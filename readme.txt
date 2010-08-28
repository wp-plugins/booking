=== Booking Calendar ===
Contributors: wpdevelop
Donate link: http://onlinebookingcalendar.net/purchase/
Tags: Booking, Booking calendar, Book, to book, Reservation, Calendar, hotel, rooms, rent, appointment, scheduling, availability, availability calendar, event, events, event calendar, resource scheduling, Rental, Meeting scheduling, reservation plugin, accommodations, dates, time
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 2.3

Booking Calendar - its plugin for online reservation and availability checking service for your site.
== Description ==

This Wordpress plugin will enable <strong>online booking services</strong> for your site. Visitors to your site will be able to <strong>check availability</strong> or <strong>to book</strong> of apartments, houses, hotel rooms, or services you offer. They can also <strong>make reservations and appointments</strong> with the ability to choose from multi-day, single day, or by the hour booking. Your clients can even view and register for upcoming events. With integrated <strong>Paypal</strong>/<strong>Sage</strong> payment support your clients can <strong>pay online</strong>!

No recurring payments, unlike other solutions. Only single time purchase of Professional versions or usage Booking Calendar Standard for free. Keep all your booking resource on your site, eliminating the risk of a third-party site from going offline, potentially losing all your client data.

This plugin is extremely easy to use and very flexible, built with full Ajax and jQuery support.


You can view a <strong>live demo</strong> of <strong>Booking Calendar Premium</strong> here (<a href="http://onlinebookingcalendar.com/demo/" title="Booking Calendar Professional Live Demo">Client side</a>. <a href="http://onlinebookingcalendar.com/wp-admin/" title="Booking Calendar Professional Live Demo - Admin Panel">Admin Panel</a> )

You can also view a <strong>live demo</strong> of <strong>Booking Calendar Hotel Edition</strong> here (<a href="http://hotel.onlinebookingcalendar.com/" title="Booking Calendar Hotel Edition Live Demo">Client side</a> <a href="http://hotel.onlinebookingcalendar.com/wp-admin/" title="Booking Calendar Hotel Edition Live Demo - Admin Panel">Admin Panel</a> )


<a href="http://onlinebookingcalendar.net/purchase/" title="Buy Booking Calendar Professional / Premium / Hotel Edition">Check <strong>feature list</strong> for each version and make <strong>Purchase now</strong></a> or try <strong>Booking Calendar Standard</strong> for <strong>free</strong>.

<a href="http://wpdevelop.com/" title="Custom WordPress Plugins Development">Support and Developments of WordPress Pugins</a>

Online Booking Calendar is great for:

* Resource scheduling (Rental, Rooms, houses, apartments, Equipment Car pools, Hotel rooms)
* Client scheduling ( Beauty salon, Spa management, Hairdresser, Massage therapist, Acupuncture)
* Meeting scheduling (Coaching, Phone advice)
* Event scheduling (Conference, Course, Fitness center, Yoga class, Gym)
* Patient scheduling (Doctor, Clinic, Medical)
* Or any other service, where can be done reservation for some days or hours.

<strong>Features</strong>:

* Make booking reservations by selecting dates at one or several calendar(s) 			
* Email notifications for administrator and site visitors 			
* Comfortable Admin panel for management of reservations
* Easy integration into posts/pages, using TinyMCE button. 			
* Booking calendar widget 			
* Validations of required form fields and email field 			
* Multi language support
* Settings start day of week, format of date for emails and booking table, and much more… 			

<strong>Advanced Professional / Premium / Hotel Edition Features</strong>:

 * Support of multiple booking resources (rooms, houses, cars, seats…)
 * Booking form fields customization, Extra fields on booking form
 * Editing exist bookings by administrator
 * Editing booking by customer, posibility to cancel booking
 * Emails customization for new reservations, confirmation or declining  of booking 			
 * Booking for specific time in a day 			
 * Online payment (PayPal, Sage payment support)
 * Week booking or any other day range selection booking
 * Support of Multi boooking at the same day at Hotel Edition
 * Adding remarks by administrator for each booking
 * Several booking forms with different fields customization
 * Season filter for settings available/unavailable dates
 * Cost Rates system based on season filter. Cost, which depends from number of selected days for booking
 * Advanced cost management, based on selection of fields from booking form
 * Much more ...


