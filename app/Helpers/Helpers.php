<?php

use Automattic\WooCommerce\Client;

function woocommerce()
{
    $url = config('woocommerce.url');
    $consumerKey = config('woocommerce.consumer_key');
    $consumerSecret = config('woocommerce.consumer_secret');
    $options = config('woocommerce.options');
    return New Client($url,$consumerKey ,$consumerSecret,$options);
}