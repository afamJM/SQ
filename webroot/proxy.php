<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

require('wp-config.php');
 
 function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$url            = API_URL . '/addTobasket';
$ch             = curl_init( $url );
$cookieStr      = $_COOKIE['nsec'];
$quantity       = $_GET['quantity'];
$productCode    = $_GET['productCode'];
$productDetailId= $_GET['productDetailID'];

if($quantity <=0) {
    $quantity  = 1;
}

parse_str($cookieStr, $output);

$data_string =  '{
    "BasketID"          : 0,
    "AuctionID"         : null,
    "Ip"                : "'.  get_client_ip()  .'",
    "WebsiteId"         : 83,
    "ProductSourceId"   : 83,
    "ProductDetailId"       : '. $productDetailId . ' ,
    "Quantity"          : '. $quantity .',
    "WishListId"        : null,
    "CurrencyId"        : 1,
    ' . (($_COOKIE['nsec']) ? '"CustomerId": ' . $output['ci'] .',' : '"CookieId": "' . $_COOKIE['ann'] . '",') . '
    "DeliveryCountryId" : 49,
    "Language"          : 23,
    ' . (($_COOKIE['nsec']) ? '"NonSecurityKey"    : "'. $output['sk'] .'" }' : '}');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)));

$result = curl_exec($ch);
curl_close($ch);

echo $result;
die;