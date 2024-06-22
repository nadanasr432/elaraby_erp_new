<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u597505123_5Aadn' );

/** MySQL database username */
define( 'DB_USER', 'u597505123_oMtvk' );

/** MySQL database password */
define( 'DB_PASSWORD', '2SJDdc4XkY' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'rq*p1do?<G&b{7J>^9TNfG2ud%.l9<^NiS(ZmWK?ghd6;)/or0#1s$OwLh5)S9;.' );
define( 'SECURE_AUTH_KEY',   'JRkY]$/1p7,TpGy?_AYD&q8wo$w/q~P[)Z:N2<hCHv1H$lS9R)>wlZoDfoOEzpq&' );
define( 'LOGGED_IN_KEY',     '~HCofh=pq!V.$A<!^|X:A/E`VQEJPeX]<bd(JPiLG*-o_TP[NGlA=D<B<$wT%aE=' );
define( 'NONCE_KEY',         '5^d+TvNcF?Ez4jCCI3`Kg:e_J8[f<]j%R^3fB=Xr2!A-GV0<C>R#100aa1pkap?q' );
define( 'AUTH_SALT',         '<1[Y[]VuyfKyw@I:.QJMkB3srr=H&z9Q}s qn?0hS$0v(&Eg/0K+|7eFy<{nKdH%' );
define( 'SECURE_AUTH_SALT',  'DzcYrD[H]Gahz![VWMt7QOKBR&vD%XZ>[}qNkNH<~sVn@Jy)Dr31kJNM@*z-8%,/' );
define( 'LOGGED_IN_SALT',    'fr[Z,@pEt)Ip}6Vu7*6e4EqAeW9dm@2~tWd/to< >U2kz.$[jjNFfXa6*4Wfb0TL' );
define( 'NONCE_SALT',        'fpuCl;yA+FME$qFp}F{O-X-Td/s>G7/HtTvrPDHN8O$Br[5q,Z4P` ryQ7iOv^ol' );
define( 'WP_CACHE_KEY_SALT', '9uoZ6#SvfpQ61iqw!MiUx)n]!EH{3$/UX`N(c}>~tsj]# }rOxVMAR]HWSK?HvpH' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




define( 'WP_AUTO_UPDATE_CORE', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
