<?php
/** 
 * Custom Wordpress Security Defaults
 * @link https://wordpress.org/support/article/configuring-automatic-background-updates/
 */


// File editing
define('DISALLOW_FILE_EDIT', true); // no file editing from admin
define('DISALLOW_FILE_MODS', true); // no file editing even via updates


/** hardcode urls so it cannot be messed up by clients */
define('WP_HOME','https://kulturforum-zagreb.org');
define('WP_SITEURL','https://kulturforum-zagreb.org');

/** Debuging constants, off on production, on when problems */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );


/** We update everything manually, and keep the install clean */
define( 'AUTOMATIC_UPDATER_DISABLED', true ); // this disables all auto updates

/** Only one of these can be used */
define( 'WP_AUTO_UPDATE_CORE', false );    // no auto updates to core
define( 'WP_AUTO_UPDATE_CORE', true );     // all auto updates to core
define( 'WP_AUTO_UPDATE_CORE', 'minor' );  // only minuor auto updates to core


define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );
define( 'WP_DEFAULT_THEME', 'themename' ); /** change to your themename */

/** If you do this, you have to set the server cron to perform these */
define( 'DISABLE_WP_CRON', true );

/** set the memory limit, often you have to match in php.ini */
define( 'WP_MEMORY_LIMIT', '512M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );