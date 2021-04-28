<?php

/**
 * Woo_Swish_Order class
 *
 * @class        Woo_Swish_Order
 * @version      1.0.0
 * @package      Woocommerce_Swish/Classes
 * @category     Class
 * @author       BjornTech
 */

defined('ABSPATH') || exit;

class Woo_Swish_Order extends WC_Order
{
    /**
     * get_transaction_status function
     *
     * If the order has a transaction order reference, we will return it. If no transaction order reference is set we
     * return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_transaction_status()
    {
        return get_post_meta($this->get_id(), '_swish_transaction_status', true);
    }

    /**
     * set_transaction_status function
     *
     * Set the transaction status on an order
     *
     * @access public
     * @return void
     */
    public function set_transaction_status($transaction_status)
    {
        update_post_meta($this->get_id(), '_swish_transaction_status', $transaction_status);
    }

     /**
     * set_transaction_location function
     *
     * Set the transaction location on an order
     *
     * @access public
     * @return void
     */
    public function set_transaction_location($transaction_location)
    {
        update_post_meta($this->get_id(), '_swish_transaction_location', $transaction_location);
    }

    /**
     * get_transaction_location function
     *
     * Set the transaction location on an order
     *
     * @access public
     * @return void
     */
    public function get_transaction_location()
    {
        return get_post_meta($this->get_id(), '_swish_transaction_location', true);
    }

    /**
     * is_missing_payment_details
     *
     * Is checking if a valid transaction was made but no callback has arrived
     *
     * @access public
     * @return bool
     */
    public function is_missing_payment_details() 
    {
        return $this->get_transaction_location() && 'WAITING' == $this->get_transaction_status();
    }

    /**
     * get_secret function
     *
     * If the order has a secret, we will return it. If no secret is set we
     * return FALSE.
     *
     * @access public
     * @return string
     */
    public function get_secret()
    {
        return get_post_meta($this->get_id(), '_swish_transaction_secret', true);
    }

    /**
     * set_secret function
     *
     * Set the transaction statis on an order
     *
     * @access public
     * @return void
     */
    public function set_secret($secret)
    {
        update_post_meta($this->get_id(), '_swish_transaction_secret', $secret);
    }

    /**
     * note function.
     *
     * Adds a custom order note
     *
     * @access public
     * @return void
     */
    public function note($message)
    {
        if (isset($message)) {
            $this->add_order_note('Swish: ' . $message);
        }
    }

    /**
     * set_refund_payment_reference
     *
     * Set the transaction location on an order
     *
     * @access public
     * @return void
     */
    public function set_refund_id($refund_id)
    {
        add_post_meta($this->get_id(), '_swish_refund_id', $refund_id);
    }

}
