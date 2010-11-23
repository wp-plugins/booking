<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://onlinebookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Version: 2.7
Author: wpdevelop
Author URI: http://onlinebookingcalendar.com/
Tested WordPress Versions: 2.8.3 - 3.0.1
*/

/*  Copyright 2009, 2010  www.onlinebookingcalendar.com  (email: info@onlinebookingcalendar.com),

    www.wpdevelop.com - custom wp-plugins development & WordPress solutions.

    This file (and only this file wpdev-booking.php) is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// <editor-fold defaultstate="collapsed" desc=" T O D O : & Changelog lists ">
/*
-----------------------------------------------
Change Log and Features for Future Releases :
-----------------------------------------------
M i n o r   T O D O   List:
 *   Posibility to add at the booking bookmark how many days to select in range there.
 *   Different rental lengths for different types of items. For example, Room 1 is only available to rent 1 day at a time and Room 2 is available to rent for either 1, 3 or 7 days.
 *   if the user selects a Friday, Saturday or Sunday, it must be part of at least two days, but they can book single days on Monday, Tuesday, Wednesday and Thursday
 *   Several range selections
 * Possible to not allow the booking before the paypal payment has been made, meaning, to entry in the booking calendar, no email, etc. before the payment has been confirmed via paypal
 * To deactivate the Pending option. If a customer books a particular date interval without paying, the booking request must be transfered for future payment, but must not block the calendar dates. Other visitors must be able to book these dates as long as the intial customer's payment has not come through
 * (Maybe at new CRM plugin) Google Calendar integration: it would be nice, someone books inserted into one of Google calendars of administraor, which is used to register all books. This way, it gets synchronized to desktop and iPhone as well
 * Send text messages after booking appointments, send Reminders via email and text messaging, SMS or text message option, to notify you immediately via your cell phone when you get a booking online
 * field type be created that only accepts numbers (auto-validates as number only) or have REGEX defined by user.
 * Add to Professional version posibility to set pending days for selection by other visitors, untill admin will not approve them. * Allow pending bookings to be chosen with an explanation that they will be on a waiting list in the event that the original booker cancels
 *
 * check posibility to include this payment system : https://www.nmi.com/ (its for Panama)
 * Paypal pro integration
 * Authorize . net support
 * Google checkout support
 * eway  payment system support
 * 2co payment system
 *
 * Dependence cost from 2 parameters at same time: number of selected days and season of selection )
 * Add checking to the email sending according errors ( it can be when PHP Mail function is not active at the SERVER )
 * Season filtering by weeks numbers
 * Add description inside of input text fields inside of fields as grey text ??? 
 * More good look of help info at the form fields customization page
 * Set posibility to login with user permission at MultiUser version
 * set required field phone for free version ??? 
 * Id like this [select visitors "1" "2" "3" "4" “5”] to be dynamic. If there is 3 products free, I’d like to see [select visitors "1" "2" "3"] If there is 1 products free, I’d like to see [select visitors "1"] In the popup you can see price and product free so I imagine it’s possible to make selected visitors dynamic
 * Days cost view inside of calendar,unders the days numbers
 * booking manager pro -  it would be much better if the booking manager displayed who had paid and who hadn't right now every order goes through with no way of identifying this
 * automated email to go out to people a couple of days prior to their reservation yet
 * set different times on different days, yet still have them show up on the same calendar
 * Fix to use the dynamic range / two mouse click selection, specifying 2 or more days minimum, it is quite easy to click only once, or click a third time and enter just one day. Add logic that would alert the user to the two day consecutive minimum IF they attempt to make a booking with less than the consecutive minimum and stop them going further
 * Add posibility to select booking resource from select box as a feature of booking calendar - no anymore JS tricks


 M a j o r   T O D O   List:
 * 2.8 Posibility to set Maximum days selections in a range days selection using 2 mouse buttons. Also posibility to set discreet numbers, like possible selection only 3, 7 and 14 days and so on. Add posibility to select only weeks (or may be other number of days). Its mean that can be selected only 7+7+7+... days.
 * 
 * 2.8 HOTEL. Search functionality of available booking resource from all system. Example: Customer is shown a calendar Customer chooses day they wish the rental to start, hit "search" Table of items available to rent beginning THAT DAY come up customer selects desired rental customer is taken to the page with the reservation form for that rental item.
 * A user front end property search facility :  (From Arrival Date – To Date) / No of bedrooms (or travellers) / Location. Search results would be a listed output each linking to a individual Page / Post where clients would have the opportunity to book available dates.
 *
 * -------------------------------------------------------
 * Most of the time, your actual  display is ok but, also quite often, many people wants to travel together and want to see in a nut shell what is available to quickly find when they can reserve together.
 * Therefore a linear summary calendar with the following format would be a very useful tool. Arrows would allow to go forth and back in the calendar.
 * A character would give the status: 0=not available, 1=available (in fact the number could be the number of persons that can stay in that resource ?), w= in a process of reservation
 * ·         Month                 June                                                                     July                                                                                      August
 * ·         Ressource         01 02 03 03 05 06 07 08 09 10 11 …             01 02 03 04 …                                                                    01 02 03 04 …
 * ·         Ressource 1       0   0    1   1   1   1    1   1    1    w w
 * ·         Ressource 2
 * Make categories for resources? I have like 70 resources, and it would be great if i could split the choices on different pages or in different categories.
 * ---------------------------------------------------------------------------------------------------------------------------------------



= 2.8 =
* Professional / Premium / Premium Plus / Hotel / MultiUser versions features:
 * 
* Features and issue fixings in All versions:
 * 

*/

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" D e b u g ">
if (!function_exists ('debuge')) {
    function debuge() {
        $numargs = func_num_args();
        $var = func_get_args();
        $makeexit = is_bool($var[count($var)-1])?$var[count($var)-1]:false;
        echo "<div style='text-align:left;background:#ffffff;border: 1px dashed #ff9933;font-size:11px;line-height:15px;font-family:'Lucida Grande',Verdana,Arial,'Bitstream Vera Sans',sans-serif;'><pre style='white-space:pre-wrap;'>";
        print_r ( $var );
        echo "</pre></div>";
        if ($makeexit) {
            echo '<div style="font-size:18px;float:right;">' . get_num_queries(). '/'  . timer_stop(0, 3) . 'qps</div>';
            exit;
        }
    }

}

if (!function_exists ('bk_error')) {
    function bk_error( $msg , $file_name='', $line_num=''){
        if (!defined('WPDEV_BK_VERSION'))  $ver_num = 'Undefined yet';
        else                               $ver_num = WPDEV_BK_VERSION ;
        echo $msg . ' [F:' .  str_replace( dirname( $file_name ) , '' , $file_name ). "|L:" .  $line_num  . "|V:" .  $ver_num  ."]" ;
    }
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Internal plugin action hooks system ">
global $wpdev_bk_action, $wpdev_bk_filter;

if (!function_exists ('add_bk_filter')) {
function add_bk_filter($filter_type, $filter) {
    global $wpdev_bk_filter;

    $args = array();
    if ( is_array($filter) && 1 == count($filter) && is_object($filter[0]) ) // array(&$this)
        $args[] =& $filter[0];
    else
        $args[] = $filter;
    for ( $a = 2; $a < func_num_args(); $a++ )
        $args[] = func_get_arg($a);

    if ( is_array($wpdev_bk_filter) )

        if ( isset($wpdev_bk_filter[$filter_type]) ) {
            if ( is_array($wpdev_bk_filter[$filter_type]) )
                $wpdev_bk_filter[$filter_type][]= $args;
            else
                $wpdev_bk_filter[$filter_type]= array($args);
        } else
            $wpdev_bk_filter[$filter_type]= array($args);
    else
        $wpdev_bk_filter = array( $filter_type => array( $args ) ) ;
}
}

if (!function_exists ('remove_bk_filter')) {
function remove_bk_filter($filter_type, $filter) {
    global $wpdev_bk_filter;

    if ( isset($wpdev_bk_filter[$filter_type]) ) {
        for ($i = 0; $i < count($wpdev_bk_filter[$filter_type]); $i++) {
            if ( $wpdev_bk_filter[$filter_type][$i][0] == $filter ) {
                $wpdev_bk_filter[$filter_type][$i] = null;
                return;
            }
        }
    }
}
}

if (!function_exists ('apply_bk_filter')) {
function apply_bk_filter($filter_type) {
    global $wpdev_bk_filter;


    $args = array();
    for ( $a = 1; $a < func_num_args(); $a++ )
        $args[] = func_get_arg($a);

    if ( count($args) > 0 )
        $value = $args[0];
    else
        $value = false;

    if ( is_array($wpdev_bk_filter) )
        if ( isset($wpdev_bk_filter[$filter_type]) )
            foreach ($wpdev_bk_filter[$filter_type] as $filter) {
                $filter_func = array_shift($filter);
                $parameter = $args;
                $value =  call_user_func_array($filter_func,$parameter );
            }
    return $value;
}
}

if (!function_exists ('make_bk_action')) {
function make_bk_action($action_type) {
    global $wpdev_bk_action;


    $args = array();
    for ( $a = 1; $a < func_num_args(); $a++ )
        $args[] = func_get_arg($a);

    //$value = $args[0];

    if ( is_array($wpdev_bk_action) )
        if ( isset($wpdev_bk_action[$action_type]) )
            foreach ($wpdev_bk_action[$action_type] as $action) {
                $action_func = array_shift($action);
                $parameter = $action;
                call_user_func_array($action_func,$args );
            }
}
}

if (!function_exists ('add_bk_action')) {
function add_bk_action($action_type, $action) {
    global $wpdev_bk_action;

    $args = array();
    if ( is_array($action) && 1 == count($action) && is_object($action[0]) ) // array(&$this)
        $args[] =& $action[0];
    else
        $args[] = $action;
    for ( $a = 2; $a < func_num_args(); $a++ )
        $args[] = func_get_arg($a);

    if ( is_array($wpdev_bk_action) )
        if ( isset($wpdev_bk_action[$action_type]) ) {
            if ( is_array($wpdev_bk_action[$action_type]) )
                $wpdev_bk_action[$action_type][]= $args;
            else
                $wpdev_bk_action[$action_type]= array($args);
        } else
                $wpdev_bk_action[$action_type]= array($args);

    else
        $wpdev_bk_action = array( $action_type => array( $args ) ) ;
}
}

if (!function_exists ('remove_bk_action')) {
function remove_bk_action($action_type, $action) {
    global $wpdev_bk_action;

    if ( isset($wpdev_bk_action[$action_type]) ) {
        for ($i = 0; $i < count($wpdev_bk_action[$action_type]); $i++) {
            if ( $wpdev_bk_action[$action_type][$i][0] == $action ) {
                $wpdev_bk_action[$action_type][$i] = null;
                return;
            }
        }
    }
}
}

// Work with Booking  Oprions //////////////////////////////////////////////////


if (!function_exists ('get_bk_option')) {
// Get
function get_bk_option( $option, $default = false ) {

    $u_value = apply_bk_filter('wpdev_bk_get_option', 'no-values'  , $option, $default );
    if ( $u_value !== 'no-values' ) return $u_value;

    return get_option( $option, $default  );
}
}

if (!function_exists ('update_bk_option')) {
// Update
function  update_bk_option ( $option, $newvalue ) {

    $u_value = apply_bk_filter('wpdev_bk_update_option', 'no-values'  , $option, $newvalue );
    if ( $u_value !== 'no-values' ) return $u_value;

    return update_option($option, $newvalue);
}
}

if (!function_exists ('delete_bk_option')) {
// Dekete
function  delete_bk_option ( $option   ) {

    $u_value = apply_bk_filter('wpdev_bk_delete_option', 'no-values'  , $option );
    if ( $u_value !== 'no-values' ) return $u_value;

    return delete_option($option );
}
}

if (!function_exists ('add_bk_option')) {
// Add
function add_bk_option( $option, $value = '', $deprecated = '', $autoload = 'yes' ) {

    $u_value = apply_bk_filter('wpdev_bk_add_option', 'no-values'  , $option, $value, $deprecated,  $autoload );
    if ( $u_value !== 'no-values' ) return $u_value;

    return add_option( $option, $value  , $deprecated  , $autoload   );
}
}
////////////////////////////////////////////////////////////////////////////////

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" I n i t i a l    F u n c t i o n s ">
//   Get header info from this file, just for compatibility with WordPress 2.8 and older versions //////////////////////////////////////
if (!function_exists ('get_file_data_wpdev')) {
function get_file_data_wpdev( $file, $default_headers, $context = '' ) {
    // We don't need to write to the file, so just open for reading.
    $fp = fopen( $file, 'r' );

    // Pull only the first 8kiB of the file in.
    $file_data = fread( $fp, 8192 );

    // PHP will close file handle, but we are good citizens.
    fclose( $fp );

    if( $context != '' ) {
        $extra_headers = array();//apply_filters( "extra_$context".'_headers', array() );

        $extra_headers = array_flip( $extra_headers );
        foreach( $extra_headers as $key=>$value ) {
            $extra_headers[$key] = $key;
        }
        $all_headers = array_merge($extra_headers, $default_headers);
    } else {
        $all_headers = $default_headers;
    }


    foreach ( $all_headers as $field => $regex ) {
        preg_match( '/' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, ${$field});
        if ( !empty( ${$field} ) )
            ${$field} =  trim(preg_replace("/\s*(?:\*\/|\?>).*/", '',  ${$field}[1] ));
        else
            ${$field} = '';
    }

    $file_data = compact( array_keys( $all_headers ) );

    return $file_data;
}
}

//   D e f i n e     S T A T I C      //////////////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists ('wpdev_bk_define_static')) {
function wpdev_bk_define_static() {

    if (  (! isset( $_GET['merchant_return_link'] ) ) && (! isset( $_GET['payed_booking'] ) ) && (!function_exists ('get_option')  )  ) {
        die('You do not have permission to direct access to this file !!!');
    }

    $default_headers = array(
            'Name' => 'Plugin Name',
            'PluginURI' => 'Plugin URI',
            'Version' => 'Version',
            'Description' => 'Description',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path'
    );
    $plugin_data = get_file_data_wpdev(  __FILE__, $default_headers, 'plugin' );


    if (!defined('WP_CONTENT_DIR'))   define('WP_CONTENT_DIR', ABSPATH . 'wp-content');                   // Z:\home\test.wpdevelop.com\www/wp-content
    if (!defined('WP_CONTENT_URL'))   define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');    // http://test.wpdevelop.com/wp-content
    if (!defined('WP_PLUGIN_DIR'))       define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');               // Z:\home\test.wpdevelop.com\www/wp-content/plugins
    if (!defined('WP_PLUGIN_URL'))       define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');               // http://test.wpdevelop.com/wp-content/plugins
    if (!defined('WPDEV_BK_PLUGIN_FILENAME'))  define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );              // menu-compouser.php
    if (!defined('WPDEV_BK_PLUGIN_DIRNAME'))   define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) ); // menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_DIR')) define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // Z:\home\test.wpdevelop.com\www/wp-content/plugins/menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_URL')) define('WPDEV_BK_PLUGIN_URL', WP_PLUGIN_URL.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // http://test.wpdevelop.com/wp-content/plugins/menu-compouser
    $version_type = '';
    if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',  $version_type.$plugin_data['Version'] );                             // 0.1

    require_once(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php' );
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php')) {
         require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php' );
    }

    if ( ! loadLocale() ) { loadLocale('en_US'); }    
    $locale = get_locale();
    //$locale = 'fr_FR'; loadLocale($locale);                                      // Localization
    if ($locale != 'en_US') {
        global  $l10n;
        //Recheck translation files according ' sign
        if (isset($l10n['wpdev-booking']))
            foreach ($l10n['wpdev-booking']->entries as $key=>$tr_obj) {
                $new_translation = str_replace("'","\\'",$tr_obj->translations);
                $l10n['wpdev-booking']->entries[$key]->translations  = $new_translation;
            }
    }

}
}

//   Load locale          //////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists ('loadLocale')) {
function loadLocale($locale = '') { // Load locale, if not so the  load en_EN default locale from folder "languages" files like "this_file_file_name-ru_RU.po" and "this_file_file_name-ru_RU.mo"
    if ( empty( $locale ) ) $locale = get_locale();
    if ( !empty( $locale ) ) {
        //Filenames like this  "microstock-photo-ru_RU.po",   "microstock-photo-de_DE.po" at folder "languages"
        $domain = str_replace('.php','',WPDEV_BK_PLUGIN_FILENAME) ;
        $mofile = WPDEV_BK_PLUGIN_DIR  .'/languages/'.$domain.'-'.$locale.'.mo';
        if (file_exists($mofile)) {
            //return load_textdomain($domain , $mofile);  // Depricated
            $plugin_rel_path = WPDEV_BK_PLUGIN_DIRNAME .'/languages'  ;
            return load_plugin_textdomain( $domain ,   false, $plugin_rel_path ) ;
        } else   return false;
    }
    return false;
}
}
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc=" Getting Ajax requests ">
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Getting Ajax requests
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( isset( $_POST['ajax_action'] ) ) {
    define('DOING_AJAX', true);
    require_once( dirname(__FILE__) . '/../../../wp-load.php' );
    @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
    wpdev_bk_define_static();
    if ( class_exists('wpdev_bk_pro')) {
        $wpdev_bk_pro_in_ajax = new wpdev_bk_pro();
    }
    wpdev_bk_ajax_responder();
}

if ( ( isset( $_GET['payed_booking'] ) )  || (  isset( $_GET['merchant_return_link'])) ) {
    require_once( dirname(__FILE__) . '/../../../wp-load.php' );
    @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
    wpdev_bk_define_static();
    if ( class_exists('wpdev_bk_pro')) {
        $wpdev_bk_pro_in_ajax = new wpdev_bk_pro();
    }
    if (function_exists ('wpdev_bk_update_pay_status')) wpdev_bk_update_pay_status();
    die;
} /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// </editor-fold>


wpdev_bk_define_static();


