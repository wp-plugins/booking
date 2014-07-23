<?php
/**
 * Welcome Page Class
 *
 * Shows a feature overview for the new version (major).
 *
 * Adapted from code in EDD (Copyright (c) 2012, Pippin Williamson) and WP.
 * 
 * @version     2.0.0
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBC_Welcome Class
 */
class WPBC_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'read';    //'manage_options';
        private $asset_path = 'http://wpbookingcalendar.com/assets/';        
        /**
	 * Get things started
	 *
	 * @access  public
	 * @since 1.4
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			sprintf( 'Welcome to WP Booking Calendar' ),
			sprintf( 'Welcome to WP Booking Calendar' ),
			$this->minimum_capability,
			'wpbc-about',
			array( $this, 'about_screen' )
		);

		// Credits Page
		add_dashboard_page(
			sprintf( 'Welcome to WP Booking Calendar' ),
			sprintf( 'Welcome to WP Booking Calendar' ),
			$this->minimum_capability,
			'wpbc-about-premium',
			array( $this, 'about_premium_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'wpbc-about' );
		remove_submenu_page( 'index.php', 'wpbc-about-premium' );
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.wpbc-badge {
                    display:none;
/*                      padding-top: 150px;
                        height: 52px;
                        width: 185px;
                        color: #666;
                        font-weight: bold;
                        font-size: 14px;
                        text-align: center;
                        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
                        margin: 0 -5px;
                        background: url('<?php $badge_url = WPDEV_BK_PLUGIN_URL . '/assets/images/wpbc-badge.png'; echo $badge_url; ?>') no-repeat;*/
		}