== Installation ==
<strong style="color:#f50;">Because of update CSS and JS files, please clear browser cache, after you made this update!!!</strong>

1. Upload entire `booking` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure Settings at the submenu of "Booking" menu
5. Add bookmark to your post/page using new button at toolbar.

== Frequently Asked Questions ==

Please see <a href="http://onlinebookingcalendar.com/faq/" title="faq">FAQ</a>.

If you have any further questions, please send them to my <a href="mailto:info@wpdevelop.com" title="faq">emeil</a>.

== Screenshots ==

1. Booking administration panel. Here you can approve or decline new bookings
2. Adding new reservation
3. Adding booking form into post/page, using new booking button
4. Custom Booking form with captcha and legend
5. Paypal page for online payment after booking process
6. General booking settings page
7. Customization booking form fields and view at booking tables
8. Customization emeils, which are sending after new booking is done and after approval or cancelation of booking
9. Paypal and cost customisation page
10. Customization rates of booking resource depends from season. (For example: the cost of day can be higher at weekend)
11. Days avalaibility customization page (setting available and unavailable days for booking resources)
12. Season filter page
13. Customization rates of booking resource depends from number of selected days for reservation
14. Booking widjets settings


== Changelog ==

= 2.3 =
* Professional / Premium / Hotel version features:
 * Posibility to edit reservation by visitors of sites. (For this operation need to create new page with shortcode [bookingedit]. At emails settings you need to use this [visitorbookingediturl] shortcode for inseerting edit link) (Professional, Premium, Hotel Edition)
 * Posibility to cancel some reservation by visitors of site (For this operation need to create new page with shortcode [bookingedit]. At emails settings you need to use this [visitorbookingcancelurl] shortcode for inseerting edit link) (Professional, Premium, Hotel Edition)
 * Direct editing cost of reservation by admin. ( Premium, Hotel Edition)
 * Send payment request to visitor of site by email. Posibility to enter reason of this payment. (For this operation need to create new page with shortcode [bookingedit]. At emails settings you need to use this [visitorbookingpayurl] shortcode for inseerting edit link)  ( Premium, Hotel Edition )
 * New email template for senfing payment request to customer. ( Premium, Hotel Edition)
 * Fixxing issue with checking time (which are already at the past for today) during filling booking form. ( Premium, Hotel Edition )
* Features and issue fixings in All versions:
 * Posibility to Aprove / Decline bookings without sending emails to visitors. New checkbox under Aprove and Cancel buttons for sending or not sending emails.
 * Posibility to Add new booking by admin without sending email to visitor. New checkbox for sending or not sending emails.


= 2.2 =
* Professional / Premium / Hotel version features:
 * Set posibility to activate calculatation of the capacity for available days, depends from number of visitors, which was at the form during previos booking(s) (Hotel Edition)
 * Add AM/PM time format for time shortcodes: [rangetime], [starttime] and [endtime]. You need to set at the General Booking settings page time format in AM/PM format, but bookmarks time format will show in AM/PM format, but at the form fields customization page, you still need to enter predefined values of time in military format. ( Premium, Hotel Edition )
 * Add posibility to show payment description nearly Payment button ( Premium, Hotel Edition )
 * Fixed issue with rates calculation, when fixed range time is activated (usual time also) and cost is set per night or day (Hotel Edition)
 * Hiding time, which are already booked at the selection box during single day selections. Available at the [rangetime] shortcode. ( Premium, Hotel Edition )
 * Adding % to the customization cost at "cost depends from number of selected days of reservations"- CDFND . So now its possible to combine rates with CDFND, is CDFND was set as %. Its mean that previosly is calculated rates cost and then applying % from CDFND. So if you set 0% for 6th day, its mean that cost of 6th selected day will be 0 and visitor will pay only for 5 selected days. If no % at the CDFND, its will calculated as early independent from rates. (Hotel Edition)
 * New shortcode of usage only Booking Form without calendar for reservation of sinle day at Hotel Edition version with usage option: "Visitors number apply to capacity". Ex.: [bookingform selected_dates='20.08.2010' type=1] (Hotel Edition)
* Features and issue fixings in All versions:
 * Fixed selection of a day (properly background and color selection), which have already some time reserved, at CSS skins.
 * Fixing several issues
 * Oprimization CSS and JS files (need browser cashe clearing after update of previos version)
 
