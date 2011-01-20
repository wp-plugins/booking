<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://onlinebookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Version: 2.8
Author: wpdevelop
Author URI: http://onlinebookingcalendar.com/
Tested WordPress Versions: 2.8.3 - 3.1
*/

/*  Copyright 2009, 2010, 2011  www.onlinebookingcalendar.com  (email: info@onlinebookingcalendar.com),

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
 *   Dependence of maximum selection of days from start selection of week day. Its mean that user can select some first day and depends from the the day of week, which was selected, he will be able to select some specific (maximum number of days).
 *
 * (Maybe at new CRM plugin) Google Calendar integration: it would be nice, someone books inserted into one of Google calendars of administraor, which is used to register all books. This way, it gets synchronized to desktop and iPhone as well
 * Send text messages after booking appointments, send Reminders via email and text messaging, SMS or text message option, to notify you immediately via your cell phone when you get a booking online
 *
 * Field type be created that only accepts numbers (auto-validates as number only) or have REGEX defined by user.
 * Add description inside of input text fields inside of fields as grey text ???
 * set required field phone for free version ???
 * Season filtering by weeks numbers
 *
 * Dependence cost from 2 parameters at same time: number of selected days and season of selection )
 * Add checking to the email sending according errors ( it can be when PHP Mail function is not active at the SERVER ) 
 * Set posibility to login with user permission at MultiUser version
 * Id like this [select visitors "1" "2" "3" "4" �5�] to be dynamic. If there is 3 products free, I�d like to see [select visitors "1" "2" "3"] If there is 1 products free, I�d like to see [select visitors "1"] In the popup you can see price and product free so I imagine it�s possible to make selected visitors dynamic
 * Days cost view inside of calendar, unders the days numbers
 * Set different times on different days, yet still have them show up on the same calendar
 *
 * 1) 6 possible half day users paying 'X' amount 2) There can be passengers (at a diffierent cost) but they will minus (take a position of) one of the 6 half day users/spots  3) People can also book full days but this will be at a different cost, it will then deduct from two of the 6 users/spots of the half day (the 2 bring one spot frmo the morning and one from the afternoon availability). e.g If someone books for the full day then on that day a morning and afternoon half day spots will be booked/unavailable.
 * Automated email to go out to people a couple of days prior to their reservation yet
 


 M a j o r   T O D O   List:
 * -------------------------------------------------------
 * 2.9
 * -------------------------------------------------------
 * Popup shortcode form:
 * - Showing 2 or more calendars with one form
 * - Booking search results
 *
 * Check posibility to include this payment system : https://www.nmi.com/ (its for Panama)
 * Paypal pro integration
 * Authorize . net support
 * Google checkout support
 * eway  payment system support
 * 2co payment system
 * ipay88 payment systems
 * WordPay
 * 
 * Add posibility to send link for payment to visitors, after visitor make booking. (Premium and higher versions)
 *
 * Fix issue with not correct cost at the Paypal button, when advanced cost is not set for custom field, but its setuped for normal fields.
 *
 * Add labels of payment -  it would be much better if the booking manager displayed who had paid and who hadn't right now every order goes through with no way of identifying this
 * Add Lables with Show max visitor in name of room (Hotel Edition, MultiUser)
 *
 Probably some this features:
 *
 * Most of the time, your actual  display is ok but, also quite often, many people wants to travel together and want to see in a nut shell
 * what is available to quickly find when they can reserve together.
 * Therefore a linear summary calendar with the following format would be a very useful tool. 
 * A character would give the status: 0=not available, 1=available
 * (in fact the number could be the number of persons that can stay in that resource ?), w= in a process of reservation
 *
 * �         Month                 June                                                                     July                                                                                      August
 * �         Ressource         01 02 03 03 05 06 07 08 09 10 11 �             01 02 03 04 �                                                                    01 02 03 04 �
 * �         Ressource 1       0   0    1   1   1   1    1   1    1    w w
 * �         Ressource 2
 *
 * Make categories for resources? I have like 70 resources, and it would be great if i could split the choices on different pages or categories.
 *
 * Show apprtment name nearly each day, if these days in diferent rooms (Hotel Edition, MultiUser)
 *
 * Think about this feature: In combination with auto cancell posibility To deactivate the Pending option. If a customer books a particular date interval without paying, the booking request must be transfered for future payment, but must not block the calendar dates. Other visitors must be able to book these dates as long as the intial customer's payment has not come through. set pending days for selection by other visitors, untill admin will not approve them. * Allow pending bookings to be chosen with an explanation that they will be on a waiting list in the event that the original booker cancels.
 * My Account & Added Extras � We are investigating ways of people (visitors) logging in to see past orders and potentially adding items to the order, like for example booking a spa treatment, or an upgraded food package.
 *
 * Add posibility to select booking resource from select box as a feature of booking calendar - no anymore JS tricks
 * Search results at new seperate page, diferent from search form
 * ---------------------------------------------------------------------------------------------------------------------------------------



= 2.9 =
* Professional / Premium / Premium Plus / Hotel / MultiUser versions features:
 *  (Professional, Premium, Premium Plus, Hotel Edition, MultiUser)
* Features and issue fixings in All versions:
 * 

*/
// </editor-fold>


    // Die if direct access to file
    if (   (! isset( $_GET['merchant_return_link'] ) ) && (! isset( $_GET['payed_booking'] ) ) && (!function_exists ('get_option')  )  && (! isset( $_POST['ajax_action'] ) ) ) { 
        die('You do not have permission to direct access to this file !!!');
    }

    // A J A X /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ( ( isset( $_GET['payed_booking'] ) )  || (  isset( $_GET['merchant_return_link']))  || ( isset( $_POST['ajax_action'] ) ) ) { 
        require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   D e f i n e     S T A T I C              //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!defined('WP_BK_DEBUG_MODE'))    define('WP_BK_DEBUG_MODE',  false );
    if (!defined('WPDEV_BK_FILE'))       define('WPDEV_BK_FILE',  __FILE__ );

    if (!defined('WP_CONTENT_DIR'))      define('WP_CONTENT_DIR', ABSPATH . 'wp-content');                   // Z:\home\test.wpdevelop.com\www/wp-content
    if (!defined('WP_CONTENT_URL'))      define('WP_CONTENT_URL', site_url() . '/wp-content');    // http://test.wpdevelop.com/wp-content
    if (!defined('WP_PLUGIN_DIR'))       define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');               // Z:\home\test.wpdevelop.com\www/wp-content/plugins
    if (!defined('WP_PLUGIN_URL'))       define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');               // http://test.wpdevelop.com/wp-content/plugins
    if (!defined('WPDEV_BK_PLUGIN_FILENAME'))  define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );              // menu-compouser.php
    if (!defined('WPDEV_BK_PLUGIN_DIRNAME'))   define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) ); // menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_DIR')) define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // Z:\home\test.wpdevelop.com\www/wp-content/plugins/menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_URL')) define('WPDEV_BK_PLUGIN_URL', WP_PLUGIN_URL.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // http://test.wpdevelop.com/wp-content/plugins/menu-compouser


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //   L O A D   F I L E S                      //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php')) {     // S u p p o r t    f u n c t i o n s
        require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-functions.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php'))  {             // C A P T C H A
        require_once(WPDEV_BK_PLUGIN_DIR. '/js/captcha/captcha.php' );}

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php'))   {             // O t h e r
        require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php' ); }

    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php'))           // C L A S S    B o o k i n g
        { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-class.php' ); }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET VERSION NUMBER
    $plugin_data = get_file_data_wpdev(  __FILE__ , array( 'Name' => 'Plugin Name', 'PluginURI' => 'Plugin URI', 'Version' => 'Version', 'Description' => 'Description', 'Author' => 'Author', 'AuthorURI' => 'Author URI', 'TextDomain' => 'Text Domain', 'DomainPath' => 'Domain Path' ) , 'plugin' );
    if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',   $plugin_data['Version'] );                             // 0.1
            
    //  T R A N S L A T I O N S   //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (defined('WP_ADMIN')) if (WP_ADMIN === true) load_bk_Translation();
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //    A J A X     R e s p o n d e r     // RUN if Ajax //
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php'))  { require_once(WPDEV_BK_PLUGIN_DIR. '/lib/wpdev-booking-ajax.php' ); }

    // RUN //
    $wpdev_bk = new wpdev_booking(); 
?>