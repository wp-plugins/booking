                var date_approved = [];
                var date2approve = [];

                // Initialisation
                function init_datepick_cal(bk_type,  date_approved_par, my_num_month, start_day ){ 

                        var cl = document.getElementById('calendar_booking'+ bk_type); if (cl == null) return; // Get calendar instance and exit if its not exist

                        if(  wpdev_bk_pro == 1  ) { set_js_validation_mask(); }
                        
                        date_approved[ bk_type ] = date_approved_par;

                        function click_on_cal_td(){
                            if(typeof( selectDayPro ) == 'function') { selectDayPro(  bk_type); }
                        }

                        function selectDay(date) {
                            jWPDev('#date_booking' + bk_type).val(date);
                            if(typeof( selectDayPro ) == 'function') { selectDayPro( date, bk_type); }
                        }

                        function hoverDay(value, date){

                            if(typeof( hoverDayPro ) == 'function') { hoverDayPro(value, date, bk_type); }
                         }

                        function applyCSStoDays(date ){

                            var class_day = (date.getMonth()+1) + '-' + date.getDate() + '-' + date.getFullYear();

                            // Select dates which need to approve, its exist only in Admin
                            if(typeof(date2approve[ bk_type ]) !== 'undefined') 
                                 if(typeof(date2approve[ bk_type ][ class_day ]) !== 'undefined')
                                       return [false, 'cal4date-' + class_day +' date2approve']; // Orange

                            //select Approved dates
                            if(typeof(date_approved[ bk_type ][ class_day ]) !== 'undefined') return [false, 'cal4date-' + class_day +' date_approved']; //Blue or Grey in client

                            return [true, 'cal4date-' + class_day ];
                        }


                        // Configure and show calendar
                        jWPDev('#calendar_booking'+ bk_type).datepick(
                                {   beforeShowDay: applyCSStoDays,
                                    onSelect: selectDay,
                                    onHover:hoverDay,
                                    showOn: 'both',
                                    multiSelect: 50,
                                    numberOfMonths: my_num_month,
                                    stepMonths: 1,
                                    prevText: '<<',
                                    nextText: '>>',
                                    dateFormat: 'dd.mm.yy',
                                    changeMonth: false, // True if month can be selected directly, false if only prev/next
                                    changeYear: false,
                                    minDate: 0, maxDate: '1Y',
                                    showStatus: false,
                                    multiSeparator: ', ',
                                    closeAtTop: false,
                                    firstDay:start_day,
                                    gotoCurrent: false,
                                    hideIfNoPrevNext:true,
                                    rangeSelect:false,
                                    useThemeRoller :false // ui-cupertino.datepick.css
                                }
                        );

                        //jWPDev('td.datepick-days-cell').bind('click', 'selectDayPro');
                }


                //Highlight dates when mouse over
                function highlightDay(td_class, bk_color){
                   jWPDev('.'+td_class).css({'background-color' : bk_color});
                }


                // Run this function at Admin side when click at Approve button
                function bookingApprove(is_delete, is_in_approved){

                    var checkedd = jWPDev(".booking_appr"+is_in_approved+":checked");
                    id_for_approve = "";

                    // get all IDs
                    checkedd.each(function(){
                        var id_c = jWPDev(this).attr('id');
                        id_c = id_c.substr(13,id_c.length-13)
                        id_for_approve += id_c + "|";
                    });

                    //delete last "|"
                    id_for_approve = id_for_approve.substr(0,id_for_approve.length-1);

                    var denyreason ;
                    if (is_delete ==1) {
                        if (is_in_approved==0) { denyreason= jWPDev('#denyreason').val(); }
                        else                   { denyreason= jWPDev('#cancelreason').val(); }
                    } else { denyreason = ''; }



                    if (id_for_approve!='') {

                        var wpdev_ajax_path = wpdev_bk_plugin_url+'/' + wpdev_bk_plugin_filename ;

                        var ajax_type_action='';
                        if (is_delete) {  ajax_type_action =  'DELETE_APPROVE'; var ajax_bk_message = 'Deleting...'; }
                        else           {  ajax_type_action =  'UPDATE_APPROVE'; var ajax_bk_message = 'Updating...';};

                        document.getElementById('ajax_working').innerHTML =
                        '<div class="info_message ajax_message" id="ajax_message">\n\
                            <div style="float:left;">'+ajax_bk_message+'</div> \n\
                            <div  style="float:left;width:80px;margin-top:-3px;">\n\
                                   <img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif">\n\
                            </div>\n\
                        </div>';

                        jWPDev.ajax({                                           // Start Ajax Sending
                            url: wpdev_ajax_path,
                            type:'POST',
                            success: function (data, textStatus){ if( textStatus == 'success')   jWPDev('#ajax_respond').html( data );  },
                            error:function (XMLHttpRequest, textStatus, errorThrown){ window.status = 'Ajax sending Error status:'+ textStatus; },
                            // beforeSend: someFunction,
                            data:{
                                ajax_action : ajax_type_action,
                                approved : id_for_approve,
                                is_in_approved : is_in_approved,
                                denyreason: denyreason
                            }
                        });
                        return false;
                    }
                    return true;
                }



                // Scroll to script
                function makeScroll(object_name) {
                     var targetOffset = jWPDev( object_name ).offset().top;
                     jWPDev('html,body').animate({scrollTop: targetOffset}, 1000);
                }

                // reservation button click
                function setReservedSelectedDates( bk_type ){

                    var sel_dates = jWPDev('#calendar_booking'+bk_type).datepick('getDate');

                    for( var i =0; i <sel_dates.length; i++) {
                      var class_day2 = (sel_dates[i].getMonth()+1) + '-' + sel_dates[i].getDate() + '-' + sel_dates[i].getFullYear();
                      date_approved[ bk_type ][ class_day2 ] = [ (sel_dates[i].getMonth()+1) ,  sel_dates[i].getDate(),  sel_dates[i].getFullYear()];
                    }

                    jWPDev('#calendar_booking'+bk_type).datepick('refresh');

                    // Set date booking to ''
                    document.getElementById('date_booking'+bk_type).value = '';

                     //if (strpos($_SERVER['REQUEST_URI'],'booking.php')!==false){ echo 'var is_admin = 1;'; } else { echo 'var is_admin = 0;'; }
                    var is_admin = 0;
                    if (location.href.indexOf('booking.php') != -1 ) {
                        is_admin = 1;
                    }
                    if (is_admin == 0) {
                        // Get calendar from the html and insert it before form div, which will hide after btn click
                        jWPDev('#calendar_booking'+bk_type).insertBefore("#booking_form_div"+bk_type);
                        document.getElementById("booking_form_div"+bk_type).style.display="none";
                        makeScroll('#calendar_booking'+bk_type);
                    } else {
                        location.reload(true); /*
                        var submit_form = document.getElementById("booking_form"+bk_type);
                        var count = submit_form.elements.length;
                        // Serialize form here
                        for (i=0; i<count; i++)   {
                            var element = submit_form.elements[i];
                            if ( (element.type !=='button') && (element.type !=='hidden') &&  (element.type !=='checkbox')   ) {
                                element.value='';
                            }
                            if ( element.name == ('date_booking' + bk_type) ) {
                                element.value='';
                            }
                        } /**/
                    }


                }


                //<![CDATA[
                function mybooking_submit( submit_form , bk_type){


                    var count = submit_form.elements.length;
                    var formdata = '';

                    // Serialize form here
                    for (i=0; i<count; i++)   {
                        var element = submit_form.elements[i];
                        if ( (element.type !=='button') && (element.type !=='hidden') && ( element.name !== ('date_booking' + bk_type) )   ) {           // Skip buttons and hidden element - type
                            var inp_value;
                            if (element.type !=='checkbox') { inp_value = element.value; }      // if checkbox so then just check checked
                            else                            { inp_value = element.checked; }


                            // Validation Check --- Requred fields
                            if ( element.className.indexOf('wpdev-validates-as-required') !== -1 ){
                                if ( inp_value == '') {
                                    jWPDev("[name='"+ element.name +"']")
                                            .fadeOut( 350 ).fadeIn( 300 )
                                            .fadeOut( 350 ).fadeIn( 400 )
                                            .animate( {opacity: 1}, 4000 )
                                    ;  // mark red border
                                    jWPDev("[name='"+ element.name +"']")
                                            .after('<div class="wpdev-help-message">This field is required</div>'); // Show message
                                    jWPDev(".wpdev-help-message")
                                            .css( {'color' : 'red'} )
                                            .animate( {opacity: 1}, 4000 )
                                            .fadeOut( 1000 );   // hide message
                                    element.focus();    // make focus to elemnt
                                    return;
                                }
                            }

                            // Validation Check --- Email correct filling field
                            if ( element.className.indexOf('wpdev-validates-as-email') !== -1 ){
                                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                                if(reg.test(inp_value) == false) {
                                    jWPDev("[name='"+ element.name +"']")
                                            .fadeOut( 350 ).fadeIn( 300 )
                                            .fadeOut( 350 ).fadeIn( 400 )
                                            .animate( {opacity: 1}, 4000 )
                                    ;  // mark red border
                                    jWPDev("[name='"+ element.name +"']")
                                            .after('<div class="wpdev-help-message">Uncorrect email field</div>'); // Show message
                                    jWPDev(".wpdev-help-message")
                                            .css( {'color' : 'red'} )
                                            .animate( {opacity: 1}, 4000 )
                                            .fadeOut( 1000 );   // hide message
                                    element.focus();    // make focus to elemnt
                                    return;
                               }
                            }


                            if(  wpdev_bk_pro == 1  ) { if (write_js_validation(element, inp_value )) { return;} ; }

                            if (formdata !=='') formdata +=  '~';                                   // next field element

                            formdata += element.type + '^' + element.name + '^' + inp_value ;       // element attr
                        }
                    }

                    if (document.getElementById('date_booking' + bk_type).value == '') {
                        alert('Please, select reservation date(s) at Calendar.');
                        return;
                    }


                    document.getElementById('submiting' + bk_type).innerHTML =
                        '<div style="height:20px;width:100%;text-align:center;margin:15px auto;"><img src="'+wpdev_bk_plugin_url+'/img/ajax-loader.gif"><//div>';

                    // Ajax POST here
                    jWPDev.ajax({                                           // Start Ajax Sending
                        url: wpdev_bk_plugin_url+'/' + wpdev_bk_plugin_filename,
                        type:'POST',
                        success: function (data, textStatus){ if( textStatus == 'success')   jWPDev('#ajax_respond_insert' + bk_type).html( data ) ; },
                        error:function (XMLHttpRequest, textStatus, errorThrown){ window.status = 'Ajax sending Error status:' + textStatus ;},
                        // beforeSend: someFunction,
                        data:{
                            ajax_action : 'INSERT_INTO_TABLE',
                            bktype: document.getElementById('bk_type' + bk_type).value ,
                            dates: document.getElementById('date_booking' + bk_type).value ,
                            form: formdata
                        }
                    });
                    return;
                }
                //]]>
