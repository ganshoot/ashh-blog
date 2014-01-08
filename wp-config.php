<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'armenianst_blog');

/** MySQL database username */
define('DB_USER', 'armenianst_blog');

/** MySQL database password */
define('DB_PASSWORD', 'hPf4SxAa');

/** MySQL hostname */
define('DB_HOST', '192.168.21.120');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '*A)zNXyr/US D?y}p.nY|g&sU.hh9Pu.TGVtUUW/}v^%`Lj]Fn^wEcm+2v^4}V~r');
define('SECURE_AUTH_KEY',  'YmmAo36ek,d]`d?[>rm4KKU`2=|!@bUP00^)ie=lXi|qsH46~3=}(k,_c09n+rQ1');
define('LOGGED_IN_KEY',    '|?0%ptt++g2# ll~zRl@ol{~o9&vWC8+#XN|FCa`%j>;i-a~c<.+E1A-tzhiH5WP');
define('NONCE_KEY',        'oVou0pE~,kNj+d&k3Y|I[P)`X;q[3hNPLE^{Oc85iEcyt{PK>9*Xd:l<MUt+]}1~');
define('AUTH_SALT',        '~ctrhv@`mlG:4#::cduR_- ns!Db~`s;x61-P[y7[wI2P|NO{~Qh0Ms{Y7#`PW-u');
define('SECURE_AUTH_SALT', 'ot?3iwLHN?!|y?G=$J$lHIFmn{pGQ/Ai?jXUj9_sP-5fB!3$ a?:W.TkXesxn|9N');
define('LOGGED_IN_SALT',   '^BjiXT=Dtg18.u+8+HlunCb|X>~Yh+(p=V`-AX3VY_Dn=t*Y=0`-B&]avC.c{,+U');
define('NONCE_SALT',       'h:y<s,VAJ^+g)W66][lTWst,-u93iM| )OI6&&rf>Gyqy=mJ`(Gcr^mW1drl(dX(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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