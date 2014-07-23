<?php
/**
 * @version 1.0
 * @package Booking Calendar 
 * @subpackage Files Loading
 * @category Bookings
 * 
 * @author wpdevelop
 * @link http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2014.05.17
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   L O A D   F I L E S                      //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-booking-functions.php';          // S u p p o r t    f u n c t i o n s
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-booking-widget.php';             // W i d g e t s
require_once WPDEV_BK_PLUGIN_DIR . '/js/captcha/captcha.php';                   // C A P T C H A
if (file_exists(WPDEV_BK_PLUGIN_DIR.'/inc/personal.php')){                      // O t h e r
require_once WPDEV_BK_PLUGIN_DIR . '/inc/personal.php'; } 
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-bk-lib.php';                     // S u p p o r t    l i b  
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-bk-timeline.php';                // T i m e l i n e    l i b
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-booking-class.php';              // C L A S S    B o o k i n g
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-booking-new.php';                 // N e w
    
require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-scripts.php';                     // Load CSS and JS

// require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-google-calendar.php';             // Sync with Google Calendar 5.2.0

if( is_admin() ) {
    
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-settings-general.php';       // S e t t i n g s        
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpdev-bk-edit-toolbar-buttons.php';// B o o k i n g    B u t t o n s   in   E d i t   t o o l b a r    
    
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-class-dismiss.php';           // C L A S S  -  Dismiss         
    global $wpbc_Dismiss;
    $wpbc_Dismiss = new WPBC_Dismiss();
        
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-welcome.php';                 // W E L C O M E     Page        
        
} else {
    
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// GET VERSION NUMBER                         //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$plugin_data = get_file_data_wpdev(  WPDEV_BK_FILE , array( 'Name' => 'Plugin Name', 'PluginURI' => 'Plugin URI', 'Version' => 'Version', 'Description' => 'Description', 'Author' => 'Author', 'AuthorURI' => 'Author URI', 'TextDomain' => 'Text Domain', 'DomainPath' => 'Domain Path' ) , 'plugin' );
if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',   $plugin_data['Version'] );                             // 0.1


if (  ( defined( 'DOING_AJAX' ) )  && ( DOING_AJAX )  ){                        // New A J A X    R e s p o n d e r
    
    if ( class_exists('wpdev_bk_personal')) { $wpdev_bk_personal_in_ajax = new wpdev_bk_personal(); }
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-ajax.php';                        // NT - Ajax 

} else {                                                                        // Usual Loading of plugin

    // We are having Response, its executed in other file: wpbc-response.php
    if ( WP_BK_RESPONSE )
        return;
    
    // Normal Start
    $wpdev_bk = new wpdev_booking();                                            // GO
}
?>