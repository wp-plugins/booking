<?php if (  (! isset( $_GET['merchant_return_link'] ) ) && (! isset( $_GET['payed_booking'] ) ) && (!function_exists ('get_option')  )  ) { die('You do not have permission to direct access to this file !!!'); }

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
                    $mail_body_to_send = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.site_url().'">' . site_url() . '</a>'), $mail_body_to_send);
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
                    $mail_body_to_send = str_replace('[siteurl]', htmlspecialchars_decode( '<a href="'.site_url().'">' . site_url() . '</a>'), $mail_body_to_send);
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


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  D e b u g    f u n c t i o n s       ///////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    if (!function_exists ('debuge')) {
        function debuge() {
            $numargs = func_num_args();
            $var = func_get_args();
            $makeexit = is_bool($var[count($var)-1])?$var[count($var)-1]:false;
            echo "<div style='text-align:left;background:#ffffff;border: 1px dashed #ff9933;font-size:11px;line-height:15px;font-family:'Lucida Grande',Verdana,Arial,'Bitstream Vera Sans',sans-serif;'><pre style='white-space:pre-wrap;font:10px Verdana;line-height:16px;'>";
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


            $last_db_error = '';
            global $EZSQL_ERROR;
            if (isset($EZSQL_ERROR[ (count($EZSQL_ERROR)-1)])) {

                $last_db_error2 = $EZSQL_ERROR[ (count($EZSQL_ERROR)-1)];

                if  ( (isset($last_db_error2['query'])) && (isset($last_db_error2['error_str'])) ) {

                    $query = $last_db_error2['query'];
                    $str   = str_replace('','',$last_db_error2['error_str']);
                    $str   = str_replace('"','', $str );     $str   = str_replace("'",'', $str );
                    $query   = str_replace('"','', $query ); $query   = str_replace("'",'', $query );

                    $str   = htmlspecialchars( $str, ENT_QUOTES );
                    $query = htmlspecialchars( $query , ENT_QUOTES );


                    //$last_db_error = '<p class="wpdberror"><strong>Last error:</strong> ['.$str.']<br /><code>'.$query.'</code></p>';
                    $last_db_error =  $str ;
                    if ( WP_BK_DEBUG_MODE )
                        $last_db_error .= '::<span style="color:#300;">'.$query.'</span>';
                }
            }
            echo $msg . '<br /><span style="font-size:11px;"> [F:' .  str_replace( dirname( $file_name ) , '' , $file_name ). "|L:" .  $line_num  . "|V:" .  $ver_num  . "|DB:" .  $last_db_error  ."] </span>" ;



        }
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  Internal plugin action hooks system      ///////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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



    //   Load locale          //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (!function_exists ('load_bk_Translation')) {
    function load_bk_Translation(){
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
?>