= 2.1 =
* Professional / Premium / Hotel version features:
 * Added SandBox - test payment, using PayPal payment (Premium, Hotel Edition )
 * Autofill button for automatic filling all booking fields during "Adding new reservation" from admin panel. Its will save time of administrator for fast making reservations. (Premium, Hotel Edition )
 * Added GBP and JPY signs for showing currency (Premium, Hotel Edition )
 * Fixed issue with returned URL from Paypal (Premium, Hotel Edition )
 * Fixed issue for cost calculation, which is depends from number of selected days for booking. Issue was with option "togather". ( Hotel Edition )
 * Fixing issue at advanced cost calculation, when no time is using at the booking form. ( Hotel Edition )
* Features and issue fixings in All versions:
 * Add some hooks for compatibility with orders support plugin
 * Removes .htaccess file from plugin installation. (At some servers have problems with configuration) 
 * Fixed small issue with sorting at booking table
 * Fixing issue with loadin JS file, which is not requred for Eng. version

= 2.0 =
* Professional / Premium / Hotel version features:
 * Fixing issue with showing warnings during serialize exeution at WP3.0 ( Hotel Edition)
 * New design of selection booking resources items
* Features and issue fixings in All versions:
 * Optimize CSS at skins
 * New design of Settings Menu
 * Some new icons
 * Show help tooltips for some actions
 * Translation into Spanish by <a href="http://www.nortasundigitala.net" target="_blank">Nortasun Digitala (Basque Sarea S.L.)</a>
 * Add additional checking for issue: "500 Internal Server Error", and set link for solving it.
 * Optimize security of execution script. Restrict permission from listing of folders at some servers. Deny direct execution of script from browser. Show message about it.

= 1.9.3 =
* Professional / Premium / Hotel version features:
 * Show all new incoming bookings from all resources at one page - Incoming
 * Make disable some options at the rangetime selections (drop down list with time intervals), during single day selections at the calendar, when some time (in selected day) already booked.
 * Set posibility to show time in diferent formats (using AM/PM and not using it) at rangetime selections (Premium, Hotel Edition)
 * Fixing issue with editing of bookings with checkbox, which are include multiple values for checking (Professional, Premium, Hotel Edition)
* Features and issue fixings in All versions:
 * Fixing IE7 issue of showing calendar at some wordpress themes.
 * Fixing some spelling.

= 1.9.2 =
* Professional / Premium / Hotel version features:
 * Customization and sending email to visitor of site, after visitor is made booking. By default its turned Off.
 * Posibility to set costs of several days, depends from number of days during selection these days at the booking form. This new option is available at the advanced day cost, which is depends from number of selected days for booking. ( Hotel Edition )
* Features and issue fixings in All versions:
 * Inserted moderate link into email for admin after new booking is done.
 * Setting default date view as a short dates view ( its mean by default dates will show in format 05/15/2010 - 05/17/2010, but you can still chnage it at settings to this view 05/15/2010, 05/16/2010, 05/17/2010 )

= 1.9.1 =
* Professional / Premium / Hotel version features:
 * Advanced costs using checkbox option. You can add additional cost or discounts, which will calculated if visitor of your site will check ON specific check box (Hotel Edition)
 * Added posibility to set advanced day cost, which is depends from number of selected days for booking. This feature work only if cost per day is selected. If this feature is activated, rates season system will not work. (Hotel Edition)
 * Fixing issue with sorting dates at the booking table ( Hotel Edition version )
 * Fixing HTML at remark fields.
 * Optimizing of showing advanced costs at the settings page ( Hotel Edition version )
 * Cost implementation into emeil (Premium, Hotel Edition)
* Features and issue fixings in All versions:
 * CSS optimisation

 
= 1.9 =
* Professional / Premium / Hotel version features:
 * New Sage payment system
 * Added new countries field list ( Professional, Premium, Hotel Edition)
 * Multi booking form customization. Posibility to create and assign several booking forms into posts/pages for some booking resources.
 * Optimize workflow of Hotel Edition version for booking resource, which set maximum number of items (seats, rooms) to 1. In this situation its work in the same way as Premium version.
 * Optimize of workflow rates season, when payment set as "fixed deposit" (Hotel Edition)
 * Fixing issue with durationtime, when start time set as a select box (Premium, Hotel Edition)
 * Added feature of showing Name ([name]) and Second name ([secondname]) inside of emails subject  (Professional, Premium, Hotel Edition)