// <editor-fold defaultstate="collapsed" desc=" C L A S S ">
if (!class_exists('wpdev_booking')) {
    class wpdev_booking {

        // <editor-fold defaultstate="collapsed" desc="  C O N S T R U C T O R  &  P r o p e r t i e s ">

        var $icon_button_url;
        var $prefix;
        var $settings;
        var $wpdev_bk_pro;
        var $captcha_instance;

        function wpdev_booking() {

            // Add settings top line before all other menu items.
            add_bk_action('wpdev_booking_settings_top_menu', array($this, 'settings_menu_top_line'));
            add_bk_action('wpdev_booking_settings_show_content', array(&$this, 'settings_menu_content'));

            $this->captcha_instance = new wpdevReallySimpleCaptcha();
            $this->prefix = 'wpdev_bk';
            $this->settings = array(  'custom_buttons' =>array(),
                    'custom_buttons_func_name_from_js_file' => 'set_bk_buttons', //Edit this name at the JS file of custom buttons
                    'custom_editor_button_row'=>1 );
            $this->icon_button_url = WPDEV_BK_PLUGIN_URL . '/img/calendar-16x16.png';

            if ( class_exists('wpdev_bk_pro')) {
                $this->wpdev_bk_pro = new wpdev_bk_pro();
            }
            else {
                $this->wpdev_bk_pro = false;
            }

            // Create admin menu
            add_action('admin_menu', array(&$this, 'add_new_admin_menu'));

            // Client side print JSS
            add_action('wp_head',array(&$this, 'client_side_print_booking_head'));

            // Add custom buttons
            add_action( 'init', array(&$this,'add_custom_buttons') );
            add_action( 'admin_head', array(&$this,'insert_wpdev_button'));

            //
            add_action( 'wp_footer', array(&$this,'wp_footer') );
            add_action( 'admin_footer', array(&$this,'print_js_at_footer') );

            // User defined
            add_action( 'wpdev_bk_add_calendar', array(&$this,'add_calendar_action') ,10 , 2);
            add_action( 'wpdev_bk_add_form',     array(&$this,'add_booking_form_action') ,10 , 2);

            add_filter( 'wpdev_bk_get_form',     array(&$this,'get_booking_form_action') ,10 , 2);

            add_filter( 'wpdev_bk_get_showing_date_format',     array(&$this,'get_showing_date_format') ,10 , 1);

            add_filter( 'wpdev_bk_is_next_day',     array(&$this,'is_next_day') ,10 , 2);


            add_bk_filter(   'wpdev_booking_table', array(&$this, 'booking_table'));

            add_bk_action('show_footer_at_booking_page', array(&$this, 'show_footer_at_booking_page'));

            add_bk_filter(   'get_script_for_calendar', array(&$this, 'get_script_for_calendar'));  // Get script for calendar activation


            // S H O R T C O D E - Booking
            add_shortcode('booking', array(&$this, 'booking_shortcode'));
            add_shortcode('bookingcalendar', array(&$this, 'booking_calendar_only_shortcode'));
            add_shortcode('bookingform', array(&$this, 'bookingform_shortcode'));
            add_shortcode('bookingedit', array(&$this, 'bookingedit_shortcode'));


            // Add settings link at the plugin page
            add_filter('plugin_action_links', array(&$this, 'plugin_links'), 10, 2 );

            // Add widjet
            add_action( 'init', array(&$this,'add_booking_widjet') );

            // Install / Uninstall
            register_activation_hook( __FILE__, array(&$this,'wpdev_booking_activate' ));
            register_deactivation_hook( __FILE__, array(&$this,'wpdev_booking_deactivate' ));

            add_bk_action('wpdev_booking_activate_user', array(&$this, 'wpdev_booking_activate'));


            if ( ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking')!==false) &&
                    ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking-reservation')===false )
            ) {
                if (defined('WP_ADMIN')) if (WP_ADMIN === true) wp_enqueue_script( 'jquery-ui-dialog' );
                wp_enqueue_style(  'wpdev-bk-jquery-ui', WPDEV_BK_PLUGIN_URL. '/css/jquery-ui.css', array(), 'wpdev-bk', 'screen' );
            }
        // add_filter( 'site_transient_update_plugins', array(&$this, 'plugin_non_update'), 10, 1 ); // donot show update for Professional active plugin
        // add_action( 'after_plugin_row', array(&$this,'after_plugin_row'),10,3 );
        // add_filter( 'plugin_row_meta', array(&$this, 'plugin_row_meta'), 10, 4 ); // donot show update for Professional active plugin

        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="    Update info of plugin at the plugins section   ">
        // Functions for using at future versions: update info of plugin at the plugins section.
        function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $context) {
            if ($plugin_file =='booking/wpdev-booking.php') {
                debuge('Ha ha', $plugin_meta, $plugin_file, $plugin_data, $context);
                // Echo plugin description here
                return $plugin_meta;
            } else            return $plugin_meta;
        }

        function after_plugin_row($plugin_file, $plugin_data, $context) {
            if ($plugin_file =='booking/wpdev-booking.php') {
                ?>
                                <tr class="plugin-update-tr">
                                    <td class="plugin-update" colspan="3">
                                        <div class="update-message">
                                            Please check updates of Paid versions
                                            <a title="Booking Calendar" class="thickbox" href="http://onlinebookingcalendar.net/changelog?width=1240&amp;TB_iframe=true" onclick="javascript:jQuery('.entry').scrollTop(100);">here</a>.
                                        </div>
                                    </td>
                                </tr>
                <?php
            }
        }

        function plugin_non_update($value) {
            if (!class_exists('wpdev_bk_pro')) return $value;
            //debuge($value);
            foreach ($value->response as $key=>$version_value) {
                //debuge($key, $version_value->new_version   );
                if( strpos($key, 'wpdev-booking.php') !== false ) {
                    unset($value->response[$key]);
                    break;
                }
            }
            //debuge($value);
            return $value;
        }

        // Adds Settings link to plugins settings
        function plugin_links($links, $file) {

            $this_plugin = plugin_basename(__FILE__);

            if ($file == $this_plugin) {
                $settings_link = '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option">'.__("Settings", 'wpdev-booking').'</a>';
                $settings_link2 = '<a href="http://onlinebookingcalendar.net/purchase/">'.__("Buy", 'wpdev-booking').' Pro</a>';
                array_unshift($links, $settings_link2);
                array_unshift($links, $settings_link);
            }
            return $links;
        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="  ADMIN MENU SECTIONS   ">
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // ADMIN MENU SECTIONS  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        function add_new_admin_menu() {
            $users_roles = array(get_bk_option( 'booking_user_role_booking' ), get_bk_option( 'booking_user_role_addbooking' ), get_bk_option( 'booking_user_role_settings' ) );

            for ($i = 0 ; $i < count($users_roles) ; $i++) {
                
                if ( $users_roles[$i] == 'administrator' )  $users_roles[$i] = 'activate_plugins';
                if ( $users_roles[$i] == 'editor' )         $users_roles[$i] = 'publish_pages';
                if ( $users_roles[$i] == 'author' )         $users_roles[$i] = 'publish_posts';
                if ( $users_roles[$i] == 'contributor' )    $users_roles[$i] = 'edit_posts';
                if ( $users_roles[$i] == 'subscriber')      $users_roles[$i] = 'read';
                //if ( $users_roles[$i] == 'administrator' )  $users_roles[$i] = 10;
                //if ( $users_roles[$i] == 'editor' )         $users_roles[$i] = 7;
                //if ( $users_roles[$i] == 'author' )         $users_roles[$i] = 2;
                //if ( $users_roles[$i] == 'contributor' )    $users_roles[$i] = 1;
                //if ( $users_roles[$i] == 'subscriber')      $users_roles[$i] = 0;
            }

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // M A I N     B O O K I N G
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pagehook1 = add_menu_page( __('Reservation services', 'wpdev-booking'), __('Booking', 'wpdev-booking'), $users_roles[0],
                    __FILE__ . 'wpdev-booking', array(&$this, 'on_show_booking_page_main'),  WPDEV_BK_PLUGIN_URL . '/img/calendar-16x16.png'  );
            add_action("admin_print_scripts-" . $pagehook1 , array( &$this, 'on_add_admin_js_files'));
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // A D D     R E S E R V A T I O N
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pagehook2 = add_submenu_page(__FILE__ . 'wpdev-booking',__('Add booking', 'wpdev-booking'), __('Add booking', 'wpdev-booking'), $users_roles[1],
                    __FILE__ .'wpdev-booking-reservation', array(&$this, 'on_show_booking_page_addbooking')  );
            add_action("admin_print_scripts-" . $pagehook2 , array( &$this, 'client_side_print_booking_head'));
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // S E T T I N G S
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pagehook3 = add_submenu_page(__FILE__ . 'wpdev-booking',__('Booking settings customizations', 'wpdev-booking'), __('Settings', 'wpdev-booking'), $users_roles[2],
                    __FILE__ .'wpdev-booking-option', array(&$this, 'on_show_booking_page_settings')  );
            add_action("admin_print_scripts-" . $pagehook3 , array( &$this, 'on_add_admin_js_files'));
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // global $submenu, $menu;               // Change Title of the Main menu inside of submenu
            // this is make error in roleswhen we have first autor and then admin and admin roles
            // $submenu[plugin_basename( __FILE__ ) . 'wpdev-booking'][0][0] = __('Booking calendar', 'wpdev-booking');
        }

        //Booking
        function on_show_booking_page_main() {
            $this->on_show_page_adminmenu('wpdev-booking','/img/calendar-48x48.png', __('Reservation services', 'wpdev-booking'),1);
        }
        //Add resrvation
        function on_show_booking_page_addbooking() {
            $this->on_show_page_adminmenu('wpdev-booking-reservation','/img/add-1-48x48.png', __('Add booking', 'wpdev-booking'),2);
        }
        //Settings
        function on_show_booking_page_settings() {
            $this->on_show_page_adminmenu('wpdev-booking-option','/img/application-48x48.png', __('Booking settings customizations', 'wpdev-booking'),3);
        }

        //Show content
        function on_show_page_adminmenu($html_id, $icon, $title, $content_type) {
            ?>
            <div id="<?php echo $html_id; ?>-general" class="wrap bookingpage">
            <?php
            if ($content_type == 3 )
                echo '<div class="icon32" style="margin:5px 40px 10px 10px;"><img src="'. WPDEV_BK_PLUGIN_URL . $icon .'"><br /></div>' ;
            else
                echo '<div class="icon32" style="margin:10px 25px 10px 10px;"><img src="'. WPDEV_BK_PLUGIN_URL . $icon .'"><br /></div>' ; ?>

            <h2><?php echo $title; ?></h2>
            <?php
            switch ($content_type) {
                case 1: $this->content_of_booking_page();
                    break;
                case 2: $this->content_of_reservation_page();
                    break;
                case 3: $this->content_of_settings_page();
                    break;
                default: break;
            } ?>
            </div>
            <?php
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   C u s t o m      b u t t o n s    ">
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  C u s t o m      b u t t o n s ///////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // C u s t o m   b u t t o n s  /////////////////////////////////////////////////////////////////////
        function add_custom_buttons() {
            // Don't bother doing this stuff if the current user lacks permissions
            if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;

            // Add only in Rich Editor mode
            if (  ( in_array( basename($_SERVER['PHP_SELF']),  array('post-new.php', 'page-new.php', 'post.php', 'page.php') ) ) /*&& ( get_user_option('rich_editing') == 'true')*/  ) {
                //content_wpdev_bk_booking_insert
                // 'content_' . $this->$prefix . '_' . $type
                $this->settings['custom_buttons'] = array(
                        'booking_insert' => array(
                                'hint' => __('Insert booking calendar', 'wpdev-booking'),
                                'title'=> __('Booking calendar', 'wpdev-booking'),
                                'img'=> $this->icon_button_url,
                                'js_func_name_click' => 'booking_click',
                                'bookmark' => 'booking',
                                'class' => 'bookig_buttons',
                                'is_close_bookmark' =>0
                        )
                );


                add_filter("mce_external_plugins", array(&$this, "mce_external_plugins"));
                // add_action( 'admin_head', array(&$this, 'add_custom_button_function') );
                add_action( 'edit_form_advanced', array(&$this, 'add_custom_button_function') );
                add_action( 'edit_page_form', array(&$this, 'add_custom_button_function') );

                if ( 1 == $this->settings['custom_editor_button_row'] )
                    add_filter( 'mce_buttons', array(&$this, 'mce_buttons') );
                else
                    add_filter( 'mce_buttons_' . $this->settings['custom_editor_button_row'] , array(&$this, 'mce_buttons') );

                add_action( 'admin_head', array(&$this, 'custom_button_dialog_CSS') );
                add_action( 'admin_footer', array(&$this, 'custom_button_dalog_structure_DIV') );

                wp_enqueue_script( 'jquery-ui-dialog' );
                wp_enqueue_style(  'wpdev-bk-jquery-ui', WPDEV_BK_PLUGIN_URL. '/css/jquery-ui.css', array(), 'wpdev-bk', 'screen' );
                //wp_enqueue_style( $this->prefix . '-jquery-ui',WPDEV_BK_PLUGIN_URL. '/js/custom_buttons/jquery-ui.css', array(), $this->prefix, 'screen' );
            }
        }

        // Add button code to the tiny editor
        function insert_wpdev_button() {
            if ( count($this->settings['custom_buttons']) > 0) {
                ?>  <script type="text/javascript">
                    var jWPDev = jQuery.noConflict();
                <?php

                echo '      function '. $this->settings['custom_buttons_func_name_from_js_file'].'(ed, url) {';

                foreach ( $this->settings['custom_buttons'] as $type => $props ) {
                    echo "if ( typeof ".$props['js_func_name_click']." == 'undefined' ) return;";

                    echo "  ed.addButton('".  $this->prefix . '_' . $type ."', {";
                    echo "		title : '". $props['hint'] ."',";
                    echo "		image : '". $props['img'] ."',";
                    echo "		onclick : function() {";
                    echo "			". $props['js_func_name_click'] ."('". $type ."');";
                    echo "		}";
                    echo "	});";
                }
                echo '}';

                ?> </script> <?php
            }
        }

        // Load the custom TinyMCE plugin
        function mce_external_plugins( $plugins ) {
            $plugins[$this->prefix . '_quicktags'] = WPDEV_BK_PLUGIN_URL.'/js/custom_buttons/editor_plugin.js';
            return $plugins;
        }

        // Add the custom TinyMCE buttons
        function mce_buttons( $buttons ) {
            //array_push( $buttons, "separator", 'wpdev_booking_insert', "separator" );
            array_push( $buttons, "separator");
            foreach ( $this->settings['custom_buttons'] as $type => $strings ) {
                array_push( $buttons, $this->prefix . '_' . $type );
            }

            return $buttons;
        }

        // Add the old style buttons to the non-TinyMCE editor views and output all of the JS for the button function + dialog box
        function add_custom_button_function() {
            $buttonshtml = '';
            $datajs='';
            foreach ( $this->settings['custom_buttons'] as $type => $props ) {

                $buttonshtml .= '<input type="button" class="ed_button" onclick="'.$props['js_func_name_click'].'(\'' . $type . '\')" title="' . $props['hint'] . '" value="' . $props['title'] . '" />';

                $datajs.= " wpdev_bk_Data['$type'] = {\n";
                $datajs.= '		title: "' . $this->js_escape( $props['title'] ) . '",' . "\n";
                $datajs.= '		tag: "' . $this->js_escape( $props['bookmark'] ) . '",' . "\n";
                $datajs.= '		tag_close: "' . $this->js_escape( $props['is_close_bookmark'] ) . '",' . "\n";
                $datajs.= '		cal_count: "' . get_bk_option( 'booking_client_cal_count' )  . '"' . "\n";
                $datajs.=  "\n	};\n";
            }
            ?>
        <script type="text/javascript">

            // <![CDATA[
            var wpdev_bk_Data={};
            <?php echo $datajs; ?>
            var is_booking_edit_shortcode=false;
                // Set default heights (IE sucks)
            <?php if( $this->wpdev_bk_pro !== false ) { ?>
                var wpdev_bk_DialogDefaultHeight = 205;
                <?php } else { ?>
                    var wpdev_bk_DialogDefaultHeight = 145;
                <?php }  ?>
                    var wpdev_bk_DialogDefaultExtraHeight = 0;
                    var wpdev_bk_DialogDefaultWidth = 580;
                    if ( jWPDev.browser.msie ) {
                        var wpdev_bk_DialogDefaultHeight = wpdev_bk_DialogDefaultHeight + 8;
                        var wpdev_bk_DialogDefaultExtraHeight = wpdev_bk_DialogDefaultExtraHeight +8;
                    }


                    // This function is run when a button is clicked. It creates a dialog box for the user to input the data.
                    function booking_click( tag ) {
                        wpdev_bk_DialogClose(); // Close any existing copies of the dialog
                        wpdev_bk_DialogMaxHeight = wpdev_bk_DialogDefaultHeight + wpdev_bk_DialogDefaultExtraHeight;


                        // Open the dialog while setting the width, height, title, buttons, etc. of it
                        var buttons = { "<?php echo esc_js(__('Ok', 'wpdev-booking')); ?>": wpdev_bk_ButtonOk,
                            "<?php echo esc_js(__('Cancel', 'wpdev-booking')); ?>": wpdev_bk_DialogClose
                        };
                        var title = '<img src="<?php echo $this->icon_button_url; ?>" /> ' + wpdev_bk_Data[tag]["title"];
                        /*
                         jWPDev("#wpdev_bk-dialog").dialog({
                             autoOpen: false,
                             width: wpdev_bk_DialogDefaultWidth,
                             minWidth: wpdev_bk_DialogDefaultWidth,
                             height: wpdev_bk_DialogDefaultHeight,
                             minHeight: wpdev_bk_DialogDefaultHeight,
                             maxHeight: wpdev_bk_DialogMaxHeight,
                             title: title,
                             buttons: buttons
                         }); /**/
                        jWPDev("#wpdev_bk-dialog").dialog({
                            autoOpen: false,
                            width: 700,
                            buttons:buttons,
                            draggable:false,
                            hide: 'slide',
                            resizable: false,
                            modal: true,
                            title: title,
                            <?php
                                $verion_width = '250';
                                if ( class_exists('wpdev_bk_pro'))            $verion_width = '375';
                                if ( class_exists('wpdev_bk_premium'))        $verion_width = '375';
                                if ( class_exists('wpdev_bk_premium_plus') )  $verion_width = '445';
                                echo " height: " . $verion_width . ' ';
                            ?>
                    });
                    // Reset the dialog box incase it's been used before
                    jWPDev("#wpdev_bk-dialog input").val("");
                    jWPDev("#calendar_tag_name").val(wpdev_bk_Data[tag]['tag']);
                    jWPDev("#calendar_tag_close").val(wpdev_bk_Data[tag]['tag_close']);
                    jWPDev("#calendar_count").val(wpdev_bk_Data[tag]['cal_count']);
                    // Style the jWPDev-generated buttons by adding CSS classes and add second CSS class to the "Okay" button
                    jWPDev(".ui-dialog button").addClass("button").each(function(){
                        if ( "<?php echo esc_js(__('Ok', 'wpdev-booking')); ?>" == jWPDev(this).html() ) jWPDev(this).addClass("button-highlighted");
                    });

                    // Do some hackery on any links in the message -- jWPDev(this).click() works weird with the dialogs, so we can't use it
                    jWPDev("#wpdev_bk-dialog-content a").each(function(){
                        jWPDev(this).attr("onclick", 'window.open( "' + jWPDev(this).attr("href") + '", "_blank" );return false;' );
                    });

                    // Show the dialog now that it's done being manipulated
                    jWPDev("#wpdev_bk-dialog").dialog("open");

                    // Focus the input field
                    jWPDev("#wpdev_bk-dialog-input").focus();
                }

                // Close + reset
                function wpdev_bk_DialogClose() {
                    jWPDev(".ui-dialog").height(wpdev_bk_DialogDefaultHeight);
                    jWPDev(".ui-dialog").width(wpdev_bk_DialogDefaultWidth);
                    jWPDev("#wpdev_bk-dialog").dialog("close");
                }

                // Callback function for the "Okay" button
                function wpdev_bk_ButtonOk() {

                    var cal_count = jWPDev("#calendar_count").val();
                    var cal_type = jWPDev("#calendar_type").val();
                    var cal_tag = jWPDev("#calendar_tag_name").val();
                    var cal_tag_close = jWPDev("#calendar_tag_close").val();
                    var calendar_or_form = jWPDev("#calendar_or_form").val();
                    var booking_form_type = jWPDev("#booking_form_type").val();

                    if (calendar_or_form == 'calendar') cal_tag = 'bookingcalendar';
                    if (calendar_or_form == 'onlyform') cal_tag = 'bookingform';

                    if ( is_booking_edit_shortcode ) cal_tag = 'bookingedit';

                    if ( !cal_tag ) return wpdev_bk_DialogClose();

                    var text = '[' + cal_tag;
                    if ( cal_tag == 'bookingform' ) {
                        text += ' ' + 'selected_dates=\''+ jWPDev("#day_popup").val() +'.'+ jWPDev("#month_popup").val()+'.'+ jWPDev("#year_popup").val() +'\'';
                    }
                    if (cal_tag != 'bookingedit') {
                        if (cal_type) text += ' ' + 'type=' + cal_type;
                        if (booking_form_type) text += ' ' + 'form_type=\'' + booking_form_type + '\'';

                        if (cal_tag != 'bookingform') {
                                if (cal_count) text += ' ' + 'nummonths=' + cal_count;
                        }

                    }
                    text += ']';
                    if (cal_tag_close != 0) text += '[/' + cal_tag + ']';


                    if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
                        ed.focus();
                        if (tinymce.isIE)
                            ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

                        ed.execCommand('mceInsertContent', false, text);
                    } else
                        edInsertContent(edCanvas, text);

                    wpdev_bk_DialogClose();
                }


                // On page load...
                jWPDev(document).ready(function(){
                    // Add the buttons to the HTML view
                    jWPDev("#ed_toolbar").append('<?php echo $this->js_escape( $buttonshtml ); ?>');

                    // If the Enter key is pressed inside an input in the dialog, do the "Okay" button event
                    jWPDev("#wpdev_bk-dialog :input").keyup(function(event){
                        if ( 13 == event.keyCode ) // 13 == Enter
                            wpdev_bk_ButtonOkay();
                    });

                    // Make help links open in a new window to avoid loosing the post contents
                    jWPDev("#wpdev_bk-dialog-slide a").each(function(){
                        jWPDev(this).click(function(){
                            window.open( jWPDev(this).attr("href"), "_blank" );
                            return false;
                        });
                    });
                });
                // ]]>
        </script>
            <?php
        }

        // Output the <div> used to display the dialog box
        function custom_button_dalog_structure_DIV() { ?>
        <div class="hidden">
            <div id="wpdev_bk-dialog">
                <div class="wpdev_bk-dialog-content">
                    <div class="wpdev_bk-dialog-inputs">

                        <?php make_bk_action('show_tabs_inside_insertion_popup_window'); ?>

                        <div id="popup_new_reservation"  style="display:block;width:650px;">

                            <?php if( $this->wpdev_bk_pro !== false ) {
                                    $types_list = $this->wpdev_bk_pro->get_booking_types(); ?>
                                    <div class="field">
                                        <div style="float:left;">
                                        <label for="calendar_type"><?php _e('Booking resource:', 'wpdev-booking'); ?></label>
                                        <select id="calendar_type" name="calendar_type">
                                            <?php foreach ($types_list as $tl) { ?>
                                            <option value="<?php echo $tl->id; ?>"
                                                        style="<?php if  (isset($tl->parent)) if ($tl->parent == 0 ) { echo 'font-weight:bold;'; } else { echo 'font-size:11px;padding-left:20px;'; } ?>"
                                                    ><?php echo $tl->title; ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                        <div class="description"><?php _e('For booking select type of booking resource', 'wpdev-booking'); ?></div>
                                    </div>
                            <?php } ?>

                            <?php make_bk_action('wpdev_show_bk_form_selection') ?>

                            <div class="field">
                                <div style="float:left;">
                                <label for="calendar_count"><?php _e('Number of calendars:', 'wpdev-booking'); ?></label>
                                <!--input id="calendar_count"  name="calendar_count" class="input" type="text" value="<?php echo get_bk_option( 'booking_client_cal_count' ); ?>" -->
                                <select  id="calendar_count"  name="calendar_count" >
                                    <option value="1" <?php if (get_bk_option( 'booking_client_cal_count' )== '1') echo ' selected="SELECTED" ' ?> >1</option>
                                    <option value="2" <?php if (get_bk_option( 'booking_client_cal_count' )== '2') echo ' selected="SELECTED" ' ?> >2</option>
                                    <option value="3" <?php if (get_bk_option( 'booking_client_cal_count' )== '3') echo ' selected="SELECTED" ' ?> >3</option>
                                    <option value="4" <?php if (get_bk_option( 'booking_client_cal_count' )== '4') echo ' selected="SELECTED" ' ?> >4</option>
                                    <option value="5" <?php if (get_bk_option( 'booking_client_cal_count' )== '5') echo ' selected="SELECTED" ' ?> >5</option>
                                    <option value="6" <?php if (get_bk_option( 'booking_client_cal_count' )== '6') echo ' selected="SELECTED" ' ?> >6</option>
                                    <option value="7" <?php if (get_bk_option( 'booking_client_cal_count' )== '7') echo ' selected="SELECTED" ' ?> >7</option>
                                    <option value="8" <?php if (get_bk_option( 'booking_client_cal_count' )== '8') echo ' selected="SELECTED" ' ?> >8</option>
                                    <option value="9" <?php if (get_bk_option( 'booking_client_cal_count' )== '9') echo ' selected="SELECTED" ' ?> >9</option>
                                    <option value="10" <?php if (get_bk_option( 'booking_client_cal_count' )== '10') echo ' selected="SELECTED" ' ?> >10</option>
                                    <option value="11" <?php if (get_bk_option( 'booking_client_cal_count' )== '11') echo ' selected="SELECTED" ' ?> >11</option>
                                    <option value="12" <?php if (get_bk_option( 'booking_client_cal_count' )== '12') echo ' selected="SELECTED" ' ?> >12</option>
                                </select>
                                </div>
                                <div class="description"><?php _e('Select number of month to show for calendar.', 'wpdev-booking'); ?></div>
                            </div>
                            <div class="field">
                                <div style="float:left;">
                                <label for="calendar_count"><?php _e('Show:', 'wpdev-booking'); ?></label>
                                <select id="calendar_or_form"  name="calendar_or_form" style="width:210px;" onchange="
                                javascript: if(this.value=='onlyform') document.getElementById('dates_for_form').style.display='block'; else  document.getElementById('dates_for_form').style.display='none';
                                ">
                                    <option value="form"><?php _e('Booking form with calendar', 'wpdev-booking'); ?></option>
                                    <option value="calendar"><?php _e('Only availability calendar', 'wpdev-booking'); ?></option>
                                    <?php if (class_exists('wpdev_bk_hotel')) { ?><option value="onlyform"><?php _e('Only booking form', 'wpdev-booking'); ?></option><?php } ?>
                                </select>
                                            <?php if (class_exists('wpdev_bk_hotel')) { ?><div style="float:right;margin-left:5px;display:none;" id="dates_for_form"> <?php _e('for','wpdev-booking'); ?>
                                                <select  id="year_popup"  name="year_popup" style="width:65px;" > <?php for ($mi = 2010; $mi < 2030; $mi++) {   echo '<option value="'.$mi.'" >'.$mi.'</option>';   } ?> </select> /
                                                <select  id="month_popup"  name="month_popup" style="width:50px;" > <?php for ($mi = 1; $mi < 13; $mi++) { if ($mi<10) {$mi ='0'.$mi;}  echo '<option value="'.$mi.'" >'.$mi.'</option>';   } ?> </select> /
                                                <select  id="day_popup"  name="day_popup" style="width:50px;" > <?php for ($mi = 1; $mi < 32; $mi++) { if ($mi<10) {$mi ='0'.$mi;}   echo '<option value="'.$mi.'" >'.$mi.'</option>';   } ?> </select> <?php _e('date','wpdev-booking'); ?>.
                                            </div><?php } ?>
                                </div>
                                <div style="height:1px;clear:both;"></div>
                                <div class="description"  style="float:left;margin-left:160px;width:650px;"><?php _e('Select what you want to show: booking form or only availability calendar.', 'wpdev-booking'); ?></div>
                            </div>

                            <?php make_bk_action('show_additional_arguments_for_shortcode'); ?>


                        </div>

                        <?php make_bk_action('show_insertion_popup_shortcode_for_bookingedit'); ?>

                        <input id="calendar_tag_name"  name="calendar_tag_name" class="input" type="hidden" >
                        <input id="calendar_tag_close"  name="calendar_tag_close" class="input" type="hidden" >
                    </div>
                </div>
            </div>
        </div>
        <div id="wpdev_bk-precacher">
            <img src="<?php echo WPDEV_BK_PLUGIN_URL.'/js/custom_buttons//img_dialog_ui/333333_7x7_arrow_right.gif'; ?>" alt="" />
            <img src="<?php echo WPDEV_BK_PLUGIN_URL.'/js/custom_buttons/img_dialog_ui/333333_7x7_arrow_down.gif'; ?>" alt="" />
        </div>
            <?php
        }

        // Hide TinyMCE buttons the user doesn't want to see + some misc editor CSS
        function custom_button_dialog_CSS() {
            global $user_ID;
            // Attempt to match the dialog box to the admin colors
            if ( 'classic' == get_user_option('admin_color', $user_ID) ) {
                $color = '#fff';
                $background = '#777';
            } else {
                $color = '#fff';
                $background = '#777';



            }?>
    <style type='text/css'>
        #wpdev_bk-precacher { display: none; }
        .ui-dialog-titlebar {
            color: <?php  echo $color; ?>;
            background: <?php  echo $background; ?>;
        }
            <?php foreach ($this->settings['custom_buttons'] as $type => $props) {
                echo  '#content_' . $this->prefix  . '_' . $type  . ' img.mceIcon{
                                                        width:16px;
                                                        height:16px;
                                                        margin:2px auto;0
                                                   }';
            }
            ?>
        .ui-dialog-title img{
            margin:3px auto;
            width:16px;
            height:16px;
        }
        #wpdev_bk-dialog .field {height:30px;
    line-height:25px;
    margin:0px 0px 5px;}
        #wpdev_bk-dialog .field label {float:left; padding-right:10px;width:155px;text-align:left; font-weight:bold;}
        #wpdev_bk-dialog .wpdev_bk-dialog-inputs {float:left;}
        #wpdev_bk-dialog input ,#wpdev_bk-dialog select {  width:120px;  }
        #wpdev_bk-dialog .input_check {width:10px; margin:5px 10px;text-align:center;}
        #wpdev_bk-dialog .dialog-wraper {float:left;width:100%;}
        #wpdev_bk-dialog .description {color:#666666;
    float:right;

    padding:0 5px;
    text-align:left;
    width:350px;}
       <?php make_bk_action('show_insertion_popup_css_for_tabs'); ?>
    </style>
            <?php
        }

        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   S U P P O R T     F U N C T I O N S     ">
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  S U P P O R T     F U N C T I O N S        ///////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Get array of images - icons inside of this directory
        function dirList ($directories) {

            // create an array to hold directory list
            $results = array();

            if (is_string($directories)) $directories = array($directories);
            foreach ($directories as $dir) {
                $directory = WPDEV_BK_PLUGIN_DIR . $dir ;
                // create a handler for the directory
                $handler = @opendir($directory);
                if ($handler !== false) {
                    // keep going until all files in directory have been read
                    while ($file = readdir($handler)) {

                        // if $file isn't this directory or its parent,
                        // add it to the results array
                        if ($file != '.' && $file != '..' && ( strpos($file, '.css' ) !== false ) )
                            $results[] = array($file, WPDEV_BK_PLUGIN_URL . $dir . $file,  ucfirst(strtolower( str_replace('.css', '', $file))) );
                    }

                    // tidy up: close the handler
                    closedir($handler);
                }
            }
            // done!
            return $results;

        }

        // WordPress' js_escape() won't allow <, >, or " -- instead it converts it to an HTML entity. This is a "fixed" function that's used when needed.
        function js_escape($text) {
            $safe_text = addslashes($text);
            $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
            $safe_text = preg_replace("/\r?\n/", "\\n", addslashes($safe_text));
            $safe_text = str_replace('\\\n', '\n', $safe_text);
            return apply_filters('js_escape', $safe_text, $text);
        }

        // Check if table exist
        function is_table_exists( $tablename ) {
            global $wpdb;
            if (strpos($tablename, $wpdb->prefix) ===false) $tablename = $wpdb->prefix . $tablename ;
            $sql_check_table = "
                SELECT COUNT(*) AS count
                FROM information_schema.tables
                WHERE table_schema = '". DB_NAME ."'
                AND table_name = '" . $tablename . "'";

            $res = $wpdb->get_results($sql_check_table);
            return $res[0]->count;

        }

        // Check if table exist
        function is_field_in_table_exists( $tablename , $fieldname) {
            global $wpdb;
            if (strpos($tablename, $wpdb->prefix) ===false) $tablename = $wpdb->prefix . $tablename ;
            $sql_check_table = "SHOW COLUMNS FROM " . $tablename ;

            $res = $wpdb->get_results($sql_check_table);

            foreach ($res as $fld) {
                if ($fld->Field == $fieldname) return 1;
            }

            return 0;

        }

        // Get version
        function get_version(){
            $version = 'free';
            if (class_exists('wpdev_bk_pro'))     $version = 'pro';
            if (class_exists('wpdev_bk_premium')) $version = 'premium';
            if (class_exists('wpdev_bk_premium_plus'))   $version = 'premium_plus';
            if (class_exists('wpdev_bk_hotel'))          $version = 'hotel';
            return $version;
        }

        // Check if nowday is tommorow from previosday
        function is_next_day($nowday, $previosday) {

            if ( empty($previosday) ) return false;

            $nowday_d = (date('m.d.Y',  mysql2date('U', $nowday ))  );
            $prior_day = (date('m.d.Y',  mysql2date('U', $previosday ))  );
            if ($prior_day == $nowday_d)    return true;                // if its the same date


            $previos_array = (date('m.d.Y',  mysql2date('U', $previosday ))  );
            $previos_array = explode('.',$previos_array);
            $prior_day =  date('m.d.Y' , mktime(0, 0, 0, $previos_array[0], ($previos_array[1]+1), $previos_array[2] ));


            if ($prior_day == $nowday_d)    return true;                // zavtra
            else                            return false;               // net
        }

        // Change date format
        function get_showing_date_format($mydate ) {
            $date_format = get_bk_option( 'booking_date_format');
            if ($date_format == '') $date_format = "d.m.Y";

            $time_format = get_bk_option( 'booking_time_format');
            if ( $time_format !== false  ) {
                $time_format = ' ' . $time_format;
                $my_time = date('H:i:s' , $mydate);
                if ($my_time == '00:00:00')     $time_format='';
            }
            else  $time_format='';

            // return date($date_format . $time_format , $mydate);
            return date_i18n($date_format,$mydate) .'<sup class="booking-table-time">' . date_i18n($time_format  , $mydate).'</sup>';

        }

        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   B O O K I N G s       A D M I N       F U N C T I O N s   ">
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  B  O O K I N G s       A D M I N       F U N C T I O N s       ///////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Write Admin booking table
        function booking_table($approved = 0, $bk_type = 'not_set', $is_show_table_header = true, $is_show_link_2_bk_res = false ) {

            global $wpdb;
//////debuge($approved , $bk_type );
            if ($bk_type === 'not_set')
                $bk_type = $this->get_default_type();

            $sql = "SELECT *

                        FROM ".$wpdb->prefix ."booking as bk

                        INNER JOIN ".$wpdb->prefix ."bookingdates as dt

                        ON    bk.booking_id = dt.booking_id

                        WHERE approved = $approved AND dt.booking_date >= CURDATE() ";

            if ($bk_type!=0) $sql .= "             AND bk.booking_type = ". $bk_type ."";

            $sql .= apply_bk_filter('get_sql_4_dates_from_other_types', ''  , $bk_type, $approved ); // Select bk ID from other TYPES, if they partly exist inside of DATES

            $sql .= "   ORDER BY bk.booking_id DESC, dt.booking_date ASC ";

            $result = $wpdb->get_results( $sql );
//debuge($result)            ;
            ///////////////////////////////////////////////////////////////////
            //transforms results into structure
            $result_structure = array();
            $old_id = '';
            $ns = -1;
            $last_date = $last_show_date = '';
            foreach ($result as $res) {

                if ($old_id == $res->booking_id ) { // add only dates

                    $result_structure[$ns]['dates'][] = $res->booking_date;
                    if (isset( $res->type_id )) $result_structure[$ns]['type_id'][] = $res->type_id;
                    else                        $result_structure[$ns]['type_id'][] =  '' ;

                } else { // new record
                    $ns++;
                    $old_id = $res->booking_id;
                    $result_structure[$ns]['dates'][] = $res->booking_date;
                    if (isset($res->type_id))   $result_structure[$ns]['type_id'][] = $res->type_id;
                    else                        $result_structure[$ns]['type_id'][] = '';
                    $result_structure[$ns]['id'] = $res->booking_id;
                    $cont = get_form_content($res->form, $res->booking_type);//$bk_type);
                    $search = array ("'(<br[ ]?[/]?>)+'si","'(<p[ ]?[/]?>)+'si","'(<div[ ]?[/]?>)+'si");
                    $replace = array ("&nbsp;&nbsp;"," &nbsp; "," &nbsp; ");
                    $cont['content'] = preg_replace($search, $replace, $cont['content']);
                    $result_structure[$ns]['form'] = $cont;

                    if (isset($res->remark))   $result_structure[$ns]['remark'] = $res->remark;
                    else                       $result_structure[$ns]['remark'] = '';
                    if (isset($res->pay_status))  $result_structure[$ns]['pay_status'] = $res->pay_status;
                    else                          $result_structure[$ns]['pay_status'] = '';
                    if (isset($res->cost))        $result_structure[$ns]['cost'] = $res->cost;
                    else                          $result_structure[$ns]['cost'] =  '';

                    $result_structure[$ns]['booking_type'] = $res->booking_type;
                    if (isset($res->hash)) $result_structure[$ns]['hash'] = $res->hash;
                    else                   $result_structure[$ns]['hash'] = '';
                    if (isset($res->pay_request)) $result_structure[$ns]['pay_request'] = $res->pay_request;
                    else                          $result_structure[$ns]['pay_request'] = 0;
                }
            }
            ///////////////////////////////////////////////////////////////////
            // Get short days
            foreach ($result_structure as $key=>$res) {
                $last_day = '';
                $last_show_day = '';
                $short_days = array();
                $short_days_type_id = array();

                foreach ($res['dates'] as $dte) {

                    if (empty($last_day)) { // First date
                        $short_days[]= $dte;
                        $last_show_day = $dte;
                    } else {                // All other days
                        if ( $this->is_next_day( $dte ,$last_day) ) {
                            if ($last_show_day != '-') $short_days[]= '-';
                            $last_show_day = '-';
                        } else {
                            if ($last_show_day !=$last_day) $short_days[]= $last_day;
                            $short_days[]= ',';
                            $short_days[]= $dte;
                            $last_show_day = $dte;
                        }
                    }
                    $last_day = $dte;
                }
                if($last_show_day != $dte) $short_days[]= $dte;
                $result_structure[$key]['short_days'] = $short_days;

                for ($sd = 0; $sd < count($short_days); $sd++) {
                    for ($ad = 0; $ad < count($res['dates']); $ad++) {

                        if ( $short_days[$sd] == $res['dates'][$ad] )
                             $short_days_type_id[$sd] = $res['type_id'][$ad];
                        else $short_days_type_id[$sd] = false;
                    }
                }

                $result_structure[$key]['short_days_type_id'] = $short_days_type_id;
            }
            ///////////////////////////////////////////////////////////////////
            // Sort this structure
            $sorted_structure = array();
            // Sort type
            if (isset($_GET['booking_sort_order'])) {
                if ($_GET['booking_sort_order'] == 'date') {
                    $sort_type = 'date';
                    $sort_order = 'ASC';
                }
                if ($_GET['booking_sort_order'] == 'date_desc') {
                    $sort_type = 'date';
                    $sort_order = 'DESC';
                }
                if ($_GET['booking_sort_order'] == 'id') {
                    $sort_type = 'id';
                    $sort_order = 'ASC';
                }
                if ($_GET['booking_sort_order'] == 'id_desc') {
                    $sort_type = 'id';
                    $sort_order = 'DESC';
                }
                if ($_GET['booking_sort_order'] == 'name') {
                    $sort_type = 'name';
                    $sort_order = 'ASC';
                }
                if ($_GET['booking_sort_order'] == 'name_desc') {
                    $sort_type = 'name';
                    $sort_order = 'DESC';
                }
                if ($_GET['booking_sort_order'] == 'email') {
                    $sort_type = 'email';
                    $sort_order = 'ASC';
                }
                if ($_GET['booking_sort_order'] == 'email_desc') {
                    $sort_type = 'email';
                    $sort_order = 'DESC';
                }
                if ($_GET['booking_sort_order'] == 'visitors') {
                    $sort_type = 'visitors';
                    $sort_order = 'ASC';
                }
                if ($_GET['booking_sort_order'] == 'visitors_desc') {
                    $sort_type = 'visitors';
                    $sort_order = 'DESC';
                }
            } else {
                $sort_type = 'id';
                $sort_order = 'DESC';
            }
//debuge('$result_structure',$result_structure);
            foreach ($result_structure as $key=>$value) {
                switch ($sort_type) {
                    case 'date':      if ( ! empty($sorted_structure[$value['dates'][0]])) $sorted_structure[$value['dates'][0] . (time() * rand()) ] = $value; else $sorted_structure[$value['dates'][0]] = $value;
                        break;
                    case 'name':     if ( ! empty($sorted_structure[$value['form']['name']])) $sorted_structure[$value['form']['name'] . (time() * rand()) ] = $value; else $sorted_structure[strtolower($value['form']['name'])] = $value;
                        break;
                    case 'email':    if ( ! empty($sorted_structure[$value['form']['email']])) $sorted_structure[$value['form']['email'] . (time() * rand()) ] = $value; else $sorted_structure[strtolower($value['form']['email'])] = $value;
                        break;
                    case 'visitors': if ( ! empty($sorted_structure[$value['form']['visitors']])) $sorted_structure[$value['form']['visitors'] . (time() * rand()) ] = $value; else $sorted_structure[$value['form']['visitors']] = $value;
                        break;
                    case 'id':
                    default: $sorted_structure[$value['id']] = $value;
                        break;
                }
            }
//debuge('$sorted_structure',$sorted_structure);             die;
            if ($sort_order == 'DESC') krsort($sorted_structure );
            else                       ksort($sorted_structure );

//debuge($sorted_structure)            ;
            $old_id = '';
            $alternative_color = '';
            if ($approved == 0) {
                $outColor = '#FFBB45';
                $outColorClass = '0';
            }
            if ($approved == 1) {
                $outColor = '#99bbee';
                $outColorClass = '1';
            }
            $booking_date_view_type = get_bk_option( 'booking_date_view_type');
            if ($booking_date_view_type == 'short') {
                $wide_days_class = ' hide_dates_view ';
                $short_days_class = '';
            }
            else {
                $wide_days_class = '';
                $short_days_class = ' hide_dates_view ';
            }


            if (count($sorted_structure)>0) {
                $sort_url = '<a style="color:#fff;" href="admin.php?page='. WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME. 'wpdev-booking&booking_type=' .$bk_type. '&booking_sort_order=';
                $arr_asc  = '<span style="font-size:17px;color:#fff;"> &darr; </span>';
                $arr_desc = '<span style="font-size:17px;color:#fff;"> &uarr; </span>';
                $arr_asc  = '<img src="'.WPDEV_BK_PLUGIN_URL.'/img/arrow-down.png" width="12" height="12" style="margin:0 0px -3px 0;">';
                $arr_desc = '<img src="'.WPDEV_BK_PLUGIN_URL.'/img/arrow-up.png" width="12" height="12" style="margin:0 0px -3px 0;">';

                ?>
                <table class='booking_table' cellspacing="0"  <?php if (! $is_show_table_header) { echo 'style="margin-top:-3px;"'; } ?>  >
                <?php if ($is_show_table_header) { ?>
                    <tr>
                        <th style="width:15px;"> <input type="checkbox" onclick="javascript:setCheckBoxInTable(this.checked, 'booking_appr<?php echo $approved; ?>');" class="booking_allappr<?php echo $approved; ?>" id="booking_allappr_<?php echo $approved; ?>"  name="booking_allappr_<?php echo $approved; ?>" </th>
                        <th style="width:35px;"><?php echo $sort_url; ?><?php
                if (isset($_GET['booking_sort_order'])) {
                    if ($_GET['booking_sort_order']=='id')  echo 'id_desc';    else echo 'id';
                }
                else echo 'id'; ?>"><?php _e('ID', 'wpdev-booking'); ?></a><?php
                if ( ($_GET['booking_sort_order']=='id')  )      echo $arr_asc;
                if ( ($_GET['booking_sort_order']=='id_desc') || (! isset( $_GET['booking_sort_order']) )  ) echo $arr_desc;
                ?></th>
                        <th style="width:43%;"><?php _e('Info', 'wpdev-booking'); ?>
                <?php
                echo '<span style="font-size:10px;">(';

                if (isset($_GET['booking_sort_order'])) {
                    if ($_GET['booking_sort_order']=='name') $srt_url_tp='name_desc'; else $srt_url_tp='name';
                }
                else $srt_url_tp='name';
                echo $sort_url.$srt_url_tp.'">Name' . "</a> " ;
                if ($_GET['booking_sort_order']=='name') {
                    echo $arr_asc;
                } if

                ($_GET['booking_sort_order']=='name_desc') {
                    echo $arr_desc;
                }

                if (isset($_GET['booking_sort_order'])) {
                    if ($_GET['booking_sort_order']=='email') $srt_url_tp='email_desc'; else $srt_url_tp='email';
                }
                else $srt_url_tp='email';
                echo $sort_url.$srt_url_tp.'"> Email'. "</a> " ;
                if ($_GET['booking_sort_order']=='email') {
                    echo $arr_asc;
                } if

                ($_GET['booking_sort_order']=='email_desc') {
                    echo $arr_desc;
                }

                // if (isset($_GET['booking_sort_order'])){ if ($_GET['booking_sort_order']=='visitors') $srt_url_tp='visitors_desc'; else $srt_url_tp='visitors';}
                // else $srt_url_tp='visitors';
                // echo $sort_url.$srt_url_tp.'"> Visitor number' . "</a> " ;if ($_GET['booking_sort_order']=='visitors') {echo $arr_asc;} if ($_GET['booking_sort_order']=='visitors_desc') {echo $arr_desc;}
                echo ")</span>";
                ?>
                        </th>
                        <th><?php echo $sort_url; ?><?php
                if (isset($_GET['booking_sort_order'])) {
                    if ($_GET['booking_sort_order']=='date') echo 'date_desc'; else echo 'date';
                }
                else echo 'date_desc'; ?>"><?php _e('Dates', 'wpdev-booking'); ?></a><?php
                if ( ($_GET['booking_sort_order']=='date')  ) echo $arr_asc;
                if ($_GET['booking_sort_order']=='date_desc') echo $arr_desc;
                ?><div style="float:right;">
                            <span  class="showwidedates<?php echo $short_days_class; ?>" style="cursor: pointer;text-decoration: none;font-size:10px;" onclick="javascript:showwidedates_at_admin_side();"><img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/arrow-left.png" width="16" height="16" style="margin:0 5px -4px 0;"><?php _e('Wide days view', 'wpdev-booking'); ?><img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/arrow-right.png" width="16" height="16"  style="margin:0 0px -4px 5px;"></span>
                            <span class="showshortdates<?php echo $wide_days_class; ?>" style="cursor: pointer;text-decoration: none;font-size:10px;"  onclick="javascript:showshortdates_at_admin_side();"><img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/arrow-right.png" width="16" height="16" style="margin:0 5px -4px 0;"><?php _e('Short days view', 'wpdev-booking'); ?><img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/arrow-left.png" width="16" height="16"  style="margin:0 0px -4px 5px;"></span>
                   </div>
                        </th>
                <?php make_bk_action('show_booking_table_status_header'); ?>
                        <th style="width:45px;"><?php _e('Actions', 'wpdev-booking'); ?></th>
                    </tr>
                <?php }



                $type_items = array();
                if( $this->wpdev_bk_pro !== false ) {
                    $types_list = $this->wpdev_bk_pro->get_booking_types();

                    foreach ($types_list as $type_item) {
                        $type_items[ $type_item->id ] = $type_item->title;
                    }
                }
//debuge($sorted_structure)                ;
                foreach ($sorted_structure as $bk) {

                    if ($bk_type==0)
                        if ( ! isset( $type_items[ $bk['booking_type'] ] ) ) {
                            continue;
                        }

                    if(isset($_GET['moderate_id'])) {
                        if ($bk['id'] !== $_GET['moderate_id']) {
                            if ( $alternative_color == '')  $alternative_color = ' class="alternative_color moderate_blend" ';
                            else                            $alternative_color = ' class="moderate_blend" ';
                        }
                    }
                    else {
                        if ( $alternative_color == '')  $alternative_color = ' class="alternative_color" ';
                        else                            $alternative_color = '';
                    }
                    // debuge($bk);die;
                    ?>
                            <tr id="booking_row<?php  echo $bk['id']  ?>"  <?php if ( (isset($_GET['booking_id_selection'])) && ($_GET['booking_id_selection'] ==$bk['id']) ) echo ' class="raw_after_editing" '; ?>  >
                                <td <?php echo $alternative_color; ?> >
                                    <input type="checkbox" class="booking_appr<?php echo $approved; ?>" id="booking_appr_<?php  echo $bk['id']  ?>"  name="booking_appr_<?php  echo $bk['id']  ?>"
                    <?php  if ( (isset($_GET['moderate_id'])) && ($bk['id'] == $_GET['moderate_id']) ) echo 'checked="checked"';  ?>  />
                                </td>
                                <td <?php echo $alternative_color; ?> style="text-align:center;" > <?php make_bk_action('show_remark_hint',$bk['id'], $bk);
                    echo $bk['id'];  ?> </td>
                                <td <?php echo $alternative_color; ?> >
                                    <div style="display:block;font-size:11px;line-height:20px;" id="full<?php  echo $bk['id'];  ?>" >
                    <?php echo $bk['form']['content']; ?>
                                    </div>
                                </td>
                                <td <?php echo $alternative_color; ?> style="text-align:center;"  >
                                    <div id="wide_dates_view<?php echo $bk['id'];?>" class="wide_dates_view<?php echo $wide_days_class; ?>"  >
                    <?php
                    $ad = -1;
                    foreach ($bk['dates'] as $date_key => $bkdate) { $ad++;
                        $date_class = ( date('m',  mysql2date('U',$bkdate)) + 0 ) . '-' . ( date('d',  mysql2date('U',$bkdate)) + 0 ) . '-' . ( date('Y',  mysql2date('U',$bkdate)) + 0 );  ?>
                                          <span class="<?php echo "adate-" . $date_class; ?>"><a href="#" class="booking_overmause<?php echo $outColorClass; ?>"
                                                                                       onmouseover="javascript:highlightDay('<?php echo "cal4date-" . $date_class; ?>','#ff0000');"
                                                                                       onmouseout="javascript:highlightDay('<?php echo "cal4date-" . $date_class; ?>','<?php echo $outColor; ?>');"
                                                                                       ><?php echo $this->get_showing_date_format( mysql2date('U',$bkdate) );?></a></span><?php
                        // These days belong to other resource
                        make_bk_action('show_diferent_bk_resource_of_this_date', $bk['type_id'][$ad], $bk['booking_type'], $bk_type, $type_items, $outColorClass );
                        //make_bk_action('show_subtype_num',$bk['booking_type'], $bk['id'], $bkdate);
                        if ($date_key != (count($bk['dates'])-1)) echo ", ";
                    }
                    echo '</div><div id="short_dates_view'.$bk['id'].'"  class="short_dates_view'. $short_days_class. '"  >';
                    // SHORT DAYS ECHO
                    $sd = -1;
                    foreach ($bk['short_days'] as $bkdate) { $sd++;  //echo $bkdate;   continue;
                        if ((trim($bkdate) != ',') && (trim($bkdate) != '-')) { //eco date
                            $date_class = ( date('m',  mysql2date('U',$bkdate)) + 0 ) . '-' . ( date('d',  mysql2date('U',$bkdate)) + 0 ) . '-' . ( date('Y',  mysql2date('U',$bkdate)) + 0 );

                            echo '<span class="adate-'.$date_class.'"><a href="#" class="booking_overmause'. $outColorClass.'"'.
                                    ' onmouseover="javascript:highlightDay(\'cal4date-' . $date_class. '\',\'#ff0000\');" ' .
                                    ' onmouseout="javascript:highlightDay(\'cal4date-' . $date_class. '\',\''.$outColor .'\');" ' . ' >' . $this->get_showing_date_format( mysql2date('U',$bkdate) ) .
                                    '</a></span>';
                            // These days belong to other resource
                            make_bk_action('show_diferent_bk_resource_of_this_date', $bk['short_days_type_id'][$sd], $bk['booking_type'], $bk_type, $type_items, $outColorClass );

                            //echo apply_bk_filter('filter_subtype_num','',$bk['booking_type'], $bk['id'], $bkdate);
                            echo ' ';
                        } else { // echo separator
                            echo '<span class="date_tire">'.$bkdate.' </span>' ;
                        }
                    }
                    ?>
                                    </div>
                                </td>
                    <?php make_bk_action('show_payment_status',$bk['id'], $bk, $alternative_color); ?>
                                <td <?php echo $alternative_color; ?> style="text-align:center;"  >
                    <?php
                    if ( ($bk_type==0) || ($is_show_link_2_bk_res === true ) )
                        if (isset($type_items[ $bk['booking_type'] ]))
                            echo '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking'.'&booking_type='.$bk['booking_type'].'" class="bktypetitle" style="line-height:25px;background-color:#fff;padding:2px 5px;font-size:10px;white-space:nowrap;">' . $type_items[ $bk['booking_type'] ]  . '</a>';

                    if( $this->wpdev_bk_pro !== false ) { ?>
                                     <a href="javascript:;" onclick='javascript:location.href=&quot;admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-reservation&booking_type=<?php echo $bk['booking_type']; ?>&booking_hash=<?php echo $bk['hash']; ?>&parent_res=1&quot;;'><img  src="<?php  echo  WPDEV_BK_PLUGIN_URL . '/img/edit_type.png'; ?>" class="tipcy" title='<?php echo __('Edit reservation','wpdev-booking'); ?>' /></a>
                        <?php } else { ?>
                                     <a href="javascript:;" onclick='javascript:openModalWindow(&quot;modal_content1&quot;);' ><img  src="<?php  echo  WPDEV_BK_PLUGIN_URL . '/img/edit_type.png'; ?>" class="tipcy" title='<?php echo __('Edit reservation','wpdev-booking'); ?>' /></a>
                        <?php }

                    //remark
                    if( $this->wpdev_bk_pro !== false ) { ?>
                                     <a href="javascript:;" onclick='javascript:if (document.getElementById(&quot;remark_row<?php echo $bk['id'];?>&quot;).style.display==&quot;block&quot;) document.getElementById(&quot;remark_row<?php echo $bk['id'];?>&quot;).style.display=&quot;none&quot;; else document.getElementById(&quot;remark_row<?php echo $bk['id'];?>&quot;).style.display=&quot;block&quot;; '><img  src="<?php  echo  WPDEV_BK_PLUGIN_URL . '/img/notes.png'; ?>" class="tipcy"  title='<?php echo __('Edit notes','wpdev-booking'); ?>' /></a>

                        <?php } else { ?>
                                     <a href="javascript:;" onclick='javascript:openModalWindow(&quot;modal_content1&quot;);' ><img  src="<?php  echo  WPDEV_BK_PLUGIN_URL . '/img/notes.png'; ?>" class="tipcy" title='<?php echo __('Edit Notes','wpdev-booking'); ?>' /></a>
                        <?php }
                    //echo "<input type='button' class='button' value='".__('Remark','wpdev-booking')."' onclick='javascript:openModalWindow(&quot;modal_content1&quot;);'>";

                    make_bk_action('show_remark_editing_field',$bk['id'],$bk,"height:1px;padding:0px;margin:0px;border:none;");
                    ?>
                                </td></tr>
                    <?php
                } ?> </table>
                <?php
                return true;
            } else {
                return false;
            }

        }

        // Get dates
        function get_dates ($approved = 'all', $bk_type = 1, $additional_bk_types= array() ) {

            make_bk_action('check_pending_not_paid_auto_cancell_bookings', $bk_type );

            if ( count($additional_bk_types)>0 ) $bk_type_additional = $bk_type .',' . implode(',', $additional_bk_types);
            else                                 $bk_type_additional = $bk_type;

            global $wpdb;
            $dates_array = $time_array = array();
            if ($approved == 'admin_blank') {
                $sql_req = "SELECT DISTINCT dt.booking_date

                         FROM ".$wpdb->prefix ."bookingdates as dt

                         INNER JOIN ".$wpdb->prefix ."booking as bk

                         ON    bk.booking_id = dt.booking_id

                         WHERE  dt.booking_date >= CURDATE()  AND bk.booking_type IN ($bk_type_additional) AND bk.form like '%admin@blank.com%'

                         ORDER BY dt.booking_date" ;
                $dates_approve = $wpdb->get_results( $sql_req );
            }else {
                if ($approved == 'all')
                    $sql_req = apply_bk_filter('get_bk_dates_sql', "SELECT DISTINCT dt.booking_date

                         FROM ".$wpdb->prefix ."bookingdates as dt

                         INNER JOIN ".$wpdb->prefix ."booking as bk

                         ON    bk.booking_id = dt.booking_id

                         WHERE  dt.booking_date >= CURDATE()  AND bk.booking_type IN ($bk_type_additional)

                         ORDER BY dt.booking_date", $bk_type_additional, 'all' );

                else
                    $sql_req = apply_bk_filter('get_bk_dates_sql', "SELECT DISTINCT dt.booking_date

                         FROM ".$wpdb->prefix ."bookingdates as dt

                         INNER JOIN ".$wpdb->prefix ."booking as bk

                         ON    bk.booking_id = dt.booking_id

                         WHERE  dt.approved = $approved AND dt.booking_date >= CURDATE() AND bk.booking_type IN ($bk_type_additional)

                         ORDER BY dt.booking_date", $bk_type_additional, $approved );

                $dates_approve = apply_bk_filter('get_bk_dates', $wpdb->get_results( $sql_req ), $approved, 0,$bk_type );
            }
//debuge($sql_req, $dates_approve);
            // loop with all dates which is selected by someone
            foreach ($dates_approve as $my_date) {
                $my_date = explode(' ',$my_date->booking_date);

                $my_dt = explode('-',$my_date[0]);
                $my_tm = explode(':',$my_date[1]);

                array_push( $dates_array , $my_dt );
                array_push( $time_array , $my_tm );
            }
            return    array($dates_array,$time_array);  // $dates_array;
        }

        // Generate booking CAPTCHA fields  for booking form
        function createCapthaContent($bk_tp) {
            if (  get_bk_option( 'booking_is_use_captcha' ) !== 'On'  ) return '';
            else {
                $this->captcha_instance->cleanup(1);

                $word = $this->captcha_instance->generate_random_word();
                $prefix = mt_rand();
                $this->captcha_instance->generate_image($prefix, $word);

                $filename = $prefix . '.png';
                $captcha_url = WPDEV_BK_PLUGIN_URL . '/js/captcha/tmp/' .$filename;
                $html  = '<input type="text" class="captachinput" value="" name="captcha_input'.$bk_tp.'" id="captcha_input'.$bk_tp.'" />';
                $html .= '<img class="captcha_img"  id="captcha_img' . $bk_tp . '" alt="captcha" src="' . $captcha_url . '" />';
                $ref = substr($filename, 0, strrpos($filename, '.'));
                $html = '<input type="hidden" name="wpdev_captcha_challenge_' . $bk_tp . '"  id="wpdev_captcha_challenge_' . $bk_tp . '" value="' . $ref . '" />'
                        . $html
                        . '<div id="captcha_msg'.$bk_tp.'" class="wpdev-help-message" ></div>';
                return $html;
            }
        }

        // Get default Booking resource
        function get_default_type() {
            if( $this->wpdev_bk_pro !== false ) {
                if (( isset( $_GET['booking_type'] )  )  && ($_GET['booking_type'] != '')) $bk_type = $_GET['booking_type'];
                else $bk_type = $this->wpdev_bk_pro->get_default_booking_resource_id();
            } else $bk_type =1;
            return $bk_type;
        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   A D M I N    M E N U    P A G E S    ">
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //  A D M I N    M E N U    P A G E S
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // CONTENT OF THE ADMIN PAGE
        function content_of_booking_page () {

            $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'check_for_active_users');
            if (! $is_can) return false;


            if ( ! isset($_GET['booking_sort_order']) ) {

                $booking_sort_order = get_bk_option( 'booking_sort_order');
                $booking_sort_order_direction = get_bk_option( 'booking_sort_order_direction');

                if ( $booking_sort_order == 'date') {
                    $sort_type = 'date';
                    if( $booking_sort_order_direction == 'DESC') {
                        $sort_type .= '_desc';
                    }
                }

                if ( $booking_sort_order == 'id') {
                    $sort_type = 'id';
                    if( $booking_sort_order_direction == 'DESC') {
                        $sort_type .= '_desc';
                    }
                }

                if ( $booking_sort_order == 'name') {
                    $sort_type = 'name';
                    if( $booking_sort_order_direction == 'DESC') {
                        $sort_type .= '_desc';
                    }
                }

                if ( $booking_sort_order == 'email') {
                    $sort_type = 'email';
                    if( $booking_sort_order_direction == 'DESC') {
                        $sort_type .= '_desc';
                    }
                }


                $_GET['booking_sort_order']=$sort_type;
            }

            if ( ! isset($_GET['booking_type']) ) {
                $default_booking_resource = get_bk_option( 'booking_default_booking_resource');

                if ((isset($default_booking_resource)) && ($default_booking_resource !== false)) {
                    $_GET['booking_type']=  $default_booking_resource;
//debuge($default_booking_resource);
                    // Check if this resource parent and has some additional childs if so then assign to parent_res=1
                    make_bk_action('check_if_bk_res_parent_with_childs_set_parent_res', $default_booking_resource  );
                }
            }


            if (  isset($_GET['booking_type']) ) {
                $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, $_GET['booking_type']);
                if ( !$is_can) { return ; }
            }

            ?>

<div id="ajax_working"></div>

<div style="display:none;" id="wpdev-bk-dialog-container"><div id="wpdev-bk-dialog" ><div id="wpdev-bk-dialog-content" >

            <!--div id="modal_content1" style="display:none;" class="modal_content_text" >
                <iframe src="http://onlinebookingcalendar.net/purchase/#content" style="border:1px solid red; width:1000px;height:500px;padding:0px;margin:0px;"></iframe>
            </div-->

            <div id="modal_content1" style="display:none;" class="modal_content_text" style="" >
            <p style="line-height:25px;text-align:left;"><?php printf(__('This functionality exist at other version of Booking Calendar: %sProfessional%s, %sPremium%s , %sPremium Plus%s or %sHotel Edition%s.','wpdev-booking'),'<a href="http://onlinebookingcalendar.net/purchase/"  class="color_pro" target="_blank">','</a>','<a href="http://onlinebookingcalendar.net/purchase/"  class="color_premium" target="_blank">','</a>','<a href="http://onlinebookingcalendar.net/purchase/"  class="color_premium_plus" target="_blank">','</a>','<a href="http://onlinebookingcalendar.net/purchase/" class="color_hotel" target="_blank">','</a>'); ?></p>
            <p style="line-height:25px;text-align:left;">Please, check feature list for each versions <a href="http://onlinebookingcalendar.com/features/" target="_blank">here</a></p>
            <p style="line-height:25px;text-align:left;">You can test <a href="http://onlinebookingcalendar.com/demo/" target="_blank">online demo</a> of  each versions of Booking Calendar <a href="http://onlinebookingcalendar.com/demo/" target="_blank">here<a></p>
            <p style="line-height:25px;text-align:center;padding-top:15px;"><a href="http://onlinebookingcalendar.net/purchase/" target="_blank" class="buttonlinktext">Buy now</a></p>
            </div>

            <?php make_bk_action('write_content_for_popups' );  ?>

</div></div></div>

<script type="text/javascript">

    jWPDev(document).ready( function(){
        setTimeout("prepare_highlight();",1000);
    });

    function prepare_highlight(){
        jWPDev("td.datepick-days-cell").mouseover(
        function(){
            jWPDev('span').removeClass('admin_calendar_selection');
            td_class = jWPDev(this).attr("class");
            var start_pos = td_class.indexOf("cal4date-");
            if (start_pos > 0) {
                var end_pos = td_class.indexOf(" ",start_pos);
                if (end_pos == -1)  end_pos = td_class.length;
                var td_class_new = td_class.substr((start_pos+9), (end_pos - start_pos-9) );

                jWPDev('span.adate-'+td_class_new).addClass('admin_calendar_selection');
            }
        }
    );
    }

</script>
<div class="clear" style="height:1px;"></div>

            <?php if( $this->wpdev_bk_pro !== false ) $this->wpdev_bk_pro->booking_types_pages();
            else {
                /*  ?>    <div id="help_screeen_pro">
    <div style="clear:both;"></div>
    <div style="margin:0px 5px auto;text-align:left;">
        <img style="margin:0px 0px 0px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/top_line.png" >
    </div>
    <div class="clear" style="height:5px;border-bottom:1px solid #cccccc;"></div>
</div>
<script type="text/javascript">jWPDev('#help_screeen_pro').animate({opacity:1},5000).fadeOut(2000);</script>
                <?php/**/

                ?>  <div style="height:auto;">
                <div class="topmenuitemborder selected_bk_typenew" id="" style="">
                <?php echo '<a class="bktypetitlenew" style="margin:0px;"  href="#" title="'.__('Standard', 'wpdev-booking').'"    >'  .__('Standard', 'wpdev-booking')  . '</a>'; ?>
                </div>
                <div class="topmenuitemborder " id="bk_type_plus" style="float:left;">
                <?php echo '<a class="bktypetitlenew tipcy0" style="font-size:12px;"  href="#" onMouseDown="openModalWindow(&quot;modal_content1&quot;);"  title="'.__('Add new booking resource', 'wpdev-booking').'"    >' .  '+ ' .__('Add new booking resource', 'wpdev-booking')  . '</a>'; ?>
                </div>
            </div>
            <div class="clear topmenuitemseparatorv" style="height:0px;clear:both;" ></div>
                <?php

                //echo '<div style="float:right;height:24px;padding:0px;font-size:12px;font-weight:bold;line-height:24px;margin:-24px 0 0;" id="bk_type_plus"><div style="float:left;width:240px;height:20px; padding:0px 3px; vertical-align:top;"><a href="#" onMouseDown="openModalWindow(&quot;modal_content1&quot;);" style="border-color:#455;border:2px solid #899;padding:3px 13px;"   class="bktypetitle" >+ '.__('Add new booking resource', 'wpdev-booking').'  </a></div></div>';
//              echo '<div style="float:right;height:24px;padding:0px 2px 0px;font-size:12px;font-weight:bold;line-height:50px;" id="bk_type_plus"><a href="#" onMouseDown="openModalWindow(&quot;modal_content1&quot;);" style="border-color:#455;border:2px solid ;padding:3px 13px 3px 35px; "   class="bktypetitle" ><div style="font-size:17px;float:left;margin:0px -34px 0px 0px;padding:0 0 0 20px;">+</div> '.__('Add new booking resource', 'wpdev-booking').'  </a></div>';
                //echo '<div class="clear" style="height:20px;border-bottom:1px solid #cccccc;clear:both;"></div>';
            }
            ?>
<div id="ajax_respond"></div>


            <?php
//TODO: HERE_EDITED
            if ( ( isset( $_GET['booking_type'] )  ) && ($_GET['booking_type']=='-1') && ( $this->wpdev_bk_pro !== false )) {
                make_bk_action('show_all_bookings_at_one_page' );
                return;
            }

            if ( ( isset( $_GET['parent_res'] )  ) && ($_GET['parent_res']=='1') && ( $this->get_version() == 'hotel' )) {
                make_bk_action('show_all_bookings_for_parent_resource', $_GET['booking_type'] );
                return;
            }
            if  ( ! isset( $_GET['booking_type'] )  )
                if ( class_exists('wpdev_bk_multiuser')) {  // If MultiUser so
                    $bk_multiuser = apply_bk_filter('get_default_bk_resource_for_user',false);
                    if ($bk_multiuser == false) return;
                }
            ?>


<div id="table_for_approve">
    <div class="selected_mark"></div><div style="float:right;"><?php
            $bk_type = $this->get_default_type();
            make_bk_action('show_subtype_filter',$bk_type);
            ?></div><h2><?php _e('Pending', 'wpdev-booking'); ?></h2>
            <?php  $res1 = $this->booking_table(0); $user = wp_get_current_user(); $user_bk_id = $user->ID; ?>
    <div style="float:left;">
        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Approve', 'wpdev-booking'); ?>" onclick="javascript:bookingApprove(0,0, <?php echo $user_bk_id; ?>);" />
        <!--input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Delete', 'wpdev-booking'); ?>" onclick="javascript:bookingApprove(2,0, <?php echo $user_bk_id; ?>);" /-->
        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Cancel', 'wpdev-booking'); ?>"  onclick="javascript:bookingApprove(1,0, <?php echo $user_bk_id; ?>);"/>
    </div>
    <div style="float:left;border:none;margin-top:18px;">
        <div for="denyreason" class="inside_hint"><?php _e('Reason of cancellation here', 'wpdev-booking'); ?><br/></div>
        <input type="text" style="width:350px;" class="has-inside-hint" name="denyreason" id="denyreason" value="">
    </div>
    <div class="clear" style="height:1px;"></div>
    <div style="float:left;border:none;margin:-15px 0px 0px 10px; font-size: 11px;color:#777;font-style: italic;">
            <input type="checkbox" checked="CHECKED" id="is_send_email_for_pending"> <label><?php _e('Send email notification to customer about this operation','wpdev-booking') ?></label>
    </div>
    <div id="admin_bk_messages0"> </div>
    <div class="clear" style="height:1px;"></div>
</div>

            <?php if (! $res1) {
                echo '<div id="no-reservations"  class="warning_message textleft">';
                printf(__('%sThere are no reservations.%s Please, press this %s button, when you edit %sposts%s or %spage%s. %sAfter entering booking you can wait for making  reservation by somebody or you can make reservation %shere%s.', 'wpdev-booking'), '<b>', '</b><br>', '<img src="'.$this->icon_button_url.'" width="16" height="16" align="top">', '<a href="post-new.php">', '</a>', '<a href="page-new.php">', '</a>', '<br>', '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-reservation">', '</a>' );
                echo '</div><div style="clear:both;height:10px;"></div>';
            } ?>

            <?php if (! $res1) { ?><script type="text/javascript">document.getElementById('table_for_approve').style.display="none";jWPDev('#no-reservations').animate({opacity:1},20000).fadeOut(2000);</script><?php } ?>
            <?php if (isset($_GET['booking_type'] ) ) if ($_GET['booking_type']=='0') {
                ?><script type="text/javascript">jWPDev('#table_for_approve h2').html('<?php _e('All incoming bookings','wpdev-booking'); ?>');</script> <?php
                return;
            }?>
            <?php //$bk_type = (string) $bk_type; debuge($bk_type);die;
            /*
            if ( isset($_GET['booking_type']) ) {
                $bk_type = $_GET['booking_type'];
            } else {
                $bk_type = '1';
            }/**/
            ?>
    <div id="changing_count_of_calendars" style="-moz-border-radius:5px 5px 5px 5px;
-moz-box-shadow:1px 1px 0 #FFFFFF;
border:1px solid #D7D7D7;
color:#89898B;
float:right;
font-size:12px;
<?php if ( $res1) { echo "margin-top:-35px;"; } ?>
padding:2px 1px 2px 7px;
text-shadow:-1px 1px 0 #FFFFFF;">
        <span style="font-style:italic;"><?php _e('Number of calendars:','wpdev-booking') ?></span>
        <select id="admin_cal_count" name="admin_cal_count" onchange="setNumerOfCalendarsAtAdminSide(<?php echo get_bk_current_user_id(); ?>,this.value);">
            <?php
            $cal_count = get_user_option( 'booking_admin_calendar_count');
            if ($cal_count === false) $cal_count = 2;
            for ($mm = 1; $mm < 13; $mm++) { ?>
                                            <option <?php if($cal_count == $mm ) echo "selected"; ?> value="<?php echo $mm; ?>"><?php echo $mm  ?></option>
                <?php } ?>
                                      </select>
</div>
<div id="calendar_booking<?php echo $bk_type; ?>"></div><br><textarea rows="3" cols="50" id="date_booking<?php echo $bk_type; ?>" name="date_booking<?php echo $bk_type; ?>" style="display:none;"></textarea>
<div class="clear" style="height:30px;clear:both;"></div>

<div id="table_approved">
    <div class="reserved_mark"></div><div style="float:right;"><?php
            // $bk_type =1;
            // if ( isset( $_GET['booking_type'] ) ) $bk_type = $_GET['booking_type'];
            make_bk_action('show_subtype_filter',$bk_type);
            ?></div><h2><?php _e('Approved', 'wpdev-booking'); ?></h2>
            <?php  $res2 = $this->booking_table(1);  ?>
    <div style="float:left;">
        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Cancel', 'wpdev-booking'); ?>"  onclick="javascript:bookingApprove(1,1, <?php echo $user_bk_id; ?>);"/>
    </div>
    <div style="float:left;border:none;margin-top:18px;">
        <div for="cancelreason" class="inside_hint"><?php _e('Reason of cancellation here', 'wpdev-booking'); ?></div>
        <input type="text" style="width:350px;" class="has-inside-hint" name="cancelreason" id="cancelreason" value="">
    </div>
    <div class="clear" style="height:1px;"></div>
    <div style="float:left;border:none;margin:-15px 0px 0px 10px; font-size: 11px;color:#777;font-style: italic;">
            <input type="checkbox" checked="CHECKED" id="is_send_email_for_aproved"> <label><?php _e('Send email notification to customer about this operation','wpdev-booking') ?></label>
    </div>
    <div id="admin_bk_messages1"> </div>
    <div class="clear" style="height:20px;"></div>
</div>

            <?php if (! $res2) { ?><script type="text/javascript">document.getElementById('table_approved').style.display="none";</script><?php } ?>
            <?php  $this->show_footer_at_booking_page();

            if( $this->wpdev_bk_pro == false )
                $support_links = '<div id="support_links">\n\
                        <a href="http://onlinebookingcalendar.com/features/" target="_blank">'.__('Features','wpdev-booking').'</a> |\n\
                        <a href="http://onlinebookingcalendar.com/demo/" target="_blank">'.__('Live Demos','wpdev-booking').'</a> |\n\
                        <a href="http://onlinebookingcalendar.com/faq/" target="_blank">'.__('FAQ','wpdev-booking').'</a> |\n\
                        <a href="mailto:info@onlinebookingcalendar.com" target="_blank">'.__('Contact','wpdev-booking').'</a> |\n\
                        <a href="http://onlinebookingcalendar.net/purchase/" class="button" target="_blank">'.__('Buy','wpdev-booking').'</a>\n\
                                      </div>';
            else
                $support_links = '<div id="support_links">\n\
                        <a href="http://onlinebookingcalendar.com/faq/" target="_blank">'.__('FAQ','wpdev-booking').'</a> |\n\
                        <a href="mailto:info@onlinebookingcalendar.com" target="_blank">'.__('Contact','wpdev-booking').'</a>\n\
                                      </div>';

            ?>

                 <script type="text/javascript">
                  jQuery('#ajax_working').before('<?php echo $support_links; ?>');
                </script>

            <?php
        }

        //Content of the Add reservation page
        function content_of_reservation_page() {


            $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'check_for_active_users');

            if (! $is_can) return false;

            if ( ! isset($_GET['booking_type']) ) {
                $default_booking_resource = get_bk_option( 'booking_default_booking_resource');
                if ((isset($default_booking_resource)) && ($default_booking_resource !== false)) $_GET['booking_type']=  $default_booking_resource;

                make_bk_action('check_if_bk_res_parent_with_childs_set_parent_res', $default_booking_resource  );

                if ( class_exists('wpdev_bk_multiuser')) {  // If MultiUser so
                    $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
                    if (! $is_can) { // User not superadmin
                        $bk_multiuser = apply_bk_filter('get_default_bk_resource_for_user',false);
                        if ($bk_multiuser == false) return;
                        else $default_booking_resource = $bk_multiuser;
                    }
                }

            }

            echo '<div id="ajax_working"></div>';
            echo '<div class="clear" style="margin:20px;"></div>';
            echo '<style type="text/css"> a.bktypetitlenew { margin-right:0px; } </style>';
            if( $this->wpdev_bk_pro !== false )  $this->wpdev_bk_pro->booking_types_pages('noedit');
            echo '<div class="clear" style="margin:20px;"></div>';

            $bk_type = $this->get_default_type();
            if (isset($_GET['booking_type'])) {
                $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, $_GET['booking_type'] ); if ( !$is_can) { return ; }
            }
            echo '<div style="width:450px">';
            do_action('wpdev_bk_add_form',$bk_type, get_bk_option( 'booking_client_cal_count'));
            ?>
            <div style="float:left;border:none;margin:0px 0 10px 1px; font-size: 11px;color:#777;font-style: italic;">
                <input type="checkbox" checked="CHECKED" id="is_send_email_for_new_booking"> <label><?php _e('Send email notification to customer about this operation','wpdev-booking') ?></label>
            </div>
            <?php
            echo '</div>';
        }

        //content of    S E T T I N G S     page  - actions runs
        function content_of_settings_page () {
            
            $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'check_for_active_users');
            if (! $is_can) return false;

            make_bk_action('wpdev_booking_settings_top_menu');
            ?> <div style="height:1px;clear:both;border-top:1px solid #bbc;"></div>  <?php
            ?> <div id="ajax_respond"></div>
            <div class="clear" ></div>
            <div id="ajax_working"></div>
            <div id="poststuff" class="metabox-holder" style="margin-top:0px;">
            <?php make_bk_action('wpdev_booking_settings_show_content'); ?>
            </div> <?php
        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="  S E T T I N G S     S U P P O R T   F U N C T I O N S    ">
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // S E T T I N G S     S U P P O R T   F U N C T I O N S
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Show top line menu
        function settings_menu_top_line() {

            $version = $this->get_version();
            if (! isset($_GET['tab'])) $_GET['tab'] = '';
            $selected_title = $_GET['tab'];
            $is_only_icons = ! true;
            if  (! isset($_GET['tab'])) $_GET['tab'] = 'form';

            if ($is_only_icons) echo '<style type="text/css"> #menu-wpdevplugin .nav-tab { padding:4px 2px 6px 32px !important; } </style>';
            ?>
             <div style="height:1px;clear:both;margin-top:20px;"></div>
             <div id="menu-wpdevplugin">
                <div class="nav-tabs-wrapper">
                    <div class="nav-tabs">

            <?php $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
            if ($is_can) { ?>

                <?php $title = __('General', 'wpdev-booking');
                $my_icon = 'General-setting-64x64.png'; $my_tab = 'main';  ?>
                <?php if ( ($_GET['tab'] == 'main') ||($_GET['tab'] == '') || (! isset($_GET['tab'])) ) {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php } else {
                     if ( (! isset($_GET['tab'])) || ($_GET['tab']=='') ) $_GET['tab'] = 'form'; // For multiuser - common user set firt selected tab -> Form
            } ?>

            <?php $title = __('Fields', 'wpdev-booking');
            $my_icon = 'Form-fields-64x64.png'; $my_tab = 'form';  ?>
            <?php if ($_GET['tab'] == 'form') {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
            <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php $title = __('Emails', 'wpdev-booking');
            $my_icon = 'E-mail-64x64.png'; $my_tab = 'email';  ?>
            <?php if ($_GET['tab'] == 'email') {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
            <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php if ( ($version == 'free') || ($version == 'premium') || ($version == 'hotel') || ($version == 'premium_plus') ) { ?>

                <?php $title = __('Payments', 'wpdev-booking');
                $my_icon = 'Paypal-cost-64x64.png'; $my_tab = 'payment';  ?>
                <?php if ($_GET['tab'] == 'payment') {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php } ?>

            <?php if ( ($version == 'free') || ($version == 'hotel') || ($version == 'premium_plus') ) { ?>

                <?php $title = __('Cost and availability', 'wpdev-booking');
                $my_icon = 'Booking-costs-64x64.png'; $my_tab = 'cost';  ?>
                <?php if ($_GET['tab'] == 'cost') {  $slct_a = 'selected'; } else { $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

                <?php $title = __('Filters', 'wpdev-booking');
                $my_icon = 'Season-64x64.png'; $my_tab = 'filter';  ?>
                <?php if ($_GET['tab'] == 'filter') {  $slct_a = 'selected'; } else { $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

                <?php if ( ($version == 'free') || ($version == 'hotel') ) { ?>
                    <?php $title = __('Resources', 'wpdev-booking');
                    $my_icon = 'Booking-resources-64x64.png'; $my_tab = 'resources';  ?>
                    <?php if ($_GET['tab'] == 'resources') {  $slct_a = 'selected'; } else { $slct_a = ''; } ?>
                    <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>
                <?php } ?>

                <?php if ( ($version == 'free')   ) { ?>
                    <?php $title = __('Users', 'wpdev-booking');
                    $my_icon = 'users-48x48.png'; $my_tab = 'users';  ?>
                    <?php if ($_GET['tab'] == 'users') {  $slct_a = 'selected'; } else { $slct_a = ''; } ?>
                    <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab tipcy" title="<?php echo __('Customization of','wpdev-booking') .' '.strtolower($title). ' '.__('settings','wpdev-booking'); ?>" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>
                <?php } ?>



            <?php } ?>

            <?php $selected_icon2 = '';
            $selected_icon2 .= apply_bk_filter('wpdev_show_top_menu_line' );
            if ( ($selected_icon2 !='^') && ($selected_icon2 !='') ) {
                $selected_icon2 = explode('^', $selected_icon2);
                $selected_icon  = $selected_icon2[0];
                $selected_title = $selected_icon2[1];
            }
            ?>

            <?php if ( ($version == 'free')  ) { ?>

                <?php $title = __('Buy now', 'wpdev-booking');
                $my_icon = 'shopping_trolley.png'; $my_tab = 'buy';  ?>
                <?php if ( ($_GET['tab'] == $my_tab)  ) {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') { $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php } elseif (   ( ($version !== 'hotel') && ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') === FALSE ) ) ||
                               (($version === 'hotel') && (class_exists('wpdev_bk_hotel') === false)   )
                            ) { ?>
                <?php $title = __('Upgrade', 'wpdev-booking');
                $my_icon = 'shopping_trolley.png'; $my_tab = 'upgrade';  ?>
                <?php if ( ($_GET['tab'] == $my_tab)  ) {  $slct_a = 'selected'; } else {  $slct_a = ''; } ?>
                <?php if ($slct_a == 'selected') {  $selected_title = $title; $selected_icon = $my_icon;  ?><span class="nav-tab nav-tab-active"><?php } else { ?><a class="nav-tab" href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=<?php echo $my_tab; ?>"><?php } ?><img class="menuicons" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php  if ($is_only_icons) echo '&nbsp;'; else echo $title; ?><?php if ($slct_a == 'selected') { ?></span><?php } else { ?></a><?php } ?>

            <?php }  ?>

                    </div>
                </div>
            </div>

            <?php if (($_GET['tab'] == 'upgrade') || ($_GET['tab'] == 'buy')) { $settings_text = '' ;
            } else {                                                            $settings_text = ' ' . __('settings'); }

            if ($version == 'free')
                $support_links = '<div id="support_links">\n\
                        <a href="http://onlinebookingcalendar.com/features/" target="_blank">'.__('Features','wpdev-booking').'</a> |\n\
                        <a href="http://onlinebookingcalendar.com/demo/" target="_blank">'.__('Live Demos','wpdev-booking').'</a> |\n\                        <a href="http://onlinebookingcalendar.com/faq/" target="_blank">'.__('FAQ','wpdev-booking').'</a> |\n\
                        <a href="mailto:info@onlinebookingcalendar.com" target="_blank">'.__('Contact','wpdev-booking').'</a> |\n\
                        <a href="http://onlinebookingcalendar.net/purchase/" class="button" target="_blank">'.__('Buy','wpdev-booking').'</a>\n\
                                      </div>';
            else
                $support_links = '<div id="support_links">\n\
                        <a class="live-tipsy" original-title="Its working  Ha ha" href="http://onlinebookingcalendar.com/faq/" target="_blank">'.__('FAQ','wpdev-booking').'</a> |\n\
                        <a href="mailto:info@onlinebookingcalendar.com" target="_blank">'.__('Contact','wpdev-booking').'</a>\n\
                                      </div>';
            ?>
             <script type="text/javascript">
                    var val1 = '<img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/<?php echo $selected_icon; ?>"><br />';
                    jQuery('div.wrap div.icon32').html(val1);
                    jQuery('div.bookingpage h2').after('<?php echo $support_links; ?>');
                    jQuery('div.bookingpage h2').html( '<?php echo $selected_title . $settings_text ?>');
              </script><?php
        }

        // Show content of settings page . At free version just promo information
        function settings_menu_content() {

            $version = $this->get_version();
            if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) $version = 'free';

            if   ( ! isset($_GET['tab']) )  {

                 $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
                 if ($is_can) {
                    $this->settings_general_content();
                    return;
                 } else { // Multiuser first page for common user page
                     $_GET['tab'] = 'form';
                     return;
                 }
            }

            switch ($_GET['tab']) {

                case 'main':
                    $this->settings_general_content();
                    return;
                    break;

                case '':
                    $this->settings_general_content();
                    return;
                    break;

                case 'upgrade':
                    if ( ( ($version !== 'free') && ($version !== 'hotel') ) || (($version === 'hotel') && (class_exists('wpdev_bk_hotel') === false) ) )
                         $this->showUpgradeWindow($version);
                    break ;

                case 'buy':
                    if ($version == 'free')
                        $this->showBuyWidow();
                    break ;

                /*case 'faq' :   ?> <div> <div style="height:60px;width:100%;text-align:center;margin:15px auto;font-size:18px;line-height:32px;"><img style="padding:0px 20px 0;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/ajax-loader.gif"> <?php _e('Loading','wpdev-booking'); ?>... </div> <iframe id="faq" style="height:450px;width:100%;margin: -35px 0px 0px;" src="http://onlinebookingcalendar.com/faq/#content"></iframe></div> <?php break;/**/
            }

            if( $this->wpdev_bk_pro !== false )  return;

            return $this->show_help();

        }

        // Show window for upgrading
        function showUpgradeWindow($version) {
            if ( strpos($_SERVER['SCRIPT_FILENAME'],'onlinebookingcalendar.com') === FALSE ) {
            ?>
                <div class='meta-box'>
                        <div <?php $my_close_open_win_id = 'bk_general_settings_upgrade'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><span>Upgrade to <?php if ( ($version == 'pro') ) { ?>Premium /<?php } ?><?php if (in_array($version, array('pro','premium') )) { ?> Premium Plus /<?php } ?> Hotel Edtion</span></span></h3>
                        <div class="inside">

                                    <p>You can make <strong>upgrade</strong> to the
                                    <?php if (in_array($version, array('pro') )) { ?><span class="color_premium" style="font-weight:bold;">Booking Calendar Premium</span> or<?php } ?>
                                    <?php if (in_array($version, array('pro','premium') )) { ?><span class="color_premium_plus" style="font-weight:bold;">Premium Plus</span> or<?php } ?>
                                    <span  class="color_hotel" style="font-weight:bold;">Hotel Edition</span>: </p>

                <?php if (in_array($version, array('pro') )) { ?>
                                    <p><span class="color_premium" style="font-weight:bold;">Booking Calendar Premium</span> features:</p>
                                    <p style="padding:0px 10px;">
                                        &bull; Bookings for <strong>specific time</strong>  in a day<br/>
                                        &bull; <strong>Week booking</strong> or any other day range selection bookings<br/>
                                        &bull; <strong>Online payment</strong> (PayPal and Sage payment support)<br/>
                                        &bull; <strong>Payment requests</strong> Posibility to send payment requests to visitors<br/>
                                        &bull; <strong>Cost editing</strong> Posibility to direct cost editing by administrator<br/>
                                    </p>
                <?php } ?>
                <?php if (in_array($version, array('pro','premium') )) { ?>
                                    <p><span class="color_premium_plus" style="font-weight:bold;">Booking Calendar Premium Plus</span> features:</p>
                                    <p style="padding:0px 10px;">
                                            &bull; <strong>Several booking forms</strong> Customization of fields for several forms<br/>
                                            &bull; <strong>Season filter</strong> flexible definition of days<br/>
                                            &bull; <strong>Availability</strong>. Set for each booking resource (un)avalaible days.<br/>
                                            &bull; <strong>Rates</strong>. Set higher costs for peak season or discounts for specific days.<br/>
                                            &bull; <strong>Additional costs</strong>. Set additional costs, which will depends from selection in dropdown lists or checkboxes.<br/>
                                            &bull; <strong>Advanced costs</strong>. Set costs, which will depends from number of selected days for booking.<br/>
                                    </p>
                <?php } ?>
                                    <p><span class="color_hotel"  style="font-weight:bold;">Booking Calendar Hotel Edition</span> features:</p>
                                    <p style="padding:0px 10px;">
                                            &bull; <strong>Multiple booking at the same day.</strong> Day will be availbale untill all items (rooms) are not reserved.<br/>
                                            &bull; <strong>"Capacity" of day depends from number of visitors</strong> Selection of visitor number will apply to the capacity of selected day(s).<br/>
                                    </p>
            <?php if( strpos( strtolower(WPDEV_BK_VERSION) , 'multisite') !== false  ) {
                $multiv = '-multi';
            } else {
                $multiv = '';
            }  ?>

                <?php if ( ($version == 'pro') ) { ?>
                                        <p style="line-height:25px;text-align:center;padding-top:15px;"><a href="http://onlinebookingcalendar.net/upgrade-pro<?php echo $multiv ?>/" target="_blank" class="buttonlinktext">Upgrade</a></p>
                <?php } elseif ( ($version == 'premium') ) { ?>
                                        <p style="line-height:25px;text-align:center;padding-top:15px;"><a href="http://onlinebookingcalendar.net/upgrade-premium<?php echo $multiv ?>/" target="_blank" class="buttonlinktext">Upgrade</a></p>
                <?php } elseif ( ($version == 'premium_plus') ) { ?>
                                        <p style="line-height:25px;text-align:center;padding-top:15px;"><a href="http://onlinebookingcalendar.net/upgrade-premium-plus<?php echo $multiv ?>/" target="_blank" class="buttonlinktext">Upgrade</a></p>
                <?php } ?>
                                </div>
                            </div>
                        </div>


            <?php
            }
        }

        // Show Settings content of main page
        function settings_general_content() {

            $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
            if ($is_can===false) return;


            if ( isset( $_POST['start_day_weeek'] ) ) {
                $booking_skin  = $_POST['booking_skin'];

                $email_reservation_adress      = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_adress']));
                $email_reservation_adress      = str_replace("\'","'",$email_reservation_adress);

                $booking_sort_order = $_POST['booking_sort_order'];
                $booking_sort_order_direction = $_POST['booking_sort_order_direction'];

                $max_monthes_in_calendar =  $_POST['max_monthes_in_calendar'];
                if (isset($_POST['admin_cal_count'])) $admin_cal_count  = $_POST['admin_cal_count'];
                if (isset($_POST['client_cal_count'])) $client_cal_count = $_POST['client_cal_count'];
                $start_day_weeek  = $_POST['start_day_weeek'];
                $new_booking_title= $_POST['new_booking_title'];
                $new_booking_title_time= $_POST['new_booking_title_time'];
                $type_of_thank_you_message = $_POST['type_of_thank_you_message'];//get_bk_option( 'booking_type_of_thank_you_message' ); //= 'message'; = 'page';
                $thank_you_page_URL = $_POST['thank_you_page_URL'];//get_bk_option( 'booking_thank_you_page_URL' ); //= 'message'; = 'page';


                $booking_date_format = $_POST['booking_date_format'];
                $booking_date_view_type = $_POST['booking_date_view_type'];
                //$is_dif_colors_approval_pending = $_POST['is_dif_colors_approval_pending'];
                $is_use_hints_at_admin_panel = $_POST['is_use_hints_at_admin_panel'];
                $multiple_day_selections =  $_POST[ 'multiple_day_selections' ];
                if (isset($_POST['is_delete_if_deactive'])) $is_delete_if_deactive =  $_POST['is_delete_if_deactive']; // check
                if (isset($_POST['wpdev_copyright'])) $wpdev_copyright  = $_POST['wpdev_copyright'];             // check
                if (isset($_POST['is_use_captcha'])) $is_use_captcha  = $_POST['is_use_captcha'];             // check
                if (isset($_POST['is_show_legend'])) $is_show_legend  = $_POST['is_show_legend'];             // check

                if (isset($_POST['unavailable_day0']))  $unavailable_day0  = $_POST['unavailable_day0'];
                if (isset($_POST['unavailable_day1']))  $unavailable_day1  = $_POST['unavailable_day1'];
                if (isset($_POST['unavailable_day2']))  $unavailable_day2  = $_POST['unavailable_day2'];
                if (isset($_POST['unavailable_day3']))  $unavailable_day3  = $_POST['unavailable_day3'];
                if (isset($_POST['unavailable_day4']))  $unavailable_day4  = $_POST['unavailable_day4'];
                if (isset($_POST['unavailable_day5']))  $unavailable_day5  = $_POST['unavailable_day5'];
                if (isset($_POST['unavailable_day6']))  $unavailable_day6  = $_POST['unavailable_day6'];

                $user_role_booking      = $_POST['user_role_booking'];
                $user_role_addbooking   = $_POST['user_role_addbooking'];
                $user_role_settings     = $_POST['user_role_settings'];
                if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) {
                    $user_role_booking      = 'subscriber';
                    $user_role_addbooking   = 'subscriber';
                    $user_role_settings     = 'subscriber';
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////





                update_bk_option( 'booking_user_role_booking', $user_role_booking );
                update_bk_option( 'booking_user_role_addbooking', $user_role_addbooking );
                update_bk_option( 'booking_user_role_settings', $user_role_settings );


                update_bk_option( 'booking_sort_order',$booking_sort_order);
                update_bk_option( 'booking_sort_order_direction',$booking_sort_order_direction);

                update_bk_option( 'booking_skin',$booking_skin);
                update_bk_option( 'booking_email_reservation_adress' , $email_reservation_adress );
                update_bk_option( 'booking_max_monthes_in_calendar' , $max_monthes_in_calendar );

                if (! isset($admin_cal_count)) $admin_cal_count = 2;
                if (! isset($client_cal_count)) $client_cal_count = 1;

                if (1*$admin_cal_count>12) $admin_cal_count = 12;
                if (1*$admin_cal_count< 1) $admin_cal_count = 1;
                update_bk_option( 'booking_admin_cal_count' , $admin_cal_count );
                if (1*$client_cal_count>12) $client_cal_count = 12;
                if (1*$client_cal_count< 1) $client_cal_count = 1;
                update_bk_option( 'booking_client_cal_count' , $client_cal_count );
                update_bk_option( 'booking_start_day_weeek' , $start_day_weeek );
                update_bk_option( 'booking_title_after_reservation' , $new_booking_title );
                update_bk_option( 'booking_title_after_reservation_time' , $new_booking_title_time );
                update_bk_option( 'booking_type_of_thank_you_message' , $type_of_thank_you_message );
                update_bk_option( 'booking_thank_you_page_URL' , $thank_you_page_URL );



                update_bk_option( 'booking_date_format' , $booking_date_format );
                update_bk_option( 'booking_date_view_type' , $booking_date_view_type);
                // if (isset( $is_dif_colors_approval_pending ))   $is_dif_colors_approval_pending = 'On';
                // else                                            $is_dif_colors_approval_pending = 'Off';
                // update_bk_option( 'booking_dif_colors_approval_pending' , $is_dif_colors_approval_pending );

                if (isset( $is_use_hints_at_admin_panel ))   $is_use_hints_at_admin_panel = 'On';
                else                                            $is_use_hints_at_admin_panel = 'Off';
                update_bk_option( 'booking_is_use_hints_at_admin_panel' , $is_use_hints_at_admin_panel );


                if (isset( $multiple_day_selections ))   $multiple_day_selections = 'On';
                else                                     $multiple_day_selections = 'Off';
                update_bk_option( 'booking_multiple_day_selections' , $multiple_day_selections );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                if (isset( $unavailable_day0 ))            $unavailable_day0 = 'On';
                else                                       $unavailable_day0 = 'Off';
                update_bk_option( 'booking_unavailable_day0' , $unavailable_day0 );
                if (isset( $unavailable_day1 ))            $unavailable_day1 = 'On';
                else                                       $unavailable_day1 = 'Off';
                update_bk_option( 'booking_unavailable_day1' , $unavailable_day1 );
                if (isset( $unavailable_day2 ))            $unavailable_day2 = 'On';
                else                                       $unavailable_day2 = 'Off';
                update_bk_option( 'booking_unavailable_day2' , $unavailable_day2 );
                if (isset( $unavailable_day3 ))            $unavailable_day3 = 'On';
                else                                       $unavailable_day3 = 'Off';
                update_bk_option( 'booking_unavailable_day3' , $unavailable_day3 );
                if (isset( $unavailable_day4 ))            $unavailable_day4 = 'On';
                else                                       $unavailable_day4 = 'Off';
                update_bk_option( 'booking_unavailable_day4' , $unavailable_day4 );
                if (isset( $unavailable_day5 ))            $unavailable_day5 = 'On';
                else                                       $unavailable_day5 = 'Off';
                update_bk_option( 'booking_unavailable_day5' , $unavailable_day5 );
                if (isset( $unavailable_day6 ))            $unavailable_day6 = 'On';
                else                                       $unavailable_day6 = 'Off';
                update_bk_option( 'booking_unavailable_day6' , $unavailable_day6 );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (isset( $is_delete_if_deactive ))            $is_delete_if_deactive = 'On';
                else                                            $is_delete_if_deactive = 'Off';
                update_bk_option( 'booking_is_delete_if_deactive' , $is_delete_if_deactive );

                if (isset( $wpdev_copyright ))                  $wpdev_copyright = 'On';
                else                                            $wpdev_copyright = 'Off';
                update_bk_option( 'booking_wpdev_copyright' , $wpdev_copyright );
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (isset( $is_use_captcha ))                  $is_use_captcha = 'On';
                else                                           $is_use_captcha = 'Off';
                update_bk_option( 'booking_is_use_captcha' , $is_use_captcha );

                if (isset( $is_show_legend ))                  $is_show_legend = 'On';
                else                                           $is_show_legend = 'Off';
                update_bk_option( 'booking_is_show_legend' , $is_show_legend );


            } else {
                $booking_skin = get_bk_option( 'booking_skin');
                $email_reservation_adress      = get_bk_option( 'booking_email_reservation_adress') ;
                $max_monthes_in_calendar =  get_bk_option( 'booking_max_monthes_in_calendar' );

                $booking_sort_order = get_bk_option( 'booking_sort_order');
                $booking_sort_order_direction = get_bk_option( 'booking_sort_order_direction');


                $admin_cal_count  = get_bk_option( 'booking_admin_cal_count' );
                $new_booking_title= get_bk_option( 'booking_title_after_reservation' );
                $new_booking_title_time= get_bk_option( 'booking_title_after_reservation_time' );

                $type_of_thank_you_message = get_bk_option( 'booking_type_of_thank_you_message' ); //= 'message'; = 'page';
                $thank_you_page_URL = get_bk_option( 'booking_thank_you_page_URL' ); //= 'message'; = 'page';


                $booking_date_format = get_bk_option( 'booking_date_format');
                $booking_date_view_type = get_bk_option( 'booking_date_view_type');
                $client_cal_count = get_bk_option( 'booking_client_cal_count' );
                $start_day_weeek  = get_bk_option( 'booking_start_day_weeek' );
                // $is_dif_colors_approval_pending = get_bk_option( 'booking_dif_colors_approval_pending' );
                $is_use_hints_at_admin_panel    = get_bk_option( 'booking_is_use_hints_at_admin_panel' );
                $multiple_day_selections =  get_bk_option( 'booking_multiple_day_selections' );
                $is_delete_if_deactive =  get_bk_option( 'booking_is_delete_if_deactive' ); // check
                $wpdev_copyright  = get_bk_option( 'booking_wpdev_copyright' );             // check
                $is_use_captcha  = get_bk_option( 'booking_is_use_captcha' );             // check
                $is_show_legend  = get_bk_option( 'booking_is_show_legend' );             // check


                $unavailable_day0 = get_bk_option( 'booking_unavailable_day0' );
                $unavailable_day1 = get_bk_option( 'booking_unavailable_day1' );
                $unavailable_day2 = get_bk_option( 'booking_unavailable_day2' );
                $unavailable_day3 = get_bk_option( 'booking_unavailable_day3' );
                $unavailable_day4 = get_bk_option( 'booking_unavailable_day4' );
                $unavailable_day5 = get_bk_option( 'booking_unavailable_day5' );
                $unavailable_day6 = get_bk_option( 'booking_unavailable_day6' );

                $user_role_booking      = get_bk_option( 'booking_user_role_booking' );
                $user_role_addbooking   = get_bk_option( 'booking_user_role_addbooking' );
                $user_role_settings     = get_bk_option( 'booking_user_role_settings' );



            }
            if (empty($type_of_thank_you_message)) $type_of_thank_you_message = 'message';


            ?>
            <div  class="clear" style="height:10px;"></div>
<form  name="post_option" action="" method="post" id="post_option" >

    <div  style="width:64%; float:left;margin-right:1%;">

        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_main'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Main settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>

                                <tr valign="top">
                                    <th scope="row"><label for="admin_cal_count" ><?php _e('Admin email', 'wpdev-booking'); ?>:</label></th>
                                    <td><input id="email_reservation_adress"  name="email_reservation_adress" class="regular-text code" type="text" style="width:350px;" size="145" value="<?php echo $email_reservation_adress; ?>" /><br/>
                                        <span class="description"><?php printf(__('Type default %sadmin email%s for checking reservations', 'wpdev-booking'),'<b>','</b>');?></span>
                                    </td>
                                </tr>

            <?php make_bk_action('wpdev_bk_general_settings_edit_booking_url'); ?>

                                <tr valign="top">
                                    <th scope="row"><label for="is_use_hints_at_admin_panel" ><?php _e('Show hints', 'wpdev-booking'); ?>:</label><br><?php _e('Show / hide hints', 'wpdev-booking'); ?></th>
                                    <td><input id="is_use_hints_at_admin_panel" type="checkbox" <?php if ($is_use_hints_at_admin_panel == 'On') echo "checked"; ?>  value="<?php echo $is_use_hints_at_admin_panel; ?>" name="is_use_hints_at_admin_panel"/>
                                        <span class="description"><?php _e(' Check, if you want to show help hints at the admin panel.', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="wpdev_copyright" ><?php _e('Copyright notice', 'wpdev-booking'); ?>:</label></th>
                                    <td><input id="wpdev_copyright" type="checkbox" <?php if ($wpdev_copyright == 'On') echo "checked"; ?>  value="<?php echo $wpdev_copyright; ?>" name="wpdev_copyright"/>
                                        <span class="description"><?php printf(__(' Turn On/Off copyright %s notice at footer of site view.', 'wpdev-booking'),'wpdevelop.com');?></span>
                                    </td>
                                </tr>



                    </tbody></table>
        </div></div></div>

        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_calendar'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Calendar settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>

                                <tr valign="top">
                                    <th scope="row"><label for="booking_skin" ><?php _e('Calendar skin', 'wpdev-booking'); ?>:</label></th>
                                    <td>
            <?php
            //TODO: Read the conatct from 2 folders and show results at this select box, aqrray with values and names
            // Create 2 more skins: one black for freee versions
            // One modern light/white for paid versions
            $dir_list = $this->dirList( array(  '/css/skins/', '/include/skins/' ) );
            ?>
                                        <select id="booking_skin" name="booking_skin" style="text-transform:capitalize;">
            <?php foreach ($dir_list as $value) {
                if($booking_skin == $value[1]) $selected_item =  'selected="SELECTED"';
                else $selected_item='';
                echo '<option '.$selected_item.' value="'.$value[1].'" >' .  $value[2] . '</option>';
            } ?>
                                        </select>
                                        <span class="description"><?php _e('Select the skin of booking calendar', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="start_day_weeek" ><?php _e('Number of months', 'wpdev-booking'); ?>:</label></th>
                                    <td>
                                        <select id="max_monthes_in_calendar" name="max_monthes_in_calendar">

            <?php for ($mm = 1; $mm < 13; $mm++) { ?>
                                            <option <?php if($max_monthes_in_calendar == $mm .'m') echo "selected"; ?> value="<?php echo $mm; ?>m"><?php echo $mm ,' ';
                _e('month(s)', 'wpdev-booking'); ?></option>
                <?php } ?>

            <?php for ($mm = 1; $mm < 11; $mm++) { ?>
                                            <option <?php if($max_monthes_in_calendar == $mm .'y') echo "selected"; ?> value="<?php echo $mm; ?>y"><?php echo $mm ,' ';
                _e('year(s)', 'wpdev-booking'); ?></option>
                <?php } ?>

                                        </select>
                                        <span class="description"><?php _e('Select your maximum number of months at booking calendar', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="start_day_weeek" ><?php _e('Start Day of week', 'wpdev-booking'); ?>:</label></th>
                                    <td>
                                        <select id="start_day_weeek" name="start_day_weeek">
                                            <option <?php if($start_day_weeek == '0') echo "selected"; ?> value="0"><?php _e('Sunday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '1') echo "selected"; ?> value="1"><?php _e('Monday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '2') echo "selected"; ?> value="2"><?php _e('Tuesday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '3') echo "selected"; ?> value="3"><?php _e('Wednesday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '4') echo "selected"; ?> value="4"><?php _e('Thursday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '5') echo "selected"; ?> value="5"><?php _e('Friday', 'wpdev-booking'); ?></option>
                                            <option <?php if($start_day_weeek == '6') echo "selected"; ?> value="6"><?php _e('Saturday', 'wpdev-booking'); ?></option>
                                        </select>
                                        <span class="description"><?php _e('Select your start day of the week', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="multiple_day_selections" ><?php _e('Multiple days selection', 'wpdev-booking'); ?>:</label><br><?php _e('in calendar', 'wpdev-booking'); ?></th>
                                    <td><input id="multiple_day_selections" type="checkbox" <?php if ($multiple_day_selections == 'On') echo "checked"; ?>  value="<?php echo $multiple_day_selections; ?>" name="multiple_day_selections"/>
                                        <span class="description"><?php _e(' Check, if you want have multiple days selection at calendar.', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

            <?php do_action('settings_advanced_set_range_selections'); ?>

            <?php do_action('settings_set_show_cost_in_tooltips'); ?>

            <?php do_action('settings_set_show_availability_in_tooltips');  ?>


                                <tr valign="top"> <td colspan="2">
                                    <div style="width:100%;">
                                        <span style="color:#21759B;cursor: pointer;font-weight: bold;"
                                           onclick="javascript: jQuery('#togle_settings_unavailable').slideToggle('normal');"
                                           style="text-decoration: none;font-weight: bold;font-size: 11px;">
                                           + <span style="border-bottom:1px dashed #21759B;"><?php _e('Show settings of unavailable days of week', 'wpdev-booking'); ?></span>
                                        </span>
                                    </div>

                                    <table id="togle_settings_unavailable" style="display:none;" class="hided_settings_table">
                                        <tr valign="top">
                                            <th scope="row"><label for="is_dif_colors_approval_pending" ><?php _e('Unavailable days', 'wpdev-booking'); ?>:</label></th>
                                            <td>    <div style="float:left;width:100px;border:0px solid red;">
                                                    <input id="unavailable_day0" name="unavailable_day0" <?php if ($unavailable_day0 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day0; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Sunday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day1" name="unavailable_day1" <?php if ($unavailable_day1 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day1; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Monday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day2" name="unavailable_day2" <?php if ($unavailable_day2 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day2; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Tuesday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day3" name="unavailable_day3" <?php if ($unavailable_day3 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day3; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Wednesday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day4" name="unavailable_day4" <?php if ($unavailable_day4 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day4; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Thursday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day5" name="unavailable_day5" <?php if ($unavailable_day5 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day5; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Friday', 'wpdev-booking'); ?></span><br/>
                                                    <input id="unavailable_day6" name="unavailable_day6" <?php if ($unavailable_day6 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day6; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Saturday', 'wpdev-booking'); ?></span>
                                                </div>
                                                <div style="float:left;width:auto;padding:0px 10px;style:0px solid red;">
                                                    <span class="description"><?php _e(' Check unavailable days for your visitors.', 'wpdev-booking');?></span></div>
                                            </td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>


                    </tbody></table>
        </div></div></div>

        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_form'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Booking form settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>

                                <tr valign="top">
                                    <th scope="row"><label for="is_use_captcha" ><?php _e('CAPTCHA', 'wpdev-booking'); ?>:</label><br><?php _e('at booking form', 'wpdev-booking'); ?></th>
                                    <td><input id="is_use_captcha" type="checkbox" <?php if ($is_use_captcha == 'On') echo "checked"; ?>  value="<?php echo $is_use_captcha; ?>" name="is_use_captcha"/>
                                        <span class="description"><?php _e(' Check, if you want to activate CAPTCHA inside of booking form.', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="is_show_legend" ><?php _e('Show legend', 'wpdev-booking'); ?>:</label><br><?php _e('at booking calendar', 'wpdev-booking'); ?></th>
                                    <td><input id="is_show_legend" type="checkbox" <?php if ($is_show_legend == 'On') echo "checked"; ?>  value="<?php echo $is_show_legend; ?>" name="is_show_legend"/>
                                        <span class="description"><?php _e(' Check, if you want to show legend of dates under booking calendar.', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

            <?php do_action('settings_advanced_set_fixed_time'); ?>

            <?php do_action('settings_set_is_use_visitors_number_for_availability');  ?>

                                <tr valign="top"> <td colspan="2">
                                    <div style="width:100%;">
                                        <span style="color:#21759B;cursor: pointer;font-weight: bold;"
                                           onclick="javascript: jQuery('#togle_settings_thankyou').slideToggle('normal');"
                                           style="text-decoration: none;font-weight: bold;font-size: 11px;">
                                           + <span style="border-bottom:1px dashed #21759B;"><?php _e('Settings of showing "thank you" message or page, after reservation is done', 'wpdev-booking'); ?></span>
                                        </span>
                                    </div>

                                    <table id="togle_settings_thankyou" style="display:none;width:100%;padding: 0px;" class="hided_settings_table">
                                        <tr>
                                            <!--th>
                                            <label for="new_booking_title" style="font-size:12px;" ><?php _e('New reservation title', 'wpdev-booking'); ?>:</label><br/>
            <?php printf(__('%sshowing after%s booking', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                            </th>
                                            <td>
                                                <input id="new_booking_title" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title; ?>" name="new_booking_title" style="width:99%;"/>
                                                <span class="description"><?php printf(__('Type title of new reservation %safter booking has done by user%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                            </td-->



<td colspan="2">
                    <table id="thank-you-booking-message"  style="width:100%;padding: 0px;">
                        <tr valign="top" style="padding: 0px;">


                                <td style="width:50%;font-weight: bold;"><input  <?php if ($type_of_thank_you_message == 'message') echo 'checked="checked"';/**/ ?> value="message" type="radio" id="type_of_thank_you_message"  name="type_of_thank_you_message"  onclick="javascript: jQuery('#togle_settings_thank-you_page').slideUp('normal');jQuery('#togle_settings_thank-you_message').slideDown('normal');"  /> <label for="type_of_thank_you_message" ><?php _e('Show "thank you" message near calendar', 'wpdev-booking'); ?></label></td>
                                <td style="width:50%;font-weight: bold;"><input  <?php if ($type_of_thank_you_message == 'page') echo 'checked="checked"';/**/ ?> value="page" type="radio" id="type_of_thank_you_message"  name="type_of_thank_you_message"  onclick="javascript: jQuery('#togle_settings_thank-you_page').slideDown('normal');jQuery('#togle_settings_thank-you_message').slideUp('normal');"  /> <label for="type_of_thank_you_message" ><?php _e('Redirect visitor to a new "thank you" page', 'wpdev-booking'); ?> </label></td>



                        </tr>
                        <tr valign="top" style="padding: 0px;"><td colspan="2">
                            <table id="togle_settings_thank-you_message" style="width:100%;<?php if ($type_of_thank_you_message != 'message') echo 'display:none;';/**/ ?>" class="hided_settings_table">
                                <tr valign="top">
                                            <th>
                                            <label for="new_booking_title" style="font-size:12px;" ><?php _e('New reservation title', 'wpdev-booking'); ?>:</label><br/>
            <?php printf(__('%sshowing after%s booking', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                            </th>
                                            <td>
                                                <input id="new_booking_title" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title; ?>" name="new_booking_title" style="width:99%;"/>
                                                <span class="description"><?php printf(__('Type title of new reservation %safter booking has done by user%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                            </td>
                                </tr>
                                <tr><th>
                                            <label for="new_booking_title" style=" font-weight: bold;font-size: 12px;" ><?php _e('Showing title time', 'wpdev-booking'); ?>:</label><br/>
            <?php printf(__('%snew reservation%s', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                            </th>
                                        <td>
                                            <input id="new_booking_title_time" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title_time; ?>" name="new_booking_title_time" />
                                            <span class="description"><?php printf(__('Type in miliseconds count of time for showing new reservation title', 'wpdev-booking'),'<b>','</b>');?></span>
                                        </td>
                                        </tr>
                            </table>

                            <table id="togle_settings_thank-you_page" style="width:100%;<?php if ($type_of_thank_you_message != 'page') echo 'display:none;';/**/ ?>" class="hided_settings_table">
                                <tr valign="top">
                                <th scope="row" style="width:170px;"><label for="thank_you_page_URL" ><?php _e('URL of "thank you" page', 'wpdev-booking'); ?>:</label></th>
                                    <td><input value="<?php echo $thank_you_page_URL; ?>" name="thank_you_page_URL" id="thank_you_page_URL" class="regular-text code" type="text" size="45"  style="width:99%;" />
                                        <span class="description"><?php printf(__('Type URL of %s"thank you" page%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                    </td>
                                </tr>
                            </table>


                    </td></tr>
                    </table>
</td>



                                        </tr>
                                        <!--tr><th>
                                            <label for="new_booking_title" style=" font-weight: bold;font-size: 12px;" ><?php _e('Showing title time', 'wpdev-booking'); ?>:</label><br/>
            <?php printf(__('%snew reservation%s', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                            </th>
                                        <td>
                                            <input id="new_booking_title_time" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title_time; ?>" name="new_booking_title_time" />
                                            <span class="description"><?php printf(__('Type in miliseconds count of time for showing new reservation title', 'wpdev-booking'),'<b>','</b>');?></span>
                                        </td>
                                        </tr-->
                                    </table>
                                    </td>
                                </tr>

                    </tbody></table>

        </div></div></div>

        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_bktable'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Booking table settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>

            <?php make_bk_action('wpdev_bk_general_settings_set_default_booking_resource'); ?>

                                <tr valign="top">
                                    <th scope="row"><label for="booking_sort_order" ><?php _e('Bookings default order', 'wpdev-booking'); ?>:</label></th>
                                    <td>

            <?php  $order_array = array('ID','Date','Name','Email'); ?>
                                        <select id="booking_sort_order" name="booking_sort_order">
            <?php foreach ($order_array as $mm) { ?>
                                            <option <?php if($booking_sort_order == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($mm) ; ?></option>
                <?php } ?>
                                        </select>

                                        <select id="booking_sort_order_direction" name="booking_sort_order_direction" style="width:70px;">
                                            <option <?php if($booking_sort_order_direction == 'ASC' ) echo "selected"; ?> value="<?php echo 'ASC'; ?>"><?php _e('ASC', 'wpdev-booking'); ?></option>
                                            <option <?php if($booking_sort_order_direction == 'DESC') echo "selected"; ?> value="<?php echo 'DESC'; ?>"><?php  _e('DESC', 'wpdev-booking'); ?></option>
                                        </select>

                                        <span class="description"><?php _e('Select your default order of booking resources', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><label for="booking_date_format" ><?php _e('Date Format', 'wpdev-booking'); ?>:</label></th>
                                    <td>
                                    <fieldset>
            <?php
            $date_formats =   array( __('F j, Y'), 'Y/m/d', 'm/d/Y', 'd/m/Y' ) ;
            $custom = TRUE;
            foreach ( $date_formats as $format ) {
                echo "\t<label title='" . esc_attr($format) . "'>";
                echo "<input type='radio' name='booking_date_format' value='" . esc_attr($format) . "'";
                if ( get_bk_option( 'booking_date_format') === $format ) {
                    echo " checked='checked'";
                    $custom = FALSE;
                }
                echo ' /> ' . date_i18n( $format ) . "</label> &nbsp;&nbsp;&nbsp;\n";
            }
            echo '<div style="height:7px;"></div>';
            echo '<label><input type="radio" name="booking_date_format" id="date_format_custom_radio" value="'. $booking_date_format .'"';
            if ( $custom )  echo ' checked="checked"';
            echo '/> ' . __('Custom', 'wpdev-booking') . ': </label>';?>
                                            <input id="booking_date_format_custom" class="regular-text code" type="text" size="45" value="<?php echo $booking_date_format; ?>" name="booking_date_format_custom" style="line-height:35px;"
                                                   onchange="javascript:document.getElementById('date_format_custom_radio').value = this.value;document.getElementById('date_format_custom_radio').checked=true;"
                                                   />
            <?php
            echo ' '. date_i18n( $booking_date_format ) . "\n";
            echo '&nbsp;&nbsp;';
            ?>
            <?php printf(__('Type your date format for showing in emails and booking table. %sDocumentation on date formatting.%s', 'wpdev-booking'),'<br/><a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">','</a>');?>
                                    </fieldset>
                                    </td>
                                </tr>

            <?php do_action('settings_advanced_set_time_format'); ?>

                                <tr valign="top">
                                    <th scope="row"><label for="booking_date_view_type" ><?php _e('Dates view', 'wpdev-booking'); ?>:</label></th>
                                    <td>
                                        <select id="booking_date_view_type" name="booking_date_view_type">
                                            <option <?php if($booking_date_view_type == 'short') echo "selected"; ?> value="short"><?php _e('Short days view', 'wpdev-booking'); ?></option>
                                            <option <?php if($booking_date_view_type == 'wide') echo "selected"; ?> value="wide"><?php _e('Wide days view', 'wpdev-booking'); ?></option>
                                        </select>
                                        <span class="description"><?php _e('Select default type of dates view at the booking tables', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                    </tbody></table>

        </div></div></div>


        <?php //do_action('wpdev_bk_general_settings_end') ?>

        <?php $this->show_help(); ?>

    </div>
    <div style="width:35%; float:left;">

            <?php  $version =

            $this->get_version();
            if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) $version = 'free';
            if ($version == 'free') $this->showBuyWidow();



            if ( ($version !== 'free') && ($version!== 'hotel') ) { $this->showUpgradeWindow($version); } ?>

        <div class='meta-box'>
                <div <?php $my_close_open_win_id = 'bk_general_settings_information'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Information', 'wpdev-booking'); ?></span></h3>
                <div class="inside">
                    <p class="sub"><?php _e("Info", 'wpdev-booking'); ?></p>
                    <div class="table">
                        <table><tbody>
                                <tr class="first">
                                    <td class="first b" style="width: 133px;"><?php _e("Version", 'wpdev-booking'); ?></td>
                                    <td class="t"><?php _e("release date", 'wpdev-booking'); ?>: <?php echo date ("d.m.Y", filemtime(__FILE__)); ?></td>
                                    <td class="b options" style="color: red; font-weight: bold;"><?php echo WPDEV_BK_VERSION; ?></td>
                                </tr>
                            </tbody></table>
                    </div>
                    <p class="sub"><?php _e("Links", 'wpdev-booking'); ?></p>
                    <div class="table">
                        <table><tbody>
                                <tr class="first">
                                    <td class="first b">Booking Calendar</td>
                                    <td class="t"><?php _e("developer plugin page", 'wpdev-booking'); ?></td>
                                    <td class="t options"><a href="http://wpdevelop.com/wp-plugins/booking-calendar/" target="_blank"><?php _e("visit", 'wpdev-booking'); ?></a></td>
                                </tr>
                                <tr>
                                    <td class="first b"><?php _e('Changelog', 'wpdev-booking'); ?></td>
                                    <td class="t"><?php _e("new features", 'wpdev-booking'); ?></td>
                                    <td class="t options"><a href="http://onlinebookingcalendar.com/changelog/" target="_blank"><?php _e("visit", 'wpdev-booking'); ?></a></td>
                                </tr>
                                <tr>
                                    <td class="first b" colspan="3" style="text-align:center;padding:10px 0px;"><a class="button-primary" href="http://onlinebookingcalendar.com/demo/" target="_blank"><?php _e('Online Demos of each versions', 'wpdev-booking'); ?></a></td>
                                </tr>
                                <tr>
                                    <td class="first b"><?php _e('WordPress Extend', 'wpdev-booking'); ?></td>
                                    <td class="t"><?php _e("wordpress plugin page", 'wpdev-booking'); ?></td>
                                    <td class="t options"><a href="http://wordpress.org/extend/plugins/booking" target="_blank"><?php _e("visit", 'wpdev-booking'); ?></a></td>
                                </tr>
                            </tbody></table>
                    </div>
                    <p class="sub"><?php _e("Author", 'wpdev-booking'); ?></p>
                    <div class="table">
                        <table><tbody>
                                <tr class="first">
                                    <td class="first b"><span><?php _e("Premium Support", 'wpdev-booking'); ?></span></td>
                                    <td class="t"><?php _e("special plugin customizations", 'wpdev-booking'); ?></td>
                                    <td class="t options"><a href="mailto:info@onlinebookingcalendar.com" target="_blank"><?php _e("email", 'wpdev-booking'); ?></a></td>
                                </tr>
                            </tbody></table>
                    </div>

                </div>
            </div>
        </div>

            <?php if (!class_exists('wpdev_crm')) { ?>

        <div class='meta-box'>
                <div <?php $my_close_open_win_id = 'bk_general_settings_recomended_plugins'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Recomended WordPress Plugins','wpdev-booking'); ?></span></h3>
                <div class="inside">
                    <h2 style="margin:10px;"><?php _e('Booking Manager - show all old bookings'); ?> </h2>
                    <img src="<?php echo WPDEV_BK_PLUGIN_URL . '/img/users-48x48.png'; ?>" style="float:left; padding:0px 10px 10px 0px;">

                    <p style="margin:0px;">
                <?php printf(__('This wordpress plugin is  %sshow all approved and pending bookings from past%s. Show how many each customer is made bookings. Paid versions support %sexport to CSV, print loyout, advanced filter%s. ','wpdev-booking'),'<strong>','</strong>','<strong>','</strong>'); ?> <br/>
                    </p>
                    <p style="text-align:center;padding:10px 0px;">
                        <a href="http://wordpress.org/extend/plugins/booking-manager" class="button-primary" target="_blank">Download from wordpress</a>
                        <a href="http://ordersplugin.onlinebookingcalendar.com" class="button-primary" target="_blank">Demo site</a>
                    </p>

                </div>
            </div>
        </div>
                <?php } ?>


        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_users_permissions'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('User permissions Settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>

                                <tr valign="top">
                                    <td colspan="2"><div style="width:100%;">
                                        <span style="color:#21759B;cursor: pointer;font-weight: bold;"
                                           onclick="javascript: jQuery('#togle_settings_useraccess').slideToggle('normal');"
                                           style="text-decoration: none;font-weight: bold;font-size: 11px;">
                                           + <span style="border-bottom:1px dashed #21759B;"><?php _e('Show settings of user access level to admin menu', 'wpdev-booking'); ?></span>
                                        </span>
                                    </div>

                                    <table id="togle_settings_useraccess" style="display:none;" class="hided_settings_table">
                                        <tr valign="top">

                                            <th scope="row"><label for="start_day_weeek" ><?php _e('Booking calendar', 'wpdev-booking'); ?>:</label><br><?php _e('access level', 'wpdev-booking'); ?></th>
                                            <td>
                                                <select id="user_role_booking" name="user_role_booking">
                                                    <option <?php if($user_role_booking == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                                    <option <?php if($user_role_booking == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                                    <option <?php if($user_role_booking == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                                    <option <?php if($user_role_booking == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                                    <option <?php if($user_role_booking == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                                </select>
                                                <span class="description"><?php _e('Select user access level for this administration page', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="start_day_weeek" ><?php _e('Add booking', 'wpdev-booking'); ?>:</label><br><?php _e('access level', 'wpdev-booking'); ?></th>
                                            <td>
                                                <select id="user_role_addbooking" name="user_role_addbooking">
                                                    <option <?php if($user_role_addbooking == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                                    <option <?php if($user_role_addbooking == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                                    <option <?php if($user_role_addbooking == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                                    <option <?php if($user_role_addbooking == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                                    <option <?php if($user_role_addbooking == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                                </select>
                                                <span class="description"><?php _e('Select user access level for this administration page', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="start_day_weeek" ><?php _e('Settings', 'wpdev-booking'); ?>:</label><br><?php _e('access level', 'wpdev-booking'); ?></th>
                                            <td>
                                                <select id="user_role_settings" name="user_role_settings">
                                                    <option <?php if($user_role_settings == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                                    <option <?php if($user_role_settings == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                                    <option <?php if($user_role_settings == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                                    <option <?php if($user_role_settings == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                                    <option <?php if($user_role_settings == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                                </select>
                                                <span class="description"><?php _e('Select user access level for this administration page', 'wpdev-booking');?></span>
            <?php if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) { ?> <br/><span class="description" style="font-weight: bold;">You do not allow to change this items because right now you test DEMO</span> <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                    </td>
                                </tr>


                    </tbody></table>

        </div></div></div>

        <div class='meta-box'>
            <div <?php $my_close_open_win_id = 'bk_general_settings_uninstall'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                <h3 class='hndle'><span><?php _e('Uninstal / deactivation settings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                    <table class="form-table"><tbody>


                                <tr valign="top">
                                    <th scope="row"><label for="is_delete_if_deactive" ><?php _e('Delete booking data', 'wpdev-booking'); ?>:</label><br><?php _e('when plugin deactivated', 'wpdev-booking'); ?></th>
                                    <td><input id="is_delete_if_deactive" type="checkbox" <?php if ($is_delete_if_deactive == 'On') echo "checked"; ?>  value="<?php echo $is_delete_if_deactive; ?>" name="is_delete_if_deactive"/>
                                        <span class="description"><?php _e(' Check, if you want delete booking data during uninstalling plugin.', 'wpdev-booking');?></span>
                                    </td>
                                </tr>

                    </tbody></table>

        </div></div></div>

    </div>

    <div class="clear" style="height:10px;"></div>
    <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save Changes', 'wpdev-booking'); ?>" name="Submit"/>
    <div class="clear" style="height:10px;"></div>



</form>
            <?php
        }

        // Show window for purchase
        function showBuyWidow() {
            if ( strpos($_SERVER['SCRIPT_FILENAME'],'onlinebookingcalendar.com') === FALSE ) {
            ?>
                <div class='meta-box'>
                    <div  class="postbox gdrgrid" > <h3 class='hndle'><span>Professional / Premium / Premium + / Hotel Ed. versions </span></h3>
                        <div class="inside">
                            <p class="sub"><?php _e("Main difference features", 'wpdev-booking'); ?></p>
                            <div class="table">
                                <table><tbody>
                                        <tr class="first">
                                            <td class="first b" style="width: 53px;"><b><?php _e("Features", 'wpdev-booking'); ?>:</b></td>
                                            <td class="t"></td>
                                            <td class="b options comparision" style="color:#11cc11;"><b><?php _e("Free", 'wpdev-booking'); ?></b></td>
                                            <td class="b options comparision" style="color:#f71;"><b><?php _e("Paid", 'wpdev-booking'); ?></b></td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b" ><?php _e("Functionality", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("all existing functionality", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b" ><?php _e("Multi booking", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("several booking for 1 day", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Time", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("enter/select the booking time", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Form", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("fields customization", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Email", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("email customization", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Range selection", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("selection fixed several days", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Payment", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<strong><?php _e("PayPal and Sage payment support", 'wpdev-booking'); ?></strong>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Season", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<strong><?php _e("avalaibility filters", 'wpdev-booking'); ?></strong>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Rates cost", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<strong><?php _e("depends from season", 'wpdev-booking'); ?></strong>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Advanced cost", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("Depends from number of selected days", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Additional cost", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("Discounts / additional cost, depends from selection at form", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Several forms", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("Several booking forms", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Capacity of resources", 'wpdev-booking'); ?></td>
                                            <td class="t i">(<?php _e("can depends from numbrer of selected visitors", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><strong><?php _e("MultiUser support", 'wpdev-booking'); ?></strong></td>
                                            <td class="t i">(<?php _e("each user can have own bookings and booking resources", 'wpdev-booking'); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr>
                                            <td class="first b" ><?php _e("Cost", 'wpdev-booking'); ?></td>
                                            <td class="t"><?php  ?></td>
                                            <td class="t options comparision" style="border-right:1px solid #ddd;"><?php _e("free", 'wpdev-booking'); ?></td>
                                            <td class="t options comparision"><?php _e("start", 'wpdev-booking'); ?> $119</td>
                                        </tr>
                                        <tr class="last">
                                            <td class="first b" ><?php _e("Live demo", 'wpdev-booking'); ?></td>
                                            <td class="t" colspan="3"> <a href="http://onlinebookingcalendar.com/demo/" target="_blank"> link</a>
                                            </td>

                                        </tr>
                                        <tr class="last">
                                            <!--td class="first b"><span><?php _e("Purchase", 'wpdev-booking'); ?></span></td-->
                                            <td colspan="4" style="text-align:right;font-size: 18px;font-weight:normal;" class="t comparision"> <a class="buttonlinktext"  href="http://onlinebookingcalendar.net/purchase/" target="_blank"><?php _e("Buy now", 'wpdev-booking'); ?></a> </td>
                                        </tr>

                                    </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>


            <?php
            }
        }

        //Show help info
        function show_help($version = 'pro') {

            $version = $this->get_version();
            if (( ! isset($_GET['tab']) ) || (empty($_GET['tab'])) )   $tab = 'main';
            else                            $tab = $_GET['tab'] ;

            if ( ($version == 'free') && ($tab != 'buy') ){

                echo '<div id="no-reservations"  class="info_message textleft" style="font-size:12px;">';


                ?><div style="text-align:center;margin:10px auto;">
                <?php if($tab == 'payment') { ?>
                         <h2><?php printf(__('This functionality exist at the %sBooking Calendar%s %sPremium%s, %sPremium Plus%s and %sHotel Edition%s', 'wpdev-booking'),'<span style="color:#fa1;">','</span>', '<a href="http://premium.onlinebookingcalendar.com/wp-admin/" class="color_premium" >','</a>','<a href="http://premiumplus.onlinebookingcalendar.com/wp-admin/" class="color_premium_plus" >','</a>','<a href="http://hotel.onlinebookingcalendar.com/wp-admin/" class="color_hotel" >','</a>'); ?></h2>
                    <?php } elseif (($tab == 'cost') || ($tab == 'filter')) { ?>
                         <h2><?php printf(__('This functionality exist at the %sBooking Calendar%s %sPremium Plus%s and %sHotel Edition%s', 'wpdev-booking'),'<span style="color:#f50;">','</span>','<a href="http://premiumplus.onlinebookingcalendar.com/wp-admin/" class="color_premium_plus" >','</a>', '<a href="http://hotel.onlinebookingcalendar.com/wp-admin/" class="color_hotel" >','</a>'); ?></h2>
                    <?php } elseif (($tab == 'resources')  ) { ?>
                         <h2><?php printf(__('This functionality exist at the %sBooking Calendar%s %sHotel Edition%s', 'wpdev-booking'),'<span style="color:#fa1;">','</span>' , '<a href="http://hotel.onlinebookingcalendar.com/wp-admin/" class="color_hotel" >','</a>'); ?></h2>
                    <?php } elseif (($tab == 'users')  ) { ?>
                         <h2><?php printf(__('This functionality exist at the %sBooking Calendar%s %sMultiUser%s version only', 'wpdev-booking'),'<span style="color:#fa1;">','</span>' , '<a href="http://multiuser.onlinebookingcalendar.com/wp-admin/" class="color_hotel" >','</a>'); ?></h2>
                    <?php } else { ?>
                         <h2><?php printf(__('This functionality exist at the %sBooking Calendar%s %sProfessional%s, %sPremium%s, %sPremium Plus%s and %sHotel Edition%s', 'wpdev-booking'),'<span style="color:#fa1;">','</span>','<a href="http://pro.onlinebookingcalendar.com/wp-admin/" class="color_pro" >','</a>','<a href="http://premium.onlinebookingcalendar.com/wp-admin/" class="color_premium" >','</a>','<a href="http://premiumplus.onlinebookingcalendar.com/wp-admin/" class="color_premium_plus" >','</a>','<a href="http://hotel.onlinebookingcalendar.com/wp-admin/" class="color_hotel" >','</a>'); ?></h2>
                    <?php } ?>
                         <h2><?php printf(__('Check %sfeatures%s of each versions, test %sonline demo%s and %sbuy%s.', 'wpdev-booking'),
                        '<a href="http://onlinebookingcalendar.com/features/" target="_blank" style="color:#1155bb;text-decoration:underline;">', '</a>',
                        '<a href="http://onlinebookingcalendar.com/demo/" target="_blank" style="color:#1155bb;text-decoration:underline;">', '</a>',
                        '<a href="http://onlinebookingcalendar.net/purchase/" target="_blank"  style="color:#1155bb;text-decoration:underline;">', '</a>'
                ); ?></h2>
                </div>

                <?php if ($tab == 'users')  { ?>
                <div> <h2> Features: </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">

 <li>Creation of sites, where can be several property owners (users) at the same time. Each owner will see only his booking resources and bookings. Posibility to make <strong>independent customization of forms fields, emails, payments and so on for each owner</strong>.</li>
 <li>Posibility to Activate and Deactivate wordpress users for using Booking system </li>
 <li>Independent, seperate configuration of form fields for each active non super booking admin user </li>
 <li>Independent, seperate configuration of email templates for each active non super booking admin user </li>
 <li>Independent, seperate configuration of costs and payments options for each active non super booking admin user </li>
 <li>Independent, seperate configuration of rates, advanced cost management and season availability for each active non super booking admin user </li>
</ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'form')  { ?>
                <div> <h2> Features: </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Flexible configuration of booking form fields, for showing at client side
                            <br />&nbsp;&nbsp;&nbsp;<span style="font-style:italic;">[<span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions support fields for entering or selection time of booking]</span></li>
                        <li>Configuration of "content" data, which is showen at emails and pending and approved tables at this <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME; ?>wpdev-booking">page</a></li>
                    </ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'email')  { ?>
                <div> <h2> Features. Flexible configuration of email templates: </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Email template for sending <strong>to admin after new reservation</strong> is done <span style="font-style:italic;">[ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Email template for sending <strong>to person after new reservation</strong> is done <span style="font-style:italic;">[ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Email template for sending <strong>to person after approval of booking</strong><span style="font-style:italic;"> [ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Email template for sending <strong>to person after cancellation of booking</strong><span style="font-style:italic;"> [ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Email template for sending <strong>to person after modification of booking</strong><span style="font-style:italic;"> [ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Email template for sending <strong>payment request to person</strong><span style="font-style:italic;"> [ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                    </ul>
                </div>
                <?php } ?>


                <?php if ($tab == 'payment')  { ?>
                <div> <h2> Features. </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Setting <strong>cost</strong> (per day/per night/fixed) for each booking resource <span style="font-style:italic;">[ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Configuration of <strong>Paypal and Sage</strong> payment system <span style="font-style:italic;">[ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Configuration of <strong>additional cost</strong>, which is depended from selection at selectboxes or checkboxes. <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                    </ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'cost')  { ?>
                <div> <h2> Features. </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <!--li>Configuration of <strong>capacity</strong>, for booking resources. Several bookings at the same day, even at the same time for same booking resource. <span style="font-style:italic;">[ <span class="color_hotel" >Hotel Edition only !</span>]</span></li>
                        <br/-->
                        <li>Configuration of dates <strong>availability</strong>, based on season filter settings. <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Configuration of <strong>rates</strong> (diferent costs),  based on season filter settings. <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Configuration of <strong>cost, which is depends from number of selected days</strong> for booking. <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <br />
                        <li><strong>Coupon discount systems</strong> - a way to have discounts. Customers can enter a promo code and they get some discounts <span style="font-style:italic;">[ Support: <span class="color_hotel" >Hotel Edition</span> version]</span></li>
                    </ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'resources')  { ?>
                <div> <h2> Features. </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Configuration of <strong>capacity</strong>, for booking resources. Several bookings at the same day, even at the same time for same booking resource. <span style="font-style:italic;">[ <span class="color_hotel" >Hotel Edition only !</span>]</span></li>

                    </ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'filter')  { ?>
                <div> <h2> Features. </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Configuration of <strong>season filter</strong>, which is used at the <strong>rates</strong> and <strong>availability</strong> systems. <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                    </ul>
                </div>
                <?php } ?>

                <?php if ($tab == 'main')  { ?>
                <div> <h2> Features. </h2>
                    <ul style="font-size:13px; font-style:normal; list-style:disc inside none; text-shadow:0 0 1px #CCCCCC;">
                        <li>Setting URL for <strong>booking editing or cancellation by visitor</strong> <span style="font-style:italic;">[ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Setting <strong>default booking resource</strong> for auto open at booking page <span style="font-style:italic;">[ Support: <span class="color_pro" >Professional</span>, <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <br />
                        <li>Setting <strong>time format</strong> <span style="font-style:italic;">[ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Setting <strong>range selections</strong> (week selections or any other number of days)<span style="font-style:italic;">[ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <li>Setting <strong>fixed time</strong> for booking form <span style="font-style:italic;">[ Support: <span class="color_premium" >Premium</span>, <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <br />
                        <li>Showing <strong>day cost</strong> at calendar <span style="font-style:italic;">[ Support: <span class="color_premium_plus">Premium Plus</span> and <span class="color_hotel" >Hotel Edition</span> versions]</span></li>
                        <br />
                        <li>Showing <strong>availability (capacity) of days</strong> at calendar <span style="font-style:italic;">[ Support: <span class="color_hotel" >Hotel Edition</span> version]</span></li>
                        <li>Setting <strong>capacity dependence </strong> from number of visitors selection at booking form <span style="font-style:italic;">[ Support: <span class="color_hotel" >Hotel Edition</span> version]</span></li>

                    </ul>
                </div>
                <?php } ?>

                         <?php
                echo '</div><div style="clear:both;height:10px;"></div>';

                    ?>
                        <div style="clear:both;"></div>
                        <div style="margin:0px 5px auto;text-align:center;"> <?php
                        switch ($_GET['tab']) {
                            case 'form':  ?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_form_pro.png" style="margin:0px 0px 20px auto;" >   <?php break;
                            case 'email': ?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_emails_pro.png" style="margin:0px 0px 20px auto;" > <?php break;
                            case 'payment':?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_payment_pro.png" style="margin:0px 0px 20px auto;" ><?php break;
                            case 'cost': ?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_rates_pro.png" style="margin:0px 0px 20px auto;" >  <?php break;
                            case 'resources': ?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_resources.png" style="margin:0px 0px 20px auto;" >  <?php break;
                            case 'filter':?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_season_pro.png" style="margin:0px 0px 20px auto;" > <?php break;
                            case 'users':?> <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/booking_users.png" style="margin:0px 0px 20px auto;" > <?php break;
                        }
                        ?></div>
                        <div style="clear:both;"></div>
                    <?php
            }
            return false;
        }

        /// Show footer info
        function show_footer_at_booking_page(){
            ?>
            <div  class="copyright_info" style="">
                <div style="width:580px;height:10px;margin:auto;">
                    <img alt="" src="<?php echo WPDEV_BK_PLUGIN_URL ; ?>/img/contact-32x32.png"  align="center" style="float:left;">
                    <div style="margin: 2px 0px 0px 20px; float: left; text-align: center;">
                        <?php _e('More Information about this Plugin can be found at the', 'wpdev-booking');?> <a href="http://onlinebookingcalendar.com/faq/" target="_blank" style="text-decoration:underline;"><?php _e('Booking calendar', 'wpdev-booking');?></a>.<br>
                        <a href="http://www.wpdevelop.com" target="_blank" style="text-decoration:underline;"  valign="middle">www.wpdevelop.com</a> <?php _e(' - custom wp-plugins and wp-themes development, WordPress solutions', 'wpdev-booking');?><br>
                    </div>
                </div>
            </div>
            <?php
        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   S I D E B A R    W I D G E T   ">
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // S I D E B A R    W I D G E T
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Add widjet controlls
        function booking_widget_control() {

            if (isset($_POST['booking_widget_title'] )) {

                update_bk_option( 'booking_widget_title', htmlspecialchars($_POST['booking_widget_title']));
                update_bk_option( 'booking_widget_show',  $_POST['booking_widget_show']);
                if( $this->wpdev_bk_pro !== false ) {
                    update_bk_option( 'booking_widget_type',  $_POST['booking_widget_type']);
                }
                update_bk_option( 'booking_widget_calendar_count',  $_POST['booking_widget_calendar_count']);

                $booking_widget_last_field = htmlspecialchars($_POST['booking_widget_last_field']);
                $booking_widget_last_field = str_replace('\"', "'" , $booking_widget_last_field);
                $booking_widget_last_field = str_replace("\'", "'" , $booking_widget_last_field);
                update_bk_option( 'booking_widget_last_field', $booking_widget_last_field );
            }
            $booking_widget_title = get_bk_option( 'booking_widget_title');
            $booking_widget_show  =  get_bk_option( 'booking_widget_show');
            if( $this->wpdev_bk_pro !== false ) {
                $booking_widget_type  =  get_bk_option( 'booking_widget_type');
            } else $booking_widget_type=1;
            $booking_widget_calendar_count  =  get_bk_option( 'booking_widget_calendar_count');
            $booking_widget_last_field = get_bk_option( 'booking_widget_last_field');

            ?>

<p>
    <label><?php _e('Title', 'wpdev-booking'); ?>:</label><br/>
    <input value="<?php echo $booking_widget_title; ?>" name="booking_widget_title" id="booking_widget_title" type="text" style="width:100%;" />
</p>

<p>
    <label><?php _e('Show', 'wpdev-booking'); ?>:</label><br/>
    <select id="booking_widget_show" name="booking_widget_show"  style="width:100%;">
        <option <?php if($booking_widget_show == 'booking_calendar') echo "selected"; ?> value="booking_calendar"><?php _e('Booking calendar', 'wpdev-booking'); ?></option>
        <option <?php if($booking_widget_show == 'booking_form') echo "selected"; ?> value="booking_form"><?php _e('Booking form', 'wpdev-booking'); ?></option>
    </select>
</p>


            <?php
            if( $this->wpdev_bk_pro !== false ) {
                $types_list = $this->wpdev_bk_pro->get_booking_types();
//debuge($types_list);
                ?>
<p>
    <label><?php _e('Booking resource', 'wpdev-booking'); ?>:</label><br/>
    <!--input id="calendar_type"  name="calendar_type" class="input" type="text" -->
    <select id="booking_widget_type" name="booking_widget_type"  style="width:100%;">
                <?php foreach ($types_list as $tl) { ?>
        <option  <?php if($booking_widget_type == $tl->id ) echo "selected"; ?>
            style="<?php if  (isset($tl->parent)) if ($tl->parent == 0 ) { echo 'font-weight:bold;'; } else { echo 'font-size:11px;padding-left:20px;'; } ?>"
            value="<?php echo $tl->id; ?>"><?php echo $tl->title; ?></option>
                    <?php } ?>
    </select>

</p>
                <?php } ?>

<p>
    <label><?php _e('Number of calendars', 'wpdev-booking'); ?>:</label><br/>
    <input value="<?php echo $booking_widget_calendar_count; ?>" name="booking_widget_calendar_count" id="booking_widget_calendar_count" type="text" style="width:100%;" />
</p>

<p>
    <label><?php _e('Footer', 'wpdev-booking'); ?>:</label><br/>
    <input value="<?php echo $booking_widget_last_field; ?>" name="booking_widget_last_field" id="booking_widget_last_field" type="text" style="width:100%;" /><br/>
    <label><?php printf(__("Example: %sMake booking here%s", 'wpdev-booking'),"<code>&lt;a href='LINK'&gt;",'&lt;/a&gt;</code>'); ?></label>
</p>

<p>
            <?php printf(__("%sImportant!!!%s Please note, if you show booking calendar (inserted into post/page) with widget at the same page, then the last will not be visible.", 'wpdev-booking'),'<strong>','</strong><br/>'); ?>
</p>
            <?php
        }

        // Init widjets
        function add_booking_widjet() {

            $widget_options = array('classname' => 'widget_wpdev_booking', 'description' => __( "Display Booking.", 'wpdev-booking') );
            wp_register_sidebar_widget('wpdev_booking_widget', __('Booking', 'wpdev-booking'), 'show_booking_widget_php4', $widget_options);
            wp_register_widget_control('wpdev_booking_widget', __('Booking settings', 'wpdev-booking'), array(&$this, 'booking_widget_control') );
        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="    J S    &   C S S     F I L E S     &     V a r i a b l e s ">
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //    J S    &   C S S     F I L E S     &     V a r i a b l e s
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                // add hook for printing scripts only at this plugin page
                function on_add_admin_js_files() {
                    // Write inline scripts and CSS at HEAD
                    add_action('admin_head', array(&$this, 'head_print_js_css_admin' ), 1);
                }

                // HEAD for ADMIN page
                function head_print_js_css_admin() {
                    $this->print_js_css(1);
                }

                // Head of Client side - including JS Ajax function
                function client_side_print_booking_head() {
                    // Write calendars script
                    $this->print_js_css(0);
                }

                // Write copyright notice if its saved
                function wp_footer() {
                    if ( ( get_bk_option( 'booking_wpdev_copyright' )  == 'On' ) && (! defined('WPDEV_COPYRIGHT')) ) {
                        printf(__('%sPowered by wordpress plugins developed by %s', 'wpdev-booking'),'<span style="font-size:9px;text-align:center;margin:0 auto;">','<a href="http://www.wpdevelop.com" target="_blank">www.wpdevelop.com</a></span>','&amp;');
                        define('WPDEV_COPYRIGHT',  1 );
                    }
                }


        //JS at footer  in Admin Panel - Booking page
        function print_js_at_footer() {
            if ( ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking')!==false) &&
                    ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking-reservation')===false )
            ) {

                $additional_bk_types = array();

                $bk_resources = array(array('id'=>$this->get_default_type()));

                if (isset($_GET['booking_type']))
                    if ($_GET['booking_type']=='-1')
                        if( $this->wpdev_bk_pro !== false )
                            $bk_resources = $this->wpdev_bk_pro->get_booking_types();

                if (isset($_GET['parent_res']))
                    if (($_GET['parent_res']=='1') && ( $this->get_version() == 'hotel' )) {
                        $bk_resources = apply_bk_filter('get_bk_resources_in_hotel' );
                    }

                foreach ($bk_resources as $value) {

                    if (gettype($value) == 'array') $bk_type = $value['id'];
                    else $bk_type = $value->id;


                    if ( strpos($bk_type,';') !== false ) {
                        $additional_bk_types = explode(';',$bk_type);
                        $bk_type = $additional_bk_types[0];
                    }

                    //  $bk_type = $this->get_default_type();  // Previos value

                    $my_boook_type = $bk_type ;

                    $start_script_code = "<script type='text/javascript'>";
                    $start_script_code .= "  jWPDev(document).ready( function(){";

                    $start_script_code .= apply_filters('wpdev_booking_availability_filter', '', $bk_type);

                    // Blank days //////////////////////////////////////////////////////////////////
                    $start_script_code .= "  date_admin_blank[". $bk_type. "] = [];";
                    $dates_and_time_for_admin_blank = $this->get_dates('admin_blank', $bk_type, $additional_bk_types);
                    $dates_blank = $dates_and_time_for_admin_blank[0];
                    $times_blank = $dates_and_time_for_admin_blank[1];
                    $i=-1;
                    foreach ($dates_blank as $date_blank) {
                        $i++;

                        $td_class =   ($date_blank[1]+0). "-" . ($date_blank[2]+0). "-". $date_blank[0];

                        $start_script_code .= " if (typeof( date_admin_blank[". $bk_type. "][ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date_admin_blank[". $bk_type. "][ '". $td_class . "' ] = [];} ";

                        $start_script_code .= "  date_admin_blank[". $bk_type. "][ '". $td_class . "' ][  date_admin_blank[".$bk_type."]['".$td_class."'].length  ] = [".
                                ($date_blank[1]+0).", ". ($date_blank[2]+0).", ". ($date_blank[0]+0).", ".
                                ($times_blank[$i][0]+0).", ". ($times_blank[$i][1]+0).", ". ($times_blank[$i][2]+0).
                                "];";
                    }
                    ////////////////////////////////////////////////////////////////////////////////


                    $start_script_code .= "  date2approve[". $bk_type. "] = [];";
                    $dates_and_time_to_approve = $this->get_dates('0', $bk_type, $additional_bk_types);
                    $dates_to_approve = $dates_and_time_to_approve[0];
                    $times_to_approve = $dates_and_time_to_approve[1];
                    $i=-1;
                    foreach ($dates_to_approve as $date_to_approve) {
                        $i++;

                        $td_class =   ($date_to_approve[1]+0). "-" . ($date_to_approve[2]+0). "-". $date_to_approve[0];

                        $start_script_code .= " if (typeof( date2approve[". $bk_type. "][ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date2approve[". $bk_type. "][ '". $td_class . "' ] = [];} ";

                        $start_script_code .= "  date2approve[". $bk_type. "][ '". $td_class . "' ][  date2approve[".$bk_type."]['".$td_class."'].length  ] = [".
                                ($date_to_approve[1]+0).", ". ($date_to_approve[2]+0).", ". ($date_to_approve[0]+0).", ".
                                ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                "];";
                    }

                    $start_script_code .= "  var date_approved_par = [];";
                    //$dates_approved = $this->get_dates('1',$my_boook_type);// [ Year, Month,Day ]...
                    $dates_and_time_to_approve = $this->get_dates('1', $my_boook_type, $additional_bk_types);
                    $dates_approved =   $dates_and_time_to_approve[0];
                    $times_to_approve = $dates_and_time_to_approve[1];
                    $i=-1;
                    foreach ($dates_approved as $date_to_approve) {
                        $i++;

                        $td_class =   ($date_to_approve[1]+0)."-".($date_to_approve[2]+0)."-".($date_to_approve[0]);

                        $start_script_code .= " if (typeof( date_approved_par[ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date_approved_par[ '". $td_class . "' ] = [];} ";

                        $start_script_code.=" date_approved_par[ '".$td_class."' ][  date_approved_par['".$td_class."'].length  ] = [".
                                ($date_to_approve[1]+0).",".($date_to_approve[2]+0).",".($date_to_approve[0]+0).", ".
                                ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                "];";
                    }

                    $cal_count = get_user_option( 'booking_admin_calendar_count');
                    if ($cal_count === false) $cal_count = 2;
                    $start_script_code .= "     init_datepick_cal('". $bk_type ."',   date_approved_par, ".
                            //get_bk_option( 'booking_admin_cal_count' ).
                            $cal_count .
                            ", ".
                            get_bk_option( 'booking_start_day_weeek' ) . " );";
                    $start_script_code .= "});";
                    $start_script_code .= "</script>";
                    $start_script_code = apply_filters('wpdev_booking_calendar', $start_script_code , $my_boook_type);
                    echo $start_script_code;

                } //TODO: HERE_EDITED

            }
            $is_use_hints = get_bk_option( 'booking_is_use_hints_at_admin_panel'  );
            if ($is_use_hints == 'On')
                if (  ( ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.php')) !== false) && (   ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking-reservation'))  === false) ) { ?>
                <script type="text/javascript" >
                    jWPDev('.tipcy').tipsy({
                        delayIn: 1000,      // delay before showing tooltip (ms)
                        delayOut: 0,     // delay before hiding tooltip (ms)
                        fade: true,     // fade tooltips in/out?
                        fallback: '',    // fallback text to use when no tooltip text
                        gravity: 'n',    // gravity
                        html: false,     // is tooltip content HTML?
                        live: false,     // use live event support?
                        offset: 40,       // pixel offset of tooltip from element
                        opacity: 0.9,    // opacity of tooltip
                        title: 'title'});
                </script> <?php }

        }

        // Print     J a v a S cr i p t   &    C S S    scripts for admin and client side.
        function print_js_css($is_admin =1 ) {

            if (! ( $is_admin))  wp_print_scripts('jquery');
            //wp_print_scripts('jquery-ui-core');

            //   J a v a S c r i pt
            ?> <!-- Booking Calendar Scripts --> <?php
            $is_use_hints = get_bk_option( 'booking_is_use_hints_at_admin_panel'  );
            if ($is_use_hints == 'On') {
                if ( $is_admin) { ?>  <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/tooltip2/src/javascripts/jquery.tipsy.js"></script> <?php }
                if ( $is_admin) { ?>  <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/tooltip2/src/stylesheets/tipsy.css" rel="stylesheet" type="text/css" /> <?php }
            }
            ?>
<script  type="text/javascript">
    var jWPDev = jQuery.noConflict();
    var wpdev_bk_plugin_url = '<?php echo WPDEV_BK_PLUGIN_URL; ?>';
    var wpdev_bk_today = new Array( parseInt(<?php echo  date_i18n('Y') .'),  parseInt('. date_i18n('m').'),  parseInt('. date_i18n('d').'),  parseInt('. date_i18n('H').'),  parseInt('. date_i18n('i') ; ?>)  );
    var visible_booking_id_on_page = [];
    var booking_max_monthes_in_calendar = '<?php echo get_bk_option( 'booking_max_monthes_in_calendar'); ?>';
    var user_unavilable_days = [];
            <?php if ( isset( $_GET['booking_hash']  ) ) { ?>
                var wpdev_bk_edit_id_hash = '<?php echo $_GET['booking_hash']; ?>';
                <?php } else { ?>
                    var wpdev_bk_edit_id_hash = '';
                <?php }  ?>
            <?php
            if ( get_bk_option( 'booking_unavailable_day0') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 0; ';
            if ( get_bk_option( 'booking_unavailable_day1') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 1; ';
            if ( get_bk_option( 'booking_unavailable_day2') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 2; ';
            if ( get_bk_option( 'booking_unavailable_day3') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 3; ';
            if ( get_bk_option( 'booking_unavailable_day4') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 4; ';
            if ( get_bk_option( 'booking_unavailable_day5') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 5; ';
            if ( get_bk_option( 'booking_unavailable_day6') == 'On' ) echo ' user_unavilable_days[user_unavilable_days.length] = 6; ';
            ?>
                // Check for correct URL based on Location.href URL, its need for correct aJax request
                var real_domain = window.location.href;
                var start_url = '';
                var pos1 = real_domain.indexOf('//'); //get http
                if (pos1 > -1 ) { start_url= real_domain.substr(0, pos1+2); real_domain = real_domain.substr(pos1+2);   }  //set without http
                real_domain = real_domain.substr(0, real_domain.indexOf('/') );    //setdomain
                var pos2 = wpdev_bk_plugin_url.indexOf('//');  //get http
                if (pos2 > -1 ) wpdev_bk_plugin_url = wpdev_bk_plugin_url.substr(pos2+2);    //set without http
                wpdev_bk_plugin_url = wpdev_bk_plugin_url.substr( wpdev_bk_plugin_url.indexOf('/') );    //setdomain
                wpdev_bk_plugin_url = start_url + real_domain + wpdev_bk_plugin_url;
                ///////////////////////////////////////////////////////////////////////////////////////

                var wpdev_bk_plugin_filename = '<?php echo WPDEV_BK_PLUGIN_FILENAME; ?>';
            <?php if (  ( get_bk_option( 'booking_multiple_day_selections' ) == 'Off') && ( get_bk_option( 'booking_range_selection_is_active') !== 'On' )  ) { ?>
                var multiple_day_selections = 0;
                <?php } else { ?>
                    var multiple_day_selections = 50;
                <?php } ?>
                    var wpdev_bk_pro =<?php if(  $this->wpdev_bk_pro !== false  ) {
                echo '1';
            } else {
                echo '0';
            } ?>;
                var wpdev_bk_is_dynamic_range_selection = false;
                var message_verif_requred = '<?php _e('This field is required', 'wpdev-booking'); ?>';
                var message_verif_requred_for_check_box = '<?php _e('This checkbox must be checked', 'wpdev-booking'); ?>';
                var message_verif_emeil = '<?php _e('Incorrect email field', 'wpdev-booking'); ?>';
                var message_verif_selectdts = '<?php _e('Please, select reservation date(s) at Calendar.', 'wpdev-booking'); ?>';
                var parent_booking_resources = [];

                var new_booking_title= '<?php echo str_replace("'","\'", __( get_bk_option( 'booking_title_after_reservation' ) , 'wpdev-booking')   ); ?>';
                var new_booking_title_time= <?php echo get_bk_option( 'booking_title_after_reservation_time' ); ?>;
                var type_of_thank_you_message = '<?php echo str_replace("'","\'",get_bk_option( 'booking_type_of_thank_you_message' )); ?>';
                var thank_you_page_URL = '<?php echo str_replace("'","\'",get_bk_option( 'booking_thank_you_page_URL' )); ?>';
                var is_am_pm_inside_time = false;
                <?php $my_booking_time_format = get_bk_option( 'booking_time_format'   );
                if (  (strpos($my_booking_time_format, 'a')!== false) || (strpos($my_booking_time_format, 'A')!== false) )  echo ' is_am_pm_inside_time = true; '; ?>
</script>
            <?php do_action('wpdev_bk_js_define_variables');
            ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/datepick/jquery.datepick.js"></script>  <?php
            $locale = get_locale();  //$locale = 'fr_FR'; // Load translation for calendar
            if ( ( !empty( $locale ) ) && ( substr($locale,0,2) !== 'en')  )
                if (file_exists(WPDEV_BK_PLUGIN_DIR. '/js/datepick/jquery.datepick-'. substr($locale,0,2) .'.js')) {
                    ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/datepick/jquery.datepick-<?php echo substr($locale,0,2); ?>.js"></script>  <?php
                }
            ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/wpdev.bk.js"></script>  <?php
            ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/tooltip/tools.tooltip.min.js"></script>  <?php

            do_action('wpdev_bk_js_write_files')
                    ?> <!-- End Booking Calendar Scripts --> <?php

            //    C S S
            ?> <link href="<?php echo get_bk_option( 'booking_skin'); ?>" rel="stylesheet" type="text/css" /> <?php

            //   Admin and Client
            if($is_admin) { ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/admin.css" rel="stylesheet" type="text/css" />  <?php
                ?>
                            <style type="text/css">
                                #wpdev-booking-general .datepick-inline {
                <?php
                $cal_count = get_user_option( 'booking_admin_calendar_count');
                if ($cal_count === false) $cal_count = 2;
                $calendars__count = $cal_count;
                if ($calendars__count>3) {
                    $calendars__count =3;
                }  ?>
                <?php echo ' width:' . (309*$calendars__count) . 'px !important;'; ?>
                                }
                                .datepick-one-month  {height:320px;}
                            </style> <?php
            } else {
                if ( strpos($_SERVER['REQUEST_URI'],'wp-admin/admin.php?') !==false ) {
                    ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/admin.css" rel="stylesheet" type="text/css" />  <?php
                }
                ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/client.css" rel="stylesheet" type="text/css" /> <?php

            }

        }

        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   C L I E N T   S I D E     &    H O O K S ">
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //   C L I E N T   S I D E     &    H O O K S
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                // Get scripts for calendar activation
                function get_script_for_calendar($bk_type, $additional_bk_types, $my_selected_dates_without_calendar, $my_boook_count ){

                    $my_boook_type = $bk_type;
                    $start_script_code = "<script type='text/javascript'>";
                    $start_script_code .= "  jWPDev(document).ready( function(){";

                    // Blank days //////////////////////////////////////////////////////////////////
                    $start_script_code .= "  date_admin_blank[". $bk_type. "] = [];";
                    $dates_and_time_for_admin_blank = $this->get_dates('admin_blank', $bk_type, $additional_bk_types);
                    $dates_blank = $dates_and_time_for_admin_blank[0];
                    $times_blank = $dates_and_time_for_admin_blank[1];
                    $i=-1;
                    foreach ($dates_blank as $date_blank) {
                        $i++;

                        $td_class =   ($date_blank[1]+0). "-" . ($date_blank[2]+0). "-". $date_blank[0];

                        $start_script_code .= " if (typeof( date_admin_blank[". $bk_type. "][ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date_admin_blank[". $bk_type. "][ '". $td_class . "' ] = [];} ";

                        $start_script_code .= "  date_admin_blank[". $bk_type. "][ '". $td_class . "' ][  date_admin_blank[".$bk_type."]['".$td_class."'].length  ] = [".
                                ($date_blank[1]+0).", ". ($date_blank[2]+0).", ". ($date_blank[0]+0).", ".
                                ($times_blank[$i][0]+0).", ". ($times_blank[$i][1]+0).", ". ($times_blank[$i][2]+0).
                                "];";
                    }
                    ////////////////////////////////////////////////////////////////////////////////

                    $start_script_code .= "  date2approve[". $bk_type. "] = [];";
                    $dates_and_time_to_approve = $this->get_dates('0', $bk_type, $additional_bk_types);
        //$dates_and_time_to_approve =  array(array(),array());

        //$dates_and_time_to_approve = array(array(),array()); // Matteo customization
                    $dates_to_approve = $dates_and_time_to_approve[0];
                    $times_to_approve = $dates_and_time_to_approve[1];
                    $i=-1;
                    foreach ($dates_to_approve as $date_to_approve) {
                        $i++;

                        $td_class =   ($date_to_approve[1]+0). "-" . ($date_to_approve[2]+0). "-". $date_to_approve[0];

                        $start_script_code .= " if (typeof( date2approve[". $bk_type. "][ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date2approve[". $bk_type. "][ '". $td_class . "' ] = [];} ";

                        $start_script_code .= "  date2approve[". $bk_type. "][ '". $td_class . "' ][  date2approve[".$bk_type."]['".$td_class."'].length  ] = [".
                                ($date_to_approve[1]+0).", ". ($date_to_approve[2]+0).", ". ($date_to_approve[0]+0).", ".
                                ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                "];";
                    }

                    $start_script_code .= "  var date_approved_par = [];";
                    $start_script_code .= apply_filters('wpdev_booking_availability_filter', '', $bk_type);
        //$dates_approved = $this->get_dates('1',$my_boook_type);// [ Year, Month,Day ]...
                    $dates_and_time_to_approve = $this->get_dates('1', $my_boook_type, $additional_bk_types);
        //$dates_and_time_to_approve =  array(array(),array());
                    $dates_approved =   $dates_and_time_to_approve[0];
                    $times_to_approve = $dates_and_time_to_approve[1];
                    $i=-1;
                    foreach ($dates_approved as $date_to_approve) {
                        $i++;

                        $td_class =   ($date_to_approve[1]+0)."-".($date_to_approve[2]+0)."-".($date_to_approve[0]);

                        $start_script_code .= " if (typeof( date_approved_par[ '". $td_class . "' ] ) == 'undefined'){ ";
                        $start_script_code .= " date_approved_par[ '". $td_class . "' ] = [];} ";

                        $start_script_code.=" date_approved_par[ '".$td_class."' ][  date_approved_par['".$td_class."'].length  ] = [".
                                ($date_to_approve[1]+0).",".($date_to_approve[2]+0).",".($date_to_approve[0]+0).", ".
                                ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                "];";
                    }

                    if ($my_selected_dates_without_calendar == '')
                        $start_script_code .= apply_filters('wpdev_booking_show_rates_at_calendar', '', $bk_type);
                    $start_script_code .= apply_filters('wpdev_booking_show_availability_at_calendar', '', $bk_type);
                    if ($my_selected_dates_without_calendar == '') {
                        $start_script_code .= apply_filters('wpdev_booking_get_additional_info_to_dates', '', $bk_type);
                        $start_script_code .= "     init_datepick_cal('". $my_boook_type ."', date_approved_par, ".
                                                    $my_boook_count ." , ". get_bk_option( 'booking_start_day_weeek' ) . ");  ";
                    }
                    $start_script_code .= "}); </script>";
                    //$start_script_code .= "<style type='text/css'> .tooltips{ font-family:Arial; font-size:12px; font-weight:normal;  line-height:16px; } </style>";

                    return $start_script_code;
                }

                // Get code of the legend here
                function get_legend(){
                    $my_result = '';
                    if (get_bk_option( 'booking_is_show_legend' ) == 'On') { //TODO: check here according legend
                        $my_result .= '<div class="block_hints datepick">';
                        $my_result .= '<div class="wpdev_hint_with_text"><div class="block_free datepick-days-cell"><a>#</a></div><div class="block_text">- '.__('Available','wpdev-booking') .'</div></div>';
                        $my_result .= '<div class="wpdev_hint_with_text"><div class="block_booked date_approved">#</div><div class="block_text">- '.__('Booked','wpdev-booking') .'</div></div>';
                        $my_result .= '<div class="wpdev_hint_with_text"><div class="block_pending date2approve">#</div><div class="block_text">- '.__('Pending','wpdev-booking') .'</div></div>';
                        if ($this->wpdev_bk_pro !== false)
                            if ($this->wpdev_bk_pro->wpdev_bk_premium !== false)
                                $my_result .= '<div class="wpdev_hint_with_text"><div class="block_time timespartly">#</div><div class="block_text">- '.__('Partially booked','wpdev-booking') .'</div></div>';
                        $my_result .= '</div><div class="wpdev_clear_hint"></div>';
                    }
                    return $my_result;
                }

        // Get form
        function get_booking_form($my_boook_type) {
            $my_form =  '<div style="text-align:left;">
                    <p>'.__('First Name (required)', 'wpdev-booking').':<br />  <span class="wpdev-form-control-wrap name'.$my_boook_type.'"><input type="text" name="name'.$my_boook_type.'" value="" class="wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Last Name (required)', 'wpdev-booking').':<br />  <span class="wpdev-form-control-wrap secondname'.$my_boook_type.'"><input type="text" name="secondname'.$my_boook_type.'" value="" class="wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Email (required)', 'wpdev-booking').':<br /> <span class="wpdev-form-control-wrap email'.$my_boook_type.'"><input type="text" name="email'.$my_boook_type.'" value="" class="wpdev-validates-as-email wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Phone', 'wpdev-booking').':<br />            <span class="wpdev-form-control-wrap phone'.$my_boook_type.'"><input type="text" name="phone'.$my_boook_type.'" value="" size="40" /></span> </p>
                    <p>'.__('Details', 'wpdev-booking').':<br />          <span class="wpdev-form-control-wrap details'.$my_boook_type.'"><textarea name="details'.$my_boook_type.'" cols="40" rows="10"></textarea></span> </p>';
            $my_form .=  '<p>[captcha]</p>';
            $my_form .=  '<p><input type="button" value="'.__('Send', 'wpdev-booking').'" onclick="mybooking_submit(this.form,'.$my_boook_type.');" /></p>
                    </div>';

            return $my_form;
        }

        // Get booking form
        function get_booking_form_action($my_boook_type=1,$my_boook_count=1, $my_booking_form = 'standard') {

            $res = $this->add_booking_form_action($my_boook_type,$my_boook_count, 0, $my_booking_form );
            return $res;

        }

        //Show booking form from action call - wpdev_bk_add_form
        function add_booking_form_action($bk_type =1, $cal_count =1, $is_echo = 1, $my_booking_form = 'standard', $my_selected_dates_without_calendar = '') {

            $is_booking_resource_exist = apply_bk_filter('wpdev_is_booking_resource_exist',true, $bk_type, $is_echo );
            if (! $is_booking_resource_exist) {
                if ( $is_echo )     echo '';
                return '';
            }

            make_bk_action('check_multiuser_params_for_client_side', $bk_type );

            $additional_bk_types = array();
            if ( strpos($bk_type,';') !== false ) {
                $additional_bk_types = explode(';',$bk_type);
                $bk_type = $additional_bk_types[0];
            }

            if (isset($_GET['booking_hash'])) {
                $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
                if ($my_booking_id_type != false)
                    if ($my_booking_id_type[1]=='') {
                        $my_result = __('Wrong booking hash in URL. Probably its expired.','wpdev-booking');
                        if ( $is_echo )            echo $my_result;
                        else                       return $my_result;
                        return;
                    }
            }

            if ($bk_type == '') {
                $my_result = __('Booking resource type is not defined. Its can be, when at the URL is wrong booking hash.','wpdev-booking');
                if ( $is_echo )            echo $my_result;
                else                       return $my_result;
                return;
            }

            $start_script_code = $this->get_script_for_calendar($bk_type, $additional_bk_types, $my_selected_dates_without_calendar, $cal_count );

            $my_result =  ' ' . $this->get__client_side_booking_content($bk_type, $my_booking_form, $my_selected_dates_without_calendar ) . ' ' . $start_script_code ;

            $my_result = apply_filters('wpdev_booking_form', $my_result , $bk_type);

            make_bk_action('finish_check_multiuser_params_for_client_side', $bk_type );

            if ( $is_echo )            echo $my_result;
            else                       return $my_result;


        }

        //Show only calendar from action call - wpdev_bk_add_calendar
        function add_calendar_action($bk_type =1, $cal_count =1, $is_echo = 1) {

            make_bk_action('check_multiuser_params_for_client_side', $bk_type );

            $additional_bk_types = array();
            if ( strpos($bk_type,';') !== false ) {
                $additional_bk_types = explode(';',$bk_type);
                $bk_type = $additional_bk_types[0];
            }

            if (isset($_GET['booking_hash'])) {
                $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
                if ($my_booking_id_type != false)
                    if ($my_booking_id_type[1]=='') {
                        $my_result = __('Wrong booking hash in URL. Probably its expired.','wpdev-booking');
                        if ( $is_echo )            echo $my_result;
                        else                       return $my_result;
                        return;
                    }
            }

            $start_script_code = $this->get_script_for_calendar($bk_type, $additional_bk_types, '' , $cal_count );

            $my_result = ' <div style="clear:both;height:10px;"></div>' .
                         '<div id="calendar_booking'.$bk_type.'">&nbsp;</div><textarea rows="3" cols="50" id="date_booking'.$bk_type.'" name="date_booking'.$bk_type.'" style="display:none;"></textarea>' ;

            $my_result .= $this->get_legend();                                  // Get Legend code here

            $my_result .=   ' ' . $start_script_code ;

            $my_result = apply_filters('wpdev_booking_calendar', $my_result , $bk_type);

            make_bk_action('finish_check_multiuser_params_for_client_side', $bk_type );

            if ( $is_echo )            echo $my_result;
            else                       return $my_result;


        }

        // Get content at client side of  C A L E N D A R
        function get__client_side_booking_content($my_boook_type = 1 , $my_booking_form = 'standard', $my_selected_dates_without_calendar = '') {

            $nl = '<div style="clear:both;height:10px;"></div>';                                                            // New line
            if ($my_selected_dates_without_calendar=='') {
                $calendar  = '<div id="calendar_booking'.$my_boook_type.'">&nbsp;</div>';
                if(  $this->wpdev_bk_pro == false  )   $calendar .= '<div style="font-size:9px;text-align:left;">Powered by <a href="http://onlinebookingcalendar.com" target="_blank">Booking Calendar</a></div>';
                $calendar .= '<textarea rows="3" cols="50" id="date_booking'.$my_boook_type.'" name="date_booking'.$my_boook_type.'" style="display:none;"></textarea>';   // Calendar code
            } else {
                $calendar = '';
                $calendar .= '<textarea rows="3" cols="50" id="date_booking'.$my_boook_type.'" name="date_booking'.$my_boook_type.'" style="display:none;">'.$my_selected_dates_without_calendar.'</textarea>';   // Calendar code
            }
            
            $calendar  .= $this->get_legend();                                  // Get Legend code here


            $form = '<div id="booking_form_div'.$my_boook_type.'" class="booking_form_div">';

            if(  $this->wpdev_bk_pro !== false  )   $form .= $this->wpdev_bk_pro->get_booking_form($my_boook_type, $my_booking_form);         // Get booking form
            else                                    $form .= $this->get_booking_form($my_boook_type);

            // Insert calendar into form
            if ( strpos($form, '[calendar]') !== false )  $form = str_replace('[calendar]', $calendar ,$form);
            else                                          $form = $calendar . $nl . $form ;

            $form = apply_bk_filter('wpdev_check_for_additional_calendars_in_form', $form, $my_boook_type );

            if ( strpos($form, '[captcha]') !== false ) {
                $captcha = $this->createCapthaContent($my_boook_type);
                $form =str_replace('[captcha]', $captcha ,$form);
            }

            $form = apply_filters('wpdev_booking_form_content', $form , $my_boook_type);
            // Add booking type field
            $form      .= '<input id="bk_type'.$my_boook_type.'" name="bk_type'.$my_boook_type.'" class="" type="hidden" value="'.$my_boook_type.'" /></div>';
            $submitting = '<div id="submiting'.$my_boook_type.'"></div><div class="form_bk_messages" id="form_bk_messages'.$my_boook_type.'" ></div>';

            $res = $form . $submitting;

            $my_random_id = time() * rand(0,1000);
            $my_random_id = 'form_id'. $my_random_id;
            //name="booking_form'.$my_boook_type.'"
            $return_form = '<div id="'.$my_random_id.'"><form  id="booking_form'.$my_boook_type.'"   class="booking_form" method="post" action=""><div id="ajax_respond_insert'.$my_boook_type.'"></div>' .
                    $res . '</form></div>';
            if ($my_selected_dates_without_calendar == '' ) {
                // Check according already shown Booking Calendar  and set do not visible of it
                $return_form .= '<script type="text/javascript">
                                    jWPDev(document).ready( function(){
                                        var visible_booking_id_on_page_num = visible_booking_id_on_page.length;
                                        if (visible_booking_id_on_page_num !== null ) {
                                            for (var i=0;i< visible_booking_id_on_page_num ;i++){
                                              if ( visible_booking_id_on_page[i]=="booking_form_div'.$my_boook_type.'" ) {
                                                  document.getElementById("'.$my_random_id.'").innerHTML = "'.__('Booking calendar for this booking resource are already at the page','wpdev-booking').'";
                                                  jWPDev("#'.$my_random_id.'").fadeOut(5000);
                                                  return;
                                              }
                                            }
                                            visible_booking_id_on_page[ visible_booking_id_on_page_num ]="booking_form_div'.$my_boook_type.'";
                                        }
                                    });
                                </script>';
            }
            return $return_form;
        }

        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="   S H O R T    C O D E S ">
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //   S H O R T    C O D E S
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Replace MARK at post with content at client side   -----    [booking nummonths='1' type='1']
        function booking_shortcode($attr) {

            if (isset($_GET['booking_hash'])) return __('You need to use special shortcode [bookingedit] for booking editing.','wpdev-booking');

            $my_boook_count = get_bk_option( 'booking_client_cal_count' );
            $my_boook_type = 1;
            $my_booking_form = 'standard';

            if ( isset( $attr['nummonths'] ) ) { $my_boook_count = $attr['nummonths'];  }
            if ( isset( $attr['type'] ) )      { $my_boook_type = $attr['type'];        }
            if ( isset( $attr['form_type'] ) ) { $my_booking_form = $attr['form_type']; }

            if ( isset( $attr['agregate'] ) ) {
                $additional_bk_types = $attr['agregate'];
                $my_boook_type .= ';'.$additional_bk_types;
            }

            $res = $this->add_booking_form_action($my_boook_type,$my_boook_count, 0 , $my_booking_form );

            return $res;
        }

        // Replace MARK at post with content at client side   -----    [booking nummonths='1' type='1']
        function booking_calendar_only_shortcode($attr) {
            $my_boook_count = get_bk_option( 'booking_client_cal_count' );
            $my_boook_type = 1;
            if ( isset( $attr['nummonths'] ) ) { $my_boook_count = $attr['nummonths']; }
            if ( isset( $attr['type'] ) )      { $my_boook_type = $attr['type'];       }
            if ( isset( $attr['agregate'] ) ) {
                $additional_bk_types = $attr['agregate'];
                $my_boook_type .= ';'.$additional_bk_types;
            }
            $res = $this->add_calendar_action($my_boook_type,$my_boook_count, 0 );
            return $res;
        }

        // Show only booking form, with already selected dates
        function bookingform_shortcode($attr) {

            $my_boook_type = 1;
            $my_booking_form = 'standard';
            $my_boook_count = 1;
            $my_selected_dates_without_calendar = '';

            if ( isset( $attr['type'] ) )           { $my_boook_type = $attr['type'];                                }
            if ( isset( $attr['form_type'] ) )      { $my_booking_form = $attr['form_type'];                         }
            if ( isset( $attr['selected_dates'] ) ) { $my_selected_dates_without_calendar = $attr['selected_dates']; }  //$my_selected_dates_without_calendar = '20.08.2010, 29.08.2010';

            $res = $this->add_booking_form_action($my_boook_type,$my_boook_count, 0 , $my_booking_form, $my_selected_dates_without_calendar );
            return $res;
        }

        // Show booking form for editing
        function bookingedit_shortcode($attr) {
            $my_boook_count = get_bk_option( 'booking_client_cal_count' );
            $my_boook_type = 1;
            $my_booking_form = 'standard';
            if ( isset( $attr['nummonths'] ) )   { $my_boook_count = $attr['nummonths'];  }
            if ( isset( $attr['type'] ) )        { $my_boook_type = $attr['type'];        }
            if ( isset( $attr['form_type'] ) )   { $my_booking_form = $attr['form_type']; }

            if (isset($_GET['booking_hash'])) {
                $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
                if ($my_booking_id_type !== false) {
                    $my_edited_bk_id = $my_booking_id_type[0];
                    $my_boook_type        = $my_booking_id_type[1];
                    if ($my_boook_type == '') return __('Wrong booking hash in URL. Probably hash is expired.','wpdev-booking');
                } else {
                    return __('Wrong booking hash in URL. Probably hash is expired.','wpdev-booking');
                }

            } else {
                return __('You do not set any parameters for booking editing','wpdev-booking');
            }

            $res = $this->add_booking_form_action($my_boook_type,$my_boook_count, 0 , $my_booking_form );

            if (isset($_GET['booking_pay'])) {
                // Payment form
                $res .= apply_bk_filter('wpdev_get_payment_form',$my_edited_bk_id, $my_boook_type );

            }

            return $res;

        }
        // </editor-fold>


        // <editor-fold defaultstate="collapsed" desc="  A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ">
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Activate
        function wpdev_booking_activate() {
            if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) add_bk_option( 'booking_admin_cal_count' ,'3');
            else                                                                       add_bk_option( 'booking_admin_cal_count' ,'2');
            add_bk_option( 'booking_skin', WPDEV_BK_PLUGIN_URL . '/css/skins/traditional.css');

            add_bk_option( 'booking_sort_order','id');
            add_bk_option( 'booking_sort_order_direction', 'ASC');

            add_bk_option( 'booking_max_monthes_in_calendar', '1y');
            add_bk_option( 'booking_client_cal_count', '1' );
            add_bk_option( 'booking_start_day_weeek' ,'0');
            add_bk_option( 'booking_title_after_reservation' , sprintf(__('Thank you for your online reservation. %s We will send confirmation of your booking as soon as possible.', 'wpdev-booking'), '<br/>') );
            add_bk_option( 'booking_title_after_reservation_time' , '7000' );
            add_bk_option( 'booking_type_of_thank_you_message' , 'message' );
            add_bk_option( 'booking_thank_you_page_URL' , get_option('siteurl') );


            add_bk_option( 'booking_date_format' , get_option('date_format') );
            add_bk_option( 'booking_date_view_type', 'short');    // short / wide
            if ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE ) add_bk_option( 'booking_is_delete_if_deactive' ,'On'); // check
            else                                                                       add_bk_option( 'booking_is_delete_if_deactive' ,'Off'); // check
            add_bk_option( 'booking_dif_colors_approval_pending' , 'On' );
            add_bk_option( 'booking_is_use_hints_at_admin_panel' , 'On' );
            add_bk_option( 'booking_multiple_day_selections' , 'On');

            add_bk_option( 'booking_unavailable_day0' ,'Off');
            add_bk_option( 'booking_unavailable_day1' ,'Off');
            add_bk_option( 'booking_unavailable_day2' ,'Off');
            add_bk_option( 'booking_unavailable_day3' ,'Off');
            add_bk_option( 'booking_unavailable_day4' ,'Off');
            add_bk_option( 'booking_unavailable_day5' ,'Off');
            add_bk_option( 'booking_unavailable_day6' ,'Off');

            if (
                    ( strpos($_SERVER['SCRIPT_FILENAME'],'onlinebookingcalendar.com') !== FALSE ) ||
                    ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE )
               ) {
                add_bk_option( 'booking_user_role_booking', 'subscriber' );
                add_bk_option( 'booking_user_role_addbooking', 'subscriber' );
                add_bk_option( 'booking_user_role_settings', 'subscriber' );
            } else {
                add_bk_option( 'booking_user_role_booking', 'editor' );
                add_bk_option( 'booking_user_role_addbooking', 'editor' );
                add_bk_option( 'booking_user_role_settings', 'administrator' );
            }
            $blg_title = get_option('blogname');
            $blg_title = str_replace('"', '', $blg_title);
            $blg_title = str_replace("'", '', $blg_title);

            add_bk_option( 'booking_email_reservation_adress', htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
            add_bk_option( 'booking_email_reservation_from_adress', htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
            add_bk_option( 'booking_email_reservation_subject',__('New reservation', 'wpdev-booking'));
            add_bk_option( 'booking_email_reservation_content',htmlspecialchars(sprintf(__('You need to approve new reservation %s for: %s Person detail information:%s Currently new booking is waiting for approval. Please visit the moderation panel%sThank you, %s', 'wpdev-booking'),'[bookingtype]','[dates]<br/><br/>','<br/> [content]<br/><br/>',' [moderatelink]<br/><br/>',$blg_title.'<br/>[siteurl]')));

            add_bk_option( 'booking_email_approval_adress',htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
            add_bk_option( 'booking_email_approval_subject',__('Your reservation has been approved', 'wpdev-booking'));
            if( $this->wpdev_bk_pro !== false )
                add_bk_option( 'booking_email_approval_content',htmlspecialchars(sprintf(__('Your reservation %s for: %s has been approved.%sYou can edit this booking at this page: %s Thank you, %s', 'wpdev-booking'),'[bookingtype]','[dates]','<br/><br/>[content]<br/><br/>', '[visitorbookingediturl]<br/><br/>' , $blg_title.'<br/>[siteurl]')));
            else add_bk_option( 'booking_email_approval_content',htmlspecialchars(sprintf(__('Your reservation %s for: %s has been approved.%sThank you, %s', 'wpdev-booking'),'[bookingtype]','[dates]','<br/><br/>[content]<br/><br/>',$blg_title.'<br/>[siteurl]')));

            add_bk_option( 'booking_email_deny_adress',htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
            add_bk_option( 'booking_email_deny_subject',__('Your reservation has been declined', 'wpdev-booking'));
            add_bk_option( 'booking_email_deny_content',htmlspecialchars(sprintf(__('Your reservation %s for: %s has been  canceled. %sThank you, %s', 'wpdev-booking'),'[bookingtype]','[dates]','<br/><br/>[denyreason]<br/><br/>[content]<br/><br/>',$blg_title.'<br/>[siteurl]')));

            add_bk_option( 'booking_is_email_reservation_adress', 'On' );
            add_bk_option( 'booking_is_email_approval_adress', 'On' );
            add_bk_option( 'booking_is_email_deny_adress', 'On' );



            add_bk_option( 'booking_widget_title', __('Booking form', 'wpdev-booking') );
            add_bk_option( 'booking_widget_show', 'booking_form' );
            add_bk_option( 'booking_widget_type', '1' );
            add_bk_option( 'booking_widget_calendar_count',  '1');
            add_bk_option( 'booking_widget_last_field','');

            add_bk_option( 'booking_wpdev_copyright','Off' );
            add_bk_option( 'booking_is_use_captcha' , 'Off' );
            add_bk_option( 'booking_is_show_legend' , 'Off' );

            // Create here tables which is needed for using plugin
            global $wpdb;
            $charset_collate = '';
            //if ( $wpdb->has_cap( 'collation' ) ) {
                if ( ! empty($wpdb->charset) ) $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                if ( ! empty($wpdb->collate) ) $charset_collate .= " COLLATE $wpdb->collate";
            //}

            $wp_queries = array();
            if ( ! $this->is_table_exists('booking') ) { // Cehck if tables not exist yet

                $simple_sql = "CREATE TABLE ".$wpdb->prefix ."booking (
                         booking_id bigint(20) unsigned NOT NULL auto_increment,
                         form text ,
                         booking_type bigint(10) NOT NULL default 1,
                         PRIMARY KEY  (booking_id)
                        ) $charset_collate;";
                $wpdb->query($simple_sql);
            } elseif  ($this->is_field_in_table_exists('booking','form') == 0) {
                $wp_queries[]  = "ALTER TABLE ".$wpdb->prefix ."booking ADD form TEXT AFTER booking_id";
                //$wpdb->query($simple_sql);
            }

            if  ($this->is_field_in_table_exists('booking','modification_date') == 0) {
                $wp_queries[]  = "ALTER TABLE ".$wpdb->prefix ."booking ADD modification_date datetime AFTER booking_id";
                //$wpdb->query($simple_sql);
            }

            if ( ! $this->is_table_exists('bookingdates') ) { // Cehck if tables not exist yet
                $simple_sql = "CREATE TABLE ".$wpdb->prefix ."bookingdates (
                         booking_id bigint(20) unsigned NOT NULL,
                         booking_date datetime NOT NULL default '0000-00-00 00:00:00',
                         approved bigint(20) unsigned NOT NULL default 0
                        ) $charset_collate;";
                $wpdb->query($simple_sql);

                if( $this->wpdev_bk_pro == false ) {
                    $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."booking ( form ) VALUES (
                         'text^name1^Jony~text^secondname1^Smith~text^email1^example-free@wpdevelop.com~text^phone1^8(038)458-77-77~textarea^details1^Reserve a room with sea view' );";
                }
            }

            if (count($wp_queries)>0) {
                foreach ($wp_queries as $wp_q)
                    $wpdb->query($wp_q);

                if( $this->wpdev_bk_pro == false ) {
                    $temp_id = $wpdb->insert_id;
                    $wp_queries_sub = "INSERT INTO ".$wpdb->prefix ."bookingdates (
                             booking_id,
                             booking_date
                            ) VALUES
                            ( ". $temp_id .", CURDATE()+ INTERVAL 2 day ),
                            ( ". $temp_id .", CURDATE()+ INTERVAL 3 day ),
                            ( ". $temp_id .", CURDATE()+ INTERVAL 4 day );";
                    $wpdb->query($wp_queries_sub);
                }
            }



            // if( $this->wpdev_bk_pro !== false )  $this->wpdev_bk_pro->pro_activate();
            make_bk_action('wpdev_booking_activation');

            //$this->setDefaultInitialValues();

        }

        // Deactivate
        function wpdev_booking_deactivate() {

            $is_delete_if_deactive =  get_bk_option( 'booking_is_delete_if_deactive' ); // check

            if ($is_delete_if_deactive == 'On') {
                // Delete here tables and options, which are needed for using plugin

                delete_bk_option( 'booking_skin');
                delete_bk_option( 'booking_sort_order');
                delete_bk_option( 'booking_sort_order_direction');

                delete_bk_option( 'booking_max_monthes_in_calendar');
                delete_bk_option( 'booking_admin_cal_count' );
                delete_bk_option( 'booking_client_cal_count' );
                delete_bk_option( 'booking_start_day_weeek' );
                delete_bk_option( 'booking_title_after_reservation');
                delete_bk_option( 'booking_title_after_reservation_time');
                delete_bk_option( 'booking_type_of_thank_you_message' , 'message' );
                delete_bk_option( 'booking_thank_you_page_URL' , get_option('siteurl') );

                delete_bk_option( 'booking_date_format');
                delete_bk_option( 'booking_date_view_type');
                delete_bk_option( 'booking_is_delete_if_deactive' ); // check
                delete_bk_option( 'booking_wpdev_copyright' );             // check
                delete_bk_option( 'booking_is_use_captcha' );
                delete_bk_option( 'booking_is_show_legend' );
                delete_bk_option( 'booking_dif_colors_approval_pending'   );
                delete_bk_option( 'booking_is_use_hints_at_admin_panel'  );
                delete_bk_option( 'booking_multiple_day_selections' );

                delete_bk_option( 'booking_unavailable_day0' );
                delete_bk_option( 'booking_unavailable_day1' );
                delete_bk_option( 'booking_unavailable_day2' );
                delete_bk_option( 'booking_unavailable_day3' );
                delete_bk_option( 'booking_unavailable_day4' );
                delete_bk_option( 'booking_unavailable_day5' );
                delete_bk_option( 'booking_unavailable_day6' );

                delete_bk_option( 'booking_user_role_booking' );
                delete_bk_option( 'booking_user_role_addbooking' );
                delete_bk_option( 'booking_user_role_settings' );


                delete_bk_option( 'booking_email_reservation_adress');
                delete_bk_option( 'booking_email_reservation_from_adress');
                delete_bk_option( 'booking_email_reservation_subject');
                delete_bk_option( 'booking_email_reservation_content');

                delete_bk_option( 'booking_email_approval_adress');
                delete_bk_option( 'booking_email_approval_subject');
                delete_bk_option( 'booking_email_approval_content');

                delete_bk_option( 'booking_email_deny_adress');
                delete_bk_option( 'booking_email_deny_subject');
                delete_bk_option( 'booking_email_deny_content');

                delete_bk_option( 'booking_is_email_reservation_adress'  );
                delete_bk_option( 'booking_is_email_approval_adress'  );
                delete_bk_option( 'booking_is_email_deny_adress'  );

                delete_bk_option( 'booking_widget_title');
                delete_bk_option( 'booking_widget_show');
                delete_bk_option( 'booking_widget_type');
                delete_bk_option( 'booking_widget_calendar_count');
                delete_bk_option( 'booking_widget_last_field');

                global $wpdb;
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'booking');
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'bookingdates');

                // Delete all users booking windows states   //if ( false === $wpdb->query( "DELETE FROM ". $wpdb->usermeta ." WHERE meta_key LIKE '%_booking_win_%'") ) {  // Only WIN states
                if ( false === $wpdb->query( "DELETE FROM ". $wpdb->usermeta ." WHERE meta_key LIKE '%booking_%'") ) {    // All users data
                    bk_error('Error during deleting user meta at DB',__FILE__,__LINE__);
                    die();
                }
                // Delete or Drafts and Pending from demo sites
                if (
                    ( strpos($_SERVER['SCRIPT_FILENAME'],'onlinebookingcalendar.com') !== FALSE ) ||
                    ( strpos($_SERVER['HTTP_HOST'],'onlinebookingcalendar.com') !== FALSE )
                   ) {  // Delete all temp posts at the demo sites: (post_status = pending || draft) && ( post_type = post ) && (post_author != 1)
                      $postss = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ( post_status = 'pending' OR  post_status = 'draft' OR  post_status = 'auto-draft' OR  post_status = 'trash' OR  post_status = 'inherit' ) AND ( post_type='post' OR  post_type='revision') AND post_author != 1");
                      foreach ($postss as $pp) { wp_delete_post( $pp->ID , true ); }
                 }

               make_bk_action('wpdev_booking_deactivation');
            }
        }


        function setDefaultInitialValues($evry_one = 1) {
            global $wpdb;
            $names = array(  'Jacob', 'Michael', 'Daniel', 'Anthony', 'William', 'Emma', 'Sophia', 'Kamila', 'Isabella', 'Jack', 'Daniel', 'Matthew',
                    'Olivia', 'Emily', 'Grace', 'Jessica', 'Joshua', 'Harry', 'Thomas', 'Oliver', 'Jack' );
            $second_names = array(  'Smith', 'Johnson', 'Widams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilyson', 'Gonzalez', 'Gomez',
                    'Taylor', 'Bron', 'Wilson', 'Davies', 'Robinson', 'Evans', 'Walker', 'Jackson', 'Clarke' );
            $city =    array(       'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'San Antonio', 'San Diego', 'San Jose', 'Detroit',
                    'San Francisco', 'Jacksonville', 'Austin',
                    'London', 'Birmingham', 'Leeds', 'Glasgow', 'Sheffield', 'Bradford', 'Edinburgh', 'Liverpool', 'Manchester' );
            $adress =   array(      '30 Mortensen Avenue', '144 Hitchcock Rd', '222 Lincoln Ave', '200 Lincoln Ave', '65 West Alisal St',
                    '426 Work St', '65 West Alisal Street', '159 Main St', '305 Jonoton Avenue', '423 Caiptown Rd', '34 Linoro Ave',
                    '50 Voro Ave', '15 East St', '226 Middle St', '35 West Town Street', '59 Other St', '50 Merci Ave', '15 Dolof St',
                    '226 Gordon St', '35 Sero Street', '59 Exit St' );
            $country = array( 'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'UK','UK','UK','UK','UK','UK','UK','UK','UK' );
            $info = array(    '  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ','  ','  ','  ','  ','  ','  ','  ','  ' );

            for ($i = 0; $i < count($names); $i++) {
                if ( ($i % $evry_one) !==0 ) {
                    continue;
                }
                $bk_type = rand(1,4);
                $form = 'text^starttime'.$bk_type.'^0'.rand(0,9).':'.rand(10,59).'~'.
                        'text^endtime'.$bk_type.'^'.rand(13,23).':'.rand(10,59).'~'.
                        'text^name'.$bk_type.'^'.$names[$i].'~'.
                        'text^secondname'.$bk_type.'^'.$second_names[$i].'~'.
                        'text^email'.$bk_type.'^'.$second_names[$i].'.example@wpdevelop.com~'.
                        'text^address'.$bk_type.'^'.$adress[$i].'~'.
                        'text^city'.$bk_type.'^'.$city[$i].'~'.
                        'text^postcode'.$bk_type.'^'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).'~'.
                        'text^country'.$bk_type.'^'.$country[$i].'~'.
                        'text^phone'.$bk_type.'^'.rand(0,9).rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).'~'.
                        'select-one^visitors'.$bk_type.'^'.rand(0,9).'~'.
                        'checkbox^children'.$bk_type.'[]^false~'.
                        'textarea^details'.$bk_type.'^'.$info[$i];

                $wp_bk_querie = "INSERT INTO ".$wpdb->prefix ."booking ( form, booking_type, cost, hash ) VALUES
                                                   ( '".$form."', ".$bk_type .", ".rand(0,1000).", MD5('". time() . '_' . rand(1000,1000000)."') ) ;";
                $wpdb->query($wp_bk_querie);

                $temp_id = $wpdb->insert_id;
                $wp_queries_sub = "INSERT INTO ".$wpdb->prefix ."bookingdates (
                                     booking_id,
                                     booking_date
                                    ) VALUES
                                    ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*$i*$evry_one+2)." day ),
                                    ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*$i*$evry_one+3)." day ),
                                    ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*$i*$evry_one+4)." day );";
                $wpdb->query($wp_queries_sub);
            }
        }

// </editor-fold>
  }
}
// </editor-fold>


$wpdev_bk = new wpdev_booking();


// <editor-fold defaultstate="collapsed" desc=" S u p p o r t    f u n c t i o n s    for   Ajax ">
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  S u p p o r t    f u n c t i o n s       ///////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    function get_bk_current_user_id() {
            $user = wp_get_current_user();
            return ( isset( $user->ID ) ? (int) $user->ID : 0 );
    }


    // Get form content for table
    function get_booking_form_show() {
        return '<div style="text-align:left">
                <strong>'.__('First Name', 'wpdev-booking').'</strong>:<span class="fieldvalue">[name]</span><br/>
                <strong>'.__('Last Name', 'wpdev-booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/>
                <strong>'.__('Email', 'wpdev-booking').'</strong>:<span class="fieldvalue">[email]</span><br/>
                <strong>'.__('Phone', 'wpdev-booking').'</strong>:<span class="fieldvalue">[phone]</span><br/>
                <strong>'.__('Details', 'wpdev-booking').'</strong>:<br /><span class="fieldvalue"> [details]</span>
                </div>';
    }


    // Parse form content
    function get_form_content ($formdata, $bktype =-1 , $booking_form_show ='' ) {

        if ($bktype == -1) {
            if (function_exists('get__default_type')) $bktype = get__default_type();
            else $bktype=1;
        }
        if ($booking_form_show==='') {
            if (function_exists ('get_booking_title')) $booking_form_show  = get_bk_option( 'booking_form_show' );
            else                                       $booking_form_show  = get_booking_form_show();
        }
        //debuge($booking_form_show, $formdata, $bktype);
        $formdata_array = explode('~',$formdata);
        $formdata_array_count = count($formdata_array);
        $email_adress='';
        $name_of_person = '';
        $coupon_code = '';
        $secondname_of_person = '';
        $visitors_count = 1;
        $select_box_selected_items = array();
        $check_box_selected_items = array();
        $all_fields_array = array();
        $checkbox_values=array();
        for ( $i=0 ; $i < $formdata_array_count ; $i++) {
            $elemnts = explode('^',$formdata_array[$i]);

//debuge($elemnts);
            $type = $elemnts[0];
            $element_name = $elemnts[1];
            $value = $elemnts[2];

            $count_pos = strlen( $bktype );
//debuge(substr( $elemnts[1], 0, -1*$count_pos ))                ;
            $type_name = $elemnts[1];
            $type_name = str_replace('[]','',$type_name);
            if ($bktype == substr( $type_name,  -1*$count_pos ) ) $type_name = substr( $type_name, 0, -1*$count_pos ); // $type_name = str_replace($bktype,'',$elemnts[1]);
            
            if ( ($type_name == 'email') || ($type == 'email')  )               $email_adress = $value;
            if ( ($type_name == 'coupon') || ($type == 'coupon')  )             $coupon_code = $value;
            if ( ($type_name == 'name') || ($type == 'name')  )                 $name_of_person = $value;
            if ( ($type_name == 'secondname') || ($type == 'secondname')  )     $secondname_of_person = $value;
            if ( ($type_name == 'visitors') || ($type == 'visitors')  )         $visitors_count = $value;


            if ($type == 'checkbox') {

                if ($value == 'true') {
                    $value = __('yes', 'wpdev-booking');
                }
                if ($value == 'false') {
                    $value = __('no', 'wpdev-booking');
                }

                if ( ($value !='') && ( $value != __('no', 'wpdev-booking') ) )
                    if ( ( isset($checkbox_value[ str_replace('[]','',(string) $element_name) ]) ) && ( is_array($checkbox_value[ str_replace('[]','',(string) $element_name) ]) ) ) {
                        $checkbox_value[ str_replace('[]','',(string) $element_name) ][] = $value;
                    } else {
                        if ($value != __('yes', 'wpdev-booking') )
                            $checkbox_value[ str_replace('[]','',(string) $element_name) ] = array($value);
                        else
                            $checkbox_value[ str_replace('[]','',(string) $element_name) ] = 'checkbox';
                    }

                $value = $value .' ' . '['. $type_name .']';

            }
            if ($type == 'select-one') { // add all select box selected items to return array
                $select_box_selected_items[$type_name] = $value;
            }

            if ( ($type == 'checkbox') && (isset($checkbox_value)) ) {
                $all_fields_array[ str_replace('[]','',(string) $element_name) ] = $checkbox_value[ str_replace('[]','',(string) $element_name) ];
                $check_box_selected_items[$type_name] = $checkbox_value[ str_replace('[]','',(string) $element_name) ];
            } else                      $all_fields_array[ str_replace('[]','',(string) $element_name) ] = $value;

            $booking_form_show = str_replace( '['. $type_name .']', $value ,$booking_form_show);
        }

        // Remove all shortcodes, which is not replaced early.
        $booking_form_show = preg_replace ('/[\s]{0,}\[[a-zA-Z0-9.,-_]{0,}\][\s]{0,}/', '', $booking_form_show);

        $return_array =   array('content' => $booking_form_show, 'email' => $email_adress, 'name' => $name_of_person, 'secondname' => $secondname_of_person , 'visitors' => $visitors_count ,'coupon'=>$coupon_code ,'_all_' => $all_fields_array  ) ;

        foreach ($select_box_selected_items as $key=>$value) {
            if (! isset($return_array[$key])) {
                $return_array[$key] = $value;
            }
        }
        foreach ($check_box_selected_items as $key=>$value) {
            if (! isset($return_array[$key])) {
                $return_array[$key] = $value;
            }
        }
        //debuge($return_array);
        return $return_array ;

    }


    // this function is fixing bug with PHP4 - "Fatal error: Nesting level too deep - recursive dependency"
    function show_booking_widget_php4($args) {


        extract($args);

        $booking_widget_title = get_bk_option( 'booking_widget_title');
        $booking_widget_show  =  get_bk_option( 'booking_widget_show');

        $booking_widget_type  =  get_bk_option( 'booking_widget_type');
        if ($booking_widget_type === false)  $booking_widget_type=1;


        $booking_widget_calendar_count  =  get_bk_option( 'booking_widget_calendar_count');
        $booking_widget_last_field  =  get_bk_option( 'booking_widget_last_field');

        echo $before_widget;
        if (isset($_GET['booking_hash'])) {
            _e('You need to use special shortcode [bookingedit] for booking editing.','wpdev-booking');
            echo $after_widget;
            return;
        }

        if ($booking_widget_title != '') echo $before_title . htmlspecialchars_decode($booking_widget_title) . $after_title;

        echo "<div style='float:left;margin:10px 0px;' >";
        if ($booking_widget_show == 'booking_form') {
            do_action('wpdev_bk_add_form', $booking_widget_type , $booking_widget_calendar_count);
        } else {
            do_action('wpdev_bk_add_calendar', $booking_widget_type , $booking_widget_calendar_count);
        }

        if ($booking_widget_last_field !== '') echo '<br/>' . htmlspecialchars_decode($booking_widget_last_field);
        echo "</div>";

        echo $after_widget;
    }



    // Change date format
    function change_date_format( $mydates ) {

        $mydates = explode(',',$mydates);
        $mydates_result = '';

        $date_format = get_bk_option( 'booking_date_format');
        $time_format = get_bk_option( 'booking_time_format');
        if ( $time_format !== false  ) $time_format = ' ' . $time_format;
        else                           $time_format='';

        if ($date_format == '') $date_format = "d.m.Y";

        foreach ($mydates as $dt) {
            $dt = trim($dt);
            $dta = explode(' ',$dt);
            $tms = $dta[1];
            $tms = explode(':' , $tms);
            $dta = $dta[0];
            $dta = explode('-',$dta);

            $date_format_now = $date_format . $time_format;
            if ($tms == array('00','00','00'))     $date_format_now = $date_format;

            //   H        M        S        M        D        Y
            $mydates_result .= date_i18n($date_format_now, mktime($tms[0], $tms[1], $tms[2], $dta[1], $dta[2], $dta[0])) . ', ';
        }

        return substr($mydates_result,0,-2);
    }



    // Get dates 4 emeil
    function get_dates_str ($approved_id_str) {
        global $wpdb;
        $dates_approve = $wpdb->get_results(
                "SELECT DISTINCT booking_date FROM ".$wpdb->prefix ."bookingdates WHERE  booking_id IN ($approved_id_str) ORDER BY booking_date" );
        $dates_str = '';
        // loop with all dates which is selected by someone
        foreach ($dates_approve as $my_date) {

            if ($dates_str != '') $dates_str .= ', ';
            $dates_str .= $my_date->booking_date;//$my_date[1] . '.' .$my_date[2] . '.' . $my_date[0];
        }

        return $dates_str;
    }



    // check if AM/PM exist and replace it to havemilitary format
    function get_time_array_checked_on_AMPM($start_time) {

        $start_time = trim($start_time);
        $start_time_plus = 0;

        if ( strpos( strtolower( $start_time) ,'am' ) !== false ) {
            $start_time = str_replace('am', '',  $start_time );
            $start_time = str_replace('AM', '',  $start_time );
        }

        if ( strpos( strtolower( $start_time) ,'pm' ) !== false ) {
            $start_time = str_replace('pm', '',  $start_time );
            $start_time = str_replace('PM', '',  $start_time );
            $start_time_plus = 12;
        }

        $start_time = explode(':',trim($start_time));

        $start_time[0] = $start_time[0] + $start_time_plus;
        $start_time[1] = $start_time[1] + 0;

        if ($start_time[0] < 10 ) $start_time[0] = '0' . $start_time[0];
        if ($start_time[1] < 10 ) $start_time[1] = '0' . $start_time[1];

        return $start_time;
    }


    // Get start and end time from booking form data
    function get_times_from_bk_form($sdform, $my_dates, $bktype){

            $start_time = $end_time = '00:00:00';
            
            if ( strpos($sdform,'rangetime' . $bktype ) !== false ) {   // Get START TIME From form request
                $pos1 = strpos($sdform,'rangetime' . $bktype );  // Find start time pos
                $pos1 = strpos($sdform,'^',$pos1)+1;             // Find TIME pos
                $pos2 = strpos($sdform,'~',$pos1);               // Find TIME length
                if ($pos2 === false) $pos2 = strlen($sdform);
                $pos2 = $pos2-$pos1;
                $range_time = substr( $sdform, $pos1,$pos2)  ;

                $range_time = explode('-',$range_time);


                $start_time  = get_time_array_checked_on_AMPM( trim($range_time[0]) );
                $start_time[2]='01';

                $end_time  = get_time_array_checked_on_AMPM( trim($range_time[1]) );
                $end_time[2]='02';


                //$start_time = explode(':',trim($range_time[0]));
                //$start_time[2]='01';
                //$end_time = explode(':',trim($range_time[1]));
                //$end_time[2]='02';
                if ( count($my_dates) == 1 ) { // add end date if someone select only 1 day with time range
                    $my_dates[]=$my_dates[0];
                }
            } else {

                if ( strpos($sdform,'starttime' . $bktype ) !== false ) {   // Get START TIME From form request
                    $pos1 = strpos($sdform,'starttime' . $bktype );  // Find start time pos
                    $pos1 = strpos($sdform,'^',$pos1)+1;             // Find TIME pos
                    $pos2 = strpos($sdform,'~',$pos1);               // Find TIME length
                    if ($pos2 === false) $pos2 = strlen($sdform);
                    $pos2 = $pos2-$pos1;
                    $start_time = substr( $sdform, $pos1,$pos2)  ;
                    $start_time = explode(':',$start_time);
                    $start_time[2]='01';
                } else  $start_time = explode(':',$start_time);

                if ( strpos($sdform,'endtime' . $bktype ) !== false ) {    // Get END TIME From form request
                    $pos1 = strpos($sdform,'endtime' . $bktype );    // Find start time pos
                    $pos1 = strpos($sdform,'^',$pos1)+1;             // Find TIME pos
                    $pos2 = strpos($sdform,'~',$pos1);               // Find TIME length
                    if ($pos2 === false) $pos2 = strlen($sdform);
                    $pos2 = $pos2-$pos1;
                    $end_time = substr( $sdform, $pos1,$pos2)  ;

                    if ( count($my_dates) == 1 ) { // add end date if someone select only 1 day with time range
                        $my_dates[]=$my_dates[0];
                    }
                    $end_time = explode(':',$end_time);
                    $end_time[2]='02';
                } else  $end_time = explode(':',$end_time);

                if ( strpos($sdform,'durationtime' . $bktype ) !== false ) {    // Get END TIME From form request
                    $pos1 = strpos($sdform,'durationtime' . $bktype );    // Find start time pos
                    $pos1 = strpos($sdform,'^',$pos1)+1;             // Find TIME pos
                    $pos2 = strpos($sdform,'~',$pos1);               // Find TIME length
                    if ($pos2 === false) $pos2 = strlen($sdform);
                    $pos2 = $pos2-$pos1;
                    $end_time = substr( $sdform, $pos1,$pos2)  ;

                    if ( count($my_dates) == 1 ) { // add end date if someone select only 1 day with time range
                        $my_dates[]=$my_dates[0];
                    }
                    $end_time = explode(':',$end_time);

                    // Here we are get start time and add duration for end time
                    $new_end_time = mktime($start_time[0], $start_time[1]);
                    $new_end_time = $new_end_time + $end_time[0]*60*60 + $end_time[1]*60;
                    $end_time = date('H:i',$new_end_time);
                    $end_time = explode(':',$end_time);
                    $end_time[2]='02';
                }


            }

        return array($start_time, $end_time, $my_dates );
    }



    // Check if dates in range format and fix it to the coma seperated dates
    function createDateRangeArray($strDateFrom,$strDateTo) {

        $aryRange=array();
        $strDateFrom = explode('.', $strDateFrom);
        $strDateTo = explode('.', $strDateTo);
        $iDateFrom=mktime(1,0,0, ($strDateFrom[1]+0),     ($strDateFrom[0]+0),($strDateFrom[2]+0));
        $iDateTo=mktime(1,0,0,($strDateTo[1]+0),     ($strDateTo[0]+0), ($strDateTo[2]+0));

        if ($iDateTo>=$iDateFrom) {
            array_push($aryRange,date('d.m.Y',$iDateFrom)); // first entry

            while ($iDateFrom<$iDateTo) {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('d.m.Y',$iDateFrom));
            }
        }
        $aryRange = implode(', ', $aryRange);
        return $aryRange;
    }



    // Check if nowday is tommorow from previosday
    function is_next_day($nowday, $previosday) {

        $nowday_d = (date('m.d.Y',  mysql2date('U', $nowday ))  );
        $prior_day = (date('m.d.Y',  mysql2date('U', $previosday ))  );
        if ($prior_day == $nowday_d)    return true;                // if its the same date


        $previos_array = (date('m.d.Y',  mysql2date('U', $previosday ))  );
        $previos_array = explode('.',$previos_array);
        $prior_day =  date('m.d.Y' , mktime(0, 0, 0, $previos_array[0], ($previos_array[1]+1), $previos_array[2] ));


        if ($prior_day == $nowday_d)    return true;                // zavtra
        else                            return false;               // net
    }


    // Get days in short format view
    function get_dates_short_format( $days ) {  // $days - string with comma seperated dates

        $days = explode(',', $days);

        $previosday = false;
        $result_string = '';
        $last_show_day = '';

        foreach ($days as $day) {
            $is_fin_at_end = false;
            if ($previosday !== false) {            // Not first day
                if ( is_next_day($day, $previosday) ) {
                    $previosday = $day;                        // Set previos day for next loop
                    $is_fin_at_end = true;
                } else {
                    if ($last_show_day !== $previosday) {      // check if previos day was show or no
                        $result_string .= ' - ' . change_date_format($previosday); // assign in needed format this day
                    }
                    $result_string .= ', ' . change_date_format($day); // assign in needed format this day
                    $previosday = $day;                        // Set previos day for next loop
                    $last_show_day = $day;
                }
            } else {                                 // First day
                $result_string = change_date_format($day); // assign in needed format first day
                $last_show_day = $day;
                $previosday = $day;                        // Set previos day for next loop
            }
        }

        if ($is_fin_at_end) {
            $result_string .= ' - ' . change_date_format($day);
        } // assign in needed format this day

        return $result_string;
    }


    function sendApproveEmails($approved_id_str, $is_send_emeils){
                global $wpdb;
                $sql = "SELECT * FROM ".$wpdb->prefix ."booking as bk WHERE bk.booking_id IN ($approved_id_str)";
                $result = $wpdb->get_results( $sql );
//debuge($result);
                $mail_sender    =  htmlspecialchars_decode( get_bk_option( 'booking_email_approval_adress') ) ; //'"'. 'Booking sender' . '" <' . $booking_form_show['email'].'>';
                $mail_subject   =  htmlspecialchars_decode( get_bk_option( 'booking_email_approval_subject') );
                $mail_body      =  htmlspecialchars_decode( get_bk_option( 'booking_email_approval_content') );

                foreach ($result as $res) {
//debuge($res)                    ;
                    // Sending mail ///////////////////////////////////////////////////////
                    if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $res->booking_type );
                    else $bk_title = '';
//debuge($bk_title);
                    $booking_form_show = get_form_content ($res->form, $res->booking_type);
//debuge($booking_form_show);
                    make_bk_action('booking_aproved', $res, $booking_form_show);

                    $mail_body_to_send = str_replace('[bookingtype]', $bk_title, $mail_body);
                    if (get_bk_option( 'booking_date_view_type') == 'short') $my_dates_4_send = get_dates_short_format( get_dates_str($res->booking_id) );
                    else                                                  $my_dates_4_send = change_date_format(get_dates_str($res->booking_id));
//debuge($my_dates_4_send);
                    $my_dates4emeil_check_in_out = explode(',',get_dates_str($res->booking_id));
                    $my_check_in_date = change_date_format($my_dates4emeil_check_in_out[0] );
                    $my_check_out_date = change_date_format($my_dates4emeil_check_in_out[ count($my_dates4emeil_check_in_out)-1 ] );

                    $mail_body_to_send = str_replace('[dates]', $my_dates_4_send , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[check_in_date]',$my_check_in_date , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[check_out_date]',$my_check_out_date , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[id]',$res->booking_id , $mail_body_to_send);


                    $mail_body_to_send = str_replace('[content]', $booking_form_show['content'], $mail_body_to_send);
                    $mail_body_to_send = str_replace('[name]', $booking_form_show['name'], $mail_body_to_send);
                    if (isset($res->cost)) $mail_body_to_send = str_replace('[cost]', $res->cost, $mail_body_to_send);
                    $mail_body_to_send = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.get_option('siteurl').'">' . get_option('siteurl') . '</a>'), $mail_body_to_send);
                    $mail_body_to_send = apply_bk_filter('wpdev_booking_set_booking_edit_link_at_email', $mail_body_to_send, $res->booking_id );

                    if ( isset($booking_form_show['secondname']) ) $mail_body_to_send = str_replace('[secondname]', $booking_form_show['secondname'], $mail_body_to_send);
                    $mail_subject1 = $mail_subject;
                    $mail_subject1 = str_replace('[name]', $booking_form_show['name'], $mail_subject1);
                    if ( isset($booking_form_show['secondname']) ) $mail_subject1 = str_replace('[secondname]', $booking_form_show['secondname'], $mail_subject1);


                    $mail_recipient =  $booking_form_show['email'];

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";
//debuge($mail_recipient, $mail_subject1, $mail_body_to_send, $mail_headers);
//debuge(get_bk_option( 'booking_is_email_approval_adress'  ));

                    if (get_bk_option( 'booking_is_email_approval_adress'  ) != 'Off')
                        if ($is_send_emeils != 0 )
                            if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                                @wp_mail($mail_recipient, $mail_subject1, $mail_body_to_send, $mail_headers);

                    // Send to the Admin also
                    $mail_recipient =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_adress') );
                    $is_email_approval_send_copy_to_admin = get_bk_option( 'booking_is_email_approval_send_copy_to_admin' );
//debuge($mail_recipient, $is_email_approval_send_copy_to_admin)                    ;
                    if ( $is_email_approval_send_copy_to_admin == 'On')
                        if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                            if ($is_send_emeils != 0 )
                                @wp_mail($mail_recipient, $mail_subject1, $mail_body_to_send, $mail_headers);

                    /////////////////////////////////////////////////////////////////////////
//debuge(';Fin')                            ;die;
                } //die;

    }


    function sendDeclineEmails($approved_id_str, $is_send_emeils, $denyreason = '') {
                global $wpdb;
                $sql = "SELECT *    FROM ".$wpdb->prefix ."booking as bk
                                    WHERE bk.booking_id IN ($approved_id_str)";

                $result = $wpdb->get_results( $sql );

                $mail_sender    =  htmlspecialchars_decode( get_bk_option( 'booking_email_deny_adress') ) ;
                $mail_subject   =  htmlspecialchars_decode( get_bk_option( 'booking_email_deny_subject') );
                $mail_body      =  htmlspecialchars_decode( get_bk_option( 'booking_email_deny_content') );

                foreach ($result as $res) {
                    // Sending mail ///////////////////////////////////////////////////////
                    if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $res->booking_type );
                    else $bk_title = '';

                    $booking_form_show = get_form_content ($res->form, $res->booking_type);

                    $mail_body_to_send = str_replace('[bookingtype]', $bk_title, $mail_body);
                    if (get_bk_option( 'booking_date_view_type') == 'short') $my_dates_4_send = get_dates_short_format( get_dates_str($res->booking_id) );
                    else                                                  $my_dates_4_send = change_date_format(get_dates_str($res->booking_id));
                    $my_dates4emeil_check_in_out = explode(',',get_dates_str($res->booking_id));
                    $my_check_in_date = change_date_format($my_dates4emeil_check_in_out[0] );
                    $my_check_out_date = change_date_format($my_dates4emeil_check_in_out[ count($my_dates4emeil_check_in_out)-1 ] );

                    $mail_body_to_send = str_replace('[dates]',$my_dates_4_send , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[check_in_date]',$my_check_in_date , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[check_out_date]',$my_check_out_date , $mail_body_to_send);
                    $mail_body_to_send = str_replace('[id]',$res->booking_id , $mail_body_to_send);

                    $mail_body_to_send = str_replace('[content]', $booking_form_show['content'], $mail_body_to_send);
                    $mail_body_to_send = str_replace('[denyreason]', $denyreason, $mail_body_to_send);
                    $mail_body_to_send = str_replace('[name]', $booking_form_show['name'], $mail_body_to_send);
                    if (isset($res->cost)) $mail_body_to_send = str_replace('[cost]', $res->cost, $mail_body_to_send);
                    $mail_body_to_send = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.get_option('siteurl').'">' . get_option('siteurl') . '</a>'), $mail_body_to_send);
                    $mail_body_to_send = apply_bk_filter('wpdev_booking_set_booking_edit_link_at_email', $mail_body_to_send, $res->booking_id );

                    if ( isset($booking_form_show['secondname']) ) $mail_body_to_send = str_replace('[secondname]', $booking_form_show['secondname'], $mail_body_to_send);
                    $mail_subject1 = $mail_subject;
                    $mail_subject1 = str_replace('[name]', $booking_form_show['name'], $mail_subject1);
                    if ( isset($booking_form_show['secondname']) ) $mail_subject1 = str_replace('[secondname]', $booking_form_show['secondname'], $mail_subject1);

                    $mail_recipient =  $booking_form_show['email'];

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    if (get_bk_option( 'booking_is_email_deny_adress'  ) != 'Off')
                        if ($is_send_emeils != 0 )
                            if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                                @wp_mail($mail_recipient, $mail_subject1, $mail_body_to_send, $mail_headers);

                    // Send to the Admin also
                    $mail_recipient =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_adress') );
                    $is_email_deny_send_copy_to_admin = get_bk_option( 'booking_is_email_deny_send_copy_to_admin' );
                    if ( $is_email_deny_send_copy_to_admin == 'On')
                        if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                            if ($is_send_emeils != 0 )
                                @wp_mail($mail_recipient, $mail_subject1, $mail_body_to_send, $mail_headers);


                    /////////////////////////////////////////////////////////////////////////
                }

    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="  A J A X     R e s p o n d e r     Real Ajax with jWPDev sender  ">
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    A J A X     R e s p o n d e r     Real Ajax with jWPDev sender     ///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function wpdev_bk_ajax_responder() {
    
    global $wpdb;
    $action = $_POST['ajax_action'];

    switch ( $action ) :

        case  'INSERT_INTO_TABLE':

            $dates = $_POST[ "dates" ];
            $bktype = $_POST[  "bktype" ];

            make_bk_action('check_multiuser_params_for_client_side', $bktype );

            $formdata = $_POST["form"];
            if (isset($_POST["is_send_emeils"])) $is_send_emeils = $_POST["is_send_emeils"];
            else                                 $is_send_emeils = 1;

            $my_booking_id = 0;//(int) $_POST["my_booking_id"];

            $my_booking_hash = '';
            if (isset($_POST['my_booking_hash'])) {
                $my_booking_hash = $_POST['my_booking_hash'];
//debuge($my_booking_hash)
                if ($my_booking_hash!='') {
                    $my_booking_id_type = false;
                    $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $my_booking_hash);
                    if ($my_booking_id_type !== false) {
                        $my_booking_id = $my_booking_id_type[0];
                        $bktype        = $my_booking_id_type[1];
                    }
                }
            }


            $is_approved_dates = '0';

            if (strpos($dates,' - ')!== FALSE) {
                $dates =explode(' - ', $dates );
                $dates = createDateRangeArray($dates[0],$dates[1]);
            }

            ///  CAPTCHA CHECKING   //////////////////////////////////////////////////////////////////////////////////////
            $the_answer_from_respondent = $_POST['captcha_user_input'];
            $prefix = $_POST['captcha_chalange'];
            if (! ( ($the_answer_from_respondent == '') && ($prefix == '') )) {
                $captcha_instance = new wpdevReallySimpleCaptcha();
                $correct = $captcha_instance->check($prefix, $the_answer_from_respondent);

                if (! $correct) {
                    $word = $captcha_instance->generate_random_word();
                    $prefix = mt_rand();
                    $captcha_instance->generate_image($prefix, $word);

                    $filename = $prefix . '.png';
                    $captcha_url = WPDEV_BK_PLUGIN_URL . '/js/captcha/tmp/' .$filename;
                    $ref = substr($filename, 0, strrpos($filename, '.'));
                    ?> <script type="text/javascript">
                        document.getElementById('captcha_input<?php echo $bktype; ?>').value = '';
                        // chnage img
                        document.getElementById('captcha_img<?php echo $bktype; ?>').src = '<?php echo $captcha_url; ?>';
                        document.getElementById('wpdev_captcha_challenge_<?php echo $bktype; ?>').value = '<?php echo $ref; ?>';
                        document.getElementById('captcha_msg<?php echo $bktype; ?>').innerHTML =
                            '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Your entered code is incorrect', 'wpdev-booking'); ?></div>';
                        document.getElementById('submiting<?php echo $bktype; ?>').innerHTML ='';
                        jWPDev('#captcha_input<?php echo $bktype; ?>')
                        .fadeOut( 350 ).fadeIn( 300 )
                        .fadeOut( 350 ).fadeIn( 400 )
                        .animate( {opacity: 1}, 4000 )
                        ;  // mark red border
                        jWPDev(".wpdev-help-message div")
                        .css( {'color' : 'red'} )
                        .animate( {opacity: 1}, 10000 )
                        .fadeOut( 2000 );   // hide message
                        document.getElementById('captcha_input<?php echo $bktype; ?>').focus();    // make focus to elemnt

</script>
                    <?php
                    die();
                }
            }//////////////////////////////////////////////////////////////////////////////////////////////////////////


            $booking_form_show = get_form_content ($formdata, $bktype);


            if ($my_booking_id>0) {                  // Edit exist booking

                if ( strpos($_SERVER['HTTP_REFERER'],'wp-admin/admin.php?') !==false ) {
                    ?> <script type="text/javascript">
                        document.getElementById('ajax_working').innerHTML =
                            '<div class="info_message ajax_message" id="ajax_message">\n\
                                            <div style="float:left;"><?php echo __('Updating...', 'wpdev-booking'); ?></div> \n\
                                            <div  style="float:left;width:80px;margin-top:-3px;">\n\
                                                   <img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif">\n\
                                            </div>\n\
                                        </div>';
                    </script> <?php
                }
                $update_sql = "UPDATE ".$wpdb->prefix ."booking AS bk SET bk.form='$formdata', bk.booking_type=$bktype , bk.modification_date=NOW() WHERE bk.booking_id=$my_booking_id;";
                if ( false === $wpdb->query( $update_sql ) ) {
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during updating exist booking in BD',__FILE__,__LINE__); ?></div>'; </script> <?php
                    die();
                }

                // Check if dates already aproved or no
                $slct_sql = "SELECT approved FROM ".$wpdb->prefix ."bookingdates WHERE booking_id IN ($my_booking_id) LIMIT 0,1";
                $slct_sql_results  = $wpdb->get_results( $slct_sql );
                if ( count($slct_sql_results) > 0 ) {
                    $is_approved_dates = $slct_sql_results[0]->approved;
                }

                $delete_sql = "DELETE FROM ".$wpdb->prefix ."bookingdates WHERE booking_id IN ($my_booking_id)";
                if ( false === $wpdb->query( $delete_sql ) ) {
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during updating exist booking for deleting dates in BD' ,__FILE__,__LINE__); ?></div>'; </script> <?php
                    die();
                }
                $booking_id = (int) $my_booking_id;       //Get ID  of reservation

            } else {                                // Add new booking

                $sql_insertion = "INSERT INTO ".$wpdb->prefix ."booking (form, booking_type, modification_date) VALUES ('$formdata',  $bktype, NOW() )" ;

                if ( false === $wpdb->query( $sql_insertion ) ) {
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during inserting into BD',__FILE__,__LINE__); ?></div>'; </script> <?php
                    die();
                }
                // Make insertion into BOOKINGDATES
                $booking_id = (int) $wpdb->insert_id;       //Get ID  of reservation
            }




            $sdform = $_POST['form'];
            $my_dates = explode(", ",$dates);

            $start_end_time = get_times_from_bk_form($sdform, $my_dates, $bktype);
            $start_time = $start_end_time[0];
            $end_time = $start_end_time[1];
            $my_dates = $start_end_time[2];

            make_bk_action('wpdev_booking_post_inserted', $booking_id, $bktype, str_replace('|',',',$dates),  array($start_time, $end_time ) );
            $my_cost = apply_bk_filter('get_booking_cost_from_db', '', $booking_id);


            $i=0;
            foreach ($my_dates as $md) { // Set in dates in such format: yyyy.mm.dd
                $md = explode('.',$md);
                $my_dates[$i] = $md[2] . '.' . $md[1] . '.' . $md[0] ;
                $i++;
            }
            sort($my_dates); // Sort dates

            $my_dates4emeil = '';
            $i=0;
            $insert='';
            foreach ($my_dates as $my_date) {
                $i++;          // Loop through all dates
                if (strpos($my_date,'.')!==false) {
                    $my_date = explode('.',$my_date);
                    if ($i == 1) {
                        $date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $my_date[0], $my_date[1], $my_date[2], $start_time[0], $start_time[1], $start_time[2] );
                    }elseif ($i == count($my_dates)) {
                        $date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $my_date[0], $my_date[1], $my_date[2], $end_time[0], $end_time[1], $end_time[2] );
                    }else {
                        $date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $my_date[0], $my_date[1], $my_date[2], '00', '00', '00' );
                    }
                    $my_dates4emeil .= $date . ',';
                    if ( !empty($insert) ) $insert .= ', ';
                    $insert .= "('$booking_id', '$date', '$is_approved_dates' )";
                }
            }
            $my_dates4emeil = substr($my_dates4emeil,0,-1);

            $my_dates4emeil_check_in_out = explode(',',$my_dates4emeil);
            $my_check_in_date = change_date_format($my_dates4emeil_check_in_out[0] );
            $my_check_out_date = change_date_format($my_dates4emeil_check_in_out[ count($my_dates4emeil_check_in_out)-1 ] );
            /* // This add 1 more day for check out day
            $my_check_out_date = $my_dates4emeil_check_in_out[ count($my_dates4emeil_check_in_out)-1 ];
            $dt = trim($my_check_out_date);
            $dta = explode(' ',$dt);
            $dta = $dta[0];
            $dta = explode('-',$dta);
            $my_check_out_date = date('Y-m-d H:i:s' , mktime(0, 0, 0, $dta[1], ($dta[2]+1), $dta[0] ));
            $my_check_out_date = change_date_format($my_check_out_date);
            /**/

            if ( !empty($insert) )
                if ( false === $wpdb->query("INSERT INTO ".$wpdb->prefix ."bookingdates (booking_id, booking_date, approved) VALUES " . $insert) ) {
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during inserting into BD - Dates',__FILE__,__LINE__); ?></div>'; </script> <?php
                    die();
                }

            if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $bktype );
            else $bk_title = '';

            if ($my_booking_id>0) { // For editing exist booking


                $mail_sender    =  htmlspecialchars_decode( get_bk_option( 'booking_email_modification_adress') ) ;
                $mail_subject   =  htmlspecialchars_decode( get_bk_option( 'booking_email_modification_subject') );
                $mail_body      =  htmlspecialchars_decode( get_bk_option( 'booking_email_modification_content') );

                if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $bktype );
                else $bk_title = '';

                $booking_form_show = get_form_content ($formdata, $bktype);

                $mail_body_to_send = str_replace('[bookingtype]', $bk_title, $mail_body);
                if (get_bk_option( 'booking_date_view_type') == 'short') $my_dates_4_send = get_dates_short_format( get_dates_str($booking_id) );
                else                                                  $my_dates_4_send = change_date_format(get_dates_str($booking_id));
                $mail_body_to_send = str_replace('[dates]',$my_dates_4_send , $mail_body_to_send);
                $mail_body_to_send = str_replace('[check_in_date]',$my_check_in_date , $mail_body_to_send);
                $mail_body_to_send = str_replace('[check_out_date]',$my_check_out_date , $mail_body_to_send);
                $mail_body_to_send = str_replace('[id]', $booking_id , $mail_body_to_send);


                $mail_body_to_send = str_replace('[content]', $booking_form_show['content'], $mail_body_to_send);
                $mail_body_to_send = str_replace('[denyreason]', $denyreason, $mail_body_to_send);
                $mail_body_to_send = str_replace('[name]', $booking_form_show['name'], $mail_body_to_send);
                $mail_body_to_send = str_replace('[cost]', $my_cost, $mail_body_to_send);
                if ( isset($booking_form_show['secondname']) ) $mail_body_to_send = str_replace('[secondname]', $booking_form_show['secondname'], $mail_body_to_send);
                $mail_body_to_send = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.get_option('siteurl').'">' . get_option('siteurl') . '</a>'), $mail_body_to_send);
                $mail_body_to_send = apply_bk_filter('wpdev_booking_set_booking_edit_link_at_email', $mail_body_to_send, $booking_id );

                $mail_subject = str_replace('[name]', $booking_form_show['name'], $mail_subject);
                if ( isset($booking_form_show['secondname']) ) $mail_subject = str_replace('[secondname]', $booking_form_show['secondname'], $mail_subject);

                $mail_recipient =  $booking_form_show['email'];

                $mail_headers = "From: $mail_sender\n";
                $mail_headers .= "Content-Type: text/html\n";

                if (get_bk_option( 'booking_is_email_modification_adress'  ) != 'Off') {
                    // Send to the Visitor
                    if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                        if ($is_send_emeils != 0 )
                            @wp_mail($mail_recipient, $mail_subject, $mail_body_to_send, $mail_headers);

                    // Send to the Admin also
                    $mail_recipient =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_adress') );
                    $is_email_modification_send_copy_to_admin = get_bk_option( 'booking_is_email_modification_send_copy_to_admin' );
                    if ( $is_email_modification_send_copy_to_admin == 'On')
                        if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body_to_send,'admin@blank.com') === false ) )
                            if ($is_send_emeils != 0 )
                                @wp_mail($mail_recipient, $mail_subject, $mail_body_to_send, $mail_headers);
                }
//debuge($_SERVER);

                if ( strpos($_SERVER['HTTP_REFERER'],'wp-admin/admin.php?') ===false ) {
                    do_action('wpdev_new_booking',$booking_id, $bktype, str_replace('|',',',$dates), array($start_time, $end_time ) ,$sdform );
                }

                ?> <script type="text/javascript">
                <?php
                if ( strpos($_SERVER['HTTP_REFERER'],'wp-admin/admin.php?') ===false ) { ?>
                            //document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div class=\"submiting_content\" ><?php echo get_bk_option( 'booking_title_after_reservation'); ?></div>';
                            //jWPDev('.submiting_content').fadeOut(<?php echo get_bk_option( 'booking_title_after_reservation_time'); ?>);
                            setReservedSelectedDates('<?php echo $bktype; ?>');
                    <?php }  else { ?>
                            document.getElementById('ajax_message').innerHTML = '<?php echo __('Updated successfully', 'wpdev-booking'); ?>';
                            jWPDev('#ajax_message').fadeOut(1000);
                            document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Updated successfully', 'wpdev-booking'); ?></div>';
                            location.href='admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ;?>wpdev-booking&booking_type=<?php echo $bktype; ?>&booking_id_selection=<?php echo  $my_booking_id;?>';
                    <?php } ?>
                    </script> <?php


            } else {// For inserting NEW booking
                // Sending mail ///////////////////////////////////////////////////////
                $mail_sender    =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_from_adress') ) ; //'"'. 'Booking sender' . '" <' . $booking_form_show['email'].'>';
                $mail_recipient =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_adress') );//'"Booking receipent" <' .get_option('admin_email').'>';
                $mail_subject   =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_subject') );
                $mail_body      =  htmlspecialchars_decode( get_bk_option( 'booking_email_reservation_content') );

                $mail_body = str_replace('[bookingtype]', $bk_title, $mail_body);
                if (get_bk_option( 'booking_date_view_type') == 'short') $my_dates_4_send = get_dates_short_format( $my_dates4emeil );
                else                                                  $my_dates_4_send = change_date_format($my_dates4emeil);
                $mail_body = str_replace('[dates]',  $my_dates_4_send , $mail_body);
                $mail_body = str_replace('[check_in_date]',$my_check_in_date , $mail_body);
                $mail_body = str_replace('[check_out_date]',$my_check_out_date , $mail_body);
                $mail_body = str_replace('[id]',$booking_id , $mail_body);

                $mail_body = str_replace('[content]', $booking_form_show['content'], $mail_body);
                $mail_body = str_replace('[name]', $booking_form_show['name'], $mail_body);
                $mail_body = str_replace('[cost]', $my_cost, $mail_body);
                $mail_body = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.get_option('siteurl').'">' . get_option('siteurl') . '</a>'), $mail_body);
                $mail_body = str_replace('[moderatelink]', htmlspecialchars_decode(
                        '<a href="'.get_option('siteurl')  . '/wp-admin/admin.php?page='. WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME .'wpdev-booking&booking_type='.$bktype.'&moderate_id='. $booking_id .'">'
                        . __('here','wpdev-booking') . '</a>'), $mail_body);


                $mail_body = apply_bk_filter('wpdev_booking_set_booking_edit_link_at_email', $mail_body, $booking_id );



                if ( isset($booking_form_show['secondname']) ) $mail_body = str_replace('[secondname]', $booking_form_show['secondname'], $mail_body);

                $mail_subject = str_replace('[name]', $booking_form_show['name'], $mail_subject);
                if ( isset($booking_form_show['secondname']) ) $mail_subject = str_replace('[secondname]', $booking_form_show['secondname'], $mail_subject);

                $mail_headers = "From: $mail_sender\n";
                $mail_headers .= "Content-Type: text/html\n";

                if ( strpos($mail_recipient,'[visitoremeil]') !== false ) {
                    $mail_recipient = str_replace('[visitoremeil]',$booking_form_show['email'],$mail_recipient);
                }

                if (get_bk_option( 'booking_is_email_reservation_adress'  ) != 'Off')
                    if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body,'admin@blank.com') === false ) )
                        if ($is_send_emeils != 0 )
                            @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);
                /////////////////////////////////////////////////////////////////////////

                if (get_bk_option( 'booking_is_email_newbookingbyperson_adress'  ) == 'On') {

                    $mail_sender    =  htmlspecialchars_decode( get_bk_option( 'booking_email_newbookingbyperson_adress') ) ; //'"'. 'Booking sender' . '" <' . $booking_form_show['email'].'>';
                    $mail_recipient =  $booking_form_show['email'];
                    $mail_subject   =  htmlspecialchars_decode( get_bk_option( 'booking_email_newbookingbyperson_subject') );
                    $mail_body      =  htmlspecialchars_decode( get_bk_option( 'booking_email_newbookingbyperson_content') );

                    $mail_body = str_replace('[bookingtype]', $bk_title, $mail_body);
                    if (get_bk_option( 'booking_date_view_type') == 'short') $my_dates_4_send = get_dates_short_format( $my_dates4emeil );
                    else                                                  $my_dates_4_send = change_date_format($my_dates4emeil);
                    $mail_body = str_replace('[dates]',  $my_dates_4_send , $mail_body);
                    $mail_body = str_replace('[check_in_date]',$my_check_in_date , $mail_body);
                    $mail_body = str_replace('[check_out_date]',$my_check_out_date , $mail_body);
                    $mail_body = str_replace('[id]',$booking_id , $mail_body);


                    $mail_body = str_replace('[content]', $booking_form_show['content'], $mail_body);
                    $mail_body = str_replace('[name]', $booking_form_show['name'], $mail_body);
                    $mail_body = str_replace('[cost]', $my_cost, $mail_body);
                    $mail_body = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.get_option('siteurl').'">' . get_option('siteurl') . '</a>'), $mail_body);
                    $mail_body = apply_bk_filter('wpdev_booking_set_booking_edit_link_at_email', $mail_body, $booking_id );

                    if ( isset($booking_form_show['secondname']) ) $mail_body = str_replace('[secondname]', $booking_form_show['secondname'], $mail_body);

                    $mail_subject = str_replace('[name]', $booking_form_show['name'], $mail_subject);
                    if ( isset($booking_form_show['secondname']) ) $mail_subject = str_replace('[secondname]', $booking_form_show['secondname'], $mail_subject);

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    if ( strpos($mail_recipient,'[visitoremeil]') !== false ) {
                        $mail_recipient = str_replace('[visitoremeil]',$booking_form_show['email'],$mail_recipient);
                    }
                    if ( strpos($mail_recipient,'@blank.com') === false )
                        if ( ( strpos($mail_recipient,'@blank.com') === false ) && ( strpos($mail_body,'admin@blank.com') === false ) )
                            if ($is_send_emeils != 0 )
                                @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);

                }

                do_action('wpdev_new_booking',$booking_id, $bktype, str_replace('|',',',$dates), array($start_time, $end_time ) ,$sdform );
                ?>
<script type="text/javascript">
   // document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div class=\"submiting_content\" ><?php echo get_bk_option( 'booking_title_after_reservation'); ?></div>';
   // jWPDev('.submiting_content').fadeOut(<?php echo get_bk_option( 'booking_title_after_reservation_time'); ?>);
    setReservedSelectedDates('<?php echo $bktype; ?>');
</script>  <?php

            }


            // ReUpdate booking resource TYPE if its needed here

            make_bk_action('wpdev_booking_reupdate_bk_type_to_childs', $booking_id, $bktype, str_replace('|',',',$dates),  array($start_time, $end_time ) , $sdform );





            die();
            break;

        case 'UPDATE_APPROVE' :

            make_bk_action('check_multiuser_params_for_client_side_by_user_id', $_POST['user_id'] );

            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $is_send_emeils = $_POST["is_send_emeils"];
            $approved_id = explode('|',$approved);
            if ( (count($approved_id)>0) && ($approved_id !==false)) {
                $approved_id_str = join( ',', $approved_id);

                if ( false === $wpdb->query( "UPDATE ".$wpdb->prefix ."bookingdates SET approved = '1' WHERE booking_id IN ($approved_id_str)") ) {
                    ?>
<script type="text/javascript">
    document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML =
        '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during updating to DB' ,__FILE__,__LINE__); ?></div>';
</script>
                    <?php
                    die();
                }
                sendApproveEmails($approved_id_str, $is_send_emeils);
                
                ?>
<script type="text/javascript">
    document.getElementById('ajax_message').innerHTML = '<?php echo __('Approved', 'wpdev-booking'); ?>';
    jWPDev('#ajax_message').fadeOut(1000);
    location.reload(true);
</script>
                <?php
                die();
            }
            break;

        case 'DELETE_APPROVE' :   
            make_bk_action('check_multiuser_params_for_client_side_by_user_id', $_POST['user_id'] );

            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $denyreason = $_POST["denyreason"];
            $is_send_emeils = $_POST["is_send_emeils"];
            if ( ( $denyreason == __('Reason of cancellation here', 'wpdev-booking')) || ( $denyreason == 'Reason of cancel here') ) {
                $denyreason = '';
            }

            $approved_id = explode('|',$approved);

            if ( (count($approved_id)>0) && ($approved_id !=false) && ($approved_id !='')) {
                $approved_id_str = join( ',', $approved_id);

                sendDeclineEmails($approved_id_str, $is_send_emeils,$denyreason);
                

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."bookingdates WHERE booking_id IN ($approved_id_str)") ) {
                    ?> <script type="text/javascript"> document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during deleting dates at DB' ,__FILE__,__LINE__); ?></div>'; </script> <?php
                    die();
                }

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."booking WHERE booking_id IN ($approved_id_str)") ) {
                    ?> <script type="text/javascript"> document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php bk_error('Error during deleting reservation at DB',__FILE__,__LINE__ ); ?></div>'; </script> <?php
                    die();
                }

                ?>
                    <script type="text/javascript">
                        document.getElementById('ajax_message').innerHTML = '<?php echo __('Deleted', 'wpdev-booking'); ?>';
                        jWPDev('#ajax_message').fadeOut(1000);
                        location.reload(true);
                    </script>
                <?php
                die();
            }
            break;

        case 'DELETE_BY_VISITOR':
            make_bk_action('wpdev_delete_booking_by_visitor');
            break;
        case 'SAVE_BK_COST':
            make_bk_action('wpdev_save_bk_cost');
            break;
        case 'SEND_PAYMENT_REQUEST':
            make_bk_action('wpdev_send_payment_request');
            break;
        case 'UPDATE_REMARK':
            make_bk_action('wpdev_updating_remark');
            break;
        case 'DELETE_BK_FORM':
            make_bk_action('wpdev_delete_booking_form');
            break;

        case 'USER_SAVE_OPTION':

            if ($_POST['option'] == 'ADMIN_CALENDAR_COUNT') {
                update_user_option($_POST['user_id'],'booking_admin_calendar_count',$_POST['count']);
            }
            ?>
<script type="text/javascript">
    document.getElementById('ajax_message').innerHTML = '<?php echo __('Done', 'wpdev-booking'); ?>';
    jWPDev('#ajax_message').fadeOut(1000);
            <?php if ( $_POST['is_reload'] == 1 ) { ?>
        location.reload(true);
                <?php  } ?>
</script>
            <?php
            die();
            break;

        case 'USER_SAVE_WINDOW_STATE': update_user_option($_POST['user_id'],'booking_win_' . $_POST['window'] ,$_POST['is_closed']);
            die();
            break;

        case 'CALCULATE_THE_COST':
            make_bk_action('wpdev_ajax_show_cost');
            die();
            break;
        default:
            if (function_exists ('wpdev_pro_bk_ajax')) wpdev_pro_bk_ajax();
            die();

        endswitch;

}

// </editor-fold>

?>