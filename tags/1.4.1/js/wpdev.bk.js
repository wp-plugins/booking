    var date_approved = [];
    var date2approve = [];
    //var tooltips = [];

    // Initialisation
    function init_datepick_cal(bk_type,  date_approved_par, my_num_month, start_day ){

            var cl = document.getElementById('calendar_booking'+ bk_type); if (cl == null) return; // Get calendar instance and exit if its not exist

            date_approved[ bk_type ] = date_approved_par;

            function click_on_cal_td(){
                if(typeof( selectDayPro ) == 'function') { selectDayPro(  bk_type); }
            }

            function selectDay(date) {
                jWPDev('#date_booking' + bk_type).val(date);
                if(typeof( selectDayPro ) == 'function') { selectDayPro( date, bk_type); }
            }

            function hoverDay(value, date){
                if(typeof( hoverDayTime ) == 'function') { hoverDayTime(value, date, bk_type); }
                if(typeof( hoverDayPro ) == 'function')  { hoverDayPro(value, date, bk_type); }
             }

            function applyCSStoDays(date ){

                var class_day = (date.getMonth()+1) + '-' + date.getDate() + '-' + date.getFullYear();
                var th=0;
                var tm=0;
                var ts=0;
                var time_return_value = false;
                // Select dates which need to approve, its exist only in Admin
                if(typeof(date2approve[ bk_type ]) !== 'undefined')
                   if(typeof(date2approve[ bk_type ][ class_day ]) !== 'undefined') {
                      th = date2approve[ bk_type ][ class_day ][0][3];
                      tm = date2approve[ bk_type ][ class_day ][0][4];
                      ts = date2approve[ bk_type ][ class_day ][0][5];
                      if ( ( th == 0 ) && ( tm == 0 ) && ( ts == 0 ) )
                          return [false, 'cal4date-' + class_day +' date2approve']; // Orange
                      else {
                          time_return_value = [true, 'cal4date-' + class_day +' date2approve timespartly']; // Times
                          if(typeof( isDayFullByTime ) == 'function') {
                              if ( isDayFullByTime(bk_type, class_day ) ) return [false, 'cal4date-' + class_day +' date2approve']; // Orange
                          }
                      }                          
                   }

                //select Approved dates
                if(typeof(date_approved[ bk_type ]) !== 'undefined')
                  if(typeof(date_approved[ bk_type ][ class_day ]) !== 'undefined') {
                      th = date_approved[ bk_type ][ class_day ][0][3];
                      tm = date_approved[ bk_type ][ class_day ][0][4];
                      ts = date_approved[ bk_type ][ class_day ][0][5];
                      if ( ( th == 0 ) && ( tm == 0 ) && ( ts == 0 ) )
                        return [false, 'cal4date-' + class_day +' date_approved']; //Blue or Grey in client
                      else {
                        time_return_value = [true,  'cal4date-' + class_day +' date_approved timespartly']; // Times
                        if(typeof( isDayFullByTime ) == 'function') {
                            if ( isDayFullByTime(bk_type, class_day ) ) return [false, 'cal4date-' + class_day +' date_approved']; // Blue or Grey in client
                        }
                      }
                  }

                if ( time_return_value !== false )  return time_return_value;
                else                                return [true, 'cal4date-' + class_day ];
            }

            function changeMonthYear(year, month){ 
                if(typeof( prepare_tooltip ) == 'function') {
                    setTimeout("prepare_tooltip("+bk_type+");",1000);
                }
            }
            // Configure and show calendar
            jWPDev('#calendar_booking'+ bk_type).datepick(
                    {   beforeShowDay: applyCSStoDays,
                        onSelect: selectDay,
                        onHover:hoverDay,
                        onChangeMonthYear:changeMonthYear,
                        showOn: 'both',
                        multiSelect: multiple_day_selections,
                        numberOfMonths: my_num_month,
                        stepMonths: 1,
                        prevText: '<<',
                        nextText: '>>',
                        dateFormat: 'dd.mm.yy',
                        changeMonth: false, 
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
            if(typeof( prepare_tooltip ) == 'function') {  setTimeout("prepare_tooltip("+bk_type+");",1000); }
    }


    //   A D M I N    Highlight dates when mouse over
    function highlightDay(td_class, bk_color){
       jWPDev('.'+td_class).css({'background-color' : bk_color });
       jWPDev('.'+td_class + ' a').css({'background-color' : bk_color });
    }


    // A D M I N    Run this function at Admin side when click at Approve button
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

    // Aftre reservation action is done
    function setReservedSelectedDates( bk_type ){

        var sel_dates = jWPDev('#calendar_booking'+bk_type).datepick('getDate');

        for( var i =0; i <sel_dates.length; i++) {
          var class_day2 = (sel_dates[i].getMonth()+1) + '-' + sel_dates[i].getDate() + '-' + sel_dates[i].getFullYear();
          date_approved[ bk_type ][ class_day2 ] = [ (sel_dates[i].getMonth()+1) ,  sel_dates[i].getDate(),  sel_dates[i].getFullYear(),0,0,0];
        }

        jWPDev('#calendar_booking'+bk_type).datepick('refresh');

        document.getElementById('date_booking'+bk_type).value = ''; // Set textarea date booking to ''

        var is_admin = 0;
        if (location.href.indexOf('booking.php') != -1 ) { is_admin = 1; }
        if (is_admin == 0) {
            // Get calendar from the html and insert it before form div, which will hide after btn click
            jWPDev('#calendar_booking'+bk_type).insertBefore("#booking_form_div"+bk_type);
            document.getElementById("booking_form_div"+bk_type).style.display="none";
            makeScroll('#calendar_booking'+bk_type);
        } else { location.reload(true); }
    }

    //Admin function s for checking all checkbos in one time
    function setCheckBoxInTable(el_stutus, el_class){
         jWPDev('.'+el_class).attr('checked', el_stutus);
    }

    //<![CDATA[
    function mybooking_submit( submit_form , bk_type){

        function showErrorMessage( element , errorMessage) {

            jWPDev("[name='"+ element.name +"']")
                    .fadeOut( 350 ).fadeIn( 300 )
                    .fadeOut( 350 ).fadeIn( 400 )
                    .animate( {opacity: 1}, 4000 )
            ;  // mark red border
            jWPDev("[name='"+ element.name +"']")
                    .after('<div class="wpdev-help-message">'+ errorMessage +'</div>'); // Show message
            jWPDev(".wpdev-help-message")
                    .css( {'color' : 'red'} )
                    .animate( {opacity: 1}, 4000 )
                    .fadeOut( 1000 );   // hide message
            element.focus();    // make focus to elemnt
            return;

        }

        var count = submit_form.elements.length;
        var formdata = '';
        var inp_value;
        var element;

        // Serialize form here
        for (i=0; i<count; i++)   {
            element = submit_form.elements[i];
            if ( (element.type !=='button') && (element.type !=='hidden') && ( element.name !== ('date_booking' + bk_type) )   ) {           // Skip buttons and hidden element - type
                
                if (element.type !=='checkbox') { inp_value = element.value; }                      // if checkbox so then just check checked
                else                            { inp_value = element.checked; }
                
                if ( element.className.indexOf('wpdev-validates-as-required') !== -1 ){             // Validation Check --- Requred fields
                    if ( inp_value == '')  { showErrorMessage( element , message_verif_requred); return; }
                }

                if ( element.className.indexOf('wpdev-validates-as-email') !== -1 ){                // Validation Check --- Email correct filling field
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if(reg.test(inp_value) == false) { showErrorMessage( element , message_verif_emeil);  return; }
                }

                if(typeof( write_js_validation ) == 'function') { if (write_js_validation(element, inp_value, bk_type )) return;   }

                if (formdata !=='') formdata +=  '~';                                                // next field element
                formdata += element.type + '^' + element.name + '^' + inp_value ;                    // element attr
            }
        }

        if (document.getElementById('date_booking' + bk_type).value == '') {
            alert(message_verif_selectdts);
            return;
        }

//alert('booking now')      ;
//return;

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


    // Prepare to show tooltips
    function prepare_tooltip(myParam){

          jWPDev("#calendar_booking" + myParam+ " .timespartly").tooltip( {
                          tip:'#demotip'+myParam,
                          predelay:500,
                          delay:500,
                          position:"top center",
                          offset:[2,0],
                          opacity:0.9
          });
          //    tooltips[myParam] = jWPDev("#calendar_booking" + myParam+ " .timespartly").tooltip( { tip:'#demotip'+myParam, predelay:500, api:true  });
          //    tooltips[myParam].show();
    }