* Features and issue fixings in All versions:
 * Translation into Belorussian by <a href="http://pc.de" target="_blank">Marcis G</a>
 * Fixing some small IE7 issue
 * Fixing samall issue with user rights

= 1.8 =
* Professional / Premium / Hotel version features:
 * Discounts or additional costs at Advanced cost management - cost depends from any "select" fields (for example for using some objects or depends from number of visitors and so on). So you can set additional cost or discounts depends from option selected by visitor. This additional cost can be fixid cash or set in procent from original booking cost. Its very flexible. You can set it at the "Paypal and cost" settings page at advanced cost block.    ( Hotel Edition version )
 * Hourly season filter - rates. Beta! Rates depends from hour entered by visitor. ( Hotel Edition version )
* Features and issue fixings in All versions:
 * Admin booking emeil modification. From now toy can change admin emeil for bookings at the settings page at Booking Calendar Standard version (free version).
 * Setting maximum number of monthes inside of booking calendar. Early was 1 year. Right now can set from 1 month to 10 years

= 1.7.4 =
* Professional / Premium / Hotel version features:
 * Advanced cost management - cost depends from number of visitors ( Hotel Edition version )
 * Hourly season filter. Beta! Need additional testing !!! ( Hotel Edition version )
* Features and issue fixings in All versions:
 * WordPress 3.0 compatibility
 * Support new WordPress theme - Twenty Ten 0.7
 * Hide booking form, if the booking form with the same booking resource are already inside of actual page. Booking Calendar Standard have only 1 booking resource, so its can show only 1 booking form at the page (its actual for situation of showing widget and booking form inside of post/page).

= 1.7.3 =
* Professional / Premium / Hotel version features:
 * Instant (ajax) update of showing tooltip remarks during updating of remarks (Pro, Premium, Hotel Edition)
 * Time duration of booking at the (Premium, Hotel Edition)
* Features and issue fixings in All versions:
 * More easy managemnt of bookings using sort by Dates, ID, Name and Email at the booking table
 * Some grammatical changes at emails and booking form.

= 1.7.2 =
* Professional / Premium / Hotel version features:
 * Fixing of showing bookings, which are belong to the default booking resource which are deleted, so then by default takes fisrst exist booking resource.
 * Add posibility to select time of booking using 1 selectbox, where in dropdown list hav values like these: "10:00 - 12:00" "12:00 - 14:00" and so on. Usefull whenbooking is possible only for prdefined times. (Premium and Hoel Edition version)
* Features and issue fixings in All versions:
 * Fixing several JS
 * Optimize CSS in standard skin at admin panel

= 1.7.1 =
* Professional / Premium / Hotel version features:
 * Posibility to enter direct cost of a day/night/hour in rate season filter.  Direct curency rate type have top prioritet in seson filters. For example: we have several seson filters: weekends, summer and winter. And we are have booking resource wih day cost $100, and we are set next rates: Weekend = 50%, Winter 75%, Summer = $300. So then its mean if we are select WORK DAY at Winter its will cost $100 + 75% = $175, if we are select WeekEnd day at winter $100 + 75% + 50% = $262,5  but if we select workday or weekend at the summer its will return $300, because of top prioritet for curency rate type.
* Features and issue fixings in All versions:
 * Posibility to insert into post/page only availability calendar. You can select whether to insert booking form or booking calendar.
 * Replaced text field for entering number of calendar month to dropdown lists.

= 1.7 =
* Professional / Premium / Hotel version features:
 * Added 2 new premium skins - Premium steel and Premium - marine (default for paid versions)
 * Admin edit bookings functionality - from now at paid versions you can edit booking (for some corrections), which was made by visitor of your site. Emeil according modifications is also will send to the visitor of site, after saving of modification.
 * New emeil template, which is sending after booking modifications are done by admin.
 * Remarks for bookings. From now admin also can add some own remarks to each bookings. Remarks are visible only for admin.
* Features and issue fixings in All versions:
 * Set additional checking for saving default count of calendars at admin panel
 * Set checking for posibility to show at admin booking page more then 3 monthes down to the page (for example 12 monthes)
 * Optimize CSS styles at skins for showing booking calendar at admin and client side