/*		.wpbc-welcome-page .about-wrap .wpbc-badge {
                    position: absolute;
                    top: 0;
                    right: 0;
		}*/

                .wpbc-welcome-page .about-text {
                    margin-right:0px;
                }
                .wpbc-welcome-page .versions {
                    color: #999999;
                    font-size: 12px;
                    font-style: normal;
                    margin: 0;
                    text-align: right;
                    text-shadow: 0 -1px 0 #EEEEEE;
                }
                .wpbc-welcome-page .versions a,
                .wpbc-welcome-page .versions a:hover{
                   color: #999;
                   text-decoration:none;
                }
                .wpbc-welcome-page .update-nag {
                    border-color: #E3C58E;
                    border-radius: 5px;
                    -moz-border-radius: 5px;
                    -webkit-border-radius: 5px;
                    box-shadow: 0 1px 3px #EEEEEE;
                    color: #998877;
                    font-size: 12px;
                    font-weight: bold;
                    margin: 15px 0 0;   
                    width:90%;
                }

		/*]]>*/
		</style>
		<?php
	}
        
        /** Show Title Section and Menu of Welcome page 
         * 
         */
        public function title_section() {
                list( $display_version ) = explode( '-', WPDEV_BK_VERSION );
                ?>
                <h1><?php printf(  'Welcome to WP Booking Calendar %s' , $display_version ); ?></h1>
                <div class="about-text"><?php 
                    echo('Thank you for updating to the latest version!'); 
                    printf(  '%s is more polished, powerful and easy to use than ever before.' , ' WP Booking Calendar ' . $display_version ); ?></div>
                <!--div class="wpbc-badge"><?php printf(  'Version %s' , $display_version ); ?></div-->

                <h2 class="nav-tab-wrapper">
                    <?php 
                        $is_about_tab_active = $is_about_premium_tab_active = '';
                        if ( ( isset($_GET['page']) ) && ( $_GET['page'] == 'wpbc-about' ) )            $is_about_tab_active = ' nav-tab-active ';
                        if ( ( isset($_GET['page']) ) && ( $_GET['page'] == 'wpbc-about-premium' ) )    $is_about_premium_tab_active = ' nav-tab-active ';
                    ?>
                        <a class="nav-tab<?php echo $is_about_tab_active; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-about' ), 'index.php' ) ) ); ?>">
                                <?php echo( "What's New" ); ?>
                        </a><a class="nav-tab<?php echo $is_about_premium_tab_active; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-about-premium' ), 'index.php' ) ) ); ?>">
                                <?php echo( "Even more Premium Features" ); ?>
                        </a>
                </h2>                
                <?php
        }

        /** Show Maintence section  for the MINOR Updates
         * 
         */
        public function maintence_section(){
                
                if ( ! ( ( defined('WP_BK_MINOR_UPDATE')) && (WP_BK_MINOR_UPDATE) ) )
                    return;
                
                list( $display_version ) = explode( '-', WPDEV_BK_VERSION );    
                ?>
                <div class="changelog point-releases">
                        <h3><?php echo( "Maintenance and Security Release" ); ?></h3>
                        <p><strong><?php printf(  'Version %s' , $display_version ); ?></strong> <?php printf(  'addressed some security issues and fixed %s bugs' , '' ); ?>. 
                            <?php printf(  'For more information, see %sthe release notes%s' ,'<a href="http://wpbookingcalendar.com/changelog/" target="_blank">','</a>') ?>.
                        </p>
                </div>                        
                <?php              
        }
        
        
	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
        public function about_screen() {
          ?><div class="wrap about-wrap wpbc-welcome-page">
              
                <?php $this->title_section(); ?>

                <?php $this->maintence_section(); ?>
              
                <div class="changelog">  
                    <h2 class="about-headline-callout"><?php echo( "Responsive, modern and easy to use Booking Admin Panel" );?></h2>
                    <div style="margin:0 1% auto;width:100%">
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-listing.png" style="width: 70%;float:left;border:none;box-shadow: 0 1px 3px #777777;">
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-listing-m.png" style="width: 20.85%;float:left;margin-left: 3%;border:none;box-shadow: 0 1px 3px #777777;">
                    </div>
<!--                    <div style="margin:0 3% auto;width:100%">    
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-overview.png" style="width: 64.3%;float:left;border:none;box-shadow: 0 1px 3px #777777;">
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-overview-m.png" style="width: 25%;float:left;margin-left: 3%;border:none;box-shadow: 0 1px 3px #777777;">
                        
                    </div>-->
                </div>
              
                <div class="clear" style="height:30px;border-bottom:1px solid #DFDFDF;"></div>
              
                <div class="changelog">  
                    <div class="feature-section col two-col">
                        <div class="col-1">
                            <img src="<?php echo $this->asset_path; ?>5.1/form-fields.png" style="width: 75%;margin:10px 12%;float:right;border:none;box-shadow: 0 1px 3px #777777;">
                        </div>
                        <div class="col-2 last-feature">                            
                            <h3><?php echo( 'Multilingual Form Fields' ); ?></h3>
                            <p><?php echo( 'Ability to define booking form fields in several languages, while using multilingual plugins like WPML or qTranslate.' ); ?></p>
                        </div>
                    </div>
                </div>
              
                <div class="clear" style="height:1px;border-bottom:1px solid #DFDFDF;"></div>
                
                <div class="changelog"> 

                    <h3><?php echo('Under the Hood');?></h3>
                    <div class="feature-section col three-col">

                        <div class="col-1">
                            <h4><?php echo( "New translations" ); ?></h4>
                            <p><?php printf( "Support translations of several new languages (%sNorwegian%s, %sBrazilian Portuguese%s) and update of some exist lanagues (%sDanish%s, %sDutch%s)." 
                                    ,'<strong>','</strong>'
                                    ,'<strong>','</strong>'
                                    ,'<strong>','</strong>'
                                    ,'<strong>','</strong>'
                                    ); ?></p>
                        </div>
                        
                        <div class="col-2">
                            <h4><?php echo( "New 'Set Read All' button " ); ?></h4>
                            <p><?php  echo( "New button to set all bookings as 'read' in the Filters tab on Booking Listing page" ); ?></p>
                        </div>     

                        <div class="col-3 last-feature">
                            <h4><?php echo( "Many other improvements and fixes" ); ?></h4>
                            <p><?php  echo( "This update contain many other small fixes, code refactoring and improvements." ); ?></p>
                        </div>

                    </div>
                    <div class="clear" style="height:30px;border-top:1px solid #DFDFDF;"></div>
                    <div>
                        <p class='description'>                        
                        <?php printf(  'For more information about current update, see %srelease notes%s or check' 
                                ,'<a class="button button-secondary" href="http://wpbookingcalendar.com/changelog/" target="_blank">','</a>'); 
                        ?> <a class='button button-primary'  href="http://wpbookingcalendar.com/updates/whats-new-5-0/" target="_blank"><?php echo( "What's New in previous Update" );?> 5.0 ...</a>                    
                        </p>
                    </div>
                </div>
              
                <?php //$this->about_screen_5_0(); ?>    
              
                <?php wpbc_welcome_panel(); ?>    
              
            </div><?php
        }
        
	public function about_screen_5_0() {		
		?>
		<div class="wrap about-wrap wpbc-welcome-page">
			
                    <?php 
                    //$this->title_section();                                     // Show Title of Welcome page
                    ?>
                        
                    <?php 
                    //$this->maintence_section();                                 // Template for the Minor updates
                    ?>
                        <div class="changelog">                            
                            <h3><?php echo('Responsive, stylish and easy to customize design');?></h3>
                            <div class="feature-section col three-col">
                                <div>                                    
                                    <img src="<?php echo $this->asset_path; ?>5.0/responsive-design.png" style="border: medium none;box-shadow: 0 0 0;margin: 0 0 0.5em 20px;width: 80%;" >
                                    <h4><?php echo( "Responsive front end design" ); ?></h4>
                                    <p><?php  echo( "We have completely rewritten the CSS of calendar skins and booking form. Booking form and calendar support fully responsive design that looks great on any device." ); ?>
                                    </p>
                                </div>

                                <div>
                                    <img src="<?php echo $this->asset_path; ?>5.0/insert.png" style="border:none;box-shadow: 0 1px 3px #777777;margin: 3px 0 1em 3px;width: 99%;" >
                                    <h4><?php echo( "Easy to customize" ); ?></h4>
                                    <p><?php printf( "Much  more easy to configure for fitting to your site design. Configure calendar width, height or even structure %s(number of months in a row)%s from settings in a minute." ,'<em>','</em>'); ?></p>                                        
                                </div>
                                
                                <div class="last-feature">
                                    <img src="<?php echo $this->asset_path; ?>5.0/sleek-design.png" style="border:none;box-shadow: 0 1px 3px #777777;margin: 3px 3px 1em 0px;width: 95%;" >
                                    <h4><?php echo( "Smoother Booking Experience" ); ?></h4>
                                    <p><?php  echo( "Booking form has new attractive calendar skins and sleek form fields with nice warning messages." ); ?></p>
                                </div>

                            </div>
                        </div>

                        <?php if ( (  $_SERVER['HTTP_HOST'] === 'dev'  ) || ! class_exists('wpdev_bk_personal')) { ?>                    
                        <div class="changelog"> 
                            <h3><?php echo('Configure your predefined set of form fields');?></h3>
                            <div class="feature-section images-stagger-right">
                                
                               <img src="<?php echo $this->asset_path; ?>5.0/settings-fields-free.png" style="width:40%; border:none;box-shadow: 0 1px 3px #777777;margin-top: 1px;">
                               <h4><?php echo( "Write Labels for your fields" ); ?></h4>
                               <p><?php  printf( "Now %s(at Booking %s Settings %s Fields page)%s is possible to change the form fields labels." ,'<em>','&gt;','&gt;','</em>'); ?></p> 
                               
                               <h4><?php echo( "Activate or Deactivate fields" ); ?></h4>
                               <p><?php  echo( "You can activate or deactivate the fields from the predefined fields set." ); ?></p>
                               
                               <h4><?php echo( "Set as required specific fields" ); ?></h4>
                               <p><?php  echo( "You can set as required specific fields in your booking form from the predefined fields set." ); ?></p>
                               
                            </div>
                        </div>
                        <?php } ?>
                    
                    
                        <div class="changelog">
                            <div class="feature-section">  
                                <h3><?php echo( "Nice and Easy to Understand Interface with Buttons for Fast Actions" ); ?></h3> 
                                <img src="<?php echo $this->asset_path; ?>5.0/interface.png" style="border: medium none;box-shadow: 0 1px 3px #777777;width: 98%;margin:0px 3px;">
                                <div class="last-feature">           
                                    <h4><?php echo( "Approve or Reject Booking in 1 Click on Calendar Overview page" ); ?></h4> 
                                    <p><?php echo( "Make common actions, like Approve, Decline or Delete of the booking in One Click on the Calendar Overview panel" ); ?>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class="changelog"> 
                            
                            <h3><?php echo('Under the Hood');?></h3>
                            <div class="feature-section col two-col">
                                
                                <div>
                                    <!--img src="<?php echo $this->asset_path; ?>5.0/code-css-black10.png" style="border:none;box-shadow: 0 1px 3px #777777;margin: 3px 0 1em 3px;width: 99%;" -->
                                    <h4><?php echo( "Customize the Calendar Skins" ); ?></h4>                            
                                    <p><?php  printf( "The calendar skins %s are located separately from the calendar structure file %s and very well commented. So you do not need to worry about the structure, sizes or responsive design of the calendar and concentrate only on design." ,'<code>../css/skins/</code>','<code>../css/calendar.css</code>'); ?></p> 
                                    </p>
                                </div>     

                                <div class="last-feature">
                                    <h4><?php echo( "Improved Performance" ); ?></h4>
                                    <p><?php  echo "WP Booking Calendar "; echo( "has been dramatically improved in terms of performance to make your site run better and faster." ); ?></p>
                                </div>
                                
                            </div>
                            
                            <p><?php echo( "Many other improvements and small issues fixing." ); ?> <?php 
                               printf(  'For more information, see %sthe release notes%s' ,'<a href="http://wpbookingcalendar.com/changelog/" target="_blank">','</a>') ?>.</p>                            
                    
                        </div>
                        
			<!--div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option' ), 'admin.php' ) ) ); ?>"><?php echo( 'Go to WP Booking Calendar Settings' ); ?></a>
			</div-->
                        <?php wpbc_welcome_panel(); ?>
                        <?php if (false) {                                      // Get Remote News or some other info

                            $response = wp_remote_post( OBC_CHECK_URL . 'info/', array() );

                            if (! ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) ) {

                                $body_to_show = json_decode( wp_remote_retrieve_body( $response ) );

                                ?><style type="text/css" media="screen">#bk_news_loaded{display:block !important;}</style><?php

                                echo $body_to_show ;
                            }
                        } ?>                                              
		</div>
		<?php
	}

        
	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
        public function about_premium_screen() {
            list( $display_version ) = explode( '-', WPDEV_BK_VERSION );
            ?>
            <div class="wrap about-wrap wpbc-welcome-page">

                <?php 
                $this->title_section();                                     // Show Title of Welcome page
                ?>
                <p class="update-nag"><?php echo( "New Features in the Paid versions of" ); ?> <?php echo ' WP Booking Calendar '.$display_version ; ?></p>

                <div class="changelog">
                    <h2 style="margin:0.2em 0;" class="about-headline-callout"><?php echo( "Responsive and easy to use Booking Admin Panel" ); ?></h2>
                    <div style="margin:0 1% auto;width:100%">    
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-overview-p.png" style="width: 71%;float:left;border:none;box-shadow: 0 1px 3px #777777;">
                        <img src="<?php echo $this->asset_path; ?>5.1/booking-overview-p-m.png" style="width: 21.9%;margin-left: 3%;float:left;border:none;box-shadow: 0 1px 3px #777777;">                        
                        
                    </div>
                    <div class="clear"></div>

                    <p><?php echo( "Booking Admin Panel support fully responsive design that looks great on any device" ); ?>. <br/>
                       <?php echo( "Industry standard Interface - resources at the first column and booking dates in right rows" ); ?>.
                    </p>
                    <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                </div>
                
                <div class="clear" style="height:20px;border-bottom:1px solid #DFDFDF;"></div>
                <div class="clear" style="height:20px;"></div>
                
                <div class="feature-section col two-col">
                    
                    <div >
                        <img src="<?php echo $this->asset_path; ?>5.1/deposit.png" style="width: 60%;border:none;box-shadow: 0 1px 3px #777777;">
                        <h4><?php echo( "Conditions for Deposit payment" ); ?></h4>
                        <p><?php  
                            printf( "Show deposit payment, only if difference between %sToday%s and %sCheck In%s days higher then specific number of days." 
                                    ,'<strong>"','"</strong>' 
                                    ,'<strong>"','"</strong>' 
                                  ); 
                            ?>
                        </p>
                    </div>
                    <div class="last-feature">
                        <img src="<?php echo $this->asset_path; ?>5.1/valuation.png" style="width: 100%;border:none;box-shadow: 0 1px 3px #777777;">
                        <div >

                            <h4><?php echo( "Valuation days for cost per night" ); ?></h4>
                            <p><?php  
                                printf( "Ability to set %sValuation days%s cost settings if was setting %scost per night%s option. " 
                                        ,'<strong>"','"</strong>' 
                                        ,'<strong>"','"</strong>' 
                                      ); 
                                ?>
                        </div>

                        <div>
                            <h4><?php echo( "Valuation days depend from Check In" ); ?></h4>
                            <p><?php  
                                printf( "Calculation %sValuation days%s cost setting that depend from Season Filter of %sCheck In%s date." 
                                        ,'<strong>"','"</strong>' 
                                        ,'<strong>"','"</strong>' 
                                      ); 
                                ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                </div>
                
                <div class="clear" style="height:10px;border-bottom:1px solid #DFDFDF;"></div>
                
                <div class="changelog"> 
                    <h3><?php echo('Under the Hood');?></h3>
                    <div class="feature-section col three-col">
                        <div class="col-1">
                            <h4><?php echo( "Users Pagination" ); ?></h4>
                            <p><?php  echo( "Pagination of users listing on the Settings Users page" ); ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">MultiUser</a> <?php echo( "version" ); ?> }</span>
                        </div>                        
                        <div class="col-2">
                            <h4><?php echo( "Custom form selection" ); ?></h4>
                            <p><?php  echo( "Ability to select default custom booking form during creation of booking resources" ); ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>     
                        <?php /*
                        <div class="col-2">
                            <h4><?php echo( "Payment page depend from locale" ); ?></h4>
                            <p><?php  echo( "Load the PayPal payment page that depend from the locale of original website" ); ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Small / Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div> */ ?>
                        <div class="col-3 last-feature">
                            <h4><?php echo( "Custom forms for regular users" ); ?></h4>
                            <p><?php echo '<strong>'; echo('Trick'); echo '.</strong> '; printf( "Ability to set %s of the constant %s in %s file for activation additional %scustom forms%s functionality for %sregular users%s" 
                                    ,'<code>TRUE</code>'
                                    ,'<code>WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS</code>'
                                    ,' <em>wpdev-booking.php</em> '
                                    ,'<em>"','"</em>'
                                    ,'<em>"','"</em>'                                    
                                    ); ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">MultiUser</a> <?php echo( "version" ); ?> }</span>
                        </div>                        

                        <div class="clear" style="width:100%;"></div>
                        
                        <div class="col-1">
                            <h4><?php echo( "Auto select Default Custom Form" ); ?></h4>
                            <p><?php printf( "Auto select %sDefault Custom Form%s of specific resource, for %sbooking resource selection%s shortcode - %s. %sNote, parameter %sform_type%s in this shortcode must be skipped%s." 
                                    ,'<strong>','</strong>'
                                    ,'<strong>','</strong>'
                                    ,'<code>[bookingselect]</code>'
                                    ,'<em>'
                                    ,'<code>','</code>'
                                    ,'</em>'
                                    ); 
                            ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>                                                
                        <div class="col-2">
                            <h4><?php echo( "Using 'options' for booking resources selection" ); ?></h4>
                            <p><?php
                            printf( "Ability to use %s parameter in the %s shortcode in the same way, as it possible to use for %s shortcode." 
                                    ,'<code>option</code>'
                                    ,'<code>[bookingselect ...]</code>'
                                    ,'<code>[booking ...]</code>'
                                    ); 
                            ?></p>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>     
                        <div class="col-3 last-feature">
                            <h4><?php echo( "Auto expand booking notes" ); ?></h4>
                            <p><?php echo '<strong>'; echo('Trick'); echo '.</strong> '; printf( "Ability to set %s of the constant %s in %s file for expand %sfilled notes section%s of bookings in booking listing page" 
                                    ,'<code>TRUE</code>'
                                    ,'<code>WP_BK_SHOW_BOOKING_NOTES</code>'
                                    ,' <em>wpdev-booking.php</em> '
                                    ,'<em>"','"</em>'
                                    ,'<em>"','"</em>'                                    
                                    ); ?></p>                            
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>     
                    </div>
                </div>
                    
                <div class="clear" style="height:30px;border-top:1px solid #DFDFDF;"></div>
                
                <div>
                    <p class='description'>                        
                    <?php printf(  'For more information about current update, see %srelease notes%s or check' 
                            ,'<a class="button button-secondary" href="http://wpbookingcalendar.com/changelog/" target="_blank">','</a>'); 
                    ?> <a class='button button-primary'  href="http://wpbookingcalendar.com/updates/whats-new-5-0/" target="_blank"><?php echo( "What's New in previous Update" );?> 5.0 ...</a>                    
                    </p>
                </div>

                <div class="return-to-dashboard">
                        <a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option' ), 'admin.php' ) ) ); ?>"><?php echo( 'Go to WP Booking Calendar Settings' ); ?></a>
                </div>
            <?php
        }
        
        
	public function about_premium_screen_5_0() {
		list( $display_version ) = explode( '-', WPDEV_BK_VERSION );
		?>
		<div class="wrap about-wrap wpbc-welcome-page">
			
                    <?php 
                    $this->title_section();                                     // Show Title of Welcome page
                    ?>
                    <p class="update-nag"><?php echo( "New Features in the Paid versions of" ); ?> <?php echo ' WP Booking Calendar '.$display_version ; ?></p>
                    
                    
                    <div class="changelog">
                        <h3><?php echo( "New Calendar Overview panel for Multiple Booking Resources ('Matrix')" ); ?></h3>
                        <div class="feature-section col three-col">
                            <img src="<?php echo $this->asset_path; ?>5.0/calendar-overview-for-several-resources.png" style="width: 99%;border:none;box-shadow: 0 1px 3px #777777;margin-top: 1px;">
                            <div>
                                <h4><?php echo( "Beautiful Easy to Understand Interface" ); ?></h4>
                                <p><?php echo( "Resources at the first column and booking dates are in right rows." ); ?></p>
                            </div>
                            <div>
                                <h4><?php echo( "Day, Week, Month or 2 Months View Mode" ); ?></h4>
                                <p><?php echo( "Possibility to set a Day, Week, Month or 2 Months view mode for the 'Matrix' Calendar Overview panel." ); ?> </p>
                            </div>
                            <div class="last-feature">
                                <h4><?php echo( "Select Several Specific or All Resources" ); ?></h4>
                                <p><?php echo( "Possibility to select several specific or all booking resources at 'Filter tab' of Booking Listing or Calendar Overview panel." ); ?></p>
                            </div>
                            <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>        
                    </div>                    
               
                    
                    <div class="changelog">
                        <div class="feature-section images-stagger-right">
                           <h3><?php echo( "Show Pending Days as Available" ); ?></h3> 
                           <img src="<?php echo $this->asset_path; ?>5.0/pending-days-available.png" style="width: 50%;border:none;box-shadow: 0 1px 3px #777777;margin-top: 1px;">
                           <div>
                                <h4><?php echo( "Possibility to book Pending Days" ); ?></h4>
                                <p><?php echo( "Set Pending booked dates as available in calendar, until you'll Approve some booking. Do not lose any bookings, if some bookings were made by mistake or it was spam." ); ?> 
                                   </p>
                           </div>
                           <div class="last-feature">
                                <h4><?php echo( "Auto Decline" ); ?></h4>
                                <p><?php echo( "Activate the Auto decline (delete) all pending bookings in your booking resource for the specific date(s), if you've approved other booking for these date(s)." ); ?>
                                   </p>
                           </div>
                           <span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>
                    </div>                    
      
                    
                    <div class="changelog">
                        <div class="feature-section images-stagger-left">  
                            <h3><?php echo( "Different Time Slots (or other content) for the Different Selected Days." ); ?></h3> 
                            <img src="<?php echo $this->asset_path; ?>5.0/different-times-selection.png" style="border: medium none;box-shadow: 0 1px 3px #777777;width: 45%;">
                            <div>
                                <br><h4><?php echo( "Set Different Time Slots for the Different Days." ); ?></h4>
                                <p><?php echo( "You can configure different Time Slots availability for the different days (weekday or date from season filter). Each week day (day of specific season filter) can have different time slots list." ); ?>               
                                   <?php printf(  "Check  more %shere%s." ,"<a href='http://wpbookingcalendar.com/help/different-time-slots-selections-for-different-days/' target='_blank'>",'</a>') ?>.</p>
                            </div>
                            <div class="last-feature">
                                <h4><?php echo( "Show Specific Form Content, if Desire Date is Selected" ); ?></h4>
                                <p><?php echo( "You need to show specific field(s), form section or just text, if specific date is selected (weekday or date from season filter) - it's also possible." ); ?>
                                   <?php printf(  "Check  more %shere%s." ,"<a href='http://wpbookingcalendar.com/help/different-content-for-different-days-selection/' target='_blank'>",'</a>') ?>.</p>
                            </div>
                            <span class="versions"> { <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium/Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>
                    </div>
                    
                    
                    <div class="changelog">
                        <div class="feature-section images-stagger-right">
                            <h3><?php echo( "Configure Days Selection as You Need." ); ?></h3> 
                            
                                <img src="<?php echo $this->asset_path; ?>5.0/days-selection-configuration.png" style="border: medium none;box-shadow: 0 1px 3px #777777;width: 45%;">
                                
                                <h4><?php echo( "Configure Number of Days selection" ); ?></h4>
                                <p><?php echo( "Specify that during certain seasons (or week days), the specific minimum (or fixed) number of days must be booked." ); ?>
                                   <?php printf(  "Check  more about 'options' %shere%s." ,"<a href='http://wpbookingcalendar.com/help/booking-calendar-shortcodes/' target='_blank'>",'</a>') ?>                                   
                                   <br><span class="versions" style="clear:both;float:none;"> { <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium/Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                                </p>
                                
                                <h4><?php echo( "Set several Start Days" ); ?></h4>
                                <p><?php echo( "Specify several weekdays as possible start day for the range days selection." ); ?></p>
                            
                            
                                <h4><?php echo( "Easy configuration of range days selection" ); ?></h4>
                                <p><?php echo( "Configure 'specific days selections', for the 'range days selection' mode, in more comfortable way." ); ?>  
                                   <?php echo( "Separate days by dash or comma." ); ?>
                                   <br><em><?php printf(  "Example: '%s'. It's mean possibility to select: %s days." ,'3-5,7,14','3, 4, 5, 7, 14'); ?></em>
                                   <br><span class="versions"> { <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Small/Medium/Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                                </p>
                            
                            
                        </div>
                    </div>

                    
                    <div class="changelog">
                        <div class="feature-section images-stagger-left">  
                            <h3><?php echo( "Easily configure your booking form fields." ); ?></h3> 
                            <img src="<?php echo $this->asset_path; ?>5.0/form-fields.png" style="border: medium none;box-shadow: 0 1px 3px #777777;width: 20%;">
                            <div>
                                <h4><?php echo( "New help system for booking form fields configuration." ); ?></h4>
                                <p><?php echo( "You can configure different form field’s shortcodes easily using smart configuration panel." ); ?>               
                            </div>
                            <div class="last-feature">
                                <h4><?php echo( "New form Fields and parameters" ); ?></h4>
                                <p><?php echo( "Booking Calendar support many new additional parameters for exist shortcodes, and some new fields, like radio buttons." ); ?>
                            </div>
                            <span class="versions"> { <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small/Medium/Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                        </div>
                    </div>
                    
                    
                    <div class="changelog">
                        <div class="feature-section images-stagger-right">
                            <h3><?php echo( "Payments and Costs." ); ?></h3> 
                                <img src="<?php echo $this->asset_path; ?>5.0/payment-forms.png" style="border: medium none;box-shadow: 0 1px 3px #777777;margin-top: -20px;width: auto;">
                            <h4>Authorize.Net</h4>
                            <p><?php printf(  "Integration %s Payment Gateway - Server Integration Method (SIM)." ,'Authorize.Net'); ?> 
                               <?php echo( "Integration of this gateway was one of the most our common user requests." ); ?> 
                               <?php echo( "Now it's existing." ); ?>
                            </p>

                            <h4><?php echo( "Currency Format" ); ?></h4>
                            <p><?php echo( "Configure format of showing the cost in the payment form." ); ?>
                                <br><span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Small / Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                            </p><br>
                            
                            <h4><?php echo( "Do More with  Less Actions" ); ?></h4>     
                            <p><?php echo( "Assign  Availability, Rates, Valuations days or Deposit amount to the several booking resources in 1 step." ); ?> 
                               <?php echo( "Select several booking resources. Click on Availability, Rates, Valuations days or Deposit button." ); ?> 
                               <?php echo( "Configure and Update settings.  That's it" ); ?>              
                               <br><span class="versions">{ <?php echo( "Available in" ); ?> <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> <?php echo( "versions" ); ?> }</span>
                            </p>
                            
                        </div>
                    </div>
                    
                    
                    

<div class="changelog"> 

    <h3><?php echo('Under the Hood');?></h3>
    <div class="feature-section col three-col">
        <div>                            
            <h4><?php echo "[denyreason] "; echo( "shortcode for 'Approve' email" ); ?></h4>                            
            <p><?php echo( "It means that we can write some text into the 'Reason of cancelation' field for having this custom text in the Approve email template." ); ?> 
               <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> }</span>
            </p>            
        </div>     
        <div>
            <h4><?php printf(  "%s Support" ,'qTranslate'); ?></h4>
            <p><?php printf(  "Full support of the %s plugin. " ,'qTranslate'); ?> 
                <?php echo( "Including the search results content and links to the post with booking forms in correct language." ); ?>
               <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> }</span>
            </p>            
            
        </div>
        <div class="last-feature">
            <h4><?php echo( "Edit Past Bookings" ); ?></h4>
            <p><?php echo( "Edit your bookings, where the time or dates have been already in the past." ); ?> 
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> }</span>
            </p>

            <?php /** ?><h4><?php echo( "Delete your Saved Filter" ); ?></h4>
            <p><?php echo( "Delete your Default saved filter template on the Booking Listing page at Filter tab" ); ?> 
                <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Personal, Business Small / Medium / Large, MultiUser</a> }</span>
            </p><?php /**/ ?>
            
        </div>
    </div>

    
    <div class="feature-section col three-col">
        <div>
            <h4><?php echo( "Checking End Time only" ); ?></h4>
            <p><?php echo( "Set checking is only for end time of bookings for Today." ); ?>  
               <?php echo( "So start time could be already in a past." ); ?> 
               <?php echo( "Reactivate old checking using" ); ?> JavaScript <code>is_check_start_time_gone=true;</code>
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Small / Medium / Large, MultiUser</a> }</span>
            </p>
        </div>        
        <div>
            <h4><?php echo( "Set cost for the 'Check Out' date" ); ?></h4>                            
            <p><?php printf(  "Possibility to use new reserved word %s (Check Out date) in the Valuation days cost settings page for the field 'For'. So you can define the cost of the last selected date." ,'<strong><code>LAST</code></strong>'); ?>
               <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> }</span>
            </p>

        </div>    
        <div class="last-feature">            
            <h4><?php echo( "Advanced Additional Cost" ); ?></h4>
            <p><?php printf(  "Set additional cost of the booking as percentage of the original booking cost. This original booking cost doesn't have impact from any other additional cost settings. Usage: just write %s sign before percentage number. Example: %s." ,"'+'", "+50%"); ?>
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> }</span>   
            </p>                        
        </div>
    </div>
    
    

    
    <div class="feature-section col three-col">
        <div>
            <h4><?php echo( "Set 'Check In/Out' dates as Available" ); ?></h4>
            <p><?php echo( "Set 'check in/out' dates as available for resources with capacity higher than one. It's useful, if check in date of booking have to be the same as check out date of other booking." ); ?>
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Large, MultiUser</a> }</span>
            </p>
        </div>
        <div>
            <h4><?php echo( "Visitors Selection in Search Result" ); ?></h4>
            <p><?php echo( "Auto selection of the correct visitor number in the booking form, when the user redirected from the search form." ); ?> 
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Large, MultiUser</a> }</span>    
            </p>
            
        </div>
        <div class="last-feature">
            <h4><?php echo( "Use 'Unavailable days from today' settings in Search Form" ); ?></h4>
            <p><?php echo( "Using the settings of 'Unavailable days from today' for the calendars in the search form." ); ?>
            <br><span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Large, MultiUser</a> }</span>    
            </p>
            
        </div>
    </div>
    

    
    
    <div class="feature-section col two-col">
        <div>
            <h4><?php echo( "Shortcodes for Emails and Content Form" ); ?></h4>                            
            <p><?php echo( "Long list of useful shortcodes for the Email Templates and the 'Content of Booking Fields' form" ); ?>:  
                <code>[cost_hint]</code>, 
                <code>[original_cost_hint]</code>, 
                <code>[additional_cost_hint]</code>, 
                <code>[deposit_hint]</code>, 
                <code>[balance_hint]</code>, 
                <code>[check_in_date_hint]</code>, 
                <code>[check_out_date_hint]</code>, 
                <code>[start_time_hint]</code>, 
                <code>[end_time_hint]</code>, 
                <code>[selected_dates_hint]</code>, 
                <code>[selected_timedates_hint]</code>, 
                <code>[selected_short_dates_hint]</code>, 
                <code>[selected_short_timedates_hint]</code>, 
                <code>[days_number_hint]</code>, 
                <code>[nights_number_hint]</code> 
             
             </p>
             <span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> }</span>
        </div>    
        <div class="last-feature">            
            <h4><?php echo( "New Shortcodes for Hints in booking form." ); ?></h4>                            
            <p><?php printf( "New shortcodes for showing real-time hints (like %s) inside of the booking form" ,'[cost_hint]'); ?>:
                <code>[deposit_hint]</code>, 
                <code>[balance_hint]</code>, 
                <code>[check_in_date_hint]</code>, 
                <code>[check_out_date_hint]</code>, 
                <code>[start_time_hint]</code>, 
                <code>[end_time_hint]</code>, 
                <code>[selected_dates_hint]</code>, 
                <code>[selected_timedates_hint]</code>, 
                <code>[selected_short_dates_hint]</code>, 
                <code>[selected_short_timedates_hint]</code>, 
                <code>[days_number_hint]</code>, 
                <code>[nights_number_hint]</code> 
            
            </p>
            <span class="versions">{ <a href="http://wpbookingcalendar.com" target="_blank">Business Medium / Large, MultiUser</a> }</span>
        </div>
    </div>
    
    
    
    <p><?php echo( "Many other improvements and small issue fixing." ); ?> <?php 
       printf(  'For more information, see %sthe release notes%s' ,'<a href="http://wpbookingcalendar.com/changelog/" target="_blank">','</a>') ?>.</p>                            

