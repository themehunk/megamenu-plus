<?php 
/**
 * Plugin Name: ThemeHunk MegaMenu
 * Plugin URI:  https://themehunk.com
 * Description: Megamenu plugin from Themehunk.
 * Version:     1.0.0
 * Author:      Themehunk
 * Author URI:  https://themehunk.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: themehunk-megamenu
 * Domain Path: /languages
 */
  
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'THMM_VERSION',  '1.0.0' );
// Setting path variables
if( ! defined( 'THMM_URL' ) ){
	define( 'THMM_URL', plugin_dir_url( __FILE__ ) );
}
if( ! defined( 'THMM_DIR' ) ){
	define( 'THMM_DIR', plugin_dir_path(__FILE__) );
}
//Include files here
include_once( THMM_DIR . 'inc/megamenu-setting.php' );
include_once( THMM_DIR . 'inc/megamenu-default-option.php' );
include_once( THMM_DIR . 'inc/megamenu-base.php' );
include_once( THMM_DIR . 'inc/megamenu-class.php' );
include_once( THMM_DIR . 'inc/toggle-themehunk-megamenu.php' );
include_once( THMM_DIR . 'inc/megamenu-functions.php' );
include_once( THMM_DIR . 'inc/megamenu-nav-menu-settings.php' );
include_once( THMM_DIR . 'inc/megamenu-widgets.php' );
include_once( THMM_DIR . 'inc/walker.php' );
include_once( THMM_DIR . 'inc/megamenu-style.php' );