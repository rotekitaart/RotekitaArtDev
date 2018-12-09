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
define('DB_NAME', 'RotekitaArt');

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
define('AUTH_KEY',         'Qk*{rFzbZ>4#O[<hBc~QRvJOp[$@,0)QJ?_:M2=,2:/&I( :*_W/Sb/4C^3&hx]p');
define('SECURE_AUTH_KEY',  'Qb]]|Wys1?_,~!_Xt+jofTUR?@W_%C5L XxQnC?UR&c5XK[/&WD[jn:0g.XUrziJ');
define('LOGGED_IN_KEY',    '1Ozr<.4VV?. [V_;NO_s@4=Wy@zaL/grFviTQ=Aisr9a+9n4,o0!?b(R+Z+kOb.q');
define('NONCE_KEY',        '50@d{@veQ}T~?4&nrXwFi=$H;$/#@K44pPFn%S]FrqqPu00@pOpsIv;!u;?z[ovI');
define('AUTH_SALT',        '_P&xVCW|ikqGX}Sp~G&<0JQE >O+~)p,eD@5x{5AnI+WxjK&k&DK0xoyNHtmf-Ib');
define('SECURE_AUTH_SALT', '_|b1;JMnw6k]Rx^Gzb<?[C:GT[_v j0zIV]WG0S41)4r.IN1PB>XN;8w O}j8gUn');
define('LOGGED_IN_SALT',   '.ZgGw@jFLs_8lS97Z`8ZH@P<Q&ZGqk5Z@We|LG-g(s2CHL,):Zd.(u.{R+l[L-Vj');
define('NONCE_SALT',       '?HN{2H/s !ulMm,zgKX?(Or)AbmoZsuZK}/j::p6OtHZ&Pqp76k):S e^GDiJLRy');

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

/** Change Media Upload Directory */
define('UPLOADS', ''.'Media');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');




