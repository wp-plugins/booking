<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://wpbookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Version: 5.1.5
Author: wpdevelop
Author URI: http://wpbookingcalendar.com/
Tested WordPress Versions: 3.3 - 3.9.1
*/

/*  Copyright 2009 - 2014  www.wpbookingcalendar.com  (email: info@wpbookingcalendar.com),

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
 * New/OLD Files:
 * =====================================
 * - ../img/shopping_trolley.png
 * - ../img/Season-64x64.png
 * - ../img/users-48x48.png
 * - ../img/General-setting-64x64.png
 * - ../img/E-mail-64x64.png
 * - ../img/Form-fields-64x64.png
 * - ../img/availability.png
 * - ../img/advanced_cost.png
 * - ../img/coupon.png
 * - ../img/Paypal-cost-64x64.png
 * - ../img/Resources-64x64.png
 * - ../img/Booking-search-64x64.png
 * - ../img/Booking-costs-64x64.png
 * - ../img/add-1-48x48.png
 * - ../img/
 * - ../img/
 * - ../img/
 * - ../img/
 * 
 * 
 * ====================================
*/
    
    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) die('<h3>Direct access to this file do not allow!</h3>');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // PRIMARY URL CONSTANTS                        //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    // ..\home\siteurl\www\wp-content\plugins\plugin-name\wpdev-booking.php
    if ( ! defined( 'WPDEV_BK_FILE' ) )             define( 'WPDEV_BK_FILE', __FILE__ ); 
    
    // wpdev-booking.php
    if ( ! defined('WPDEV_BK_PLUGIN_FILENAME' ) )   define('WPDEV_BK_PLUGIN_FILENAME', basename( __FILE__ ) );                     

    // plugin-name    
    if ( ! defined('WPDEV_BK_PLUGIN_DIRNAME' ) )    define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename( dirname( __FILE__ ) )  );  
    
    // ..\home\siteurl\www\wp-content\plugins\plugin-name
    if ( ! defined('WPDEV_BK_PLUGIN_DIR' ) )        define('WPDEV_BK_PLUGIN_DIR', untrailingslashit( plugin_dir_path( WPDEV_BK_FILE ) )  );
    
    // http: //website.com/wp-content/plugins/plugin-name
    if ( ! defined('WPDEV_BK_PLUGIN_URL' ) )        define('WPDEV_BK_PLUGIN_URL', untrailingslashit( plugins_url( '', WPDEV_BK_FILE ) )  );     
          
    require_once WPDEV_BK_PLUGIN_DIR . '/lib/wpbc.php'; 
?>