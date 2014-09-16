<?php
/** Enable W3 Total Cache Edge Mode */
define('W3TC_EDGE_MODE', true); // Added by W3 Total Cache


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
define('DB_NAME', 'pera_site');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'XCk`-M5lAuoAugzj0;(SacsRjh+9sF^b Z*|YX;*_G.Z9:L9vieBz@>r+->e{*xI');
define('SECURE_AUTH_KEY',  'g|>Z:^,gFGpyox$h:qsISzzJ4AmW~nwhc^e:n+v3FQI~$@Vb-g#CdODD}.>F7Zhe');
define('LOGGED_IN_KEY',    'JyCTszx(2|@58u%|p8z+xi++eLg!lh4%3-Gnm_pO?Ht:hLaNxy9aK)c fpHEq~GH');
define('NONCE_KEY',        'y:&s&y%b|cp9G RqgXS!`|cr|D#)g@M:oIgRJE+pu|#F}ZYft=N[gt]3Wbu?Q-En');
define('AUTH_SALT',        '<R)zHx7S+,l#3v/-KXV,]S:n:=In]Q[9xu)Vq4x~g0X3(Y 1_=tM5+9gE8q8-L{6');
define('SECURE_AUTH_SALT', 'j2T(^zBMWaiKrP;BbK)X^2[CXp wDJ3Q_&eqx|UKDV5ACa[]>WM(5|,|C@i:aGW{');
define('LOGGED_IN_SALT',   'o.K/af+6Z$F-F{Tin)oHq}RR+ S!4rPf~F4r-7`MOvT$o?Eg6+T--<x:+h4Bc|,W');
define('NONCE_SALT',       'vlp-^n!5-F*pr:kQzFHN|X--81*P>ebPn8mr0|ec%][EO:%p@}GyKV-KGw5g~n{w');

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
