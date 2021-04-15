<?php

use Automattic\WooCommerce\Client;

function wooCommerce()
{
    $url = config('woocommerce.url');
    $consumerKey = config('woocommerce.consumer_key');
    $consumerSecret = config('woocommerce.consumer_secret');
    $options = config('woocommerce.options');
    return new Client($url, $consumerKey, $consumerSecret, $options);
}
