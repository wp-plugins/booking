<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://booking.wpdevelop.com/
Description: Online reservation and availability checking service for your site.
Version: 1.4
Author: wpdevelop.com
Author URI: http://www.wpdevelop.com
*/

/*  Copyright 2009,  www.wpdevelop.com  (email: info@wpdevelop.com),

    www.wpdevelop.com - custom wp-plugins development & WordPress solutions.

    This file (and only this file) is free software; you can redistribute it and/or modify
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

/*
Tested WordPress Versions: 2.8.3 - 2.8.6
-----------------------------------------------
Change Log and Features for Future Releases :
-----------------------------------------------
= 1.5 =
>>>> Payment cost calculation depends from the period
 * Several Booking calendars skins (pro version)
 * Captcha to the form
 * Dublicated emeils sending to specific emeil for audit of each reservation or approval or cancellation (pro version).
 * Showing booking from all booking types at admin panel
 * User roles management for access inside of plugin
 * Posibility to add at the booking bookmark how many days to select in range there.
 * Set export import data through CSV files

= 1.4.1 =
 * Professional and Premium version features:
  * Set unavailable dayes for the booking.

= 1.4 =
 * Professional and Premium version features:
  * New versions of Booking Calendar - Booking Calendar Premium. Version Booking Calendar Deluxe is closed alternative - Booking Calendar Premium
  * Booking for specific time. Divide day to the parts according to the booking time (Booking Calendar Premium)
  * Posibility to enter price per day, per night per hour and fixed price.
  * Set start and end time at the range days selection (week selection) (Booking Calendar Premium)
 * Features and issue fixings in All versions:
  * Set time for showing thank you message after new booking is done
  * Multiple / Single day(s) selection feature
  * Admin panel checkbox - selection all booking in one time at booking tables (aproval, reserved)
  * Fixing bug with PHP 4 - "Fatal error: Nesting level too deep - recursive dependency" during activation of Widget
  * Fixing bug with PHP 5.3.0 - "Deprecated: Assigning the return value of new by reference is deprecated in ... "
  * Fixing issue of not correctly showing this ' symbol at the emeils and reservation forms.
  * Correct showing translation for the dates inside emeil and booking tables.

= 1.3.3 =
 * Features and issue fixings in All versions:
  * Show aproved and pending dates in diferent colors at client side view

= 1.3.2 =
 * Features and issue fixings in All versions:
  * Correction issue with Ajax error (this bug is apper when URL at the location bar was diferent from the saved location of blog. Common situation 'www' is not at location bar)
  * Set footer "powered by copyright" - not default during installation

= 1.3.1 =
 * Features and issue fixings in All versions:
  * Fixed some issues at calendar style
  * Fixed not showing booking calendar button at toolbar, when user deactivated visual editor.

= 1.3 =
 * Professional and Delux version features:
  * Paypal static Deposit payment do not depends from count of booking days for some booking properties (delux version).
 * Features and issue fixings in All versions:
  * Translation to other languages
  * Fixed issue with uncorrect showing dates at the Booking administration (approval / reserved) tables in some timezone (for example in Losangeles).


= 1.2 =
 * Professional and Delux version features:
  * Support of selection several days at once - range selection, for example make a minimum booking a 5 or 7 days (delux version).
  * Support of start day of week for range selection, for example make a selection from monday till friday only (delux version).
  * Rename "Booking Calendar Professional with paypal module" to "Booking Calendar Delux"
  * Added full list of 23 currencies, which are available at PayPal.
 * Features and issue fixings in All versions:
  * Fixing issue with not showing calendar, when theme or some plugin use other version of jQuery
  * Booking form widgets ( show only booking calendar or show full booking form)
  * Inseting booking form at any place not only into post or page, using action hook: "wpdev_bk_add_calendar" - showing only calendar, "wpdev_bk_add_form" - showing booking form. Check FAQ for usage of it.

= 1.1 =
 * Professional version features:
  * PayPal support online payment for booking. Enter price of day for each booking types.
  * Emeil customization form support new bookmrak - [name]. Its name of person, who made reservation.
 * Features and issue fixings in Free and Professional versions:
  * Customization of Date Format inside of emeils and booking table.
  * Posibility to enter message, which are show after reservation is done
  * Fixing issue with deactivation previous version before install new version, or during automatic update

= 1.0 =
 * Professional version features:
  * Multiple booking types (property) support. { Possibility to make several booking ( for example for different rooms) at the same date}
  * Email customization for approve, decline and new reservation (custom emails, subject, content... )
  * Booking fields customization from reservation form, customization of showing data from form after booking.
  * Time of start and finish booking, using additional time fields inside booking form
  * Time validation at the client side
  * Inserting calendar using 'Calendar TAG' in any place of booking form
 * Features and issue fixings in Free and Professional versions:
  * Fixed issue of showing calendar button at the TinyMCE at Safari and IE browsers
  * Fixing "Parse error: syntax error, unexpected T_VARIABLE, expecting T_FUNCTION in … wpdev-booking.php on line 1453"
  * Added decline reason of booking at the admin page
  * New Ajax message system
  * Solving problem with showing Ajax error window
  * Do not hiding reservation form after booking at the Admin part
  * New Validation of required fields and email field

= 0.7 =
 * Completly replaced calendar to new jQuery version
 * Solving issue with not showing calendar at client side of blog (because of conflicts mootols and prototype library from other wp-plugins)
 * New skin of calendar
 * Select startday of week

= 0.6 =
 * Fixed PHP4 issue of do not showing calendar at admin page
 * TiniMCE button at editor toolbar for inserting calendar
 * Created several sub menus pages - Booking calendar, Add booking from Admin page, Settings
 * New page - Admin reservation page, where admin can reserve some days
 * New Settings page - Save different options like start day of week, count of calendars, deactivation option and other
 * Adding Icons to the admin pages

= 0.5 =
* Inital beta release

 */


function wpdev_bk_define_static() {
    if (!defined('WPDEV_BK_VERSION'))    define('WPDEV_BK_VERSION',  '1.4' );                             // 0.1
    if (!defined('WP_CONTENT_DIR'))   define('WP_CONTENT_DIR', ABSPATH . 'wp-content');                   // Z:\home\test.wpdevelop.com\www/wp-content
    if (!defined('WP_CONTENT_URL'))   define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');    // http://test.wpdevelop.com/wp-content
    if (!defined('WP_PLUGIN_DIR'))       define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');               // Z:\home\test.wpdevelop.com\www/wp-content/plugins
    if (!defined('WP_PLUGIN_URL'))       define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');               // http://test.wpdevelop.com/wp-content/plugins
    if (!defined('WPDEV_BK_PLUGIN_FILENAME'))  define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );              // menu-compouser.php
    if (!defined('WPDEV_BK_PLUGIN_DIRNAME'))   define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) ); // menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_DIR')) define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // Z:\home\test.wpdevelop.com\www/wp-content/plugins/menu-compouser
    if (!defined('WPDEV_BK_PLUGIN_URL')) define('WPDEV_BK_PLUGIN_URL', WP_PLUGIN_URL.'/'.WPDEV_BK_PLUGIN_DIRNAME ); // http://test.wpdevelop.com/wp-content/plugins/menu-compouser

    require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-gui-bk.php' );           // Connect my GUI class
    if (file_exists(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php')) { require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-pro.php' ); }

    // Localization
    if ( ! loadLocale() )  loadLocale('en_US');
    //loadLocale('ru_RU');
}

