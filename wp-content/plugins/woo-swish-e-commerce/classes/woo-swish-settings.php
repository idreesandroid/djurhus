<?php
/**
 * Woo_Swish_Settings class
 *
 * @class           Woo_Swish_Settings
 * @version         1.0.0
 * @package         Woocommerce_Swish/Classes
 * @category        Class
 * @author          BjornTech
 */

defined('ABSPATH') || exit;

class Woo_Swish_Settings
{

    /**
     * get_fields function.
     *
     * Returns an array of available admin settings fields
     *
     * @access public static
     * @return array
     */
    public static function get_fields($connection_type, $service_is_connected)
    {

        $connect_fields = array();
        $title = '';
        $curlversion = curl_version();
        $title = sprintf(__('Local Swish Certificate (using %s @ %s)', 'woo-swish-e-commerce'), $curlversion['ssl_version'], $_SERVER["DOCUMENT_ROOT"]);
        if (false === strpos($curlversion['ssl_version'], 'NSS')) {
            $connect_fields = array(
                'legacy_setup' => array(
                    'type' => 'title',
                    'class' => 'swishcontent _legacy',
                    'title' => $title,
                ),
                'merchant_certificate' => array(
                    'title' => __('Merchant Certificate', 'woo-swish-e-commerce') . self::get_required_symbol(),
                    'type' => 'text',
                    'desc_tip' => true,
                    'default' => $_SERVER["DOCUMENT_ROOT"],
                    'description' => __('Create a directory in a safe place on your server and place the certificate there', 'woo-swish-e-commerce'),
                ),
                'private_key_password' => array(
                    'title' => __('Private Key Password', 'woo-swish-e-commerce'),
                    'type' => 'password',
                    'description' => __('Password for the private key, leave blank if no password', 'woo-swish-e-commerce'),
                    'desc_tip' => true,
                ),
            );
        } else {
            $title = __('Your system is using NSS. The plugin can be configured to work with NSS but this requires deep NSS knowledge. If you do not have this knowledge we do recommend to use our service as Technical supplier.', 'woo-swish-e-commerce');
            $connect_fields = array(
                'legacy_setup' => array(
                    'type' => 'title',
                    'class' => 'swishcontent _legacy',
                    'title' => $title,
                ),
                'merchant_certificate' => array(
                    'title' => __('Merchant Certificate', 'woo-swish-e-commerce') . self::get_required_symbol(),
                    'type' => 'text',
                    'description' => __('Enter nickname for the Swish certificate stored in your NSS database', 'woo-swish-e-commerce'),
                ),
                'swish_nssdatabase' => array(
                    'title' => __('NSS database location', 'woo-swish-e-commerce'),
                    'type' => 'text',
                    'default' => '',
                    'description' => __('NSS database location', 'woo-swish-e-commerce'),
                    'desc_tip' => true,
                ),
            );
        }

        $prefields = array(
            'enabled' => array(
                'title' => __('Enable', 'woo-swish-e-commerce'),
                'type' => 'checkbox',
                'label' => __('Enable Swish Payment', 'woo-swish-e-commerce'),
                'default' => 'yes',
            ),
            'connect_info' => array(
                'type' => 'title',
                'title' => __('Select your preferred way to connect', 'woo-swish-e-commerce'),
                'description' => __('There are several ways to connect this plugin to Swish. Read more about the different connection options <a href="https://bjorntech.com/sv/swish-handel?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product">here</a><br>When using BjornTech as Technical provider you agree to our <a href="https://bjorntech.com/privacy-policy?utm_source=wp-swish&utm_medium=plugin&utm_campaign=product" target="_blank" rel="noopener">privacy policy</a>.', 'woo-swish-e-commerce'),
            ),
            'connection_type' => array(
                'title' => __('Connection type', 'woo-swish-e-commerce'),
                'type' => 'select',
                'default' => '',
                'options' => array(
                    '' => __('Select connection type', 'woo-swish-e-commerce'),
                    '_service' => __('BjornTech as Technical Supplier', 'woo-swish-e-commerce'),
                    '_legacy' => __('Local Swish certificate', 'woo-swish-e-commerce'),
                    '_test' => __('Swish Simulator', 'woo-swish-e-commerce'),
                ),
            ),
        );
        $service_fields = array();
        if ($service_is_connected) {
            $service_fields = array(
                'service_setup' => array(
                    'type' => 'title',
                    'class' => 'swishcontent _service',
                    'title' => __('You are using BjornTech as Technical Supplier', 'woo-swish-e-commerce'),
                ),
                'btn_disconnect' => array(
                    'title' => __('Disconnect from BjornTech as Technical Supplier', 'woo-swish-e-commerce'),
                    'text' => __('Disconnect', 'woo-swish-e-commerce'),
                    'type' => 'button',
                ),
            );
        } else {
            $service_fields = array(
                'service_setup' => array(
                    'type' => 'title',
                    'class' => 'swishcontent _service',
                ),
                'swish_user_email' => array(
                    'title' => __('Account mail address', 'woo-swish-e-commerce') . self::get_required_symbol(),
                    'type' => 'text',
                    'description' => __('The address where to send the confirmation mail address', 'woo-swish-e-commerce'),
                    'desc_tip' => true,
                    'id' => 'swish_user_email',
                ),
                'btn_connect' => array(
                    'title' => __('Connect to BjornTech as Technical Supplier', 'woo-swish-e-commerce'),
                    'text' => __('Connect', 'woo-swish-e-commerce'),
                    'type' => 'button',
                ),
            );
        }

        $postfields = array(
            'transaction_setup' => array(
                'type' => 'title',
                'class' => 'swishcontent _service _legacy',
                'title' => __('Transaction setup', 'woo-swish-e-commerce'),
            ),
            'customer_on_transaction' => array(
                'title' => __('Add Customer number on transaction', 'woo-swish-e-commerce'),
                'type' => 'checkbox',
                'label' => __('Add the customer number in the text field of the transaction', 'woo-swish-e-commerce'),
                'default' => '',
            ),
            'text_on_transaction' => array(
                'title' => __('Text on transaction', 'woo-swish-e-commerce'),
                'type' => 'textarea',
                'description' => __('Text that to be placed on the transaction (max 50 characters including customer number if selected above).', 'woo-swish-e-commerce'),
                'default' => '',
                'desc_tip' => true,
                'custom_attributes' => array(
                    'maxlength' => 50,
                ),
            ),
        );

        $defaultfields = array(
            'shop_setup' => array(
                'type' => 'title',
                'class' => 'swishcontent _service _legacy _test',
                'title' => __('Shop setup', 'woo-swish-e-commerce'),
            ),
            'title' => array(
                'title' => __('Title', 'woo-swish-e-commerce'),
                'type' => 'text',
                'description' => __('This is the title which the user sees during checkout.', 'woo-swish-e-commerce'),
                'default' => __('Swish', 'woo-swish-e-commerce'),
                'desc_tip' => true,
            ),
            'number_label' => array(
                'title' => __('Mobile number label', 'woo-swish-e-commerce'),
                'type' => 'text',
                'description' => __('This is the label for the field where the customer enters their Swish (mobile) number.', 'woo-swish-e-commerce'),
                'default' => __('Swish number', 'woo-swish-e-commerce'),
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => __('Customer Message', 'woo-swish-e-commerce'),
                'type' => 'textarea',
                'description' => __('This is the description which the user sees during checkout.', 'woo-swish-e-commerce'),
                'default' => __('Enter your Swish-number and press Process. After that you open your Swish-app and authorize the payment that we sent to your app.', 'woo-swish-e-commerce'),
                'desc_tip' => true,
            ),
            'enable_for_methods' => array(
                'title' => __('Enable for shipping methods', 'woo-swish-e-commerce'),
                'type' => 'multiselect',
                'class' => 'wc-enhanced-select',
                'css' => 'width: 400px;',
                'default' => array(),
                'description' => __('If Swish is only available for certain methods, set it up here. Leave empty to enable for all methods.', 'woo-swish-e-commerce'),
                'options' => apply_filters('swish_shipping_options', array()),
                'desc_tip' => true,
                'custom_attributes' => array(
                    'data-placeholder' => __('Select methods', 'woo-swish-e-commerce'),
                ),
            ),
            'swish_show_button' => array(
                'title' => __('Show "Start Swish app" button in these cases', 'woo-swish-e-commerce'),
                'type' => 'select',
                'default' => '',
                'description' => __('The user is presented with a button to click on in order to start the Swish-app if it is present on the device', 'woo-swish-e-commerce'),
                'options' => array(
                    '' => __('Never show', 'woo-swish-e-commerce'),
                    'mobile' => __('Show when Wordpress detects a mobile device', 'woo-swish-e-commerce'),
                    'all' => __('Always show', 'woo-swish-e-commerce'),
                ),
                'desc_tip' => true,
            ),
            'swish_checkout_type' => array(
                'title' => __('Select type of checkout', 'woo-swish-e-commerce'),
                'type' => 'select',
                'default' => '',
                'description' => __('Select the type of checkout you want the user to see. The modal checkout does not work with all themes.', 'woo-swish-e-commerce'),
                'options' => array(
                    '' => __('Standard checkout', 'woo-swish-e-commerce'),
                    'modal' => __('Modal checkout', 'woo-swish-e-commerce'),
                ),
                'desc_tip' => true,
            ),
            'swish_order_state' => array(
                'title' => __('Order status when paid', 'woo-swish-e-commerce'),
                'type' => 'select',
                'default' => '',
                'description' => __('Set the preferred order state for an order that is successfully paid.', 'woo-swish-e-commerce'),
                'options' => array(
                    '' => __('Let WooCommerce settings decide', 'woo-swish-e-commerce'),
                    'processing' => _x('Processing', 'Order status', 'woocommerce'),
                    'completed' => _x('Completed', 'Order status', 'woocommerce'),
                ),
                'desc_tip' => true,
            ),
            'debug_log' => array(
                'title' => __('Enable debug-log', 'woo-swish-e-commerce'),
                'type' => 'checkbox',
                'label' => __('Turn on logging for debug purposes.', 'woo-swish-e-commerce'),
                'default' => '',
            ),
            'swish_service_url' => array(
                'title' => __('BjornTech url', 'woo-swish-e-commerce'),
                'type' => 'text',
                'description' => __('Do not change unless instructed by BjornTech', 'woo-swish-e-commerce'),
                'desc_tip' => true,
            ),
        );

        $alias_field = array(
            'alias_setup' => array(
                'type' => 'title',
                'class' => 'swishcontent _service _legacy',
            ),
            'merchant_alias' => array(
                'title' => __('Your Swish-number', 'woo-swish-e-commerce') . self::get_required_symbol(),
                'type' => 'text',
                'description' => __('The Swish-number to receive payments. The number must be a Swish Handel account. A private Swish-number or a Swish Corporate number will not work.', 'woo-swish-e-commerce'),
                'desc_tip' => true,
                'id' => 'merchant_alias',
            ),
        );

        return array_merge($prefields, $alias_field, $connect_fields, $service_fields, $postfields, $defaultfields);
    }

