<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('DB_NAME', 'ibiza');

 

if( $_SERVER['SERVER_ADDR'] == '192.168.56.101' ){

    /** MySQL database username */
    define('DB_USER', 'root');

    /** MySQL database password */
    define('DB_PASSWORD', 'd3v0p5');

    /** MySQL hostname */
    define('DB_HOST', 'localhost');

    /** Database Charset to use in creating database tables. */
    define('DB_CHARSET', 'utf8mb4');
    
    define('API_URL', 'http://ibizaschemas.product');
    
    

}else if( $_SERVER['SERVER_ADDR'] == '172.31.1.0' ){
    /** MySQL database username */
    define('DB_USER', 'ibiza');

    /** MySQL database password */
    define('DB_PASSWORD', 'password_uat');

    /** MySQL hostname */
    define('DB_HOST', 'ibiza-front-end-wordpress-db-uat.cbextfa9fu28.eu-west-1.rds.amazonaws.com');
                        
    /** Database Charset to use in creating database tables. */
    define('DB_CHARSET', 'utf8mb4');
    
    define('API_URL', 'http://ibizaschemas.product.uat');
    
}else if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
	/** MySQL database username */
    define('DB_USER', 'root');

    /** MySQL database password */
    define('DB_PASSWORD', '');

    /** MySQL hostname */
    define('DB_HOST', '127.0.0.1');

    /** Database Charset to use in creating database tables. */
    define('DB_CHARSET', 'utf8mb4');
    
    define('API_URL', 'http://ibizaschemas.product');
}
else{
    
    /** MySQL database username */
    define('DB_USER', 'ibiza');

    /** MySQL database password */
    define('DB_PASSWORD', 'ibizawp!');

    /** MySQL hostname */
    define('DB_HOST', 'ibiza-front-end-wordpress-db.cbextfa9fu28.eu-west-1.rds.amazonaws.com');

    /** Database Charset to use in creating database tables. */
    define('DB_CHARSET', 'utf8mb4');    
    
    define('API_URL', 'http://ibizaschemas.product');
    
}



/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+a~nmSUDio(6bxY:NY)nKssU+BF9!kD2p,D->.0!Ah+%q$!,|#cXO1WqRsxc1} F');
define('SECURE_AUTH_KEY',  'z&s#EWG7Np-.|1P!s1}[s7|{sO1lo-^<q5v||t7mM;NPNL=-Ko/qhJ3+-FwM2itz');
define('LOGGED_IN_KEY',    'C-opyiEcJ1z+:s6U|noDM1{i4yxGweBaME[FY>7x.(!lU_,3mq{a2Fw&GjJ#oeI|');
define('NONCE_KEY',        '-k>pgn|*{_t+&]d8FQs!q gEg5rfOIJh>OI9AD:U0:=1+j27hrT<h/r Y|53{Q>%');
define('AUTH_SALT',        'D^q=7r^7r1z).Jao[>J&xLv:S|!5&([KP9(75tg[~lH@u?/+UHu81mQV!M@V/qlI');
define('SECURE_AUTH_SALT', '=F=|A,4~|K5|55Wbs+M_+nM+m;l>++qg$fwX!8U[4g}?[O^0|q:x2DnMw]qE#+?9');
define('LOGGED_IN_SALT',   'AoTnnu]:XUh_K=bJn>~J4&.lwj):3Uv@gQt3^tr<>2q6ExxB5M!c%8mxbsrq8Rl3');
define('NONCE_SALT',       '<0hYn<c%^5PZoi6R]G4]!-s*dyM(4#9&:6DDO,;Xco]$H1N_]Y#z{><GUr-j5d4f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
