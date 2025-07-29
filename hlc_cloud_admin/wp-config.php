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
define( 'DB_NAME', 'hlc_cloud_admin' );

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
define( 'AUTH_KEY',         '}4;dDD488mAwk$w$%TiS9~Em27.y[E<6i8x5ds}P!5se|Q4SR5rOVt4f|nJ~GDKx' );
define( 'SECURE_AUTH_KEY',  'zQ4[d+T61k=EEtG?!eK[2j0Fb0g9p~yr@l4}CK/4`I7jKTdfK.nKD!ATvBI`EH*o' );
define( 'LOGGED_IN_KEY',    't0--&G)l(C4skDg2-]>rx,n:Ss2j&*1}/}w>&uH^(y?@^*#ziEFrI(HDV-yA,p6[' );
define( 'NONCE_KEY',        'WnDN!yQ#-[MM .-N*b?]jblG]!4qv%|hoj5 `+dU>U*|f`TmtQR8{^BJ^/<nS:$7' );
define( 'AUTH_SALT',        '@R`l`y7{W{X[&x,[}+*+mMt%hVP&iG!aNhKMdtcJK$@{)_:l(}]p~5Uj8GdlhXm4' );
define( 'SECURE_AUTH_SALT', '|Mq=)H>C,t[eR:EB{Z:zum<NbD*W>QO(.TP.xa@j-d (g=j-VQ@xOa`%Y(8-v$WO' );
define( 'LOGGED_IN_SALT',   '/|3LEc[q6j/v;2<EGcX2M/m.=+TX79NBDT8r7>K&**^]]2tD8t2/GG!A~UU9qv,T' );
define( 'NONCE_SALT',       '`K(aZLC}R#OqK$Gd4LZ5n3?kWxAl_d(=mm>rU75yHK=*baw9|EH+-XREJ84&,7n ' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
