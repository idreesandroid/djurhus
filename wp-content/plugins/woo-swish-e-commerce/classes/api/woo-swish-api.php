<?php
/**
 * Woo_Swish_API class
 *
 * @class         Woo_Swish_API
 * @since         1.7.0
 * @package       Woocommerce_Swish/Classes/Api
 * @category      Class
 * @author        BjornTech
 */

defined('ABSPATH') || exit;

class Woo_Swish_API
{

    public function create(Woo_Swish_Order $order, $payer_alias = "")
    {
        throw new Woo_Swish_API_Exception("Connection not configured", 900);
    }

    public function refund($transaction_id, $order, $amount = null, $reason = '')
    {
        throw new Woo_Swish_API_Exception("Connection not configured", 900);
    }

}
