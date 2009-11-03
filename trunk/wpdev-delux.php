<?php

/*
THIS IS COMMERCIAL SOFTWARE. You must own a license to use this plugin !!!
This file license is per 1 site usage.
You should not edit and/or (re)distribute this file.
If you want to have customization, please contact by email - call_customization@wpdevelop.com
If you do not have licence for this script, please buy it -  call_buy@wpdevelop.com
*/

if (!class_exists('wpdev_bk_paypal')) {
    class wpdev_bk_paypal {

        // Constructor
        function wpdev_bk_paypal() {

            add_filter('wpdev_booking_form', array(&$this, 'add_paypal_form'));                     // Filter for inserting paypal form
            add_action('wpdev_new_booking', array(&$this, 'show_paypal_form_in_ajax_request'),1,3); // Make showing Paypal in Ajax

            add_action('wpdev_bk_general_settings_end', array(&$this, 'show_general_settings'));    // Write General Settings

            add_action('wpdev_bk_js_define_variables', array(&$this, 'js_define_variables') );      // Write JS variables
            add_action('wpdev_bk_js_write_files', array(&$this, 'js_write_files') );                // Write JS files

        }

     //   S U P P O R T     F U N C T I O N S    //////////////////////////////////////////////////////////////////////////////////////////////////

        // Get booking types from DB
        function get_booking_type($booking_id) {
            global $wpdb;
            $types_list = $wpdb->get_results( "SELECT title, cost FROM ".$wpdb->prefix ."bookingtypes  WHERE booking_type_id = " . $booking_id );
            return $types_list;
        }

        // Get booking types from DB
        function get_booking_types() {
            global $wpdb;
            $types_list = $wpdb->get_results( "SELECT booking_type_id as id, title, cost FROM ".$wpdb->prefix ."bookingtypes  ORDER BY title" );
            return $types_list;
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


     //   C L I E N T     S I D E    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Define JavaScript variables
        function js_define_variables(){
            ?>
                    <script  type="text/javascript">
                        var days_select_count= <?php echo get_option( 'booking_range_selection_days_count'); ?>;
                        var range_start_day= <?php echo get_option( 'booking_range_start_day'); ?>;
                        <?php if ( get_option( 'booking_range_selection_is_active') == 'On' ) { ?>
                            var is_select_range = 1;
                        <?php } else { ?>
                            var is_select_range = 0;
                        <?php }  ?>
                    </script>
            <?php
        }

        // Write JS files
        function js_write_files(){
            ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/include/js/wpdev.bk.delux.js"></script>  <?php
        }

        // Add Paypal place for inserting to the Booking FORM
        function add_paypal_form($form_content) {

            $paypal_is_active            =  get_option( 'booking_paypal_is_active' );
            if ($paypal_is_active == 'Off') return $form_content ;
            if (strpos($_SERVER['REQUEST_URI'],'booking.php')!==false) return $form_content ;

            $str_start = strpos($form_content, 'booking_form');
            $str_fin = strpos($form_content, '"', $str_start);

            $my_boook_type = substr($form_content,$str_start, ($str_fin-$str_start) );

            $form_content .= '<div  id="paypal'.$my_boook_type.'"></div>';
            return $form_content;
        }

        // Show Paypal form from Ajax request
        function show_paypal_form_in_ajax_request($booking_id, $booking_type, $booking_days_count ){

                    $paypal_is_active            =  get_option( 'booking_paypal_is_active' );
                    if ($paypal_is_active == 'Off') return 0 ;

                    $days_array = explode(',', $booking_days_count);
                    $days_count = count($days_array);

                    $paypal_emeil               =  get_option( 'booking_paypal_emeil' );
                    $paypal_curency             =  get_option( 'booking_paypal_curency' );
                    $paypal_subject             =  get_option( 'booking_paypal_subject' );
                    $paypal_is_reference_box    =  get_option( 'booking_paypal_is_reference_box' );           // checkbox
                    $paypal_reference_title_box =  get_option( 'booking_paypal_reference_title_box' );
                    $paypal_return_url          =  get_option( 'booking_paypal_return_url' );
                    $paypal_button_type         =  get_option( 'booking_paypal_button_type' );  // radio

                    $bk_title = $this->get_booking_type($booking_type);

                    $paypal_subject = str_replace('[bookingname]',$bk_title[0]->title,$paypal_subject);
                    $paypal_subject = str_replace('[dates]',$booking_days_count,$paypal_subject);

                    //$paypal_subject .= ' Booking type: ' . $bk_title[0]->title . '. For period: ' . $booking_days_count;


                    $output .= '<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" style="text-align:left;"> <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" /> ';
                    $output .= "<input type=\"hidden\" name=\"business\" value=\"$paypal_emeil\" />";
                    $output .= "<input type=\"hidden\" name=\"item_name\" value=\"$paypal_subject\" />";
                    $output .= "<input type=\"hidden\" name=\"currency_code\" value=\"$paypal_curency\" />";
                    //$output .= "<span style=\"font-size:10.0pt\"><strong> $paypal_subject</strong></span><br /><br />";

                    $paypal_dayprice = $bk_title[0]->cost;

                    $output .= "<strong>".__('Cost')." : ". (1* $paypal_dayprice * $days_count ) ." " . $paypal_curency ."</strong><br/>";
                    $output .= '<input type=\"hidden\" name=\"amount\" size=\"10\" title=\"Cost\" value=\"'. (1* $paypal_dayprice * $days_count ) .'\" />';

                    // Show the reference text box
                    if ($paypal_is_reference_box == 'On') {
                        $output .= "<br/><strong> $paypal_reference_title_box :</strong>";
                        $output .= '<input type=\"hidden\" name=\"on0\" value=\"Reference\" />';
                        $output .= '<input type=\"text\" name=\"os0\" maxlength=\"60\" /><br/><br/>';
                    }

                    $output .= '<input type=\"hidden\" name=\"no_shipping\" value=\"2\" /> <input type=\"hidden\" name=\"no_note\" value=\"1\" /> <input type=\"hidden\" name=\"mrb\" value=\"3FWGC6LFTMTUG\" /> <input type=\"hidden\" name=\"bn\" value=\"IC_Sample\" /> ';
                    if (!empty($paypal_return_url))  {   $output .= '<input type=\"hidden\" name=\"return\" value=\"'.$paypal_return_url.'\" />'; }
                    else    {                           $output .='<input type=\"hidden\" name=\"return\" value=\"'. get_bloginfo('home') .'\" />'; }

                    $output .= "<input type=\"image\" src=\"$paypal_button_type\" name=\"submit\" style=\"border:none;\" alt=\"".__('Make payments with payPal - its fast, free and secure!')."\" />";
                    $output .= '</form>';

                    $output = str_replace("'",'"',$output);
          ?>
                    <script type="text/javascript">
                       document.getElementById('submiting<?php echo $booking_type; ?>').innerHTML ='';
                       document.getElementById('paypalbooking_form<?php echo $booking_type; ?>').innerHTML = '<div class=\"\" style=\"height:200px;margin:20px 0px;\" ><?php echo $output; ?></div>';
                    </script>
          <?php
        }

 
     //   A D M I N     S I D E    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Show settings page depends from selecting TAB
        function check_settings(){
                ?>
                <?php if ($_GET['tab'] == 'paypal') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
                 | <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=paypal" class="<?php echo $slct_a; ?>"><?php _e('Paypal and cost customization'); ?></a>
                 <div style="height:10px;clear:both;border-bottom:1px solid #cccccc;"></div>
                <?php
                    switch ($_GET['tab']) {

                       case 'paypal':
                        $this->show_settings_content();
                        return false;
                        break;

                     default:
                        return true;
                        break;
                    }


            }


        // Show Settings page booking cost window
        function show_booking_types_cost(){
            if ( isset( $_POST['submit_costs'] ) ) {
                $bk_types = $this->get_booking_types();
                global $wpdb;
                foreach ($bk_types as $bt) {
                    if ( false === $wpdb->query( "UPDATE ".$wpdb->prefix ."bookingtypes SET cost = '".$_POST['type_price'.$bt->id]."' WHERE booking_type_id = " .  $bt->id) ) {
                           echo __('Error during updating to DB booking costs');  
                    }
                }
            } ?>

                      <div class='meta-box'>  <div  class="postbox" > <h3 class='hndle'><span><?php _e('Cost of each booking type'); ?></span></h3> <div class="inside">

                            <form  name="post_option_cost" action="" method="post" id="post_option_cost" >

                                <?php
                                    $bk_types = $this->get_booking_types();
                                    foreach ($bk_types as $bt) { ?>
                                        <div style="float:left; border:0px solid grey; margin:0px; padding:10px">
                                            <strong><?php echo $bt->title; ?> </strong>:
                                            <input  style="width:70px;" maxlength="7" type="text" value="<?php echo $bt->cost; ?>" name="type_price<?php echo $bt->id; ?>" id="type_price<?php echo $bt->id; ?>">
                                        </div>
                                    <?php
                                    }
                                ?>
                                <div class="clear" style="height:10px;"></div>
                                 <span class="description"><?php printf(__('Please, enter %scost of 1 day%s of each booking property. Enter only digits.'),'<span style="color:#ff5533;font-weight:bold;">','</span>');?></span>
                                 <div class="clear" style="height:10px;"></div>
                                <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save costs'); ?>" name="submit_costs"/>
                                <div class="clear" style="height:10px;"></div>

                            </form>

                       </div> </div> </div>

            <?php
        }


        //Show Settings page
        function show_settings_content() {

            // debuge($_SERVER['HTTP_HOST']);

            if ( isset( $_POST['paypal_emeil'] ) ) {
                     if ($_SERVER['HTTP_HOST'] == 'booking.wpdevelop.com') $_POST['paypal_emeil'] = 'booking@wpdevelop.com';
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_emeil =  ($_POST['paypal_emeil']);
                     if ( get_option( 'booking_paypal_emeil' ) !== false  )   update_option( 'booking_paypal_emeil' , $paypal_emeil );
                     else                                                     add_option('booking_paypal_emeil' , $paypal_emeil );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_curency =  ($_POST['paypal_curency']);
                     if ( get_option( 'booking_paypal_curency' ) !== false  )   update_option( 'booking_paypal_curency' , $paypal_curency );
                     else                                                     add_option('booking_paypal_curency' , $paypal_curency );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_subject =  ($_POST['paypal_subject']);
                     if ( get_option( 'booking_paypal_subject' ) !== false  )   update_option( 'booking_paypal_subject' , $paypal_subject );
                     else                                                     add_option('booking_paypal_subject' , $paypal_subject );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     if (isset( $_POST['paypal_is_active'] ))     $paypal_is_active = 'On';
                     else                                         $paypal_is_active = 'Off';
                     if ( get_option( 'booking_paypal_is_active' ) !== false  )   update_option( 'booking_paypal_is_active' , $paypal_is_active );
                     else                                                     add_option('booking_paypal_is_active' , $paypal_is_active );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     if (isset( $_POST['paypal_is_reference_box'] ))     $paypal_is_reference_box = 'On';
                     else                                                $paypal_is_reference_box = 'Off';
                     if ( get_option( 'booking_paypal_is_reference_box' ) !== false  )   update_option( 'booking_paypal_is_reference_box' , $paypal_is_reference_box );
                     else                                                     add_option('booking_paypal_is_reference_box' , $paypal_is_reference_box );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_reference_title_box =  ($_POST['paypal_reference_title_box']);
                     if ( get_option( 'booking_paypal_reference_title_box' ) !== false  )   update_option( 'booking_paypal_reference_title_box' , $paypal_reference_title_box );
                     else                                                     add_option('booking_paypal_reference_title_box' , $paypal_reference_title_box );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_return_url =  ($_POST['paypal_return_url']);
                     if ( get_option( 'booking_paypal_return_url' ) !== false  )   update_option( 'booking_paypal_return_url' , $paypal_return_url );
                     else                                                     add_option('booking_paypal_return_url' , $paypal_return_url );
                     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     $paypal_button_type =  ($_POST['paypal_button_type']);
                     if ( get_option( 'booking_paypal_button_type' ) !== false  )   update_option( 'booking_paypal_button_type' , $paypal_button_type );
                     else                                                     add_option('booking_paypal_button_type' , $paypal_button_type );
            }
            $paypal_emeil               =  get_option( 'booking_paypal_emeil' );
            $paypal_curency             =  get_option( 'booking_paypal_curency' );
            $paypal_subject             =  get_option( 'booking_paypal_subject' );
            $paypal_is_active           =  get_option( 'booking_paypal_is_active' );
            $paypal_is_reference_box    =  get_option( 'booking_paypal_is_reference_box' );           // checkbox
            $paypal_reference_title_box =  get_option( 'booking_paypal_reference_title_box' );
            $paypal_return_url          =  get_option( 'booking_paypal_return_url' );
            $paypal_button_type         =  get_option( 'booking_paypal_button_type' );  // radio


            ?>

                        <div class="clear" style="height:20px;"></div>
                        <div id="ajax_working"></div>
                        <div id="poststuff" class="metabox-holder">

                        <?php $this->show_booking_types_cost();    ?>

                        <div class='meta-box'>  <div  class="postbox" > <h3 class='hndle'><span><?php _e('PayPal customization'); ?></span></h3> <div class="inside">

                            <form  name="post_option" action="" method="post" id="post_option" >

                                <table class="form-table settings-table">
                                    <tbody>

                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="paypal_is_active" ><?php _e('PayPal active'); ?>:</label>
                                            </th>
                                            <td>
                                                <input <?php if ($paypal_is_active == 'On') echo "checked";/**/ ?>  value="<?php echo $paypal_is_active; ?>" name="paypal_is_active" id="paypal_is_active" type="checkbox" />
                                                <span class="description"><?php _e(' Tick this checkbox if you want to use PayPal payment.');?></span>
                                            </td>
                                        </tr>


                                        <tr valign="top">
                                          <th scope="row">
                                            <label for="paypal_emeil" ><?php _e('Paypal Email address to receive payments'); ?>:</label>
                                            <br/><?php //printf(__('%syour emeil%s adress'),'<span style="color:#888;font-weight:bold;">','</span>'); ?>
                                          </th>
                                          <td>
                                              <input value="<?php echo $paypal_emeil; ?>" name="paypal_emeil" id="paypal_emeil" class="regular-text code" type="text" size="45" />
                                              <span class="description"><?php printf(__('This is the Paypal Email address where the payments will go'),'<b>','</b>');?></span>
                                              <?php  if ($_SERVER['HTTP_HOST'] == 'booking.wpdevelop.com') { ?> <span class="description">You can not allow to change emeil because right now you test DEMO</span> <?php } ?>
                                          </td>
                                        </tr>

                                        <tr valign="top">
                                          <th scope="row">
                                            <label for="paypal_curency" ><?php _e('Choose Payment Currency'); ?>:</label>
                                          </th>
                                          <td>
                                             <select id="paypal_curency" name="paypal_curency">
                                                <option <?php if($paypal_curency == 'USD') echo "selected"; ?> value="USD"><?php _e('U.S. Dollars'); ?></option>
                                                <option <?php if($paypal_curency == 'EUR') echo "selected"; ?> value="EUR"><?php _e('Euros'); ?></option>
                                                <option <?php if($paypal_curency == 'GBP') echo "selected"; ?> value="GBP"><?php _e('Pounds Sterling'); ?></option>
                                                <option <?php if($paypal_curency == 'JPY') echo "selected"; ?> value="JPY"><?php _e('Yen'); ?></option>
                                                <option <?php if($paypal_curency == 'AUD') echo "selected"; ?> value="AUD"><?php _e('Australian Dollars'); ?></option>
                                                <option <?php if($paypal_curency == 'CAD') echo "selected"; ?> value="CAD"><?php _e('Canadian Dollars'); ?></option>
                                                <option <?php if($paypal_curency == 'NZD') echo "selected"; ?> value="NZD"><?php _e('New Zealand Dollar'); ?></option>
                                                <option <?php if($paypal_curency == 'CHF') echo "selected"; ?> value="CHF"><?php _e('Swiss Franc'); ?></option>
                                                <option <?php if($paypal_curency == 'HKD') echo "selected"; ?> value="HKD"><?php _e('Hong Kong Dollar'); ?></option>
                                                <option <?php if($paypal_curency == 'SGD') echo "selected"; ?> value="SGD"><?php _e('Singapore Dollar'); ?></option>
                                                <option <?php if($paypal_curency == 'SEK') echo "selected"; ?> value="SEK"><?php _e('Swedish Krona'); ?></option>
                                                <option <?php if($paypal_curency == 'DKK') echo "selected"; ?> value="DKK"><?php _e('Danish Krone'); ?></option>
                                                <option <?php if($paypal_curency == 'PLN') echo "selected"; ?> value="PLN"><?php _e('Polish Zloty'); ?></option>
                                                <option <?php if($paypal_curency == 'NOK') echo "selected"; ?> value="NOK"><?php _e('Norwegian Krone'); ?></option>
                                                <option <?php if($paypal_curency == 'HUF') echo "selected"; ?> value="HUF"><?php _e('Hungarian Forint'); ?></option>
                                                <option <?php if($paypal_curency == 'CZK') echo "selected"; ?> value="CZK"><?php _e('Czech Koruna'); ?></option>
                                                <option <?php if($paypal_curency == 'ILS') echo "selected"; ?> value="ILS"><?php _e('Israeli Shekel'); ?></option>
                                                <option <?php if($paypal_curency == 'MXN') echo "selected"; ?> value="MXN"><?php _e('Mexican Peso'); ?></option>
                                                <option <?php if($paypal_curency == 'BRL') echo "selected"; ?> value="BRL"><?php _e('Brazilian Real (only for Brazilian users)'); ?></option>
                                                <option <?php if($paypal_curency == 'MYR') echo "selected"; ?> value="MYR"><?php _e('Malaysian Ringgits (only for Malaysian users)'); ?></option>
                                                <option <?php if($paypal_curency == 'PHP') echo "selected"; ?> value="PHP"><?php _e('Philippine Pesos'); ?></option>
                                                <option <?php if($paypal_curency == 'TWD') echo "selected"; ?> value="TWD"><?php _e('Taiwan New Dollars'); ?></option>
                                                <option <?php if($paypal_curency == 'THB') echo "selected"; ?> value="THB"><?php _e('Thai Baht'); ?></option>
                                             </select>
                                             <span class="description"><?php printf(__('This is the currency for your visitors to make Payments'),'<b>','</b>');?></span>
                                          </td>
                                        </tr>

                                      

                                        <tr valign="top">
                                          <th scope="row" >
                                            <label for="paypal_subject" ><?php _e('Payment description'); ?>:</label><br/><br/>
                                            <span class="description"><?php printf(__('Enter the service name or the reason for the payment here.'),'<br/>','</b>');?></span>
                                          </th>
                                          <td>


                                    <div style="float:left;margin:10px 0px;width:100%;">
                                    <input id="paypal_subject" name="paypal_subject" class="darker-border"  type="text" maxlength="50" size="59" value="<?php echo $paypal_subject; ?>" />
                                    
                                    </div>
                                    <div style="float:left;margin:10px 0px;width:375px;" class="code_description">
                                        <div style="border:1px solid #cccccc;margin-bottom:10px;padding:3px 0px;">
                                          <span class="description">&nbsp;<?php printf(__(' Use these shortcodes for customization: '));?></span><br/><br/>
                                          <span class="description"><?php printf(__('%s[bookingname]%s - inserting name of booking property, '),'<code>','</code>');?></span><br/>
                                          <span class="description"><?php printf(__('%s[dates]%s - inserting list of reserved dates '),'<code>','</code>');?></span><br/>
                                        </div>
                                    </div>
                                              <div class="clear"></div>

                                              
                                          </td>
                                        </tr>



                                        <tr valign="top">
                                            <th scope="row">
                                                <label for="paypal_is_reference_box" ><?php _e('Show Reference Text Box'); ?>:</label>
                                            </th>
                                            <td>
                                                <input <?php if ($paypal_is_reference_box == 'On') echo "checked";/**/ ?>  value="<?php echo $paypal_is_reference_box; ?>" name="paypal_is_reference_box" id="paypal_is_reference_box" type="checkbox"
                                                                                                                           onMouseDown="javascript: document.getElementById('paypal_reference_title_box').disabled=this.checked; "/>
                                                <span class="description"><?php _e(' Tick this checkbox if you want your visitors to be able to enter a reference text like email or web address.');?></span>
                                            </td>
                                        </tr>

                                        <tr valign="top">
                                          <th scope="row">
                                            <label for="paypal_reference_title_box" ><?php _e('Reference Text Box Title'); ?>:</label>
                                          </th>
                                          <td>
                                              <input <?php if ($paypal_is_reference_box !== 'On') echo " disabled "; ?>  value="<?php echo $paypal_reference_title_box; ?>" name="paypal_reference_title_box" id="paypal_reference_title_box" class="regular-text code" type="text" size="45" />
                                              <span class="description"><?php printf(__('Enter a title for the Reference text box (ie. Your emeil). The visitors will see this text'),'<b>','</b>');?></span>
                                          </td>
                                        </tr>

                                        <tr valign="top">
                                          <th scope="row">
                                            <label for="paypal_return_url" ><?php _e('Return URL from PayPal'); ?>:</label>
                                          </th>
                                          <td>
                                              <input value="<?php echo $paypal_return_url; ?>" name="paypal_return_url" id="paypal_return_url" class="regular-text code" type="text" size="45" />
                                              <span class="description"><?php printf(__('Enter a return URL (could be a Thank You page). PayPal will redirect visitors to this page after Payment'),'<b>','</b>');?></span>
                                          </td>
                                        </tr>


                                        <tr valign="top">
                                          <th scope="row">
                                            <label for="paypal_button_type" ><?php _e('Button types'); ?>:</label>
                                          </th>
                                          <td>
                                                <div style="width:150px;margin:auto;float:left;margin:5px;text-align:center;">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" /><br/>
                                                        <input <?php if ($paypal_button_type == 'https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif') echo ' checked="checked" '; ?> type="radio" name="paypal_button_type" value="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" style="margin:10px;" />
                                                </div>
                                                <div style="width:150px;margin:auto;float:left;margin:5px;text-align:center;">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif" /><br/>
                                                        <input <?php if ($paypal_button_type == 'https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif') echo ' checked="checked" '; ?>  type="radio" name="paypal_button_type" value="https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif" style="margin:10px;" />
                                                </div>
                                                <div style="width:150px;margin:auto;float:left;margin:5px;text-align:center;">
                                                        <img src="https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif" /><br/>
                                                        <input <?php if ($paypal_button_type == 'https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif') echo ' checked="checked" '; ?>  type="radio" name="paypal_button_type" value="https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif" style="margin:10px;" />
                                                </div>
                                               <span class="description"><?php printf(__('Select type of submit button'),'<b>','</b>');?></span>
                                          </td>
                                        </tr>

                                    </tbody>
                                </table>


                                <div class="clear" style="height:10px;"></div>
                                <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save'); ?>" name="Submit"/>
                                <div class="clear" style="height:10px;"></div>

                            </form>

                       </div> </div> </div>


                        </div>

        <?php
        }


        function show_general_settings(){

            if (isset($_POST['submit_settings_propay'])) {

                     if (isset( $_POST['range_selection_is_active'] ))     $range_selection_is_active = 'On';
                     else                                                  $range_selection_is_active = 'Off';
                     update_option( 'booking_range_selection_is_active' ,  $range_selection_is_active );

                     $range_selection_days_count =  $_POST['range_selection_days_count'];
                     update_option( 'booking_range_selection_days_count' , $range_selection_days_count );

                     $range_start_day =  $_POST['range_start_day'];
                     update_option( 'booking_range_start_day' , $range_start_day );
            }
            $range_selection_is_active = get_option( 'booking_range_selection_is_active');
            $range_selection_days_count = get_option( 'booking_range_selection_days_count');
            $range_start_day = get_option( 'booking_range_start_day');
            ?>
                        <div class="clear" style="height:20px;"></div>

                        <div  style="width:99%; ">

                            <div class='meta-box'>
                                <div  class="postbox" > <h3 class='hndle'><span><?php _e('Delux Settings'); ?></span></h3>
                                    <div class="inside">
                                            <form  name="post_option" action="" method="post" id="post_option" >
                                                <table class="form-table"><tbody>


                                                        <tr valign="top">
                                                            <th scope="row">
                                                                <label for="range_selection_is_active" ><?php _e('Range selection'); ?>:</label>
                                                            </th>
                                                            <td>
                                                                <input <?php if ($range_selection_is_active == 'On') echo "checked";/**/ ?>  value="<?php echo $range_selection_is_active; ?>" name="range_selection_is_active" id="range_selection_is_active" type="checkbox" />
                                                                <span class="description"><?php _e(' Tick this checkbox if you want to use range selection in calendar. For example selection only 5 days for booking.');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                        <th scope="row"><label for="range_selection_days_count" ><?php _e('Count of days'); ?>:</label><br><?php printf(__('in %srange to select%s'),'<span style="color:#888;font-weight:bold;">','</span>'); ?></th>
                                                            <td><input value="<?php echo $range_selection_days_count; ?>" name="range_selection_days_count" id="range_selection_days_count" class="regular-text code" type="text" size="45"  />
                                                                <span class="description"><?php printf(__('Type your %scount of days for range selection%s'),'<b>','</b>');?></span>
                                                            </td>
                                                        </tr>

                                                        <tr valign="top">
                                                            <th scope="row"><label for="range_start_day" ><?php _e('Start day of range'); ?>:</label></th>
                                                            <td>
                                                                <select id="range_start_day" name="range_start_day">
                                                                    <option <?php if($range_start_day == '-1') echo "selected"; ?> value="-1"><?php _e('Any day of week'); ?></option>
                                                                    <option <?php if($range_start_day == '0') echo "selected"; ?> value="0"><?php _e('Sunday'); ?></option>
                                                                    <option <?php if($range_start_day == '1') echo "selected"; ?> value="1"><?php _e('Monday'); ?></option>
                                                                    <option <?php if($range_start_day == '2') echo "selected"; ?> value="2"><?php _e('Thuesday'); ?></option>
                                                                    <option <?php if($range_start_day == '3') echo "selected"; ?> value="3"><?php _e('Wednesday'); ?></option>
                                                                    <option <?php if($range_start_day == '4') echo "selected"; ?> value="4"><?php _e('Thusday'); ?></option>
                                                                    <option <?php if($range_start_day == '5') echo "selected"; ?> value="5"><?php _e('Friday'); ?></option>
                                                                    <option <?php if($range_start_day == '6') echo "selected"; ?> value="6"><?php _e('Saturday'); ?></option>
                                                                </select>
                                                                <span class="description"><?php _e('Select your start day of range selection at week');?></span>
                                                            </td>
                                                        </tr>

                                                </tbody></table>

                                                <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save Changes'); ?>" name="submit_settings_propay"/>
                                                <div class="clear" style="height:10px;"></div>
                                            </form>
                                    </div>
                                </div>
                             </div>

                        </div>


            <?php
        }

     //   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ///////////////////////////////////////////////////

            // Activate
            function pro_activate() {
                global $wpdb;
                add_option( 'booking_paypal_emeil', get_option('admin_email') );
                add_option( 'booking_paypal_curency', 'USD' );
                add_option( 'booking_paypal_subject', sprintf(__('Payment for booking of the %s for days: %s' ),'[bookingname]','[dates]'));
                add_option( 'booking_paypal_is_active','On' );
                add_option( 'booking_paypal_is_reference_box', 'Off' );           // checkbox
                add_option( 'booking_paypal_reference_title_box', __('Enter your phone' ));
                add_option( 'booking_paypal_return_url', get_option('siteurl') );
                add_option( 'booking_paypal_button_type', 'https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif' );  // radio

                add_option( 'booking_range_selection_is_active', 'Off');
                add_option( 'booking_range_selection_days_count','3');
                add_option( 'booking_range_start_day' , '-1' );

                if  ($this->is_field_in_table_exists('bookingtypes','cost') == 0){
                    $simple_sql = "ALTER TABLE ".$wpdb->prefix ."bookingtypes ADD cost VARCHAR(100) NOT NULL DEFAULT '0'";
                    $wpdb->query($simple_sql);
                    $wpdb->query( "UPDATE ".$wpdb->prefix ."bookingtypes SET cost = '25'");
                }

            }

            //Decativate
            function pro_deactivate(){

                delete_option( 'booking_paypal_emeil' );
                delete_option( 'booking_paypal_curency' );
                delete_option( 'booking_paypal_subject' );
                delete_option( 'booking_paypal_is_active' );
                delete_option( 'booking_paypal_is_reference_box' );           // checkbox
                delete_option( 'booking_paypal_reference_title_box' );
                delete_option( 'booking_paypal_return_url' );
                delete_option( 'booking_paypal_button_type' );  // radio

                delete_option( 'booking_range_selection_is_active');
                delete_option( 'booking_range_selection_days_count');
                delete_option( 'booking_range_start_day'   );

            }


    }
}
?>
