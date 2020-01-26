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
define( 'DB_NAME', 'grocipal_wp973' );

/** MySQL database username */
define( 'DB_USER', 'grocipal_wp973' );

/** MySQL database password */
define( 'DB_PASSWORD', '@4704a@Spz' );

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
define( 'AUTH_KEY',         '0fjzpvdzv6f1myli8d3s1xabpegs476csybth9rqeschoe5gtrsw7sp2hiyo0vjq' );
define( 'SECURE_AUTH_KEY',  'azpofzvq7hy5qztncgvim59eadsxj6q8osjeswy8okvkl8hs6rnsighygzmon8zh' );
define( 'LOGGED_IN_KEY',    'do2yh33kqrjmydotgdaipdqdtecl7cdsrakp0o5xx1nedcxn6rn0rloezeqmvqlz' );
define( 'NONCE_KEY',        'e3q0b0geg3xo5x1piv3jiq6trwaeamtnvvv4lmm6olx9tq5u1hwue5jqpaxapctr' );
define( 'AUTH_SALT',        'jeib6gjqmzfkuftvflvwd2azwu4bsurae4aqz3ctiw1cghykh7btvrmkem8htzgu' );
define( 'SECURE_AUTH_SALT', 'wv0phunpcr9krg48eqgfnua5jawot9zwjlwwo1pqgzh0c3pybnnybop4zrh7cnjy' );
define( 'LOGGED_IN_SALT',   '3v3svauk9thtena8udphjxhewul4muwcarf2yel1cjngmva9yceqegacvbwmbvw8' );
define( 'NONCE_SALT',       'eewkjwfpgx4acbx48rnuwmxvmphackqmhltyhra1677shvulfoojhwqqiszznh3d' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpca_';

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
define( 'WP_DEBUG', false );

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.grocipal.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('ALLOW_UNFILTERED_UPLOADS', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
