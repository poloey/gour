<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/Users/polodev/code/valetFolder/rv/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'rv');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'c)xuVf Dl~.VU/;{rTbfdtCDw<<PS@T2kG]fZw^W/YRcAde9.?*]O:V;,)Phkri_');
define('SECURE_AUTH_KEY',  'EHYu:uV&OP!pLm!o*)HlI{eL5C jxXBgR9.9mz ]|E3[w6,<)B!fXG:RKGr@d aV');
define('LOGGED_IN_KEY',    'Xns;pQb~[JJS4>/qp-Xd)h{&F[__]02D>M=8dG=HnOwn~Zr?}22=Aa$nfu!`;[/7');
define('NONCE_KEY',        ',e@ dLf}$]p-:mM#]6kfM[c.9q}t10ppbCbiW`GRk415K8L?>#H7ewz4d{WNZX;|');
define('AUTH_SALT',        '*BGP0mr@Q#UP )_vj5nKrN-?Du-dW6O3~z,QW]7Xpicb+$?VnA@MDjaL`HT?vvlm');
define('SECURE_AUTH_SALT', 'V&INgCJD>UMVV`#:2`zWKb9~tKNXN+Vy<e_jey^VX8(c;Jv!:z$%s7R*+L5dRsjv');
define('LOGGED_IN_SALT',   'OyE$AVK2.B1NscqjS`P cmWZ#Qs[]8q$zT<#1(Ha!gcm/priVt0}shmxT{lGp*>)');
define('NONCE_SALT',       '^/w6b~aBw/.*6#R_XKmIU+EDokH96V7T,<>7S?i,*Et8) IMu.]@LN+W++?4[]-$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
