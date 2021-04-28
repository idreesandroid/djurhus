<?php

/**
 * Plugin Name: Woo Swish e-commerce
 *
 * Plugin URI: https://wordpress.org/plugins/woo-swish-e-commerce/
 * Description: Integrates <a href="https://www.getswish.se/foretag/vara-erbjudanden/#foretag_two" target="_blank">Swish e-commerce</a> into your WooCommerce installation.
 * Version: 2.5.2
 * Author: BjornTech
 * Author URI: https://bjorntech.com/sv/swish-handel?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product
 *
 * Text Domain: woo-swish-e-commerce
 *
 * WC requires at least: 4.0
 * WC tested up to: 4.4
 *
 * Copyright:         2018-2020 BjornTech AB
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') || exit;

define('WCSW_VERSION', '2.5.2');
define('WCSW_URL', plugins_url(__FILE__));
define('WCSW_PATH', plugin_dir_path(__FILE__));
define('WCSW_SERVICE_URL', 'swish.finnvid.net/v1');

add_action('plugins_loaded', 'init_swish_gateway', 0);

function init_swish_gateway()
{
    if (!class_exists('WooCommerce')) {
        return;
    }

    require_once WCSW_PATH . 'classes/api/woo-swish-api.php';
    require_once WCSW_PATH . 'classes/api/woo-swish-api-service.php';
    require_once WCSW_PATH . 'classes/api/woo-swish-api-test.php';
    require_once WCSW_PATH . 'classes/api/woo-swish-api-legacy.php';
    require_once WCSW_PATH . 'classes/woo-swish-exception.php';
    require_once WCSW_PATH . 'classes/woo-swish-log.php';
    require_once WCSW_PATH . 'classes/woo-swish-helper.php';
    require_once WCSW_PATH . 'classes/woo-swish-settings.php';
    require_once WCSW_PATH . 'classes/woo-swish-order.php';
    require_once WCSW_PATH . 'classes/woo-swish-notices.php';

    class Woo_Swish_Ecommerce extends WC_Payment_Gateway
    {

        /**
         * $payer_alias.
         *
         * @var string
         * @access public
         */
        public $payer_alias;

        /**
         * $_instance.
         *
         * @var mixed
         * @access public
         * @static
         */
        public static $_instance = null;

        /**
         * @var Woo_Swish_Log
         * @access public
         */
        public $logger;

        public $service_url;

        public $merchant_alias;

        public $version;

        public $connection_type;

        /**
         * get_instance.
         *
         * Returns a new instance of self, if it does not already exist.
         *
         * @access public
         * @static
         * @return Woo_Swish_Ecommerce
         */
        public static function get_instance()
        {
            if (null === self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * __construct function.
         *
         * The class construct
         *
         * @access public
         * @return void
         */
        public function __construct()
        {
            $this->id = 'swish';
            $this->method_title = __('Swish', 'woo-swish-e-commerce');
            $this->method_description = __('Receive payments using Swish e-commerce.', 'woo-swish-e-commerce');
            $this->icon = '';
            $this->has_fields = true;
            $this->version = WCSW_VERSION;

            $this->supports = array(
                'products',
                'refunds',
            );

            // Load the form fields and settings
            $this->init_settings();
            $this->logger = new Woo_Swish_Log($this->get_option('debug_log') != 'yes');
            $this->init_form_fields();

            // Get gateway variables
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->instructions = $this->get_option('instructions');
            $this->enable_for_methods = $this->get_option('enable_for_methods', array());
            $this->merchant_alias = $this->get_option('merchant_alias');
            $this->account_uuid = $this->get_option('swish_account_uuid');
            $this->service_url = ($service_url = $this->get_option('swish_service_url')) ? $service_url : WCSW_SERVICE_URL;
            $this->connection_type = $this->get_option('connection_type');

            if (!get_site_transient('swish_activated_or_upgraded')) {

                $this->logger->add(sprintf('Swish activated or upgraded connection type = %s, merchant alias = %s', $this->connection_type, $this->merchant_alias));

                if ($this->merchant_alias && !$this->connection_type) {
                    $this->connection_type = '_legacy';
                    $this->update_option('connection_type', $this->connection_type);
                    $this->logger->add('Swish connection type changed to _legacy');
                }

                set_site_transient('swish_activated_or_upgraded', date('c'));
            }

            $this->connection_class = 'Woo_Swish_API' . $this->connection_type;

            $nss_database = $this->get_option('swish_nssdatabase');
            if ($nss_database != '') {
                putenv("SSL_DIR=" . $nss_database);
            }
        }

        /**
         * hooks_and_filters function.
         *
         * Applies plugin hooks and filters
         *
         * @access public
         * @return void
         */
        public function hooks_and_filters()
        {
            add_action('woocommerce_api_wc_' . $this->id, array($this, 'callback_handler'));
            add_action('wp_ajax_nopriv_wait_for_payment', array($this, 'ajax_wait_for_payment'));
            add_action('wp_ajax_wait_for_payment', array($this, 'ajax_wait_for_payment'));
            add_action('swish_ecommerce_after_swish_logo', array($this, 'show_goto_swish_button'));
            add_filter('woocommerce_thankyou_order_received_text', array($this, 'swish_thankyou_text'), 20, 2);
            add_filter('woocommerce_gateway_icon', array($this, 'apply_gateway_icons'), 2, 3);
            add_action('wp_enqueue_scripts', array($this, 'add_styles_and_scripts'));
            add_action('woocommerce_api_wc_admin', array($this, 'admin_callback_handler'));
            add_filter('learndash_woocommerce_manual_payment_methods', array($this, 'learndash_filter'));
            add_filter('woocommerce_payment_complete_order_status', array($this, 'payment_complete_order_status'), 20, 3);

            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'add_admin_styles_and_scripts'));
                add_action('wp_ajax_swish_clear_notice', array($this, 'ajax_clear_notice'));
                add_action('admin_notices', array($this, 'generate_messages'), 50);
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
                add_action('in_admin_header', array($this, 'swish_modal_admin'));
                add_action('wp_ajax_wait_for_admin', array($this, 'ajax_wait_for_admin'));
                add_action('wp_ajax_connect_swish_service', array($this, 'ajax_connect_swish_service'));
                add_action('wp_ajax_disconnect_swish_service', array($this, 'ajax_disconnect_swish_service'));
                add_action('wp_ajax_swish_retrieve_transaction', array($this, 'ajax_swish_retrieve_transaction'));
                add_filter('swish_shipping_options', array($this, 'swish_shipping_options'));
                add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            }

            if ($this->get_option('swish_checkout_type') == 'modal') {
                add_action('woocommerce_thankyou_swish', array($this, 'swish_modal'), 1, 100);
            } else {
                add_action('woocommerce_thankyou_swish', array($this, 'swish_thankyou'));
            }
        }

        /**
         * add_styles_and_scripts function.
         *
         * Applies styles and scripts
         *
         * @access public
         * @return void
         */
        public function add_styles_and_scripts()
        {
            wp_register_style('swish-ecommerce', plugin_dir_url(__FILE__) . 'assets/stylesheets/swish.css', array(), $this->version);
            wp_enqueue_style('swish-ecommerce');

            wp_register_script('waiting-for-swish-callback', plugin_dir_url(__FILE__) . 'assets/javascript/swish.js', array('jquery'), $this->version);
            wp_enqueue_script('waiting-for-swish-callback');
            wp_localize_script('waiting-for-swish-callback', 'swish', array(
                'logo' => plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Primary_RGB.png',
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax_swish'),
                'message' => __('Start your Swish-App and authorize the payment', 'woo-swish-e-commerce')));
        }

        /**
         * add_admin_styles_and_scripts function.
         *
         * Applies styles and scripts to admin pages
         *
         * @access public
         * @return void
         */
        public function add_admin_styles_and_scripts($hook)
        {
            wp_register_style('swish-ecommerce', plugin_dir_url(__FILE__) . 'assets/stylesheets/swish.css', array(), $this->version);
            wp_enqueue_style('swish-ecommerce');

            wp_register_script('swish-ecommerce-admin', plugin_dir_url(__FILE__) . 'assets/javascript/swish-admin.js', array('jquery'), $this->version);
            wp_enqueue_script('swish-ecommerce-admin');
            wp_localize_script('swish-ecommerce-admin', 'swish_admin', array(
                'nonce' => wp_create_nonce('ajax_swish_admin'),
                'connect' => __('I agree to the BjornTech Privacy Policy', 'woo-swish-e-commerce'),
                'disconnect' => __('You are about to disconnect BjornTech as Technical Supplier', 'woo-swish-e-commerce'),
            ));
        }

        public function payment_complete_order_status($status, $order_id, $order)
        {
            if ('swish' == $order->get_payment_method() && ($preferred_status = $this->get_option('swish_order_state'))) {
                $status = $preferred_status;
            }
            return $status;
        }

        public function ajax_connect_swish_service()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish_admin')) {
                wp_die();
            }

            $response = array();
            $merchant_alias = $this->get_option('merchant_alias');
            $swish_user_email = $this->get_option('swish_user_email');
            $site_url = get_site_url();

            if (strpos($site_url, 'https') === false) {
                $response = array(
                    'result' => 'error',
                    'message' => __('The site must be configured with https to work with Swish', 'woo-swish-e-commerce'),
                );
            } elseif ($merchant_alias == '' || $merchant_alias != $_POST['merchant_alias']) {
                $response = array(
                    'result' => 'error',
                    'message' => __('Enter your "Swish Handel" number and save the page before connecting', 'woo-swish-e-commerce'),
                );
            } elseif (strlen($merchant_alias) != 10 || strpos($merchant_alias, '123') !== 0) {
                $response = array(
                    'result' => 'error',
                    'message' => __('The "Swish Handel" number must start with 123, be 10 digits long and not contain any spaces', 'woo-swish-e-commerce'),
                );
            } elseif ($swish_user_email == '' || ($swish_user_email != $_POST['user_email'])) {
                $response = array(
                    'result' => 'error',
                    'message' => __('Enter the address to where the verification mail is sent and save the page before connecting.', 'woo-swish-e-commerce'),
                );
            } else {
                $this->update_option('connection_type', '_service');

                $auth_url = 'https://' . $this->service_url . '/connect';
                $nonce = wp_create_nonce('handle_swish_account');
                $site_params = array(
                    'email' => $swish_user_email,
                    'version' => $this->version,
                    'merchant_alias' => $merchant_alias,
                    'nonce' => $nonce,
                );
                set_site_transient('handle_swish_account', $nonce, HOUR_IN_SECONDS);
                $encoded_params = base64_encode(json_encode($site_params));

                $url = $auth_url . '?redirect_uri=' . $site_url . '&state=' . $encoded_params;
                $sw_response = wp_remote_get($url, array('timeout' => 20));

                if (is_wp_error($sw_response)) {
                    $code = $sw_response->get_error_code();
                    $error = $sw_response->get_error_message($code);
                    $response_body = json_decode(wp_remote_retrieve_body($sw_response));
                    $this->logger->add(print_r($code, true));
                    $this->logger->add(print_r($error, true));
                    $this->logger->add(print_r($response_body, true));
                    $response = array(
                        'result' => 'error',
                        'message' => __('Something went wrong when trying to connect to the BjornTech service.', 'woo-swish-e-commerce'),
                    );
                    $this->logger->add('Failed connecing to BjornTech service');
                } else {
                    $response_body = json_decode(wp_remote_retrieve_body($sw_response));
                    $response_code = wp_remote_retrieve_response_code($response);
                    if ($response_body->account_uuid) {
                        $this->account_uuid = $response_body->account_uuid;
                        $this->update_option('swish_account_uuid', $this->account_uuid);
                        $this->logger->add(sprintf('BjornTech account uuid %s was created', $this->account_uuid));
                        $response = array(
                            'result' => 'success',
                        );
                    } else {
                        $response = array(
                            'result' => 'error',
                            'message' => __('Something went wrong when trying to connect to the BjornTech service.', 'woo-swish-e-commerce'),
                        );
                        $this->logger->add(sprintf('Failed to create BjornTech account, error %s', $response_body->response));
                    }
                }
            }
            wp_send_json($response);
            wp_die();
        }

        public function ajax_disconnect_swish_service()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish_admin')) {
                wp_die();
            }
            $auth_url = 'https://' . $this->service_url . '/disconnect';
            $site_params = array(
                'email' => $this->get_option('swish_user_email'),
                'version' => $this->version,
                'merchant_alias' => $this->get_option('merchant_alias'),
                'nonce' => wp_create_nonce('handle_swish_account'),
                'uuid' => $this->account_uuid,
            );
            $encoded_params = base64_encode(json_encode($site_params));
            $site_url = get_site_url();

            $url = $auth_url . '?redirect_uri=' . $site_url . '&state=' . $encoded_params;
            $sw_response = wp_remote_get($url, array('timeout' => 20));

            if (is_wp_error($sw_response)) {
                $this->logger->add(__('Something went wrong when trying to disconnect from the certificate service', 'woo-swish-e-commerce'));
            } else {
                $this->account_uuid = false;
                $this->update_option('swish_account_uuid', '');
                $this->update_option('swish_refresh_token', '');
                $this->update_option('swish_access_token', '');
                $this->update_option('swish_token_expiry', 0);
                $this->logger->add(__('Succcessfully disconnected from the certificate service', 'woo-swish-e-commerce'));
            }

            $response = array(
                'response' => 'success',
            );

            wp_send_json($response);
            wp_die();
        }

        function swish_thankyou_text($text, $order)
        {
            if (is_object($order) && $order->get_payment_method() == 'swish') {
                $text = __('Start your Swish-App and authorize the payment', 'woo-swish-e-commerce');
            }
            return $text;
        }

        public function learndash_filter($filter)
        {
            if (!in_array('swish', $filter)) {
                array_push($filter, 'swish');
            }
            return $filter;
        }

        /**
         * ajax_wait_for_payment.
         *
         * Called from the javascript on the thankyou page
         *
         * @access public
         * @return void
         */
        public function ajax_wait_for_payment()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish')) {
                wp_die();
            }

            $this->logger->add(sprintf('Waiting for payment sent url %s', $_POST['url']));

            preg_match('/\=(wc_order_[^&]*)/', $_POST['url'], $key);

            if (($order_id = wc_get_order_id_by_order_key($key[1])) && ($order = new Woo_Swish_Order($order_id))) {

                $status = $order->get_transaction_status();

                $this->logger->add(sprintf('Waiting for payment on order %s (%s) returned status %s', $order->get_id(), $key[1], $status));

                $response = array(
                    'status' => $status,
                    'message' => Woo_Swish_Helper::error_code($status),
                );

            } else {

                $response = array(
                    'status' => 'ERROR',
                    'message' => __('Error processing the payment. Contact the shop support', 'woo-swish-e-commerce'),
                );

            }

            wp_send_json($response);

            wp_die();
        }

        public function generate_messages()
        {

            if (('_legacy' == $this->connection_type) && ($swish_cert = WC_SEC()->get_option('merchant_certificate')) && ($cert_info = $this->certificate_info($swish_cert))) {

                $this->logger->add(sprintf('Found certificate for %s issued by %s(%s) at %s valid to %s', $cert_info->merchant_number, $cert_info->issuer, $cert_info->common_name, date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $cert_info->valid_from), date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $cert_info->valid_to)));

                $now = time();

                if ($cert_info->valid_to < $now) {
                    $message = sprintf(__('Your certificate %s expired %s. Take the opportunity to start using us as your Technical supplier. Read more <a href="https://bjorntech.com/sv/swish-teknisk-leverantor?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product">here</a>', 'woo-swish-e-commerce'), $cert_info->merchant_number, date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $cert_info->valid_to));
                    $id = sw_notice::add($message, 'error', false, 'cert_expiry_error');
                } elseif ($cert_info->valid_to < $now + WEEK_IN_SECONDS) {
                    $message = sprintf(__('Your certificate %s expires %s. Take the opportunity to start using us as your Technical supplier. Read more <a href="https://bjorntech.com/sv/swish-teknisk-leverantor?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product">here</a>', 'woo-swish-e-commerce'), $cert_info->merchant_number, date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $cert_info->valid_to));
                    $id = sw_notice::add($message, 'warning', false, 'cert_expiry_warning');
                }

            }

            if (get_site_transient('swish_activated')) {
                delete_site_transient('swish_activated');

                try {
                    sw_notice::clear();
                    delete_site_transient('swish_did_show_connection_info');
                    delete_site_transient('swish_did_show_legacy_info');
                    do_action('swish_force_connection');
                } catch (Woo_Swish_API_Exception $e) {
                    $e->write_to_logs();
                }
            }

            if (get_site_transient('swish_upgraded')) {
                delete_site_transient('swish_upgraded');
                try {
                    sw_notice::clear();
                    do_action('swish_force_connection');
                    delete_site_transient('swish_did_show_connection_info');
                    delete_site_transient('swish_did_show_legacy_info');
                } catch (Woo_Swish_API_Exception $e) {
                    $e->write_to_logs();
                }
            }

            if (!$this->connection_type && !get_site_transient('swish_did_show_connection_info')) {
                $message = sprintf(__('Congratulations! If you have SEB, Swedbank, Handelsbanken, Danske Bank or Nordea as your bank you can now be live with Swish payments within minutes. Go to the <a href="%s">configuration page</a> and select BjornTech as Technical Supplier as your connection type.', 'woo-swish-e-commerce'), get_admin_url(null, 'admin.php?page=wc-settings&tab=checkout&section=swish'));
                $id = sw_notice::add($message, 'info');
                set_site_transient('swish_did_show_connection_info', $id);
            } elseif ($this->connection_type == '_legacy' && !get_site_transient('swish_did_show_legacy_info')) {
                $message = __('Congratulations! Your Swish-plugin is now upgraded. You can continue using it as normal. In this version you can use BjornTech as Technical Supplier, read more <a href="https://bjorntech.com/sv/swish-teknisk-leverantor?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product">here</a>', 'woo-swish-e-commerce');
                $id = sw_notice::add($message, 'info');
                set_site_transient('swish_did_show_legacy_info', $id);
            }

        }

        public function ajax_clear_notice()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish_admin')) {
                wp_die();
            }

            if (isset($_POST['parents'])) {
                $id = substr($_POST['parents'], strpos($_POST['parents'], 'id-'));
                sw_notice::clear($id);
            }
            $response = array(
                'status' => 'success',
            );

            wp_send_json($response);
            exit;
        }

        /**
         * ajax_wait_for_admin.
         *
         * Called from the javascript on the init service page
         *
         * @access public
         * @return void
         */
        public function ajax_wait_for_admin()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish_admin')) {
                wp_die();
            }

            $message = '';
            if (get_site_transient('handle_swish_account')) {
                if ($connected = get_site_transient('swish_connect_result')) {
                    delete_site_transient('handle_swish_account');
                    delete_site_transient('swish_connect_result');
                    if ($connected == 'failure') {
                        $message = __('The activation of the account failed', 'woo-swish-e-commerce');
                    }
                } else {
                    $message = __('We have sent a mail with the activation link. Click on the link to activate the service.', 'woo-swish-e-commerce');
                }
            } else {
                $connected = 'failure';
                $message = __('The link has now expired, please connect again to get a new link.', 'woo-swish-e-commerce');
            }

            $response = array(
                'status' => $connected ? $connected : 'waiting',
                'message' => $message,
            );

            wp_send_json($response);
            wp_die();
        }

        /**
         * show_goto_swish_button.
         *
         * Called from the action 'swish_ecommerce_after_swish_logo'
         *
         * @access public
         * @param $order_id
         * @return void
         */
        public function show_goto_swish_button($order_id)
        {
            $button_mode = $this->get_option('swish_show_button');
            if ('all' == $button_mode || ('mobile' == $button_mode) && wp_is_mobile()) {?>
                <div class="swish-button swish-centered">
                    <a class="button gotoswish" onclick="window.location.href='swish://';"  href="swish://"><?php echo __('Start Swish app', 'woo-swish-e-commerce'); ?></a>
                </div>
            <?php }
        }

        /**
         * swish_modal.
         *
         * creates the modal page that shows the wait for payment
         *
         * @access public
         * @return void
         */

        public function swish_modal()
        {
            $this->logger->add('Using modal checkout page');?>
            <div id="swish-modal-id" class="swish-modal">
                <div class="swish-modal-content">
                    <div class="swish-messages swish-centered">
                        <h1><p id="swish-status"></p></h1>
                    </div>
                    <div class="swish-circle swish-centered">
                        <img class="swish-loader swish-centered" src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Circle.png'; ?>" />
                    </div>
                    <div class="swish-logo swish-centered">
                        <img id="swish-logo-id" class="swish-centered" src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Text.png'; ?>" />
                    </div>
                    <?php do_action('swish_ecommerce_after_swish_logo');?>
                </div>
                <script>waitForPaymentModal();</script>
            </div>
        <?php }

        public function swish_modal_admin()
        {?>
            <div id="swish-modal-id" class="swish-modal" style="display: none">
                <div class="swish-modal-content swish-centered">
                    <span class="swish-close">&times;</span>
                    <div class="swish-messages swish-centered">
                        <h1><p id="swish-status"></p></h1>
                    </div>
                    <div class="bjorntech-logo swish-centered">
                        <img id="swish-logo-id" class="swish-centered" src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/BjornTech_logo_small.png'; ?>" />
                    </div>
                </div>
            </div>
        <?php }

        /**
         * swish_thankyou.
         *
         * Replaces the ordinary thank-you-page
         * removes the order details and shows the Swish logo instead
         * Includes the javascript checking for payment
         *
         * @access public
         * @return void
         */
        public function swish_thankyou($order_id)
        {
            $this->logger->add('Using standard checkout page');
            remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
            ?>
                <body>
                    <div class="swish-messages swish-centered">
                        <h1><p id="swish-status"></p></h1>
                    </div>
                    <div class="swish-circle swish-centered">
                        <img class="swish-loader swish-centered" src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Circle.png'; ?>" />
                    </div>
                    <div class="swish-logo swish-centered">
                        <img id="swish-logo-id" class="swish-centered" src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Text.png'; ?>" />
                    </div>
                    <?php do_action('swish_ecommerce_after_swish_logo', $order_id);?>
                    <script>document.addEventListener('DOMContentLoaded', waitForPayment);</script>
                </body>
            <?php }
        /**
         * validate_fields.
         *
         * Validates the swish-number-field
         *
         * @access public
         * @return bool
         */
        public function validate_fields()
        {
            $payer_alias_raw = isset($_POST[esc_attr($this->id) . '-payer-alias']) ? $_POST[esc_attr($this->id) . '-payer-alias'] : '';
            $payer_alias = preg_replace('/[^0-9]/', '', $payer_alias_raw);
            $number_lenght = strlen($payer_alias);
            if ($number_lenght == 0) {
                wc_add_notice(__('Swish number missing', 'woo-swish-e-commerce'), 'error');
                return false;
            }
            if ($payer_alias[0] == '0') {
                $payer_alias = '46' . substr($payer_alias, 1);
                $number_lenght = strlen($payer_alias);
            }
            if ($number_lenght < 8) {
                wc_add_notice(__('Swish number must be at least 8 characters long', 'woo-swish-e-commerce'), 'error');
                return false;
            }
            if ($number_lenght > 15) {
                wc_add_notice(__('Swish number can be maximum 15 characters long', 'woo-swish-e-commerce'), 'error');
                return false;
            }
            $this->payer_alias = $payer_alias;
            return true;
        }

        /**
         * payment_fields.
         *
         * @access public
         * @return void
         */
        public function payment_fields()
        {
            if ($this->get_option('connection_type', '_legacy') == '_test') {
                echo wpautop(wptexturize(__("You are running Swish e-commerce in test mode, use 4671234768 to test a payment", 'woo-swish-e-commerce')));
            } else {
                if (!empty($this->description)) {
                    echo wpautop(wptexturize($this->description));
                }
            }
            $this->form();
        }

        /**
         * Outputs fields for entering Swish information.
         * @since 1.0.0
         */
        public function form()
        {
            $fields = array();
            $number_text = $this->get_option('number_label', __('Swish number', 'woo-swish-e-commerce'));
            $default_fields = array(
                'swish-payer-alias' => '<p class="form-row form-row-wide">
                <label for="' . esc_attr($this->id) . '-payer-alias">' . esc_html($number_text) . '<span class="required">*</span></label>
                <input id="' . esc_attr($this->id) . '-payer-alias" class="input-text wc-swish-form-payer-alias" type="text" autocomplete="off" name="' . esc_attr($this->id) . '-payer-alias" maxlength="17" />
            </p>',
            );

            $fields = wp_parse_args($fields, apply_filters('woocommerce_swish_form_fields', $default_fields, $this->id));
            ?>

            <fieldset id="<?php echo esc_attr($this->id); ?>-cc-form" class='wc-swish-form wc-payment-form'>
                <?php do_action('woocommerce_swish_form_start', $this->id);?>
                <?php foreach ($fields as $field) {
                echo $field;
            }
            ?>
                <?php do_action('woocommerce_swish_form_end', $this->id);?>
                <div class="clear"></div>
            </fieldset>
        <?php }

        /**
         * add_action_links function.
         *
         * Adds action links inside the plugin overview
         *
         * @access public static
         * @return array
         */
        public static function add_action_links($links) // legit

        {
            $links = array_merge(array(
                '<a href="' . Woo_Swish_Settings::get_settings_page_url() . '">' . __('Settings', 'woo-swish-e-commerce') . '</a>',
            ), $links);

            return $links;
        }

        /**
         * process_payment.
         *
         * Processing payments on checkout
         * @param $order_id
         * @return array
         */
        public function process_payment($order_id)
        {

            try {

                $this->logger->add(sprintf('Processing payment for order %s using connection type %s', $order_id, $this->connection_class));
                $order = new Woo_Swish_Order($order_id);
                $payment = new stdClass();
                $swish = new $this->connection_class();
                $payment = $swish->create($order, $this->payer_alias);
                $order->set_transaction_location($payment->location ? $payment->location : '');
                $order->set_transaction_status('WAITING');
                $order->note(__('Payment initiated', 'woo-swish-e-commerce'));
                $order->update_status('pending');
                $redirect_url = $this->get_return_url($order);
                $this->logger->add(sprintf('Payment initiated successfully, redirecting to %s', $redirect_url));
                return array(
                    'result' => 'success',
                    'redirect' => $redirect_url,
                );

            } catch (Woo_Swish_API_Exception $e) {
                $e->write_to_logs();
                wc_add_notice($e->getMessage(), 'error');
            }

            return false;

        }

        /**
         * Process refunds
         *
         * @param  int $order_id
         * @param  float $amount
         * @param  string $reason
         * @return bool|WP_Error
         */
        public function process_refund($order_id, $amount = null, $reason = '')
        {
            try {
                $order = new Woo_Swish_Order($order_id);

                $transaction_id = $order->get_transaction_id('edit');

                if (!$transaction_id) {
                    throw new Woo_Swish_Exception(sprintf(__("No transaction ID for order: %s", 'woo-swish-e-commerce'), $order_id));
                }

                $payment = new stdClass();
                $swish = new $this->connection_class();
                $payment = $swish->refund($transaction_id, $order, $amount, $reason);

                return true;
            } catch (Woo_Swish_Exception $e) {
                $e->write_to_logs();
                wc_add_notice($e->getMessage(), 'error');
            } catch (Woo_Swish_API_Exception $e) {
                $e->write_to_logs();
                wc_add_notice($e->getMessage(), 'error');
            }

            return false;
        }

        /**
         * admin_callback_handler function.
         *
         * Is called by the Swish-service.
         *
         * @access public
         * @return void
         */

        public function admin_callback_handler()
        {
            $nonce = get_site_transient('handle_swish_account');
            if (array_key_exists('nonce', $_REQUEST) && ($_REQUEST['nonce'] == $nonce)) {
                if (array_key_exists('account_uuid', $_REQUEST) && $_REQUEST['account_uuid'] == $this->account_uuid) {
                    $request_body = file_get_contents("php://input");
                    $json = json_decode($request_body);
                    if ($json !== null && json_last_error() === JSON_ERROR_NONE) {
                        $this->refresh_token = $json->refresh_token;
                        $this->update_option('swish_refresh_token', $this->refresh_token);
                        $this->logger->add(sprintf('Account uuid %s was authorized and got refresh token %s from service', $this->account_uuid, $this->refresh_token));
                        set_site_transient('swish_connect_result', 'success', MINUTE_IN_SECONDS);
                        wp_die('', '', 200);
                    } else {
                        $this->logger->add(sprintf('Failed decoding authorize json %s', print_r($request_body, true)));
                    }
                } else {
                    $this->logger->add(sprintf('Faulty call to admin callback %s', $this->account_uuid));
                }
            } else {
                $this->logger->add('Nonce not verified at admin_callback_handler');
                $this->logger->add(print_r($_REQUEST, true));
                $this->logger->add(print_r($nonce, true));
            }
            set_site_transient('swish_connect_result', 'failure', MINUTE_IN_SECONDS);
            wp_die();
        }

        public function certificate_info($swish_cert)
        {
            try {

                if (file_exists($swish_cert)) {
                    $cert = file_get_contents($swish_cert);
                    if ($cert_info = openssl_x509_parse($cert)) {
                        return (object) array(
                            'issuer' => $cert_info['issuer']['O'],
                            'common_name' => $cert_info['issuer']['CN'],
                            'valid_from' => $cert_info['validFrom_time_t'],
                            'valid_to' => $cert_info['validTo_time_t'],
                            'merchant_number' => $cert_info['subject']['CN'],
                        );
                    }
                }

            } catch (Throwable $t) {
                if (method_exists($t, 'write_to_logs')) {
                    $t->write_to_logs();
                } else {
                    WC_FH()->logger->add(print_r($t, true));
                }

            }
            return false;
        }

        public function process_order($order, $request_body, $testmode)
        {
            $json = json_decode($request_body);

            switch ($json->status) {
                case 'DECLINED':
                    $this->logger->add('Got DECLINED from Swish');
                    $order->set_transaction_status($json->status);
                    $order->note(sprintf(__('%s declined by user', 'woo-swish-e-commerce'), $testmode ? __('Test-payment', 'woo-swish-e-commerce') : __('Payment', 'woo-swish-e-commerce')));
                    $order->update_status('pending');
                    break;
                case 'ERROR':
                    $this->logger->add(sprintf('Got ERROR %s from Swish', $json->errorCode));
                    $order->set_transaction_status($json->errorCode);
                    $order->note($json->errorCode . ' - ' . Woo_Swish_Helper::error_code($json->errorCode), $json->id);
                    $order->update_status('pending');
                    break;
                case 'DEBITED':
                    $this->logger->add('Got DEBITED from Swish');
                    $order->note(sprintf(__('Merchant account debited - %s ID: %s', 'woo-swish-e-commerce'), $testmode ? 'Test-transaction' : 'Transaction', $json->id));
                    $order->set_transaction_status($json->status);
                    break;
                case 'PAID':
                    if ('DEBITED' == $order->get_transaction_status()) {
                        $this->logger->add('Customer got PAID from Swish');
                        $order->note(sprintf(__('Refund confirmed - %s ID: %s', 'woo-swish-e-commerce'), $testmode ? 'Test-transaction' : 'Transaction', $json->id));
                        $order->set_refund_id($json->paymentReference);
                    } elseif (!$order->get_transaction_id('edit')) {
                        $this->logger->add('Merchant got PAID from Swish');
                        $order->note(sprintf(__('Payment confirmed - %s ID: %s', 'woo-swish-e-commerce'), $testmode ? 'Test-transaction' : 'Transaction', $json->id));
                        $order->set_transaction_status($json->status);
                        $order->reduce_order_stock();
                        $order->set_transaction_id($json->paymentReference);
                        $order->payment_complete();
                    }
                    break;
            }
            $order->save();
        }
        /**
         * callback_handler function.
         *
         * Is called after a payment has been submitted in the Swish payment window.
         *
         * @access public
         * @return void
         */

        public function callback_handler()
        {
            global $woocommerce;

            try {

                $nonce = isset($_REQUEST['nonce']) ? trim($_REQUEST['nonce']) : '';
                $order_id = isset($_REQUEST['order_id']) ? trim($_REQUEST['order_id']) : '';
                $order = new Woo_Swish_Order($order_id);

                if ($this->get_option('connection_type') == '_test') {
                    $merchant_alias = '1234679304';
                    $testmode = true;
                } else {
                    $merchant_alias = $this->get_option('merchant_alias');
                    $testmode = false;
                }

                if (!Woo_Swish_Helper::verify_nonce($nonce, 'swish_' . $order_id, $order->get_secret(), $merchant_alias)) {
                    $this->logger->add(sprintf('Nonce verification failed for order %s', $order_id));
                    wp_die();
                };

                $request_body = file_get_contents("php://input");
                if (empty($request_body)) {
                    $this->logger->add(sprintf('Request body missing for order %s', $order_id));
                    wp_die();
                }

                $this->process_order($order, $request_body, $testmode);

            } catch (Throwable $t) {
                if (method_exists($t, 'write_to_logs')) {
                    $t->write_to_logs();
                } else {
                    WC_FH()->logger->add(print_r($t, true));
                }
            }
            wp_die('', 200);
        }

        public function generate_button_html($key, $data)
        {
            $field_key = $this->get_field_key($key);
            $defaults = array(
                'title' => '',
                'name' => '',
                'text' => '',
                'disabled' => false,
                'class' => '',
                'css' => '',
                'type' => 'button',
                'desc_tip' => false,
                'description' => '',
                'custom_attributes' => array(),
            );

            $data = wp_parse_args($data, $defaults);

            ob_start();
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr($field_key); ?>"><?php echo wp_kses_post($data['title']); ?> <?php echo $this->get_tooltip_html($data); ?></label>
                </th>
                <td class="forminp">
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php echo wp_kses_post($data['title']); ?></span></legend>
                        <button class="button <?php echo esc_attr($data['class']); ?>" type="<?php echo esc_attr($data['type']); ?>" name="<?php echo esc_attr($field_key); ?>" id="<?php echo esc_attr($field_key); ?>" style="<?php echo esc_attr($data['css']); ?>" <?php disabled($data['disabled'], true);?> <?php echo $this->get_custom_attribute_html($data); ?> ><?php echo $data['text'] ?></button>
                        <?php echo $this->get_description_html($data); ?>
                    </fieldset>
                </td>
            </tr>
            <?php

            return ob_get_clean();
        }

        /**
         * add_meta_boxes function.
         *
         * Adds the action meta box inside the single order view.
         *
         * @access public
         * @return void
         */
        public function add_meta_boxes()
        {
            global $post;

            $screen = get_current_screen();
            $post_types = ['shop_order'];

            if (in_array($screen->id, $post_types, true) && in_array($post->post_type, $post_types, true)) {
                $order = new Woo_Swish_Order($post->ID);
                if ($order->is_missing_payment_details()) {
                    add_meta_box('swish-payment-actions', __('Swish Payment', 'woo-swish-e-commerce'), [
                         & $this,
                        'meta_box_payment',
                    ], 'shop_order', 'side', 'high');
                }
            }
        }

        /**
         * meta_box_payment function.
         *
         * Inserts the content of the API actions meta box - Payments
         *
         * @access public
         * @return void
         */
        public function meta_box_payment()
        {

            global $post;
            echo '<a class="button swish_retrieve_button" id="swish_retrieve_button" name="' . $post->ID . '">' . __('Retrieve payment', 'woo-swish-e-commerce') . '</a>';

        }

        /**
         * ajax_swish_retrieve_transaction.
         *
         * Called from the javascript on the init service page
         *
         * @access public
         * @return void
         */
        public function ajax_swish_retrieve_transaction()
        {
            if (!wp_verify_nonce($_POST['nonce'], 'ajax_swish_admin')) {
                wp_die();
            }

            $order = new Woo_Swish_Order($_POST['name']);

            $transaction_location = $order->get_transaction_location();
            $this->logger->add(sprintf('Transaction location is: %s', $transaction_location));

            try {

                $swish = new $this->connection_class();
                $payment_body = $swish->retreive($transaction_location);

                $this->logger->add(print_r($payment_body, true));

                $this->process_order($order, $payment_body, $this->get_option('connection_type') == '_test');

            } catch (Woo_Swish_API_Exception $e) {
                $e->write_to_logs();
            }

            $response = array(
                'status' => $connected ? $connected : 'waiting',
                'message' => $message,
            );

            wp_send_json($response);
            wp_die();
        }

        public function swish_shipping_options($options)
        {
            $options = array();
            $data_store = WC_Data_Store::load('shipping-zone');
            $raw_zones = $data_store->get_zones();

            foreach ($raw_zones as $raw_zone) {
                $zones[] = new WC_Shipping_Zone($raw_zone);
            }

            $zones[] = new WC_Shipping_Zone(0);

            foreach (WC()->shipping()->load_shipping_methods() as $method) {

                $options[$method->get_method_title()] = array();

                // Translators: %1$s shipping method name.
                $options[$method->get_method_title()][$method->id] = sprintf(__('Any &quot;%1$s&quot; method', 'woo-swish-e-commerce'), $method->get_method_title());

                foreach ($zones as $zone) {

                    $shipping_method_instances = $zone->get_shipping_methods();

                    foreach ($shipping_method_instances as $shipping_method_instance_id => $shipping_method_instance) {

                        if ($shipping_method_instance->id !== $method->id) {
                            continue;
                        }

                        $option_id = $shipping_method_instance->get_rate_id();

                        // Translators: %1$s shipping method title, %2$s shipping method id.
                        $option_instance_title = sprintf(__('%1$s (#%2$s)', 'woo-swish-e-commerce'), $shipping_method_instance->get_title(), $shipping_method_instance_id);

                        // Translators: %1$s zone name, %2$s shipping method instance name.
                        $option_title = sprintf(__('%1$s &ndash; %2$s', 'woo-swish-e-commerce'), $zone->get_id() ? $zone->get_zone_name() : __('Other locations', 'woo-swish-e-commerce'), $option_instance_title);

                        $options[$method->get_method_title()][$option_id] = $option_title;
                    }
                }
            }
            return $options;
        }
        /**
         * init_form_fields function.
         *
         * Initiates the plugin settings form fields
         *
         * @access public
         * @return array
         */
        public function init_form_fields()
        {
            $this->form_fields = Woo_Swish_Settings::get_fields($this->get_option('connection_type'), $this->get_option('swish_refresh_token') != '');
        }

        /**
         * Check If The Gateway Is Available For Use.
         *
         * @return bool
         */
        public function is_available()
        {
            $order = null;
            $needs_shipping = false;

            // Test if shipping is needed first.
            if (WC()->cart && WC()->cart->needs_shipping()) {
                $needs_shipping = true;
            } elseif (is_page(wc_get_page_id('checkout')) && 0 < get_query_var('order-pay')) {
                $order_id = absint(get_query_var('order-pay'));
                $order = wc_get_order($order_id);

                // Test if order needs shipping.
                if (0 < count($order->get_items())) {
                    foreach ($order->get_items() as $item) {
                        $_product = $item->get_product();
                        if ($_product && $_product->needs_shipping()) {
                            $needs_shipping = true;
                            break;
                        }
                    }
                }
            } elseif (WC()->cart && WC()->cart->needs_shipping()) {
                $needs_shipping = true;
            }

            $needs_shipping = apply_filters('woocommerce_cart_needs_shipping', $needs_shipping);

            // Only apply if all packages are being shipped via chosen method, or order is virtual.
            if (!empty($this->enable_for_methods) && $needs_shipping) {
                $canonical_rate_ids = array();
                $order_shipping_items = is_object($order) ? $order->get_shipping_methods() : false;
                $chosen_shipping_methods_session = WC()->session->get('chosen_shipping_methods');

                if ($order_shipping_items) {
                    $canonical_rate_ids = $this->get_canonical_order_shipping_item_rate_ids($order_shipping_items);
                } else {
                    $canonical_rate_ids = $this->get_canonical_package_rate_ids($chosen_shipping_methods_session);
                }

                if (!count($this->get_matching_rates($canonical_rate_ids))) {
                    return false;
                }
            }

            return parent::is_available();
        }

        /**
         * Converts the chosen rate IDs generated by Shipping Methods to a canonical 'method_id:instance_id' format.
         *
         * @since  3.4.0
         *
         * @param  array $order_shipping_items  Array of WC_Order_Item_Shipping objects.
         * @return array $canonical_rate_ids    Rate IDs in a canonical format.
         */
        private function get_canonical_order_shipping_item_rate_ids($order_shipping_items)
        {

            $canonical_rate_ids = array();

            foreach ($order_shipping_items as $order_shipping_item) {
                $canonical_rate_ids[] = $order_shipping_item->get_method_id() . ':' . $order_shipping_item->get_instance_id();
            }

            return $canonical_rate_ids;
        }

        /**
         * Converts the chosen rate IDs generated by Shipping Methods to a canonical 'method_id:instance_id' format.
         *
         * @since  3.4.0
         *
         * @param  array $chosen_package_rate_ids Rate IDs as generated by shipping methods. Can be anything if a shipping method doesn't honor WC conventions.
         * @return array $canonical_rate_ids  Rate IDs in a canonical format.
         */
        private function get_canonical_package_rate_ids($chosen_package_rate_ids)
        {

            $shipping_packages = WC()->shipping->get_packages();
            $canonical_rate_ids = array();

            if (!empty($chosen_package_rate_ids) && is_array($chosen_package_rate_ids)) {
                foreach ($chosen_package_rate_ids as $package_key => $chosen_package_rate_id) {
                    if (!empty($shipping_packages[$package_key]['rates'][$chosen_package_rate_id])) {
                        $chosen_rate = $shipping_packages[$package_key]['rates'][$chosen_package_rate_id];
                        $canonical_rate_ids[] = $chosen_rate->get_method_id() . ':' . $chosen_rate->get_instance_id();
                    }
                }
            }

            return $canonical_rate_ids;
        }

        /**
         * Indicates whether a rate exists in an array of canonically-formatted rate IDs that activates this gateway.
         *
         * @since  3.4.0
         *
         * @param array $rate_ids Rate ids to check.
         * @return boolean
         */
        private function get_matching_rates($rate_ids)
        {
            // First, match entries in 'method_id:instance_id' format. Then, match entries in 'method_id' format by stripping off the instance ID from the candidates.
            return array_unique(array_merge(array_intersect($this->enable_for_methods, $rate_ids), array_intersect($this->enable_for_methods, array_unique(array_map('wc_get_string_before_colon', $rate_ids)))));
        }

        /**
         * admin_options function.
         *
         * Prints the admin settings form
         *
         * @access public
         * @return string
         */
        public function admin_options()
        {

            echo "<h3>Swish v" . WCSW_VERSION . "</h3>";
            echo "<p>" . __('Receive payments using Swish e-commerce.', 'woo-swish-e-commerce') . "</p>";

            do_action('woocommerce_swish_settings_table_before');

            $this->service_status();

            echo "<table class=\"form-table\">";
            $this->generate_settings_html();
            echo "</table";

            do_action('woocommerce_swish_settings_table_after');
        }

        public function service_status()
        {
            if ($this->get_option('swish_refresh_token') != '') {
                echo '<div class="swishcontent _service notice notice-success notice-alt notice-large">' . sprintf(__('Your Swish-account %s is using <strong>BjornTech as Technical Supplier.</strong>', 'woo-swish-e-commerce'), $this->merchant_alias) . '</div>';
            } else {
                echo '<div class="notice notice-warning notice-alt"><p>' . esc_html__('If you have your Swish Handel account at SEB, Swedbank, Handelsbanken, Danske Bank or Nordea you can use BjornTech as Technical Supplier. Select it as "Connection type" below. Enter your Swish-account, your mail and click "Connect". No complicated certificate creation needed, just follow the instructions in the confirmation mail', 'woo-swish-e-commerce') . '</p></div>';
            }
        }

        /**
         * Generate Title HTML.
         *
         * @param string $key Field key.
         * @param array  $data Field data.
         * @since  1.0.0
         * @return string
         */
        public function generate_title_html($key, $data)
        {
            $field_key = $this->get_field_key($key);
            $defaults = array(
                'title' => '',
                'class' => '',
            );

            $data = wp_parse_args($data, $defaults);

            ob_start();
            ?></table>
			    <h3 class="wc-settings-sub-title <?php echo esc_attr($data['class']); ?>" id="<?php echo esc_attr($field_key); ?>"><?php echo wp_kses_post($data['title']); ?></h3>
			    <?php if (!empty($data['description'])): ?>
				    <p><?php echo wp_kses_post($data['description']); ?></p>
			    <?php endif;?>
			<table class="form-table <?php echo esc_attr($data['class']); ?>"><?php

            return ob_get_clean();
        }

        /**
         * FILTER: apply_gateway_icons function.
         *
         * Sets gateway icons on frontend
         *
         * @access public
         * @return void
         */
        public function apply_gateway_icons($icon, $id)
        {
            if ($id == $this->id) {
                $icon_url = WC_HTTPS::force_https_url(plugin_dir_url(__FILE__) . 'assets/images/Swish_Logo_Secondary_RGB.png');
                $icon = '<img src="' . $icon_url . '" alt="' . esc_attr($this->get_title()) . '" style="max-height:' . '30px' . '"/>';
            }
            return $icon;
        }

    }

    /**
     * Make the object available for later use
     *
     * @return Woo_Swish_Ecommerce
     */
    function WC_SEC()
    {
        return Woo_Swish_Ecommerce::get_instance();
    }

    // Instantiate
    WC_SEC();
    WC_SEC()->hooks_and_filters();

    // Add the gateway to WooCommerce
    function add_swish_gateway($methods)
    {
        $methods[] = 'Woo_Swish_Ecommerce';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'add_swish_gateway');

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'Woo_Swish_Ecommerce::add_action_links');

}

/**
 * Activation activities to be performed then the plugin is activated
 */
function woocommerce_swish_integration_activate()
{

    /**
     * Log the activation time in a transient
     */
    set_site_transient('swish_activation_time', date('c'));

    /**
     * Set transient to always force the plugin to ask for credentials when activated
     */
    set_site_transient('swish_activated', 1);
    delete_site_transient('swish_activated_or_upgraded');

}

register_activation_hook(__FILE__, 'woocommerce_swish_integration_activate');

/**
 * Upgrade activities to be performed when the plugin is upgraded
 */
function swish_upgrade_completed($upgrader_object, $options)
{
    $our_plugin = plugin_basename(__FILE__);

    if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {
        foreach ($options['plugins'] as $plugin) {
            if ($plugin == $our_plugin) {

                /**
                 * Log the activation time in a transient
                 */
                set_site_transient('swish_upgraded_time', date('c'));

                /**
                 * Set transient to always force the plugin to ask for credentials when activated
                 */
                set_site_transient('swish_upgraded', 1);

                /**
                 * Delete transient containing the date for activation or upgrade
                 */
                delete_site_transient('swish_activated_or_upgraded');
            }
        }
    }
}
add_action('upgrader_process_complete', 'swish_upgrade_completed', 10, 2);
