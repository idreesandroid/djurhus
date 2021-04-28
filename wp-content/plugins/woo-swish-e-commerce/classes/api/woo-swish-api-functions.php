<?php
/**
 * Woo_Swish_API_Functions class
 *
 * @class         Woo_Swish_API_Functions
 * @since         1.7.0
 * @package       Woocommerce_Swish/Classes/Api
 * @category      Class
 * @author        BjornTech
 */

defined('ABSPATH') || exit;

class Woo_Swish_API_Functions
{

    public $text_on_transaction = null;
    public $customer_on_transaction = false;
    public $merchant_alias = null;
    public $api_url = null;

    public function __construct()
    {
        $this->merchant_alias = WC_SEC()->get_option('merchant_alias');
        $this->text_on_transaction = WC_SEC()->get_option('text_on_transaction', "");
        $this->customer_on_transaction = WC_SEC()->get_option('customer_on_transaction') == 'yes' ? true : false;
    }
    /**
     * create function.
     *
     * Creates a new payment via the API
     *
     * @access public
     * @param  Woo_Swish_Order $order
     * @return object
     * @throws Woo_Swish_API_Exception
     */
    public function create(Woo_Swish_Order $order, $payer_alias = "")
    {
        $secret = $order->get_secret();
        if (!$secret) {
            $secret = uniqid();
            $order->set_secret($secret);
        }
        $order_id = $order->get_id();

        $transaction_textarray = array();
        if ($this->text_on_transaction != '') {
            $transaction_textarray[] = $this->text_on_transaction;
        }

        if ($this->customer_on_transaction) {
            $customer_number = apply_filters('woo_swish_ecommerce_user_id', $order->get_user_id(), $order);
            $transaction_textarray[] = sprintf(__('Customer number %s', 'woo-swish-e-commerce'), $customer_number);
        }

        $transaction_text = mb_substr(preg_replace("/[^a-zA-Z0-9åäöÅÄÖ :;.,?!()]+/", "", implode(', ', $transaction_textarray)), 0, 49);

        $params = array(
            'payeePaymentReference' => $order->get_order_number(),
            'callbackUrl' => Woo_Swish_Helper::get_callback_url($order_id, $secret, $this->merchant_alias),
            'payerAlias' => strlen($payer_alias) < 8 ? '4671234768' : $payer_alias,
            'payeeAlias' => $this->merchant_alias,
            'amount' => str_replace(',', '.', $order->get_total()),
            'currency' => 'SEK',
            'message' => strlen($payer_alias) < 8 ? $payer_alias : $transaction_text,
        );
        $payment = $this->post('paymentrequests', $params);

        return $payment;
    }

    /**
     * refund function.
     *
     * Sends a 'refund' request to the Swish API
     *
     * @access public
     * @param  int $transaction_id
     * @param  int $amount
     * @return void
     * @throws Woo_Swish_API_Exception
     */
    public function refund($transaction_id, $order, $amount = null, $reason = '')
    {
        if ($amount === null) {
            $amount = $order->get_total();
        }

        $transaction_text = mb_substr(preg_replace("/[^a-zA-Z0-9åäöÅÄÖ :;.,?!()]+/", "", $reason), 0, 49);

        $secret = $order->get_secret();
        if (!$secret) {
            $secret = uniqid();
            $order->set_secret($secret);
        }
        $params = array(
            'payerPaymentReference' => 'R-' . $order->get_order_number() . '-' . date('Y-m-d H:i', current_time('timestamp')),
            'originalPaymentReference' => $transaction_id,
            'callbackUrl' => Woo_Swish_Helper::get_callback_url($order->get_id(), $secret, $this->merchant_alias),
            'payerAlias' => $this->merchant_alias,
            'amount' => str_replace(',', '.', $amount),
            'currency' => 'SEK',
            'message' => $transaction_text,
        );

        $payment = $this->post('refunds', $params);

        return $payment;
    }

    /**
     * retreive function.
     *
     * Retreives a payment via the API
     *
     * @access public
     * @param  string $order
     * @return object
     * @throws Woo_Swish_API_Exception
     */
    public function retreive($order_url)
    {

        $payment = $this->get('retreive', array('order_url' => $order_url));

        return $payment;

    }

}
