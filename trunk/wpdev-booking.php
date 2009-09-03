<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://plugins.wpdevelop.com
Description: Calendar of reservation for booking service
Version: 0.6
Author: Dima Sereda
Author URI: http://www.wpdevelop.com
*/

/*  Copyright 2009,  Dima Sereda  (email: info@wpdevelop.com),

    www.wpdevelop.com - custom wp-plugins development & WordPress solutions.

    This program is free software; you can redistribute it and/or modify
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
 Tested WordPress Versions: 2.8.3 - 2.8.4
 *
Change log:

= 0.6 =
 * Fixed PHP4 issue of do not showing calendar at admin page
 * Icon at editor toolbar for inserting calendar
 * Created several sub menus pages - Booking calendar, Add booking from Admin page, Settings
 * New page - Admin reservation page, where admin can reserve some days
 * New Settings page - Save different options like start day of week, count of calendars, deactivation option and other
 * Adding Icons to the admin pages

= 0.5 =
* Inital beta release

TODO: Neet to do all these
 *
 * FEATURES
 *
        * Add at footer of client side row with wpdevelop copyright, check on off from settings
        * Add to Settings page possibility to select for client side calendar have to be before or after form
 * Add to Settings page customisation of emeil
        * Add to the tiniMCE button of insertion calendar
        * Add at initial start of plugin examples into DB
        * During deinstalling check unchek deleting of the tables at the settings page make option to check / uncheck
 * Captcha to the form
 * Make front page with palls according how many $ user can play for COM VER
 * Show at front page: site, description of com ver, stat of booking, clear booking date of
        * Select startday of week
 *
 * Add to Settings page customisation of form fields COMMERCIAL VERSION
 * Skin customisation COMMERCIAL VERSION
 * Payment process COMMERCIAL VERSION
 * Add possibility to select several types of booking COMMERCIAL VERSION
 * Add possibilit to select also time start - end COMMERCIAL VERCION
 *
 * BUGS
 *
 * Atahualpa WP Theme problem show calendar
 */


// If    A J A X so then make it
if ( isset( $_POST['AJAX_WPDEV_PLUGIN'] ) )
    if ( ($_POST['AJAX_WPDEV_PLUGIN'] === basename( __FILE__ ) ) ) {
        define('DOING_AJAX', true);
        require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
        wpdev_ajax_booking_responder();
        die(0);
    }

if (! defined('WPDEV_BK_VERSION'))
    define('WPDEV_BK_VERSION',  '0.6' );
if (! defined('WPDEV_COPYRIGHT'))
    define('WPDEV_COPYRIGHT',  1 );
