<?php

    // Show Settings content of main page
    function wpdev_bk_settings_general() {

        $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
        if ($is_can===false) return;


        if ( isset( $_POST['start_day_weeek'] ) ) {
            $booking_skin  = $_POST['booking_skin'];

            $email_reservation_adress      = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_adress']));
            $email_reservation_adress      = str_replace("\'","'",$email_reservation_adress);

            $bookings_num_per_page = $_POST['bookings_num_per_page'];
            $booking_sort_order = $_POST['booking_sort_order'];
            $booking_default_toolbar_tab = $_POST['booking_default_toolbar_tab'];
            $bookings_listing_default_view_mode = $_POST['bookings_listing_default_view_mode'];
            $booking_view_days_num = $_POST['booking_view_days_num'];

            //$booking_sort_order_direction = $_POST['booking_sort_order_direction'];

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
            if (isset($_POST['is_use_hints_at_admin_panel']))
                $is_use_hints_at_admin_panel = $_POST['is_use_hints_at_admin_panel'];

            $type_of_day_selections = $_POST[ 'type_of_day_selections' ];
            

            if (isset($_POST['is_delete_if_deactive'])) $is_delete_if_deactive =  $_POST['is_delete_if_deactive']; // check
            if (isset($_POST['wpdev_copyright_adminpanel'])) $wpdev_copyright_adminpanel  = $_POST['wpdev_copyright_adminpanel'];             // check
            if (isset($_POST['booking_is_show_powered_by_notice'])) $booking_is_show_powered_by_notice  = $_POST['booking_is_show_powered_by_notice'];             // check

            if (isset($_POST['is_use_captcha'])) $is_use_captcha  = $_POST['is_use_captcha'];             // check
            if (isset($_POST['is_use_autofill_4_logged_user'])) $is_use_autofill_4_logged_user  = $_POST['is_use_autofill_4_logged_user'];             // check

            if (isset($_POST['unavailable_day0']))  $unavailable_day0  = $_POST['unavailable_day0'];
            if (isset($_POST['unavailable_day1']))  $unavailable_day1  = $_POST['unavailable_day1'];
            if (isset($_POST['unavailable_day2']))  $unavailable_day2  = $_POST['unavailable_day2'];
            if (isset($_POST['unavailable_day3']))  $unavailable_day3  = $_POST['unavailable_day3'];
            if (isset($_POST['unavailable_day4']))  $unavailable_day4  = $_POST['unavailable_day4'];
            if (isset($_POST['unavailable_day5']))  $unavailable_day5  = $_POST['unavailable_day5'];
            if (isset($_POST['unavailable_day6']))  $unavailable_day6  = $_POST['unavailable_day6'];

            $user_role_booking      = $_POST['user_role_booking'];
            $user_role_addbooking   = $_POST['user_role_addbooking'];
            $booking_user_role_settings     = $_POST['user_role_settings'];
            if (isset($_POST['user_role_resources']))
                $user_role_resources     = $_POST['user_role_resources'];
            if ( wpdev_bk_is_this_demo() ) {
                $user_role_booking      = 'subscriber';
                $user_role_addbooking   = 'subscriber';
                $booking_user_role_settings     = 'subscriber';
                $user_role_resources    = 'subscriber';
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////


            update_bk_option( 'booking_user_role_booking', $user_role_booking );
            update_bk_option( 'booking_user_role_addbooking', $user_role_addbooking );
            if (isset($user_role_resources))
                update_bk_option( 'booking_user_role_resources', $user_role_resources );
            update_bk_option( 'booking_user_role_settings', $booking_user_role_settings );


            update_bk_option( 'bookings_num_per_page',$bookings_num_per_page);
            update_bk_option( 'booking_sort_order',$booking_sort_order);
            update_bk_option( 'booking_default_toolbar_tab',$booking_default_toolbar_tab);
            update_bk_option( 'bookings_listing_default_view_mode',$bookings_listing_default_view_mode);
            update_bk_option( 'booking_view_days_num',$booking_view_days_num);


            //update_bk_option( 'booking_sort_order_direction',$booking_sort_order_direction);

            update_bk_option( 'booking_skin',$booking_skin);
            update_bk_option( 'booking_email_reservation_adress' , $email_reservation_adress );

            if ( get_bk_version() == 'free' ) { // Update admin from adresses at free version
                //update_bk_option( 'booking_email_reservation_from_adress', $email_reservation_adress );
                update_bk_option( 'booking_email_approval_adress', $email_reservation_adress );
                update_bk_option( 'booking_email_deny_adress', $email_reservation_adress );
            }

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

            if (! wpdev_bk_is_this_demo() ) { // Do not allow to chnage it in  the demo
                if (isset( $_POST['is_not_load_bs_script_in_client'] ))   $is_not_load_bs_script_in_client = 'On';
                else                                                      $is_not_load_bs_script_in_client = 'Off';
                update_bk_option( 'booking_is_not_load_bs_script_in_client' , $is_not_load_bs_script_in_client );
                if (isset( $_POST['is_not_load_bs_script_in_admin'] ))   $is_not_load_bs_script_in_admin = 'On';
                else                                                      $is_not_load_bs_script_in_admin = 'Off';
                update_bk_option( 'booking_is_not_load_bs_script_in_admin' , $is_not_load_bs_script_in_admin );
            }


            update_bk_option( 'booking_type_of_day_selections' , $type_of_day_selections );

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $unavailable_days_num_from_today     = $_POST['unavailable_days_num_from_today'];
            update_bk_option( 'booking_unavailable_days_num_from_today' , $unavailable_days_num_from_today );




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

            if (isset( $booking_is_show_powered_by_notice ))                  $booking_is_show_powered_by_notice = 'On';
            else                                            $booking_is_show_powered_by_notice = 'Off';
            update_bk_option( 'booking_is_show_powered_by_notice' , $booking_is_show_powered_by_notice );
            if (isset( $wpdev_copyright_adminpanel ))                  $wpdev_copyright_adminpanel = 'On';
            else                                            $wpdev_copyright_adminpanel = 'Off';
            update_bk_option( 'booking_wpdev_copyright_adminpanel' , $wpdev_copyright_adminpanel );
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if (isset( $is_use_captcha ))                  $is_use_captcha = 'On';
            else                                           $is_use_captcha = 'Off';
            update_bk_option( 'booking_is_use_captcha' , $is_use_captcha );

            if (isset( $is_use_autofill_4_logged_user ))                    $is_use_autofill_4_logged_user = 'On';
            else                                                            $is_use_autofill_4_logged_user = 'Off';
            update_bk_option( 'booking_is_use_autofill_4_logged_user' , $is_use_autofill_4_logged_user );



            //if (isset( $is_show_legend ))                  $is_show_legend = 'On';
            //else                                           $is_show_legend = 'Off';
            //update_bk_option( 'booking_is_show_legend' , $is_show_legend );

        } else {
            $booking_skin = get_bk_option( 'booking_skin');
            $email_reservation_adress      = get_bk_option( 'booking_email_reservation_adress') ;
            $max_monthes_in_calendar =  get_bk_option( 'booking_max_monthes_in_calendar' );

            $bookings_num_per_page =  get_bk_option( 'bookings_num_per_page');
            $booking_sort_order = get_bk_option( 'booking_sort_order');
            $booking_default_toolbar_tab = get_bk_option( 'booking_default_toolbar_tab');
            $bookings_listing_default_view_mode = get_bk_option( 'bookings_listing_default_view_mode');
            $booking_view_days_num = get_bk_option( 'booking_view_days_num');
            //$booking_sort_order_direction = get_bk_option( 'booking_sort_order_direction');


            $admin_cal_count  = get_bk_option( 'booking_admin_cal_count' );
            $new_booking_title= get_bk_option( 'booking_title_after_reservation' );
            $new_booking_title_time= get_bk_option( 'booking_title_after_reservation_time' );

            $type_of_thank_you_message = get_bk_option( 'booking_type_of_thank_you_message' ); //= 'message'; = 'page';
            $thank_you_page_URL = get_bk_option( 'booking_thank_you_page_URL' ); //= 'message'; = 'page';


            $booking_date_format = get_bk_option( 'booking_date_format');
            $booking_date_view_type = get_bk_option( 'booking_date_view_type');
            $client_cal_count = get_bk_option( 'booking_client_cal_count' );
            $start_day_weeek  = get_bk_option( 'booking_start_day_weeek' );
            $is_use_hints_at_admin_panel    = get_bk_option( 'booking_is_use_hints_at_admin_panel' );
            $is_not_load_bs_script_in_client = get_bk_option( 'booking_is_not_load_bs_script_in_client'  );
            $is_not_load_bs_script_in_admin = get_bk_option( 'booking_is_not_load_bs_script_in_admin'  );

            
            $type_of_day_selections =  get_bk_option( 'booking_type_of_day_selections');



            $is_delete_if_deactive =  get_bk_option( 'booking_is_delete_if_deactive' ); // check
            $wpdev_copyright_adminpanel  = get_bk_option( 'booking_wpdev_copyright_adminpanel' );             // check
            $booking_is_show_powered_by_notice = get_bk_option( 'booking_is_show_powered_by_notice' );             // check
            $is_use_captcha  = get_bk_option( 'booking_is_use_captcha' );             // check
            $is_use_autofill_4_logged_user  = get_bk_option( 'booking_is_use_autofill_4_logged_user' );             // check

            $unavailable_days_num_from_today = get_bk_option( 'booking_unavailable_days_num_from_today'  );
            $unavailable_day0 = get_bk_option( 'booking_unavailable_day0' );
            $unavailable_day1 = get_bk_option( 'booking_unavailable_day1' );
            $unavailable_day2 = get_bk_option( 'booking_unavailable_day2' );
            $unavailable_day3 = get_bk_option( 'booking_unavailable_day3' );
            $unavailable_day4 = get_bk_option( 'booking_unavailable_day4' );
            $unavailable_day5 = get_bk_option( 'booking_unavailable_day5' );
            $unavailable_day6 = get_bk_option( 'booking_unavailable_day6' );

            $user_role_booking      = get_bk_option( 'booking_user_role_booking' );
            $user_role_addbooking   = get_bk_option( 'booking_user_role_addbooking' );
            $user_role_resources   = get_bk_option( 'booking_user_role_resources');
            $booking_user_role_settings     = get_bk_option( 'booking_user_role_settings' );
        }

        if (empty($type_of_thank_you_message)) $type_of_thank_you_message = 'message';
        ?>
        <div  class="clear" style="height:10px;"></div>
        <div class="wpdevbk-not-now">
        <form  name="post_option" action="" method="post" id="post_option" class="form-horizontal">

            <div  style="width:64%; float:left;margin-right:1%;">

                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_main'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Main', 'wpdev-booking'); ?></span></h3> <div class="inside">
                            <table class="form-table"><tbody>

                    <?php  // make_bk_action('wpdev_bk_general_settings_a'); ?>


                                        <tr valign="top">
                                            <th scope="row"><label for="admin_cal_count" ><?php _e('Admin email', 'wpdev-booking'); ?>:</label></th>
                                            <td><input id="email_reservation_adress"  name="email_reservation_adress" class="regular-text code" type="text" style="width:350px;" size="145" value="<?php echo $email_reservation_adress; ?>" /><br/>
                                                <span class="description"><?php printf(__('Type default %sadmin email%s for booking confirmation', 'wpdev-booking'),'<b>','</b>');?></span>
                                            </td>
                                        </tr>

                                        <?php make_bk_action('wpdev_bk_general_settings_edit_booking_url'); ?>

                                        <?php do_action('settings_advanced_set_update_hash_after_approve'); ?>

                                        <tr valign="top">
                                            <th scope="row"><label for="is_use_hints_at_admin_panel" ><?php _e('Show hints', 'wpdev-booking'); ?>:</label><br><?php _e('Show / hide hints', 'wpdev-booking'); ?></th>
                                            <td><input id="is_use_hints_at_admin_panel" type="checkbox" <?php if ($is_use_hints_at_admin_panel == 'On') echo "checked"; ?>  value="<?php echo $is_use_hints_at_admin_panel; ?>" name="is_use_hints_at_admin_panel"/>
                                                <span class="description"> <?php _e('Check this box if you want to show help hints on the admin panel.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        <tr valign="top"><td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td></tr>



                                        <tr valign="top"> <td colspan="2">
                                            <div style="width:100%;">
                                                <span style="color:#21759B;cursor: pointer;font-weight: bold;"
                                                   onclick="javascript: jQuery('#togle_settings_javascriptloading').slideToggle('normal');jQuery('.bk_show_advanced_settings_js').toggle('normal');"
                                                   style="text-decoration: none;font-weight: bold;font-size: 11px;">
                                                     <span class="bk_show_advanced_settings_js">+ <span style="border-bottom:1px dashed #21759B;"><?php _e('Show advanced settings of JavaScript loading', 'wpdev-booking'); ?></span></span>
                                                     <span class="bk_show_advanced_settings_js" style="display:none;">- <span style="border-bottom:1px dashed #21759B;"><?php _e('Hide advanced settings of JavaScript loading', 'wpdev-booking'); ?></span></span>

                                                </span>
                                            </div>


                                            <table id="togle_settings_javascriptloading" style="display:none;" class="hided_settings_table">

                                            <tr valign="top">
                                                <th scope="row"><label for="is_not_load_bs_script_in_client" ><?php _e('Disable Bootstrap loading', 'wpdev-booking'); ?>:</label><br><?php _e('Client side', 'wpdev-booking'); ?></th>
                                                <td><input id="is_not_load_bs_script_in_client" type="checkbox" <?php if ($is_not_load_bs_script_in_client == 'On') echo "checked"; ?>  value="<?php echo $is_not_load_bs_script_in_client; ?>" name="is_not_load_bs_script_in_client"
                                                                                                        onclick="javascript: if (this.checked) { var answer = confirm('<?php  _e('Warning','wpdev-booking'); echo '! '; _e("You are need to be sure what you are doing. You are disable of loading some JavaScripts Do you really want to do this?", 'wpdev-booking'); ?>'); if ( answer){ this.checked = true; } else {this.checked = false;} }"
                                                           />
                                                    <span class="description"><?php _e(' If your theme or some other plugin is load the BootStrap JavaScripts, you can disable  loading of this script by this plugin.', 'wpdev-booking');?></span>
                                                </td>
                                            </tr>
                                            <tr valign="top">
                                                <th scope="row"><label for="is_not_load_bs_script_in_admin" ><?php _e('Disable Bootstrap loading', 'wpdev-booking'); ?>:</label><br><?php _e('Admin  side', 'wpdev-booking'); ?></th>
                                                <td><input id="is_not_load_bs_script_in_admin" type="checkbox" <?php if ($is_not_load_bs_script_in_admin == 'On') echo "checked"; ?>  value="<?php echo $is_not_load_bs_script_in_admin; ?>" name="is_not_load_bs_script_in_admin"
                                                     onclick="javascript: if (this.checked) { var answer = confirm('<?php  _e('Warning','wpdev-booking'); echo '! '; _e("You are need to be sure what you are doing. You are disable of loading some JavaScripts Do you really want to do this?", 'wpdev-booking'); ?>'); if ( answer){ this.checked = true; } else {this.checked = false;} }"
                                                           />
                                                    <span class="description"><?php _e(' If your theme or some other plugin is load the BootStrap JavaScripts, you can disable  loading of this script by this plugin.', 'wpdev-booking');?></span>
                                                </td>
                                            </tr>

                                            </table>
                                            </td>
                                        </tr>

                                       


                                        <tr valign="top"> <td colspan="2">
                                            <div style="width:100%;">
                                                <span style="color:#21759B;cursor: pointer;font-weight: bold;"
                                                   onclick="javascript: jQuery('.bk_show_advanced_settings_powered').toggle('normal'); jQuery('#togle_settings_powered').slideToggle('normal');"
                                                   style="text-decoration: none;font-weight: bold;font-size: 11px;">
                                                     <span class="bk_show_advanced_settings_powered">+ <span style="border-bottom:1px dashed #21759B;"><?php _e('Show settings of powered by notice', 'wpdev-booking'); ?></span></span>
                                                     <span class="bk_show_advanced_settings_powered" style="display:none;">- <span style="border-bottom:1px dashed #21759B;"><?php _e('Hide settings of powered by notice', 'wpdev-booking'); ?></span></span>
                                                </span>
                                            </div>

                                            <table id="togle_settings_powered" style="display:none;" class="hided_settings_table">

                                                    <tr valign="top">
                                                        <th scope="row"><label for="booking_is_show_powered_by_notice" ><?php _e('Powered by notice', 'wpdev-booking'); ?>:</label></th>
                                                        <td><input id="booking_is_show_powered_by_notice" type="checkbox" <?php if ($booking_is_show_powered_by_notice == 'On') echo "checked"; ?>  value="<?php echo $booking_is_show_powered_by_notice; ?>" name="booking_is_show_powered_by_notice"/>
                                                            <span class="description"><?php printf(__(' Turn On/Off powered by "Booking Calendar" notice under the calendar.', 'wpdev-booking'),'wpbookingcalendar.com');?></span>
                                                        </td>
                                                    </tr>


                                                    <tr valign="top">
                                                        <th scope="row"><label for="wpdev_copyright_adminpanel" ><?php _e('Copyright notice', 'wpdev-booking'); ?>:</label></th>
                                                        <td><input id="wpdev_copyright_adminpanel" type="checkbox" <?php if ($wpdev_copyright_adminpanel == 'On') echo "checked"; ?>  value="<?php echo $wpdev_copyright_adminpanel; ?>" name="wpdev_copyright_adminpanel"/>
                                                            <span class="description"><?php printf(__(' Turn On/Off version notice at footer of booking admin panel.', 'wpdev-booking'),'wpbookingcalendar.com');?></span>
                                                        </td>
                                                    </tr>

                                            </table>
                                        </td></tr>



                            </tbody></table>
                </div></div></div>

                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_calendar'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Calendar', 'wpdev-booking'); ?></span></h3> <div class="inside">
                            <table class="form-table"><tbody>

                                        <tr valign="top">
                                            <th scope="row"><label for="booking_skin" ><?php _e('Calendar skin', 'wpdev-booking'); ?>:</label></th>
                                            <td>
                    <?php
                    $dir_list = wpdev_bk_dir_list( array(  '/css/skins/', '/inc/skins/' ) );
                    ?>
                                                <select id="booking_skin" name="booking_skin" style="text-transform:capitalize;">
                    <?php foreach ($dir_list as $value) {
                        if($booking_skin == $value[1]) $selected_item =  'selected="SELECTED"';
                        else $selected_item='';
                        if (  strpos($booking_skin, $value[0]) !== false ) $selected_item =  'selected="SELECTED"';
                        echo '<option '.$selected_item.' value="'.$value[1].'" >' .  $value[2] . '</option>';
                    } ?>
                                                </select>
                                                <span class="description"><?php _e('Select the skin of the booking calendar', 'wpdev-booking');?></span>
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
                                                <span class="description"><?php _e('Select the maximum number of months to show on the booking calendar', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        <tr valign="top">
                                            <th scope="row"><label for="start_day_weeek" ><?php _e('Start Day of the week', 'wpdev-booking'); ?>:</label></th>
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

                                        <tr valign="top"><td colspan="2" style="padding:10px 0px; "><div style="border-bottom:1px solid #cccccc;"></div></td></tr>

                                        <tr valign="top">
                                            <th scope="row"><label for="type_of_day_selections" ><?php _e('Type of days selection', 'wpdev-booking'); ?>:</label><br><?php _e('in calendar', 'wpdev-booking'); ?></th>
                                            <td><div style="height:30px;">
                                                    <input  value="single" <?php if ( ($type_of_day_selections == 'single') || (empty($type_of_day_selections)) ) echo 'checked="CHECKED"'; ?>
                                                            onclick="javascript: jQuery('#togle_settings_range_type_selection').slideUp('normal');
                                                                jQuery('.booking_time_advanced_config').slideUp('normal');
if ( jQuery('#range_selection_time_is_active').length > 0 ) { jQuery('#range_selection_time_is_active').attr('checked', false); }
if ( jQuery('#booking_recurrent_time').length > 0 )         { jQuery('#booking_recurrent_time').attr('checked', false); }
if ( jQuery('#togle_settings_range_times').length > 0 )     { jQuery('#togle_settings_range_times').slideUp('normal'); }
                                                                    "
                                                            name="type_of_day_selections" id="type_of_day_selections_single" type="radio" style="height: 22px;margin: 0 3px;vertical-align: sub;" /><label for="type_of_day_selections_single"><?php _e('Single day', 'wpdev-booking');?></label>&nbsp;&nbsp;
                                                    <input  value="multiple" <?php if ($type_of_day_selections == 'multiple')  echo 'checked="CHECKED"'; ?> 
                                                            onclick="javascript: jQuery('#togle_settings_range_type_selection').slideUp('normal');
                                                                jQuery('.booking_time_advanced_config').slideDown('normal');
                                                                "
                                                            name="type_of_day_selections" id="type_of_day_selections_multiple"  type="radio" style="height: 22px;margin: 0 3px;vertical-align: sub;" /><label for="type_of_day_selections_multiple"><?php _e('Multiple days', 'wpdev-booking');?></label>&nbsp;&nbsp;
                                                    <?php if (class_exists('wpdev_bk_biz_s')) { ?>
                                                    <input  value="range" <?php if ($type_of_day_selections == 'range')  echo 'checked="CHECKED"'; ?>
                                                            onclick="javascript: jQuery('#togle_settings_range_type_selection').slideDown('normal');
                                                                jQuery('.booking_time_advanced_config').slideDown('normal'); 
                                                                "
                                                            name="type_of_day_selections" id="type_of_day_selections_range"  type="radio" style="height: 22px;margin: 0 3px;vertical-align: sub;" /><label for="type_of_day_selections_range"><?php _e('Range days', 'wpdev-booking');?></label>
                                                    <?php } ?>
                                                </div>
                                                <span class="description"><?php _e(' Select type of days selection at calendar.', 'wpdev-booking');?></span>
                                            </td>


                                        </tr>
                                        
                                        <?php do_action('settings_advanced_set_range_selections'); ?>
                                        <?php do_action('settings_advanced_set_fixed_time'); ?>

                                        
                                        <?php do_action('settings_set_show_cost_in_tooltips'); ?>
                                        <?php do_action('settings_set_show_availability_in_tooltips');  ?>
                                        

                                        <tr valign="top">
                                            <th scope="row"><label for="unavailable_days_num_from_today" ><?php _e('Unavailable days from today', 'wpdev-booking'); ?>:</label></th>
                                            <td>
                                                <select id="unavailable_days_num_from_today" name="unavailable_days_num_from_today">
                                                    <?php  for ($i = 0; $i < 32; $i++) { ?>
                                                    <option <?php if($unavailable_days_num_from_today == $i) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php      } ?>
                                                </select>
                                                <span class="description"><?php _e('Select number of unavailable days in calendar start from today.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="is_dif_colors_approval_pending" ><?php _e('Unavailable days', 'wpdev-booking'); ?>:</label></th>
                                            <td>    <div style="float:left;width:500px;border:0px solid red;">
                                                    <input id="unavailable_day0" name="unavailable_day0" <?php if ($unavailable_day0 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day0; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Sunday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day1" name="unavailable_day1" <?php if ($unavailable_day1 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day1; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Monday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day2" name="unavailable_day2" <?php if ($unavailable_day2 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day2; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Tuesday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day3" name="unavailable_day3" <?php if ($unavailable_day3 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day3; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Wednesday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day4" name="unavailable_day4" <?php if ($unavailable_day4 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day4; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Thursday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day5" name="unavailable_day5" <?php if ($unavailable_day5 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day5; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Friday', 'wpdev-booking'); ?></span>&nbsp;
                                                    <input id="unavailable_day6" name="unavailable_day6" <?php if ($unavailable_day6 == 'On') echo "checked"; ?>  value="<?php echo $unavailable_day6; ?>"  type="checkbox" />
                                                    <span class="description"><?php _e('Saturday', 'wpdev-booking'); ?></span>
                                                </div>
                                                <div style="width:auto;margin-top:25px;">
                                                   <span class="description"><?php _e('Check unavailable days in calendars. This option is overwrite all other settings.', 'wpdev-booking');?></span></div>
                                            </td>
                                        </tr>


                            </tbody></table>
                </div></div></div>

                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_form'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Form', 'wpdev-booking'); ?></span></h3> <div class="inside">

                            
<?php /*// Is using the BootStrap CSS //////////////////////////////////////////////////////////////////////////
if (isset( $_POST['Submit'] )) {
    if (isset( $_POST['booking_form_is_using_bs_css'] )) $booking_form_is_using_bs_css = 'On';
    else                                                 $booking_form_is_using_bs_css = 'Off';
    update_bk_option( 'booking_form_is_using_bs_css',    $booking_form_is_using_bs_css );
}
$booking_form_is_using_bs_css = get_bk_option( 'booking_form_is_using_bs_css');
?>                            
<div class="control-group">
  <label for="booking_form_is_using_bs_css" class="control-label" style="font-weight:bold"><?php _e('CSS BootStrap', 'wpdev-booking'); ?>:</label>
  <div class="controls">
    <label class="checkbox">
      <input type="checkbox" name="booking_form_is_using_bs_css" id="booking_form_is_using_bs_css"
          <?php if ($booking_form_is_using_bs_css == 'On') {echo ' checked="checked" ';} ?>  
          value="<?php echo $booking_form_is_using_bs_css; ?>" >
      <?php _e('Using BootStrap CSS for the form fields', 'wpdev-booking'); ?>
    </label>
    <p class="help-block"><strong><?php _e('Note', 'wpdev-booking'); ?>:</strong> <?php _e('You must not deactivate loading BootStrap files at main section of this settings!', 'wpdev-booking'); ?></p>
  </div>
</div><?php /**/ ?>                            

                            
<?php /* if ( get_bk_version() == 'free' ) { ?>
<?php // Type of Form Format: { vertical | horizontal } ////////////////////////////////////////////////////////
if (isset( $_POST['booking_form_format_type'] ))
    update_bk_option( 'booking_form_format_type',$_POST['booking_form_format_type']);
$booking_form_format_type = get_bk_option( 'booking_form_format_type');
?>
<div class="control-group">
   <label class="control-label" style="font-weight:bold"><?php _e('Type of form format', 'wpdev-booking'); ?>:</label>
   <div class="controls">
     <label class="radio">
       <input type="radio" value="form-vertical" 
              id="booking_form_format_type_vertical" 
              name="booking_form_format_type" 
              <?php if ($booking_form_format_type == 'form-vertical') {echo ' checked="checked" ';} ?> >
       <?php _e('Stacked, left-aligned labels over controls', 'wpdev-booking'); ?>
     </label>
     <label class="radio">
       <input type="radio" value="form-horizontal" 
              id="booking_form_format_type_horizontal" 
              name="booking_form_format_type" 
              <?php if ($booking_form_format_type == 'form-horizontal') {echo ' checked="checked" ';} ?> >
       <?php _e('Float left, right-aligned labels on same line as controls', 'wpdev-booking'); ?>
     </label>
   </div>
</div>                            
<?php } /**/?>
                            
                            <table class="form-table"><tbody>

                                        <?php // Is using the BootStrap CSS //////////////////////////////////////////////////////////////////////////
                                        if (isset( $_POST['Submit'] )) {
                                            if (isset( $_POST['booking_form_is_using_bs_css'] )) $booking_form_is_using_bs_css = 'On';
                                            else                                                 $booking_form_is_using_bs_css = 'Off';
                                            update_bk_option( 'booking_form_is_using_bs_css',    $booking_form_is_using_bs_css );
                                        }
                                        $booking_form_is_using_bs_css = get_bk_option( 'booking_form_is_using_bs_css');
                                        ?> 
                                        <tr valign="top">
                                            <th scope="row"><label for="booking_form_is_using_bs_css" ><?php _e('CSS BootStrap', 'wpdev-booking'); ?>:</label><br/><?php _e('at booking form', 'wpdev-booking'); ?></th>
                                            <td><label class="checkbox">
                                                    <input type="checkbox" name="booking_form_is_using_bs_css" id="booking_form_is_using_bs_css"
                                                        <?php if ($booking_form_is_using_bs_css == 'On') {echo ' checked="checked" ';} ?>  
                                                        value="<?php echo $booking_form_is_using_bs_css; ?>" >
                                                    <span class="description"><?php _e('Using BootStrap CSS for the form fields', 'wpdev-booking'); ?></span>
                                                 </label>
                                                 <p class="help-block description"><strong><?php _e('Note', 'wpdev-booking'); ?>:</strong> <?php _e('You must not deactivate loading BootStrap files at main section of this settings!', 'wpdev-booking'); ?></p>
                                            </td>
                                        </tr>                                    
                                    
                                        <tr valign="top">
                                            <th scope="row"><label for="is_use_captcha" ><?php _e('CAPTCHA', 'wpdev-booking'); ?>:</label><br><?php _e('at booking form', 'wpdev-booking'); ?></th>
                                            <td><input id="is_use_captcha" type="checkbox" <?php if ($is_use_captcha == 'On') echo "checked"; ?>  value="<?php echo $is_use_captcha; ?>" name="is_use_captcha"/>
                                                <span class="description"><?php _e('Check the box to activate CAPTCHA inside the booking form.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        <tr valign="top">
                                            <th scope="row"><label for="is_use_autofill_4_logged_user" ><?php _e('Auto-fill fields', 'wpdev-booking'); ?>:</label><br><?php _e('for logged in users', 'wpdev-booking'); ?></th>
                                            <td><input id="is_use_autofill_4_logged_user" type="checkbox" <?php if ($is_use_autofill_4_logged_user == 'On') echo "checked"; ?>  value="<?php echo $is_use_autofill_4_logged_user; ?>" name="is_use_autofill_4_logged_user"/>
                                                <span class="description"><?php _e('Check the box to activate auto-fill fields of booking form for logged in users.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>


                                        <?php
                                        wpdev_bk_settings_legend_section();
                                        /** ?>

                                        <tr valign="top">
                                            <th scope="row"><label for="is_show_legend" ><?php _e('Show legend', 'wpdev-booking'); ?>:</label><br><?php _e('at booking calendar', 'wpdev-booking'); ?></th>
                                            <td><input id="is_show_legend" type="checkbox" <?php if ($is_show_legend == 'On') echo "checked"; ?>  value="<?php echo $is_show_legend; ?>" name="is_show_legend"/>
                                                <span class="description"> <?php _e('Check this box to display a legend of dates below the booking calendar.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr><?php /**/ ?>

                                <tr valign="top" style="padding: 0px;">


                                        <td style="width:50%;font-weight: bold;"><input  <?php if ($type_of_thank_you_message == 'message') echo 'checked="checked"';/**/ ?> value="message" type="radio" id="type_of_thank_you_message"  name="type_of_thank_you_message"  onclick="javascript: jQuery('#togle_settings_thank-you_page').slideUp('normal');jQuery('#togle_settings_thank-you_message').slideDown('normal');"  /> <label for="type_of_thank_you_message" ><?php _e('Show "thank you" message after booking is done', 'wpdev-booking'); ?></label></td>
                                        <td style="width:50%;font-weight: bold;"><input  <?php if ($type_of_thank_you_message == 'page') echo 'checked="checked"';/**/ ?> value="page" type="radio" id="type_of_thank_you_message"  name="type_of_thank_you_message"  onclick="javascript: jQuery('#togle_settings_thank-you_page').slideDown('normal');jQuery('#togle_settings_thank-you_message').slideUp('normal');"  /> <label for="type_of_thank_you_message" ><?php _e('Redirect visitor to a new "thank you" page', 'wpdev-booking'); ?> </label></td>



                                </tr>
                                <tr valign="top" style="padding: 0px;"><td colspan="2">
                                    <table id="togle_settings_thank-you_message" style="width:100%;<?php if ($type_of_thank_you_message != 'message') echo 'display:none;';/**/ ?>" class="hided_settings_table">
                                        <tr valign="top">
                                                    <th>
                                                    <label for="new_booking_title" style="font-size:12px;" ><?php _e('New booking title', 'wpdev-booking'); ?>:</label><br/>
                    <?php printf(__('%sshowing after%s booking', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                                    </th>
                                                    <td>
                                                        <input id="new_booking_title" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title; ?>" name="new_booking_title" style="width:99%;"/>
                                                        <span class="description"><?php printf(__('Type title of new booking %safter booking has done by user%s', 'wpdev-booking'),'<b>','</b>');?></span>
                                                        <?php make_bk_action('show_additional_translation_shortcode_help'); ?>
                                                    </td>
                                        </tr>
                                        <tr><th>
                                                    <label for="new_booking_title" style=" font-weight: bold;font-size: 12px;" ><?php _e('Showing title time', 'wpdev-booking'); ?>:</label><br/>
                    <?php printf(__('%snew booking%s', 'wpdev-booking'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                                    </th>
                                                <td>
                                                    <input id="new_booking_title_time" class="regular-text code" type="text" size="45" value="<?php echo $new_booking_title_time; ?>" name="new_booking_title_time" />
                                                    <span class="description"><?php printf(__('Duration of time (milliseconds) to show the new reservation title', 'wpdev-booking'),'<b>','</b>');?></span>
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

                            </tbody></table>

                </div></div></div>

                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_bktable'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Listing of bookings', 'wpdev-booking'); ?></span></h3> <div class="inside">
                            <table class="form-table"><tbody>



                                        <tr valign="top">
                                            <th scope="row"><label for="bookings_listing_default_view_mode" ><?php _e('Default booking admin page', 'wpdev-booking'); ?>:</label></th>
                                            <td>

                                                <?php   $wpdevbk_selectors = array(__('Bookings Listing', 'wpdev-booking') =>'vm_listing',
                                                                                   __('Calendar Overview', 'wpdev-booking') =>'vm_calendar'
                                                                                  ); ?>
                                                <select id="bookings_listing_default_view_mode" name="bookings_listing_default_view_mode">
                                                <?php foreach ($wpdevbk_selectors as $kk=>$mm) { ?>
                                                    <option <?php if($bookings_listing_default_view_mode == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($kk) ; ?></option>
                                                <?php } ?>
                                                </select>

                                                <span class="description"><?php _e('Select your default view mode of bookings at the booking listing page', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        <?php make_bk_action('wpdev_bk_general_settings_set_default_booking_resource'); ?>
                                        
                                        <tr valign="top"><td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td></tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="booking_view_days_num" ><?php _e('Default calendar view mode', 'wpdev-booking'); ?>:</label></th>
                                            <td>

                                                <?php   
                                                if (class_exists('wpdev_bk_personal')) {                                                
                                                     $wpdevbk_selectors = array(
                                                                                __('Day', 'wpdev-booking') =>'1',                                                                                
                                                                                __('Week', 'wpdev-booking') =>'7',
                                                    
                                                                                __('Month', 'wpdev-booking') =>'30',
                                                    
                                                                                __('2 Months', 'wpdev-booking') =>'60',
                                                    
                                                                                __('3 Months', 'wpdev-booking') =>'90',
                                                                                __('Year', 'wpdev-booking') =>'365'
                                                                          ); 
//bookings_listing_default_view_mode                                                
//default_booking_resource
                                                     
                                                } else {
                                                     $wpdevbk_selectors = array(
                                                                                __('Month', 'wpdev-booking') =>'30',
                                                                                __('3 Months', 'wpdev-booking') =>'90',
                                                                                __('Year', 'wpdev-booking') =>'365'
                                                                          );                                                     
                                                }
                                                 ?>
                                                <select id="booking_view_days_num" name="booking_view_days_num" onfocus="javascript:wpdev_bk_recheck_disabled_options();">
                                                <?php foreach ($wpdevbk_selectors as $kk=>$mm) { ?>
                                                    <option <?php if($booking_view_days_num == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($kk) ; ?></option>
                                                <?php } ?>
                                                </select>
                                                <script type="text/javascript">
                                                    // Set the correct  value of this selectbox, depend from the Matrix or Single Calendar Overview 
                                                    function wpdev_bk_recheck_disabled_options() {
                                                        if ( jQuery('#default_booking_resource').length>0 ) {
                                                            jQuery('#default_booking_resource').bind('change', function() {
                                                                jQuery('#booking_view_days_num option:eq(2)').prop("selected", true);
                                                            });
                                                            if ( jQuery('#default_booking_resource').val() == '' ) { //All resources selected
                                                                jQuery('#booking_view_days_num option:eq(0)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(1)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(2)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(3)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(4)').prop("disabled", true);
                                                                jQuery('#booking_view_days_num option:eq(5)').prop("disabled", true);
                                                            } else {
                                                                jQuery('#booking_view_days_num option:eq(0)').prop("disabled", true);
                                                                jQuery('#booking_view_days_num option:eq(1)').prop("disabled", true);
                                                                jQuery('#booking_view_days_num option:eq(2)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(3)').prop("disabled", true);
                                                                jQuery('#booking_view_days_num option:eq(4)').prop("disabled", false);
                                                                jQuery('#booking_view_days_num option:eq(5)').prop("disabled", false);                                                                
                                                            }
                                                        }
                                                    }
                                                </script>
                                                
                                                <span class="description"><?php _e('Select your default calendar view mode at booking calendar overview page', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        <?php make_bk_action('wpdev_bk_general_settings_set_default_title_in_day'); ?>

                                        <tr valign="top"><td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td></tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="booking_default_toolbar_tab" ><?php _e('Default toolbar tab', 'wpdev-booking'); ?>:</label></th>
                                            <td>

                                                <?php   $wpdevbk_selectors = array(__('Filter tab', 'wpdev-booking') =>'filter',
                                                                                   __('Actions tab', 'wpdev-booking') =>'actions'
                                                                                  ); ?>
                                                <select id="booking_default_toolbar_tab" name="booking_default_toolbar_tab">
                                                <?php foreach ($wpdevbk_selectors as $kk=>$mm) { ?>
                                                    <option <?php if($booking_default_toolbar_tab == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($kk) ; ?></option>
                                                <?php } ?>
                                                </select>

                                                <span class="description"><?php _e('Select your default opened tab in toolbar at booking listing page', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                                        
                                        <tr valign="top">
                                            <th scope="row"><label for="bookings_num_per_page" ><?php _e('Bookings number per page', 'wpdev-booking'); ?>:</label></th>
                                            <td>

                                                <?php  $order_array = array( 5, 10, 20, 25, 50, 75, 100 ); ?>
                                                <select id="bookings_num_per_page" name="bookings_num_per_page">
                                                <?php foreach ($order_array as $mm) { ?>
                                                    <option <?php if($bookings_num_per_page == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($mm) ; ?></option>
                                                <?php } ?>
                                                </select>
                                                <span class="description"><?php _e('Select number of bookings per page in booking listing', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>


                                        <tr valign="top">
                                            <th scope="row"><label for="booking_sort_order" ><?php _e('Bookings default order', 'wpdev-booking'); ?>:</label></th>
                                            <td><?php
                                                $order_array = array('ID');
                                                $wpdevbk_selectors = array(__('ID', 'wpdev-booking').'&nbsp;'.__('ASC', 'wpdev-booking') =>'',
                                                                           __('ID', 'wpdev-booking').'&nbsp;'.__('DESC', 'wpdev-booking') =>'booking_id_asc',
                                                   __('Dates', 'wpdev-booking').'&nbsp;'.__('ASC', 'wpdev-booking') =>'sort_date',
                                                   __('Dates', 'wpdev-booking').'&nbsp;'.__('DESC', 'wpdev-booking') =>'sort_date_asc',
                                                  /* __('Cost', 'wpdev-booking').'&nbsp;'.__('ASC', 'wpdev-booking') =>'cost',
                                                   __('Cost', 'wpdev-booking').'&nbsp;'.__('DESC', 'wpdev-booking') =>'cost_asc',

                                                    */
                                                  );
                                                if (class_exists('wpdev_bk_personal')) {
                                                    $order_array[]= 'Resource';

                                                    $wpdevbk_selectors[__('Resource', 'wpdev-booking').'&nbsp;'.__('ASC', 'wpdev-booking') ] = 'booking_type';
                                                    $wpdevbk_selectors[__('Resource', 'wpdev-booking').'&nbsp;'.__('DESC', 'wpdev-booking')] = 'booking_type_asc';
                                                }
                                                if (class_exists('wpdev_bk_biz_s')) {
                                                    $order_array[]= 'Cost';
                                                   $wpdevbk_selectors[__('Cost', 'wpdev-booking').'&nbsp;'.__('ASC', 'wpdev-booking')  ] ='cost';
                                                   $wpdevbk_selectors[__('Cost', 'wpdev-booking').'&nbsp;'.__('DESC', 'wpdev-booking') ] ='cost_asc';
                                                }
                                                ?>
                                                <select id="booking_sort_order" name="booking_sort_order">
                                                <?php foreach ($wpdevbk_selectors as $kk=>$mm) { ?>
                                                    <option <?php if($booking_sort_order == strtolower($mm) ) echo "selected"; ?> value="<?php echo strtolower($mm); ?>"><?php echo ($kk) ; ?></option>
                                                <?php } ?>
                                                </select>

                                                <span class="description"><?php _e('Select your default order of bookings in the booking listing', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>



                                        

                                        <tr valign="top"><td colspan="2"><div style="border-bottom:1px solid #cccccc;"></div></td></tr>
                                        
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
                                                <?php printf(__('Type your date format for emails and the booking table. %sDocumentation on date formatting.%s', 'wpdev-booking'),'<br/><a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">','</a>');?>
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
                                                <span class="description"><?php _e('Select the default view for dates on the booking tables', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                            </tbody></table>

                </div></div></div>

                <?php make_bk_action('wpdev_bk_general_settings_cost_section') ?>

                <?php make_bk_action('wpdev_bk_general_settings_pending_auto_cancelation') ?>

                <?php do_action('wpdev_bk_general_settings_advanced_section') ?>

            </div>
            <div style="width:35%; float:left;">

                <?php  $version = get_bk_version();
                if ( wpdev_bk_is_this_demo() ) $version = 'free';


                //if ( ($version !== 'free') && ($version!== 'biz_l') ) { wpdev_bk_upgrade_window($version); } ?>

                <div class='meta-box'>
                        <div <?php $my_close_open_win_id = 'bk_general_settings_info'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Information', 'wpdev-booking'); ?></span></h3>
                        <div class="inside">
                            <?php make_bk_action('dashboard_bk_widget_show'); ?>
                        </div>
                        </div>
                </div>

                <?php if ( (false) && (!class_exists('wpdev_crm')) &&  ($version != 'free') ){ ?>
                    <div class='meta-box'>
                        <div <?php $my_close_open_win_id = 'bk_general_settings_recomended_plugins'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                            <h3 class='hndle'><span><?php _e('Recommended WordPress Plugins','wpdev-booking'); ?></span></h3>
                            <div class="inside">
                                <h2 style="margin:10px;"><?php _e('Booking Manager - show all old bookings'); ?> </h2>
                                <img src="<?php echo WPDEV_BK_PLUGIN_URL . '/img/users-48x48.png'; ?>" style="float:left; padding:0px 10px 10px 0px;">

                                <p style="margin:0px;">
                            <?php printf(__('This wordpress plugin is  %sshow all approved and pending bookings from past%s. Show how many each customer is made bookings. Paid versions support %sexport to CSV, print layout, advanced filter%s. ','wpdev-booking'),'<strong>','</strong>','<strong>','</strong>'); ?> <br/>
                                </p>
                                <p style="text-align:center;padding:10px 0px;">
                                    <a href="http://wordpress.org/extend/plugins/booking-manager" class="button-primary" target="_blank">Download from wordpress</a>
                                    <a href="http://wpbookingmanager.com" class="button-primary" target="_blank">Demo site</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_users_permissions'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('User permissions for plugin menu pages', 'wpdev-booking'); ?></span></h3> <div class="inside">
                        <table class="form-table"><tbody>

                            <tr valign="top">
                                <td colspan="2">
                                    <span class="description"><?php _e('Select user access level for the menu pages of plugin', 'wpdev-booking');?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label for="start_day_weeek" ><?php _e('Bookings', 'wpdev-booking'); ?>:</label><br><?php _e('menu page', 'wpdev-booking'); ?></th>
                                <td>
                                    <select id="user_role_booking" name="user_role_booking">
                                        <option <?php if($user_role_booking == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                        <option <?php if($user_role_booking == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                        <option <?php if($user_role_booking == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                        <option <?php if($user_role_booking == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                        <option <?php if($user_role_booking == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                    </select>                                                
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
                                </td>
                            </tr>

                            <?php if  ($version !== 'free') { ?>
                                <tr valign="top">
                                    <th scope="row"><label for="user_role_resources" ><?php _e('Resources', 'wpdev-booking'); ?>:</label><br><?php _e('access level', 'wpdev-booking'); ?></th>
                                    <td>
                                        <select id="user_role_resources" name="user_role_resources">
                                            <option <?php if($user_role_resources == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                            <option <?php if($user_role_resources == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                            <option <?php if($user_role_resources == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                            <option <?php if($user_role_resources == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                            <option <?php if($user_role_resources == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr valign="top">
                                <th scope="row"><label for="start_day_weeek" ><?php _e('Settings', 'wpdev-booking'); ?>:</label><br><?php _e('access level', 'wpdev-booking'); ?></th>
                                <td>
                                    <select id="user_role_settings" name="user_role_settings">
                                        <option <?php if($booking_user_role_settings == 'subscriber') echo "selected"; ?> value="subscriber" ><?php echo translate_user_role('Subscriber'); ?></option>
                                        <option <?php if($booking_user_role_settings == 'administrator') echo "selected"; ?> value="administrator" ><?php echo translate_user_role('Administrator'); ?></option>
                                        <option <?php if($booking_user_role_settings == 'editor') echo "selected"; ?> value="editor" ><?php echo translate_user_role('Editor'); ?></option>
                                        <option <?php if($booking_user_role_settings == 'author') echo "selected"; ?> value="author" ><?php echo translate_user_role('Author'); ?></option>
                                        <option <?php if($booking_user_role_settings == 'contributor') echo "selected"; ?> value="contributor" ><?php echo translate_user_role('Contributor'); ?></option>
                                    </select>
                                    <?php if ( wpdev_bk_is_this_demo() ) { ?> <br/><span class="wpbc-demo-alert-not-allow">You do not allow to change this items because right now you test DEMO</span> <?php } ?>
                                </td>
                            </tr>
                        </tbody></table>
                </div></div></div>


                <div class='meta-box'>
                    <div <?php $my_close_open_win_id = 'bk_general_settings_uninstall'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                        <h3 class='hndle'><span><?php _e('Uninstall / deactivation', 'wpdev-booking'); ?></span></h3> <div class="inside">
                            <table class="form-table"><tbody>


                                        <tr valign="top">
                                            <th scope="row"><label for="is_delete_if_deactive" ><?php _e('Delete booking data', 'wpdev-booking'); ?>:</label><br><?php _e('when plugin deactivated', 'wpdev-booking'); ?></th>
                                            <td><input id="is_delete_if_deactive" type="checkbox" <?php if ($is_delete_if_deactive == 'On') echo "checked"; ?>  value="<?php echo $is_delete_if_deactive; ?>" name="is_delete_if_deactive"
                                                    onclick="javascript: if (this.checked) { var answer = confirm('<?php  _e('Warning','wpdev-booking'); echo '! '; _e("If you check this option, all booking data will be deleted when you uninstall this plugin. Do you really want to do this?", 'wpdev-booking'); ?>'); if ( answer){ this.checked = true; } else {this.checked = false;} }"
                                                       />
                                                <span class="description"> <?php _e('Check this box to delete all booking data when you uninstal this plugin.', 'wpdev-booking');?></span>
                                            </td>
                                        </tr>

                            </tbody></table>
                </div></div></div>

                <?php make_bk_action('wpdev_booking_technical_booking_section'); ?>
                
            </div>

            <div class="clear" style="height:10px;"></div>
            <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save Changes', 'wpdev-booking'); ?>" name="Submit"/>
            <div class="clear" style="height:10px;"></div>
        </form>
        </div>    
        <?php
    }

    // Show window for upgrading
    function wpdev_bk_upgrade_window($version) {
        if ( ! wpdev_bk_is_this_demo() ) {
        ?>
            <div class='meta-box'>
                <div <?php $my_close_open_win_id = 'bk_general_settings_upgrade'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="gdrgrid postbox <?php //if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <?php /*<div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>*/ ?>
                <h3 class='hndle'><span><span>Upgrade to <?php if ( ($version == 'personal') ) { ?>Business Small /<?php } ?><?php if (in_array($version, array('personal','biz_s') )) { ?> Business Medium /<?php } ?> Business Large</span></span></h3>
                <div class="inside">

                    <div style="width:100%;border:none; clear:both;margin:10px 0px;" id="bk_news_section"> 
                            <div id="bk_news"><span style="font-size:11px;text-align:center;">Loading...</span></div>
                            <div id="ajax_bk_respond" style=""></div>
                                    <?php /*
                                    $response = wp_remote_post( OBC_CHECK_URL . 'info/', array() );

                                    if (! ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) ) {

                                        $body_to_show = json_decode( wp_remote_retrieve_body( $response ) );

                                        ?><!--style type="text/css" media="screen">#bk_news_loaded{display:block !important;}</style--><?php

                                        echo $body_to_show ;
                                    }*/
                                    ?>                    
                            <script type="text/javascript">
                                jQuery.ajax({                                           // Start Ajax Sending
                                    url: '<?php echo WPDEV_BK_PLUGIN_URL , '/' ,  WPDEV_BK_PLUGIN_FILENAME ; ?>' ,
                                    type:'POST',
                                    success: function (data, textStatus){if( textStatus == 'success')   jQuery('#ajax_bk_respond').html( data );},
                                    error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;
                                    },                            
                                    data:{
                                        ajax_action : 'CHECK_BK_FEATURES',
                                        wpbc_nonce: document.getElementById('wpbc_admin_panel_nonce').value         
                                    }
                                });
                            </script>                           

                    </div>
                    <?php if( strpos( strtolower(WPDEV_BK_VERSION) , 'multisite') !== false  ) {
                        $multiv = '-multi';
                    } else if( strpos( strtolower(WPDEV_BK_VERSION) , 'develop') !== false  ) {
                        $multiv = '-develop';
                    } else {
                        $multiv = '';
                    }  ?>

                    <p style="line-height:25px;text-align:center;padding-top:15px;" class="wpdevbk">
                    <?php if ( ($version == 'personal') ) { ?>
                        <a href="http://wpbookingcalendar.com/upgrade-pro<?php echo $multiv ?>/" target="_blank" class="btn">Upgrade</a>
                    <?php } elseif ( ($version == 'biz_s') ) { ?>
                        <a href="http://wpbookingcalendar.com/upgrade-premium<?php echo $multiv ?>/" target="_blank" class="btn">Upgrade</a>
                    <?php } elseif ( ($version == 'biz_m') ) { ?>
                        <a href="http://wpbookingcalendar.com/upgrade-premium-plus<?php echo $multiv ?>/" target="_blank" class="btn">Upgrade</a>
                    <?php } ?>
                    </p>    

                </div>
                </div>
            </div>
         <?php
        }
    }

    // S e t t i n g s /////////////////////////////////////////////////////
    //
    // Settings for selecting default booking resource
    function wpdev_bk_settings_legend_section(){
            if (isset($_POST['booking_legend_text_for_item_available'])) {

                if (isset( $_POST['booking_is_show_legend'] ))      $booking_is_show_legend = 'On';
                else                                                $booking_is_show_legend = 'Off';
                update_bk_option( 'booking_is_show_legend' ,        $booking_is_show_legend );

                if (isset( $_POST['booking_legend_is_show_item_available'] ))   $booking_legend_is_show_item_available = 'On';
                else                                                            $booking_legend_is_show_item_available = 'Off';
                update_bk_option( 'booking_legend_is_show_item_available' ,     $booking_legend_is_show_item_available );
                update_bk_option( 'booking_legend_text_for_item_available' ,  $_POST['booking_legend_text_for_item_available'] );

                if (isset( $_POST['booking_legend_is_show_item_pending'] ))   $booking_legend_is_show_item_pending = 'On';
                else                                                            $booking_legend_is_show_item_pending = 'Off';
                update_bk_option( 'booking_legend_is_show_item_pending' ,     $booking_legend_is_show_item_pending );
                update_bk_option( 'booking_legend_text_for_item_pending' ,  $_POST['booking_legend_text_for_item_pending'] );

                if (isset( $_POST['booking_legend_is_show_item_approved'] ))   $booking_legend_is_show_item_approved = 'On';
                else                                                            $booking_legend_is_show_item_approved = 'Off';
                update_bk_option( 'booking_legend_is_show_item_approved' ,     $booking_legend_is_show_item_approved );
                update_bk_option( 'booking_legend_text_for_item_approved' ,  $_POST['booking_legend_text_for_item_approved'] );

                if ( class_exists('wpdev_bk_biz_s') ) {
                    if (isset( $_POST['booking_legend_is_show_item_partially'] ))   $booking_legend_is_show_item_partially = 'On';
                    else                                                            $booking_legend_is_show_item_partially = 'Off';
                    update_bk_option( 'booking_legend_is_show_item_partially' ,     $booking_legend_is_show_item_partially );
                    update_bk_option( 'booking_legend_text_for_item_partially' ,  $_POST['booking_legend_text_for_item_partially'] );
                }
            }
            $booking_is_show_legend   = get_bk_option( 'booking_is_show_legend');

            $booking_legend_is_show_item_available    = get_bk_option( 'booking_legend_is_show_item_available');
            $booking_legend_text_for_item_available   = get_bk_option( 'booking_legend_text_for_item_available');

            $booking_legend_is_show_item_pending    = get_bk_option( 'booking_legend_is_show_item_pending');
            $booking_legend_text_for_item_pending   = get_bk_option( 'booking_legend_text_for_item_pending');

            $booking_legend_is_show_item_approved    = get_bk_option( 'booking_legend_is_show_item_approved');
            $booking_legend_text_for_item_approved   = get_bk_option( 'booking_legend_text_for_item_approved');

            if ( class_exists('wpdev_bk_biz_s') ) {                
                $booking_legend_is_show_item_partially    = get_bk_option( 'booking_legend_is_show_item_partially');
                $booking_legend_text_for_item_partially   = get_bk_option( 'booking_legend_text_for_item_partially');
            }
         ?>
               <tr valign="top" class="ver_premium_plus">
                    <th scope="row">
                        <label for="booking_is_show_legend" ><?php _e('Display legend below calendar', 'wpdev-booking'); ?>:</label>
                    </th>
                    <td>
                        <input <?php if ($booking_is_show_legend == 'On') echo "checked";/**/ ?>  value="<?php echo $booking_is_show_legend; ?>" name="booking_is_show_legend" id="booking_is_show_legend" type="checkbox"
                             onclick="javascript: if (this.checked) jQuery('#togle_settings_show_legend').slideDown('normal'); else  jQuery('#togle_settings_show_legend').slideUp('normal');"
                                                                                                          />
                        <span class="description"> <?php _e('Check this box to display a legend of dates below the booking calendar.', 'wpdev-booking');?></span>
                    </td>
                </tr>

                <tr valign="top" class="ver_premium_plus"><td colspan="2">
                    <table id="togle_settings_show_legend" style="<?php if ($booking_is_show_legend != 'On') echo "display:none;";/**/ ?>" class="hided_settings_table">

                        <tr>
                            <th scope="row"><label for="booking_legend_is_show_item_available" ><?php _e('Available item', 'wpdev-booking'); ?>:</label></th>
                            <td>
                                <input <?php if ($booking_legend_is_show_item_available == 'On') echo "checked"; ?>  type="checkbox"
                                    value="<?php echo $booking_legend_is_show_item_available; ?>"
                                    name="booking_legend_is_show_item_available"  id="booking_legend_is_show_item_available"  />&nbsp;
                                <input value="<?php echo $booking_legend_text_for_item_available; ?>" name="booking_legend_text_for_item_available" id="booking_legend_text_for_item_available"  type="text"    />
                                <span class="description"><?php printf(__('Activate and type your %stitle of available%s item in legend', 'wpdev-booking'),'<b>','</b>');?></span>
                                <?php //make_bk_action('show_additional_translation_shortcode_help'); ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="booking_legend_is_show_item_pending" ><?php _e('Pending item', 'wpdev-booking'); ?>:</label></th>
                            <td>
                                <input <?php if ($booking_legend_is_show_item_pending == 'On') echo "checked"; ?>  type="checkbox"
                                    value="<?php echo $booking_legend_is_show_item_pending; ?>"
                                    name="booking_legend_is_show_item_pending"  id="booking_legend_is_show_item_pending"  />&nbsp;
                                <input value="<?php echo $booking_legend_text_for_item_pending; ?>" name="booking_legend_text_for_item_pending" id="booking_legend_text_for_item_pending"  type="text"    />
                                <span class="description"><?php printf(__('Activate and type your %stitle of pending%s item in legend', 'wpdev-booking'),'<b>','</b>');?></span>
                                <?php //make_bk_action('show_additional_translation_shortcode_help'); ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="booking_legend_is_show_item_approved" ><?php _e('Approved item', 'wpdev-booking'); ?>:</label></th>
                            <td>
                                <input <?php if ($booking_legend_is_show_item_approved == 'On') echo "checked"; ?>  type="checkbox"
                                    value="<?php echo $booking_legend_is_show_item_approved; ?>"
                                    name="booking_legend_is_show_item_approved"  id="booking_legend_is_show_item_approved"  />&nbsp;
                                <input value="<?php echo $booking_legend_text_for_item_approved; ?>" name="booking_legend_text_for_item_approved" id="booking_legend_text_for_item_approved"  type="text"    />
                                <span class="description"><?php printf(__('Activate and type your %stitle of approved%s item in legend', 'wpdev-booking'),'<b>','</b>');?></span>
                                <?php //make_bk_action('show_additional_translation_shortcode_help'); ?>
                            </td>
                        </tr>
                        <?php if ( class_exists('wpdev_bk_biz_s') ) { ?>
                            <tr>
                                <th scope="row"><label for="booking_legend_is_show_item_partially" ><?php _e('Partially booked item', 'wpdev-booking'); ?>:</label></th>
                                <td>
                                    <input <?php if ($booking_legend_is_show_item_partially == 'On') echo "checked"; ?>  type="checkbox"
                                        value="<?php echo $booking_legend_is_show_item_partially; ?>"
                                        name="booking_legend_is_show_item_partially"  id="booking_legend_is_show_item_partially"  />&nbsp;
                                    <input value="<?php echo $booking_legend_text_for_item_partially; ?>" name="booking_legend_text_for_item_partially" id="booking_legend_text_for_item_partially"  type="text"    />
                                    <span class="description"><?php printf(__('Activate and type your %stitle of partially booked%s item in legend', 'wpdev-booking'),'<b>','</b>');?></span>
                                    <?php //make_bk_action('show_additional_translation_shortcode_help'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                <?php make_bk_action('show_additional_translation_shortcode_help'); ?>
                            </td>
                        </tr>


                    </table>
                </td></tr>
                <tr valign="top"><td colspan="2" style="padding:0px 0px 10px;"><div style="border-bottom:1px solid #cccccc;"></div></td></tr>
        <?php
    }

    
        function wpdev_bk_settings_form_labels(){ 
            ?>
            <div class="clear" style="height:0px;"></div>
            <div id="ajax_working"></div>
            <div id="poststuff" class="metabox-holder wpdevbk">
                <form  name="post_settings_form_fields" action="" method="post" id="post_settings_form_fields" class="form-horizontal">
                
                  <div id="visibility_container_form_fields" class="visibility_container" style="display:block;">
                    <div class='meta-box'>
                        <div <?php $my_close_open_win_id = 'bk_settings_form_fields'; ?>  id="<?php echo $my_close_open_win_id; ?>" class="postbox <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_win_id ) ) echo 'closed'; ?>" > <div title="<?php _e('Click to toggle','wpdev-booking'); ?>" class="handlediv"  onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_win_id; ?>');"><br></div>
                            <h3 class='hndle'><span><?php _e('Form fields labels', 'wpdev-booking'); ?></span></h3><div class="inside">

                                
                                <?php // FIELD # 1 //////////////////////////////////////////////////////////////////////////////////////////////////////////
                                if (isset( $_POST['Submit'] )) {
                                    
                                    if (isset( $_POST['booking_form_field_active1'] )) $booking_form_field_active1 = 'On';
                                    else                                               $booking_form_field_active1 = 'Off';
                                    update_bk_option( 'booking_form_field_active1',    $booking_form_field_active1 );
                                
                                    if (isset( $_POST['booking_form_field_required1'] )) $booking_form_field_required1 = 'On';
                                    else                                                 $booking_form_field_required1 = 'Off';
                                    update_bk_option( 'booking_form_field_required1',    $booking_form_field_required1 );
                                
                                    update_bk_option( 'booking_form_field_label1',    $_POST['booking_form_field_label1'] );
                                }
                                $booking_form_field_active1 = get_bk_option( 'booking_form_field_active1');
                                $booking_form_field_required1 = get_bk_option( 'booking_form_field_required1');
                                $booking_form_field_label1 = get_bk_option( 'booking_form_field_label1');

                                ?>
                                <div class="control-group">
                                  <label for="name" class="control-label" style="font-weight:bold;"><?php _e('Field Label', 'wpdev-booking'); ?> #1:</label>
                                  <div class="controls"> 
                                      
                                    <input type="text" class="input-xlarge" 
                                           name="booking_form_field_label1" value="<?php echo $booking_form_field_label1; ?>">&nbsp;&nbsp;&nbsp;
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_active1"
                                            <?php if ($booking_form_field_active1 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_active1; ?>" >
                                        <?php _e('Active', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_required1"
                                            <?php if ($booking_form_field_required1 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_required1; ?>" >
                                        <?php _e('Required', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <p class="help-block"><?php _e('Activate or deactivate field and change the label title', 'wpdev-booking'); ?></p>
                                  </div>
                                </div>

                                <?php // FIELD # 2 //////////////////////////////////////////////////////////////////////////////////////////////////////////
                                if (isset( $_POST['Submit'] )) {
                                    
                                    if (isset( $_POST['booking_form_field_active2'] )) $booking_form_field_active2 = 'On';
                                    else                                               $booking_form_field_active2 = 'Off';
                                    update_bk_option( 'booking_form_field_active2',    $booking_form_field_active2 );
                                
                                    if (isset( $_POST['booking_form_field_required2'] )) $booking_form_field_required2 = 'On';
                                    else                                                 $booking_form_field_required2 = 'Off';
                                    update_bk_option( 'booking_form_field_required2',    $booking_form_field_required2 );
                                
                                    update_bk_option( 'booking_form_field_label2',    $_POST['booking_form_field_label2'] );
                                }
                                $booking_form_field_active2 = get_bk_option( 'booking_form_field_active2');
                                $booking_form_field_required2 = get_bk_option( 'booking_form_field_required2');
                                $booking_form_field_label2 = get_bk_option( 'booking_form_field_label2');

                                ?>
                                <div class="control-group">
                                  <label for="name" class="control-label" style="font-weight:bold;"><?php _e('Field Label', 'wpdev-booking'); ?> #2:</label>
                                  <div class="controls"> 
                                      
                                    <input type="text" class="input-xlarge" 
                                           name="booking_form_field_label2" value="<?php echo $booking_form_field_label2; ?>">&nbsp;&nbsp;&nbsp;
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_active2"
                                            <?php if ($booking_form_field_active2 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_active2; ?>" >
                                        <?php _e('Active', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_required2"
                                            <?php if ($booking_form_field_required2 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_required2; ?>" >
                                        <?php _e('Required', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <p class="help-block"><?php _e('Activate or deactivate field and change the label title', 'wpdev-booking'); ?></p>
                                  </div>
                                </div>

                                <?php // FIELD # 3 //////////////////////////////////////////////////////////////////////////////////////////////////////////
                                if (isset( $_POST['Submit'] )) {
                                    
                                    //if (isset( $_POST['booking_form_field_active3'] )) $booking_form_field_active3 = 'On';
                                    //else                                               $booking_form_field_active3 = 'Off';
                                    $booking_form_field_active3 = 'On';
                                    update_bk_option( 'booking_form_field_active3',    $booking_form_field_active3 );
                                
                                    //if (isset( $_POST['booking_form_field_required3'] )) $booking_form_field_required3 = 'On';
                                    //else                                                 $booking_form_field_required3 = 'Off';
                                    $booking_form_field_required3 = 'On';
                                    update_bk_option( 'booking_form_field_required3',    $booking_form_field_required3 );
                                
                                    update_bk_option( 'booking_form_field_label3',    $_POST['booking_form_field_label3'] );
                                }
                                $booking_form_field_active3 = get_bk_option( 'booking_form_field_active3');
                                $booking_form_field_required3 = get_bk_option( 'booking_form_field_required3');
                                $booking_form_field_label3 = get_bk_option( 'booking_form_field_label3');

                                ?>
                                <div class="control-group">
                                  <label for="name" class="control-label" style="font-weight:bold;"><?php _e('Email Label', 'wpdev-booking'); ?>:</label>
                                  <div class="controls"> 
                                      
                                    <input type="text" class="input-xlarge" 
                                           name="booking_form_field_label3" value="<?php echo $booking_form_field_label3; ?>">&nbsp;&nbsp;&nbsp;
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_active3" disabled=""
                                            <?php if (($booking_form_field_active3 == 'On') || (true)) {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_active3; ?>" >
                                        <?php _e('Active', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_required3" disabled=""
                                            <?php if (($booking_form_field_required3 == 'On') || (true)) {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_required3; ?>" >
                                        <?php _e('Required', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <p class="help-block"><?php _e('Change the label title of this field. Email is obligatory field in booking form.', 'wpdev-booking'); ?></p>
                                  </div>
                                </div>

                                <?php // FIELD # 4 //////////////////////////////////////////////////////////////////////////////////////////////////////////
                                if (isset( $_POST['Submit'] )) {
                                    
                                    if (isset( $_POST['booking_form_field_active4'] )) $booking_form_field_active4 = 'On';
                                    else                                               $booking_form_field_active4 = 'Off';
                                    update_bk_option( 'booking_form_field_active4',    $booking_form_field_active4 );
                                
                                    if (isset( $_POST['booking_form_field_required4'] )) $booking_form_field_required4 = 'On';
                                    else                                                 $booking_form_field_required4 = 'Off';
                                    update_bk_option( 'booking_form_field_required4',    $booking_form_field_required4 );
                                
                                    update_bk_option( 'booking_form_field_label4',    $_POST['booking_form_field_label4'] );
                                }
                                $booking_form_field_active4 = get_bk_option( 'booking_form_field_active4');
                                $booking_form_field_required4 = get_bk_option( 'booking_form_field_required4');
                                $booking_form_field_label4 = get_bk_option( 'booking_form_field_label4');

                                ?>
                                <div class="control-group">
                                  <label for="name" class="control-label" style="font-weight:bold;"><?php _e('Field Label', 'wpdev-booking'); ?> #4:</label>
                                  <div class="controls"> 
                                      
                                    <input type="text" class="input-xlarge" 
                                           name="booking_form_field_label4" value="<?php echo $booking_form_field_label4; ?>">&nbsp;&nbsp;&nbsp;
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_active4"
                                            <?php if ($booking_form_field_active4 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_active4; ?>" >
                                        <?php _e('Active', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_required4"
                                            <?php if ($booking_form_field_required4 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_required4; ?>" >
                                        <?php _e('Required', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <p class="help-block"><?php _e('Activate or deactivate field and change the label title', 'wpdev-booking'); ?></p>
                                  </div>
                                </div>

                                <?php // FIELD # 5 //////////////////////////////////////////////////////////////////////////////////////////////////////////
                                if (isset( $_POST['Submit'] )) {
                                    
                                    if (isset( $_POST['booking_form_field_active5'] )) $booking_form_field_active5 = 'On';
                                    else                                               $booking_form_field_active5 = 'Off';
                                    update_bk_option( 'booking_form_field_active5',    $booking_form_field_active5 );
                                
                                    if (isset( $_POST['booking_form_field_required5'] )) $booking_form_field_required5 = 'On';
                                    else                                                 $booking_form_field_required5 = 'Off';
                                    update_bk_option( 'booking_form_field_required5',    $booking_form_field_required5 );
                                
                                    update_bk_option( 'booking_form_field_label5',    $_POST['booking_form_field_label5'] );
                                }
                                $booking_form_field_active5 = get_bk_option( 'booking_form_field_active5');
                                $booking_form_field_required5 = get_bk_option( 'booking_form_field_required5');
                                $booking_form_field_label5 = get_bk_option( 'booking_form_field_label5');

                                ?>
                                <div class="control-group">
                                  <label for="name" class="control-label" style="font-weight:bold;"><?php _e('Textarea Label', 'wpdev-booking'); ?>:</label>
                                  <div class="controls"> 
                                      
                                    <input type="text" class="input-xlarge" 
                                           name="booking_form_field_label5" value="<?php echo $booking_form_field_label5; ?>">&nbsp;&nbsp;&nbsp;
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_active5"
                                            <?php if ($booking_form_field_active5 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_active5; ?>" >
                                        <?php _e('Active', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <label class="checkbox inline">
                                        <input type="checkbox"  name="booking_form_field_required5"
                                            <?php if ($booking_form_field_required5 == 'On') {echo ' checked="checked" ';} ?>  
                                            value="<?php echo $booking_form_field_required5; ?>" >
                                        <?php _e('Required', 'wpdev-booking'); ?>
                                    </label> 
                                    
                                    <p class="help-block"><?php _e('Activate or deactivate field and change the label title', 'wpdev-booking'); ?></p>
                                  </div>
                                </div>


                     </div></div></div>
                  </div>

                  <div <?php $my_close_open_alert_id = 'bk_alert_settings_form_in_free'; ?>
                      class="alert alert-block alert-info <?php if ( '1' == get_user_option( 'booking_win_' . $my_close_open_alert_id ) ) echo 'closed'; ?>"                             
                      id="<?php echo $my_close_open_alert_id; ?>">
                    <a class="close tooltip_left" rel="tooltip" title="Don't show the message anymore" data-dismiss="alert" href="#"
                       onclick="javascript:verify_window_opening(<?php echo get_bk_current_user_id(); ?>, '<?php echo $my_close_open_alert_id; ?>');"
                       >&times;</a>
                    <strong class="alert-heading">Note!</strong>
                        Check how in <a href="http://wpbookingcalendar.com/help/versions-overview/" target="_blank" style="text-decoration:underline;">other versions of Booking Calendar</a> is possible fully <a href="http://wpbookingcalendar.com/help/booking-form-fields/" target="_blank" style="text-decoration:underline;">customize the booking form</a> <em>(add or remove fields, change structure of booking form, etc...)</em>
                         
                  </div>
                    
                    
                  <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save', 'wpdev-booking'); ?>" name="Submit" />
                  <div class="clear" style="height:10px;"></div>
                  
                </form>
            </div>
         <?php
        }    
?>