= 1.6 =
* Professional / Premium / Hotel version features:
 * Added 2 premium skins - Premium black and Premium - light
* Features and issue fixings in All versions:
 * New skins manager, from now all skins (CSS) will be at the folder booking/css/skins . So if you will create new sking you just need put it to this folder.
 * Added 1 new skin - Black
 * Remove top Today line from calendar, create it more compact and stylish.

= 1.5.8 =
* Professional / Premium / Hotel version features:
 *
* Features and issue fixings in All versions:
 * New shortcode [bookingcalendar] for showing only Booking Caendar without booking Form at post /page. For showing avalaibility. [bookingcalendar nummonths=2 type=1]
 * Added Danish language file
 * Optimize CSS style for showing booking form
 * New title icons
 * New screenshots and descriptions

= 1.5.7 =
* Professional / Premium / Hotel version features:
 *
* Features and issue fixings in All versions:
 * Optimize CSS at admin menu
 * Fixed compatibility with xLanguage plugin
 * Fixed compatibility with Pagemash plugin

= 1.5.6 =
* Professional / Premium / Hotel version features:
 * Do not link to the paypal, when cost price is 0 ( Premium, Hotel Edition )
 * Fixed issue of highlighting tooltip undefined showing info, after booking is done. ( Premium, Hotel Edition )
* Features and issue fixings in All versions:
 * Remove images descriptions of paid version from main Booking Calendar Admin panel page and from Booking Calendar General settings page (advnaced settings image description).
 * New Menu links design
 * Some CSS improvements

= 1.5.5 =
* Features and issue fixings in All versions:
 * Fixing error showing during updating plugin to version 1.5.4 at WordPress version 2.8 and older.

= 1.5.4 =
* Professional / Premium / Hotel version features:
 * Showing availability of booking resources at the highlighting tooltip ( Hotel Edition )
 * Setting start day of selection in dynamic range selection, using 2 mouse click for selection (Premium, Hotel Edition )
 * Setting minimum number of days for selection in dynamic range selection, using 2 mouse click for selection (Premium, Hotel Edition )
 * More easy selection/editing  of time format (Premium, Hotel Edition )
* Features and issue fixings in All versions:
 * More easy selection/editing  of date format

= 1.5.3 =
* Professional / Premium / Hotel version features:
 * Showing cost of day at the highlighting tooltip ( Hotel Edition )
* Features and issue fixings in All versions:
 * Short view of severeal days at emails and booking table. For exmaple during booking 01.06.2010, 02.06.2010, 03.06.2010, 04.06.2010 now you can set option to show it like  01.06.2010 - 04.06.2010

= 1.5.2 =
* Professional / Premium / Hotel version features:
  * Rates feature - costs depends from the season. Example: Payment cost calculation depends from the period - July and August the price for a day is € 100,00. From January until March the price is € 50,00 and during April and May the price is € 70,00 and so on.  ( Hotel Edition )
  * Activate / Deactivate sending of emails at the Profesional, Premium and Hotel edition version. [visitoremeil] - shortcode (at field "To" of form "Email to "Admin" after booking at site") for sending emails also to the visitor after booking is made.  ( Pro, Premium,  Hotel Edition )
  * Added new way of range selections by mouse selection begin and end days of range (in 2 mouse clicks)  ( Premium, Hotel Edition )
  * Optimising of range selections: more correct selections checking on already booked days / times.  ( Premium, Hotel Edition )
 * Features and issue fixings in All versions:
  * Fixing some Internet Exploreer CSS issues
  * Added website url at emeils, where visitor made booking (at preofessional versions its customised feature)
  * Set showing of some settings only when its needed.
  * Optimize showing of inline hints inside of input box of cancelation reson

= 1.5.1 =
* Professional / Premium / Hotel version features:
  * Season avalaibility filter functionality             ( Hotel Edition )
  * Posibility to set avalaible / unavailable dates inside of calendar   ( Hotel Edition )

