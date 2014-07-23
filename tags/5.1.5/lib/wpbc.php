<?php
/**
 * @version 1.0
 * @package Booking Calendar 
 * @subpackage Core
 * @category Bookings
 * 
 * @author wpdevelop
 * @link http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2014.05.17
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


if ( ! class_exists( 'Booking_Calendar' ) ) :

    
// General Init Class    
final class Booking_Calendar {
    
    
    static private $instance = NULL;

    
    // Get Single Instance of this Class
    static public function getInstance() {
        
        if (  self::$instance == NULL ) {

            self::$instance = new Booking_Calendar();
            
            self::$instance->constants();
            self::$instance->includes();
            
            // TODO: Finish here
            // add_action('plugins_loaded', array(self::$instance, 'load_textdomain') );    // T r a n s l a t i o n            
        }
        
        return self::$instance;
    }

    
    // Define constants
    private function constants() {
        require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-constants.php' ; 
    }
    
    
    // Include Files
    private function includes() {
        require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc-include.php' ; 
    }
    
    
    // TODO: Finish here
    public function load_textdomain() {
        // Set filter for plugin's languages directory
        $iwpdev_pp_lang_dir = WPDEV_BK_PLUGIN_DIR . '/i18n/languages/';
        $iwpdev_pp_lang_dir = apply_filters( 'wpbc~languages_directory', $iwpdev_pp_lang_dir );

        // Plugin locale filter
        $locale        = apply_filters( 'plugin_locale',  get_locale(), 'wpdev-booking' );
        $mofile        = sprintf( '%1$s-%2$s.mo', 'wpdev-booking', $locale );

        // Setup paths to current locale file
        $mofile_local  = $iwpdev_pp_lang_dir . $mofile;
        $mofile_global = WP_LANG_DIR . '/iwpdev_pp/' . $mofile;

        if ( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/iwpdev_pp folder
                load_textdomain( 'wpdev-booking', $mofile_global );
        } elseif ( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/wpfiledownload/i18n/languages/ folder
                load_textdomain( 'wpdev-booking', $mofile_local );
        } else {
                // Load the default language files
                load_plugin_textdomain( 'wpdev-booking', false, $iwpdev_pp_lang_dir );
        }
    }    
    
}

endif;


// Get Instance of Booking Calendar CLASS
function wpbookingcalendar() {
    return Booking_Calendar::getInstance();
}


// Start
wpbookingcalendar();
?>