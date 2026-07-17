<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'companyprofilewordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F$q|_D^`REx$T`)KMqkV= +K`jOt++2kAQ;*nW|m2zZX)IpW!9W/A/S%6~QbL9R#' );
define( 'SECURE_AUTH_KEY',  '9IA=T^>S5o<|T/b1_f-kx^k1:WQYB>#V/#Y~r[WN*-w*<5/&R?.p0KWXzf<O&E==' );
define( 'LOGGED_IN_KEY',    '*:^bjugG5uH!M3$`H3lS-NO(OTj;Xv3^w))%m@#x*u X#b00u^!P#[C(%=UiOcse' );
define( 'NONCE_KEY',        '/!v-D09&1vjj;xmt3jK=yV``SCkbN<?holn6^@Z,SB`l||le>:Sa?D_U2!XZX1yI' );
define( 'AUTH_SALT',        '^$vp=BiE}kwN9id%i;s$B5FuS(1:rqqB%E(3}.&W~-m$VI8dNgjXWl+k??|]Xn$.' );
define( 'SECURE_AUTH_SALT', 'D@A%bfG:Ds.Oo!%yb)a5e$G0/;Zw|:,mv;)2QPuu.tm6|nR$zRPdQQb(=<{*yoaV' );
define( 'LOGGED_IN_SALT',   'bPx`{K%igrhQZF98%t;Aw;=]~D47nWgq{9K+#$F>bjbCs+zsRv5ik*==RjB;gq]n' );
define( 'NONCE_SALT',       '??Uy.XFn8voGl6la&yEZu=Rn_15@m};S&/ I)X/C{d/lg,VzeIKU#Yq5fF^N0Q,^' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
/* Add any custom values between this line and the "stop editing" line. */

// Load .env early for GA_MEASUREMENT_ID, SEO flags, etc.
if ( file_exists( __DIR__ . '/wp-content/mu-plugins/load-env.php' ) ) {
	require_once __DIR__ . '/wp-content/mu-plugins/load-env.php';
}

if ( ! defined( 'WP_DEBUG' ) ) {
	define(
		'WP_DEBUG',
		function_exists( 'apexora_flag' ) ? apexora_flag( 'WP_DEBUG', false ) : false
	);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
