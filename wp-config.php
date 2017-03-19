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
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', 'C:\xampp\htdocs\wordpress\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'wordpress');

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
define('AUTH_KEY',         'shQu*=FOI-?sLRpPZZiV@ScqD>5!C{H^;V~t?0:E29AZY@A4ihV|c#:xXq<G-O#N');
define('SECURE_AUTH_KEY',  '5uu;vQaB&{v$mSw!R6!3jQQ_(%v2vqBB$4ciOEJ3.y!uA:H8NN)pgHRa;XE:0qL9');
define('LOGGED_IN_KEY',    'CFQ^}e6ze%k,!9[n!CvRkYI]qB9Ru:,cYI7pWYjqpq&9<vGBr9ygEZu3Ft+!o81J');
define('NONCE_KEY',        'zAHOiBD`)8PbpM%i>;T<T+]5k`)>eGJ0}Ckc$khL,~~boLm,K!+{@GDu}A_^^1R8');
define('AUTH_SALT',        'Co-KVP1|(wZh;xog|XT~BuNDjS}&YQe,Kd[RLr&HlSMs2Oswz@1q%<9kn)uxu+AY');
define('SECURE_AUTH_SALT', '1Th~RMUJ|!Sa1!AG[y?eI+olYwk2cZ:k/K<E hoSXeRoBycfPLvyIrXL(1SQgY8L');
define('LOGGED_IN_SALT',   '#4CT?$XAMV_$CdO@a >qOk.>|.6cPw0?9D7~t_oF(Yr-.XaG0Q8kWv3*# %Ge$oB');
define('NONCE_SALT',       '3O~}y~-Q44cFk;]qOp4w%!FUO0`]C{>d[@f(sU]4WkFi$5Q`}uPJ$.bDzE<7|/<H');

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
