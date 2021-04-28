<?php

/**
 * Woo_Swish_Helper class
 *
 * @class          Woo_Swish_Helper
 * @version        1.0.0
 * @package        Woocommerce_Swish/Classes
 * @category       Class
 * @author         BjornTech
 */

defined('ABSPATH') || exit;

class Woo_Swish_Helper
{

    /**
     * error_code function.
     *
     * @access public static
     * @param string $code
     * @return string $text
     */
    public static function error_code($code)
    {
        $codes = array(
            'PA01' => __('You have to use a "Swish Handel" account and select BjornTech as Technical Supplier in your Bank for the service to work', 'woo-swish-e-commerce'),
            'FF08' => __("PayeePaymentReference is invalid", 'woo-swish-e-commerce'),
            'RP03' => __("Callback URL is missing or does not use Https", 'woo-swish-e-commerce'),
            'BE18' => __("Payer alias is invalid", 'woo-swish-e-commerce'),
            'RP01' => __("Payee alias is missing or empty", 'woo-swish-e-commerce'),
            'PA02' => __("Amount value is missing or not a valid number", 'woo-swish-e-commerce'),
            'AM06' => __("Amount value is too low", 'woo-swish-e-commerce'),
            'AM02' => __("Amount value is too large", 'woo-swish-e-commerce'),
            'AM03' => __("Invalid or missing currency", 'woo-swish-e-commerce'),
            'RP02' => __("Wrong formatted message", 'woo-swish-e-commerce'),
            'RP06' => __("Another active request already exists for this swish number", 'woo-swish-e-commerce'),
            'ACMT03' => __("Payer not Enrolled", 'woo-swish-e-commerce'),
            'ACMT01' => __("Counterpart is not activated", 'woo-swish-e-commerce'),
            'ACMT07' => __("Payee not Enrolled", 'woo-swish-e-commerce'),
            'ACMT17' => __("Not a valid swish number", 'woo-swish-e-commerce'),
            'WAITING' => __("Start your Swish-App and authorize the payment", 'woo-swish-e-commerce'),
            'PAID' => __("Thank you for your payment", 'woo-swish-e-commerce'),
            'DECLINED' => __("Payment declined", 'woo-swish-e-commerce'),
            'ERROR' => __("An error has occured", 'woo-swish-e-commerce'),
            'RF07' => __("Transaction declined", 'woo-swish-e-commerce'),
            'BANKIDCL' => __("Payer cancelled BankId signing", 'woo-swish-e-commerce'),
            'FF10' => __("Bank system processing error", 'woo-swish-e-commerce'),
            'TM01' => __("Swish timed out before the payment was started", 'woo-swish-e-commerce'),
            'RF07' => __("Check the payment with your Bank", 'woo-swish-e-commerce'),
            'RF02' => __("Original payment not found or original payment is more than than 13 months old", 'woo-swish-e-commerce'),
            'DS24' => __("Swish timed out waiting for an answer from the banks. Check with your bank about the status of this payment", 'woo-swish-e-commerce'),
            'BANKIDONGOING' => __("BankID already in use.", 'woo-swish-e-commerce'),
            'BANKIDUNKN' => __("BankID is not able to authorize the payment", 'woo-swish-e-commerce'),
        );
        return array_key_exists($code, $codes) ? $codes[$code] : __("Unknown error received from Swish", 'woo-swish-e-commerce');
    }

    /**
     * get_callback_url function
     *
     * Returns the order's main callback url
     *
     * @access public
     * @return string
     */
    public static function get_callback_url($order_id, $secret, $id)
    {
        $args = array(
            'wc-api' => 'wc_swish',
            'nonce' => Woo_Swish_Helper::create_nonce('swish_' . $order_id, $secret, $id),
            'order_id' => $order_id,
        );

        $args = apply_filters('woo_swish_callback_args', $args, $order_id);

        return add_query_arg($args, site_url('/'));
    }

    public static function verify_nonce($nonce, $action, $secret, $id)
    {
        $nonce = (string) $nonce;

        if (empty($nonce)) {
            return false;
        }

        $i = wp_nonce_tick();

        $expected = substr(wp_hash($i . '|' . $action . '|' . $secret . '|' . $id, 'nonce'), -12, 10);
        if (hash_equals($expected, $nonce)) {
            return 1;
        }

        return false;
    }

    public static function create_nonce($action, $secret, $id)
    {
        $i = wp_nonce_tick();

        return substr(wp_hash($i . '|' . $action . '|' . $secret . '|' . $id, 'nonce'), -12, 10);
    }

}
