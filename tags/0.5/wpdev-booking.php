<?php
/*
Plugin Name: Booking Calendar
Plugin URI: http://plugins.wpdevelop.com
Description: Calendar of reservation for booking service
Version: 0.5
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

-- 1.SQL create tables
-- 2.Send request and story at DB
-- 3.Read DB at ADMIN page
-- 4.create view of booking table
-- 5.crete approve of orders at admin page
-- 6.View client side booking dates

-- Update content of each tables during updating and caledar
-- Show different colors of orders at calendar
TODO:  send emeil to the user

TODO: .View different types of orders at admin page selection
-- .Delete orders

 */


// If    A J A X so then make it
if ( isset( $_POST['AJAX_WPDEV_PLUGIN'] ) )
    if ($_POST['AJAX_WPDEV_PLUGIN'] === 'yes') {
        define('DOING_AJAX', true);
        require_once( dirname(__FILE__) . '/../../../wp-load.php' );
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
        wpdev_ajax_booking_responder();
        die(0);
    }


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

            var $gui_option;  // GUI class

            function wpdev_booking() {

                    require_once(WPDEV_BK_PLUGIN_DIR. '/class/wpdev-plugin-gui.php' ); // Connect my GUI class
                    $this->gui_option = new wpdev_plugins_gui('wpdev-booking-',__FILE__,__('Booking service'), __('Booking')/*,'options'/**/,'');
                    $this->gui_option->add_content(array(&$this, 'content_of_booking_option_page'));

                    // Page hook for admin JS files ONLY at this plugin page
                    add_action('admin_menu', array(&$this,'on_add_admin_plugin_page'));
                    add_action('wp_head',array(&$this, 'client_side_print_booking_head'));

                    add_shortcode('booking', array(&$this, 'booking_shortcode'));

                    register_activation_hook( __FILE__, array(&$this,'wpdev_booking_activate' ));
                    register_deactivation_hook( __FILE__, array(&$this,'wpdev_booking_deactivate' ));

            }

    //   F U N C T I O N S       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
            function booking_table($approved = 0){

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
              add_action("admin_print_scripts-" . $this->gui_option->pagehook , array( &$this, 'on_add_admin_js_files'));
            }

            // add hook for printing scripts only at this plugin page
            function on_add_admin_js_files(){
              // List of WordPress scripts for Ajax working
              wp_print_scripts( array( 'sack' ));

              // Write inline scripts and CSS at HEAD
              add_action('admin_head', array(&$this, 'head_print_js_css' ), 1);
            }

            // Print NOW   admin     J a v a S cr i p t   &    C S S
            function head_print_js_css(){
                if (! is_admin()) wp_print_scripts('jquery');
            ?>
                <script src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/calendar_js/mootools.v1.11.js" type="text/javascript"></script>
                <script src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/calendar_js/nogray_date_calendar_vs1_min.js" type="text/javascript"></script>
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
                                    if ( is_admin() ){
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
                                    if ( is_admin() )
                                        echo "my_num_month=3;";
                                    else
                                        echo "my_num_month=1;";
                                    ?>
                                }
                                if (typeof (my_book_type)=='undefined' ) my_book_type=1;

                                // may be later its will be needed
                                selected_dates=[<?php/*
                                        if ( is_admin() ){
                                             $dates_to_approve = $this->get_dates('0');
                                              foreach ($dates_to_approve as $date_to_approve) {
                                                 echo "new Date($date_to_approve[0], $date_to_approve[1]-1, $date_to_approve[2]),";  ////echo "new Date($year, $month, $day),";
                                            }
                                        }       /**/?>];

                                // all reserved dates
                                unavailable_dates=[<?php

                                         if ( is_admin() )
                                            $dates_to_approve = $this->get_dates('1');
                                        else
                                            $dates_to_approve = $this->get_dates();
                                          foreach ($dates_to_approve as $date_to_approve) {
                                            echo "new Date($date_to_approve[0], $date_to_approve[1]-1, $date_to_approve[2]),";  ////echo "new Date($year, $month, $day),";
                                        }
                                                ?>];

                                calender_booking = new Calendar("calendar_booking", null, {    visible:true,
                                                                                            inputField:'date_booking',
                                                                                            allowSelection:true,
                                                                                            numMonths:my_num_month,
                                                                                            startDay:1,
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
                                    <?php if ( is_admin() ){ ?>
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
                                mysack.setVar( "AJAX_WPDEV_PLUGIN", 'yes' );

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

                </script>
                <link href="<?php echo WPDEV_BK_PLUGIN_URL; ?>/calendar_js/nogray_calendar_vs1.css" rel="stylesheet" type="text/css" />
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
                            width:1005px;
                            margin:0px auto;
                            padding:0;
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
                            border:1px solid #CCCCCC;
                        }
                        .booking_table td{
                            padding:5px 20px;
                            border:none;

                        }
                        .booking_table th{
                            padding:5px 20px;
                            border:none;
                            font-size:12px;
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

                </style>
                <?php  if (! is_admin()){  ?>
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
                        }
                        .redBorders {
                            background: red;
                        }
                        </style>
                <?php  }
            }

            // CONTENT OF THE ADMIN PAGE
            function content_of_booking_option_page () {
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


            <?php
            }


    //   C L I E N T   S I D E   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // Get content at client side of  C A L E N D A R
            function get__client_side_booking_content($my_boook_type = 1){

                return '<div id="calendar_booking"></div>
                        <div id="submiting"></div>
                        <form name="booking_form" id="booking_form"  method="post" action="">
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
                            <div id="form_bk_messages" ></div>
                            <input type="button" class="submit" value="Reserve" onclick="mybooking_submit(this.form);">
                        </form>
                        ';
            }

            // Replace MARK at post with content at client side   -----    [booking nummonths='1' type='1']
            function booking_shortcode($attr){

                $my_boook_type = 1;
                // Set initial parameters here for callendar through variables
                $script_code = "<script type='text/javascript'>";
                if ( isset( $attr['nummonths'] ) )
                    $script_code .= " my_num_month = ".$attr['nummonths'].";";
                if ( isset( $attr['type'] ) ) {
                    $script_code .= " my_book_type = ".$attr['type'].";"; $my_boook_type = $attr['type']; }
                $script_code .= "</script>";

                return $script_code .' ' . $this->get__client_side_booking_content($my_boook_type) ;
            }

            // Head of Client side - including JS Ajax function
            function client_side_print_booking_head(){

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
                  document.getElementById("booking_form").style.display="none";
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
                      mysack.setVar( "AJAX_WPDEV_PLUGIN", 'yes' );

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
                $this->head_print_js_css();

            }


    //   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ///////////////////////////////////////////////////////////

            // Activate
            function wpdev_booking_activate() {
                // Create here tables which is needed for using plugin
                $charset_collate = '';
                $wp_queries = array();
                global $wpdb;

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

                foreach ($wp_queries as $wp_q)
                  $wpdb->query($wp_q);

            }

            // Deactivate
            function wpdev_booking_deactivate() {
                // Delete here tables which is needed for using plugin
                global $wpdb;
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'booking');
                $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'bookingdates');
            }

    }
}
$wpdev_bk = new wpdev_booking();


// A J A X     R e s p o n d e r   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function wpdev_ajax_booking_responder(){
      global $wpdb;

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
                                $mail_body =  $res->user_name . ' your reservation has approved.';

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
                                $mail_body =  $res->user_name . 'your reservation has declined.';

                                $mail_sender =  get_option('admin_email');;
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
