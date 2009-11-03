<?php

/*
THIS IS COMMERCIAL SOFTWARE. You must own a license to use this plugin !!!
This file license is per 1 site usage.
You should not edit and/or (re)distribute this file.
If you want to have customization, please contact by email - call_customization@wpdevelop.com
If you do not have licence for this script, please buy it -  call_buy@wpdevelop.com
*/

if (file_exists(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-delux.php')) { require_once(WPDEV_BK_PLUGIN_DIR. '/include/wpdev-delux.php' ); }

if (!class_exists('wpdev_bk_pro')) {
    class wpdev_bk_pro   {

        var $current_booking_type;
        var $wpdev_bk_paypal;
        
        function wpdev_bk_pro() {
            $this->current_booking_type = 1;

            add_action('wpdev_bk_js_define_variables', array(&$this, 'js_define_variables') );      // Write JS variables
            add_action('wpdev_bk_js_write_files', array(&$this, 'js_write_files') );

            if ( class_exists('wpdev_bk_paypal')) {
                    $this->wpdev_bk_paypal = new wpdev_bk_paypal();
            } else { $this->wpdev_bk_paypal = false; }

           
        }

 // S U P P O R T       F u n c t i o n s    //////////////////////////////////////////////////////////////////////////////////////////////////

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

        function get_default_form(){
            return '[calendar] \n\
<div style="text-align:left"> \n\
<p>'. __('Arrival time').': [time arrival]  '. __('Departure time').': [time departure]</p> \n\
\n\
<p>'. __('Name (required)').':<br />  [text* name] </p> \n\
\n\
<p>'. __('Second Name (required)').':<br />  [text* surname] </p> \n\
\n\
<p>'. __('Email (required)').':<br />  [email* email] </p> \n\
\n\
<p>'. __('Phone').':<br />  [text phone] </p> \n\
\n\
<p>'. __('Visitors').':<br />  [select visitors "1" "2" "3" "4"] '. __('Childrens').': [checkbox children ""]</p> \n\
\n\
<p>'. __('Details').':<br /> [textarea details] </p> \n\
\n\
<p>[submit "'. __('Send').'"]</p> \n\
</div>';
        }

        function get_default_form_show(){
            return '<div style="text-align:left"> \n\
<strong>'. __('Arrival time').'</strong>: <span class="fieldvalue">[arrival]</span> \n\
<strong>'. __('Departure time').'</strong>: <span class="fieldvalue">[departure]</span></br>\n\
<strong>'. __('Name').'</strong>:<span class="fieldvalue">[name]</span><br/>\n\
<strong>'. __('Second Name').'</strong>:<span class="fieldvalue">[surname]</span><br/>\n\
<strong>'. __('Email').'</strong>:<span class="fieldvalue">[email]</span><br/>\n\
<strong>'. __('Phone').'</strong>:<span class="fieldvalue">[phone]</span><br/>\n\
<strong>'. __('Count  of visitors').'</strong>:<span class="fieldvalue"> [visitors]</span><br/>\n\
<strong>'. __('Childrens').'</strong>:<span class="fieldvalue"> [children]</span><br/>\n\
<strong>'. __('Details').'</strong>:<br /><span class="fieldvalue"> [details]</span>\n\
</div>';
        }


 // C l i e n t     s i d e     f u n c t i o n s     /////////////////////////////////////////////////////////////////////////////////////////

        // Define JavaScript variables
        function js_define_variables(){
            ?>
                    <script  type="text/javascript">
                        var days_select_count= <?php echo get_option( 'booking_range_selection_days_count'); ?>;
                        var message_time_error = '<?php _e('Uncorrect date format'); ?>';
                    </script>
            <?php
        }

        // Write Js files
        function js_write_files(){
             ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/include/js/jquery.meio.mask.min.js"></script>  <?php
             ?> <script type="text/javascript" src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/include/js/wpdev.bk.pro.js"></script>  <?php
         }

// B o o k i n g     T y p e s              //////////////////////////////////////////////////////////////////////////////////////////////////

        // Get booking types from DB
        function get_booking_types() {
            global $wpdb;
            $types_list = $wpdb->get_results( "SELECT booking_type_id as id, title FROM ".$wpdb->prefix ."bookingtypes  ORDER BY title" );
            return $types_list;
        }

        // Show line of adding new
        function booking_types_pages($is_edit = ''){

            $types_list = $this->get_booking_types();

            $bk_types_line ='';

            foreach ($types_list as $bk_type ) {
                $selected_class = '';
                if ( isset($_GET['booking_type']) ) {
                    if ($_GET['booking_type'] == $bk_type->id) $selected_class = ' selected_bk_type ';
                } else {
                    if (1 == $bk_type->id) $selected_class = ' selected_bk_type ';
                }
                if($is_edit == 'noedit') $subpage = '-reservation';
                else $subpage = '';

                $bk_types_line .= '<div id="bktype'.$bk_type->id.'" class="bk_types'.$selected_class.'"><a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking'.$subpage.'&booking_type='.$bk_type->id.'" class="bktypetitle">' . $bk_type->title . '</a>';
                if ( ($selected_class == '') && ( $is_edit !== 'noedit') && (1 != $bk_type->id) ) $bk_types_line .=' <a href="#"  title="'. __('Delete') .'" style="text-decoration:none;" onclick="javascript:delete_bk_type('.$bk_type->id.');"><img src="'.WPDEV_BK_PLUGIN_URL.'/img/delete_type.png" width="8" height="8" /></a>';
                if (   ( $is_edit !== 'noedit')   ) $bk_types_line .=' <a href="#"  title="'. __('edit') .'" style="text-decoration:none;" onclick="javascript:edit_bk_type('.$bk_type->id.');"><img src="'.WPDEV_BK_PLUGIN_URL.'/img/edit_type.png" width="8" height="8" /></a>';
                $bk_types_line .='</div>';
                $bk_types_line .='<div  id="bktypeedit'.$bk_type->id.'" style="float:left;display:none;">
                                    <input type="text" id="edit_bk_type'.$bk_type->id.'" name="edit_bk_type'.$bk_type->id.'" class="add_type_field" value="' . $bk_type->title . '" />
                                    <input  type="button" class="button-secondary" onclick="javascript:save_edit_bk_type('.$bk_type->id.');" value=" Edit " />
                                  </div>';
                $bk_types_line .='<div id="bktype_separator'.$bk_type->id.'" class="bk_types"> | </div>';
            }
            //$bk_types_line = substr($bk_types_line, 0 , -2);

            echo '<span style="height:24px;border:0px solid red;padding-top:2px;" id="bk_types_line">' . $bk_types_line . '</span>';

            if ( $is_edit !== 'noedit')
                echo '<div style="float:left;height:24px;padding:0px 2px 0px;font-size:12px;font-weight:bold;" id="bk_type_plus"><a href="#" onMouseDown="addBKTypes(\'Plus\');" style="text-decoration:none;"><img src="'.WPDEV_BK_PLUGIN_URL.'/img/add_type.png" style="margin:-2px 5px 0px 0px;width:12px;height:12px;vertical-align:middle;" /></a><a href="#" onMouseDown="addBKTypes(\'Plus\');">'.__('Add new type').'  </a></div>';

            ?>
                 <div style="float:left;border:0px dotted green;display:none;" id="bk_type_addbutton">
                    <input type="text" id="new_bk_type" name="new_bk_type" class="add_type_field"  value="" />
                    <input  type="button" class="button-secondary" onclick="javascript:add_bk_type();" value=" <?php _e('Add'); ?> " />
                </div>
            <div class="clear" style="height:5px;border-bottom:1px solid #cccccc;"></div>
            <script type="text/javascript">

                function delete_bk_type(type_id) {
                        var answer = confirm("<?php _e("Do you really want to delete this type?"); ?>");
                        if (! answer){
                            return false;
                        }

                        //Ajax adding new type to the DB
                        document.getElementById('ajax_working').innerHTML =
                        '<div class="info_message ajax_message" id="ajax_message" >\n\
                            <div style="float:left;"><?php _e('Deleting...'); ?></div> \n\
                            <div  style="float:left;width:80px;margin-top:-3px;">\n\
                                <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/ajax-loader.gif">\n\
                            </div>\n\
                        </div>';

                        jWPDev.ajax({                                           // Start Ajax Sending
                            url: '<?php echo WPDEV_BK_PLUGIN_URL . '/' . WPDEV_BK_PLUGIN_FILENAME ; ?>',
                            type:'POST',
                            success: function (data, textStatus){ if( textStatus == 'success')   jWPDev('#ajax_respond').html( data )  },
                            error:function (XMLHttpRequest, textStatus, errorThrown){ window.status('Ajax sending Error status:' + textStatus)},
                            // beforeSend: someFunction,
                            data:{
                                ajax_action : 'DELETE_BK_TYPE',
                                type_id : type_id
                            }
                        });
                        return false;
                }

                function edit_bk_type(type_id) {
                    jWPDev('#bktype' + type_id ).css({'display':'none'});
                    jWPDev('#bktypeedit' + type_id ).css({'display':'block'});
                    
                }

                function save_edit_bk_type(type_id) {
                    var my_val = jWPDev('#edit_bk_type'+ type_id).val();
                    jWPDev('#bktype' + type_id +' a.bktypetitle').html(my_val);
                    jWPDev('#bktype' + type_id ).css({'display':'block'});
                    jWPDev('#bktypeedit' + type_id ).css({'display':'none'});

                    //Ajax adding new type to the DB
                    document.getElementById('ajax_working').innerHTML =
                    '<div class="info_message ajax_message" id="ajax_message" >\n\
                        <div style="float:left;"><?php _e('Saving...'); ?></div> \n\
                        <div  style="float:left;width:80px;margin-top:-3px;">\n\
                            <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/ajax-loader.gif">\n\
                        </div>\n\
                    </div>';


                    jWPDev.ajax({                                           // Start Ajax Sending
                        url: '<?php echo WPDEV_BK_PLUGIN_URL . '/' . WPDEV_BK_PLUGIN_FILENAME ; ?>',
                        type:'POST',
                        success: function (data, textStatus){ if( textStatus == 'success')   jWPDev('#ajax_respond').html( data )  },
                        error:function (XMLHttpRequest, textStatus, errorThrown){ window.status('Ajax sending Error status:' + textStatus)},
                        // beforeSend: someFunction,
                        data:{
                            ajax_action : 'EDIT_BK_TYPE',
                            title : my_val,
                            type_id:type_id
                        }
                    });
                    return false;


                }

                function add_bk_type() {
                    var type_str = document.getElementById('new_bk_type').value;
                    if (type_str == '') return;
                    document.getElementById('new_bk_type').value = '';
                    jWPDev('#bk_types_line').append('<div id="last_book_type" class="bk_types">' + type_str + '</div>' + '<div id="last_book_type_separator" class="bk_types"> | </div>' );
                    document.getElementById('bk_type_plus').style.display='block';
                    document.getElementById('bk_type_addbutton').style.display='none';

                        //Ajax adding new type to the DB
                        document.getElementById('ajax_working').innerHTML =
                        '<div class="info_message ajax_message" id="ajax_message" >\n\
                            <div style="float:left;"><?php _e('Saving...'); ?></div> \n\
                            <div  style="float:left;width:80px;margin-top:-3px;">\n\
                                <img src="<?php echo WPDEV_BK_PLUGIN_URL; ?>/img/ajax-loader.gif">\n\
                            </div>\n\
                        </div>';


                        jWPDev.ajax({                                           // Start Ajax Sending
                            url: '<?php echo WPDEV_BK_PLUGIN_URL . '/' . WPDEV_BK_PLUGIN_FILENAME ; ?>',
                            type:'POST',
                            success: function (data, textStatus){ if( textStatus == 'success')   jWPDev('#ajax_respond').html( data )  },
                            error:function (XMLHttpRequest, textStatus, errorThrown){ window.status('Ajax sending Error status:' + textStatus)},
                            // beforeSend: someFunction,
                            data:{
                                ajax_action : 'ADD_BK_TYPE',
                                title : type_str
                            }
                        });
                        return false;

                }
                function addBKTypes(param){
                    document.getElementById('bk_type_plus').style.display='none';
                    document.getElementById('bk_type_addbutton').style.display='block';
                    setTimeout(function ( ) {
                                jWPDev('#new_bk_type').focus();
                                }
                                ,100);

                }
                function bk_type_addbutton_press_key( e ) {
                        if ( 13 == e.which ) {
                                add_bk_type();
                                return false;
                        }
                };
                jWPDev('#bk_type_addbutton input.add_type_field').keypress( bk_type_addbutton_press_key );

            </script>

            <?php
        }



 // P A R S E   F o r m                      //////////////////////////////////////////////////////////////////////////////////////////////////
        function get_booking_form($my_boook_type){

            $booking_form  = get_option( 'booking_form' );

            $this->current_booking_type = $my_boook_type;

            return $this->form_elements($booking_form);
        }

                // Getted from script under GNU /////////////////////////////////////
                function form_elements($form, $replace = true) {
                        $types = 'text[*]?|email[*]?|time[*]?|textarea[*]?|select[*]?|checkbox[*]?|radio|acceptance|captchac|captchar|file[*]?|quiz';
                        $regex = '%\[\s*(' . $types . ')(\s+[a-zA-Z][0-9a-zA-Z:._-]*)([-0-9a-zA-Z:#_/|\s]*)?((?:\s*(?:"[^"]*"|\'[^\']*\'))*)?\s*\]%';
                        $submit_regex = '%\[\s*submit(\s[-0-9a-zA-Z:#_/\s]*)?(\s+(?:"[^"]*"|\'[^\']*\'))?\s*\]%';
                        if ($replace) {
                                $form = preg_replace_callback($regex, array(&$this, 'form_element_replace_callback'), $form);
                                // Submit button
                                $form = preg_replace_callback($submit_regex, array(&$this, 'submit_replace_callback'), $form);
                                return $form;
                        } else {
                                $results = array();
                                preg_match_all($regex, $form, $matches, PREG_SET_ORDER);
                                foreach ($matches as $match) {
                                        $results[] = (array) $this->form_element_parse($match);
                                }
                                return $results;
                        }
                }

                function form_element_replace_callback($matches) {
                        extract((array) $this->form_element_parse($matches)); // $type, $name, $options, $values, $raw_values

                        $name .= $this->current_booking_type ;

                        if ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) {
                                $validation_error = $_POST['wpdev_validation_errors']['messages'][$name];
                                $validation_error = $validation_error ? '<span class="wpdev-not-valid-tip-no-ajax">' . $validation_error . '</span>' : '';
                        } else {
                                $validation_error = '';
                        }

                        $atts = '';
                $options = (array) $options;

                $id_array = preg_grep('%^id:[-0-9a-zA-Z_]+$%', $options);
                if ($id = array_shift($id_array)) {
                    preg_match('%^id:([-0-9a-zA-Z_]+)$%', $id, $id_matches);
                    if ($id = $id_matches[1])
                        $atts .= ' id="' . $id . $this->current_booking_type .'"';
                }

                $class_att = "";
                $class_array = preg_grep('%^class:[-0-9a-zA-Z_]+$%', $options);
                foreach ($class_array as $class) {
                    preg_match('%^class:([-0-9a-zA-Z_]+)$%', $class, $class_matches);
                    if ($class = $class_matches[1])
                        $class_att .= ' ' . $class;
                }

                if (preg_match('/^email[*]?$/', $type))
                    $class_att .= ' wpdev-validates-as-email';
                if (preg_match('/^time[*]?$/', $type))
                    $class_att .= ' wpdev-validates-as-time';
                if (preg_match('/[*]$/', $type))
                    $class_att .= ' wpdev-validates-as-required';

                if (preg_match('/^checkbox[*]?$/', $type))
                    $class_att .= ' wpdev-checkbox';

                if ('radio' == $type)
                    $class_att .= ' wpdev-radio';

                if (preg_match('/^captchac$/', $type))
                    $class_att .= ' wpdev-captcha-' . $name;

                if ('acceptance' == $type) {
                    $class_att .= ' wpdev-acceptance';
                    if (preg_grep('%^invert$%', $options))
                        $class_att .= ' wpdev-invert';
                }

                if ($class_att)
                    $atts .= ' class="' . trim($class_att) . '"';

                        // Value.
                        if ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) {
                                if (isset($_POST['wpdev_mail_sent']) && $_POST['wpdev_mail_sent']['ok'])
                                        $value = '';
                                elseif ('captchar' == $type)
                                        $value = '';
                                else
                                        $value = $_POST[$name];
                        } else {
                                $value = $values[0];
                        }

                // Default selected/checked for select/checkbox/radio
                if (preg_match('/^(?:select|checkbox|radio)[*]?$/', $type)) {
                    $scr_defaults = array_values(preg_grep('/^default:/', $options));
                    preg_match('/^default:([0-9_]+)$/', $scr_defaults[0], $scr_default_matches);
                    $scr_default = explode('_', $scr_default_matches[1]);
                }

                        switch ($type) {
                                case 'time':
                                case 'time*':
                                case 'text':
                                case 'text*':
                                case 'email':
                                case 'email*':
                                case 'captchar':
                                        if (is_array($options)) {
                                                $size_maxlength_array = preg_grep('%^[0-9]*[/x][0-9]*$%', $options);
                                                if ($size_maxlength = array_shift($size_maxlength_array)) {
                                                        preg_match('%^([0-9]*)[/x]([0-9]*)$%', $size_maxlength, $sm_matches);
                                                        if ($size = (int) $sm_matches[1])
                                                                $atts .= ' size="' . $size . '"';
                                else
                                    $atts .= ' size="40"';
                                                        if ($maxlength = (int) $sm_matches[2])
                                                                $atts .= ' maxlength="' . $maxlength . '"';
                                                } else {
                                $atts .= ' size="40"';
                            }
                                        }
                                        $html = '<input type="text" name="' . $name . '" value="' . attribute_escape($value) . '"' . $atts . ' />';
                                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                        return $html;
                                        break;
                                case 'textarea':
                                case 'textarea*':
                                        if (is_array($options)) {
                                                $cols_rows_array = preg_grep('%^[0-9]*[x/][0-9]*$%', $options);
                                                if ($cols_rows = array_shift($cols_rows_array)) {
                                                        preg_match('%^([0-9]*)[x/]([0-9]*)$%', $cols_rows, $cr_matches);
                                                        if ($cols = (int) $cr_matches[1])
                                                                $atts .= ' cols="' . $cols . '"';
                                else
                                    $atts .= ' cols="40"';
                                                        if ($rows = (int) $cr_matches[2])
                                                                $atts .= ' rows="' . $rows . '"';
                                else
                                    $atts .= ' rows="10"';
                                                } else {
                                $atts .= ' cols="40" rows="10"';
                            }
                                        }
                                        $html = '<textarea name="' . $name . '"' . $atts . '>' . $value . '</textarea>';
                                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                        return $html;
                                        break;
                                case 'select':
                                case 'select*':
                        $multiple = (preg_grep('%^multiple$%', $options)) ? true : false;
                        $include_blank = preg_grep('%^include_blank$%', $options);

                                        if ($empty_select = empty($values) || $include_blank)
                                                array_unshift($values, '---');

                                        $html = '';
                        foreach ($values as $key => $value) {
                            $selected = '';
                            if (! $empty_select && in_array($key + 1, (array) $scr_default))
                                $selected = ' selected="selected"';
                            if ($this->processing_unit_tag == $_POST['wpdev_unit_tag'] && (
                                    $multiple && in_array($value, (array) $_POST[$name]) ||
                                    ! $multiple && $_POST[$name] == $value))
                                $selected = ' selected="selected"';
                                                $html .= '<option value="' . attribute_escape($value) . '"' . $selected . '>' . $value . '</option>';
                        }

                        if ($multiple)
                            $atts .= ' multiple="multiple"';

                                        $html = '<select name="' . $name . ($multiple ? '[]' : '') . '"' . $atts . '>' . $html . '</select>';
                                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                        return $html;
                                        break;
                    case 'checkbox':
                    case 'checkbox*':
                    case 'radio':
                        $multiple = (preg_match('/^checkbox[*]?$/', $type) && ! preg_grep('%^exclusive$%', $options)) ? true : false;
                        $html = '';

                        if (preg_match('/^checkbox[*]?$/', $type) && ! $multiple)
                            $onclick = ' onclick="wpdevExclusiveCheckbox(this);"';

                        $input_type = rtrim($type, '*');

                        foreach ($values as $key => $value) {
                            $checked = '';
                            if (in_array($key + 1, (array) $scr_default))
                                $checked = ' checked="checked"';
                            if ($this->processing_unit_tag == $_POST['wpdev_unit_tag'] && (
                                    $multiple && in_array($value, (array) $_POST[$name]) ||
                                    ! $multiple && $_POST[$name] == $value))
                                $checked = ' checked="checked"';
                            if (preg_grep('%^label[_-]?first$%', $options)) { // put label first, input last
                                $item = '<span class="wpdev-list-item-label">' . $value . '</span>&nbsp;';
                                $item .= '<input type="' . $input_type . '" name="' . $name . ($multiple ? '[]' : '') . '" value="' . attribute_escape($value) . '"' . $checked . $onclick . ' />';
                            } else {
                                $item = '<input type="' . $input_type . '" name="' . $name . ($multiple ? '[]' : '') . '" value="' . attribute_escape($value) . '"' . $checked . $onclick . ' />';
                                $item .= '&nbsp;<span class="wpdev-list-item-label">' . $value . '</span>';
                            }
                            $item = '<span class="wpdev-list-item">' . $item . '</span>';
                            $html .= $item;
                        }

                        $html = '<span' . $atts . '>' . $html . '</span>';
                                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                        return $html;
                                        break;
                    case 'quiz':
                        if (count($raw_values) == 0 && count($values) == 0) { // default quiz
                            $raw_values[] = '1+1=?|2';
                            $values[] = '1+1=?';
                        }

                        $pipes = $this->get_pipes($raw_values);

                        if (count($values) == 0) {
                            break;
                        } elseif (count($values) == 1) {
                            $value = $values[0];
                        } else {
                            $value = $values[array_rand($values)];
                        }

                        $answer = $this->pipe($pipes, $value);
                        $answer = $this->canonicalize($answer);

                                        if (is_array($options)) {
                                                $size_maxlength_array = preg_grep('%^[0-9]*[/x][0-9]*$%', $options);
                                                if ($size_maxlength = array_shift($size_maxlength_array)) {
                                                        preg_match('%^([0-9]*)[/x]([0-9]*)$%', $size_maxlength, $sm_matches);
                                                        if ($size = (int) $sm_matches[1])
                                                                $atts .= ' size="' . $size . '"';
                                else
                                    $atts .= ' size="40"';
                                                        if ($maxlength = (int) $sm_matches[2])
                                                                $atts .= ' maxlength="' . $maxlength . '"';
                                                } else {
                                $atts .= ' size="40"';
                            }
                                        }

                        $html = '<span class="wpdev-quiz-label">' . $value . '</span>&nbsp;';
                        $html .= '<input type="text" name="' . $name . '"' . $atts . ' />';
                        $html .= '<input type="hidden" name="wpdev_quiz_answer_' . $name . '" value="' . wp_hash($answer, 'wpdev_quiz') . '" />';
                                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                        return $html;
                        break;
                    case 'acceptance':
                        $invert = (bool) preg_grep('%^invert$%', $options);
                        $default = (bool) preg_grep('%^default:on$%', $options);

                        $onclick = ' onclick="wpdevToggleSubmit(this.form);"';
                        $checked = $default ? ' checked="checked"' : '';
                        $html = '<input type="checkbox" name="' . $name . '" value="1"' . $atts . $onclick . $checked . ' />';
                        return $html;
                        break;
                                case 'captchac':
                        if (! class_exists('ReallySimpleCaptcha')) {
                            return '<em>' . 'To use CAPTCHA, you need <a href="http://wordpress.org/extend/plugins/really-simple-captcha/">Really Simple CAPTCHA</a> plugin installed.' . '</em>';
                            break;
                        }

                                        $op = array();
                                        // Default
                                        $op['img_size'] = array(72, 24);
                                        $op['base'] = array(6, 18);
                                        $op['font_size'] = 14;
                                        $op['font_char_width'] = 15;

                                        $op = array_merge($op, $this->captchac_options($options));

                                        if (! $filename = $this->generate_captcha($op)) {
                                                return '';
                                                break;
                                        }
                                        if (is_array($op['img_size']))
                                                $atts .= ' width="' . $op['img_size'][0] . '" height="' . $op['img_size'][1] . '"';
                                        $captcha_url = trailingslashit($this->captcha_tmp_url()) . $filename;
                                        $html = '<img alt="captcha" src="' . $captcha_url . '"' . $atts . ' />';
                                        $ref = substr($filename, 0, strrpos($filename, '.'));
                                        $html = '<input type="hidden" name="wpdev_captcha_challenge_' . $name . '" value="' . $ref . '" />' . $html;
                                        return $html;
                                        break;
                    case 'file':
                    case 'file*':
                        $html = '<input type="file" name="' . $name . '"' . $atts . ' value="1" />';
                        $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                        return $html;
                        break;
                        }
                }

                function submit_replace_callback($matches) {
                $atts = '';
                $options = preg_split('/[\s]+/', trim($matches[1]));

                $id_array = preg_grep('%^id:[-0-9a-zA-Z_]+$%', $options);
                if ($id = array_shift($id_array)) {
                    preg_match('%^id:([-0-9a-zA-Z_]+)$%', $id, $id_matches);
                    if ($id = $id_matches[1])
                        $atts .= ' id="' . $id . '"';
                }

                $class_att = '';
                $class_array = preg_grep('%^class:[-0-9a-zA-Z_]+$%', $options);
                foreach ($class_array as $class) {
                    preg_match('%^class:([-0-9a-zA-Z_]+)$%', $class, $class_matches);
                    if ($class = $class_matches[1])
                        $class_att .= ' ' . $class;
                }

                if ($class_att)
                    $atts .= ' class="' . trim($class_att) . '"';

                        if ($matches[2])
                                $value = $this->strip_quote($matches[2]);
                        if (empty($value))
                                $value = __('Send');
                        $ajax_loader_image_url =   WPDEV_BK_PLUGIN_URL . '/img/ajax-loader.gif';

                $html = '<input type="button" value="' . $value . '"' . $atts . ' onclick="mybooking_submit(this.form,'.$this->current_booking_type.');" />';
                $html .= ' <img class="ajax-loader" style="visibility: hidden;" alt="ajax loader" src="' . $ajax_loader_image_url . '" />';
                        return $html;
                }

                function form_element_parse($element) {
                        $type = trim($element[1]);
                        $name = trim($element[2]);
                        $options = preg_split('/[\s]+/', trim($element[3]));

                        preg_match_all('/"[^"]*"|\'[^\']*\'/', $element[4], $matches);
                        $raw_values = $this->strip_quote_deep($matches[0]);

                        if ( preg_match('/^(select[*]?|checkbox[*]?|radio)$/', $type) || 'quiz' == $type) {
                            $pipes = $this->get_pipes($raw_values);
                            $values = $this->get_pipe_ins($pipes);
                        } else {
                            $values =& $raw_values;
                        }

                        return compact('type', 'name', 'options', 'values', 'raw_values');
                }

                function strip_quote($text) {
                        $text = trim($text);
                        if (preg_match('/^"(.*)"$/', $text, $matches))
                                $text = $matches[1];
                        elseif (preg_match("/^'(.*)'$/", $text, $matches))
                                $text = $matches[1];
                        return $text;
                }

                function strip_quote_deep($arr) {
                        if (is_string($arr))
                                return $this->strip_quote($arr);
                        if (is_array($arr)) {
                                $result = array();
                                foreach ($arr as $key => $text) {
                                        $result[$key] = $this->strip_quote($text);
                                }
                                return $result;
                        }
                }

                function pipe($pipes, $value) {
                    if (is_array($value)) {
                        $results = array();
                        foreach ($value as $k => $v) {
                            $results[$k] = $this->pipe($pipes, $v);
                        }
                        return $results;
                    }

                    foreach ($pipes as $p) {
                        if ($p[0] == $value)
                            return $p[1];
                    }

                    return $value;
                }

                function get_pipe_ins($pipes) {
                    $ins = array();
                    foreach ($pipes as $pipe) {
                        $in = $pipe[0];
                        if (! in_array($in, $ins))
                            $ins[] = $in;
                    }
                    return $ins;
                }

                function get_pipes($values) {
                    $pipes = array();

                    foreach ($values as $value) {
                        $pipe_pos = strpos($value, '|');
                        if (false === $pipe_pos) {
                            $before = $after = $value;
                        } else {
                            $before = substr($value, 0, $pipe_pos);
                            $after = substr($value, $pipe_pos + 1);
                        }

                        $pipes[] = array($before, $after);
                    }

                    return $pipes;
                }

                function pipe_all_posted($contact_form) {
                    $all_pipes = array();

                    $fes = $this->form_elements($contact_form['form'], false);
                    foreach ($fes as $fe) {
                        $type = $fe['type'];
                        $name = $fe['name'];
                        $raw_values = $fe['raw_values'];

                        if (! preg_match('/^(select[*]?|checkbox[*]?|radio)$/', $type))
                            continue;

                        $pipes = $this->get_pipes($raw_values);

                        $all_pipes[$name] = array_merge($pipes, (array) $all_pipes[$name]);
                    }

                    foreach ($all_pipes as $name => $pipes) {
                        if (isset($this->posted_data[$name]))
                            $this->posted_data[$name] = $this->pipe($pipes, $this->posted_data[$name]);
                    }
                }
                ////////////////////////////////////////////////////////////////////////

 //  S e t t i n g s     p a g e s           //////////////////////////////////////////////////////////////////////////////////////////////////
        function check_settings(){
            ?>
            <div style="height:20px;clear:both;"></div>
            <?php if ( ($_GET['tab'] == 'main') || (! isset($_GET['tab'])) ) { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=main" class="<?php echo $slct_a; ?>"><?php _e('General settings'); ?></a> |
            <?php if ($_GET['tab'] == 'form') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=form" class="<?php echo $slct_a; ?>"><?php _e('Form fields and content customization'); ?></a> |
            <?php if ($_GET['tab'] == 'email') { $slct_a = 'selected'; } else {$slct_a = '';} ?>
            <a href="admin.php?page=<?php echo WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME ; ?>wpdev-booking-option&tab=email" class="<?php echo $slct_a; ?>"><?php _e('Emails customization'); ?></a>
            <?php
            if ($this->wpdev_bk_paypal !== false) {
               $border_line = true;
               if (! $this->wpdev_bk_paypal->check_settings() ) {
                   return false;
               }

            }
            if ($border_line !== true) {
                    ?> <div style="height:10px;clear:both;border-bottom:1px solid #cccccc;"></div> <?php
            }
                switch ($_GET['tab']) {

                   case 'main':
                    return true;
                    break;

                   case 'form':
                    $this->compouse_form();
                    return false;
                    break;

                   case 'email':
                    $this->compouse_email();
                    return false;
                    break;

                 default:
                    return true;
                    break;
                }

            
        }

        function compouse_form(){


             if ( isset( $_POST['booking_form'] ) ) {

                 $booking_form =  ($_POST['booking_form']);
                 $booking_form = str_replace('\"','"',$booking_form);
                 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 if ( get_option( 'booking_form' ) !== false  )   update_option( 'booking_form' , $booking_form );
                 else                                             add_option('booking_form' , $booking_form );

             }else {

                $booking_form  = get_option( 'booking_form' );

             }

             if ( isset( $_POST['booking_form_show'] ) ) {

                 $booking_form_show =  ($_POST['booking_form_show']);
                 $booking_form_show = str_replace('\"','"',$booking_form_show);
                 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 if ( get_option( 'booking_form_show' ) !== false  )   update_option( 'booking_form_show' , $booking_form_show );
                 else                                                  add_option('booking_form_show' , $booking_form_show );

             }else {

                $booking_form_show  = get_option( 'booking_form_show' );

             }


            ?>

                    <div class="clear" style="height:20px;"></div>
                    <div id="ajax_working"></div>
                    <div id="poststuff" class="metabox-holder">
                    <script type="text/javascript">
                        function reset_to_def_from() {
                            document.getElementById('booking_form').value = '<?php echo $this->get_default_form(); ?>';
                        }
                        function reset_to_def_from_show() {
                            document.getElementById('booking_form_show').value = '<?php echo $this->get_default_form_show(); ?>';
                        }
                    </script>
                    <div class='meta-box'><div  class="postbox" ><h3 class='hndle'><span><?php _e('Form fields customization'); ?></span></h3><div class="inside">
                                <form  name="post_option" action="" method="post" id="post_option" >
                                    <div style="float:left;margin:10px 0px;width:58%;">
                                        <textarea id="booking_form" name="booking_form" class="darker-border" style="width:100%;" rows="21"><?php echo htmlspecialchars($booking_form, ENT_NOQUOTES ); ?></textarea>
                                    </div>
                                    <div style="float:right;margin:10px 0px;width:40%;" class="code_description">
                                        <div style="border:1px solid #cccccc;margin-bottom:10px;">
                                          <span class="description" style="padding:5px;"><?php printf(__('%sGeneral shortcode fields rule for inserting field:%s'),'<strong>','</strong>');?></span><br/><br/>
                                          <span class="description"><?php printf( '<code>[shortcode_type* field_name "value"]</code>');?></span><br/>
                                          <span class="description"><?php printf(__('Parameters: '));?></span><br/>
                                          <span class="description"><?php printf(__('%s - this symbol means that this field is Required (can be skipped)'),'<code>*</code>');?></span><br/>
                                          <span class="description"><?php printf(__('%s - field name, must be unique (can not be skipped)'),'<code>field_name</code>');?></span><br/>
                                          <span class="description"><?php printf(__('%s - default value of field (can be skipped)'),'<code>"value"</code>');?></span><br/><br/>
                                        </div>
                                        <div style="border:1px solid #cccccc;">
                                          <span class="description" style="padding:5px;"><?php printf(__('%sUse these shortcode types for inserting fields into form:%s'),'<strong>','</strong>');?></span><br/><br/>
                                          <span class="description"><?php printf(__('%s - calendar'),'<code>[calendar]</code>');?></span><br/>

                                          <span class="description"><?php printf(__('%s - text field. '),'<code>[text]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %sJohn%s'),'[text firt_name "', '"]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - time field. '),'<code>[time]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %s '),'[time start_tm]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - emeil field, '),'<code>[email]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %s '),'[email* my_email]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - select field, '),'<code>[select]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %s '),'[select my_slct "1" "2" "3"]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - checkbox field, '),'<code>[checkbox]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %s '),'[checkbox my_radio ""]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - textarea field, '),'<code>[textarea]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %s '),'[textarea my_details]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - submit button, '),'<code>[submit]</code>');?></span>
                                          <span class="description example-code"><?php printf(__('Example: %sSend%s '),'[submit "', '"]');?></span><br/>

                                          <span class="description"><?php printf(__('%s - inserting new line, '),'<code>&lt;br/&gt;</code>');?></span><br/>
                                          <span class="description"><?php printf(__('use any other HTML tags (carefully).'),'<code>','</code>');?></span><br/><br/>
                                        </div>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input class="button-secondary" style="float:left;" type="button" value="<?php _e('Reset to default form'); ?>" onclick="javascript:reset_to_def_from();" name="reset_form"/>
                                    <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save'); ?>" name="Submit"/>
                                    <div class="clear" style="height:5px;"></div>

                                </form>
                     </div></div></div>


                    <div class='meta-box'><div  class="postbox" ><h3 class='hndle'><span><?php printf(__('Form content data showing at emails (%s-shortcode) and inside approval and reservation tables at booking calendar page'),'[content]'); ?></span></h3><div class="inside">
                                <form  name="post_option" action="" method="post" id="post_option" >
                                    <div style="float:left;margin:10px 0px;width:58%;">
                                    <textarea id="booking_form_show" name="booking_form_show" class="darker-border" style="width:100%;" rows="11"><?php echo htmlspecialchars($booking_form_show, ENT_NOQUOTES ); ?></textarea>
                                    </div>
                                    <div style="float:right;margin:10px 0px;width:40%;" class="code_description">
                                        <div style="border:1px solid #cccccc;margin-bottom:10px;">
                                          <span class="description"><?php printf(__('Use these shortcodes for customization: '));?></span><br/><br/>
                                          <span class="description"><?php printf(__('%s - inserting data from fields of booking form, '),'<code>[field_name]</code>');?></span><br/><br/>
                                          <span class="description"><?php printf(__('%s - inserting new line, '),'<code>&lt;br/&gt;</code>');?></span><br/><br/>
                                          <span class="description"><?php printf(__('use any other HTML tags (carefully).'),'<code>','</code>');?></span><br/><br/>
                                        </div>
                                    </div>
                                    <div class="clear" style="height:1px;"></div>
                                    <input class="button-secondary" style="float:left;" type="button" value="<?php _e('Reset to default form content'); ?>" onclick="javascript:reset_to_def_from_show();" name="reset_form"/>
                                    <input class="button-primary" style="float:right;" type="submit" value="<?php _e('Save'); ?>" name="Submit"/>
                                    <div class="clear" style="height:5px;"></div>

                                </form>
                     </div></div></div>

                    </div>
         <?php
        }

        function compouse_email(){

             if ( isset( $_POST['email_reservation_adress'] ) ) {

                 $email_reservation_adress      = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_adress']));
                 $email_reservation_from_adress = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_from_adress']));
                 $email_reservation_subject     = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_subject']));
                 $email_reservation_content     = htmlspecialchars( str_replace('\"','"',$_POST['email_reservation_content']));

                 if ( get_option( 'booking_email_reservation_adress' ) !== false  )      update_option( 'booking_email_reservation_adress' , $email_reservation_adress );
                 else                                                                    add_option('booking_email_reservation_adress' , $email_reservation_adress );
                 if ( get_option( 'booking_email_reservation_from_adress' ) !== false  ) update_option( 'booking_email_reservation_from_adress' , $email_reservation_from_adress );
                 else                                                                    add_option('booking_email_reservation_from_adress' , $email_reservation_from_adress );
                 if ( get_option( 'booking_email_reservation_subject' ) !== false  )     update_option( 'booking_email_reservation_subject' , $email_reservation_subject );
                 else                                                                    add_option('booking_email_reservation_subject' , $email_reservation_subject );
                 if ( get_option( 'booking_email_reservation_content' ) !== false  )     update_option( 'booking_email_reservation_content' , $email_reservation_content );
                 else                                                                    add_option('booking_email_reservation_content' , $email_reservation_content );
                 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                 $email_approval_adress  = htmlspecialchars( str_replace('\"','"',$_POST['email_approval_adress']));
                 $email_approval_subject = htmlspecialchars( str_replace('\"','"',$_POST['email_approval_subject']));
                 $email_approval_content = htmlspecialchars( str_replace('\"','"',$_POST['email_approval_content']));

                 if ( get_option( 'booking_email_approval_adress' ) !== false  )         update_option( 'booking_email_approval_adress' , $email_approval_adress );
                 else                                                                    add_option('booking_email_approval_adress' , $email_approval_adress );
                 if ( get_option( 'booking_email_approval_subject' ) !== false  )        update_option( 'booking_email_approval_subject' , $email_approval_subject );
                 else                                                                    add_option('booking_email_approval_subject' , $email_approval_subject );
                 if ( get_option( 'booking_email_approval_content' ) !== false  )        update_option( 'booking_email_approval_content' , $email_approval_content );
                 else                                                                    add_option('booking_email_approval_content' , $email_approval_content );
                 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                 $email_deny_adress  = htmlspecialchars( str_replace('\"','"',$_POST['email_deny_adress']));
                 $email_deny_subject = htmlspecialchars( str_replace('\"','"',$_POST['email_deny_subject']));
                 $email_deny_content = htmlspecialchars( str_replace('\"','"',$_POST['email_deny_content']));

                 if ( get_option( 'booking_email_deny_adress' ) !== false  )             update_option( 'booking_email_deny_adress' , $email_deny_adress );
                 else                                                                    add_option('booking_email_deny_adress' , $email_deny_adress );
                 if ( get_option( 'booking_email_deny_subject' ) !== false  )            update_option( 'booking_email_deny_subject' , $email_deny_subject );
                 else                                                                    add_option('booking_email_deny_subject' , $email_deny_subject );
                 if ( get_option( 'booking_email_deny_content' ) !== false  )            update_option( 'booking_email_deny_content' , $email_deny_content );
                 else                                                                    add_option('booking_email_deny_content' , $email_deny_content );

             } else {

                 $email_reservation_adress      = get_option( 'booking_email_reservation_adress') ;
                 $email_reservation_from_adress = get_option( 'booking_email_reservation_from_adress');
                 $email_reservation_subject     = get_option( 'booking_email_reservation_subject');
                 $email_reservation_content     = get_option( 'booking_email_reservation_content');
                 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 $email_approval_adress      = get_option( 'booking_email_approval_adress');
                 $email_approval_subject     = get_option( 'booking_email_approval_subject');
                 $email_approval_content     = get_option( 'booking_email_approval_content');
                 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 $email_deny_adress      = get_option( 'booking_email_deny_adress');
                 $email_deny_subject     = get_option( 'booking_email_deny_subject');
                 $email_deny_content     = get_option( 'booking_email_deny_content');

                 //$email_deny_adress = $email_approval_adress = $email_reservation_from_adress = $email_reservation_adress = htmlspecialchars('"Booking system" <' .get_option('admin_email').'>');

             }

            ?>

                    <div class="clear" style="height:20px;"></div>
                    <div id="ajax_working"></div>
                    <div id="poststuff" class="metabox-holder">

                    <div class='meta-box'>  <div  class="postbox" > <h3 class='hndle'><span><?php _e('Emails customization'); ?></span></h3> <div class="inside">

                        <form  name="post_option" action="" method="post" id="post_option" >

                            <table class="form-table email-table" >
                                <tbody>
                                    <tr><td colspan="2" class="th-title"><h2><?php _e('Email to "Admin" after booking at site'); ?></h2></td></tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="admin_cal_count" ><?php _e('To'); ?>:</label></th>
                                        <td><input id="email_reservation_adress"  name="email_reservation_adress" class="regular-text code" type="text" size="45" value="<?php echo $email_reservation_adress; ?>" />
                                            <span class="description"><?php printf(__('Type default %sadmin email%s for checking reservations'),'<b>','</b>');?></span>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="admin_cal_count" ><?php _e('From'); ?>:</label></th>
                                        <td><input id="email_reservation_from_adress" name="email_reservation_from_adress" class="regular-text code" type="text" size="45" value="<?php echo $email_reservation_from_adress; ?>" />
                                            <span class="description"><?php printf(__('Type default %sadmin email%s from where this emeil is sending'),'<b>','</b>');?></span>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                            <th scope="row"><label for="admin_cal_count" ><?php _e('Subject'); ?>:</label></th>
                                            <td><input id="email_reservation_subject" name="email_reservation_subject"  class="regular-text code" type="text" size="45" value="<?php echo $email_reservation_subject; ?>" />
                                                <span class="description"><?php printf(__('Type your email subject for %schecking booking%s'),'<b>','</b>');?></span>
                                            </td>
                                    </tr>

                                    <tr valign="top">
                                        <td colspan="2">
                                            <span class="description"><?php printf(__('Type your %semail message for checking booking%s at site. '),'<b>','</b>');  ?></span>
                                              <textarea id="email_reservation_content" name="email_reservation_content" style="width:100%;" rows="2"><?php echo ($email_reservation_content); ?></textarea>
                                              <span class="description"><?php printf(__('Use this shortcodes: '));?></span>
                                              <span class="description"><?php printf(__('%s - inserting name of person, who made booking (field %s requred at form for this bookmark), '),'<code>[name]</code>','[text name]');?></span>
                                              <span class="description"><?php printf(__('%s - inserting dates of booking, '),'<code>[dates]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting type of booking property, '),'<code>[bookingtype]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting detail person info, '),'<code>[content]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting new line'),'<code>&lt;br/&gt;</code>');?></span>
                                              <br/><?php echo htmlentities(sprintf(__('For example: "You need to approve new reservation %s at dates: %s Person detail information:%s Thank you, Booking service."'),'[bookingtype]','[dates]<br/><br/>','<br/> [content]<br/><br/>')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="form-table email-table" >
                                <tbody>
                                    <tr><td colspan="2"  class="th-title"><h2><?php _e('Email to "Person" after approval of booking'); ?></h2></td></tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="admin_cal_count" ><?php _e('From'); ?>:</label></th>
                                        <td><input id="email_approval_adress"  name="email_approval_adress" class="regular-text code" type="text" size="45" value="<?php echo $email_approval_adress; ?>" />
                                            <span class="description"><?php printf(__('Type default %sadmin email%s from where this emeil is sending'),'<b>','</b>');?></span>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                            <th scope="row"><label for="admin_cal_count" ><?php _e('Subject'); ?>:</label></th>
                                            <td><input id="email_approval_subject"  name="email_approval_subject" class="regular-text code" type="text" size="45" value="<?php echo $email_approval_subject; ?>" />
                                                <span class="description"><?php printf(__('Type your email subject for %sapproval of booking%s'),'<b>','</b>');?></span>
                                            </td>
                                    </tr>

                                    <tr valign="top">
                                        <td colspan="2">
                                              <span class="description"><?php printf(__('Type your %semail message for approval booking%s at site'),'<b>','</b>');?></span>
                                              <textarea id="email_approval_content" name="email_approval_content" style="width:100%;" rows="2"><?php echo ($email_approval_content); ?></textarea>
                                              <span class="description"><?php printf(__('Use this shortcodes: '));?></span>
                                              <span class="description"><?php printf(__('%s - inserting name of person, who made booking (field %s requred at form for this bookmark), '),'<code>[name]</code>','[text name]');?></span>
                                              <span class="description"><?php printf(__('%s - inserting dates of booking, '),'<code>[dates]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting type of booking property, '),'<code>[bookingtype]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting detail person info, '),'<code>[content]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting new line'),'<code>&lt;br/&gt;</code>');?></span>
                                              <br/><?php echo htmlentities(sprintf(__('For example: "Your reservation %s at dates: %s has been approved.%sThank you, Booking service."'),'[bookingtype]', '[dates]','<br/><br/>[content]<br/><br/>')); ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="form-table email-table" >
                                <tbody>
                                    <tr><td colspan="2"  class="th-title"><h2><?php _e('Email to "Person" after deny of booking'); ?></h2></td></tr>

                                    <tr valign="top">
                                        <th scope="row"><label for="admin_cal_count" ><?php _e('From'); ?>:</label></th>
                                        <td><input id="email_deny_adress"  name="email_deny_adress" class="regular-text code" type="text" size="45" value="<?php echo $email_deny_adress; ?>" />
                                            <span class="description"><?php printf(__('Type default %sadmin email%s from where this emeil is sending'),'<b>','</b>');?></span>
                                        </td>
                                    </tr>

                                    <tr valign="top">
                                            <th scope="row"><label for="admin_cal_count" ><?php _e('Subject'); ?>:</label></th>
                                            <td><input id="email_deny_subject"  name="email_deny_subject" class="regular-text code" type="text" size="45" value="<?php echo $email_deny_subject; ?>" />
                                                <span class="description"><?php printf(__('Type your email subject for %sdeny of booking%s'),'<b>','</b>');?></span>
                                            </td>
                                    </tr>

                                    <tr valign="top">
                                        <td colspan="2">
                                              <span class="description"><?php printf(__('Type your %semail message for deny booking%s at site'),'<b>','</b>');?></span>
                                              <textarea id="email_deny_content" name="email_deny_content" style="width:100%;" rows="2"><?php echo ($email_deny_content); ?></textarea>
                                              <span class="description"><?php printf(__('Use this shortcodes: '));?></span>
                                              <span class="description"><?php printf(__('%s - inserting name of person, who made booking (field %s requred at form for this bookmark), '),'<code>[name]</code>','[text name]');?></span>
                                              <span class="description"><?php printf(__('%s - inserting dates of booking, '),'<code>[dates]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting type of booking property, '),'<code>[bookingtype]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting detail person info'),'<code>[content]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting reson of cancel booking'),'<code>[denyreason]</code>');?></span>
                                              <span class="description"><?php printf(__('%s - inserting new line'),'<code>&lt;br/&gt;</code>');?></span>
                                              <br/><?php echo htmlentities(   sprintf(__('For example: "Your reservation %s at dates: %s has been  canceled. %s Thank you, Booking service."'), '[bookingtype]' ,'[dates]' , '<br/><br/>[denyreason]<br/><br/>[content]<br/><br/>')); ?>
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


 //   A C T I V A T I O N   A N D   D E A C T I V A T I O N    O F   T H I S   P L U G I N  ///////////////////////////////////////////////////

        // Activate
        function pro_activate() {


               add_option( 'booking_form' , str_replace('\\n\\','',$this->get_default_form()));
               add_option( 'booking_form_show' ,str_replace('\\n\\','',$this->get_default_form_show()));


                $charset_collate = '';
                $wp_queries = array();
                global $wpdb;

                if ( ( ! $this->is_table_exists('bookingtypes')  )) { // Cehck if tables not exist yet
                        if ( $wpdb->has_cap( 'collation' ) ) {
                            if ( ! empty($wpdb->charset) )
                                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
                            if ( ! empty($wpdb->collate) )
                                $charset_collate .= " COLLATE $wpdb->collate";
                        }
                        /** Create WordPress database tables SQL */
                        $wp_queries[] = "CREATE TABLE ".$wpdb->prefix ."bookingtypes (
                             booking_type_id bigint(20) unsigned NOT NULL auto_increment,
                             title varchar(200) NOT NULL default '',
                             PRIMARY KEY  (booking_type_id)
                            ) $charset_collate;";

                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."bookingtypes ( title ) VALUES ( '". __('Default') ."' );";
                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."bookingtypes ( title ) VALUES ( '". __('Appartment #1') ."' );";
                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."bookingtypes ( title ) VALUES ( '". __('Appartment #2') ."' );";
                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."bookingtypes ( title ) VALUES ( '". __('Appartment #3') ."' );";

                        $wp_queries[] = "INSERT INTO ".$wpdb->prefix ."booking ( form ) VALUES (
                         'text^arrival1^10:20~text^departure1^15:40~text^name1^Victoria~text^surname1^Smith~text^email1^victoria@wpdevelop.com~text^phone1^(044)458-77-88~select-one^visitors1^2~checkbox^children1[]^false~textarea^details1^Please, reserve an appartment with fresh flowers.' );";

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

                if ($this->wpdev_bk_paypal !== false) { $this->wpdev_bk_paypal->pro_activate(); }


        }

        //Decativate
        function pro_deactivate(){
            global $wpdb;

            delete_option( 'booking_form');
            delete_option( 'booking_form_show');

            $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'bookingtypes');

            if ($this->wpdev_bk_paypal !== false) { $this->wpdev_bk_paypal->pro_deactivate(); }
        }

    }
}