// Load locale
function loadLocale($locale = ''){ // Load locale, if not so the  load en_EN default locale from folder "languages" files like "this_file_file_name-ru_RU.po" and "this_file_file_name-ru_RU.mo"
    if ( empty( $locale ) ) $locale = get_locale(); 
    if ( !empty( $locale ) ) {
            //Filenames like this  "microstock-photo-ru_RU.po",   "microstock-photo-de_DE.po" at folder "languages"
            $mofile = WPDEV_BK_PLUGIN_DIR  .'/languages/'.str_replace('.php','',WPDEV_BK_PLUGIN_FILENAME).'-'.$locale.'.mo';
            if (file_exists($mofile))   return load_textdomain(str_replace('.php','',WPDEV_BK_PLUGIN_FILENAME), $mofile);
            else                        return false;
    } return false;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Getting Ajax requests
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( isset( $_POST['ajax_action'] ) ) {
        define('DOING_AJAX', true);
        require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
        wpdev_bk_define_static();
        if ( class_exists('wpdev_bk_pro')) { $wpdev_bk_pro_in_ajax = new wpdev_bk_pro(); }
        wpdev_bk_ajax_responder();
} /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


wpdev_bk_define_static();


if (!class_exists('wpdev_booking')) {
    class wpdev_booking   {

        var $gui_booking;  // GUI class
        var $gui_settings;
        var $gui_reservation;
        var $prefix;
        var $settings;
        var $wpdev_bk_pro;

        function wpdev_booking() {

            $this->prefix = 'wpdev_bk';
            $this->settings = array(  'custom_buttons' =>array(),
                                'custom_buttons_func_name_from_js_file' => 'set_bk_buttons', //Edit this name at the JS file of custom buttons
                                'custom_editor_button_row'=>1 );

            
            
            if ( class_exists('wpdev_bk_pro')) {
                $this->wpdev_bk_pro = new wpdev_bk_pro();
            } else { $this->wpdev_bk_pro = false; }

            $this->gui_booking = new wpdev_gui_bk('wpdev-booking',__FILE__,__('Booking services', 'wpdev-booking'), __('Booking', 'wpdev-booking'),'');
            add_action('admin_menu', array(&$this->gui_booking, 'on_admin_menu'));
            $this->gui_booking->user_level = 0;
            $this->gui_booking->set_icon(array(WPDEV_BK_PLUGIN_URL . '/img/calendar-16x16.png', WPDEV_BK_PLUGIN_URL . '/img/calendar-48x48.png'));
            $this->gui_booking->add_content(array($this, 'content_of_booking_page'));

            $this->gui_reservation = new wpdev_gui_bk('wpdev-booking-reservation',__FILE__  ,__('Add booking', 'wpdev-booking'), __('Add booking', 'wpdev-booking'),'submenu','', __FILE__ . $this->gui_booking->gui_html_id_prefix,0);
            add_action('admin_menu', array(&$this->gui_reservation, 'on_admin_menu'));
            $this->gui_reservation->set_icon(array('', WPDEV_BK_PLUGIN_URL . '/img/add-1-48x48.png'));
            $this->gui_reservation->add_content(array($this, 'content_of_reservation_page'));

            $this->gui_settings = new wpdev_gui_bk('wpdev-booking-option',__FILE__  ,__('Booking settings', 'wpdev-booking'), __('Settings', 'wpdev-booking'),'submenu','', __FILE__ . $this->gui_booking->gui_html_id_prefix,1);
            add_action('admin_menu', array(&$this->gui_settings, 'on_admin_menu'));
            $this->gui_settings->set_icon(array('', WPDEV_BK_PLUGIN_URL . '/img/application-48x48.png'));
            $this->gui_settings->add_content(array($this, 'content_of_settings_page'));/**/

            
            add_action('admin_menu', array(&$this,'on_add_admin_plugin_page'));     // Page hook for admin JS files ONLY at this plugin page
            add_action('wp_head',array(&$this, 'client_side_print_booking_head'));

            add_action( 'init', array(&$this,'add_custom_buttons') );               // Add custom buttons
            add_action( 'admin_head', array(&$this,'insert_wpdev_button'));

            add_action( 'wp_footer', array(&$this,'wp_footer') );
            add_action( 'admin_footer', array(&$this,'print_js_at_footer') );

            add_action( 'wpdev_bk_add_calendar', array(&$this,'add_calendar_action') ,10 , 2);
            add_action( 'wpdev_bk_add_form',     array(&$this,'add_booking_form_action') ,10 , 2);

            add_shortcode('booking', array(&$this, 'booking_shortcode'));

            add_filter('plugin_action_links', array(&$this, 'plugin_links'), 10, 2 );

            add_action( 'init', array(&$this,'add_booking_widjet') );               // Add widjet

            register_activation_hook( __FILE__, array(&$this,'wpdev_booking_activate' ));
            register_deactivation_hook( __FILE__, array(&$this,'wpdev_booking_deactivate' ));

           
           
        }

        //   F U N C T I O N S       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
                                                'img'=> $this->gui_booking->icon_url,
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
                                wp_enqueue_style( $this->prefix . '-jquery-ui',WPDEV_BK_PLUGIN_URL. '/js/custom_buttons/jquery-ui.css', array(), $this->prefix, 'screen' );
                            }
                        }

                        // Add button code to the tiny editor
                        function insert_wpdev_button(){
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
                                $datajs.= '		cal_count: "' . get_option( 'booking_client_cal_count' )  . '"' . "\n";
                                $datajs.=  "\n	};\n";
                            }
                            ?>
                            <script type="text/javascript">

                            // <![CDATA[
                                var wpdev_bk_Data={};
                                <?php echo $datajs; ?>

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
                                    var buttons = { "<?php echo js_escape(__('Ok', 'wpdev-booking')); ?>": wpdev_bk_ButtonOk,
                                                    "<?php echo js_escape(__('Cancel', 'wpdev-booking')); ?>": wpdev_bk_DialogClose
                                                  };
                                    var title = '<img src="<?php echo $this->gui_booking->icon_url; ?>" /> ' + wpdev_bk_Data[tag]["title"];
                                    jWPDev("#wpdev_bk-dialog").dialog({ autoOpen: false, width: wpdev_bk_DialogDefaultWidth, minWidth: wpdev_bk_DialogDefaultWidth, height: wpdev_bk_DialogDefaultHeight, minHeight: wpdev_bk_DialogDefaultHeight, maxHeight: wpdev_bk_DialogMaxHeight, title: title, buttons: buttons});

                                    // Reset the dialog box incase it's been used before
                                    jWPDev("#wpdev_bk-dialog input").val("");
                                    jWPDev("#calendar_tag_name").val(wpdev_bk_Data[tag]['tag']);
                                    jWPDev("#calendar_tag_close").val(wpdev_bk_Data[tag]['tag_close']);
                                    jWPDev("#calendar_count").val(wpdev_bk_Data[tag]['cal_count']);
                                    // Style the jWPDev-generated buttons by adding CSS classes and add second CSS class to the "Okay" button
                                    jWPDev(".ui-dialog button").addClass("button").each(function(){
                                        if ( "<?php echo js_escape(__('Ok', 'wpdev-booking')); ?>" == jWPDev(this).html() ) jWPDev(this).addClass("button-highlighted");
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


                                    if ( !cal_tag ) return wpdev_bk_DialogClose();

                                    var text = '[' + cal_tag;

                                    if (cal_count) text += ' ' + 'nummonths=' + cal_count;
                                    if (cal_type) text += ' ' + 'type=' + cal_type;
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
                                                    <?php
                                                        if( $this->wpdev_bk_pro !== false ) {
                                                            $types_list = $this->wpdev_bk_pro->get_booking_types();

                                                    ?>
                                                        <div class="field">
                                                            <label for="calendar_type"><?php _e('Type of booking:', 'wpdev-booking'); ?></label>
                                                            <!--input id="calendar_type"  name="calendar_type" class="input" type="text" -->
                                                            <select id="calendar_type" name="calendar_type">
                                                            <?php foreach ($types_list as $tl) { ?>
                                                                <option value="<?php echo $tl->id; ?>"><?php echo $tl->title; ?></option>
                                                            <?php } ?>
                                                            </select>

                                                            <span class="description"><?php _e('For booking select type of booking resource', 'wpdev-booking'); ?></span>
                                                        </div>
                                                    <?php }/**/ ?>
                                                    <div class="field">
                                                        <label for="calendar_count"><?php _e('Count of calendars:', 'wpdev-booking'); ?></label>
                                                        <input id="calendar_count"  name="calendar_count" class="input" type="text" value="<?php echo get_option( 'booking_client_cal_count' ); ?>" >
                                                        <span class="description"><?php _e('Enter number of month to show for calendar.', 'wpdev-booking'); ?></span>
                                                    </div>

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
                                global $user_id;
                                // Attempt to match the dialog box to the admin colors
                                if ( 'classic' == get_user_option('admin_color', $user_id) ) {
                                        $color = '#093E56';
                                        $background = '#EAF2FA';
                                } else {
                                        $color = '#464646';
                                        $background = '#DFDFDF';



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
                                                    margin:2px auto;
                                               }';
                                          }
                                     ?>
                                    .ui-dialog-title img{
                                       margin:3px auto;
                                        width:16px;
                                        height:16px;
                                    }
                                #wpdev_bk-dialog .field {line-height:25px;margin:5px 0px;}
                                #wpdev_bk-dialog .field label {float:left; padding-right:10px;width:155px;text-align:left; font-weight:bold;}
                                #wpdev_bk-dialog .wpdev_bk-dialog-inputs {float:left;}
                                #wpdev_bk-dialog input ,#wpdev_bk-dialog select {  width:80px;  }
                                #wpdev_bk-dialog .input_check {width:10px; margin:5px 10px;text-align:center;}
                                #wpdev_bk-dialog .dialog-wraper {float:left;width:100%;}

                                </style>
                        <?php
                        }

                        // E N D   C u s t o m   b u t t o n s  //////////////////////////////////////////////////////////////


         // Adds Settings link to plugins settings
        function plugin_links($links, $file) { 

            $this_plugin = plugin_basename(__FILE__);

            if ($file == $this_plugin){
                $settings_link = '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option">'.__("Settings", 'wpdev-booking').'</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
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

        // Change date format
        function get_showing_date_format($mydate ){
           $date_format = get_option( 'booking_date_format');
           if ($date_format == '') $date_format = "d.m.Y";

           $time_format = get_option( 'booking_time_format');
           if ( $time_format !== false  ) {
               $time_format = ' ' . $time_format;
               $my_time = date('H:i:s' , $mydate);
               if ($my_time == '00:00:00')     $time_format='';
           }
           else  $time_format='';

           // return date($date_format . $time_format , $mydate);
           return date_i18n($date_format . $time_format , $mydate);

       }


        // Get dates
        function get_dates ($approved = 'all', $bk_type = 1) {

            global $wpdb;
            $dates_array = $time_array = array();

            if ($approved == 'all')
                $dates_approve = $wpdb->get_results(
                    "SELECT DISTINCT dt.booking_date

                     FROM ".$wpdb->prefix ."bookingdates as dt

                     INNER JOIN ".$wpdb->prefix ."booking as bk

                     ON    bk.booking_id = dt.booking_id

                     WHERE  dt.booking_date >= CURDATE()  AND bk.booking_type = $bk_type

                     ORDER BY dt.booking_date" );
            else
                $dates_approve = $wpdb->get_results(
                    "SELECT DISTINCT dt.booking_date
                    
                     FROM ".$wpdb->prefix ."bookingdates as dt
                     
                     INNER JOIN ".$wpdb->prefix ."booking as bk

                     ON    bk.booking_id = dt.booking_id

                     WHERE  dt.approved = $approved AND dt.booking_date >= CURDATE() AND bk.booking_type = $bk_type 

                     ORDER BY dt.booking_date" );

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

        //Write Admin booking table
        function booking_table($approved = 0) {

            global $wpdb;

            $bk_type =1;

            if ( isset( $_GET['booking_type'] ) ) $bk_type = $_GET['booking_type'];

            $sql = "SELECT *

                        FROM ".$wpdb->prefix ."booking as bk

                        INNER JOIN ".$wpdb->prefix ."bookingdates as dt

                        ON    bk.booking_id = dt.booking_id

                        WHERE approved = $approved AND dt.booking_date >= CURDATE()

                        AND bk.booking_type = ". $bk_type ."

                        ORDER BY bk.booking_id DESC, dt.booking_date ASC

                ";



            $result = $wpdb->get_results( $sql );
            $old_id = '';
            $alternative_color = '';

            if ($approved == 0) {$outColor = '#FFBB45'; $outColorClass = '0';}
            if ($approved == 1) {$outColor = '#9be'; $outColorClass = '1';}

            if ( count($result) > 0 ) {
                ?>
            <table class='booking_table' cellspacing="0">
                <tr>
                    <th style="width:15px;"> <input type="checkbox" onclick="javascript:setCheckBoxInTable(this.checked, 'booking_appr<?php echo $approved; ?>');" class="booking_allappr<?php echo $approved; ?>" id="booking_allappr_<?php echo $approved; ?>"  name="booking_allappr_<?php echo $approved; ?>" </th>
                    <th style="width:15px;"><?php _e('ID', 'wpdev-booking'); ?></th>
                    <th style="width:49%;"><?php _e('Info', 'wpdev-booking'); ?></th>
                    <th><?php _e('Dates', 'wpdev-booking'); ?></th>
                </tr>
                                <?php
                                foreach ($result as $bk) {
                                    if ($old_id !== $bk->booking_id ) { //add NEW full row

                                        if ($old_id !=='') {  // Close previos roW
                                            echo "</td></tr>";
                                        }
                                        $old_id = $bk->booking_id;
                                        if ( $alternative_color == '')  $alternative_color = ' class="alternative_color" ';
                                        else $alternative_color = ''
                                                ?>
                <tr>
                    <td <?php echo $alternative_color; ?> >
                        <input type="checkbox" class="booking_appr<?php echo $approved; ?>" id="booking_appr_<?php  echo $bk->booking_id  ?>"  name="booking_appr_<?php  echo $bk->booking_id  ?>"
                                                       <?php  //if ($bk->approved) echo 'checked="checked"';  ?>  />
                    </td>
                    <td <?php echo $alternative_color; ?> > <?php  echo $bk->booking_id  ?> </td>
                    <td <?php echo $alternative_color; ?> >
        
            <?php

            $cont = get_form_content($bk->form) ;  ?>
            <div style="display:block;font-size:11px;line-height:20px;" id="full<?php  echo $bk->booking_id;  ?>" >
                <?php

                $search = array ("'(<br[ ]?[/]?>)+'si","'(<p[ ]?[/]?>)+'si","'(<div[ ]?[/]?>)+'si");
                $replace = array ("&nbsp;&nbsp;"," &nbsp; "," &nbsp; ");

                $yt_description = preg_replace($search, $replace, $cont['content']);
                echo $yt_description;  ?>
            </div>

        </td>
        <td <?php echo $alternative_color; ?> 
            <span><a href="#" class="booking_overmause<?php echo $outColorClass; ?>"
               onmouseover="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('U',$bk->booking_date)) + 0 );
                                       ?>','#ff0000');"
               onmouseout="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('U',$bk->booking_date)) + 0 );
                                       ?>','<?php echo $outColor; ?>');"
               ><?php echo $this->get_showing_date_format( mysql2date('U',$bk->booking_date) );?></a></span><?php

                                } else {                            // add only dates
                                    echo ', '; ?>
            <span><a href="#" class="booking_overmause<?php echo $outColorClass; ?>"
               onmouseover="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('U',$bk->booking_date)) + 0 );
                                       ?>','#ff0000');"
               onmouseout="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('U',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('U',$bk->booking_date)) + 0 );
                                       ?>','<?php echo $outColor; ?>');"
               ><?php echo $this->get_showing_date_format( mysql2date('U',$bk->booking_date) );?></a></span><?php
                                   }
                               }
                            ?> </td></tr></table> <?php
                    return true;
                } else {
                    return false;
                }

            }




        //   A D M I N     S I D E   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       
        // Add widjet controlls
        function booking_widget_control(){

             if (isset($_POST['booking_widget_title'] )) {

               update_option('booking_widget_title', htmlspecialchars($_POST['booking_widget_title']));
               update_option('booking_widget_show',  $_POST['booking_widget_show']);
               if( $this->wpdev_bk_pro !== false ) { update_option('booking_widget_type',  $_POST['booking_widget_type']); }
               update_option('booking_widget_calendar_count',  $_POST['booking_widget_calendar_count']);

               $booking_widget_last_field = htmlspecialchars($_POST['booking_widget_last_field']);
               $booking_widget_last_field = str_replace('\"', "'" , $booking_widget_last_field);
               $booking_widget_last_field = str_replace("\'", "'" , $booking_widget_last_field);
               update_option('booking_widget_last_field', $booking_widget_last_field );
             }
             $booking_widget_title = get_option('booking_widget_title');
             $booking_widget_show  =  get_option('booking_widget_show');
             if( $this->wpdev_bk_pro !== false ) { $booking_widget_type  =  get_option('booking_widget_type'); } else $booking_widget_type=1;
             $booking_widget_calendar_count  =  get_option('booking_widget_calendar_count');
             $booking_widget_last_field = get_option('booking_widget_last_field');

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

            ?>
            <p>
                <label><?php _e('Booking resource', 'wpdev-booking'); ?>:</label><br/>
                    <!--input id="calendar_type"  name="calendar_type" class="input" type="text" -->
                    <select id="booking_widget_type" name="booking_widget_type"  style="width:100%;">
                    <?php foreach ($types_list as $tl) { ?>
                        <option  <?php if($booking_widget_type == $tl->id ) echo "selected"; ?> value="<?php echo $tl->id; ?>"><?php echo $tl->title; ?></option>
                    <?php } ?>
                    </select>
                    
            </p>
            <?php } ?>

            <p>
            <label><?php _e('Count of calendars', 'wpdev-booking'); ?>:</label><br/>
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
        function add_booking_widjet(){
           
            $widget_options = array('classname' => 'widget_wpdev_booking', 'description' => __( "Display Booking.", 'wpdev-booking') );
            wp_register_sidebar_widget('wpdev_booking_widget', __('Booking', 'wpdev-booking'), 'show_booking_widget_php4', $widget_options);
            wp_register_widget_control('wpdev_booking_widget', __('Booking settings', 'wpdev-booking'), array(&$this, 'booking_widget_control') );
        }



        // Print scripts only at plugin page
        function on_add_admin_plugin_page() {
            add_action("admin_print_scripts-" . $this->gui_booking->pagehook , array( &$this, 'on_add_admin_js_files'));

            global $submenu, $menu;               // Change Title of the Main menu inside of submenu
            $submenu[plugin_basename( __FILE__ ) . $this->gui_booking->gui_html_id_prefix][0][0] = __('Booking calendar', 'wpdev-booking');

            add_action("admin_print_scripts-" . $this->gui_settings->pagehook , array( &$this, 'on_add_admin_js_files'));
            add_action("admin_print_scripts-" . $this->gui_reservation->pagehook , array( &$this, 'client_side_print_booking_head'));
        }

        // add hook for printing scripts only at this plugin page
        function on_add_admin_js_files() {
            // Write inline scripts and CSS at HEAD
            add_action('admin_head', array(&$this, 'head_print_js_css_admin' ), 1);
        }



        // HEAD for ADMIN page
        function head_print_js_css_admin() {
            $this->print_js_css(1); 
        }

        //JS at footer
        function print_js_at_footer(){ 
          if ( ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking')!==false) &&
               ( strpos($_SERVER['REQUEST_URI'],'wpdev-booking.phpwpdev-booking-reservation')===false )
             )   {

                if ( isset($_GET['booking_type']) ) { $bk_type = $_GET['booking_type']; }
                else                                { $bk_type = '1';}
                $my_boook_type = $bk_type ;

                $start_script_code = "<script type='text/javascript'>";
                $start_script_code .= "  jWPDev(document).ready( function(){";


            $start_script_code .= "  date2approve[". $bk_type. "] = [];";
            $dates_and_time_to_approve = $this->get_dates('0', $bk_type);
            $dates_to_approve = $dates_and_time_to_approve[0];
            $times_to_approve = $dates_and_time_to_approve[1];$i=-1;
            foreach ($dates_to_approve as $date_to_approve) { $i++;

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
            $dates_and_time_to_approve = $this->get_dates('1', $my_boook_type);
            $dates_approved =   $dates_and_time_to_approve[0];
            $times_to_approve = $dates_and_time_to_approve[1];$i=-1;
            foreach ($dates_approved as $date_to_approve) { $i++;

                $td_class =   ($date_to_approve[1]+0)."-".($date_to_approve[2]+0)."-".($date_to_approve[0]);

                $start_script_code .= " if (typeof( date_approved_par[ '". $td_class . "' ] ) == 'undefined'){ ";
                            $start_script_code .= " date_approved_par[ '". $td_class . "' ] = [];} ";

                $start_script_code.=" date_approved_par[ '".$td_class."' ][  date_approved_par['".$td_class."'].length  ] = [".
                                                            ($date_to_approve[1]+0).",".($date_to_approve[2]+0).",".($date_to_approve[0]+0).", ".
                                                            ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                                                             "];";
            }

                $start_script_code .= "     init_datepick_cal('". $bk_type ."',   date_approved_par, ".
                                                                  get_option( 'booking_admin_cal_count' ).", ".
                                                                  get_option( 'booking_start_day_weeek' ) . " );";
                $start_script_code .= "});";
                $start_script_code .= "</script>";
                $start_script_code = apply_filters('wpdev_booking_calendar', $start_script_code , $my_boook_type);
                echo $start_script_code;
           }
        }

       // Print     J a v a S cr i p t   &    C S S    scripts for admin and client side.
        function print_js_css($is_admin =1 ) { 

            if (! ( $is_admin))  wp_print_scripts('jquery');
            //wp_print_scripts('jquery-ui-core');

           //   J a v a S c r i pt
           ?> <!-- Booking Calendar Scripts -->
                    <script  type="text/javascript">
                        var jWPDev = jQuery.noConflict();
                        var wpdev_bk_plugin_url = '<?php echo WPDEV_BK_PLUGIN_URL; ?>';
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
                        <?php if (  ( get_option( 'booking_multiple_day_selections' ) == 'Off') && ( get_option( 'booking_range_selection_is_active') !== 'On' )  ) { ?>
                            var multiple_day_selections = 0;
                        <?php } else { ?>
                            var multiple_day_selections = 50;
                        <?php } ?>
                        var wpdev_bk_pro =<?php if(  $this->wpdev_bk_pro !== false  ) { echo '1'; } else { echo '0'; } ?>;

                        var message_verif_requred = '<?php _e('This field is required', 'wpdev-booking'); ?>';
                        var message_verif_emeil = '<?php _e('Incorrect email field', 'wpdev-booking'); ?>';
                        var message_verif_selectdts = '<?php _e('Please, select reservation date(s) at Calendar.', 'wpdev-booking'); ?>';

                    </script>
           <?php do_action('wpdev_bk_js_define_variables'); 
           ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/datepick/jquery.datepick.js"></script>  <?php            
            $locale = get_locale();  //$locale = 'ru_RU'; // Load translation for calendar
            if ( !empty( $locale ) ) 
                   if (file_exists(WPDEV_BK_PLUGIN_DIR. '/js/datepick/jquery.datepick-'. substr($locale,0,2) .'.js'))
           ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/datepick/jquery.datepick-<?php echo substr($locale,0,2); ?>.js"></script>  <?php
           ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/wpdev.bk.js"></script>  <?php
           ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/tooltip/tools.tooltip.min.js"></script>  <?php

           do_action('wpdev_bk_js_write_files')
           ?> <!-- End Booking Calendar Scripts --> <?php

           //    C S S
           ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/datepick/wpdev_booking.css" rel="stylesheet" type="text/css" /> <?php
           //   Admin and Client
           if($is_admin) { ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/admin.css" rel="stylesheet" type="text/css" />  <?php }
           else {
               if ( strpos($_SERVER['REQUEST_URI'],'wp-admin/admin.php?') !==false ) {
                    ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/admin.css" rel="stylesheet" type="text/css" />  <?php 
               }
               ?> <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/css/client.css" rel="stylesheet" type="text/css" /> <?php

               // Show dates in diferent colors: aproved and pending dates
               if (  get_option( 'booking_dif_colors_approval_pending'   ) == 'Off') { ?>
               <style type="text/css">
                   .datepick  .date2approve, .datepick  .date_approved {
                    color:#aaa !important;
                }
               </style> <?php 
               }
           }

         }


        // CONTENT OF THE ADMIN PAGE
        function content_of_booking_page () {
            ?>
           <div id="ajax_working"></div>
                <div class="clear" style="height:20px;"></div>
                <?php if( $this->wpdev_bk_pro !== false ) $this->wpdev_bk_pro->booking_types_pages();
                      else {
                          ?>    <div id="help_screeen_pro">
                                        <div style="clear:both;"></div>
                                        <div style="margin:0px 5px auto;text-align:left;">
                                        <img style="margin:0px 0px 0px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/top_line.png" >
                                        </div>
                                        <div class="clear" style="height:5px;border-bottom:1px solid #cccccc;"></div>
                                </div>
                                <script type="text/javascript">jWPDev('#help_screeen_pro').animate({opacity:1},5000).fadeOut(2000);</script>
                          <?php

                      }
                ?>
                <div id="ajax_respond"></div>
                <div id="table_for_approve">
                    <div class="selected_mark"></div><h2><?php _e('Approve', 'wpdev-booking'); ?></h2>
                                <?php  $res1 = $this->booking_table(0);  ?>
                    <div style="float:left;">
                        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Approve', 'wpdev-booking'); ?>" onclick="javascript:bookingApprove(0,0);" />
                        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Cancel', 'wpdev-booking'); ?>"  onclick="javascript:bookingApprove(1,0);"/>
                    </div>
                    <div style="float:left;border:none;margin-top:18px;"> <input type="text" style="width:350px;float:left;" name="denyreason" id="denyreason" value="<?php _e('Reason of cancellation here', 'wpdev-booking'); ?>"> </div>
                    <div id="admin_bk_messages0"> </div>
                    <div class="clear" style="height:1px;"></div>
                </div>
            
            <?php if (! $res1) { echo '<div id="no-reservations"  class="warning_message textleft">'; printf(__('%sThere are no reservations.%s Please, press this %s button, when you edit %sposts%s or %spage%s. %sAfter entering booking you can wait for making  reservation by somebody or you can make reservation %shere%s.', 'wpdev-booking'), '<b>', '</b><br>', '<img src="'.$this->gui_booking->icon_url.'" width="16" height="16" align="top">', '<a href="post-new.php">', '</a>', '<a href="page-new.php">', '</a>', '<br>', '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-reservation">', '</a>' ); echo '</div><div style="clear:both;height:10px;"></div>';  } ?>

            <?php if (! $res1) { ?><script type="text/javascript">document.getElementById('table_for_approve').style.display="none";jWPDev('#no-reservations').animate({opacity:1},20000).fadeOut(2000);</script><?php } ?>

            <?php
                if ( isset($_GET['booking_type']) ) {
                    $bk_type = $_GET['booking_type'];
                } else { $bk_type = '1';}
            ?>

            <div id="calendar_booking<?php echo $bk_type; ?>"></div><br><textarea rows="3" cols="50" id="date_booking<?php echo $bk_type; ?>" name="date_booking<?php echo $bk_type; ?>" style="display:none"></textarea>
            <div class="clear" style="height:30px;clear:both;"></div>
            
            <div id="table_approved">
                <div class="reserved_mark"></div><h2><?php _e('Reserved', 'wpdev-booking'); ?></h2>
                            <?php  $res2 = $this->booking_table(1);  ?>
                <div style="float:left;">
                    <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Cancel', 'wpdev-booking'); ?>"  onclick="javascript:bookingApprove(1,1);"/>
                </div>
                <div style="float:left;border:none;margin-top:18px;"> <input type="text" style="width:350px;float:left;" name="cancelreason" id="cancelreason" value="<?php _e('Reason of cancellation here', 'wpdev-booking'); ?>"> </div>
                <div id="admin_bk_messages1"> </div>
                <div class="clear" style="height:20px;"></div>
            </div>

            <?php if (! $res2) { ?><script type="text/javascript">document.getElementById('table_approved').style.display="none";</script><?php } ?>

            <div  class="copyright_info" style="">
                <div style="width:580px;height:10px;margin:auto;">
                    <img alt="" src="<?php echo WPDEV_BK_PLUGIN_URL ; ?>/img/contact-32x32.png"  align="center" style="float:left;">
                    <div style="margin: 2px 0px 0px 20px; float: left; text-align: center;">
                                    <?php _e('More Information about this Plugin can be found at the', 'wpdev-booking');?> <a href="http://booking.wpdevelop.com/faq/" target="_blank" style="text-decoration:underline;"><?php _e('Booking calendar', 'wpdev-booking');?></a>.<br>
                        <a href="http://www.wpdevelop.com" target="_blank" style="text-decoration:underline;"  valign="middle">www.wpdevelop.com</a> <?php _e(' - custom wp-plugins and wp-themes development, WordPress solutions', 'wpdev-booking');?><br>
                    </div>
                </div>
            </div>


        <?php
        }

        //Content of the Add reservation page
        function content_of_reservation_page() {
            echo '<div class="clear" style="margin:20px;"></div>';
            if( $this->wpdev_bk_pro !== false )  $this->wpdev_bk_pro->booking_types_pages('noedit');
            echo '<div class="clear" style="margin:20px;"></div>';

            echo '<div style="width:450px">';

            if (isset($_GET['booking_type'])) $bk_type = $_GET['booking_type'];
            else                              $bk_type = 1;
            do_action('wpdev_bk_add_form',$bk_type, get_option( 'booking_client_cal_count'));
            echo '</div>';
        }

        //content of S E T T I N G S  page
        function content_of_settings_page () {
           
           $is_show_settings = true;
           if( $this->wpdev_bk_pro !== false )  $is_show_settings = $this->wpdev_bk_pro->check_settings();
           else                                 $is_show_settings = $this->check_settings();
           if ($is_show_settings) {

                    if ( isset( $_POST['start_day_weeek'] ) ) {
                        $admin_cal_count  = $_POST['admin_cal_count'];
                        $client_cal_count = $_POST['client_cal_count'];
                        $start_day_weeek  = $_POST['start_day_weeek'];
                        $new_booking_title= $_POST['new_booking_title'];
                        $new_booking_title_time= $_POST['new_booking_title_time'];
                        $booking_date_format = $_POST['booking_date_format'];
                        $is_dif_colors_approval_pending = $_POST['is_dif_colors_approval_pending'];
                        $multiple_day_selections =  $_POST[ 'multiple_day_selections' ];
                        $is_delete_if_deactive =  $_POST['is_delete_if_deactive']; // check
                        $wpdev_copyright  = $_POST['wpdev_copyright'];             // check

                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        update_option( 'booking_admin_cal_count' , $admin_cal_count );
                        update_option( 'booking_client_cal_count' , $client_cal_count );
                        update_option( 'booking_start_day_weeek' , $start_day_weeek );
                        update_option( 'booking_title_after_reservation' , $new_booking_title );
                        update_option( 'booking_title_after_reservation_time' , $new_booking_title_time );
                        update_option( 'booking_date_format' , $booking_date_format );
                        if (isset( $is_dif_colors_approval_pending ))   $is_dif_colors_approval_pending = 'On';
                        else                                            $is_dif_colors_approval_pending = 'Off';
                        update_option( 'booking_dif_colors_approval_pending' , $is_dif_colors_approval_pending );

                        if (isset( $multiple_day_selections ))   $multiple_day_selections = 'On';
                        else                                     $multiple_day_selections = 'Off';
                        update_option( 'booking_multiple_day_selections' , $multiple_day_selections );

                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        if (isset( $is_delete_if_deactive ))            $is_delete_if_deactive = 'On';
                        else                                            $is_delete_if_deactive = 'Off';
                        update_option('booking_is_delete_if_deactive' , $is_delete_if_deactive );

                        if (isset( $wpdev_copyright ))                  $wpdev_copyright = 'On';
                        else                                            $wpdev_copyright = 'Off';
                        update_option( 'booking_wpdev_copyright' , $wpdev_copyright );
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    } else {
                        $admin_cal_count  = get_option( 'booking_admin_cal_count' );
                        $new_booking_title= get_option( 'booking_title_after_reservation' );
                        $new_booking_title_time= get_option( 'booking_title_after_reservation_time' );
                        $booking_date_format = get_option( 'booking_date_format');
                        $client_cal_count = get_option( 'booking_client_cal_count' );
                        $start_day_weeek  = get_option( 'booking_start_day_weeek' );
                        $is_dif_colors_approval_pending = get_option( 'booking_dif_colors_approval_pending' );
                        $multiple_day_selections =  get_option( 'booking_multiple_day_selections' );
                        $is_delete_if_deactive =  get_option( 'booking_is_delete_if_deactive' ); // check
                        $wpdev_copyright  = get_option( 'booking_wpdev_copyright' );             // check
                    }


                    ?>
                    <div class="clear" style="height:20px;"></div>
                    <div id="ajax_working"></div>
                    <div id="poststuff" class="metabox-holder">

                        <div  style="width:64%; float:left;margin-right:1%;">

                            <div class='meta-box'>
                                <div  class="postbox" > <h3 class='hndle'><span><?php _e('Settings', 'wpdev-booking'); ?></span></h3>
                                    <div class="inside">
                                            <form  name="post_option" action="" method="post" id="post_option" >
                                                <table class="form-table"><tbody>

                                                        <tr valign="top">
                                                        <th scope="row"><label for="admin_cal_count" ><?php _e('Count of calendars', 'wpdev-booking'); ?>:</label><br><?php printf(__('at %sadmin%s booking page', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                            <td><input id="admin_cal_count" class="regular-text code" type="text" size="45" value="<?php echo $admin_cal_count; ?>" name="admin_cal_count"/>
                                                                <span class="description"><?php printf(__('Type your number of calendars %sat admin booking page%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                        <th scope="row"><label for="client_cal_count" ><?php _e('Count of calendars', 'wpdev-booking'); ?>:</label><br><?php printf(__('at %sclient%s side view', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                            <td><input id="client_cal_count" class="regular-text code" type="text" size="45" value="<?php echo $client_cal_count; ?>" name="client_cal_count"/>
                                                                <span class="description"><?php printf(__('Type your %sdefault count of calendars%s for inserting into post/page', 'wpdev-booking'),'<b>','</b>');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                            <th scope="row"><label for="start_day_weeek" ><?php _e('Start Day of week', 'wpdev-booking'); ?>:</label></th>
                                                            <td>
                                                                <select id="start_day_weeek" name="start_day_weeek">
                                                                    <option <?php if($start_day_weeek == '0') echo "selected"; ?> value="0"><?php _e('Sunday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '1') echo "selected"; ?> value="1"><?php _e('Monday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '2') echo "selected"; ?> value="2"><?php _e('Thuesday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '3') echo "selected"; ?> value="3"><?php _e('Wednesday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '4') echo "selected"; ?> value="4"><?php _e('Thursday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '5') echo "selected"; ?> value="5"><?php _e('Friday', 'wpdev-booking'); ?></option>
                                                                    <option <?php if($start_day_weeek == '6') echo "selected"; ?> value="6"><?php _e('Saturday', 'wpdev-booking'); ?></option>
                                                                </select>
                                                                <span class="description"><?php _e('Select your start day of the week', 'wpdev-booking');?></span>
                                                            </td>
                                                        </tr>


                                                        <tr valign="top">
                                                        <th scope="row"><label for="booking_date_format" ><?php _e('Date Format', 'wpdev-booking'); ?>:</label></th>
                                                            <td><input id="booking_date_format" class="regular-text code" type="text" size="45" value="<?php echo $booking_date_format; ?>" name="booking_date_format"/>
                                                                <span class="description"><?php printf(__('Type your date format for showing in emeils and booking table. %sDocumentation on date formatting.%s', 'wpdev-booking'),'<br/><a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">','</a>');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                        <th scope="row"><label for="new_booking_title" ><?php _e('New reservation title', 'wpdev-booking'); ?>:</label><br><?php printf(__('%sshowing after%s booking', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                        <td><input id="new_booking_title" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title; ?>" name="new_booking_title" style="width:99%;"/>
                                                                <br/><span class="description"><?php printf(__('Type title of new reservation %safter booking has done by user%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                        <th scope="row"><label for="new_booking_title_time" ><?php _e('Showing title time', 'wpdev-booking'); ?>:</label><br><?php printf(__('%snew reservation%s', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                        <td><input id="new_booking_title_time" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title_time; ?>" name="new_booking_title_time" />
                                                                 <span class="description"><?php printf(__('Type in miliseconds count of time for showing new reservation title', 'wpdev-booking'),'<b>','</b>');?></span>
                                                            </td>
                                                        </tr>


                                                        <tr valign="top">
                                                            <th scope="row"><label for="is_dif_colors_approval_pending" ><?php _e('Diferent days color', 'wpdev-booking'); ?>:</label><br><?php _e('Aproved / pending days', 'wpdev-booking'); ?></th>
                                                            <td><input id="is_dif_colors_approval_pending" type="checkbox" <?php if ($is_dif_colors_approval_pending == 'On') echo "checked"; ?>  value="<?php echo $is_dif_colors_approval_pending; ?>" name="is_dif_colors_approval_pending"/>
                                                                <span class="description"><?php _e(' Check, if you want to show in diferent colors aproved days and pending for aproval days at client side.', 'wpdev-booking');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                            <th scope="row"><label for="multiple_day_selections" ><?php _e('Multiple days selection', 'wpdev-booking'); ?>:</label><br><?php _e('at calendar', 'wpdev-booking'); ?></th>
                                                            <td><input id="multiple_day_selections" type="checkbox" <?php if ($multiple_day_selections == 'On') echo "checked"; ?>  value="<?php echo $multiple_day_selections; ?>" name="multiple_day_selections"/>
                                                                <span class="description"><?php _e(' Check, if you want have multiple days selection at calendar.', 'wpdev-booking');?></span>
                                                            </td>
                                                        </tr>



                                                        <tr valign="top">
                                                            <td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td>
                                                        </tr>

                                                        <tr valign="top">
                                                            <th scope="row"><label for="is_delete_if_deactive" ><?php _e('Delete booking data', 'wpdev-booking'); ?>:</label><br><?php _e('when plugin deactivated', 'wpdev-booking'); ?></th>
                                                            <td><input id="is_delete_if_deactive" type="checkbox" <?php if ($is_delete_if_deactive == 'On') echo "checked"; ?>  value="<?php echo $is_delete_if_deactive; ?>" name="is_delete_if_deactive"/>
                                                                <span class="description"><?php _e(' Check, if you want delete booking data during uninstalling plugin.', 'wpdev-booking');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                            <th scope="row"><label for="wpdev_copyright" ><?php _e('Copyright notice', 'wpdev-booking'); ?>:</label></th>
                                                            <td><input id="wpdev_copyright" type="checkbox" <?php if ($wpdev_copyright == 'On') echo "checked"; ?>  value="<?php echo $wpdev_copyright; ?>" name="wpdev_copyright"/>
                                                                <span class="description"><?php printf(__(' Turn On/Off copyright %s notice at footer of site view.', 'wpdev-booking'),'wpdevelop.com');?></span>
                                                            </td>
                                                        </tr>

                                                    </tbody></table>

                                                <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save Changes', 'wpdev-booking'); ?>" name="Submit"/>
                                                <div class="clear" style="height:10px;"></div>
                                            </form>
                                    </div>
                                </div>
                             </div>

                        </div>

                        <div style="width:35%; float:left;">
                            <?php if( $this->wpdev_bk_pro == false ) { ?>

                            <div class='meta-box'>
                                <div  class="postbox gdrgrid" > <h3 class='hndle'><span><?php _e('Professional version', 'wpdev-booking'); ?></span></h3>
                                    <div class="inside">
                                        <p class="sub"><?php _e("Main difference features", 'wpdev-booking'); ?></p>
                                        <div class="table">
                                            <table><tbody>
                                                <tr class="first">
                                                    <td class="first b" style="width: 53px;"><b><?php _e("Features", 'wpdev-booking'); ?></b></td>
                                                    <td class="t"></td>
                                                    <td class="b options comparision" style="color:#11cc11;"><b><?php _e("Free", 'wpdev-booking'); ?></b></td>
                                                    <td class="b options comparision" style="color:#f71;"><b><?php _e("Pro", 'wpdev-booking'); ?></b></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="first b" ><?php _e("Functions", 'wpdev-booking'); ?></td>
                                                    <td class="t i">(<?php _e("all existing functions", 'wpdev-booking'); ?>)</td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                                </tr>
                                                <tr class="">
                                                    <td class="first b" ><?php _e("Multi booking", 'wpdev-booking'); ?></td>
                                                    <td class="t i">(<?php _e("several booking on the same date", 'wpdev-booking'); ?>)</td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                                </tr>
                                                <tr class="">
                                                    <td class="first b"><?php _e("Time", 'wpdev-booking'); ?></td>
                                                    <td class="t i">(<?php _e("enter the booking time", 'wpdev-booking'); ?>)</td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                                </tr>
                                                <tr class="">
                                                    <td class="first b"><?php _e("Form", 'wpdev-booking'); ?></td>
                                                    <td class="t i">(<?php _e("field customization", 'wpdev-booking'); ?>)</td>
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
                                                    <td class="t i">(<strong><?php _e("PayPal support", 'wpdev-booking'); ?></strong>)</td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                                    <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                                </tr>
                                                <tr>
                                                    <td class="first b" ><?php _e("Price", 'wpdev-booking'); ?></td>
                                                    <td class="t"><?php  ?></td>
                                                    <td class="t options comparision"><?php _e("free", 'wpdev-booking'); ?></td>
                                                    <td class="t options comparision"><?php _e("start", 'wpdev-booking'); ?> $119</td>
                                                </tr>
                                                <tr class="last">
                                                    <td class="first b"><span><?php _e("Online Demo", 'wpdev-booking'); ?></span></td>
                                                    <td class="t i">(<?php _e("demo of professional version", 'wpdev-booking'); ?>)</td>
                                                    <td class="t comparision"></td>
                                                    <td class="t comparision"><a href="http://booking.wpdevelop.com/" target="_blank"><?php _e("visit", 'wpdev-booking'); ?></a></td>
                                                </tr>
                                                <tr class="last">
                                                    <td class="first b"><span><?php _e("Purchase", 'wpdev-booking'); ?></span></td>
                                                    <td class="t i">(<?php _e("buy Professional version", 'wpdev-booking'); ?>)</td>
                                                    <td colspan="2" style="text-align:right;" class="t comparision"><strong><a  href="http://wpdevelop.com/booking-calendar-professional/" target="_blank"><?php _e("Buy now", 'wpdev-booking'); ?></a></strong></td>
                                                </tr>

                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                             </div>

                            <?php } ?>


                            <div class='meta-box'>
                                <div  class="postbox gdrgrid" > <h3 class='hndle'><span><?php _e('Information', 'wpdev-booking'); ?></span></h3>
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
                                                <tr class="first">
                                                    <td class="first b"><?php _e('Demo page', 'wpdev-booking'); ?></td>
                                                    <td class="t"><?php _e("plugin online demo", 'wpdev-booking'); ?></td>
                                                    <td class="t options"><a href="http://booking.wpdevelop.com/" target="_blank"><?php _e("visit", 'wpdev-booking'); ?></a></td>
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
                                                    <td class="t options"><a href="mailto:info@wpdevelop.com" target="_blank"><?php _e("email", 'wpdev-booking'); ?></a></td>
                                                </tr>
                                            </tbody></table>
                                        </div>

                                    </div>
                                </div>
                             </div>


                        </div>

                        <?php do_action('wpdev_bk_general_settings_end') ?>
                        <?php if( $this->wpdev_bk_pro === false )   $is_show_settings = $this->show_blank_advanced_settings(); ?>

                    </div>
                    <?php
           }
        }

        //Show blank Advanced settings
        function show_blank_advanced_settings(){
            ?>
                        <div class="clear" style="height:20px;"></div>

                        <div  style="width:99%; ">

                            <div class='meta-box'>
                                <div  class="postbox" > <h3 class='hndle'><span><?php _e('Advanced Settings', 'wpdev-booking'); ?></span></h3>
                                    <div class="inside">
                                        <?php $this->show_help(true); ?>
                                        <div style="clear:both;"></div>
                                        <div style="margin:0px 5px auto;text-align:center;">
                                        <!--img style="margin:0px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/range_selection_settings.png" -->
                                        <img style="margin:0px 0px 20px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/range_selection_wide.png" >
                                        </div>
                                        <div style="clear:both;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
        }

        // Show help info
        function check_settings(){
            ?>

            <div style="height:20px;clear:both;"></div>
            <?php if ( ($_GET['tab'] == 'main') || (! isset($_GET['tab'])) ) { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=main" class="bk_top_menu <?php echo $slct_a; ?>"><?php _e('General settings', 'wpdev-booking'); ?></a> |
            <?php if ($_GET['tab'] == 'form') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=form" class="bk_top_menu <?php echo $slct_a; ?>"><?php _e('Form fields and content customization', 'wpdev-booking'); ?></a> |
            <?php if ($_GET['tab'] == 'email') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=email" class="bk_top_menu <?php echo $slct_a; ?>"><?php _e('Emails customization', 'wpdev-booking'); ?></a>
            <?php if ($_GET['tab'] == 'paypal') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
                 | <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=paypal" class="bk_top_menu <?php echo $slct_a; ?>"><?php _e('Paypal and cost customization', 'wpdev-booking'); ?></a>
                 <div style="height:10px;clear:both;border-bottom:1px solid #cccccc;"></div>
            <?php

            switch ($_GET['tab']) {

                   case 'main':
                    return true;
                    break;

                   case 'form':
                    $this->show_help();
                    ?>
                                        <div style="clear:both;"></div>
                                        <div style="margin:0px 5px auto;text-align:center;">
                                        <img style="margin:0px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/form_custom_wide.png">
                                        </div>
                                        <div style="clear:both;"></div>
                    <?php
                    return false;
                    break;

                   case 'email':
                    $this->show_help();
                    ?>
                                        <div style="clear:both;"></div>
                                        <div style="margin:0px 5px auto;text-align:center;">
                                        <img style="margin:0px 0px 20px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/emeil_custom_wide.png" >
                                        </div>
                                        <div style="clear:both;"></div>
                    <?php
                    return false;
                    break;
                   case 'paypal':
                    $this->show_help(true);
                    ?>
                                        <div style="clear:both;"></div>
                                        <div style="margin:0px 5px auto;text-align:center;">
                                        <img style="margin:0px 0px 20px auto;" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/help/paypal_custom_wide.png" >
                                        </div>
                                        <div style="clear:both;"></div>
                    <?php
                    return false;
                    break;
                 default:
                    return true;
                    break;
                }

            return true;
        }

        //Show help info
        function show_help($isPremium = false){
            echo '<div id="no-reservations"  class="info_message textleft" style="font-size:12px;">';
            ?><div style="text-align:center;margin:10px auto;">
                 <?php if($isPremium) { ?>
                <h2><?php printf(__('This functionality exist at the %sBooking Calendar Premium%s', 'wpdev-booking'),'<span style="color:#FFAA11">','</span>'); ?></h2>
                 <?php } else { ?>
                <h2><?php printf(__('This functionality exist at the %sBooking Calendar Professional%s and %sBooking Calendar Premium%s', 'wpdev-booking'),'<span style="color:#11BB11">','</span>','<span style="color:#FFAA11">','</span>'); ?></h2>
                 <?php } ?>
                 <h2><?php printf(__('Check %sfeatures%s, test %sonline demo%s and %sbuy%s.', 'wpdev-booking'),
                     '<a href="http://booking.wpdevelop.com/features/" target="_blank" style="color:#1155bb;text-decoration:underline;">', '</a>',
                     '<a href="http://booking.wpdevelop.com/demo/" target="_blank" style="color:#1155bb;text-decoration:underline;">', '</a>',
                     '<a href="http://wpdevelop.com/booking-calendar-professional/" target="_blank"  style="color:#1155bb;text-decoration:underline;">', '</a>'
                    ); ?></h2>
            </div>
            <?php
            echo '</div><div style="clear:both;height:10px;"></div>';
        }
        //   C L I E N T   S I D E   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Show only calendar from action call - wpdev_bk_add_calendar
        function add_calendar_action($bk_type =1, $cal_count =1){

            $script_code = "<script type='text/javascript'>";
            $script_code .= " my_num_month = ".$cal_count.";";$my_boook_count = $cal_count;
            $script_code .= " my_book_type = ".$bk_type.";"; $my_boook_type = $bk_type;
            $script_code .= "</script>";

            $start_script_code = "<script type='text/javascript'>";
            $start_script_code .= "  jWPDev(document).ready( function(){";
            $start_script_code .= "  var date_approved_par = new Array();";

            $dates_and_time_to_approve = $this->get_dates('all',$my_boook_type);
            $dates_to_approve = $dates_and_time_to_approve[0];
            $times_to_approve = $dates_and_time_to_approve[1];$i=-1;
            foreach ($dates_to_approve as $date_to_approve) { $i++;

                $td_class =   ($date_to_approve[1]+0)."-".($date_to_approve[2]+0)."-".($date_to_approve[0]);

                $start_script_code .= " if (typeof( date_approved_par[ '". $td_class . "' ] ) == 'undefined'){ ";
                            $start_script_code .= " date_approved_par[ '". $td_class . "' ] = [];} ";

                $start_script_code.=" date_approved_par[ '".$td_class."' ][  date_approved_par['".$td_class."'].length  ] = [".
                                                            ($date_to_approve[1]+0).",".($date_to_approve[2]+0).",".($date_to_approve[0]+0).", ".
                                                            ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                                                             "];";

            }

            $start_script_code .= "     init_datepick_cal('". $my_boook_type ."', date_approved_par, ".
                                                              $my_boook_count ." , ".
                                                              get_option( 'booking_start_day_weeek' ) . "); }); ";
            $start_script_code .= "</script>";

            $start_script_code = apply_filters('wpdev_booking_calendar', $start_script_code , $bk_type);

            echo $script_code .' '
            .  '<div style="clear:both;height:10px;"></div>' 

            . '<div id="calendar_booking'.$my_boook_type.'"></div><textarea rows="3" cols="50" id="date_booking'.$my_boook_type.'" name="date_booking'.$my_boook_type.'" style="display:none;"></textarea>' .

            ' ' . $start_script_code ;

        }
        
        //Show booking form from action call - wpdev_bk_add_form
        function add_booking_form_action($bk_type =1, $cal_count =1, $is_echo = 1){
            $script_code = "<script type='text/javascript'>";
            $script_code .= " my_num_month = ".$cal_count.";";$my_boook_count = $cal_count;
            $script_code .= " my_book_type = ".$bk_type.";"; $my_boook_type = $bk_type;
            $script_code .= "</script>";

            $start_script_code = "<script type='text/javascript'>";
            $start_script_code .= "  jWPDev(document).ready( function(){";


            $start_script_code .= "  date2approve[". $bk_type. "] = [];";
            $dates_and_time_to_approve = $this->get_dates('0', $bk_type);
            $dates_to_approve = $dates_and_time_to_approve[0];
            $times_to_approve = $dates_and_time_to_approve[1];$i=-1;
            foreach ($dates_to_approve as $date_to_approve) { $i++;

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
            $dates_and_time_to_approve = $this->get_dates('1', $my_boook_type);
            $dates_approved =   $dates_and_time_to_approve[0];
            $times_to_approve = $dates_and_time_to_approve[1];$i=-1;
            foreach ($dates_approved as $date_to_approve) { $i++;

                $td_class =   ($date_to_approve[1]+0)."-".($date_to_approve[2]+0)."-".($date_to_approve[0]);

                $start_script_code .= " if (typeof( date_approved_par[ '". $td_class . "' ] ) == 'undefined'){ ";
                            $start_script_code .= " date_approved_par[ '". $td_class . "' ] = [];} ";

                $start_script_code.=" date_approved_par[ '".$td_class."' ][  date_approved_par['".$td_class."'].length  ] = [".
                                                            ($date_to_approve[1]+0).",".($date_to_approve[2]+0).",".($date_to_approve[0]+0).", ".
                                                            ($times_to_approve[$i][0]+0).", ". ($times_to_approve[$i][1]+0).", ". ($times_to_approve[$i][2]+0).
                                                                             "];";
            }
//echo $start_script_code; die;
            $start_script_code .= "     init_datepick_cal('". $my_boook_type ."', date_approved_par, ". 
                                                              $my_boook_count ." , ".
                                                              get_option( 'booking_start_day_weeek' ) . "); }); ";
            $start_script_code .= "</script>";
            $my_result =  $script_code .' ' . $this->get__client_side_booking_content($my_boook_type ) . ' ' . $start_script_code ;

            $my_result = apply_filters('wpdev_booking_form', $my_result , $bk_type);
           if ( $is_echo )            echo $my_result;
           else                       return $my_result;
        }

        // Get form
        function get_booking_form($my_boook_type){
            return  '<div style="text-align:left;">
                    <p>'.__('Name (required)', 'wpdev-booking').':<br />  <span class="wpdev-form-control-wrap name'.$my_boook_type.'"><input type="text" name="name'.$my_boook_type.'" value="" class="wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Second Name (required)', 'wpdev-booking').':<br />  <span class="wpdev-form-control-wrap secondname'.$my_boook_type.'"><input type="text" name="secondname'.$my_boook_type.'" value="" class="wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Email (required)', 'wpdev-booking').':<br /> <span class="wpdev-form-control-wrap email'.$my_boook_type.'"><input type="text" name="email'.$my_boook_type.'" value="" class="wpdev-validates-as-email wpdev-validates-as-required" size="40" /></span> </p>
                    <p>'.__('Phone', 'wpdev-booking').':<br />            <span class="wpdev-form-control-wrap phone'.$my_boook_type.'"><input type="text" name="phone'.$my_boook_type.'" value="" size="40" /></span> </p>
                    <p>'.__('Details', 'wpdev-booking').':<br />          <span class="wpdev-form-control-wrap details'.$my_boook_type.'"><textarea name="details'.$my_boook_type.'" cols="40" rows="10"></textarea></span> </p>
                    <p><input type="button" value="'.__('Send', 'wpdev-booking').'" onclick="mybooking_submit(this.form,'.$my_boook_type.');" /></p>
                    </div>';
        }

        // Get content at client side of  C A L E N D A R
        function get__client_side_booking_content($my_boook_type = 1 ) {
           
            $nl = '<div style="clear:both;height:10px;"></div>';                                                            // New line
            $calendar = '<div id="calendar_booking'.$my_boook_type.'"></div><textarea rows="3" cols="50" id="date_booking'.$my_boook_type.'" name="date_booking'.$my_boook_type.'" style="display:none;"></textarea>';   // Calendar code
            
            $form = '<div id="booking_form_div'.$my_boook_type.'" class="booking_form_div">';

            if(  $this->wpdev_bk_pro !== false  )   $form .= $this->wpdev_bk_pro->get_booking_form($my_boook_type);         // Get booking form
            else                                    $form .= $this->get_booking_form($my_boook_type);

            // Insert calendar into form
            if ( strpos($form, '[calendar]') !== false ) {  $form =str_replace('[calendar]', $calendar ,$form); }
            else                                         {  $form =  $calendar . $nl . $form ;    }


            $form = apply_filters('wpdev_booking_form_content', $form , $my_boook_type);
            // Add booking type field
            $form      .= '<input id="bk_type'.$my_boook_type.'" name="bk_type'.$my_boook_type.'" class="" type="hidden" value="'.$my_boook_type.'" /></div>';
            $submitting = '<div id="submiting'.$my_boook_type.'"></div><div class="form_bk_messages" id="form_bk_messages'.$my_boook_type.'" ></div>';

            $res = $form . $submitting;

            

            return '<form name="booking_form'.$my_boook_type.'" class="booking_form" id="booking_form'.$my_boook_type.'"  method="post" action=""><div id="ajax_respond_insert'.$my_boook_type.'"></div>' .
                                     $res . '</form>';
        }

        // Replace MARK at post with content at client side   -----    [booking nummonths='1' type='1']
        function booking_shortcode($attr) {
            $my_boook_count = get_option( 'booking_client_cal_count' );
            $my_boook_type = 1;
            if ( isset( $attr['nummonths'] ) ){ $my_boook_count = $attr['nummonths']; }
            if ( isset( $attr['type'] ) )     { $my_boook_type = $attr['type']; }

            return $this->add_booking_form_action($my_boook_type,$my_boook_count, 0 );
        }

        // Head of Client side - including JS Ajax function
        function client_side_print_booking_head() {
            // Write calendars script
            $this->print_js_css(0);
        }

        // Write copyright notice if its saved
        function wp_footer(){
            if ( ( get_option( 'booking_wpdev_copyright' )  == 'On' ) && (! defined('WPDEV_COPYRIGHT')) ) {
                        printf(__('%sPowered by wordpress plugins developed by %', 'wpdev-booking'),'<span style="font-size:9px;text-align:center;margin:0 auto;">','<a href="http://www.wpdevelop.com" target="_blank">swww.wpdevelop.com</a></span>','&amp;');
                        define('WPDEV_COPYRIGHT',  1 );
            }
        }

        /**///   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ///////////////////////////////////////////////////////////

        // Activate
        function wpdev_booking_activate() {

           add_option( 'booking_admin_cal_count' ,'2');
           add_option( 'booking_client_cal_count', '1' );
           add_option( 'booking_start_day_weeek' ,'0');
           add_option( 'booking_title_after_reservation' , sprintf(__('Thank you for your online reservation. %s We will contact for confirmation your booking as soon as possible.', 'wpdev-booking'), '<br/>') );
           add_option( 'booking_title_after_reservation_time' , '7000' );
           add_option( 'booking_date_format' , get_option('date_format') );
           add_option( 'booking_is_delete_if_deactive' ,'Off'); // check
           add_option( 'booking_dif_colors_approval_pending' , 'On' );
           add_option( 'booking_multiple_day_selections' , 'On');
           
           add_option( 'booking_email_reservation_adress', htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
           add_option( 'booking_email_reservation_from_adress', htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
           add_option( 'booking_email_reservation_subject',__('New reservation', 'wpdev-booking'));
           add_option( 'booking_email_reservation_content',htmlspecialchars(sprintf(__('You need to approve new reservation %s at dates: %s Person detail information:%s Thank you, Booking service.', 'wpdev-booking'),'[bookingtype]','[dates]<br/><br/>','<br/> [content]<br/><br/>')));

           add_option( 'booking_email_approval_adress',htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
           add_option( 'booking_email_approval_subject',__('Your reservation has been approved', 'wpdev-booking'));
           add_option( 'booking_email_approval_content',htmlspecialchars(sprintf(__('Your reservation %s at dates: %s has been approved.%sThank you, Booking service.', 'wpdev-booking'),'[bookingtype]','[dates]','<br/><br/>[content]<br/><br/>')));

           add_option( 'booking_email_deny_adress',htmlspecialchars('"Booking system" <' .get_option('admin_email').'>'));
           add_option( 'booking_email_deny_subject',__('Your reservation has been declined', 'wpdev-booking'));
           add_option( 'booking_email_deny_content',htmlspecialchars(sprintf(__('Your reservation %s at dates: %s has been  canceled. %sThank you, Booking service.', 'wpdev-booking'),'[bookingtype]','[dates]','<br/><br/>[denyreason]<br/><br/>[content]<br/><br/>')));


           add_option('booking_widget_title', __('Booking form', 'wpdev-booking') );
           add_option('booking_widget_show', 'booking_form' );
           add_option('booking_widget_type', '1' );
           add_option('booking_widget_calendar_count',  '1');
           add_option('booking_widget_last_field','');

           add_option( 'booking_wpdev_copyright','Off' ); 
            


           // Create here tables which is needed for using plugin
            $charset_collate = '';    $wp_queries = array();     global $wpdb;
            if ( $wpdb->has_cap( 'collation' ) ) {
                if ( ! empty($wpdb->charset) )
                    $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                if ( ! empty($wpdb->collate) )
                    $charset_collate .= " COLLATE $wpdb->collate";
            }

            if ( ! $this->is_table_exists('booking') ) { // Cehck if tables not exist yet

                    $wp_queries[] = "CREATE TABLE ".$wpdb->prefix ."booking (
                         booking_id bigint(20) unsigned NOT NULL auto_increment,
                         form text NOT NULL,
                         booking_type bigint(10) NOT NULL default 1,
                         PRIMARY KEY  (booking_id)
                        ) $charset_collate;";
            } elseif  ($this->is_field_in_table_exists('booking','form') == 0){
                $simple_sql = "ALTER TABLE ".$wpdb->prefix ."booking ADD form TEXT NOT NULL AFTER booking_id";
                $wpdb->query($simple_sql);
            }

            if ( ! $this->is_table_exists('bookingdates') ) { // Cehck if tables not exist yet
                    $wp_queries[] = "CREATE TABLE ".$wpdb->prefix ."bookingdates (
                         booking_id bigint(20) unsigned NOT NULL,
                         booking_date datetime NOT NULL default '0000-00-00 00:00:00',
                         approved bigint(20) unsigned NOT NULL default 0
                        ) $charset_collate;";

                    
                    if( $this->wpdev_bk_pro == false ) {
                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."booking ( form ) VALUES (
                         'text^name1^Anna~text^secondname1^Mazur~text^email1^example-free@wpdevelop.com~text^phone1^8(038)458-77-77~textarea^details1^Reserve a room with sea view' );";
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

            if( $this->wpdev_bk_pro !== false )  $this->wpdev_bk_pro->pro_activate();
        }

        // Deactivate
        function wpdev_booking_deactivate() {
    
           $is_delete_if_deactive =  get_option( 'booking_is_delete_if_deactive' ); // check
           
           if ($is_delete_if_deactive == 'On') {
                // Delete here tables and options, which are needed for using plugin
                delete_option( 'booking_admin_cal_count' );
                delete_option( 'booking_client_cal_count' );
                delete_option( 'booking_start_day_weeek' );
                delete_option( 'booking_title_after_reservation');
                delete_option( 'booking_title_after_reservation_time');
                delete_option( 'booking_date_format');
                delete_option( 'booking_is_delete_if_deactive' ); // check
                delete_option( 'booking_wpdev_copyright' );             // check
                delete_option( 'booking_dif_colors_approval_pending'   );
                delete_option( 'booking_multiple_day_selections' );

                delete_option( 'booking_email_reservation_adress');
                delete_option( 'booking_email_reservation_from_adress');
                delete_option( 'booking_email_reservation_subject');
                delete_option( 'booking_email_reservation_content');

                delete_option( 'booking_email_approval_adress');
                delete_option( 'booking_email_approval_subject');
                delete_option( 'booking_email_approval_content');

                delete_option( 'booking_email_deny_adress');
                delete_option( 'booking_email_deny_subject');
                delete_option( 'booking_email_deny_content');

                delete_option('booking_widget_title');
                delete_option('booking_widget_show');
                delete_option('booking_widget_type');
                delete_option('booking_widget_calendar_count');
                delete_option('booking_widget_last_field');

                global $wpdb;
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'booking');
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'bookingdates');

                if( $this->wpdev_bk_pro !== false )  $this->wpdev_bk_pro->pro_deactivate();
           }
        }

    }
}


$wpdev_bk = new wpdev_booking();


//  S u p p o r t    f u n c t i o n s       /////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_booking_form_show(){
    return '<div style="text-align:left">
            <strong>'.__('Name', 'wpdev-booking').'</strong>:<span class="fieldvalue">[name]</span><br/>
            <strong>'.__('Second Name', 'wpdev-booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/>
            <strong>'.__('Email', 'wpdev-booking').'</strong>:<span class="fieldvalue">[email]</span><br/>
            <strong>'.__('Phone', 'wpdev-booking').'</strong>:<span class="fieldvalue">[phone]</span><br/>
            <strong>'.__('Details', 'wpdev-booking').'</strong>:<br /><span class="fieldvalue"> [details]</span>
            </div>';
}


function get_form_content ($formdata, $bktype =-1 ){

           if ($bktype == -1) {
                    if ( isset($_GET['booking_type']) ) {
                        $bktype = $_GET['booking_type'];
                    } else { $bktype = '1';}
           }
           
           if (function_exists ('get_booking_title')) $booking_form_show  = get_option( 'booking_form_show' );
           else $booking_form_show  = get_booking_form_show();

            $formdata_array = explode('~',$formdata);
            $formdata_array_count = count($formdata_array);
            $email_adress='';$name_of_person = '';
            for ( $i=0 ; $i < $formdata_array_count ; $i++) {
                $elemnts = explode('^',$formdata_array[$i]);

                $type = $elemnts[0];
                $element_name = $elemnts[1];
                $value = $elemnts[2];

                $type_name = str_replace($bktype,'',$elemnts[1]);
                $type_name = str_replace('[]','',$type_name);

                if ($type_name == 'email') {
                    $email_adress = $value;
                }

                if ( $type_name == 'name') {
                    $name_of_person = $value;
                }

                if ($type == 'checkbox') {
                    if ($value == 'true') { $value = __('yes', 'wpdev-booking');}
                    else                  { $value = __('no', 'wpdev-booking');}
                }
                $booking_form_show = str_replace( '['. $type_name .']', $value ,$booking_form_show);

            }
          return ( array('content' => $booking_form_show, 'email' => $email_adress, 'name' => $name_of_person ) );
}



// this function is fixing bug with PHP4 - "Fatal error: Nesting level too deep - recursive dependency"
function show_booking_widget_php4($args){
    extract($args);

     $booking_widget_title = get_option('booking_widget_title');
     $booking_widget_show  =  get_option('booking_widget_show');

     $booking_widget_type  =  get_option('booking_widget_type');
     if ($booking_widget_type === false)  $booking_widget_type=1;


     $booking_widget_calendar_count  =  get_option('booking_widget_calendar_count');
     $booking_widget_last_field  =  get_option('booking_widget_last_field');

    echo $before_widget;
    echo $before_title . htmlspecialchars_decode($booking_widget_title) . $after_title;

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



// A J A X     R e s p o n d e r   Real Ajax with jWPDev sender     //////////////////////////////////////////////////////////////////////////////////
function wpdev_bk_ajax_responder() {
    if (!function_exists ('adebug')) { function adebug() { $var = func_get_args(); echo "<div style='text-align:left;background:#ffffff;border: 1px dashed #ff9933;font-size:11px;line-height:15px;font-family:'Lucida Grande',Verdana,Arial,'Bitstream Vera Sans',sans-serif;'><pre>"; print_r ( $var ); echo "</pre></div>"; } }
    global $wpdb;

   // Change date format
   function change_date_format( $mydates ){
//adebug($mydates);
       $mydates = explode(',',$mydates);
       $mydates_result = '';

       $date_format = get_option( 'booking_date_format');
       $time_format = get_option( 'booking_time_format');
       if ( $time_format !== false  ) $time_format = ' ' . $time_format;
       else                           $time_format='';

       if ($date_format == '') $date_format = "d.m.Y";

       foreach ($mydates as $dt) {
           $dt = trim($dt);
           $dta = explode(' ',$dt);
           $tms = $dta[1]; $tms = explode(':' , $tms);
           $dta = $dta[0]; $dta = explode('-',$dta);

           $date_format_now = $date_format . $time_format;
           if ($tms == array('00','00','00'))     $date_format_now = $date_format; 
           
                                                      //   H        M        S        M        D        Y
           //$mydates_result .= date($date_format_now, mktime($tms[0], $tms[1], $tms[2], $dta[1], $dta[2], $dta[0])) . ', ';
           $mydates_result .= date_i18n($date_format_now, mktime($tms[0], $tms[1], $tms[2], $dta[1], $dta[2], $dta[0])) . ', ';

           /*
           if ($is_day_before_month) {
                                                      // H  M  S     M        D        Y
            $mydates_result .= date($date_format, mktime(0, 0, 0, $dta[1], $dta[0], $dta[2])) . ', ';
           } else {
            $mydates_result .= date($date_format, mktime(0, 0, 0, $dta[0], $dta[1], $dta[2])) . ', ';
           }/**/
       }
//adebug($mydates_result);
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
                /*$my_date = explode(' ',$my_date->booking_date);
                $my_date = explode('-',$my_date[0]);/**/
//adebug($my_date->booking_date);
                if ($dates_str != '') $dates_str .= ', ';
                $dates_str .= $my_date->booking_date;//$my_date[1] . '.' .$my_date[2] . '.' . $my_date[0];
            }
//adebug($dates_str);
            return $dates_str;
      }



    $action = $_POST['ajax_action'];
    switch ( $action ) :

        case  'INSERT_INTO_TABLE':

            $dates = $_POST[ "dates" ];
            $bktype = $_POST[  "bktype" ];
            $formdata = $_POST["form"];

            $booking_form_show = get_form_content ($formdata, $bktype);

            $insert = "('$formdata',  $bktype)";
            if ( !empty($insert) )
                if ( false === $wpdb->query("INSERT INTO ".$wpdb->prefix ."booking (form, booking_type) VALUES " . $insert) ) {
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during inserting into BD', 'wpdev-booking'); ?></div>'; </script> <?php
                    die();
                }

            // Make insertion into BOOKINGDATES
            $booking_id = (int) $wpdb->insert_id;       //Get ID  of reservation
            $insert='';

            $sdform = $_POST['form'];
            $start_time = $end_time = '00:00:00';
            $my_dates = explode(", ",$dates);

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
   

            $i=0;
            foreach ($my_dates as $md) { // Set in dates in such format: yyyy.mm.dd
                $md = explode('.',$md);
                $my_dates[$i] = $md[2] . '.' . $md[1] . '.' . $md[0] ;
                $i++;
            }
            sort($my_dates); // Sort dates

            $my_dates4emeil = ''; $i=0;
            foreach ($my_dates as $my_date) { $i++;          // Loop through all dates
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
                    $insert .= "('$booking_id', '$date', '0')";
                }
            }
            $my_dates4emeil = substr($my_dates4emeil,0,-1);
//adebug($my_dates4emeil);
            if ( !empty($insert) )
                if ( false === $wpdb->query("INSERT INTO ".$wpdb->prefix ."bookingdates (booking_id, booking_date, approved) VALUES " . $insert) ){
                    ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during inserting into BD - Dates', 'wpdev-booking'); ?></div>'; </script> <?php
                    die();
                }

            if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $bktype );
            else $bk_title = '';

            // Sending mail ///////////////////////////////////////////////////////
            $mail_sender    =  htmlspecialchars_decode( get_option( 'booking_email_reservation_from_adress') ) ; //'"'. 'Booking sender' . '" <' . $booking_form_show['email'].'>';
            $mail_recipient =  htmlspecialchars_decode( get_option( 'booking_email_reservation_adress') );//'"Booking receipent" <' .get_option('admin_email').'>';
            $mail_subject   =  htmlspecialchars_decode( get_option( 'booking_email_reservation_subject') );
            $mail_body      =  htmlspecialchars_decode( get_option( 'booking_email_reservation_content') );

            $mail_body = str_replace('[bookingtype]', $bk_title, $mail_body);
            $mail_body = str_replace('[dates]', change_date_format($my_dates4emeil), $mail_body);
            $mail_body = str_replace('[content]', $booking_form_show['content'], $mail_body);
            $mail_body = str_replace('[name]', $booking_form_show['name'], $mail_body);

            $mail_headers = "From: $mail_sender\n";
            $mail_headers .= "Content-Type: text/html\n";

            @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);
            /////////////////////////////////////////////////////////////////////////
            
            
            ?>
            <script type="text/javascript">
               document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div class=\"submiting_content\" ><?php echo get_option('booking_title_after_reservation'); ?></div>';
               jWPDev('.submiting_content').fadeOut(<?php echo get_option('booking_title_after_reservation_time'); ?>);
               setReservedSelectedDates('<?php echo $bktype; ?>');
            </script>
            <?php
            do_action('wpdev_new_booking',$booking_id, $bktype, str_replace('|',',',$dates), array($start_time, $end_time )  );
            die();

            break;


        case 'UPDATE_APPROVE' :  

            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $approved_id = explode('|',$approved);
            if ( (count($approved_id)>0) && ($approved_id !==false)) {
                $approved_id_str = join( ',', $approved_id);

                if ( false === $wpdb->query( "UPDATE ".$wpdb->prefix ."bookingdates SET approved = '1' WHERE booking_id IN ($approved_id_str)") ) {
                    ?>
                      <script type="text/javascript">
                        document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML =
                            '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during updating to DB', 'wpdev-booking'); ?></div>';
                      </script>
                    <?php
                    die();
                }

                $sql = "SELECT * FROM ".$wpdb->prefix ."booking as bk WHERE bk.booking_id IN ($approved_id_str)";

                $result = $wpdb->get_results( $sql );
 
                $mail_sender    =  htmlspecialchars_decode( get_option( 'booking_email_approval_adress') ) ; //'"'. 'Booking sender' . '" <' . $booking_form_show['email'].'>';
                $mail_subject   =  htmlspecialchars_decode( get_option( 'booking_email_approval_subject') );
                $mail_body      =  htmlspecialchars_decode( get_option( 'booking_email_approval_content') );

                foreach ($result as $res) {
                // Sending mail ///////////////////////////////////////////////////////
                    if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $res->booking_type );
                    else $bk_title = '';

                    $booking_form_show = get_form_content ($res->form, $res->booking_type);

                    $mail_body_to_send = str_replace('[bookingtype]', $bk_title, $mail_body);
                    $mail_body_to_send = str_replace('[dates]', change_date_format(get_dates_str($res->booking_id)), $mail_body_to_send);
                    $mail_body_to_send = str_replace('[content]', $booking_form_show['content'], $mail_body_to_send);
                    $mail_body_to_send = str_replace('[name]', $booking_form_show['name'], $mail_body_to_send);

                    $mail_recipient =  $booking_form_show['email'];

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    @wp_mail($mail_recipient, $mail_subject, $mail_body_to_send, $mail_headers);
                /////////////////////////////////////////////////////////////////////////
                }
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

        case 'DELETE_APPROVE' :   // adebug($_POST); die();
            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $denyreason = $_POST["denyreason"];

            if ( ( $denyreason == __('Reason of cancellation here', 'wpdev-booking')) || ( $denyreason == 'Reason of cancel here') ) {
                $denyreason = '';
            }

            $approved_id = explode('|',$approved);
            if ( (count($approved_id)>0) && ($approved_id !=false) && ($approved_id !='')) {
                $approved_id_str = join( ',', $approved_id);

                $sql = "SELECT *    FROM ".$wpdb->prefix ."booking as bk
                                    WHERE bk.booking_id IN ($approved_id_str)";

                $result = $wpdb->get_results( $sql );

                $mail_sender    =  htmlspecialchars_decode( get_option( 'booking_email_deny_adress') ) ;
                $mail_subject   =  htmlspecialchars_decode( get_option( 'booking_email_deny_subject') );
                $mail_body      =  htmlspecialchars_decode( get_option( 'booking_email_deny_content') );

                foreach ($result as $res) {
                // Sending mail ///////////////////////////////////////////////////////
                    if (function_exists ('get_booking_title')) $bk_title = get_booking_title( $res->booking_type );
                    else $bk_title = '';

                    $booking_form_show = get_form_content ($res->form, $res->booking_type);

                    $mail_body_to_send = str_replace('[bookingtype]', $bk_title, $mail_body);
                    $mail_body_to_send = str_replace('[dates]', change_date_format(get_dates_str($res->booking_id)), $mail_body_to_send);
                    $mail_body_to_send = str_replace('[content]', $booking_form_show['content'], $mail_body_to_send);
                    $mail_body_to_send = str_replace('[denyreason]', $denyreason, $mail_body_to_send);
                    $mail_body_to_send = str_replace('[name]', $booking_form_show['name'], $mail_body_to_send);

                    $mail_recipient =  $booking_form_show['email'];

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    @wp_mail($mail_recipient, $mail_subject, $mail_body_to_send, $mail_headers);
                /////////////////////////////////////////////////////////////////////////
                }

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."bookingdates WHERE booking_id IN ($approved_id_str)") ) {
                    ?> <script type="text/javascript"> document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during deleting dates at DB', 'wpdev-booking'); ?></div>'; </script> <?php
                    die();
                }

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."booking WHERE booking_id IN ($approved_id_str)") ) {
                    ?> <script type="text/javascript"> document.getElementById('admin_bk_messages<?php echo $is_in_approved; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during deleting reservation at DB', 'wpdev-booking'); ?></div>'; </script> <?php
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

        default:
            if (function_exists ('wpdev_pro_bk_ajax')) wpdev_pro_bk_ajax();
            die();

    endswitch;

}

?>