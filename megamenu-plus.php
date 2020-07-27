<?php 
/**
 * Plugin Name: Megamenu Plus
 * Plugin URI:  https://themehunk.com
 * Description: Megamenu plugin from Themehunk.
 * Version:     1.0.0
 * Author:      Themehunk
 * Author URI:  https://themehunk.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mmplus
 * Domain Path: /languages
 */
  
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'MMPLUS_VERSION',  '1.0.0' );
// Setting path variables
if( ! defined( 'MMPLUS_URL' ) ){
	define( 'MMPLUS_URL', plugin_dir_url( __FILE__ ) );
}
if( ! defined( 'MMPLUS_DIR' ) ){
	define( 'MMPLUS_DIR', plugin_dir_path(__FILE__) );
}
//Include files here
include_once( MMPLUS_DIR . 'inc/megamenu-plus-setting.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-default-option.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-base.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-class.php' );
include_once( MMPLUS_DIR . 'inc/toggle-megamenu-plus.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-functions.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-nav-menu-settings.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-widgets.php' );
include_once( MMPLUS_DIR . 'inc/walker.php' );
include_once( MMPLUS_DIR . 'inc/megamenu-style.php' );