//  S u p p o r t    f u n c t i o n s       /////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_booking_title( $type_id = 1){ 
    global $wpdb;
    $types_list = $wpdb->get_results( "SELECT title FROM ".$wpdb->prefix ."bookingtypes  WHERE booking_type_id =" . $type_id ); 
    if ($types_list)
        return $types_list[0]->title;
    else
        return '';
}


// A J A X     R e s p o n d e r   Real Ajax with jWPDev sender     //////////////////////////////////////////////////////////////////////////////////
function wpdev_pro_bk_ajax(){
    if (!function_exists ('adebug')) { function adebug() { $var = func_get_args(); echo "<div style='text-align:left;background:#ffffff;border: 1px dashed #ff9933;font-size:11px;line-height:15px;font-family:'Lucida Grande',Verdana,Arial,'Bitstream Vera Sans',sans-serif;'><pre>"; print_r ( $var ); echo "</pre></div>"; } }
    global $wpdb;

    $action = $_POST['ajax_action'];

    switch ($action) {
        case 'ADD_BK_TYPE':
            $title = $_POST[ "title" ];
            $wp_querie  = "INSERT INTO ".$wpdb->prefix ."bookingtypes (
             title
            ) VALUES (
             '".$title."'
            );";

            if ( false === $wpdb->query( $wp_querie ) ) {
                ?> <script type="text/javascript">document.getElementById('ajax_message').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during inserting into BD'); ?></div>'; jWPDev('#ajax_message').fadeOut(5000); </script> <?php
                die();
            } else {
                $newid = (int) $wpdb->insert_id;
                ?> <script type="text/javascript">
                    document.getElementById('ajax_message').innerHTML = '<?php echo __('Saved'); ?>';
                    document.getElementById('last_book_type').innerHTML = '<?php echo '<a href="admin.php?page=' . WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking&booking_type='.$newid.'"  class="bktypetitle">' . $title . '</a>  <a href="#" title="'. __('Delete') .'" style="text-decoration:none;" onclick="javascript:delete_bk_type('.$newid.');"><img src="'.WPDEV_BK_PLUGIN_URL.'/img/delete_type.png" width="8" height="8" /></a>' ?>';
                    jWPDev('#last_book_type').attr("id",'bktype<?php echo $newid; ?>');
                    jWPDev('#last_book_type_separator').attr("id",'bktype_separator<?php echo $newid; ?>');
                    jWPDev('#ajax_message').fadeOut(1000);
                </script> <?php
                die();
            }

            break;

        case 'EDIT_BK_TYPE':
            $title = $_POST[ "title" ];
            $type_id = $_POST[ "type_id" ];

            $wp_querie  = "UPDATE ".$wpdb->prefix ."bookingtypes SET title='".$title."'  WHERE booking_type_id = $type_id";

            if ( false === $wpdb->query( $wp_querie ) ) {
                ?> <script type="text/javascript">document.getElementById('ajax_message').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during editing BD'); ?></div>'; jWPDev('#ajax_message').fadeOut(5000); </script> <?php
                die();
            } else {
                ?> <script type="text/javascript">
                    document.getElementById('ajax_message').innerHTML = '<?php echo __('Saved'); ?>';
                    jWPDev('#ajax_message').fadeOut(1000);
                </script> <?php
                die();
            }
            break;

        case 'DELETE_BK_TYPE':
            $type_id = $_POST['type_id'];

           $wp_querie = "DELETE FROM ".$wpdb->prefix ."bookingtypes WHERE booking_type_id = $type_id";

            if ( false === $wpdb->query( $wp_querie ) ) {
                ?> <script type="text/javascript">document.getElementById('ajax_message').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('Error during deleting from BD'); ?></div>'; jWPDev('#ajax_message').fadeOut(5000); </script> <?php
            } else {
                ?> <script type="text/javascript">
                    document.getElementById('ajax_message').innerHTML = '<?php echo __('Deleted'); ?>';
                    jWPDev('#ajax_message').fadeOut(1000);
                    jWPDev('#bktype<?php echo $type_id; ?>' ).fadeOut(1000);
                    jWPDev('#bktype_separator<?php echo $type_id; ?>' ).fadeOut(1000);
                </script> <?php
            }
            die();

            break;
        default:
            break;
    }

}

?>
