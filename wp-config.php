<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'shop' );

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
define( 'AUTH_KEY',         'yE=JF&?+GF/7yU_S%s.Gp~l r<y_U [R_1_osfk{<4qb.bQ$NAMr7N*v,n_be5nD' );
define( 'SECURE_AUTH_KEY',  'R%Acx7{,_i -2NhRQA,Xui5%_%OnS]}KFB*!3D(}Q70O05qTq@[)]z^<=u%8rSbO' );
define( 'LOGGED_IN_KEY',    'uAU@`n**L1%#Q83u!,^dw]D)s1<M,:`Bl0*%5MZ;#rm540lP3pP5(Efuc1u&fz.Q' );
define( 'NONCE_KEY',        'Cc1I#V%ZV1z,MC0iVf|GsUkPP<3B3~AL)$1i+_zqhi6FHTA^z^y!HBYV2S(AZyj)' );
define( 'AUTH_SALT',        '&<GrQ`(Hr+1Z@*T:`pMC2_j:4I;Pn/+ZpVq7eBF1|h;?ASI|@y!.+3Utrknx`_Wx' );
define( 'SECURE_AUTH_SALT', 'W:$6 k|wSx%Nf7-SzSg77Z&Q*|J.WW H6PiV*|15t%f%%fj{(r,q4[yGE`=)Tmz-' );
define( 'LOGGED_IN_SALT',   '/L5Al>@)}g&w QL`j+c9C{%<6N?E j94_sn*,2eq6^@p9S}Alr8U,Ur<BXH039%&' );
define( 'NONCE_SALT',       'Xp:bS:d2/1U$3{fut8Zx0]ew* f5w.>jxaYXea%c:dH!*)WA`a(20PMou!NQaXc!' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