= 1.5 =
 * Professional / Premium / Hotel version features:
  * New version - Booking Calendar Hotel Edition
  * Posibility to set number of items inside of booking resource. For exmaple maximum number of rooms/seats/places/count of visitors of the specific type(booking resource). So days will be availbale untill all rooms (itms) are not reserved.  ( Hotel Edition )
  * Filter for showing only specific booking from selected items of some booking resource. In practice, for example, its mean that you can see only all bookings of standard (booking resource) room #101 (booking item)  ( Hotel Edition )
  * Fixing issue with not showing booking field value (at booking table and emeils), if field value consist some specific digits.  ( Pro, Premium, Hotel Edition )
 * Features and issue fixings in All versions:
  * Fixing issue of not showing Booking menu at Admin panel at PHP 4 and WordPress 2.9 combination
  * Optimisation of highliting days at the admin panel from booking tables and from calendar.
  * Legend of booking dates under booking calendar

= 1.4.3 =
 * Features and issue fixings in All versions:
  * Adding Captcha to the booking form. Activate/deactivate captcha from admin panel.
  * Optimising internal code structure.

= 1.4.2 =
 * Professional and Premium version features:
  * Improve highlighting of days at range (week) days selections.  ( Premium Edition )
 * Features and issue fixings in All versions:
  * 12,000 ms pause in error form message before the letters fade, gives slower readers time to figure it out!
  * Set user unavailable dayes for the booking, like Saturday, Sunday or any other days of week.
  * Improve some translations
  * New Booking calendar demo site adress - www.onlinebookingcalendar.com

= 1.4.1 =
 * Professional and Premium version features:
  * Fixing Checking of start time today if time is gone already. ( Premium Edition )
 * Features and issue fixings in All versions:
  * User roles management for access inside of plugin

= 1.4 =
 * Professional and Premium version features:
  * New versions of Booking Calendar - Booking Calendar Premium. Version Booking Calendar Deluxe is closed alternative - Booking Calendar Premium
  * Booking for specific time. Divide day to the parts according to the booking time (Booking Calendar Premium) ( Premium Edition )
  * Posibility to enter price per day, per night per hour and fixed price. ( Premium Edition )
  * Set start and end time at the range days selection (week selection) (Booking Calendar Premium)
 * Features and issue fixings in All versions:
  * Set time for showing thank you message after new booking is done
  * Multiple / Single day(s) selection feature
  * Admin panel checkbox - selection all booking in one time at booking tables (aproval, reserved)
  * Fixing bug with PHP 4 - "Fatal error: Nesting level too deep - recursive dependency" during activation of Widget
  * Fixing bug with PHP 5.3.0 - "Deprecated: Assigning the return value of new by reference is deprecated in ... "
  * Fixing issue of not correctly showing this ' symbol at the emails and reservation forms.
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
  * Customization of Date Format inside of emails and booking table.
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

== Upgrade Notice ==

= 2.3 =
Posibility to send or not send emails, when admin approve, cancel or add new booking. Posibility for visitor of sites to edit their bookings, cancel them. Posibility for admin send payment request to visitors.

= 2.2 =
Add dependence of free seats at booking dates from number of visitors at booking form during reservations. Optimization and fixing several items.

= 2.1 =
New autofill button at admin panel for Premium and Hotel Edition ver. Fixing small issues. Adding comaptibility with orders support plugin. Many other optimization.

= 2.0 =
New styles of elements for admin panel. Security optimization. Fixing some small issues.

= 1.9.3 =
Feasture for showing all new incoming bookings. Fixing several samll issues. Optimisation of rangetime selections.

= 1.9.2 =
New emails to visitor after new booking. Moderation link. More advanced costs management, which is depends from count of booking days.

== Languages ==

Right now plugin is support languages:
<ul>
 <li>English</li>
 <li>Spanish</li>
 <li>Danish</li>
 <li>Belarusian</li>
 <li>Russian</li>
 <li>You can translate to any other language, using this <a href="http://wpdevelop.com/blog/tutorial-translation-wordpress-plugin/" title="Tutorial of translation wordpress plugin">instruction</a></li>
</ul>

== Tech support ==

If you have some questions, which you do not found at <a href="http://onlinebookingcalendar.com/faq/" title="FAQ">FAQ</a> you can post them at <a href="http://onlinebookingcalendar.com/issues/" title="fixing issues">technical help board</a>

== New ideas ==

Please, fill free to propose new ideas or new features <a href="http://onlinebookingcalendar.com/ideas/" title="new feature">here</a>