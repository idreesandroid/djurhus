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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'djurhus' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'c?+ZV97uJaN?B}26ki4Xl{>Q(Ie~WP}7&.@o#)-v!zmBb3J}DQRcjQ$~qnuTk1Fk' );
define( 'SECURE_AUTH_KEY',  'bU_ot3;W)|~M6P^I)J];G=^d/VKedgLyR:&>|]oZ{331X0i)=+SRVvX-(*)$Dx4k' );
define( 'LOGGED_IN_KEY',    'XALP&1b6jC=9C5B!sEJ5.{,L=8|lmv$5l&Mg/Na*c-WkAUaQ|fxoQ9KrISqSG~/d' );
define( 'NONCE_KEY',        '/sd)[`E$4[Mhf]9x}I)%NQ$(h%E5Qgi8%D~>6XZ#V|h1sR&=H{)0hi7^W[,eU[qw' );
define( 'AUTH_SALT',        'w.(q(ha6]=95mjfb9>fk~OoLT*C@N<yqkB85. x0==LhSTkzUZgA1{G`tZsBtHfq' );
define( 'SECURE_AUTH_SALT', 't?b^M{$Zj@|;{-Wv/#MOFTC?8R3M9S?5]L8uJyGX86p@tJf^BP7^hkPph#&_f5^-' );
define( 'LOGGED_IN_SALT',   'bl&)AOL{o[pTpsn3oPctUBq;s6KpHHa7aEVv}V8]%)#RM 3y,& pv~CkyM@eDQ}(' );
define( 'NONCE_SALT',       '>K@NHzu^:yP8@ZwLf)-|qK-l)d^3rQ:;.Ho0#y,ag`aGXC_lH-qWf7q7Z/JsGw;%' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