</div>

                                
                    <div class="return-to-dashboard">
                            <a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option' ), 'admin.php' ) ) ); ?>"><?php echo( 'Go to WP Booking Calendar Settings' ); ?></a>
                    </div>

		</div>
		<?php
	}

	/**
	 * Sends user to the Welcome page on first activation of plugin as well as each
	 * time plugin is upgraded to a new version
	 */
	public function welcome() {
            // Bail if no activation redirect transient is set
            if ( ! get_transient( '_wpbc_activation_redirect' ) )
                    return;

                // Delete the redirect transient
                delete_transient( '_wpbc_activation_redirect' );

                // Bail if DEMO or activating from network, or bulk, or within an iFrame
                if ( wpdev_bk_is_this_demo() || is_network_admin() || isset( $_GET['activate-multi'] ) || defined( 'IFRAME_REQUEST' ) )
                        return;

                wp_safe_redirect( admin_url( 'index.php?page=wpbc-about' ) );
                exit;                
	}
}
new WPBC_Welcome();

function wpbc_welcome_panel() {
    ?>
<style type="text/css" media="screen">
/*<![CDATA[*/
    /* WPBC Welcome Panel */                
    .wpbc-panel .welcome-panel {
        background: linear-gradient(to top, #F5F5F5, #FAFAFA) repeat scroll 0 0 #F5F5F5;
        border-color: #DFDFDF;
    }
    .wpbc-panel .welcome-panel {
            position: relative;
            overflow: auto;
            margin: 20px 0;
            padding: 23px 10px 12px;
            border-width: 1px;
            border-style: solid;
            border-radius: 3px;
            font-size: 13px;
            line-height: 2.1em;
    }
    .wpbc-panel .welcome-panel h3 {
            margin: 0;
            font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
            font-size: 21px;
            font-weight: normal;
            line-height: 1.2;
    }
    .wpbc-panel .welcome-panel h4 {
            margin: 1.33em 0 0;
            font-size: 13px;
    }
    .wpbc-panel .welcome-panel a{
        color:#21759B;
    }
    .wpbc-panel .welcome-panel .about-description {
            font-size: 16px;
            margin: 0;
    }
    .wpbc-panel .welcome-panel .welcome-panel-close {
            position: absolute;
            top: 5px;
            right: 10px;
            padding: 8px 3px;
            font-size: 13px;
            text-decoration: none;
            line-height: 1;
    }
    .wpbc-panel .welcome-panel .welcome-panel-close:before {
            content: ' ';
            position: absolute;
            left: -12px;
            width: 10px;
            height: 100%;
            background: url('../wp-admin/images/xit.gif') 0 7% no-repeat;
    }
    .wpbc-panel .welcome-panel .welcome-panel-close:hover:before {
            background-position: 100% 7%;
    }
    .wpbc-panel .welcome-panel .button.button-hero {
        margin: 15px 0 3px;
    }
    .wpbc-panel .welcome-panel-content {
            margin-left: 13px;
            max-width: 1500px;
    }
    .wpbc-panel .welcome-panel .welcome-panel-column-container {
            clear: both;
            overflow: hidden;
            position: relative;
    }
    .wpbc-panel .welcome-panel .welcome-panel-column {
            width: 32%;
            min-width: 200px;
            float: left;
    }
    .ie8 .wpbc-panel .welcome-panel .welcome-panel-column {
            min-width: 230px;
    }
    .wpbc-panel .welcome-panel .welcome-panel-column:first-child {
            width: 36%;
    }
    .wpbc-panel .welcome-panel-column p {
            margin-top: 7px;
    }
    .wpbc-panel .welcome-panel .welcome-icon {
        background: none;    
        display: block;
        padding: 2px 0 8px 2px;    
    }
    .wpbc-panel .welcome-panel .welcome-add-page {
            background-position: 0 2px;
    }
    .wpbc-panel .welcome-panel .welcome-edit-page {
            background-position: 0 -90px;
    }
    .wpbc-panel .welcome-panel .welcome-learn-more {
            background-position: 0 -136px;
    }
    .wpbc-panel .welcome-panel .welcome-comments {
            background-position: 0 -182px;
    }
    .wpbc-panel .welcome-panel .welcome-view-site {
            background-position: 0 -274px;
    }
    .wpbc-panel .welcome-panel .welcome-widgets-menus {
            background-position: 1px -229px;
            line-height: 14px;
    }
    .wpbc-panel .welcome-panel .welcome-write-blog {
            background-position: 0 -44px;
    }
    .wpbc-panel .welcome-panel .welcome-panel-column ul {
            margin: 0.8em 1em 1em 0;
    }
    .wpbc-panel .welcome-panel .welcome-panel-column li {
        line-height: 16px;
        list-style-type: none;
    }
    @media screen and (max-width: 870px) {
            .wpbc-panel .welcome-panel .welcome-panel-column,
            .wpbc-panel .welcome-panel .welcome-panel-column:first-child {
                    display: block;
                    float: none;
                    width: 100%;
            }
            .wpbc-panel .welcome-panel .welcome-panel-column li {
                    display: inline-block;
                    margin-right: 13px;
            }
            .wpbc-panel .welcome-panel .welcome-panel-column ul {
                    margin: 0.4em 0 0;
            }
            .wpbc-panel .welcome-panel .welcome-icon {
                    padding-left: 25px;
            }
    }
/*]]>*/
</style>                
<div id="wpbc-panel-get-started" class="wpbc-panel" style="display:none;"> <div class="welcome-panel"> 
<?php 
     
    $is_panel_visible = false;
    if ( (class_exists('WPBC_Dismiss')) && (! wpdev_bk_is_this_demo() ) ){
        global $wpbc_Dismiss;
        $is_panel_visible = $wpbc_Dismiss->render(array( 'id'    =>  'wpbc-panel-get-started',
                                     'title' =>  sprintf( __('Dismiss' , 'wpdev-booking' )  )
                              ));
    }
    
    if ($is_panel_visible)
        wpbc_welcome_panel_content(); 
?> 
</div> </div>
<?php
}

function wpbc_welcome_panel_content() {
    global $wpdb;
?>
    <div class="welcome-panel-content">
    <p class="about-description"><?php _e( 'We&#8217;ve assembled some links to get you started:' , 'wpdev-booking'); ?></p>
    <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
            <h4><?php _e( 'Get Started' , 'wpdev-booking'  ); ?></h4>
            <ul>
                <li><div class="welcome-icon"><?php printf( __('Insert booking form %sshortcode%s into your %sPost%s or %sPage%s', 'wpdev-booking'), 
                        '<strong>','</strong>', 
                        '<a href="'.admin_url( 'edit.php' ).'">', '</a>', 
                        '<a href="'.admin_url( 'edit.php?post_type=page' ).'">', '</a>'); ?></div></li>                            

                <li><div class="welcome-icon"><?php printf( __('or add booking calendar %sWidget%s to your sidebar.', 'wpdev-booking'), 
                        '<a href="'.admin_url( 'widgets.php' ).'">', '</a>'); ?></div></li>                            

                <li><div class="welcome-icon"><?php printf( __('Check %show todo%s that and what %sshortcodes%s are available.', 'wpdev-booking'), 
                        '<a href="http://wpbookingcalendar.com/help/inserting-booking-form/" target="_blank">', '</a>', 
                        '<a href="http://wpbookingcalendar.com/help/booking-calendar-shortcodes/" target="_blank">', '</a>' ); ?></div></li>
                <li><div class="welcome-icon"><?php printf( __('Add new booking from your post/page or from %sAdmin Panel%s.', 'wpdev-booking'), 
                        '<a href="'. esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-reservation' ), 'admin.php' ) ) ) .'">', '</a>' ); ?></div></li>                    
            </ul>
        </div>
        <div class="welcome-panel-column">
                <h4><?php _e( 'Next Steps' , 'wpdev-booking' ); ?></h4>
                <ul>
                    <li><div class="welcome-icon"><?php printf( __( 'Check %sBooking Listing%s page for new bookings.', 'wpdev-booking'), 
                        '<a href="'. esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking', 'view_mode' => 'vm_listing' ), 'admin.php' ) ) ) .'">', 
                        '</a>' ); ?></div></li>                                                    
                    <li><div class="welcome-icon"><?php printf(  __( 'Configure booking %sSettings%s.', 'wpdev-booking'), 
                        '<a href="'. esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option' ), 'admin.php' ) ) ) .'">', 
                        '</a>' ); ?></div></li>                            
                    <li><div class="welcome-icon"><?php printf( __( 'Configure predefined set of your %sForm Fields%s.', 'wpdev-booking'), 
                        '<a href="'. esc_url( admin_url( add_query_arg( array( 'page' =>  WPDEV_BK_PLUGIN_DIRNAME . '/'. WPDEV_BK_PLUGIN_FILENAME . 'wpdev-booking-option', 'tab'=>'form' ), 'admin.php' ) ) ) .'">', 
                        '</a>' ); ?></div></li>
                </ul>
        </div>
        <div class="welcome-panel-column welcome-panel-last">
                <h4><?php _e( 'Have a questions?' , 'wpdev-booking'); ?></h4>
                <ul>
                    <li><div class="welcome-icon"><?php printf( __( 'Check out our %sHelp%s', 'wpdev-booking'), 
                        '<a href="http://wpbookingcalendar.com/help/" target="_blank">', 
                        '</a>' ); ?></div></li>
                    <li><div class="welcome-icon"><?php printf( __( 'See %sFAQ%s.', 'wpdev-booking'), 
                        '<a href="http://wpbookingcalendar.com/faq/" target="_blank">', 
                        '</a>' ); ?></div></li>
                    <li><div class="welcome-icon"><?php printf( __( 'Still having questions? Contact %sSupport%s.', 'wpdev-booking'), 
                        '<a href="http://wpbookingcalendar.com/support/" target="_blank">', 
                        '</a>' ); ?></div></li>
                </ul>
        </div>
    </div>
        <div class="welcome-icon welcome-widgets-menus" style="text-align:right;font-style:italic;"><?php 
        printf( __( 'Need even more functionality? Check %s higher versions %s', 'wpdev-booking'),
                '<a href="http://wpbookingcalendar.com/features/" target="_blank">', '</a>' ); ?>
        </div>
    </div> 
    <?php
}

?>