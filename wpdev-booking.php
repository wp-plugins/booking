<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://wpbookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Version: 5.1.3
Author: wpdevelop
Author URI: http://wpbookingcalendar.com/
Tested WordPress Versions: 3.3 - 3.9
*/

/*  Copyright 2009 - 2013  www.wpbookingcalendar.com  (email: info@wpbookingcalendar.com),

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

/*
-----------------------------------------------
Change Log and Features for Future Releases :
-----------------------------------------------
 * New Files:
 * =====================================
 * - /languages/wpdev-booking-hr_HR.po (mo)
 * + /languages/wpdev-booking-hr.po
 * 
 * + /lib/wpbc.php
 * ====================================
*/

    // Die if direct access to file ////////////////////////////////////////////
    if (   (! isset( $_GET['wpdev_bkpaypal_ipn'] ) ) && 
           (! isset( $_GET['merchant_return_link'] ) ) && 
           (! isset( $_GET['payed_booking'] ) ) && 
           ( (! isset($_GET['pay_sys']) ) || ($_GET['pay_sys'] != 'authorizenet') ) &&
           (! function_exists ('get_option') )  && 
           (! isset( $_POST['ajax_action'] ) ) 
       ) { die('You do not have permission to direct access to this file !!!'); }

    // A J A X /////////////////////////////////////////////////////////////////
    function wpbc_find_wp_base_path() {
        $dir = dirname(__FILE__);
        do {
            //it is possible to check for other files here
            if( file_exists($dir."/wp-config.php") ) {
                return $dir;
            }
        } while( $dir = realpath("$dir/..") );
        return null;
    }   
    
    if ( 
         ( isset( $_GET['wpdev_bkpaypal_ipn'] ) )  || 
         ( isset( $_GET['payed_booking'] ) )  || 
         ( isset( $_GET['merchant_return_link'] ) )  || 
         ( (isset($_GET['pay_sys']) ) && ($_GET['pay_sys'] == 'authorizenet' ) ) ||    
         ( isset( $_POST['ajax_action'] ) ) 
       ) {
            
        if ( file_exists( dirname(__FILE__) . '/../../../wp-load.php' ) ) {
            require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        } else if (file_exists( wpbc_find_wp_base_path() . '/wp-load.php' )) {
            require_once( wpbc_find_wp_base_path() . '/wp-load.php' );
        } else {
            die('Booking Calendar Error! Can not load WP functions!');
        }        
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
        
    } //  End Ajax  ////////////////////////////////////////////////////////////
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   USERS  CONFIGURABLE  CONSTANTS           //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!defined('WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS'))   define('WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS',   false );
    if (!defined('WP_BK_SHOW_INFO_IN_FORM'))                define('WP_BK_SHOW_INFO_IN_FORM',   false );      // This feature can impact to the performace
    if (!defined('WP_BK_SHOW_BOOKING_NOTES'))               define('WP_BK_SHOW_BOOKING_NOTES',  false );      // Set notes of the specific booking visible by default.
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   SYSTEM  CONSTANTS                        //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!defined('WP_BK_VERSION_NUM'))      define('WP_BK_VERSION_NUM',         '5.1.3' );
    if (!defined('WP_BK_MINOR_UPDATE'))     define('WP_BK_MINOR_UPDATE',        true );    
    if (!defined('IS_USE_WPDEV_BK_CACHE'))  define('IS_USE_WPDEV_BK_CACHE',     true );    
    if (!defined('WP_BK_DEBUG_MODE'))       define('WP_BK_DEBUG_MODE',          false );
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!defined('WPDEV_BK_FILE'))             define('WPDEV_BK_FILE',  __FILE__ );       
    if (!defined('WP_CONTENT_DIR'))            define('WP_CONTENT_DIR', ABSPATH . 'wp-content');                        // Z:\home\server.com\www/wp-content
    if (!defined('WP_PLUGIN_DIR'))             define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');                    // Z:\home\server.com\www/wp-content/plugins
    if (!defined('WPDEV_BK_PLUGIN_FILENAME'))  define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );              // wpdev-booking.php
    if (!defined('WPDEV_BK_PLUGIN_DIRNAME'))   define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) ); // wpdev-booking
    if (!defined('WPDEV_BK_PLUGIN_DIR')) define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.WPDEV_BK_PLUGIN_DIRNAME );     // Z:\home\server.com\www/wp-content/plugins/booking
    if (!defined('WPDEV_BK_PLUGIN_URL')) define('WPDEV_BK_PLUGIN_URL', plugins_url( '', WPDEV_BK_FILE ) );              // http://server.com/wp-content/plugins/booking
          
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   L O A D   F I L E S                      //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php')) {     // S u p p o r t    f u n c t i o n s
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-class-dismiss.php')) {          // C L A S S  -  Dismiss
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-class-dismiss.php' ); 
        global $wpbc_Dismiss;
        $wpbc_Dismiss = new WPBC_Dismiss();
    }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-settings-general.php')) {      // S e t t i n g s
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-settings-general.php' ); }        
        
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-widget.php')) {        // W i d g e t s
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-widget.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php'))  {             // C A P T C H A
        require_once(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php' );}

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/inc/personal.php'))   {                  // O t h e r
        require_once(WPDEV_BK_PLUGIN_DIR. '/inc/personal.php' ); }
        
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-lib.php')) {                // S u p p o r t    l i b
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-lib.php' ); }
                
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-timeline.php')) {           // T i m e l i n e    l i b
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-timeline.php' ); }
        
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-edit-toolbar-buttons.php')) { // B o o k i n g    B u t t o n s   in   E d i t   t o o l b a r
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-bk-edit-toolbar-buttons.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php'))           // C L A S S    B o o k i n g
        { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-booking-new.php'))              // N e w
        { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-booking-new.php' ); }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET VERSION NUMBER
    $plugin_data = get_file_data_wpdev(  __FILE__ , array( 'Name' => 'Plugin Name', 'PluginURI' => 'Plugin URI', 'Version' => 'Version', 'Description' => 'Description', 'Author' => 'Author', 'AuthorURI' => 'Author URI', 'TextDomain' => 'Text Domain', 'DomainPath' => 'Domain Path' ) , 'plugin' );
    if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',   $plugin_data['Version'] );                             // 0.1
            
    //    A J A X     R e s p o n d e r
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php'))  { 
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php' ); }

    // Wellcome page
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-welcome.php'))                 // W E L C O M E
        { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpbc-welcome.php' ); }
    
    // ** GO **
    $wpdev_bk = new wpdev_booking();     
?>