    /**
     * Returns the link to the gateway settings page.
     *
     * @return mixed
     */
    public static function get_settings_page_url()
    {
        return admin_url('admin.php?page=wc-settings&tab=checkout&section=swish');
    }

    /**
     * Shows an admin notice if the setup is not complete.
     *
     * @return void
     */
    public static function show_admin_setup_notices()
    {
        $error_fields = array();

        $mandatory_fields = array(
            'merchant_certificate' => __('Merchant Certificate', 'woo-swish-e-commerce'),
            'merchant_alias' => __('Merchant Swish number', 'woo-swish-e-commerce'),
        );

        foreach ($mandatory_fields as $mandatory_field_setting => $mandatory_field_label) {
            if (self::has_empty_mandatory_post_fields($mandatory_field_setting)) {
                $error_fields[] = $mandatory_field_label;
            }
        }

        if (!empty($error_fields)) {
            $message = sprintf('<h2>%s</h2>', __("WooCommerce Swish e-commerce", 'woo-swish-e-commerce'));
            $message .= sprintf('<p>%s</p>', sprintf(__('You have missing or incorrect settings. Go to the <a href="%s">settings page</a>.', 'woo-swish-e-commerce'), self::get_settings_page_url()));
            $message .= '<ul>';
            foreach ($error_fields as $error_field) {
                $message .= "<li>" . sprintf(__('<strong>%s</strong> is mandatory.', 'woo-swish-e-commerce'), $error_field) . "</li>";
            }
            $message .= '</ul>';

            printf('<div class="%s">%s</div>', 'notice notice-error', $message);
        }
    }

    /**
     * Logic wrapper to check if some of the mandatory fields are empty on post request.
     *
     * @return bool
     */
    private static function has_empty_mandatory_post_fields($settings_field)
    {
        $post_key = 'woocommerce_swish_' . $settings_field;
        $setting_key = WC_SEC()->get_option($settings_field);
        return empty($_POST[$post_key]) && empty($setting_key);

    }

    /**
     * function get_required_symbol
     *
     * @return string
     */
    private static function get_required_symbol()
    {
        return '<span style="color: red;">*</span>';
    }
}
