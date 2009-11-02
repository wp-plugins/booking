=== Booking Calendar ===
Contributors: Dima Sereda
Donate link: http://www.wpdevelop.com/
Tags: Reservation, Booking, Book, Calendar, Booking calendar, reservation service, reservation dates, booking date, hotel rooms, ajax, paypal, online payment, rent
Requires at least: 2.7
Tested up to: 2.8.5
Stable tag: 1.2

Booking calendar for making reservation at your site and blogs. Book ing days of diferent type of properties on calendar with online payment.
== Description ==

This wordpress plugin is add booking service to your site. Your site visitors can make booking for one or several days of one or several properties (appartments, hotel rooms, cars and so on) and make online payment.  Its can be  interesting for hotel reservation service, rental service or any other service, where is needed making reservation at specific dates.

Plugin extremly easy to use and very flexible, fully Ajax supported.

Related Links:

* <a href="http://wpdevelop.com/booking-calendar-professional/" title="Buy Booking Calendar Professional">Buy "Booking Calendar Professional"</a>
* <a href="http://booking.wpdevelop.com/" title="Booking Calendar Professional Demo">"Booking Calendar Professional" Demo</a>
* <a href="http://wpdevelop.com/" title="Custom WordPress Plugins Development">Support and Developments of WordPress Pugins</a>

Features:

 * Making booking reservations by easy selecting dates at one or several calendar(s)
 * Email notifications for Administrator and for persons, who made booking.
 * Comfortable Admin panel for booking management
 * Easy integration into posts or pages by TinyMCE button at Editor toolbar
 * Booking calendar widget
 * Settings format of date for emeils and booking table
 * Settings start day of week
 * Fully Ajax and jQuery supported
 * Validations of requred form fields and email field
 * much more …

Advanced Professional / Delux / Ultimate Features:

 * PayPal payment support
 * Days range selections ( with posibility to set start day of week for booking)
 * Possibility to make multiple booking at same date using different booking properties
 * Management Booking properties ( Properties can be appartments, rooms, cars and so on)
 * Booking form fields customisation
 * Emails customisation for new reservations, approval or decline of booking
 * Time field support inside of booking form (time validation)
 * Custom integration of calendar at any place of form depends from your site design using action hooks

You can test <a href="http://booking.wpdevelop.com/demo/" title="Booking service">online demo</a> of  “Booking Calendar Professional”.



== Installation ==

This section describes how to install the plugin and get it working.

1. Upload entire `booking` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The Plugin menu "Booking" will appear at admin menu
4. Configure Settings at the submenu settings page of Booking menu
5. Add bookmark to your post or page usinf new booking button

== Frequently Asked Questions ==

 = How to insert booking form into post or page ? =

1. Go to the edit post / page menu
2. At the editor (TinyMCE) toolbar find new Booking Calendar button, press it.
3. Change settings at the popup window
4. Insert Booking Calendar into post/page
5. Format of the inserted bookmark is [ booking nummonths=1 type=1]

= How to insert booking form into any other place of site (not inside of post or page) ? =

1. Open for edit your them php file, like single.php.
2. Insert this action hook for showing Booking form <?php do_action('wpdev_bk_add_form', $bookingtype, $calendar_count); ?>
3. where you need to set $bookingtype – type of booking property (default = 1);
4. and you need to set $calendar_count – calendar count (default = 1);

 = How to insert only booking calendar into any other place of site (not inside of post or page) ? =

1. Open for edit your them php file, like single.php.
2. Insert this action hook for showing Booking form <?php do_action('wpdev_bk_add_calendar', $bookingtype, $calendar_count); ?>
3. where you need to set $bookingtype – type of booking property (default = 1);
4. and you need to set $calendar_count – calendar count (default = 1);

= Why my booking calendar at the widget is not show ? =

Booking Calendar at the widget do not to show, when at the same page is showing booking form with the same booking properties (type). At free version all booking form have the same booking types.

= How to change skin and colors ? =

Just go to the folder of plugin then choose and edit this CSS file "BOOKING_PLUGIN_PATH/js/datepick/wpdev_booking.css"
If you want to include your skin at next release, please send it to me by email info@wpdevelop.com

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png
5. screenshot-5.png
6. screenshot-6.png
7. screenshot-7.png
8. screenshot-8.png
9. screenshot-9.png
10. screenshot-10.png
11. screenshot-11.png
12. screenshot-12.png

== Changelog ==
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
 * Professioanl version features:
  * Multiple booking types (property) support. { Possibility to make several bookings ( for example for different rooms) at the same date}
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


== Customization ==

If you need customization or support this or any other WordPress plugin, please contact me here <a href="http://www.wpdevelop.com" title="WPDevelop - wordpress plugins development">www.wpdevelop.com</a>