=== Booking Calendar ===
Contributors: wpdevelop.com
Donate link: http://www.wpdevelop.com/
Tags: Reservation, Booking, Calendar, Booking calendar, reservation service, reservation dates, booking date, hotel rooms, ajax
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 1.0

Booking calendar for making Reservation at your site and blogs. 
== Description ==

This wordpress plugin is add booking service to your site. Your site visitors can make booking for one or several days of one or several properties (appartments, hotel rooms, cars and so on).  Its can be  interesting for hotel reservation service, rental service or any other service, where is needed making reservation at specific dates.

Plugin extremly easy to use and very flexible, fully Ajax supported.
Related Links:

* <a href="http://booking.wpdevelop.com/" title="Booking service">Plugin Homepage</a>
* <a href="http://wpdevelop.com/" title="Custom WordPress Plugins Development">Support and Developments of WordPress Pugins</a>

Features
    * Making booking reservations by easy selecting dates at calendar
    * Email notifications for Administraor and for persons, who made booking.
    * Comfortable Admin panel for booking management
    * Easy integration into posts or pages by TinyMCE button at Editor toolbar
    * Fully Ajax and jQuery supported
    * Validations of requred form fields and email field
    * much more …

Advanced Professional Features
    * Possibility to make multiple booking at same date using different booking properties
    * Management Booking properties ( Properties can be appartments, rooms, cars and so on)
    * Booking form fields customisation
    * Emails customisation for new reservations, approval or decline of booking
    * Time field support inside of booking form (time validation)
    * Custom integration of calendar at any place of form depends from your site design

You can test <a href="http://booking.wpdevelop.com/demo/" title="Booking service">online demo</a> of  “Booking Calendar Professional”.



== Installation ==

This section describes how to install the plugin and get it working.

1. If you use previos version of plugin before version 1.0, then make complete uninstall plugin with "Delete booking data" checked on at settins page
2. Upload entire `booking` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. The Plugin menu "Booking" will appear at admin menu
5. Configure Settings at the submenu settings page of Booking menu
6. Add bookmark to your post or page usinf new booking button

== Frequently Asked Questions ==

= How to add Booking form to my post? =

Just click at the booking button at the Editor toolbar and insert bookmark at the post content

= How to change skin and colors ?=

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

== Changelog ==
= 1.0 =
 * PROFESSIONAL VERSION FEATURE: Multiple booking types (property) support. { Possibility to make several bookings ( for example for different rooms) at the same date}
 * PROFESSIONAL VERSION FEATURE: Email customisation for approve, decline and new reservation (custom emails, subject, content... )
 * PROFESSIONAL VERSION FEATURE: Booking fields customisation from reservation form, customisation of showing data from form after booking.
 * PROFESSIONAL VERSION FEATURE: Time of start and finish booking, using additional time fields inside booking form
 * PROFESSIONAL VERSION FEATURE: Time validation at the client side
 * PROFESSIONAL VERSION FEATURE: Inserting calendar using 'Calendar TAG' in any place of booking form
 *
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


== Arbitrary section ==

If you need customisation or support this or any other WordPress plugin, please contact me here www.wpdevelop.com