<?php
/**
 * Created by PhpStorm.
 * User: Studio Animation 2D
 * Date: 07/04/2017
 * Time: 03:52
 */

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


require_once APPPATH.'libraries/woocommerce/woocommerce-api.php';

class Woocommerce
{
    protected $client;

    function __construct()
    {
        $key_client = "ck_8cfca8308409322d16308dbd85bdf6309dfcb572";
        $key_secret = "cs_90897f88fb986ec630244b8cba02b337c792c243";

        $options = array(
            'ssl_verify'      => false,
        );

        try {

            $this->client = new WC_API_Client(E_COMMERCE_HOST, $key_client, $key_secret, $options);
        } catch ( WC_API_Client_Exception $e ) {

            echo $e->getMessage() . PHP_EOL;
            echo $e->getCode() . PHP_EOL;

            if ( $e instanceof WC_API_Client_HTTP_Exception ) {

                print_r( $e->get_request() );
                print_r( $e->get_response() );
            }
        }
    }

    function change_order_state($order_id, $state)
    {
        $this->client->orders->update_status($order_id, $state);
    }

    function get_order($order_id)
    {
        return $this->client->orders->get($order_id);
    }
}