if (! defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (! defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');

if (! defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
if (! defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

if (! defined('WPDEV_BK_PLUGIN_DIR')) // My plugin local file path
    define('WPDEV_BK_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) );
if (! defined('WPDEV_BK_PLUGIN_URL')) // My plugin HTTP URL to plugin folder
    define('WPDEV_BK_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) );

if (! defined('WPDEV_BK_PLUGIN_FILENAME')) // My plugin FILE NAME
    define('WPDEV_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );
if (! defined('WPDEV_BK_PLUGIN_DIRNAME')) // My plugin FOLDER NAME
    define('WPDEV_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) );



if (!class_exists('wpdev_booking')) {
    class wpdev_booking {

        var $gui_booking;  // GUI class
        var $gui_settings;
        var $gui_reservation;
        var $prefix = 'wpdev_bk';
        var $settings = array(  'custom_buttons' =>array(),
                                'custom_buttons_func_name_from_js_file' => 'set_bk_buttons', //Edit this name at the JS file of custom buttons
                                'custom_editor_button_row'=>1 );

        function wpdev_booking() {

            // Localization
            if ( ! $this->loadLocale() )  $this->loadLocale('en_EN');
            $sa = serialize($this);
            require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-gui.php' ); // Connect my GUI class
            $this->gui_booking = &new wpdev_gui('wpdev-booking',__FILE__,__('Bookings service'), __('Bookings'),'');
            $this->gui_booking->set_icon(array(WPDEV_BK_PLUGIN_URL . '/img/calendar-16x16.png', WPDEV_BK_PLUGIN_URL . '/img/calendar-48x48.png'));
            $this->gui_booking->add_content(array($this, 'content_of_booking_page'));

            $this->gui_reservation = &new wpdev_gui('wpdev-booking-reservation',__FILE__  ,__('Add booking'), __('Add booking'),'submenu','', __FILE__ . $this->gui_booking->gui_html_id_prefix);
            $this->gui_reservation->set_icon(array('', WPDEV_BK_PLUGIN_URL . '/img/add-1-48x48.png'));
            $this->gui_reservation->add_content(array($this, 'content_of_reservation_page'));

            $this->gui_settings = &new wpdev_gui('wpdev-booking-option',__FILE__  ,__('Booking settings'), __('Settings'),'submenu','', __FILE__ . $this->gui_booking->gui_html_id_prefix);
            $this->gui_settings->set_icon(array('', WPDEV_BK_PLUGIN_URL . '/img/application-48x48.png'));
            $this->gui_settings->add_content(array($this, 'content_of_settings_page'));/**/
/**/

            // Page hook for admin JS files ONLY at this plugin page
            add_action('admin_menu', array(&$this,'on_add_admin_plugin_page'));
            add_action('wp_head',array(&$this, 'client_side_print_booking_head'));

            // Add custom buttons
            add_action( 'init', array(&$this,'add_custom_buttons') );
            add_action( 'wp_footer', array(&$this,'wp_footer') );
           

            add_shortcode('booking', array(&$this, 'booking_shortcode'));

            add_filter('plugin_action_links', array(&$this, 'plugin_links'), 10, 2 );
/**/
            register_activation_hook( __FILE__, array(&$this,'wpdev_booking_activate' ));
            register_deactivation_hook( __FILE__, array(&$this,'wpdev_booking_deactivate' ));

            
           
        }

        //   F U N C T I O N S       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // C u s t o m   b u t t o n s  /////////////////////////////////////////////////////////////////////
        function add_custom_buttons() {
           // Don't bother doing this stuff if the current user lacks permissions
           if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;

           // Add only in Rich Editor mode
           if (  ( in_array( basename($_SERVER['PHP_SELF']),  array('post-new.php', 'page-new.php', 'post.php', 'page.php') ) ) && ( get_user_option('rich_editing') == 'true')  ) {

                $this->settings['custom_buttons'] = array(
                            'booking_insert' => array(
                                'hint' => __('Insertbooking calendar'),
                                'title'=> __('Booking calendar'),
                                'img'=> $this->gui_booking->icon_url,
                                'js_func_name_click' => 'booking_click',
                                'bookmark' => 'booking',
                                'class' => 'bookig_buttons',
                                'is_close_bookmark' =>0
                            )
                        );


                add_filter("mce_external_plugins", array(&$this, "mce_external_plugins"));
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

            echo '<script type="text/javascript">';
            echo ' var wpdev_bk_Data=[];';
            echo '      function '. $this->settings['custom_buttons_func_name_from_js_file'].'(ed, url) {';
            foreach ( $this->settings['custom_buttons'] as $type => $props ) {

                $buttonshtml .= '<input type="button" class="ed_button" onclick="'.$props['js_func_name_click'].'(\'' . $type . '\')" title="' . $props['hint'] . '" value="' . $props['title'] . '" />';

                echo "if ( typeof ".$props['js_func_name_click']." == 'undefined' ) return;";

                echo "  ed.addButton('".  $this->prefix . '_' . $type ."', {";
		echo "		title : '". $props['hint'] ."',";
		echo "		image : '". $props['img'] ."',";
                echo "		class : '". $props['class'] ."',";
		echo "		onclick : function() {";
		echo "			". $props['js_func_name_click'] ."('". $type ."');";
		echo "		}";
		echo "	});";
                echo " wpdev_bk_Data['$type'] = {\n";
                echo '		title: "' . $this->js_escape( $props['title'] ) . '",' . "\n";
                echo '		tag: "' . $this->js_escape( $props['bookmark'] ) . '",' . "\n";
                echo '		tag_close: "' . $this->js_escape( $props['is_close_bookmark'] ) . '",' . "\n";
                echo '		cal_count: "' . get_option( 'booking_client_cal_count' )  . '",' . "\n";
                echo  "\n	};\n";
            }
            echo '} </script>';
            /*
            $types = array(
                'booking_insert'     => array(
                __('YouTube0'),
                __('Embed a video from YouTube'),
                __('Please enter the URL at which the video can be viewed.'),
                'http://www.youtube.com/watch?v=stdJd598Dtg',
                ),
            );


            foreach ( $types as $type => $strings ) {
               // HTML for quicktag button
               $buttonshtml .= '<input type="button" class="ed_button" onclick="wpdev_bk_ButtonClick(\'' . $type . '\')" title="' . $strings[1] . '" value="' . $strings[0] . '" />';

                // Create the data array
                $datajs .= "	VVQData['$type'] = {\n";
                $datajs .= '		title: "' . $this->js_escape( ucwords( $strings[1] ) ) . '",' . "\n";
                $datajs .= '		instructions: "' . $this->js_escape( $strings[2] ) . '",' . "\n";
                $datajs .= '		example: "' . js_escape( $strings[3] ) . '"';
                //if ( !empty($this->settings[$type]['width']) && !empty($this->settings[$type]['height']) ) {
                    $datajs .= ",\n		width: 425"  . ",\n";
                    $datajs .= '		height: 324' ;
                //}
                $datajs .= "\n	};\n";
            }*/
            ?>
            <script type="text/javascript">

            // <![CDATA[
                // Set default heights (IE sucks)
                    var wpdev_bk_DialogDefaultHeight = 220;
                    var wpdev_bk_DialogDefaultExtraHeight = 0;
                    var wpdev_bk_DialogDefaultWidth = 580;
                if ( jQuery.browser.msie ) {
                    var wpdev_bk_DialogDefaultHeight = wpdev_bk_DialogDefaultHeight + 8;
                    var wpdev_bk_DialogDefaultExtraHeight = wpdev_bk_DialogDefaultExtraHeight +8;
                }


                // This function is run when a button is clicked. It creates a dialog box for the user to input the data.
                function booking_click( tag ) {
                    wpdev_bk_DialogClose(); // Close any existing copies of the dialog
                    wpdev_bk_DialogMaxHeight = wpdev_bk_DialogDefaultHeight + wpdev_bk_DialogDefaultExtraHeight;
                    

                    // Open the dialog while setting the width, height, title, buttons, etc. of it
                    var buttons = { "<?php echo js_escape(__('Ok')); ?>": wpdev_bk_ButtonOk, 
                                    "<?php echo js_escape(__('Cancel')); ?>": wpdev_bk_DialogClose
                                  };
                    var title = '<img src="<?php echo $this->gui_booking->icon_url; ?>" /> ' + wpdev_bk_Data[tag]["title"];
                    jQuery("#wpdev_bk-dialog").dialog({ autoOpen: false, width: wpdev_bk_DialogDefaultWidth, minWidth: wpdev_bk_DialogDefaultWidth, height: wpdev_bk_DialogDefaultHeight, minHeight: wpdev_bk_DialogDefaultHeight, maxHeight: wpdev_bk_DialogMaxHeight, title: title, buttons: buttons});
 
                    // Reset the dialog box incase it's been used before
                    jQuery("#wpdev_bk-dialog input").val("");
                    jQuery("#calendar_tag_name").val(wpdev_bk_Data[tag]['tag']);
                    jQuery("#calendar_tag_close").val(wpdev_bk_Data[tag]['tag_close']);
                    jQuery("#calendar_count").val(wpdev_bk_Data[tag]['cal_count']);
                    // Style the jQuery-generated buttons by adding CSS classes and add second CSS class to the "Okay" button
                    jQuery(".ui-dialog button").addClass("button").each(function(){
                        if ( "<?php echo js_escape(__('Ok')); ?>" == jQuery(this).html() ) jQuery(this).addClass("button-highlighted");
                    });

                    // Do some hackery on any links in the message -- jQuery(this).click() works weird with the dialogs, so we can't use it
                    jQuery("#wpdev_bk-dialog-content a").each(function(){
                        jQuery(this).attr("onclick", 'window.open( "' + jQuery(this).attr("href") + '", "_blank" );return false;' );
                    });

                    // Show the dialog now that it's done being manipulated
                    jQuery("#wpdev_bk-dialog").dialog("open");

                    // Focus the input field
                    jQuery("#wpdev_bk-dialog-input").focus();
                }

                // Close + reset
                function wpdev_bk_DialogClose() {
                    jQuery(".ui-dialog").height(wpdev_bk_DialogDefaultHeight);
                    jQuery(".ui-dialog").width(wpdev_bk_DialogDefaultWidth);
                    jQuery("#wpdev_bk-dialog").dialog("close");
                }

                // Callback function for the "Okay" button
                function wpdev_bk_ButtonOk() {

                    var cal_count = jQuery("#calendar_count").val();
                    var cal_type = jQuery("#calendar_type").val();
                    var cal_pos = jQuery('#calendar_position').val();
                    var cal_tag = jQuery("#calendar_tag_name").val();
                    var cal_tag_close = jQuery("#calendar_tag_close").val();
                    

                    if ( !cal_tag ) return wpdev_bk_DialogClose();

                    var text = '[' + cal_tag;

                    if (cal_count) text += ' ' + 'nummonths=' + cal_count;
                    if (cal_type) text += ' ' + 'type=' + cal_type;
                    if (cal_pos) text += ' ' + 'position=\''+ cal_pos + '\'';
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
                jQuery(document).ready(function(){
                    // Add the buttons to the HTML view
                    jQuery("#ed_toolbar").append('<?php echo $this->js_escape( $buttonshtml ); ?>');

                    // If the Enter key is pressed inside an input in the dialog, do the "Okay" button event
                    jQuery("#wpdev_bk-dialog :input").keyup(function(event){
                        if ( 13 == event.keyCode ) // 13 == Enter
                            wpdev_bk_ButtonOkay();
                    });

                    // Make help links open in a new window to avoid loosing the post contents
                    jQuery("#wpdev_bk-dialog-slide a").each(function(){
                        jQuery(this).click(function(){
                            window.open( jQuery(this).attr("href"), "_blank" );
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
                                    <div class="field">
                                        <label for="calendar_count"><?php _e('Count of calendars:'); ?></label>
                                        <input id="calendar_count"  name="calendar_count" class="input" type="text" value="<?php echo get_option( 'booking_client_cal_count' ); ?>" >
                                        <span class="description"><?php _e('Enter count of month to show for calendar.'); ?></span>
                                    </div>
                                    <?php /* ?>
                                    <div class="field">
                                        <label for="calendar_type"><?php _e('Type of booking:'); ?></label>
                                        <input id="calendar_type"  name="calendar_type" class="input" type="text" >
                                        <span class="description"><?php _e('Enter type of property fot booking.'); ?></span>
                                    </div>
                                    <?php /**/ ?>
                                    <div class="field">
                                        <label for="calendar_position"><?php _e('Position of calendar:'); ?></label>
                                        <select id="calendar_position" name="calendar_position">
                                            <?php $cal_position = get_option( 'booking_cal_position' ); ?>
                                            <option <?php if($cal_position == 'top') echo "selected"; ?> value="top"><?php _e('Top');?></option>
                                            <option <?php if($cal_position == 'right') echo "selected"; ?> value="right"><?php _e('Right');?></option>
                                            <option <?php if($cal_position == 'bottom') echo "selected"; ?> value="bottom"><?php _e('Bottom');?></option>
                                            <option <?php if($cal_position == 'left') echo "selected"; ?> value="left"><?php _e('Left');?></option>
                                        </select>
                                        <span class="description"><?php _e('Select, position of calendar relative to the form.'); ?></span><br>
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
                    <?php foreach ($this->settings['custom_buttons'] as $props) {
                               echo 'a.' . $props['class'] . ' img.mceIcon{
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
                $settings_link = '<a href="admin.php?page=booking/wpdev-booking.phpwpdev-booking-option">'.__("Settings").'</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

        // Load locale
        function loadLocale($locale = ''){ // Load locale, if not so the  load en_EN default locale from folder "languages" files like "this_file_file_name-ru_RU.po" and "this_file_file_name-ru_RU.mo"
            if ( empty( $locale ) ) $locale = get_locale();
            if ( !empty( $locale ) ) {
                    //Filenames like this  "microstock-photo-ru_RU.po",   "microstock-photo-de_DE.po" at folder "languages"
                    $mofile = WPDEV_BK_PLUGIN_DIR  .'languages/'.str_replace('.php','',WPDEV_BK_PLUGIN_FILENAME).'-'.$locale.'.mo';
                    return load_textdomain(str_replace('.php','',WPDEV_BK_PLUGIN_FILENAME), $mofile);
            } return false;
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


        // Get dates
        function get_dates ($approved = 'all') {

            global $wpdb;
            $dates_array = array();

            if ($approved == 'all')
                $dates_approve = $wpdb->get_results(
                    "SELECT DISTINCT booking_date FROM ".$wpdb->prefix ."bookingdates WHERE  booking_date >= CURDATE() ORDER BY booking_date" );
            else
                $dates_approve = $wpdb->get_results(
                    "SELECT DISTINCT booking_date FROM ".$wpdb->prefix ."bookingdates WHERE  approved = $approved AND booking_date >= CURDATE() ORDER BY booking_date" );

            // loop with all dates which is selected by someone
            foreach ($dates_approve as $my_date) {
                $my_date = explode(' ',$my_date->booking_date);
                $my_date = explode('-',$my_date[0]);
                array_push( $dates_array , $my_date );
            }

            return $dates_array;
        }

        //Write Admin booking table
        function booking_table($approved = 0) {

            global $wpdb;

            $sql = "SELECT *

                        FROM ".$wpdb->prefix ."booking as bk

                        INNER JOIN ".$wpdb->prefix ."bookingdates as dt

                        ON    bk.booking_id = dt.booking_id

                        WHERE approved = $approved AND dt.booking_date >= CURDATE()

                        ORDER BY bk.booking_id DESC, dt.booking_date ASC

                ";



            $result = $wpdb->get_results( $sql );
            $old_id = '';
            $alternative_color = '';

            if ($approved == 0) {$outColor = '#FFBB45'; $outColorClass = '0';}
            if ($approved == 1) {$outColor = '#81B8C4'; $outColorClass = '1';}

            if ( count($result) > 0 ) {
                ?>
<table class='booking_table' cellspacing="0">
    <tr>
        <th>Approved</th>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>E-mail</th>
        <th>Phone</th>
        <th>Detail info</th>
        <th style="display:none;">Type</th>
        <th>Booking Dates</th>
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
                                           <?php  if ($bk->approved) echo 'checked="checked"';  ?>  />
        </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->booking_id  ?> </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->user_name  ?> </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->user_surname  ?> </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->user_email  ?> </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->user_phone  ?> </td>
        <td <?php echo $alternative_color; ?> > <?php  echo $bk->user_description  ?> </td>
        <td <?php echo $alternative_color; ?> style="display:none;"> <?php  echo $bk->booking_type  ?> </td>
        <td <?php echo $alternative_color; ?>
            <a href="#" class="booking_overmause<?php echo $outColorClass; ?>"
           onmouseover="javascript:highlightDay('<?php
                                   echo "cal4date-" . ( date('m',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                       ( date('d',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                       ( date('Y',  mysql2date('G',$bk->booking_date)) + 0 );
                                   ?>','#ff0000');"
           onmouseout="javascript:highlightDay('<?php
                                   echo "cal4date-" . ( date('m',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                       ( date('d',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                       ( date('Y',  mysql2date('G',$bk->booking_date)) + 0 );
                                   ?>','<?php echo $outColor; ?>');"
           >
                                    <?php  echo date('d.m.Y',  mysql2date('G',$bk->booking_date))  ?></a><?php
                                } else {                            // add only dates
                                    echo ', '; ?>
            <a href="#" class="booking_overmause<?php echo $outColorClass; ?>"
               onmouseover="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('G',$bk->booking_date)) + 0 );
                                       ?>','#ff0000');"
               onmouseout="javascript:highlightDay('<?php
                                       echo "cal4date-" . ( date('m',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('d',  mysql2date('G',$bk->booking_date)) + 0 ) . '-' .
                                           ( date('Y',  mysql2date('G',$bk->booking_date)) + 0 );
                                       ?>','<?php echo $outColor; ?>');"
               ><?php echo date('d.m.Y',  mysql2date('G',$bk->booking_date));?></a><?php
                                   }
                               }
                            ?> </td></tr></table> <?php
                    return true;
                } else {
                    return false;
                }

            }




        //   A D M I N     S I D E   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Print scripts only at plugin page
        function on_add_admin_plugin_page() {
            add_action("admin_print_scripts-" . $this->gui_booking->pagehook , array( &$this, 'on_add_admin_js_files'));
            // Change Title of the Main menu inside of submenu
            global $submenu, $menu;
            $submenu[plugin_basename( __FILE__ ) . $this->gui_booking->gui_html_id_prefix][0][0] = __('Booking calendar');

            add_action("admin_print_scripts-" . $this->gui_settings->pagehook , array( &$this, 'on_add_admin_js_files'));
            add_action("admin_print_scripts-" . $this->gui_reservation->pagehook , array( &$this, 'client_side_print_booking_head'));
        }

        // add hook for printing scripts only at this plugin page
        function on_add_admin_js_files() {
        // List of WordPress scripts for Ajax working
            wp_print_scripts( array( 'sack' ));

            // Write inline scripts and CSS at HEAD
            add_action('admin_head', array(&$this, 'head_print_js_css_admin' ), 1);
        }



        // HEAD for ADMIN page
        function head_print_js_css_admin() {
            $this->head_print_js_css(1);
        }

        // Print NOW   admin     J a v a S cr i p t   &    C S S
        function head_print_js_css($is_admin = 1) {
            if (! $is_admin) wp_print_scripts('jquery');
            ?>
            <script src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/calendar/mootools.v1.11.js" type="text/javascript"></script>
            <script src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/calendar/nogray_date_calendar_vs1_min.js" type="text/javascript"></script>
            <script language="javascript">
            // Initial Run
            function initialRun(){
                today = new Date();
                /*
                        var td_events = [];
                        var d_16 = (today.getMonth()+1)+'-16-'+today.getFullYear();
                        td_events[d_16] = {'click':function(td, date_str){alert(new Date().fromString(date_str));}};
                 */
                var dateon = [];
                    <?php
                    // Select by different color dates which are for approve atadmin panel
                    if ( $is_admin ) {
                        $dates_to_approve = $this->get_dates('0');
                        foreach ($dates_to_approve as $date_to_approve) {
                            ?>
                                            var d_to_appr = '<?php echo ($date_to_approve[1]+0); ?>-<?php echo ($date_to_approve[2]+0); ?>-<?php echo $date_to_approve[0]; ?>';
                                            //alert(d_to_appr);
                                            dateon[d_to_appr] = function(td, date_str){
                                                td.setStyle('background-color', '#FFBB45');
                                            };
                        <?
                        }
                    }
                    ?>

                                // Its from booking TAG
                                if (typeof (my_num_month)=='undefined' ) {
                    <?php
                    if ( $is_admin )
                        echo "my_num_month=". get_option( 'booking_admin_cal_count' ) .";";
                    else
                        echo "my_num_month=". get_option( 'booking_client_cal_count' ) .";";
                    ?>
                                    }
                                    if (typeof (my_book_type)=='undefined' ) my_book_type=1;

                                    // may be later its will be needed
                                    selected_dates=[<?php/*
                                if ( $is_admin ){
                                     $dates_to_approve = $this->get_dates('0');
                                      foreach ($dates_to_approve as $date_to_approve) {
                                         echo "new Date($date_to_approve[0], $date_to_approve[1]-1, $date_to_approve[2]),";  ////echo "new Date($year, $month, $day),";
                                    }
                                }       /**/?>];

                                            // all reserved dates
                                            unavailable_dates=[<?php

                    if ( $is_admin )
                        $dates_to_approve = $this->get_dates('1');
                    else
                        $dates_to_approve = $this->get_dates();
                    foreach ($dates_to_approve as $date_to_approve) {
                        echo "new Date($date_to_approve[0], $date_to_approve[1]-1, $date_to_approve[2]),";  ////echo "new Date($year, $month, $day),";
                    }
                    ?>];
                                    var start_day = <?php echo get_option( 'booking_start_day_weeek' ); ?>;

                                                        calender_booking = new Calendar("calendar_booking", null, {    visible:true,
                                                            inputField:'date_booking',
                                                            allowSelection:true,
                                                            numMonths:my_num_month,
                                                            startDay:start_day,
                                                            startDate:today,
                                                            endDate:new Date(today.getFullYear()+1, 11, 31),
                                                            idPrefix:'cal4',
                                                            maxSelection:50,
                                                            multiSelection:true,
                                                            datesOff:unavailable_dates,
                                                            weekend:[],
                                                            dateFormat:'d.m.Y|',
                                                            //tdEvents:td_events,
                                                            dateOnAvailable:dateon,
                                                            selectedDates:[],
                                                            onSelect: function(){
                                                                //alert(this.options.selectedDate);
                                                            }
                                                        }
                                                    );

                                                        // Select dates in calendar, but now its empty
                                                        var selected_dates_count = selected_dates.length; var i=0;
                                                        for (i=0; i < selected_dates_count;i++)
                                                            calender_booking.selectDate( selected_dates[i]);/**/

                                                        // Set if admin panel - no selection
                    <?php if ( $is_admin ) { ?>
                                            calender_booking.options.allowSelection=false;
                    <?php } ?>

                                            // Update calendar
                                            calender_booking.updateCalendar(today);
                                        }


                                        window.addEvent("domready", initialRun);

                                        //Highlight dates when mouse over
                                        function highlightDay(td_id, bk_color){
                                            var elmnt = document.getElementById(td_id);
                                            elmnt.style.background = bk_color;
                                        }

                                        // Update calendar with such parameters -- may be later I will use it
                                        function updateCalendar( select_d, unavailable_d, start_d ){

                                            // gathering all selected dates
                                            calender_booking.selectedDates=[];
                                            var selected_dates_count = select_d.length; var i=0;
                                            for (i=0; i < selected_dates_count;i++)
                                                calender_booking.selectDate( select_d[i]);

                                            //gathering all unavailable dates
                                            calender_booking.options.datesOff=[];
                                            var unavailable_dates_count = unavailable_d.length; var i=0;
                                            for (i=0; i < unavailable_dates_count;i++)
                                                calender_booking.options.datesOff.push(unavailable_d.getTime());

                                            if ( start_d == 'undefined' ) start_d = today;

                                            //update calendar
                                            calender_booking.updateCalendar(start_d);
                                        }


                                        // Run this function at Admin side when click at Approve button
                                        function bookingApprove(is_delete, is_in_approved){

                                            var checkedd = jQuery(".booking_appr"+is_in_approved+":checked");
                                            id_for_approve = "";

                                            // get all IDs
                                            checkedd.each(function(){
                                                var id_c = jQuery(this).attr('id');
                                                id_c = id_c.substr(13,id_c.length-13)
                                                id_for_approve += id_c + "|";
                                            });

                                            //delete last "|"
                                            id_for_approve = id_for_approve.substr(0,id_for_approve.length-1);

                                            if (id_for_approve!='') {
                                                // Ajax sending results
                                                var mysack = new sack( "<?php  echo WPDEV_BK_PLUGIN_URL; ?>/<?php echo WPDEV_BK_PLUGIN_FILENAME; ?>" );
                                                mysack.execute = 1;
                                                mysack.method = 'POST';
                                                mysack.setVar( "AJAX_WPDEV_PLUGIN", '<?php echo basename( __FILE__ ); ?>' );

                                                if (is_delete)
                                                    mysack.setVar( "AJAX_WPDEV_TYPE", 'DELETE_APPROVE' );
                                                else
                                                    mysack.setVar( "AJAX_WPDEV_TYPE", 'UPDATE_APPROVE' );

                                                mysack.setVar( "approved", id_for_approve );
                                                mysack.setVar( "is_in_approved", is_in_approved );

                                                mysack.onError = function() { alert('Ajax error in voting' )};
                                                mysack.runAJAX();
                                            }
                                            return true;

                                        }
                                        jQuery(document).ready( function(){/*
                                            jQuery('.warning_message').animate({ opacity: 1.0 }, 10000).fadeOut( 1000 );
                                            jQuery('.error_message').animate({ opacity: 1.0 }, 10000).fadeOut( 1000 );
                                            jQuery('.info_message').animate({ opacity: 1.0 }, 10000).fadeOut( 1000 );
                                            jQuery('.accept_message').animate({ opacity: 1.0 }, 4000).fadeOut( 1000 );/**/
                                        });

            </script>
            <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/js/calendar/nogray_calendar_vs1.css" rel="stylesheet" type="text/css" />
            <style type="text/css">
                #calendar_booking {font-family:Arial, Helvetica, sans-serif;
                                   font-size:9pt;}
                /* table list */
                .table_list {border-collapse:collapse;
                             border:solid #cccccc 1px;
                             width:100%;}
                .table_list td {padding:5px;
                                border:solid #efefef 1px;}
                .table_list th {background:#75b2d1;
                                padding:5px;
                                color:#ffffff;}
                .table_list tr.odd {background:#e1eff5;}
                /* calendar styles */
                #calendar_booking {
                    border:1px solid #eeeeee;
                    padding-bottom:5px;
                    padding-top:5px;}
                #calendar_booking .ng-cal{
                    margin:5px 3px;
                    float:left;
                }
                #calendar_booking {
                    /*width:1005px;*/
                    margin:0px auto;
                    padding:0px;
                }
                #calendar_booking .ng-cal-header-table {width:98%;margin:5px 1%;}
                #calendar_booking .ng-dateOff {background:#81b8c4;
                                               color:#1e6372;}
                #calendar_booking .ng-cal * {font-size:10pt;}
                #calendar_booking .ng-cal td {
                    padding:3px;
                    width:25px;
                    height:30px;
                    border:solid #9eefee 1px;
                    padding:10px;
                    text-align:center;
                    font-size:13px;font-weight:normal;
                }
                .ng-outOfRange {
                    text-decoration:none;
                    color:#efefef;
                }

                .booking_table {
                    width:99%;
                    border:1px solid #aaa;
                    -moz-border-radius:5px;
                    -moz-box-sizing:content-box;
                }
                .booking_table td{
                    padding:5px 20px;
                    border:none;

                }
                .booking_table th{
                    padding:5px 20px;
                    border:none;
                    font-size:12px;
                    background:#888;
                    color:#fff;
                }
                .booking_table td.alternative_color{
                    background:#ececec;
                }

                #admin_bk_messages0, #admin_bk_messages1 {
                    float:left;
                    margin:15px 5px;
                }

                .submiting_content{
                    background:#EEFDED none repeat scroll 0 0;
                    border:2px solid #ACCFC9;
                    font-size:14px;
                    font-weight:bold;
                    padding:5px 20px;
                    color:black;
                }
                .reserved_mark, .selected_mark {
                    float:left;
                    height:25px;
                    width:30px;
                    border:1px solid #9EEFEE;
                    background:#81B8C4;
                    margin:20px 10px 0px 0px;

                }
                .selected_mark {
                    background:#FFBB45;
                }
                a.booking_overmause1 ,a.booking_overmause1:visited , a.booking_overmause0 ,a.booking_overmause0:visited {
                    background:#FFBB45 none repeat scroll 0 0;
                    color:#FFFFFF;
                    font-weight:bold;
                    padding:2px 10px;
                    text-decoration:underline;
                    line-height:22px;
                }
                a.booking_overmause1 ,a.booking_overmause1:visited {
                    background:#81B8C4 none repeat scroll 0 0;
                }
                a.booking_overmause1:hover, a.booking_overmause0:hover{
                    background:#FF0000;
                }

                .copyright_info {
                    font-size:10px;
                    line-height:14px;
                    padding:5px;
                    text-align:center;
                    width:99%;
                }
                .error_message, info_message, .accept_message, .warning_message{
                    font-size:14Add to Settings page px;
                    padding:11px;
                    padding-left:55px;
                    text-align:center;
                    margin:5px 10px 30px 10px;
                    line-height:22px;
                    -moz-border-radius:5px;
                }
                .error_message a, info_message a, .accept_message a, .warning_message a{
                    text-decoration:underline;
                }
                .error_message{
                    border:1px solid red;
                    background:#ffeeee url('<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/remove-32x32.png') no-repeat 10px 50%;
                }
                .info_message {
                    border:1px solid #eaefff;
                    background:#fdfffd url('<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/info-32x32.png') no-repeat 10px 50%;
                }
                .accept_message {
                    border:1px solid #b0ef55;
                    background:#f7fff7 url('<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/accept-32x32.png') no-repeat 10px 50%;
                }
                .warning_message {
                    border:1px solid #fedab9;
                    background:#fffae5 url('<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/warning-32x32.png') no-repeat 10px 50%;
                }
                .textleft{ text-align:left; }
                .textcenter{ text-align:center; }
                .textright {text-align:right; }
                code{
                    background:#f5f5f5;
                    color:#0066ab;
                    font-size:12px;
                    padding:5px;
                    font-weight:bold;
                }

                /* Settings CSS */
                .form-table th{
                    width:160px;
                    line-height:15px;
                     font-size:11px;
                     font-style:italic;
                }
                .form-table th label{
                    font-size:12px;
                    font-weight:bold;
                    font-style:normal;
                }
                .form-table input.regular-text, .form-table select {
                    width:90px;
                }
                .form-table span.description{
                    font-size:12px;
                }

                /* Front Page settings GRID */
                .gderror {
-moz-border-radius-bottomleft:3px;
-moz-border-radius-bottomright:3px;
-moz-border-radius-topleft:3px;
-moz-border-radius-topright:3px;
background-color:#FFEBE8;
border:1px solid #CC0000;
padding:12px;
}
                .gdpttitle span {
                color:red;
                font-size:12px;
                font-weight:bold;
                margin-left:5px;
                vertical-align:14px;
                }
                .gdrgrid .disabled {
                color:gray;
                }
                .gdrgrid .table {
                -moz-background-clip:border;
                -moz-background-inline-policy:continuous;
                -moz-background-origin:padding;
                background:#F9F9F9 none repeat scroll 0 0;
                border-bottom:1px solid #ECECEC;
                border-top:1px solid #ECECEC;
                margin:0 -6px 10px;
                padding:0 10px;
                table-layout:fixed;
                }
                .gdrgrid div.inside {
                margin:10px;
                }
                #poststuff .gdrgrid p.sub {
                color:#777777;
                font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
                font-size:12px;
                font-style:italic;
                margin:-12px;
                padding:7px 15px 17px;
                }
                #poststuff .gdrgrid p.sub span.spanlink {
                color:#777777;
                font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
                font-size:12px;
                font-style:italic;
                margin:-12px;
                padding:7px 15px 17px;
                }
                .gdrgrid table {
                width:100%;
                }
                .gdrgrid table tr.first th {
                color:#990000;
                font-weight:bold;
                }
                .gdrgrid table tr.first th, .gdrgrid table tr.first td {
                border-top:medium none;
                }
                .gdrgrid td {
                border-top:1px solid #ECECEC;
                font-size:18px;
                padding:2px 0;
                white-space:nowrap;
                }
                .gdrgrid td.b, .gdrgrid th.first {
                font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
                font-size:14px;
                padding-right:6px;
                text-align:right;
                white-space:nowrap;
                }
                .gdrgrid td.i {
                font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
                font-size:14px;
                padding-right:6px;
                white-space:nowrap;
                font-style:italic;
                }
                .gdrgrid td.first, .gdrgrid td.last {
                width:1px;
                }
                .gdrgrid td.options {
                padding-right:0 !important;
                text-align:right;
                white-space:normal;
                }
                .gdrgrid td.t {
                padding-bottom:3px;
                white-space:normal;
                }
                .gdrgrid td.t, .gdrgrid th {
                color:#777777;
                font-size:12px;
                padding-right:12px;
                padding-top:6px;
                }
                .gdrgrid th {
                background-color:#ECECEC;
                padding:3px 5px;
                text-align:left;
                }
                .gdrgrid td.comparision, .gdrgrid th.comparision{
                    text-align:center;
                    font-size:12px;
                }
            </style>
            <?php  if (! $is_admin) {  ?>
            <style type="text/css">
                #calendar_booking {
                    width:330px;
                }
                .submiting_content {
                    border:1px solid #55CC55;
                    font-size:15px;
                    font-weight:bold;
                    height:20px;
                    margin:15px auto;
                    padding:5px 10px;
                    text-align:center;
                    width:100%;
                }

                textarea, input, select {
                    border-color:#DFDFDF;
                }
                textarea, input, select {
                    -moz-border-radius-bottomleft:4px;
                    -moz-border-radius-bottomright:4px;
                    -moz-border-radius-topleft:4px;
                    -moz-border-radius-topright:4px;
                    border-style:solid;
                    border-width:1px;
                }
                textarea, input, select {
                    margin:1px;
                    padding:3px;
                }
                textarea {
                    line-height:1.4em;
                }
                textarea, input, select {
                    font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
                    font-size:13px;
                }
                #booking_form {
                    text-align:left;
                }
                .button, .submit, .button-secondary {
                    -moz-background-clip:border;
                    -moz-background-inline-policy:continuous;
                    -moz-background-origin:padding;
                    background:#F2F2F2 url(../images/white-grad.png) repeat-x scroll left top;
                }
                .submit, .button, .button-primary, .button-secondary, .button-highlighted, #postcustomstuff .submit input {
                    -moz-border-radius-bottomleft:11px;
                    -moz-border-radius-bottomright:11px;
                    -moz-border-radius-topleft:11px;
                    -moz-border-radius-topright:11px;
                    -moz-box-sizing:content-box;
                    border-style:solid;
                    border-width:1px;
                    cursor:pointer;
                    font-size:11px !important;
                    line-height:16px;
                    padding:2px 8px;
                    text-decoration:none;
                    font-weight:bold;
                    margin:10px 0px;
                    float:right;
                }

                #booking_form .field {clear:both; text-align:right; line-height:25px;margin:5px 0px;}
                #booking_form label {float:left; padding-right:10px;width:80px;text-align:left;}
                #booking_form .main_div {float:left}
                #form_bk_messages {
                    display:none;
                    float:left;
                    font-size:14px;
                    font-weight:bold;
                    border:1px solid #99ddaa;
                    padding:3px 10px;
                    margin:2px 5px;
                    background:#fef9ed;
                    color:#555555;
                    margin:15px auto;
                    padding:5px 10px;
                    text-align:center;
                    width:100%;
                }
                .redBorders {
                    background: red;
                }
            </style>
            <?php  }
        }

        // CONTENT OF THE ADMIN PAGE
        function content_of_booking_page () {
            ?>
                <div class="clear" style="height:10px;"></div>
                <div id="table_for_approve">
                    <div class="selected_mark"></div><h2>Approve</h2>
                                <?php  $res1 = $this->booking_table(0);  ?>
                    <div style="float:left;">
                        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Approve'); ?>" onclick="javascript:bookingApprove(0,0);" />
                        <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Delete'); ?>"  onclick="javascript:bookingApprove(1,0);"/>
                    </div>
                    <div id="admin_bk_messages0"> </div>
                    <div class="clear" style="height:1px;"></div>
                </div>
            <?php
            if ((! $res1) ) {
                echo '<div   class="warning_message textleft">';
                printf(__('%sThere are no booking reservations.%s
                             Please, press this %s button, when you edit %spost%s or %spage%s.
                           %sAfter inserting booking you can wait for making by someone reservation or you can make reservation %shere%s.'),
                       '<b>',
                       '</b><br>',
                       '<img src="'.$this->gui_booking->icon_url.'" width="16" height="16" align="top">',
                       '<a href="post-new.php">',
                       '</a>',
                       '<a href="page-new.php">',
                       '</a>',
                       '<br>',
                       '<a href="admin.php?page=booking/wpdev-booking.phpwpdev-booking-reservation">',
                       '</a>'
                       );
                echo '</div>';
            }
            ?>

            <?php if (! $res1) { ?><script type="text/javascript">document.getElementById('table_for_approve').style.display="none";</script><?php } ?>

            <div id="calendar_booking"></div><br><textarea rows="3" cols="50" id="date_booking" name="date_booking" style="display:none"></textarea>

            <div id="table_approved">
                <div class="reserved_mark"></div><h2>Reserved</h2>
                            <?php  $res2 = $this->booking_table(1);  ?>
                <div style="float:left;">
                    <input class="button-primary" type="button" style="margin:20px 10px;" value="<?php _e('Delete'); ?>"  onclick="javascript:bookingApprove(1,1);"/>
                </div>
                <div id="admin_bk_messages1"> </div>
                <div class="clear" style="height:20px;"></div>
            </div>

            <?php if (! $res2) { ?><script type="text/javascript">document.getElementById('table_approved').style.display="none";</script><?php } ?>

            <div  class="copyright_info" style="">
                <div style="width:580px;height:10px;margin:auto;">
                    <img alt="" src="<?php echo WPDEV_BK_PLUGIN_URL ; ?>/img/contact-32x32.png"  align="center" style="float:left;">
                    <div style="margin: 2px 0px 0px 20px; float: left; text-align: center;">
                                    <?php _e('More Information about this Plugin can be found at the');?> <a href="http://plugins.wpdevelop.com" target="_blank" style="text-decoration:underline;"><?php _e('plugins.wpdevelop.com');?></a>.<br>
                        <a href="http://www.wpdevelop.com" target="_blank" style="text-decoration:underline;"  valign="middle"><?php _e('www.wpdevelop.com');?></a> <?php _e(' - custom wp-plugins and wp-themes development, WordPress solutions');?><br>
                    </div>
                </div>
            </div>


        <?php
        }

        //Content of the Add reservation page
        function content_of_reservation_page() {
            echo '<div class="clear" style="margin:30px;"></div>';
            $mypos = get_option( 'booking_cal_position' ); 
            if ( ($mypos =='top') || ($mypos =='bottom') ) echo '<div style="width:400px">';
            else                                           echo '<div style="width:750px">';
            echo $this->get__client_side_booking_content();
            echo '</div>';
        }

        //content of S E T T I N G S  page
        function content_of_settings_page () {

            if ( isset( $_POST['start_day_weeek'] ) ) { 

                $admin_cal_count  = $_POST['admin_cal_count'];
                $client_cal_count = $_POST['client_cal_count'];
                $start_day_weeek  = $_POST['start_day_weeek'];
                $cal_position     = $_POST['cal_position'];
                $is_delete_if_deactive =  $_POST['is_delete_if_deactive']; // check
                $wpdev_copyright  = $_POST['wpdev_copyright'];             // check

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ( get_option( 'booking_admin_cal_count' ) !== false  )   update_option( 'booking_admin_cal_count' , $admin_cal_count );
                else                                                        add_option('booking_admin_cal_count' , $admin_cal_count );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ( get_option( 'booking_client_cal_count' ) !== false  ) update_option( 'booking_client_cal_count' , $client_cal_count );
                else                                                       add_option('booking_client_cal_count' , $client_cal_count );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ( get_option( 'booking_start_day_weeek' ) !== false )  update_option( 'booking_start_day_weeek' , $start_day_weeek );
                else                                                      add_option('booking_start_day_weeek' , $start_day_weeek );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ( get_option( 'booking_cal_position' )  !== false )     update_option( 'booking_cal_position' , $cal_position );
                else                                                       add_option('booking_cal_position' , $cal_position );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (isset( $is_delete_if_deactive ))            $is_delete_if_deactive = 'On';
                else                                            $is_delete_if_deactive = 'Off';
                if ( get_option( 'booking_is_delete_if_deactive' )  !== false )    update_option('booking_is_delete_if_deactive' , $is_delete_if_deactive );
                else                                                               add_option('booking_is_delete_if_deactive' , $is_delete_if_deactive );

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (isset( $wpdev_copyright ))                  $wpdev_copyright = 'On';
                else                                            $wpdev_copyright = 'Off';
                if ( get_option( 'booking_wpdev_copyright' )  !== false )  update_option( 'booking_wpdev_copyright' , $wpdev_copyright );
                else                                                       add_option('booking_wpdev_copyright' , $wpdev_copyright );
            
            } else { 
                $admin_cal_count  = get_option( 'booking_admin_cal_count' );
                $client_cal_count = get_option( 'booking_client_cal_count' );
                $start_day_weeek  = get_option( 'booking_start_day_weeek' );
                $cal_position     = get_option( 'booking_cal_position' );
                $is_delete_if_deactive =  get_option( 'booking_is_delete_if_deactive' ); // check
                $wpdev_copyright  = get_option( 'booking_wpdev_copyright' );             // check
            }


        ?>
            <div class="clear" style="height:20px;"></div>
            <div id="ajax_working"></div>
            <div id="poststuff" class="metabox-holder">

                <div  style="width:64%; float:left;margin-right:1%;">
                    
                    <div class='meta-box'>
                        <div  class="postbox" > <h3 class='hndle'><span><?php _e('Settings'); ?></span></h3>
                            <div class="inside">
                                    <form  name="post_option" action="" method="post" id="post_option" >
                                        <table class="form-table"><tbody>

                                                <tr valign="top">
                                                <th scope="row"><label for="admin_cal_count" ><?php _e('Count of calendars'); ?>:</label><br><?php printf(__('at %sadmin%s booking page'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                    <td><input id="admin_cal_count" class="regular-text code" type="text" size="45" value="<?php echo $admin_cal_count; ?>" name="admin_cal_count"/>
                                                        <span class="description"><?php printf(__('Type your count of calendars %sat admin booking page%s'),'<b>','</b>');?></span>
                                                    </td>
                                                </tr>

                                                <tr valign="top">
                                                <th scope="row"><label for="client_cal_count" ><?php _e('Count of calendars'); ?>:</label><br><?php printf(__('at %sclient%s side view'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                    <td><input id="client_cal_count" class="regular-text code" type="text" size="45" value="<?php echo $client_cal_count; ?>" name="client_cal_count"/>
                                                        <span class="description"><?php printf(__('Type your default count of calendars %sinside of post or page%s'),'<b>','</b>');?></span>
                                                    </td>
                                                </tr>

                                                <tr valign="top">
                                                    <th scope="row"><label for="start_day_weeek" ><?php _e('Start Day of week'); ?>:</label></th>
                                                    <td>
                                                        <select id="start_day_weeek" name="start_day_weeek">
                                                            <option <?php if($start_day_weeek == '0') echo "selected"; ?> value="0"><?php _e('Sunday'); ?></option>
                                                            <option <?php if($start_day_weeek == '1') echo "selected"; ?> value="1"><?php _e('Monday'); ?></option>
                                                            <option <?php if($start_day_weeek == '2') echo "selected"; ?> value="2"><?php _e('Thuesday'); ?></option>
                                                            <option <?php if($start_day_weeek == '3') echo "selected"; ?> value="3"><?php _e('Wednesday'); ?></option>
                                                            <option <?php if($start_day_weeek == '4') echo "selected"; ?> value="4"><?php _e('Thusday'); ?></option>
                                                            <option <?php if($start_day_weeek == '5') echo "selected"; ?> value="5"><?php _e('Friday'); ?></option>
                                                            <option <?php if($start_day_weeek == '6') echo "selected"; ?> value="6"><?php _e('Saturday'); ?></option>
                                                        </select>
                                                        <span class="description"><?php _e('Select your start day of the week');?></span>
                                                    </td>
                                                </tr>

                                                <tr valign="top">
                                                    <th scope="row"><label for="cal_position" ><?php _e('Position of calendar'); ?>:</label></th>
                                                    <td>
                                                        <select id="cal_position" name="cal_position">
                                                            <option <?php if($cal_position == 'top') echo "selected"; ?> value="top"><?php _e('Top'); ?></option>
                                                            <option <?php if($cal_position == 'bottom') echo "selected"; ?> value="bottom"><?php _e('Bottom'); ?></option>
                                                            <option <?php if($cal_position == 'right') echo "selected"; ?> value="right"><?php _e('Right'); ?></option>
                                                            <option <?php if($cal_position == 'left') echo "selected"; ?> value="left"><?php _e('Left'); ?></option>
                                                        </select>
                                                        <span class="description"><?php _e('Select your default position of calendar relative to form');?></span>
                                                    </td>
                                                </tr>

                                                <?php // COMMERCIAL VERSION ?>
                                                <!--tr valign="top">
                                                    <th scope="row"><label for="login_password" ><?php _e('Default type'); ?>:</label></th>
                                                    <td><input id="login_password" class="regular-text" type="password" size="45" value="<?php echo $login_password; ?>" name="login_password"/>
                                                        <span class="description"><?php _e('Type your password for Fotolia');?>&reg;.</span>
                                                    </td>
                                                </tr-->

                                                <tr valign="top">
                                                    <td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td>
                                                </tr>

                                                <tr valign="top">
                                                    <th scope="row"><label for="is_delete_if_deactive" ><?php _e('Delete booking data'); ?>:</label><br><?php _e('when plugin deactivated'); ?></th>
                                                    <td><input id="is_delete_if_deactive" type="checkbox" <?php if ($is_delete_if_deactive == 'On') echo "checked"; ?>  value="<?php echo $is_delete_if_deactive; ?>" name="is_delete_if_deactive"/>
                                                        <span class="description"><?php _e(' Check, if you want delete booking data during uninstalling plugin.');?></span>
                                                    </td>
                                                </tr>

                                                <tr valign="top">
                                                    <th scope="row"><label for="wpdev_copyright" ><?php _e('Copyright notice'); ?>:</label></th>
                                                    <td><input id="wpdev_copyright" type="checkbox" <?php if ($wpdev_copyright == 'On') echo "checked"; ?>  value="<?php echo $wpdev_copyright; ?>" name="wpdev_copyright"/>
                                                        <span class="description"><?php _e(' Turn On/Off copyright wpdevelop.com notice at footer of site view.');?></span>
                                                    </td>
                                                </tr>

                                            </tbody></table>
                                        
                                        <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save Changes'); ?>" name="Submit"/>
                                        <div class="clear" style="height:10px;"></div>
                                    </form>
                            </div>
                        </div>
                     </div>

                </div>
                <div style="width:35%; float:left;">

                    <div class='meta-box'>
                        <div  class="postbox gdrgrid" > <h3 class='hndle'><span><?php _e('Information'); ?></span></h3>
                            <div class="inside">
                                <p class="sub"><?php _e("Info"); ?></p>
                                <div class="table">
                                    <table><tbody>
                                        <tr class="first">
                                            <td class="first b" style="width: 133px;"><?php _e("Version"); ?></td>
                                            <td class="t"><?php _e("release date"); ?>: <?php echo date ("d.m.Y", filemtime(__FILE__)); ?></td>
                                            <td class="b options" style="color: red; font-weight: bold;"><?php echo WPDEV_BK_VERSION; ?></td>
                                        </tr>
                                    </tbody></table>
                                </div>
                                <p class="sub"><?php _e("Links"); ?></p>
                                <div class="table">
                                    <table><tbody>
                                        <tr class="first">
                                            <td class="first b">Booking Calendar</td>
                                            <td class="t"><?php _e("official plugin page"); ?></td>
                                            <td class="t options"><a href="http://plugins.wpdevelop.com/" target="_blank"><?php _e("visit"); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td class="first b">WordPress Extend</td>
                                            <td class="t"><?php _e("wordpress plugin page"); ?></td>
                                            <td class="t options"><a href="http://wordpress.org/extend/plugins/booking" target="_blank"><?php _e("visit"); ?></a></td>
                                        </tr>
                                    </tbody></table>
                                </div>
                                <p class="sub"><?php _e("Author"); ?></p>
                                <div class="table">
                                    <table><tbody>
                                        <tr class="first">
                                            <td class="first b"><span><?php _e("Premium Support"); ?></span></td>
                                            <td class="t"><?php _e("special plugin customizations"); ?></td>
                                            <td class="t options"><a href="mailto:info@wpdevelop.com" target="_blank"><?php _e("contact"); ?></a></td>
                                        </tr>
                                    </tbody></table>
                                </div>

                            </div>
                        </div>
                     </div>

                    <div class='meta-box'>
                        <div  class="postbox gdrgrid" > <h3 class='hndle'><span><?php _e('Commercial version'); ?></span></h3>
                            <div class="inside">
                                <p class="sub"><?php _e("Main difference features"); ?></p>
                                <div class="table">
                                    <table><tbody>
                                        <tr class="first">
                                            <td class="first b" style="width: 53px;"><b>Features</b></td>
                                            <td class="t"></td>
                                            <td class="b options comparision" style=" "><b><?php _e("Free"); ?></b></td>
                                            <td class="b options comparision" style=" "><b><?php _e("Commercial"); ?></b></td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b" ><?php _e("Functions"); ?></td>
                                            <td class="t i">(<?php _e("all current exist functions"); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b" ><?php _e("Multi types"); ?></td>
                                            <td class="t i">(<?php _e("several types of booking"); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Time"); ?></td>
                                            <td class="t i">(<?php _e("booking time selection"); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <tr class="">
                                            <td class="first b"><?php _e("Form"); ?></td>
                                            <td class="t i">(<?php _e("fields customisation"); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr>
                                        <?php /* ?>
                                        <tr class="">
                                            <td class="first b"><?php _e("Payment"); ?></td>
                                            <td class="t i">(<?php _e("payment process"); ?>)</td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;"></td>
                                            <td class="b options comparision" style="text-align:center;color: green; font-weight: bold;">&bull;</td>
                                        </tr><?php /**/ ?>
                                        <tr>
                                            <td class="first b" ><?php _e("Price"); ?></td>
                                            <td class="t"><?php  ?></td>
                                            <td class="t options comparision"><?php _e("free"); ?></td>
                                            <td class="t options comparision"><?php _e("$99"); ?></td>
                                        </tr>
                                        <tr class="last">
                                            <td class="first b"><span><?php _e("Preorder"); ?></span></td>
                                            <td class="t i">(<?php _e("send request with contact data"); ?>)</td>
                                            <td class="options comparision"></td>
                                            <td class="t comparision"><a href="mailto:order@wpdevelop.com" target="_blank"><?php _e("contact"); ?></a></td>
                                        </tr>

                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                     </div>
                    
                </div>

            </div>
        <?php
        }


        //   C L I E N T   S I D E   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Get content at client side of  C A L E N D A R
        function get__client_side_booking_content($my_boook_type = 1, $myposition = '') {
            
            $calendar = '<div id="calendar_booking"></div>';
            $form = '<div id="booking_form_div">
                            <textarea rows="3" cols="50" id="date_booking" name="date_booking" style="display:none;"></textarea>
                            <div class="main_div">
                                <div class="field"> <label for="bk_name">Name* :</label><input id="bk_name"  name="bk_name" class="" type="text" ><div class="field_message bk_name_mess"></div></div>
                                <div class="field"> <label for="bk_surname">Surname* :</label><input id="bk_surname" name="bk_surname" class="" type="text" > </div>
                                <div class="field"> <label for="bk_emeil">Email* :</label><input id="bk_emeil" name="bk_emeil" class="" type="text" > </div>
                                <div class="field"> <label for="bk_phone">Phone* :</label><input id="bk_phone" name="bk_phone" class="" type="text" > </div>
                            </div>
                            <div style="clear:both;"></div>
                            <label for="bk_detail">Detail :</label><br>
                            <textarea rows="3" cols="50" id="bk_detail" name="bk_detail"></textarea>
                            <input id="bk_type" name="bk_type" class="" type="hidden" value="'.$my_boook_type.'" >
                            <div style="clear:both;"></div>
                    </div>';
             $submitting = '<div id="submiting"></div><div id="form_bk_messages" ></div>';
             $nl = '<div style="clear:both;height:10px;"></div>';
             $btn = '<input type="button" id="booking_form_btn" class="submit" value="Reserve" onclick="mybooking_submit(this.form);">';
            if ( $myposition == '' ) $mypos = get_option( 'booking_cal_position' );
            else $mypos = $myposition;
            switch ($mypos) {
                case 'bottom':
                    $res = $form . $nl . $nl . $calendar .  $submitting. $btn . $nl; // Bottom
                    break;
                case 'left':
                    $res = '<div style="float:left;margin:0px 20px 20px 0px;">' . $calendar . '</div><div style="float:left">' .$form . '</div>' . $nl . $submitting. $btn . $nl; // Left
                    break;
                case 'right':
                    $res = '<div style="float:left;margin:0px 20px 20px 0px;">' . $form . '</div><div style="float:left">' . $calendar . '</div>' . $nl . $submitting. $btn . $nl; // Right
                    break;
                default:
                    $res = $calendar . $nl . $submitting .   $form . $btn . $nl; // Top Calendar
                    break;
            }
            return '<form name="booking_form" id="booking_form"  method="post" action="">' . $res . '</form>';
        }

        // Replace MARK at post with content at client side   -----    [booking nummonths='1' type='1']
        function booking_shortcode($attr) {

            $my_boook_type = 1;
            // Set initial parameters here for callendar through variables
            $script_code = "<script type='text/javascript'>";
            if ( isset( $attr['nummonths'] ) )
                $script_code .= " my_num_month = ".$attr['nummonths'].";";
            if ( isset( $attr['type'] ) ) {
                $script_code .= " my_book_type = ".$attr['type'].";"; $my_boook_type = $attr['type']; }
            if ( isset( $attr['position'] ) ) {
                $script_code .= " my_book_position = ".$attr['position'].";"; }
            $script_code .= "</script>";

            return $script_code .' ' . $this->get__client_side_booking_content($my_boook_type, $attr['position']) ;
        }

        // Head of Client side - including JS Ajax function
        function client_side_print_booking_head() {
            wp_print_scripts( array( 'sack' )); // Define custom A J A X  respond at Client side
            ?>
<script type="text/javascript">

            function setReservedSelectedDates(){
                // get selected dates
                var sel_dates = calender_booking.selectedDates.copy();
                var new_dt;
                //calender_booking.selectedDates=[];
                sel_dates.each(function (dt){
                    new_dt = new Date(dt);
                    //Unselect all this selected dates
                    calender_booking.unselectDate(new_dt);
                    //Add to days Off selected days
                    calender_booking.options.datesOff.push(new_dt.getTime());
                });
                //Update view of calendar
                document.getElementById('date_booking').value = '';
                calender_booking.updateCalendar(new_dt);
                document.getElementById("booking_form_div").style.display="none";
                document.getElementById("booking_form_btn").style.display="none";
            }

            //<![CDATA[
            function mybooking_submit( submit_form ){

                var isAllFill = true;

                if (submit_form.bk_phone.value == '') { isAllFill = false;
                    jQuery('#bk_phone').css( {'border' : '1px solid red'} ).fadeOut( 350 ).fadeIn( 500 );
                    submit_form.bk_phone.focus();
                } else jQuery('#bk_phone').css( {'border' : '1px solid #dfdfdf'} );

                if (submit_form.bk_emeil.value == '') { isAllFill = false;
                    jQuery('#bk_emeil').css( {'border' : '1px solid red'} ).fadeOut( 350 ).fadeIn( 500 );
                    submit_form.bk_emeil.focus();
                } else jQuery('#bk_emeil').css( {'border' : '1px solid #dfdfdf'} );

                if (submit_form.bk_surname.value == '') { isAllFill = false;
                    jQuery('#bk_surname').css( {'border' : '1px solid red'} ).fadeOut( 350 ).fadeIn( 500 );
                    submit_form.bk_surname.focus();
                } else jQuery('#bk_surname').css( {'border' : '1px solid #dfdfdf'} );

                if (submit_form.bk_name.value == '') { isAllFill = false;
                    jQuery('#bk_name').css( {'border' : '1px solid red'} ).fadeOut( 350 ).fadeIn( 500 );
                    submit_form.bk_name.focus();
                } else jQuery('#bk_name').css( {'border' : '1px solid #dfdfdf'} );

                if (submit_form.date_booking.value == '') { isAllFill = false;
                    alert('<?php _e("Please, select reservation date.") ?>');
                }

                if (! isAllFill) {
                    jQuery('#form_bk_messages')
                    .html( 'Please, fill selected fields, correctly.' )
                    .css( {'display' : 'none'} )
                    .fadeIn(200)
                    .fadeOut(3000);

                    return 0;
                }



                document.getElementById('submiting').innerHTML =
                    '<div style="height:20px;width:100%;text-align:center;margin:15px auto;"><img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/ajax-loader.gif"></div>';

                var mysack = new sack( "<?php  echo WPDEV_BK_PLUGIN_URL; ?>/<?php echo WPDEV_BK_PLUGIN_FILENAME; ?>" );

                mysack.execute = 1;
                mysack.method = 'POST';
                mysack.setVar( "AJAX_WPDEV_PLUGIN", '<?php echo basename( __FILE__ ); ?>' );

                mysack.setVar( "AJAX_WPDEV_TYPE", 'INSERT_INTO_TABLE' );

                mysack.setVar( "bktype", submit_form.bk_type.value );
                mysack.setVar( "dates", submit_form.date_booking.value );
                mysack.setVar( "name", submit_form.bk_name.value );
                mysack.setVar( "surname", submit_form.bk_surname.value );
                mysack.setVar( "email", submit_form.bk_emeil.value );
                mysack.setVar( "phone", submit_form.bk_phone.value );
                mysack.setVar( "detail", submit_form.bk_detail.value );

                mysack.onError = function() { alert('Ajax error in voting' )};
                mysack.runAJAX();
                return true;
            }
            //]]>
</script>
            <?php
            // Write calendars script
            $this->head_print_js_css(0);
        }

        // Write copyright notice if its saved
        function wp_footer(){
            if ( ( get_option( 'booking_wpdev_copyright' )  == 'On' ) && ( WPDEV_COPYRIGHT ) ) {
               printf(__('Uses wordpress plugins developed by %swww.wpdevelop.com%s'),'<a href="http://www.wpdevelop.com" target="_blank">','</a>','&amp;');
               define('WPDEV_COPYRIGHT',  0 );
            }
        }

        //   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ///////////////////////////////////////////////////////////

        // Activate
        function wpdev_booking_activate() {

            add_option( 'booking_admin_cal_count' ,'2');
            add_option( 'booking_client_cal_count', '1' );
            add_option( 'booking_start_day_weeek' ,'0');
            add_option( 'booking_cal_position' ,'top');
            add_option( 'booking_is_delete_if_deactive' ,'Off'); // check
            add_option( 'booking_wpdev_copyright','On' );             // check

        // Create here tables which is needed for using plugin
            $charset_collate = '';
            $wp_queries = array();
            global $wpdb;

            if ( ( ! $this->is_table_exists('booking') ) || ( ! $this->is_table_exists('bookingdates') )) { // Cehck if tables not exist yet
                    if ( $wpdb->has_cap( 'collation' ) ) {
                        if ( ! empty($wpdb->charset) )
                            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                        if ( ! empty($wpdb->collate) )
                            $charset_collate .= " COLLATE $wpdb->collate";
                    }
                    /** Create WordPress database tables SQL */
                    $wp_queries[] = "CREATE TABLE ".$wpdb->prefix ."booking (
                         booking_id bigint(20) unsigned NOT NULL auto_increment,
                         user_name varchar(200) NOT NULL default '',
                         user_surname varchar(200) NOT NULL default '',
                         user_email varchar(200) NOT NULL default '',
                         user_phone varchar(200) NOT NULL default '',
                         user_description varchar(800) NOT NULL default '',
                         booking_type bigint(10) NOT NULL default 0,
                         PRIMARY KEY  (booking_id)
                        ) $charset_collate;";

                    $wp_queries[] = "CREATE TABLE ".$wpdb->prefix ."bookingdates (
                         booking_id bigint(20) unsigned NOT NULL,
                         booking_date datetime NOT NULL default '0000-00-00 00:00:00',
                         approved bigint(20) unsigned NOT NULL default 0
                        ) $charset_collate;";


                    $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."booking (
                         user_name, user_surname, user_email, user_phone, user_description
                        ) VALUES (
                         'Name example', 'Second name example', 'example@wpdevelop.com', '8-077-333-22-11',
                         'This is example of booking reservation. Please, reserve for me room with flowers and sea view. '
                        );";

                    foreach ($wp_queries as $wp_q)
                        $wpdb->query($wp_q);


                     $temp_id = $wpdb->insert_id;
                     $wp_queries_sub = "INSERT INTO ".$wpdb->prefix ."bookingdates (
                         booking_id,
                         booking_date
                        ) VALUES
                        ( ". $temp_id .", NOW()+ INTERVAL 2 day ),
                        ( ". $temp_id .", NOW()+ INTERVAL 3 day ),
                        ( ". $temp_id .", NOW()+ INTERVAL 4 day );";
                        $wpdb->query($wp_queries_sub);
            }
        }

        // Deactivate
        function wpdev_booking_deactivate() {
    
           $is_delete_if_deactive =  get_option( 'booking_is_delete_if_deactive' ); // check
           
           if ($is_delete_if_deactive == 'On') {
                // Delete here tables and options, which are needed for using plugin
                delete_option( 'booking_admin_cal_count' );
                delete_option( 'booking_client_cal_count' );
                delete_option( 'booking_start_day_weeek' );
                delete_option( 'booking_cal_position' );
                delete_option( 'booking_is_delete_if_deactive' ); // check
                delete_option( 'booking_wpdev_copyright' );             // check
                global $wpdb;
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'booking');
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'bookingdates');
           }
        }

    }
}


$wpdev_bk = new wpdev_booking();


// A J A X     R e s p o n d e r   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function wpdev_ajax_booking_responder() {
    global $wpdb;

      // Get dates 4 emeil
      function get_dates_str ($approved_id_str) {
            global $wpdb;
            $dates_approve = $wpdb->get_results(
                  "SELECT DISTINCT booking_date FROM ".$wpdb->prefix ."bookingdates WHERE  booking_id IN ($approved_id_str) ORDER BY booking_date" );
            $dates_str = '';
            // loop with all dates which is selected by someone
            foreach ($dates_approve as $my_date) {
                $my_date = explode(' ',$my_date->booking_date);
                $my_date = explode('-',$my_date[0]);
                if ($dates_str != '') $dates_str .= ', ';
                $dates_str .= $my_date[1] . '.' .$my_date[2] . '.' . $my_date[0];
            }
            return $dates_str;
      }


    switch ( $_POST["AJAX_WPDEV_TYPE"] ) {

        case  'INSERT_INTO_TABLE':

            $dates = $_POST[ "dates" ];
            $name = $_POST[  "name" ];
            $surname = $_POST[  "surname" ];
            $email = $_POST[  "email" ];
            $phone = $_POST[  "phone" ];
            $detail = $_POST[  "detail" ];
            $bktype = $_POST[  "bktype" ];
            // Make insertion into BOOKING
            $insert = "('$name', '$surname', '$email', '$phone', '$detail', $bktype)";
            if ( !empty($insert) )
                if ( false === $wpdb->query("INSERT INTO ".$wpdb->prefix ."booking (user_name, user_surname, user_email, user_phone, user_description, booking_type) VALUES " . $insert) )
                    die("document.getElementById('submiting').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;>".__('Error during inserting into BD')."</div>';");

            // Make insertion into BOOKINGDATES
            $booking_id = (int) $wpdb->insert_id;       //Get ID  of reservation
            $insert='';

            $my_dates = explode("|",$dates);
            foreach ($my_dates as $my_date) {           // Loop through all dates
                if (strpos($my_date,'.')!==false) {
                    $my_date = explode('.',$my_date);
                    $date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $my_date[2], $my_date[1], $my_date[0], '00', '00', '00' );
                    if ( !empty($insert) ) $insert .= ', ';
                    $insert .= "('$booking_id', '$date', '0')";
                }
            }
            if ( !empty($insert) )
                if ( false === $wpdb->query("INSERT INTO ".$wpdb->prefix ."bookingdates (booking_id, booking_date, approved) VALUES " . $insert) )
                    die("document.getElementById('submiting').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;>".__('Error during inserting into BD - Dates')."</div>';");

            // Sending mail ///////////////////////////////////////////////////////
            $mail_subject =  'New reservation';
            $mail_body =  'You need to approve reservation for '. $name . ' '. $surname.
                '<br><br> at dates: ' . str_replace('|',',',$dates) .
                '<br><br> Contact phone:' . $phone . '<br><br>' . $detail ;

            $mail_sender =  $email;
            $mail_recipient =  get_option('admin_email');;

            $mail_headers = "From: $mail_sender\n";
            $mail_headers .= "Content-Type: text/html\n";

            @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);
            /////////////////////////////////////////////////////////////////////////

            die("document.getElementById('submiting').innerHTML = '<div class=\"submiting_content\" >Your dates are reserved.</div>';jQuery('.submiting_content').fadeOut(5000);setReservedSelectedDates();");

            break;

        case  'UPDATE_APPROVE':

            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $approved_id = explode('|',$approved);
            if ( (count($approved_id)>0) && ($approved_id !==false)) {
                $approved_id_str = join( ',', $approved_id);

                if ( false === $wpdb->query( "UPDATE ".$wpdb->prefix ."bookingdates SET approved = '1' WHERE booking_id IN ($approved_id_str)") )
                    die("document.getElementById('admin_bk_messages".$is_in_approved."').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;>".__('Error during updating to DB')."</div>';");

                $sql = "SELECT *
                                    FROM ".$wpdb->prefix ."booking as bk
                                    WHERE bk.booking_id IN ($approved_id_str)";

                $result = $wpdb->get_results( $sql );

                foreach ($result as $res) {
                // Sending mail ///////////////////////////////////////////////////////
                    $mail_subject =  'Your reservation is approved';
                    $mail_body =  $res->user_name . ' your reservation for '.get_dates_str($res->booking_id).'  has been approved.';

                    $mail_sender =  get_option('admin_email');;
                    $mail_recipient =  $res->user_email;

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);
                /////////////////////////////////////////////////////////////////////////
                }

                die("document.getElementById('admin_bk_messages".$is_in_approved."').innerHTML = '<div class=\"submiting_content\" >".$approved_id."</div>';jQuery('.submiting_content').html('Approved').fadeOut(4000);location.reload(true);");
            }
            break;

        case  'DELETE_APPROVE':
            $is_in_approved = $_POST[ "is_in_approved" ];
            $approved = $_POST[ "approved" ];
            $approved_id = explode('|',$approved);
            if ( (count($approved_id)>0) && ($approved_id !=false) && ($approved_id !='')) {
                $approved_id_str = join( ',', $approved_id);

                $sql = "SELECT *
                                    FROM ".$wpdb->prefix ."booking as bk
                                    WHERE bk.booking_id IN ($approved_id_str)";

                $result = $wpdb->get_results( $sql );

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."bookingdates WHERE booking_id IN ($approved_id_str)") )
                    die("document.getElementById('admin_bk_messages".$is_in_approved."').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;>".__('Error during deleting dates at DB')."</div>';");

                if ( false === $wpdb->query( "DELETE FROM ".$wpdb->prefix ."booking WHERE booking_id IN ($approved_id_str)") )
                    die("document.getElementById('admin_bk_messages".$is_in_approved."').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;>".__('Error during deleting reservation at DB')."</div>';");

                foreach ($result as $res) {
                // Sending mail ///////////////////////////////////////////////////////
                    $mail_subject =  'Your reservation is decline';
                    $mail_body =  $res->user_name . 'your reservation for '.get_dates_str($res->booking_id).'  has been declined.';

                    $mail_sender =  '"admin booking" <' .get_option('admin_email').'>';//fish
                    $mail_recipient =  $res->user_email;

                    $mail_headers = "From: $mail_sender\n";
                    $mail_headers .= "Content-Type: text/html\n";

                    @wp_mail($mail_recipient, $mail_subject, $mail_body, $mail_headers);
                /////////////////////////////////////////////////////////////////////////
                }


                die("document.getElementById('admin_bk_messages".$is_in_approved."').innerHTML = '<div class=\"submiting_content\" >".$approved_id."</div>';jQuery('.submiting_content').html('Deleted').fadeOut(4000);location.reload(true);");
            }
            break;


    }

    die(0);
}


?>
