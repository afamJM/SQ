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

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'd3v0p5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
///l2i^tE7kPl7LGpN
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Mk+Py /^%$b:a#u=BnOpcncikXq|vD?9%4>f^&S,;vF`[;Rg;v=C|73*e?IEF^|k');
define('SECURE_AUTH_KEY',  'dp2rz+_t+5 GegkpH+cNs3Rk0ene2;;%Z2fXbc:D4CsPN/EGA4SK/p]G=s%nR1{v');
define('LOGGED_IN_KEY',    'P>esHenFWpo>U?-UKG/~6|8f.0) OP-C%=:K9YcJ2Y]jX|U$8^]B(.cDM/1hNeSk');
define('NONCE_KEY',        'fcCa|v#%edSZD)[TZL8_Gu^=l;*OQZT}4L5~/E=5s3>W!F5V*-kqUr0.& Ry/O?<');
define('AUTH_SALT',        'e~K[mylk/*.kEQKahtLN_V^?.5Cr[UTC7Bnp0b/lIdv-G;_FVOc`N0+k`<aG2D+^');
define('SECURE_AUTH_SALT', '~kOG-o>;3Jh]d<]W;_&pr?4A}>$a;3<_FCsAw+L^?R8|jm6.vCZ?y$D56.Bjqu>4');
define('LOGGED_IN_SALT',   'wgMyLJ4j)dpCND*dQQdl%-UZ+F,0UZ*y+*o5WW)`{+gji;gZ|Ur{+|*0R%f?/9_n');
define('NONCE_SALT',       '-_2j3>8rv;gH-D@?!],m|~Ocqtps*KsQTsx|6(F<xSk_ji! (kGg:PSeb`N|^3dG');

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
