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
define('WP_USE_THEMES', true);

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

$ips[]   = '188.223.81.179';
$ips[]   = '81.145.137.50';
$ips[]   = '92.237.202.106';
$ips[]   = '192.168.56.1';
$ips[]   = '151.224.44.65';
$ips[]   = '80.169.150.68';
$ips[]   = '91.142.40.68';
$ips[]   = '169.254.37.20';



if( in_array( get_client_ip() , $ips)    ){
    /** Loads the WordPress Environment and Template */
    require( dirname( __FILE__ ) . '/wp-blog-header.php' );
}else{

    header( 'Location: http://sewingquarter.com/' );
    die;
}








