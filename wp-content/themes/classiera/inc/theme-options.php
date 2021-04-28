<?php
    /*==========================
    ReduxFramework Sample Config File
    For full documentation, please visit: http://docs.reduxframework.com/
	===========================*/ 
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
	/*==========================
    This is your option name where all the Redux data is stored.
    ===========================*/
    $opt_name = "redux_demo";

    /*==========================
    This line is only for altering the demo. Can be easily removed.
    ===========================*/
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*==========================
	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
    ===========================*/
    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }
    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /*==========================
    SET ARGUMENTS
    All the possible arguments for Redux.
    For full documentation on arguments, please refer to:
    https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
    ===========================*/
	/*==========================
    For use with some settings. Not necessary.
    ===========================*/
    $theme = wp_get_theme();
	
    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Classiera Options', 'classiera' ),
        'page_title'           => __( 'Classiera Options', 'classiera' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyAr94kq9EE6JV2JkQav-9spfxnzBZtLT_8',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
    /*==========================
    ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    ===========================*/
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://joinwebs.co.uk/docs/classiera',
        'title' => __( 'Documentation', 'classiera' ),
    );
    /*==========================
    SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    ===========================*/
	
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/joinwebs',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/joinwebs',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/joinwebs',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );
	/*==========================
    Panel Intro text -> before the form
	===========================*/
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( 'Welcome To Classiera Classified Ads WordPress Theme Options Panel', 'classiera' ), $v );
    } else {
        $args['intro_text'] = __( 'Welcome To Classiera Classified Ads WordPress Theme Options Panel', 'classiera' );
    }
	/*==========================
    // Add content after the form.
	===========================*/
    $args['footer_text'] = __( 'Thanks for using Classiera Options Panel.', 'classiera' );

    Redux::setArgs( $opt_name, $args );
	
    /*==========================
    START HELP TABS
    ===========================*/

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'classiera' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiera' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'classiera' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiera' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );
	/*==========================
    Set the help sidebar
	===========================*/
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'classiera' );
    Redux::setHelpSidebar( $opt_name, $content );
	/*==========================
	Classiera: General Settings
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'classiera' ),
        'id'               => 'basic-general',
		'icon'             => 'el el-cog',       
        'customizer_width' => '450px',
        'desc'=> __('Classiera General Settings', 'classiera'),
        'fields'           => array(
            array(
				'id'=>'logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo. Recommended image size:150x50', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'logo_offcanvas',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Off-canvas Logo', 'classiera'),
				'compiler' => 'true',		
				'desc'=> __('Upload your logo for off-canvas menu. Recommended image size:150x50', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'favicon',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Favicon', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your favicon.Recommended image size:16x16', 'classiera'),
				'subtitle' => __('Upload your favicon', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id' => 'registor-email-verify',
				'type' => 'switch',
				'title' => __('Email Verification on Register', 'classiera'),
				'subtitle' => __('Email Verification', 'classiera'),
				'desc'=> __('If you turn this ON, a user will have to provide a valid email address. Then a password will be sent to the user’s email inbox. If you turn this OFF, then there is no need for a valid email address. User will be able to set their password at front-end.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_nothumb',
				'type' => 'switch',
				'title' => __('No Thumbnail', 'classiera'),
				'subtitle' => __('Display no thumbnail', 'classiera'),
				'desc'=> __('When user will not upload any image with ad then we will display no thumbnail image.', 'classiera'),
				'default' => false,
            ),
			array(
				'id' => 'classiera_social_login',
				'type' => 'switch',
				'title' => __('Social Login Area', 'classiera'),
				'subtitle' => __('Social Login ON/OFF', 'classiera'),
				'desc'=> __('If you are not using social login and you want to remove the social login option from the login page, then turn OFF this option.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_pagination',
				'type' => 'radio',
				'title' => __('Select pagination type', 'classiera'),
				'subtitle' => __('Pagination type', 'classiera'),
				'desc' => __('Select pagination or Infinite Scroll', 'classiera'),
				'options' => array('pagination' => 'Pagination', 'infinite' => 'Infinite Scroll'),
				'default' => 'pagination'
			),
			array(
				'id' => 'backtotop',
				'type' => 'switch',
				'title' => __('Back To Top Button', 'classiera'),
				'desc' => __('If you don&rsquo;t want to use Back To Top Button then turn this OFF', 'classiera'),
				'subtitle' => __('Turn ON/OFF Back To Top', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_no_of_ads_all_page',
				'type' => 'text',
				'title' => __('Ads Count on All Ads Page', 'classiera'),
				'subtitle' => __('Put Number', 'classiera'),
				'desc' => __('How many ads you want to shown on All Ads Page?', 'classiera'),
				'default' => '12'
			),
			array(
				'id'=>'classiera_cat_ads_count',
				'type' => 'text',
				'title' => __('Ads Count on category Page', 'classiera'),
				'subtitle' => __('Put Number', 'classiera'),
				'desc' => __('How many ads you want to shown on category page?', 'classiera'),
				'default' => '12'
			),
			array(
				'id'=>'classiera_no_of_cats_all_page',
				'type' => 'text',
				'title' => __('Categories Count on All Categories Page', 'classiera'),
				'subtitle' => __('Put Number', 'classiera'),
				'desc' => __('How many Categories do you want to be shown on All Categories Page?', 'classiera'),
				'default' => '12'
			),	
			array(
				'id'=>'tags_limit',
				'type' => 'text',
				'title' => __('Number of tags in the Tag Cloud widget', 'classiera'),
				'subtitle' => __('Number of tags in the Tag Cloud widget', 'classiera'),
				'desc' => __('Put here a number. Example "16"', 'classiera'),
				'default' => '15'
			),
			array(
				'id' => 'footer_widgets_area_on',
				'type' => 'switch',
				'title' => __('Footer Widgets Area ON/OFF', 'classiera'),
				'subtitle' => __('Footer Widgets Area On/OFF', 'classiera'),
				'desc' => __('If You don&rsquo;t want to use widgets in footer, then turn this OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'footer_copyright',
				'type' => 'text',
				'title' => __('Footer Copyright Text', 'classiera'),
				'subtitle' => __('Footer Copyright Text', 'classiera'),
				'desc' => __('You can add text and HTML in here.', 'classiera'),
				'default' => 'All copyrights reserved &copy; 2015 - Design &amp; Development by <a href="http://joinwebs.com">Joinwebs</a>'
			),
			array(
				'id'=>'termsandcondition',
				'type' => 'text',
				'title' => __('Terms And Conditions URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('This link will be shown on the registration page', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'classiera_gdpr_url',
				'type' => 'text',
				'title' => __('GDPR URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('This Link will be shown at registration page', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'classiera_footer_logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Footer Logo', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo for footer. Recommended image size:150x50', 'classiera'),
				'subtitle' => __('Upload Footer logo', 'classiera'),
				'default'=>array('url'=>''),
			),
        )
    ) ); 
	/*==========================
	Classiera: START Email Notifications Settings
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Email Notification', 'classiera' ),
        'id'               => 'classiera_email_notify',
		'icon'             => 'el el-envelope',
		'subsection' => true,
        'customizer_width' => '500px',        
		'desc'=> __('All About Email notifications', 'classiera'),
        'fields'           => array( 
			array(
				'id'=>'classiera_email_logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Email LOGO Image', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your email header logo, Image size:200x60', 'classiera'),
				'subtitle' => __('Upload logo for email header', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'classiera_email_header_img',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Email Header Image', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your email header image. Image size:900x180', 'classiera'),
				'subtitle' => __('Upload header image for email', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id' => 'newusernotification',
				'type' => 'switch',
				'title' => __('Email to Admin on a new user sign-up', 'classiera'),
				'subtitle' => __('Would You like to receive email?', 'classiera'),
				'desc' => __('If you want to receive emails on new user registrations please turn this option ON.', 'classiera'),
				'default' => 2,
            ),
			array(
				'id' => 'classiera_private_email',
				'type' => 'switch',
				'title' => __('Email Pending Post', 'classiera'),
				'subtitle' => __('Would You like to receive email?', 'classiera'),
				'desc' => __('Would you like to receive emails about new posted ads to approve or reject?', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_reject_email',
				'type' => 'switch',
				'title' => __('Email Rejected Post', 'classiera'),
				'subtitle' => __('Would you like emails to be sent?', 'classiera'),
				'desc' => __('Would you like emails to be sent to users about rejected ads?', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_publish_email',
				'type' => 'switch',
				'title' => __('Email Publish Post', 'classiera'),
				'subtitle' => __('Would You like to send email?', 'classiera'),
				'desc' => __('Would you like emails to be sent to users about their ads being published?', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_expire_email',
				'type' => 'switch',
				'title' => __('Email Expired Post', 'classiera'),
				'subtitle' => __('Would You like to send email?', 'classiera'),
				'desc' => __('Would you like emails to be sent to users about their ads being expired/removed?', 'classiera'),
				'default' => true,
            ),
			array(
				'id'=>'email_footer_copyright',
				'type' => 'textarea',
				'title' => __('Email Footer Copyright Text', 'classiera'),
				'subtitle' => __('Email Copyright Text', 'classiera'),
				'desc' => __('You can add text and HTML in here.', 'classiera'),
				'default' => 'All copyrights reserved &copy; 2015 - Design &amp; Development by <a href="http://joinwebs.com">Joinwebs</a>'
			),
		)
    ) );
	/*==========================
	Classiera: START HomePage Settings 
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Homepage Settings', 'classiera' ),
        'id'               => 'homepagesections',
        'desc'             => __( 'Manage all HomePage Sections!', 'classiera' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-dashboard'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Home General Settings', 'classiera' ),
        'id'               => 'basic-home',
		'icon'             => 'el el-home-alt',
		'subsection' => true,
        'customizer_width' => '500px',        
		'desc'=> __('Home General settings of Classiera', 'classiera'),
        'fields'           => array(           
           array(
				'id'=>'home-cat-counter',
				'type' => 'text',
				'title' => __('How many Categories on homepage?', 'classiera'),
				'subtitle' => __('Categories on homepage', 'classiera'),
				'desc' => __('Categories on homepage', 'classiera'),
				'default' => '6'
			),
			array(
				'id'=>'classiera_cat_menu_count',
				'type' => 'text',
				'title' => __('How many Categories in the Categories Menu?', 'classiera'),
				'subtitle' => __('Categories Menu Bar', 'classiera'),
				'desc' => __('Categories Menu Bar on Homepage V4 and Landing Page', 'classiera'),				
				'default' => '6'
			),
			array(
				'id' => 'classiera_cat_post_counter',
				'type' => 'switch',
				'title' => __('Post Counter on Category Box', 'classiera'),
				'subtitle' => __('Post count on Category Box ON/OFF', 'classiera'),
				'desc' => __('If you want to hide ads count from the Category Box, then turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_loc_post_counter',
				'type' => 'switch',
				'title' => __('Post Counter with Location', 'classiera'),
				'subtitle' => __('Locations Post Count ON/OFF', 'classiera'),
				'desc' => __('If you want to hide ads count from the Location Box, then turn this option OFF.', 'classiera'),
				'default' => true,
            ),
			array(
				'id'=>'home-ads-counter',
				'type' => 'text',
				'title' => __('How many Regular Ads on the homepage?', 'classiera'),
				'subtitle' => __('Ads on the homepage', 'classiera'),
				'desc' => __('Ads on the homepage', 'classiera'),
				'default' => '6'
			),
			array(
				'id'=>'classiera_featured_ads_count',
				'type' => 'text',
				'title' => __('How many Featured Ads on the homepage', 'classiera'),
				'subtitle' => __('Ads on homepage', 'classiera'),
				'desc' => __('All Ads section on the homepage', 'classiera'),
				'default' => '6'
			),
			array(
				'id'=>'home-location-counter',
				'type' => 'text',
				'title' => __('How many Locations on the homepage?', 'classiera'),
				'subtitle' => __('Put a number count', 'classiera'),
				'desc' => __('How many locations do you want to be shown on the homepage. Enter a number like 5, 10 , 15, etc.', 'classiera'),			
				'default' => '6'
			),
			array(
				'id'=>'home-ads-view',
				'type' => 'radio',
				'title' => __('Select Ads view type', 'classiera'),
				'subtitle' => __('Ads view type', 'classiera'),
				'desc' => __('Ads view type', 'classiera'),
				'options' => array(
					'grid' => 'Grid view',
					'medium' => 'Grid medium',
					'list' => 'List view'
				),
				'default' => 'grid'
			),		
			array(
				'id'=>'locations-sec-title',
				'type' => 'text',
				'title' => __('Locations title', 'classiera'),
				'subtitle' => __('Locations title', 'classiera'),
				'desc' => __('Enter location title here..', 'classiera'),
				'default' => 'Ads Locations'
			),
			array(
				'id'=>'locations-desc',
				'type' => 'textarea',
				'title' => __('Locations title description', 'classiera'),
				'subtitle' => __('Locations title description', 'classiera'),
				'desc' => __('Enter location sub-title here.', 'classiera'),
				'default' => 'Classiera provides you with an ads location section where you can add your desired locations. There is no limit for the locations, you can enter as many as you wish. '
			),
			array(
				'id'=>'plans-title',
				'type' => 'text',
				'title' => __('Plan title', 'classiera'),
				'subtitle' => __('Plan title', 'classiera'),
				'desc' => __('Enter the plan title here.', 'classiera'),
				'default' => 'Find a plan that&#44;s right for you'
			),
			array(
				'id'=>'plans-desc',
				'type' => 'textarea',
				'title' => __('Plans title description', 'classiera'),
				'subtitle' => __('Plans title description', 'classiera'),
				'desc' => __('Enter the plan sub-title here.', 'classiera'),
				'default' => 'An advertisement section where we have two types of ads listing. One with grids and the other one with list views - Latest Ads, Popular Ads & Random Ads. Also Featured Ads will be shown below.'
			),
			array(
				'id'=>'classiera_plans_bg',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Pricing Plans Background', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload Pricing Plans background image. Recommended size: 1920 x 710', 'classiera'),
				'subtitle' => __('Upload Plans BG', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'ad-desc',
				'type' => 'textarea',
				'title' => __('Advertisement title description', 'classiera'),
				'subtitle' => __('Advertisement title description', 'classiera'),
				'desc' => __('Enter advertisement sub-title here', 'classiera'),
				'default' => 'An advertisement section where we have two types of ads listing. One with grids and the other one with list views - Latest Ads, Popular Ads & Random Ads. Also Featured Ads will be shown below. '
			),
			array(
				'id'=>'cat-sec-title',
				'type' => 'text',
				'title' => __('Categories Section Title', 'classiera'),
				'subtitle' => __('Categories Section Title', 'classiera'),
				'desc' => __('Enter the Categories Section title here.', 'classiera'),
				'default' => 'Ads categories'
			),
			array(
				'id'=>'cat-sec-desc',
				'type' => 'textarea',
				'title' => __('Categories Section Description', 'classiera'),
				'subtitle' => __('Categories Section Description', 'classiera'),
				'desc' => __('Type the Categories Section description here.', 'classiera'),
				'default' => 'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor'
			),		
        )
    ) );
	/*==========================
	Classiera: Static Banner settings 
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Static Banner settings', 'classiera' ),
        'id'         => 'StaticBannersettings',
		'icon'             => 'el el-screen',
        'subsection' => true,
        'desc' => __('If you want to include a banner on the homepage, then you need to set it up from here', 'classiera'), 
        'fields'     => array(
			array(
				'id'       => 'classiera_header_bg',
				'type'     => 'background',
				'title'    => __('Header Banner Background', 'classiera'),
				'subtitle' => __('Header Banner Background, color, etc.', 'classiera'),
				'desc'     => __('IIf you want to display an image, don&rsquo;t select a colour, just upload your image. Banner size: width 1920px and height 733px', 'classiera'),
				'default'  => array(
					'background-color' => '#fff',
					'background-image' => '',
					'background-repeat' => '',
					'background-position' => '',
					'background-size' => '',
					'background-attachment' => '',
				),			 
			),
			array(
				'id'=>'homepage-v2-title',
				'type' => 'text',
				'title' => __('Homepage Header First Heading', 'classiera'),
				'subtitle' => __('Homepage Header First Heading', 'classiera'),
				'desc' => __('Enter the Header title here. Note: this title will only work with homepage V2, V3, V4.', 'classiera'),
				'default' => 'WELCOME TO CLASSIERA'
			),			
			array(
				'id'=>'homepage-v2-desc',
				'type' => 'textarea',
				'title' => __('Homepage Header Description', 'classiera'),
				'subtitle' => __('Homepage Header Description', 'classiera'),
				'desc' => __('Enter the Header description here. Note: this description will only work with homepage V2, V3, V4.', 'classiera'),
				'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard1500s'
			),
			
			array(
                'id'       => 'classiera_banner_heading_typography',
                'type'     => 'typography',
                'title'    => __( 'Header First Heading Font Settings', 'classiera' ),
                'subtitle' => __( 'Specify the font settings properties.', 'classiera' ),
                'letter-spacing'=> true,
				'google'   => true,
                'default'  => array(
                    'color'       => '#fff',
                    'font-size'   => '60px',
                    'font-family' => 'Raleway,sans-serif',
                    'font-weight' => '700',
                    'line-height' => '60px',
                    'text-align' => '',
                    'letter-spacing' => '',
                ),				
            ),
			array(
                'id'       => 'classiera_banner_desc_typography',
                'type'     => 'typography',
                'title'    => __( 'Header Description Font Settings', 'classiera' ),
                'subtitle' => __( 'Specify the font settings properties.', 'classiera' ),
                'letter-spacing'=> true,
				'google'   => true,
                'default'  => array(
                    'color'       => '#fff',
                    'font-size'   => '24px',
                    'font-family' => 'Raleway,sans-serif',
                    'font-weight' => '400',
                    'line-height' => '24px',
                    'text-align' => '',
                    'letter-spacing' => '',
                ),				
            ),
			array(
				'id' => 'classiera_cats_slider',
				'type' => 'switch',
				'title' => __('Turn ON/OFF categories boxes from image slider', 'classiera'),
				'subtitle' => __('Categories boxes ON/OFF', 'classiera'),
				'desc'=> __('In some demos the categories boxes are shown by default, if you don&rsquo;t want to show theme, turn them off from here.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_minimal_header_text',
				'type' => 'text',
				'title' => __('Minimal Header Text', 'classiera'),
				'subtitle' => __('Replace text', 'classiera'),
				'desc' => __('If you are using minimal header, you can change the text from here.', 'classiera'),
				'default' => 'World Biggest <span>Classified Ads</span> Search Engine'
			),
		)
    ) );
	/*==========================
	Classiera: Call To Action
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Call To Action', 'classiera' ),
        'id'         => 'call-to-section',
		'icon'             => 'el el-asl',
        'subsection' => true,
        'desc' => __('Manage the Call To Action (CTA) section on the homepage. If you are not using this section, then no need to do anything here.', 'classiera'), 
        'fields'     => array(			
		array(
			'id'       => 'classiera_call_to_action_background',
			'type'     => 'background',
			'title'    => __('CTA Background', 'classiera'),
			'subtitle' => __('Upload CTA Background', 'classiera'),
			'desc'     => __('If you want to display an image, don&rsquo;t select a colour, just upload your image. Banner size: width 1920px and height 600px', 'classiera'),
			'default'  => array(
				'background-color' => '#fff',
				'background-image' => '',
				'background-repeat' => '',
				'background-position' => '',
				'background-size' => '',
				'background-attachment' => '',
			),			 
		),
		array(
			'id'=>'classiera_call_to_action_about_icon',
			'type' => 'media', 
			'url'=> true,
			'title' => __('CTA About Icon', 'classiera'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your CTA About Icon', 'classiera'),
			'subtitle' => __('Upload CTA About Icon', 'classiera'),
			'default'=>array('url'=>''),
			),	
		array(
			'id'=>'classiera_call_to_action_about',
			'type' => 'text',
			'title' => __('Call To Action Title ', 'classiera'),
			'subtitle' => __('Call To Action Title', 'classiera'),
			'desc' => __('Enter the homepage CTA title here.', 'classiera'),
			'default' => 'About Us'
			),
		array(
			'id'=>'classiera_call_to_action_about_desc',
			'type' => 'textarea',
			'title' => __('Homepage CTA Description ', 'classiera'),
			'subtitle' => __('CTA Description', 'classiera'),
			'desc' => __('Enter the homepage CTA description here', 'classiera'),
			'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
			),
		array(
			'id'=>'classiera_call_to_action_sell_icon',
			'type' => 'media', 
			'url'=> true,
			'title' => __('CTA Sell Icon', 'classiera'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your CTA Sell Icon', 'classiera'),
			'subtitle' => __('Upload CTA Sell Icon', 'classiera'),
			'default'=>array('url'=>''),
			),
		array(
			'id'=>'classiera_call_to_action_sell',
			'type' => 'text',
			'title' => __('CTA Sell Title ', 'classiera'),
			'subtitle' => __('CTA Sell Title', 'classiera'),
			'desc' => __('Enter the homepage CTA Sell title here.', 'classiera'),
			'default' => 'Sell Safely'
			),
		array(
			'id'=>'classiera_call_to_action_sell_desc',
			'type' => 'textarea',
			'title' => __('Homepage CTA sell Description ', 'classiera'),
			'subtitle' => __('CTA sell Description', 'classiera'),
			'desc' => __('Enter the homepage CTA sell description here.', 'classiera'),
			'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
			),
		array(
			'id'=>'classiera_call_to_action_buy_icon',
			'type' => 'media', 
			'url'=> true,
			'title' => __('CTA Buy Icon', 'classiera'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your CTA Buy Icon', 'classiera'),
			'subtitle' => __('Upload CTA Buy Icon', 'classiera'),
			'default'=>array('url'=>''),
			),	
		array(
			'id'=>'classiera_call_to_action_buy',
			'type' => 'text',
			'title' => __('Homepage CTA Buy Title ', 'classiera'),
			'subtitle' => __('CTA Buy Title', 'classiera'),
			'desc' => __('Enter the homepage CTA Buy title here', 'classiera'),
			'default' => 'Buy Safely'
			),
		array(
			'id'=>'classiera_call_to_action_buy_desc',
			'type' => 'text',
			'title' => __('Homepage CTA Buy Description ', 'classiera'),
			'subtitle' => __('CTA Buy Description', 'classiera'),
			'desc' => __('Enter the homepage CTA Buy description here', 'classiera'),
			'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
			),
		)
    ) );
	/*==========================
	Classiera: Callout Message
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Callout Message', 'classiera' ),
        'id'         => 'basic-callout',
		'icon'             => 'el el-bullhorn',
        'subsection' => true,
        'desc'=> __('Callout Message for the homepage', 'classiera'),
        'fields'     => array(
			array(
				'id' => 'classiera_parallax',
				'type' => 'switch',
				'title' => __('Parallax effect', 'classiera'),
				'subtitle' => __('Turn ON/OFF', 'classiera'),
				'desc' => __('Turn ON/OFF the Parallax effect. This effect will work on Strobe, Coral, Canary', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'callout-bg',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Callout Background', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your Image.', 'classiera'),
				'subtitle' => __('Callout Background', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'callout-bg-version2',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Callout Small Image', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('This image will be shown on the home page V2, V3, V4. Image size: 435 x 360', 'classiera'),
				'subtitle' => __('Callout Small Image', 'classiera'),
				'default'=>array('url'=>''),
			),	
			array(
				'id'=>'callout_title',
				'type' => 'text',
				'title' => __(' Callout Title', 'classiera'),
				'desc'=> __('Enter the Callout title here', 'classiera'),
				'subtitle' => __('Callout Title', 'classiera'),
				'default'=>'ARE YOU READY',
			),
			array(
				'id'       => 'classiera_title_color',
				'type'     => 'color',
				'title'    => __('Callout Title Color', 'classiera'), 
				'subtitle' => __('Pick a text color default: #ffffff.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'=>'callout_title_second',
				'type' => 'text',
				'title' => __(' Callout second Title', 'classiera'),
				'desc'=> __('Enter the Callout second title here', 'classiera'),
				'subtitle' => __('Callout second Title', 'classiera'),
				'default'=>'FOR THE POSTING YOUR ADS ON <span>&quot;ClassiEra?&quot;</span>',
			),
			array(
				'id'       => 'classiera_second_title_color',
				'type'     => 'color',
				'title'    => __('Callout second title text Color', 'classiera'), 
				'subtitle' => __('Pick a Color default: #ffffff.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'=>'callout_desc',
				'type' => 'textArea',
				'title' => __(' Callout Description', 'classiera'),
				'desc'=> __('Enter the Callout description here.', 'classiera'),
				'subtitle' => __('Callout Description', 'classiera'),
				'default'=>'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor..',
			),
			array(
				'id'       => 'classiera_desc_color',
				'type'     => 'color',
				'title'    => __('Callout description Color', 'classiera'), 
				'subtitle' => __('Pick a colour for the callout description text. Default: #ffffff.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'=>'callout_btn_text',
				'type' => 'text',
				'title' => __(' Callout Button Text', 'classiera'),
				'desc'=> __('Enter the Callout Button text here.', 'classiera'),
				'subtitle' => __('Callout Button Text', 'classiera'),
				'default'=>'Get Started ',
			),
			array(
				'id'=>'callout_btn_icon_code',
				'type' => 'text',
				'title' => __('Callout First Button icon', 'classiera'),
				'desc'=> __('Enter a Font Awesome icon code here. This code will only work on Home V1 and Home V2.', 'classiera'),
				'default'=>'fas fa-plus-circle',
			),
			array(
				'id'=>'callout_btn_url',
				'type' => 'text',
				'title' => __(' Callout Button URL', 'classiera'),
				'desc'=> __('Enter your Callout Button URL.', 'classiera'),
				'subtitle' => __('Callout Button URL', 'classiera'),
				'validate' => 'url',
				'default'=>'',
			),
			array(
				'id'=>'callout_btn_text_two',
				'type' => 'text',
				'title' => __(' Callout Second Button Text', 'classiera'),
				'desc'=> __('Enter the Second Callout Button text.', 'classiera'),
				'subtitle' => __('Callout Button Text', 'classiera'),
				'default'=>'Get Started ',
			),
			array(
				'id'=>'callout_btn_icon_code_two',
				'type' => 'text',
				'title' => __('Callout Second Button icon', 'classiera'),
				'desc'=> __('Enter a Font Awesome icon code here. This code will only work on Home V1 and Home V2.', 'classiera'),
				'default'=>'fas fa-shopping-cart',
			),
			array(
				'id'=>'callout_btn_url_two',
				'type' => 'text',
				'title' => __(' Callout Second Button URL', 'classiera'),
				'desc'=> __('Enter your Second Callout Button URL.', 'classiera'),
				'subtitle' => __('Callout Button URL', 'classiera'),
				'validate' => 'url',
				'default'=>'',
			),
		)
    ) );
	/*==========================
	Classiera: START Search Section
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Search Setting', 'classiera' ),
        'id'               => 'classiera_search',
        'customizer_width' => '500px',
		'subsection' => true,
        'icon'             => 'el el-search',
		'desc'  => __( 'Search Page Setting', 'classiera' ),
		'fields'     => array(
			array(
				'id'=>'classiera_max_price_input',
				'type' => 'text',
				'title' => __('Max Price', 'classiera'),
				'subtitle' => __('Put Value', 'classiera'),
				'desc' => __('Max Price Value for Advance Search', 'classiera'),
				'default' => '100000'
			),
			array(
				'id' => 'classiera_search_location_on_off',
				'type' => 'switch',
				'title' => __('Location in Search Bar', 'classiera'),
				'subtitle' => __('Turn On/OFF', 'classiera'),
				'desc' => __('Turn ON/OFF Location in Search Bar', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_search_location_type',
				'type' => 'radio',
				'title' => __('Select locations type', 'classiera'),
				'subtitle' => __('Locations type in header', 'classiera'),
				'desc' => __('Select dropdown or text input..', 'classiera'),
				'options' => array('dropdown' => 'Dropdown', 'input' => 'Text Input'),
				'default' => 'input'
			),
			array(
				'id'=>'location-shown-by',
				'type' => 'select',
				'title' => __('Location filter', 'classiera'),
				'subtitle' => __('Filter location by', 'classiera'),
				'desc' => __('Location section filtered by Countries, States or Cities?', 'classiera'),
				'options' => array('post_location' => 'Country', 'post_state' => 'States', 'post_city' =>'City'),
				'default' => 'post_city'
			),
			array(
				'id' => 'classiera_pricerange_on_off',
				'type' => 'switch',
				'title' => __('Price Range in the sidebar advanced search', 'classiera'),
				'subtitle' => __('Turn On/OFF', 'classiera'),
				'desc' => __('Turn ON/OFF the Price Range in the sidebar advanced search', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_pricerange_style',
				'type' => 'radio',
				'title' => __('Select the Price Range style', 'classiera'),
				'subtitle' => __('Search style in the advanced search..', 'classiera'),
				'desc' => __('This will only work in the sidebar advanced search.', 'classiera'),
				'options' => array('slider' => 'Price Range Slider with radio', 'input' => 'Min and Max Price input'),
				'default' => 'slider'
			),
			array(
				'id' => 'classiera_adv_search_on_cats',
				'type' => 'switch',
				'title' => __('Advanced Search on the Categories page', 'classiera'),
				'subtitle' => __('Turn On/OFF', 'classiera'),
				'desc' => __('Turn ON/OFF the Advanced Search in the Categories page.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_search_map_max_post',
				'type' => 'text',
				'title' => __('How many posts on the Search Map?', 'classiera'),
				'subtitle' => __('Post Count', 'classiera'),
				'desc' => __('How many results do you want to be shown on the Google Map?', 'classiera'),
				'default' => '100'
			),
			array(
				'id'=>'classiera_search_max_post',
				'type' => 'text',
				'title' => __('How many featured Ads on search page?', 'classiera'),
				'subtitle' => __('Post Count', 'classiera'),
				'desc' => __('How many Featured Ads do you want to be shown on the search result page? Regular ads will be shown after the number of the Featured Ads', 'classiera'),
				'default' => '10'
			),
			array(
				'id'=>'classiera_max_post_ajax',
				'type' => 'text',
				'title' => __('How many ads to include in the AJAX search?', 'classiera'),
				'subtitle' => __('Top bar search results', 'classiera'),
				'desc' => __('From here you can set a number of ads you want to be shown in the AJAX results on keywords  type. You can limit the ads count to increase the response time if you are using a cheap hosting.', 'classiera'),
				'default' => '100'
			),
			array(
				'id' => 'classiera_remove_ajax',
				'type' => 'switch',
				'title' => __('AJAX search field in the top search bar', 'classiera'),
				'subtitle' => __('Turn On/OFF', 'classiera'),
				'desc' => __('If you don&rsquo;t want to use the AJAX search in the top search bar, simply turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
		)
    ) );
	/*==========================
	Classiera: Blogs Section
	===========================*/
	Redux::setSection( $opt_name, array(
        'title' => __( 'Blogs', 'classiera' ),
        'id'    => 'classiera_blogs',
		'subsection' => true,
        'desc'  => __( 'Manage the Blog section on the homepage', 'classiera' ),
        'icon'  => 'el el-question',
		'fields' => array(
			array(
				'id'=>'classiera_blog_section_title',
				'type' => 'text',
				'title' => __('Blog Section Title', 'classiera'),
				'subtitle' => __('Replace text', 'classiera'),
				'desc' => __('Change the Blog section title on the homepage.', 'classiera'),
				'default' => 'Latest From Blog'
			),
			array(
				'id'=>'classiera_blog_section_desc',
				'type' => 'textarea',
				'title' => __('Blog Section Description', 'classiera'),
				'subtitle' => __('Replace text', 'classiera'),
				'desc' => __('Change the Blog section description on the homepage.', 'classiera'),
				'default' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable.'
			),
			array(
				'id'=>'classiera_blog_section_count',
				'type' => 'text',
				'title' => __('How Many Post', 'classiera'),
				'subtitle' => __('Post Count', 'classiera'),
				'desc' => __('How many blogs posts do you want to be shown in the Blog section on the homepage?', 'classiera'),
				'default' => '6'
			),
			array(
				'id'=>'classiera_blog_section_post_order',
				'type' => 'radio',
				'title' => __('Blog Section Post Order', 'classiera'), 
				'subtitle' => __('orderby', 'classiera'),				
				'options' => array('title' => 'Order by title','name' => 'Order by name','date' => 'Order by date','rand' => 'Order by random'),//Must provide key => value pairs for radio options
				'default' => 'title'
			),
			array(
				'id'=>'classiera_blog_post_order',
				'type' => 'radio',
				'title' => __('Blog Post Order', 'classiera'), 
				'subtitle' => __('Order', 'classiera'),				
				'options' => array('ASC' => 'Order by ASC','DESC' => 'Order by DESC'),//Must provide key => value pairs for radio options
				'default' => 'DESC'
			),
		)
    ) );
	/*==========================
	Classiera: START Layout Manager
	===========================*/
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Manager', 'classiera' ),
        'id'               => 'layoutmanager',
        'desc'             => __( 'Home Page and Landing Page Manager', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-align-justify'
    ) );
	/*==========================
	Classiera: Layout Utilities
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Utilities', 'classiera' ),
        'id'               => 'classiera_design_settings',
		'subsection' => true,
		'desc'  => __( 'In this section you can select one of the available Layout Designs for a number of sections throughout the website.', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-brush',
		'fields'     => array(			
			array(
				'id'=>'nav-style',
				'type' => 'radio',
				'title' => __('Nav Styles', 'classiera'), 
				'subtitle' => __('Nav Styles', 'classiera'),
				'desc' => __('Nav Styles', 'classiera'),
				'options' => array(
					'1' => 'Version 1(Lime)',
					'2' => 'Version 2(Strobe)',
					'3' => 'Version 3(Coral)',
					'4' => 'Version 4(Canary, Cherry)',
					'5' => 'Version 5(IVY)',
					'6' => 'Version 6(IRIS, Plum)',
					'7' => 'Version 7(Allure)',
					'8' => 'Version 8(Minimal)',
				),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id' => 'classiera_sticky_nav',
				'type' => 'switch',
				'title' => __('Sticky Navbar', 'classiera'),
				'subtitle' => __('ON/OFF', 'classiera'),
				'desc'=> __('Turn OFF this option if you don&rsquo;t need a sticky navbar.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_mobile_btn',
				'type' => 'switch',
				'title' => __('Mobile button', 'classiera'),
				'subtitle' => __('ON/OFF', 'classiera'),
				'desc'=> __('Turn OFF mobile bottom button', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_page_search',
				'type' => 'switch',
				'title' => __('Search bar', 'classiera'),
				'subtitle' => __('Custom pages', 'classiera'),
				'desc'=> __('If you want to turn OFF search bar from your custom pages like about us, privacy policy etc, Then turn OFF this option.', 'classiera'),
				'default' => true,
            ),
			array(
				'id'=>'classiera_search_style',
				'type' => 'radio',
				'title' => __('Search Styles', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('The selection will work on all pages other than the homepage, on homepage search bar will be used from template', 'classiera'),
				'options' => array(
					'1' => 'Version 1(Lime)',
					'2' => 'Version 2(Strobe)',
					'3' => 'Version 3(Coral)',
					'4' => 'Version 4(Canary)',
					'5' => 'Version 5(IVY)',
					'6' => 'Version 6(IRIS, Plum)',
					'7' => 'Version 7(Allure, Cherry)'
				),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id'=>'classiera_premium_style',
				'type' => 'radio',
				'title' => __('Premium Styles', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('The selection will work on all pages other than the homepage, on homepage design will be used from template', 'classiera'),
				'options' => array(
					'1' => 'Version 1(Lime)',
					'2' => 'Version 2(Strobe)',
					'3' => 'Version 3(Coral)',
					'4' => 'Version 4(IVY)',
					'5' => 'Version 5(IRIS)',
					'6' => 'Version 6(Allure)',
					'7' => 'Version 7(Cherry, Plum)',
					'8' => 'Version 8(Minimal)'
				),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id'=>'classiera_cat_style',
				'type' => 'radio',
				'title' => __('Categories Styles', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('The selection will work on all pages other than the homepage, on homepage design will be used from template', 'classiera'),
				'options' => array(
					'1' => 'Version 1(Lime)',
					'2' => 'Version 2(Strobe)',
					'3' => 'Version 3(Coral)',
					'4' => 'Version 4(Canary)',
					'5' => 'Version 5(IVY)',
					'6' => 'Version 6(IRIS)',
					'7' => 'Version 7(Allure)',
					'8' => 'Version 8(Cherry)',
					'9' => 'Version 9(Plum)',
					'10' => 'Version 10(Minimal)',
				),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id'=>'classiera_plans_style',
				'type' => 'radio',
				'title' => __('Pricing Plans Styles', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('The selection will only work on the Pricing Plans page itself, on homepage design will be used from layout manager', 'classiera'),
				'options' => array(
					'1' => 'Version 1(Lime)',
					'2' => 'Version 2(Strobe)',
					'3' => 'Version 3(Coral)',
					'4' => 'Version 4(Canary)',
					'5' => 'Version 5(IVY)',
					'6' => 'Version 6(IRIS)',
					'7' => 'Version 7(Allure)'					
				),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id'=>'classiera_cat_icon_img',
				'type' => 'radio',
				'title' => __('Category icons source', 'classiera'), 
				'subtitle' => __('Select the category icons source', 'classiera'),
				'desc' => __('Do you want to use Font Awesome or your own images for the category icons?', 'classiera'),
				'options' => array('icon' => 'Font Awesome Icons', 'img' => 'Custom Images Icon'),//Must provide key => value pairs for radio options
				'default' => 'icon'
			),
			array(
				'id'=>'classiera_cat_child',
				'type' => 'radio',
				'title' => __('Category icons path', 'classiera'), 
				'subtitle' => __('Select category icons path', 'classiera'),
				'desc' => __('Do you want to use parent category icons only, or do you also want to use icons in child categories? If you select Child Categories, then you will have to upload icons for all child categories.', 'classiera'),
				'options' => array(
					'main' => 'From Parent Categories', 
					'child' => 'From Child Categories'
				),
				'default' => 'main'
			),
			array(
				'id'=>'classiera_single_ad_style',
				'type' => 'radio',
				'title' => __('Single Ad Page', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('Select a style for a single ad page', 'classiera'),
				'options' => array('1' => 'Version 1', '2' => 'Version 2'),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			
			array(
				'id'=>'classiera_author_page_style',
				'type' => 'radio',
				'title' => __('Author Page Style', 'classiera'), 
				'subtitle' => __('Select Style', 'classiera'),
				'desc' => __('Select a style for the Author Public Profile Page.', 'classiera'),
				'options' => array('fullwidth' => 'Full Width', 'sidebar' => 'With Sidebar'),//Must provide key => value pairs for radio options
				'default' => 'fullwidth'
			),
			array(
				'id'=>'classiera_footer_style',
				'type' => 'radio',
				'title' => __('Footer Style', 'classiera'), 
				'subtitle' => __('Select Style', 'classiera'),
				'desc' => __('Select a style for the footer', 'classiera'),
				'options' => array(
					'three' => 'Three Column',
					'four' => 'Four Column',
					'minimal' => 'Minimal'
				),
				'default' => 'three'
			),
			array(
				'id'=>'classiera_footer_bottom_style',
				'type' => 'radio',
				'title' => __('Footer bottom Style', 'classiera'), 
				'subtitle' => __('Select Style', 'classiera'),
				'desc' => __('Select what you prefer to be shown in the footer bottom. Menu or Social icons?', 'classiera'),
				'options' => array('menu' => 'Menu', 'icon' => 'Social icon'),//Must provide key => value pairs for radio options
				'default' => 'menu'
			),
			array(
				'id' => 'classiera_categories_desc',
				'type' => 'switch',
				'title' => __('Categories description', 'classiera'),
				'subtitle' => __('ON/OFF', 'classiera'),
				'desc'=> __('If you want to show category descriptions on the Category page, then turn this option ON.', 'classiera'),
				'default' => 0,
            ),			
		)
    ) );
	/*==========================
	Classiera: START Home Layout Manager
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Layout Manager', 'classiera' ),
        'id'               => 'homelayoutmanager',
		'subsection' => true,
		'desc'  => __( 'These settings will only work for the Homepage Version 1. If you want to disable any section just drag it from the &ldquo;enabled&rdquo; to the &ldquo;disabled&rdquo; section.', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-home-alt',
		'fields'     => array(
			array(
                'id'       => 'opt-homepage-layout',
                'type'     => 'sorter',
                'title'    => 'Homepage Layout Manager(Lime)',
                'desc'     => 'Organize how you want the layout to appear on the homepage',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'googlemap' => 'Google MAP',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'searchv1' => 'Search Bar',
                        'premiumslider'   => 'Premium Ads Slider',                       
                        'categories'   => 'Categories',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'advertisement'   => 'Advertisement',
                        'packages'   => 'Pricing Plans',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v2',
                'type'     => 'sorter',
                'title'    => 'Homepage V2 Layout Manager (Strobe)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V2',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(						
                        'customads'   => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'googlemap' => 'Google MAP',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
						'searchv2' => 'Search Bar',
						'premiumslider'   => 'Premium Ads Slider',
						'categories'   => 'Categories',
						'advertisement'   => 'Advertisement',
                        'callout'   => 'Callout',
						'location'   => 'Location',
						'packages'   => 'Pricing Plans',
                        'partners'   => 'Partners', 
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v3',
                'type'     => 'sorter',
                'title'    => 'Homepage V3 Layout Manager (Coral)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V3',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'googlemap' => 'Google MAP',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(  
						'layerslider' => 'LayerSlider',
						'searchv3' => 'Search Bar',
						'premiumslider'   => 'Premium Ads Slider',
						'categories'   => 'Categories',
						'advertisement'   => 'Advertisement',
						'callout'   => 'Callout',
						'location'   => 'Location',
						'packages'   => 'Pricing Plans',
						'partners'   => 'Partners',	
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v4',
                'type'     => 'sorter',
                'title'    => 'Homepage V4 Layout Manager (Canary)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V4',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'googlemap' => 'Google MAP',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
						'categoriesmenu'   => 'Categories Bar',
						'layerslider' => 'LayerSlider',
						'searchv4' => 'Search Bar',
						'categories'   => 'Categories',
						'advertisement'   => 'Advertisement',
						'callout'   => 'Callout',
						'packages'   => 'Pricing Plans',						
						'blogs'   => 'Blog Section',
						'partners'   => 'Partners',
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v5',
                'type'     => 'sorter',
                'title'    => 'Homepage V5 Layout Manager (IVY)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V5',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
						'customads' => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'googlemap' => 'Google MAP',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
						'searchv5' => 'Search Bar',
						'banner' => 'Image Slider',
						'premiumslider'   => 'Premium Ads Slider',
						'categories'   => 'Categories',
						'callout'   => 'Callout',
						'location'   => 'Location',
						'advertisement'   => 'Advertisement',
						'packages'   => 'Pricing Plans',
						'blogs'   => 'Blog Section',
						'partners'   => 'Partners',
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v6',
                'type'     => 'sorter',
                'title'    => 'Homepage V6 Layout Manager (IRIS)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V6',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
						'customads' => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'banner' => 'Big Slider',
						'premiumslider'   => 'Premium Ads Slider',
						'categories'   => 'Categories',
						'advertisement'   => 'Advertisement',
						'callout'   => 'Callout',
						'location'   => 'Location',						
						'packages'   => 'Pricing Plans',
						'blogs'   => 'Blog Section',
						'partners'   => 'Partners',
                    ),
                ),
            ),
			array(
                'id'       => 'opt-homepage-layout-v7',
                'type'     => 'sorter',
                'title'    => 'Homepage V7 Layout Manager (Allure)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V7',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
						'customads' => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'banner' => 'Big Slider',
						'premiumslider'   => 'Premium Ads Slider',
						'categories'   => 'Categories',
						'callout'   => 'Callout',
						'location'   => 'Location',
						'advertisement'   => 'Advertisement',
						'packages'   => 'Pricing Plans',
						'blogs'   => 'Blog Section',
						'partners'   => 'Partners',
                    ),
                ),
            ),
		)
    ) );
	/*==========================
	Classiera: START Landing Page
	===========================*/
	
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Landing Page Manager', 'classiera' ),
        'id'               => 'landingpagemanager',
		'subsection' => true,
		'desc'  => __( 'These settings will only work on the Landing Page. You can use any section below on the Landing Page.', 'classiera' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-home-alt',
		'fields'     => array(
			array(
                'id'       => 'opt-homepage-layout-landing',
                'type'     => 'sorter',
                'title'    => 'Landing Page Layout Manager',
                'desc'     => 'Organize how you want the layout to appear on the Landing Page',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array( 
						'navcategories' => 'Nav Categories Canary',
						'imgslider1' => 'Image Slider IVY',
						'imgslider2' => 'Image Slider IRIS - Plum',
						'imgslider3' => 'Image Slider Allure-Cherry',
						'slidermini' => 'Minimal Slider',
						'googlemap' => 'Google MAP',
						'searchv2' => 'Search Strobe',
						'searchv3' => 'Search Coral',
						'searchv4' => 'Search Canary',
						'searchv5' => 'Search IVY',
						'searchv6' => 'Search IRIS',
						'searchv7' => 'Search Allure',
						'searchmini' => 'Search Minimal',
						'premiumslider2'   => 'Premium Ads Strobe',
						'premiumslider3'   => 'Premium Ads Coral',
						'premiumslider4'   => 'Premium Ads IVY ',
						'premiumslider5'   => 'Premium Ads IRIS',
						'premiumslider6'   => 'Premium Ads Allure',
						'premiumslider7'   => 'Premium Ads Cherry - Plum',
						'premiumslider8'   => 'Premium Ads Minimal',
						'categories2'   => 'Categories Strobe',
						'categories3'   => 'Categories Coral',
						'categories4'   => 'Categories Canary',
						'categories5'   => 'Categories IVY',
						'categories6'   => 'Categories IRIS',
						'categories7'   => 'Categories Allure',
						'categories8'   => 'Categories Cherry',
						'categories9'   => 'Categories Plum',
						'categories10'   => 'Categories Minimal',
						'advertisement2'   => 'Advertisement Strobe',		
						'advertisement3'   => 'Advertisement Coral',		
						'advertisement4'   => 'Advertisement Canary',		
						'advertisement5'   => 'Advertisement IVY - Cherry - Plum',		
						'advertisement6'   => 'Advertisement IRIS',		
						'advertisement7'   => 'Advertisement Allure',
						'locationv2'   => 'Location Strobe',
						'locationv3'   => 'Location Coral',
						'locationv4'   => 'Location IVY',
						'locationv5'   => 'Location IRIS - Allure',						
						'locationv6'   => 'Location Plum - Cherry',
						'locationv7'   => 'Location Minimal',
						'plans2'   => 'Pricing Plans Strobe',
						'plans3'   => 'Pricing Plans Coral',
						'plans4'   => 'Pricing Plans Canary',
						'plans5'   => 'Pricing Plans IVY',
						'plans6'   => 'Pricing Plans IRIS',
						'plans7'   => 'Pricing Plans Allure',
						'callout2'   => 'Callout Strobe',
						'callout3'   => 'Callout Coral',
						'callout4'   => 'Callout Canary - Plum',
						'callout5'   => 'Callout IVY',
						'callout6'   => 'Callout IRIS - Cherry',
						'callout7'   => 'Callout Allure',
						'partners2'   => 'Partners Style 2',
						'partners3'   => 'Partners Style 3',
						'partners4'   => 'Partners Style 4- Cherry - Plum',
						'partners5'   => 'Partners Style 5',
						'partners6'   => 'Partners Style 6',
						'blogs2'   => 'Blog Style 2',
						'blogs3'   => 'Blog Style 3',
						'blogs4'   => 'Blog Style 4',
						'customads' => 'Banner ads',
						'customads2'   => 'Banner ads 2',
						'customads3'   => 'Banner ads 3',
						'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
						'searchv1' => 'Search Lime',
						'premiumslider1'   => 'Premium Ads Lime',
						'categories1'   => 'Categories Lime',
						'advertisement1'   => 'Advertisement Lime',
						'locationv1'   => 'Location Lime',
						'plans1'   => 'Pricing Plans Lime',
						'callout1'   => 'Callout Style Lime',
						'partners1'   => 'Partners Lime',
						'blogs1'   => 'Blog Style 1',
                    ),
                ),
            ),
		)
    ) );
	/*==========================
	Classiera: Ads Manager
	===========================*/	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Ads Manager', 'classiera' ),
        'id'               => 'adsmanager',
        'desc'             => __( 'Manage Premium Ads and Regular Ads', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-signal'
    ) );
	/*==========================
	Classiera: Premium Ads
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Premium Ads', 'classiera' ),
        'id'               => 'premiumads',
		'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-usd',
		'fields'     => array(
			array(
				'id'=>'premium-sec-title',
				'type' => 'text',
				'title' => __('Premium Section Title', 'classiera'),
				'subtitle' => __('Premium Section Title', 'classiera'),
				'desc' => __('Enter the Premium Section title.', 'classiera'),
				'default' => 'PREMIUM ADVERTISEMENT'
			),
			array(
				'id'=>'premium-sec-desc',
				'type' => 'textarea',
				'title' => __('Premium Section Description', 'classiera'),
				'subtitle' => __('Premium Section Description', 'classiera'),
				'desc' => __('Enter the Premium Section description.', 'classiera'),
				'default' => 'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor.'
			),
			array(
				'id' => 'featured-options-on',
				'type' => 'switch',
				'title' => __('Premium Ads slider', 'classiera'),
				'subtitle' => __('Ads slider', 'classiera'),
				'desc' => __('If you want to exclude the Premium Ads slider from all pages other than the homepage, then turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'featured-caton',
				'type' => 'switch',
				'title' => __('Featured Category ON/OFF', 'classiera'),
				'subtitle' => __('Ads shown in the Featured Category.', 'classiera'),
				'desc' => __('If you don&rsquo;t want to use the Featured Category, then turn this option OFF.', 'classiera'),
				'default' => 2,
            ),
			array(
				'id' => 'featured-ads-cat',
				'type' => 'select',
				'data' => 'categories',
				'multi'    => true,	
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'default' => '',
				'title' => __('Featured Category', 'classiera'),
				'subtitle' => __('Featured Category', 'classiera'), 
				'desc' => __('Here you can choose ad category/categories which will be shown in the Premium Slider Section. Leave empty to include all categories.', 'classiera'),
            ),			
			array(
				'id'=>'premium-ads-counter',
				'type' => 'text',
				'title' => __('How many ads in the Premium Ads Slider?', 'classiera'),
				'subtitle' => __('Ads in the Premium Ads Slider', 'classiera'),
				'desc' => __('How many Premium Ads do you want to be shown in the Premium Ads Slider?', 'classiera'),
				'default' => '9'
			),
			array(
				'id'=>'premium-ads-limit',
				'type' => 'text',
				'title' => __('How many images for Premium Ads?', 'classiera'),
				'subtitle' => __('Premium Ads Image Limit', 'classiera'),
				'desc' => __('Enter a value for the Premium Ads. How many images do you allow paid users to be able to upload? Example: "3"', 'classiera'),
				'default' => '3'
			),
			array(
				'id' => 'classiera_featured_expiry',
				'type' => 'switch',
				'title' => __('Featured Ads Expiry', 'classiera'),
				'subtitle' => __('ON/OFF Featured Ads Expiry', 'classiera'),
				'desc' => __('If you turn ON this option, then the featured ads will be removed after the expiry date.', 'classiera'),
				'default' => false,
            ),
		)
    ) );
	/*==========================
	Classiera: Regular Ads
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Regulars Ads', 'classiera' ),
        'id'               => 'regularadsposting',
		'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-usd',
		'fields'     => array(
			array(
				'id' => 'regular-ads',
				'type' => 'switch',
				'title' => __('Regular ad posting ON/OFF', 'classiera'),
				'subtitle' => __('Regular ad posting ON/OFF', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'ad_expiry',
				'type' => 'select',
				'title' => __('Regular Ads Expiry', 'classiera'), 
				'subtitle' => __('Regular Ads Expiry', 'classiera'),
				'desc' => __('Regular Ads Expiry', 'classiera'),
				'options' => array(
					'1' => 'One Day',
					'2' => 'Two Days',
					'3' => 'Three Days',
					'4' => 'Four Days',
					'5' => 'Five Days',
					'6' => 'Six Days',
					'7' => 'One week',
					'14' => 'Two weeks',
					'21' => 'Three weeks',
					'30' => 'One Month',
					'60' => 'Two Months',
					'90' => 'Three Months',
					'120' => 'Four Months',
					'150' => 'Five Months',
					'180' => 'Six Months',
					'365' => 'One Year',
					'lifetime' => 'Lifetime'
				),
				'default' => 'lifetime'
			),
			array(
				'id'=>'classiera_regularad_expire_status',
				'type' => 'radio',
				'title' => __('Ad Expiry Status', 'classiera'),
				'subtitle' => __('Select Status', 'classiera'),
				'desc' => __('If you select “Trash”, then a user ad will be moved to Trash and the user will not be able to restore the ad. But if you choose to select “Expired”, then the user can restore their ad any time.', 'classiera'),
				'options' => array(
					'trash' => 'Trash',
					'expired' => 'Expired'
				),
				'default' => 'trash'
			),
			array(
				'id'=>'regular-ads-limit',
				'type' => 'text',
				'title' => __('How many images for Regular Ads?', 'classiera'),
				'subtitle' => __('Regular Ads Image Limit', 'classiera'),
				'desc' => __('Enter a value for the Regular Ads. How many images do you allow regular users to be able to upload? Example: "2"', 'classiera'),
				'default' => '2'
			),
			array(
				'id' => 'regular-ads-posting-limit',
				'type' => 'switch',
				'title' => __('Regular Ads Post Limit', 'classiera'),
				'subtitle' => __('Turn ON/OFF Limit for Regular Ads.', 'classiera'),
				'desc' => __('If you want to set limit for free ads posting, then you must turn ON this option.', 'classiera'),
				'default' => false,
            ),
			array(
				'id'=>'regular-ads-user-limit',
				'type' => 'text',
				'title' => __('How many Free Ads can a user post?', 'classiera'),
				'subtitle' => __('Regular Ads Limit', 'classiera'),
				'desc' => __('Enter a value for the Regular Ads. How many Free Ads do you allow regular users to be able to post? Example: "2"', 'classiera'),
				'default' => '2'
			),
		)
    ) );
	/*==========================
	Classiera: Bump up Ads
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Bump Ads', 'classiera' ),
        'id'               => 'bumpads',
		'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-arrow-up',
		'desc' => __('You need a WooCommerce Product ID here. First, you need to create a product named “Bump Ad” and set its price, then enter the product ID here.', 'classiera'),
		'fields'     => array(
			array(
				'id'=>'classiera_bump_ad_woo_id',
				'type' => 'text',
				'title' => __('Product ID', 'classiera'),
				'subtitle' => __('WooCommerece Product ID', 'classiera'),
				'desc' => __('Copy the Product ID from WooCommerce Products and paste it here.', 'classiera'),
				'default' => ''
			),
		)
    ) );
	/*==========================
	Classiera: Single Ads
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Single Ad', 'classiera' ),
        'id'               => 'postads',
        'customizer_width' => '500px',
        'icon'             => 'el el-pencil',
		'desc'  => __( 'Some settings which will work on single ad pages.', 'classiera' ),
		'fields'     => array(
			
			array(
				'id' => 'related-ads-on',
				'type' => 'switch',
				'title' => __('Related Ads On Single Post', 'classiera'),
				'subtitle' => __('Related Ads On Single Post', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_related_ads_count',
				'type' => 'text',
				'title' => __('Related Ads Count', 'classiera'),
				'subtitle' => __('Put Number', 'classiera'),
				'desc' => __('How many related ads do you want to be shown on a single post page?', 'classiera'),
				'default' => '12'
			),
			array(
				'id' => 'classiera_related_ads_autoplay',
				'type' => 'switch',
				'title' => __('Auto Play Related Ads', 'classiera'),
				'desc' => __('Manage auto play for related ads on a single ad page', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_sing_post_comments',
				'type' => 'switch',
				'title' => __('Comments section on a single ad', 'classiera'),
				'subtitle' => __('Comments section ON/OFF', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_author_contact_info',
				'type' => 'switch',
				'title' => __('Author Contact info', 'classiera'),
				'subtitle' => __('Contact info ON/OFF', 'classiera'),
				'desc' => __('If you want to hide complete author contact info then turn off this option.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_author_contact_email',
				'type' => 'switch',
				'title' => __('Author contact email', 'classiera'),
				'subtitle' => __('Contact email ON/OFF', 'classiera'),
				'desc' => __('If you want to hide author email from single ad details page then turn off this option.', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_bid_system',
				'type' => 'switch',
				'title' => __('Bid system', 'classiera'),
				'subtitle' => __('Bid option ON/OFF', 'classiera'),
				'desc' => __('If you don&rsquo;t want to allow bidding, then turn OFF this option.', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'classiera_report_ad',
				'type' => 'switch',
				'title' => __('Report / Watch Later', 'classiera'),
				'subtitle' => __('Turn ON/OFF Report Ad and Watch Later', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'author-msg-box-off',
				'type' => 'switch',
				'title' => __('Author Message Box ON/OFF', 'classiera'),
				'subtitle' => __('Author Message box on ad detail page', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_map_post_location',
				'type' => 'radio',
				'title' => __('Select Google MAP Location', 'classiera'),
				'subtitle' => __('Where do you want to show the map?', 'classiera'),
				'desc' => __('Do you want to show the Map on the sidebar or after the description on a single ad page?', 'classiera'),
				'options' => array('sidebar' => 'Google Map in the sidebar', 'descarea' => 'Google Map in the description area'),
				'default' => 'sidebar'
			),
		)
    ) );
	/*==========================
	Classiera: Submit Ads - Edit Ads
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Submit Ads - Edit Ads', 'classiera' ),
        'id'               => 'classiera_submit_ad',
		'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-arrow-up',
		'desc' => __('From here you can manage your Submit Ad / Post Ad form.', 'classiera'),
		'fields'     => array(
			array(
				'id'=>'classiera_submit_cat_icon',
				'type' => 'radio',
				'title' => __('Category icons type', 'classiera'), 
				'subtitle' => __('Select a type for category icons', 'classiera'),
				'desc' => __('Do you prefer to show category icons using Font Awesome or do you have your own images?', 'classiera'),
				'options' => array(
					'awesome_icons' => 'Font Awesome Icons',
					'map_pin' => 'MAP pin icon',
					'cat_thumbnail' => 'Category thumbnail image',
				),
				'default' => 'map_pin'
			),
			array(
				'id' => 'post-options-on',
				'type' => 'switch',
				'title' => __('Post moderation', 'classiera'),
				'subtitle' => __('Post moderation', 'classiera'),
				'default' => 1,
			),
			array(
				'id' => 'post-options-edit-on',
				'type' => 'switch',
				'title' => __('Post moderation On every edit post', 'classiera'),
				'subtitle' => __('Post moderation On every edit post', 'classiera'),
				'default' => 1,
			),
			array(
				'id' => 'phoneon',
				'type' => 'switch',
				'title' => __('Phone number', 'classiera'),
				'subtitle' => __('Manage user phone number on the Post New Ad form', 'classiera'),
				'desc' => __('If you don&rsquo;t want users to be able to provide their phone numbers on Post New Ad forms, simply turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'post_whatsapp_on',
				'type' => 'switch',
				'title' => __('WhatsAPP number', 'classiera'),
				'subtitle' => __('WhatsAPP number on submit ad form', 'classiera'),
				'desc' => __('If you don&rsquo;t want users to be able to provide their WhatsAPP numbers on Post New Ad forms, simply turn this option OFF.', 'classiera'),
				'default' => true,
            ),
			array(
				'id' => 'email_on',
				'type' => 'switch',
				'title' => __('Email', 'classiera'),
				'subtitle' => __('Manage user email on the Post New Ad form', 'classiera'),
				'desc' => __('If you don&rsquo;t want users to be able to provide their email on Post New Ad forms, simply turn this option OFF.', 'classiera'),
				'default' => 1,
            ),			
			array(
				'id' => 'classiera_ads_type',
				'type' => 'switch',
				'title' => __('Ads Type', 'classiera'),
				'subtitle' => __('Turn ON/OFF ads type', 'classiera'),
				'desc' => __('Ad types: Buy, Sell, Rent, Hire (as below)', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_ads_type_show',
				'type' => 'checkbox',
				'title' => __('Which ad types do you want to use?', 'classiera'),
				'desc' => __('Here you need to select which ad types you want to be shown (Buy, Sell, Rent, Hire, etc.)', 'classiera'),
				'options' => array(
					'1' => __('I want to sell', 'classiera'),
					'2' => __('I want to buy', 'classiera'),
					'3' => __('I want to rent', 'classiera'),
					'4' => __('I want to hire', 'classiera'),
					'5' => __('Lost and found', 'classiera'),
					'6' => __('I give for free.', 'classiera'),
					'7' => __('I am an event', 'classiera'),
					'8' => __('Professional service', 'classiera'),
					'9' => __('Exchange', 'classiera'),
				),
				'default' => array(
					'1' => '1',
					'2' => '1',
					'3' => '1',
					'4' => '1',
					'5' => '1',
					'6' => '1',
					'7' => '1',
					'8' => '1',
					'9' => '1',
				),
			),
			array(
				'id' => 'adpost-condition',
				'type' => 'switch',
				'title' => __('Item Condition', 'classiera'),
				'subtitle' => __('Turn ON/OFF item condition in ad posts', 'classiera'),
				'desc' => __('If you don&rsquo;t want to include item condition option on Submit Ad Page, then turn this OFF here.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_post_web_url',
				'type' => 'switch',
				'title' => __('Website URL', 'classiera'),
				'subtitle' => __('Turn ON/OFF URL on Ad Posts', 'classiera'),
				'desc' => __('If you don&rsquo;t want to allow URL option in ads, then turn it OFF here.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_locations_input',
				'type' => 'radio',
				'title' => __('How locations are shown on Submit Ad Page?', 'classiera'), 
				'subtitle' => __('Select option', 'classiera'),
				'desc' => __('<strong>Must read!</strong> Do you want users to see dropdowns or input fields for states and cities? If you select input, user will have to type in states and cities. If you select dropdown, then locations you have added from backend will be shown in the dropdown.', 'classiera'),
				'options' => array('dropdown' => 'DropDown', 'input' => 'Input'),//Must provide key => value pairs for radio options
				'default' => 'dropdown'
			),
			array(
				'id' => 'location_states_on',
				'type' => 'switch',
				'title' => __('State locations ON/OFF', 'classiera'),
				'subtitle' => __('Locations States On/OFF', 'classiera'),
				'desc' => __('This option will only work when the City location below is turned OFF.', 'classiera'),
				'default' => 1,
            ),			
			array(
				'id' => 'location_city_on',
				'type' => 'switch',
				'title' => __('City locations ON/OFF', 'classiera'),
				'subtitle' => __('Locations City On/OFF', 'classiera'),
				'desc' => __('If you don&rsquo;t want to allow city locations, then turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_address_field_on',
				'type' => 'switch',
				'title' => __('Address Field ON/OFF', 'classiera'),
				'subtitle' => __('Address Field ON/OFF', 'classiera'),
				'desc' => __('If you don&rsquo;t want to allow Address Field then turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'google-lat-long',
				'type' => 'switch',
				'title' => __('Latitude and Longitude', 'classiera'),
				'subtitle' => __('Turn ON/OFF Latitude and Longitude in Ad Posts', 'classiera'),
				'desc' => __('If you don&rsquo;t want users to put Latitude and Longitude while posting ads, then just turn OFF this option.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'google-map-adpost',
				'type' => 'switch',
				'title' => __('Google Map on Ad Posts', 'classiera'),
				'subtitle' => __('Turn ON/OFF Google Map in Ad Posts', 'classiera'),
				'desc' => __('If you want to hide Google Map from Submit Ad Page and Single Ad Page, then turn OFF this option.', 'classiera'),
				'default' => 1,
            ),			
			array(
				'id' => 'classiera_ad_location_remove',
				'type' => 'switch',
				'title' => __('Ad Location Section', 'classiera'),
				'subtitle' => __('Ad Location ON/OFF', 'classiera'),
				'desc' => __('If you want to remove Ad Locations section completely, then turn OFF this option. It will remove Country, State, City, Address, Google Latitude, Google Longitude and Google MAP Option.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_video_postads',
				'type' => 'switch',
				'title' => __('Video Box on Post New Ad Page', 'classiera'),
				'subtitle' => __('Turn ON/OFF Video Box on Post New Ad Page', 'classiera'),
				'desc' => __('If you dont want to allow users to add video iframe or link in ads then just turn off this option', 'classiera'),
				'default' => 1,
            ),			
			array(
				'id' => 'regularpriceon',
				'type' => 'switch',
				'title' => __('Regular Price tab on Post New Ad Page', 'classiera'),
				'subtitle' => __('Turn ON/OFF', 'classiera'),
				'default' => 1,
            ),
			array(
				'id' => 'classiera_sale_price_off',
				'type' => 'switch',
				'title' => __('Price section', 'classiera'),
				'subtitle' => __('Price field on Post New Ad Page', 'classiera'),
				'desc' => __('If you want to hide the price section completely, then please turn this option OFF.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_multi_currency',
				'type' => 'button_set',
				'title' => __('Select Currency', 'classiera'),
				'subtitle' => __('Ads Posts', 'classiera'),
				'options' => array('multi' => 'Multi Currency', 'single' => 'Single Currency'),
				'desc' => __('If you run your website only in one country, then select Single Currency. If you select Multi Currency, then on Post New Ad Page there will be a dropdown from where user will be able to select currency tag.', 'classiera'),
				'default' =>'multi',
			),
			array(
				'id'=>'classiera_multi_currency_default',
				'type' => 'select',
				'title' => __('Currency Tag', 'classiera'),
				'subtitle' => __('Currency Tag', 'classiera'),
				'desc' => __('Select currency and it will be set as default in the currency dropdown field on Post New Ad Page.', 'classiera'),
				'options' => array(
					'USD' => 'US Dollar', 
					'CAD' => 'Canadian Dollar',
					'EUR' => 'Euro',
					'AED' =>'United Arab Emirates Dirham',
					'AFN' => 'Afghan Afghani',
					'ALL' => 'Albanian Lek',
					'AMD' => 'Armenian Dram',
					'ARS' => 'Argentine Peso',
					'AUD' => 'Australian Dollar',
					'AZN' => 'Azerbaijani Manat',
					'BTC' => 'Bitcoin',
					'BDT' => 'Bangladeshi Taka',
					'BGN' => 'Bulgarian Lev',
					'BHD' => 'Bahraini Dinar',
					'BND' => 'Brunei Dollar',
					'BOB' => 'Bolivian Boliviano',
					'BRL' => 'Brazilian Real',
					'BWP' => 'Botswanan Pula',
					'BYN' => 'Belarusian Ruble',
					'BZD' => 'Belize Dollar',
					'CHF' => 'Swiss Franc',
					'CLP' => 'Chilean Peso',
					'CNY' => 'Chinese Yuan',
					'COP' => 'Colombian Peso',
					'CRC' => 'Costa Rican Colón',
					'CVE' => 'Cape Verdean Escudo',
					'CZK' => 'Czech Republic Koruna',
					'DJF' => 'Djiboutian Franc',
					'DKK' => 'Danish Krone',
					'DOP' => 'Dominican Peso',
					'DZD' => 'Algerian Dinar',
					'EGP' => 'Egyptian Pound',
					'ERN' => 'Eritrean Nakfa',
					'ETB' => 'Ethiopian Birr',
					'GBP' => 'British Pound',
					'‎GEL' => 'Georgian Lari',
					'GHS' => 'Ghanaian Cedi',
					'GTQ' => 'Guatemalan Quetzal',
					'GMB' => 'Gambia Dalasi',
					'HKD' => 'Hong Kong Dollar',
					'HNL' => 'Honduran Lempira',
					'HRK' => 'Croatian Kuna',
					'HUF' => 'Hungarian Forint',
					'IDR' => 'Indonesian Rupiah',
					'ILS' => 'Israeli SheKel',
					'INR' => 'Indian Rupee',
					'IQD' => 'Iraqi Dinar',
					'IRR' => 'Iranian Rial',
					'ISK' => 'Icelandic Króna',
					'JMD' => 'Jamaican Dollar',
					'JOD' => 'Jordanian Dinar',
					'JPY' => 'Japanese Yen',
					'KES' => 'Kenyan Shilling',
					'KHR' => 'Cambodian Riel',
					'KMF' => 'Comorian Franc',
					'KRW' => 'South Korean Won',
					'KWD' => 'Kuwaiti Dinar',
					'KZT' => 'Kazakhstani Tenge',
					'KM' => 'Konvertibilna Marka',
					'LBP' => 'Lebanese Pound',
					'LKR' => 'Sri Lankan Rupee',
					'LTL' => 'Lithuanian Litas',
					'LVL' => 'Latvian Lats',
					'LYD' => 'Libyan Dinar',
					'MAD' => 'Moroccan Dirham',
					'MDL' => 'Moldovan Leu',
					'MGA' => 'Malagasy Ariary',
					'MKD' => 'Macedonian Denar',
					'MMK' => 'Myanma Kyat',
					'HKD' => 'Macanese Pataca',
					'MUR' => 'Mauritian Rupee',
					'MXN' => 'Mexican Peso',
					'MYR' => 'Malaysian Ringgit',
					'MZN' => 'Mozambican Metical',
					'NAD' => 'Namibian Dollar',
					'NGN' => 'Nigerian Naira',
					'NIO' => 'Nicaraguan Córdoba',
					'NOK' => 'Norwegian Krone',
					'NPR' => 'Nepalese Rupee',
					'NZD' => 'New Zealand Dollar',
					'OMR' => 'Omani Rial',
					'‎PAB' => 'Panamanian Balboa',
					'PEN' => 'Peruvian Nuevo Sol',
					'PHP' => 'Philippine Peso',
					'PKR' => 'Pakistani Rupee',
					'PLN' => 'Polish Zloty',
					'PYG' => 'Paraguayan Guarani',
					'QAR' => 'Qatari Rial',
					'RON' => 'Romanian Leu',
					'RSD' => 'Serbian Dinar',
					'RUB' => 'Russian Ruble',
					'RWF' => 'Rwandan Franc',
					'SAR' => 'Saudi Riyal',
					'SDG' => 'Sudanese Pound',
					'SEK' => 'Swedish Krona',
					'SGD' => 'Singapore Dollar',
					'SOS' => 'Somali Shilling',
					'SYP' => 'Syrian Pound',
					'LE' => 'Sierra Leone',
					'THB' => 'Thai Baht',
					'TND' => 'Tunisian Dinar',
					'TOP' => 'Tongan Paʻanga',
					'TRY' => 'Turkish Lira',
					'TTD' => 'Trinidad and Tobago Dollar',
					'TWD' => 'New Taiwan Dollar',
					'UAH' => 'Ukrainian Hryvnia',
					'UGX' => 'Ugandan Shilling',
					'UYU' => 'Uruguayan Peso',
					'UZS' => 'Uzbekistan Som',
					'VEF' => 'Venezuelan Bolívar',
					'VND' => 'Vietnamese Dong',
					'YER' => 'Yemeni Rial',
					'ZAR' => 'South African Rand',
					'FCFA' => 'CFA Franc BEAC',
					'TZS' => 'Tanzanian Shillings',
					'SRD' => 'Surinamese dollar',
					'ZMK' => 'Zambian Kwacha'),
				'default' => 'USD',
				'required' => array( 'classiera_multi_currency', '=', 'multi' )
			),
			array(
				'id'=>'classierapostcurrency',
				'type' => 'text',
				'title' => __('Currency Tag', 'classiera'),
				'subtitle' => __('Currency Tag', 'classiera'),
				'desc' => __('Put Your Own Currency Symbol or HTML code to display', 'classiera'),
				'default' => '$',
				'required' => array( 'classiera_multi_currency', '=', 'single' )
			),
			array(
				'id'=>'classiera_currency_left_right',
				'type' => 'radio',
				'title' => __('Currency Tag Display', 'classiera'), 
				'subtitle' => __('Select option', 'classiera'),
				'desc' => __('Do you want the currency tag to be placed on the left or right of the ad price?', 'classiera'),
				'options' => array('left' => 'Left', 'right' => 'Right'),//Must provide key => value pairs for radio options
				'default' => 'left'
			),
			array(
				'id'=>'classiera_categories_noprice',
				'type' => 'select',
				'data' => 'categories',
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
				),
				'multi'    => true,				
				'title' => __('Select Categories to hide price from', 'classiera'), 
				'subtitle' => __('Hide Price from selected categories', 'classiera'),
				'desc' => __('Please select ad categories you wish to exclude the price section from. Then, the price section will be hidden from ads in these categories.', 'classiera'),
				'default' => '',
			),
			array(
				'id'=>'classiera_exclude_categories',
				'type' => 'select',
				'data' => 'categories',
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
				),
				'multi'    => true,				
				'title' => __('Select Categories to hide from users', 'classiera'), 
				'subtitle' => __('These categories will be hide from front-end', 'classiera'),
				'desc' => __('Please select ad categories you wish to hide from normal user from front-end ad posting.', 'classiera'),
				'default' => '',
			),
			array(
				'id'=>'classiera_exclude_user',
				'type' => 'select',
				'multi' => true,
				'title' => __('Select user roles', 'classiera'),
				'subtitle' => __('Hide categories from', 'classiera'),
				'desc' => __('Select user roles from where you want restrict posting ads from above categories.', 'classiera'),
				'options' => array(
					'editor' => __('Editor', 'classiera'),
					'author' => __('Author', 'classiera'),
					'contributor' => __('Contributor', 'classiera'),
					'subscriber' => __('Subscriber', 'classiera'),
				),
				'default' => array('contributor', 'subscriber'),
			),
			array(
				'id'=>'classiera_image_size',
				'type' => 'text',
				'title' => __('Image Size', 'classiera'),
				'subtitle' => __('Enter value in MB', 'classiera'),
				'desc' => __('Here you can enter image size limit in MB, Be careful 1MB = 100KB', 'classiera'),
				'default' => '1'
			),
		)
    ) ); 
	/*==========================
	Classiera: Color Selection
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Color Selection', 'classiera' ),
        'id'    => 'color',
        'desc'  => __( 'Color Selection', 'classiera' ),
        'icon'  => 'el el-brush',
		'fields' => array(
			array(
				'id'       => 'color-primary',
				'type'     => 'color',
				'title'    => __('Primary Color', 'classiera'), 
				'subtitle' => __('Pick the Primary Color. Default: #e96969.', 'classiera'),
				'default'  => '#b6d91a',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'color-secondary',
				'type'     => 'color',
				'title'    => __('Secondary Color', 'classiera'), 
				'subtitle' => __('Pick the Secondary Color. Default: #232323.', 'classiera'),
				'default'  => '#232323',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_topbar_bg',
				'type'     => 'color',
				'title'    => __('Topbar Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for the Topbar Background. Default: #444444.', 'classiera'),
				'default'  => '#444444',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_topbar_txt',
				'type'     => 'color',
				'title'    => __('Topbar Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for topbar text default: #aaaaaa.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_navbar_color',
				'type'     => 'color',
				'title'    => __('Navbar Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for Navbar Background default: #fafafa.', 'classiera'),
				'default'  => '#fafafa',
				'validate' => 'color',
				'transparent' => true,
			),
			array(
				'id'       => 'classiera_pages_navbar_color',
				'type'     => 'color',
				'title'    => __('Navbar Pages Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for Navbar Background default: #143139.', 'classiera'),
				'desc' => __('Background color for all pages other than the homepage. This color option will only work on Nav Style Version 6 and 7.', 'classiera'),
				'default'  => '#143139',
				'validate' => 'color',
				'transparent' => true,
			),
			array(
				'id'       => 'classiera_navbar_text_color',
				'type'     => 'color',
				'title'    => __('Navbar Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for Navbar Text default: #444444.', 'classiera'),
				'default'  => '#444444',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_submit_btn',
				'type'     => 'link_color',
				'title'    => __('Submit button', 'classiera'), 
				'subtitle' => __('Pick color for submit button on header', 'classiera'),
				'default'  => '#444444',
				'validate' => 'color',
				'default'  => array(
					'regular' => '#ffffff',
					'hover' => '#ffffff',
					'active' => false,
				),
			),
			array(
				'id'       => 'classiera_featured_color',
				'type'     => 'color',
				'title'    => __('Featured Tag', 'classiera'), 
				'subtitle' => __('Pick a color for featured tag default: #017fb1.', 'classiera'),
				'default'  => '#017fb1',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_featured_border_color',
				'type'     => 'color',
				'title'    => __('Featured Tag Border', 'classiera'), 
				'subtitle' => __('Pick a color for featured tag border default: #03b0f4.', 'classiera'),
				'default'  => '#03b0f4',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_postv6_gradient',
				'type'     => 'color_gradient',
				'title'    => __('Post style v6/v7 gradient', 'classiera'), 
				'subtitle' => __('Pick a color for post style v6/v7', 'classiera'),
				'validate' => 'color',
				'transparent' => false,
				'default'  => array(
					'from' => '#ffffff',
					'to' => '#143139',
				),
			),
			array(
				'id'       => 'classiera_footer_bg',
				'type'     => 'color',
				'title'    => __('Footer Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer Background default: #232323.', 'classiera'),
				'default'  => '#232323',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_heading',
				'type'     => 'color',
				'title'    => __('Footer Heading Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer Heading text default: #232323.', 'classiera'),
				'default'  => '#232323',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_tags_bg',
				'type'     => 'color',
				'title'    => __('Footer Tags Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer tags Background default: #444444.', 'classiera'),
				'default'  => '#444444',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_tags_txt',
				'type'     => 'color',
				'title'    => __('Footer Tags Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer tags Text default: #ffffff.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_tags_txt_hover',
				'type'     => 'color',
				'title'    => __('Footer Tags Hover Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for the Footer Tags Text on Hover. Default: #ffffff.', 'classiera'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_txt',
				'type'     => 'color',
				'title'    => __('Footer text widget Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer text widget Text default: #aaaaaa.', 'classiera'),
				'default'  => '#aaaaaa',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_bottom_bg',
				'type'     => 'color',
				'title'    => __('Footer Bottom Background Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer Bottom Background default: #444444.', 'classiera'),
				'default'  => '#444444',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'classiera_footer_bottom_txt',
				'type'     => 'color',
				'title'    => __('Footer Bottom Text Color', 'classiera'), 
				'subtitle' => __('Pick a color for Footer Bottom text default: #8e8e8e.', 'classiera'),
				'default'  => '#8e8e8e',
				'validate' => 'color',
				'transparent' => false,
			),
		)
    ) );
	/*==========================
	Classiera: Social Links
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Social Links', 'classiera' ),
        'id'    => 'social-links',
        'desc'  => __( 'Enter Social Links', 'classiera' ),
        'icon'  => 'el el-glasses',
		'fields' => array(
			array(
				'id'=>'facebook-link',
				'type' => 'text',
				'title' => __('Facebook Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Facebook Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'twitter-link',
				'type' => 'text',
				'title' => __('Twitter Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Twitter Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'dribbble-link',
				'type' => 'text',
				'title' => __('Dribbble Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Dribbble Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'flickr-link',
				'type' => 'text',
				'title' => __('Flickr Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Flickr Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'github-link',
				'type' => 'text',
				'title' => __('Github Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Github Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'pinterest-link',
				'type' => 'text',
				'title' => __('Pinterest Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Pinterest Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'youtube-link',
				'type' => 'text',
				'title' => __('YouTube Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('YouTube Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'google-plus-link',
				'type' => 'text',
				'title' => __('Google+ Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Google+ Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'linkedin-link',
				'type' => 'text',
				'title' => __('LinkedIn Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('LinkedIn Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'instagram-link',
				'type' => 'text',
				'title' => __('Instagram Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Instagram Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'vimeo-link',
				'type' => 'text',
				'title' => __('Vimeo Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('Vimeo Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),	
			array(
				'id'=>'vk-link',
				'type' => 'text',
				'title' => __('VK Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('VK Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'odnoklassniki-link',
				'type' => 'text',
				'title' => __('Odnoklassniki Page URL', 'classiera'),
				'subtitle' => __('This must be a URL.', 'classiera'),
				'desc' => __('OK Page URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
		)
    ) );
	/*==========================
	Classiera: Advertisement
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Advertisement', 'classiera' ),
        'id'    => 'advertisement',
        'desc'  => __( 'Advertisement Section. If you want to add banner ads, please upload your banner and enter a website URL below. But if you want to add Google Ads, then the banner image fields must be left empty.', 'classiera' ),
        'icon'  => 'el el-picture',
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Homepage sponsored ads', 'classiera' ),
        'id'               => 'home-page-ads',
		'icon'             => 'el el-home-alt',
		'subsection' => true,
        'customizer_width' => '500px',        
		'desc'=> __('Include sponsored ads on the homepage.', 'classiera'),
        'fields'           => array( 
			array(
				'id'=>'home_ad1',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Homepage First Banner Ad', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your banner ad.', 'classiera'),
				'subtitle' => __('Banner Ad', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'home_ad1_url',
				'type' => 'text',
				'title' => __('Homepage First Banner Ad URL', 'classiera'),
				'subtitle' => __('Link URL', 'classiera'),
				'desc' => __('Add a URL here so that a user will be redirected to that URL after clicking on the banner ad.', 'classiera'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'home_html_ad',
				'type' => 'textarea',
				'title' => __('HTML Ads Or Google Ads', 'classiera'),
				'subtitle' => __('HTML ads for the homepage', 'classiera'),
				'desc' => __('Paste your HTML or Google Ads code for the First Banner here.', 'classiera'),
				'default' => ''
			),
			array(
				'id'=>'classiera_home_banner_2',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Homepage Second Banner Ad', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your banner ad.', 'classiera'),
				'subtitle' => __('Banner Ad', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'classiera_home_banner_2_url',
				'type' => 'text',
				'title' => __('Homepage Second Banner Ad URL', 'classiera'),
				'subtitle' => __('Link URL', 'classiera'),
				'desc' => __('Add a URL here so that a user will be redirected to that URL after clicking on the banner ad.', 'classiera'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'classiera_home_banner_2_html',
				'type' => 'textarea',
				'title' => __('HTML Ads Or Google Ads', 'classiera'),
				'subtitle' => __('HTML ads for the homepage', 'classiera'),
				'desc' => __('Paste your HTML or Google Ads code for the Second Banner here.', 'classiera'),
				'default' => ''
			),
			array(
				'id'=>'classiera_home_banner_3',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Homepage Third Banner Ad', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your banner ad.', 'classiera'),
				'subtitle' => __('Banner Ad', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'classiera_home_banner_3_url',
				'type' => 'text',
				'title' => __('Homepage Third Banner Ad URL', 'classiera'),
				'subtitle' => __('Link URL', 'classiera'),
				'desc' => __('Add a URL here so that a user will be redirected to that URL after clicking on the banner ad.', 'classiera'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'classiera_home_banner_3_html',
				'type' => 'textarea',
				'title' => __('HTML Ads Or Google Ads', 'classiera'),
				'subtitle' => __('HTML ads for the homepage', 'classiera'),
				'desc' => __('Paste your HTML or Google Ads code for the Third Banner here.', 'classiera'),
				'default' => ''
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Other Ads', 'classiera' ),
        'id'         => 'advertisement-other',
		'desc'  => __( 'If you want to add banner ads, please upload your banner and enter a website URL below. But if you want to add Google Ads, then the banner image fields must be left empty.', 'classiera' ),
		'icon'  => 'el el-picture',
        'subsection' => true,
        'fields'     => array(
			array(
				'id'=>'home_ad2',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Single Post Banner Ad', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your banner ad.', 'classiera'),
				'subtitle' => __('Single Post Page Ad img', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'home_ad2_url',
				'type' => 'text',
				'title' => __('Single Post Banner Ad URL', 'classiera'),
				'subtitle' => __('Single Post Ad link URL', 'classiera'),
				'desc' => __('Add a URL here so that a user will be redirected to that URL after clicking on the banner ad.', 'classiera'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'home_html_ad2',
				'type' => 'textarea',
				'title' => __('HTML Ads Or Google Ads for Single Post', 'classiera'),
				'subtitle' => __('Google ads', 'classiera'),
				'desc' => __('Paste your HTML or Google Ads code here.', 'classiera'),
				'default' => ''
			),	
			array(
				'id'=>'post_ad',
				'type' => 'media', 
				'url'=> true,
				'title' => __(' Location & Category Page Ad', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your banner ad.', 'classiera'),
				'subtitle' => __('Upload your banner ad', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'post_ad_url',
				'type' => 'text',
				'title' => __('Location & Category Page Ad URL', 'classiera'),
				'subtitle' => __('Ad link URL', 'classiera'),
				'desc' => __('You can add URL.', 'classiera'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'post_ad_code_html',
				'type' => 'textarea',
				'title' => __('HTML or Google ads (Location & category page)', 'classiera'),
				'subtitle' => __('Google ads', 'classiera'),
				'desc' => __('Paste your HTML or Google Ads code here.', 'classiera'),
				'default' => ''
			),
        )
    ) );
	/*==========================
	Classiera: Partners
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Partners', 'classiera' ),
        'id'    => 'partners',
        'desc'  => __( 'Upload Partners Logos', 'classiera' ),
        'icon'  => 'el el-group',
		'fields' => array(
			array(
				'id' => 'partners-on',
				'type' => 'switch',
				'title' => __('Partners Slider', 'classiera'),
				'subtitle' => __('Turn On/OFF', 'classiera'),
				'desc' => __('This setting will only work for pages other than the homepage. If you want to turn the Partners Slider OFF on the homepage, then visit Home Layout Manager under the Layout Manager tab.', 'classiera'),
				'default' => 1,
            ),
			array(
				'id'=>'classiera_partners_style',
				'type' => 'radio',
				'title' => __('Partners Styles', 'classiera'), 
				'subtitle' => __('Select Styles', 'classiera'),
				'desc' => __('Selection will work on all pages other than the homepage, on homepage Design will be used from template', 'classiera'),
				'options' => array('1' => 'Version 1', '2' => 'Version 2', '3' => 'Version 3', '4' => 'Version 4', '5' => 'Version 5', '6' => 'Version 6'),//Must provide key => value pairs for radio options
				'default' => '1'
			),
			array(
				'id'=>'classiera_partners_title',
				'type' => 'text',
				'title' => __('Partner Title', 'classiera'),
				'subtitle' => __('Partner Title', 'classiera'),
				'desc' => __('Partner Sections Title.', 'classiera'),
				'default' => 'See Our Featured Members'
			),
			array(
				'id'=>'classiera_partners_desc',
				'type' => 'text',
				'title' => __('Partner Description', 'classiera'),
				'subtitle' => __('Partner Description', 'classiera'),
				'desc' => __('Replace the example description with your own.', 'classiera'),
				'default' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.'
			),
			array(
				'id'=>'partner1',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner One', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner1-url',
				'type' => 'text',
				'title' => __('Partner One URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner One URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'partner2',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner two', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner2-url',
				'type' => 'text',
				'title' => __('Partner two URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner two URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),	
			array(
				'id'=>'partner3',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner three', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner3-url',
				'type' => 'text',
				'title' => __('Partner three URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner three URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'partner4',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner four', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner4-url',
				'type' => 'text',
				'title' => __('Partner four URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner four URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),	
			array(
				'id'=>'partner5',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner five', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner5-url',
				'type' => 'text',
				'title' => __('Partner five URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner five URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),	
			array(
				'id'=>'partner6',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner six', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner6-url',
				'type' => 'text',
				'title' => __('Partner six URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner six URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'partner7',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner seven', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner7-url',
				'type' => 'text',
				'title' => __('Partner seven URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner seven URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'partner8',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Partner eight', 'classiera'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'classiera'),
				'subtitle' => __('Upload your logo', 'classiera'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'partner8-url',
				'type' => 'text',
				'title' => __('Partner eight URL', 'classiera'),
				'subtitle' => __('This must be an URL.', 'classiera'),
				'desc' => __('Partner eight URL', 'classiera'),
				'validate' => 'url',
				'default' => ''
			),
		)
    ) ); 
	/*==========================
	Classiera: Fonts
	===========================*/
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Fonts', 'classiera' ),
        'id'     => 'Fonts',
        'desc' => __('Select Fonts for your Website', 'classiera'),
        'icon'   => 'el el-font',
        'fields' => array(           
            array(
            'id' => 'heading1-font',
            'type' => 'typography',
            'title' => __('H1 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h1, h1 a'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '36px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '36px',
                ),
         	),

		array(
            'id' => 'heading2-font',
            'type' => 'typography',
            'title' => __('H2 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h2, h2 a, h2 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '30px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '30px',
                ),
         	),

		array(
            'id' => 'heading3-font',
            'type' => 'typography',
            'title' => __('H3 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h3, h3 a, h3 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '24px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '24px',
                ),
         	),

		array(
            'id' => 'heading4-font',
            'type' => 'typography',
            'title' => __('H4 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h4, h4 a, h4 span'),
            'default' => array(
				'color' => '#232323',
                'font-size' => '18px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '18px',
                ),
         	),

		array(
            'id' => 'heading5-font',
            'type' => 'typography',
            'title' => __('H5 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h5, h5 a, h5 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '14px',
                'font-family' => 'ubuntu',
                'font-weight' => '600',
                'line-height' => '24px',
                ),
         	),

		array(
            'id' => 'heading6-font',
            'type' => 'typography',
            'title' => __('H6 Font', 'classiera'),
            'subtitle' => __('Specify the heading font properties.', 'classiera'),
            'google' => true,
            'output' => array('h6, h6 a, h6 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '12px',
                'font-family' => 'ubuntu',
                'font-weight' => '600',
                'line-height' => '24px',
                ),
         	),

		array(
            'id' => 'body-font',
            'type' => 'typography',
            'title' => __('Body Font', 'classiera'),
            'subtitle' => __('Specify the body font properties.', 'classiera'),
            'google' => true,
            'output' => array('html, body, div, applet, object, iframe p, blockquote, a, abbr, acronym, address, big, cite, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video, .submit-post form .form-group label, .submit-post form .form-group .form-control, .help-block'),
            'default' => array(
                'color' => '#6c6c6c',
                'font-size' => '14px',
                'font-family' => 'Lato',
                'font-weight' => 'Normal',
                'line-height' => '24px',
                'visibility' => 'inherit',
                ),
         	),
        )
    ) ); 
	/*==========================
	Classiera: Google Settings
	===========================*/
	Redux::setSection( $opt_name, array(
        'title' => __( 'Google Settings', 'classiera' ),
        'icon'  => 'el el-map-marker',
        'id'    => 'google-map',
        'desc'  => __( 'Google Settings', 'classiera' ),        
        'fields' => array(
			array(
				'id'=>'classiera_map_post_type',
				'type' => 'radio',
				'title' => __('Select Ads type', 'classiera'),
				'subtitle' => __('Which ads do you want to show?', 'classiera'),
				'desc' => __('Which type of ads do you want to show on Google Map on the homepage? On the search result page all ads will be displayed.', 'classiera'),
				'options' => array('featured' => 'Featured / Premium', 'all' => 'All Ads (Regular & Premium)'),
				'default' => 'all'
			),
			array(
				'id'=>'classiera_map_post_count',
				'type' => 'text',
				'title' => __('How many ads?', 'classiera'),
				'subtitle' => __('Enter a number', 'classiera'),
				'desc' => __('How many ads do you want to show on Google Map (a map on the header)? On the search result page count will be shown from a search query.', 'classiera'),
				'default' => '12'
			),
			array(
				'id' => 'classiera_map_on_search',
				'type' => 'switch',
				'title' => __('Google MAP on the Search Page.', 'classiera'),
				'subtitle' => __('Turn the Map ON/OFF on the search result page.', 'classiera'),
				'desc' => __('If you don&rsquo;t wish to display the Google Map on the search result page, then turn this option OFF.', 'classiera'),
				'default' => true,
			),
			array(
				'id' => 'classiera_map_on_category',
				'type' => 'switch',
				'title' => __('Google Map on the Category Page', 'classiera'),
				'subtitle' => __('Turn the Map ON/OFF on the Category Page', 'classiera'),
				'desc' => __('If you don&rsquo;t wish to display the Google Map on the category page, then turn this option OFF.', 'classiera'),
				'default' => false,
			),
			array(
				'id' => 'classiera_map_dragging',
				'type' => 'switch',
				'title' => __('Google MAP dragging', 'classiera'),
				'subtitle' => __('Turn ON/OFF dragging the MAP', 'classiera'),
				'desc' => __('Here you can manage the dragging option on the Google Map.', 'classiera'),
				'default' => false,
			),
			array(
				'id' => 'classiera_map_scroll',
				'type' => 'switch',
				'title' => __('Google Map scroll wheel zoom.', 'classiera'),
				'subtitle' => __('Turn ON/OFF the scroll wheel zoom function on the MAP.', 'classiera'),
				'desc' => __('Here you can manage the scroll wheel zoom function on the Google Map.', 'classiera'),
				'default' => false,
			),
			array(
				'id'=>'classiera_google_api',
				'type' => 'text',
				'title' => __('Google API Key', 'classiera'),
				'subtitle' => __('Google API Key', 'classiera'),
				'desc' => __('Put your Google API key here to activate the Google Map. If you are not sure how to get an API key, please visit <a href="http://www.tthemes.com/get-google-api-key/" target="_blank">Google API Key</a>.', 'classiera'),
				'default' => ''
			),
			array(
				'id'=>'classiera_map_lang_code',
				'type' => 'text',
				'title' => __('Google MAP Language', 'classiera'),
				'subtitle' => __('Enter your language code', 'classiera'),
				'desc' => __('Google allow only a few languages in Maps. Please copy your language code and paste above. <a href="https://developers.google.com/maps/faq#languagesupport" target="_blank">Click here</a> for the language codes.', 'classiera'),
				'default' => 'en'
			),
			array(
				'id'=>'google_analytics',
				'type' => 'textarea',
				'title' => __('Google Analytics', 'classiera'),
				'subtitle' => __('Google Analytics Script Code', 'classiera'),
				'desc' => __('Get Analytics for your site. Enter your Google Analytics script code above.', 'classiera'),
				'default' => ''
			),
			array(
				'id'=>'classiera_header_code',
				'type' => 'textarea',
				'title' => __('Header Code', 'classiera'),
				'subtitle' => __('Any HTML or Script', 'classiera'),
				'desc' => __('Enter any HTML or script code above. It will be inserted in the head tag.', 'classiera'),
				'default' => ''
			),
			array(
				'id'=>'map-style',
				'type' => 'textarea',
				'title' => __('Map Styles', 'classiera'), 
				'subtitle' => __('Check <a href="http://snazzymaps.com/" target="_blank">snazzymaps.com</a> for a list of nice Google Map styles.', 'classiera'),
				'desc' => __('Paste your Google Map style above.', 'classiera'),
				'validate' => 'html_custom',
				'default' => '',
				'allowed_html' => array(
					'a' => array(
						'href' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array()
					)
			),
		)
    ) );
	/*==========================
	Classiera: Coming Soon Page
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Coming Soon Page', 'classiera' ),
        'id'    => 'coming-soon',
        'desc'  => __( 'Coming Soon Page Settings', 'classiera' ),
        'icon'  => 'el el-magic',
        'fields' => array(
			array(
			'id'=>'coming-soon-logo',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Coming Soon logo', 'classiera'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload Coming Soon template logo.', 'classiera'),
			'subtitle' => __('Upload Coming Soon template logo', 'classiera'),
			'default'=>array('url'=>''),
			),
			array(
			'id'=>'coming-soon-bg',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Coming Soon BG', 'classiera'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload Coming Soon template Background.', 'classiera'),
			'subtitle' => __('Coming Soon BG', 'classiera'),
			'default'=>array('url'=>''),
			),
			array(
			'id'=>'coming-soon-txt',
			'type' => 'textarea',
			'title' => __('Coming Soon Text', 'classiera'),
			'subtitle' => __('Coming Soon Text', 'classiera'),
			'desc' => __('Coming Soon Text', 'classiera'),
			'default' => 'We will be here soon with our new awesome site!'
			),
			array(
			'id'=>'coming-trns-days',
			'type' => 'text',
			'title' => __('Replace Days text', 'classiera'),
			'subtitle' => __('Days text', 'classiera'),
			'desc' => __('Days text', 'classiera'),
			'default' => 'Days'
			),
			array(
			'id'=>'coming-trns-hours',
			'type' => 'text',
			'title' => __('Replace Hours text', 'classiera'),
			'subtitle' => __('Hours text', 'classiera'),
			'desc' => __('Hours text', 'classiera'),
			'default' => 'Hours'
			),
			array(
			'id'=>'coming-trns-minutes',
			'type' => 'text',
			'title' => __('Replace Minutes text', 'classiera'),
			'subtitle' => __('Minutes text', 'classiera'),
			'desc' => __('Minutes text', 'classiera'),
			'default' => 'Minutes'
			),
			array(
			'id'=>'coming-trns-seconds',
			'type' => 'text',
			'title' => __('Replace Seconds text', 'classiera'),
			'subtitle' => __('Seconds text', 'classiera'),
			'desc' => __('Seconds text', 'classiera'),
			'default' => 'Seconds'
			),			
			array(
			'id'=>'coming-month',
			'type' => 'select',
			'title' => __('Month', 'classiera'), 
			'subtitle' => __('Select Month.', 'classiera'),
			'options' => array('1'=>'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May', '6'=>'June', '7'=>'July', '8'=>'August', '9'=>'September', '10'=>'October', '11'=>'November', '12'=>'December'),
			'default' => '6',
			),
			array(
			'id'=>'coming-days',
			'type' => 'select',
			'title' => __('Days', 'classiera'), 
			'subtitle' => __('Select Days.', 'classiera'),
			'options' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12', '13'=>'13', '14'=>'14', '15'=>'15', '16'=>'16', '17'=>'17', '18'=>'18', '19'=>'19', '20'=>'20', '21'=>'21', '22'=>'22', '23'=>'23', '24'=>'24', '25'=>'25', '26'=>'26', '27'=>'27', '28'=>'28', '29'=>'29', '30'=>'30', '31'=>'31'),
			'default' => '10',
			),
			array(
			'id'=>'coming-year',
			'type' => 'text',
			'title' => __('Year', 'classiera'),
			'subtitle' => __('Enter year example: 2016.', 'classiera'),
			'desc' => __('Year', 'classiera'),			
			'default' => '2017'
			),
			array(
			'id'=>'coming-copyright',
			'type' => 'text',
			'title' => __('Copyright Text', 'classiera'),
			'subtitle' => __('Copyright Text for Coming Soon Page.', 'classiera'),
			'desc' => __('Copyright Text', 'classiera'),			
			'default' => 'Copyright &copy; 2015 Classiera'
			),
       )
    ) );
	/*==========================
	Classiera: Contact Page
	===========================*/
    Redux::setSection( $opt_name, array(
        'title' => __( 'Contact Page', 'classiera' ),
        'icon'  => 'el el-envelope',
        'id'    => 'contact-page',
        'desc'  => __( 'Contact Page Settings', 'classiera' ),        
        'fields' => array(			
			array(
				'id' => 'contact-map',
				'type' => 'switch',
				'title' => __('Google Map on the Contact Page', 'classiera'),
				'subtitle' => __('Turn ON/OFF the Map on the Contact Page.', 'classiera'),
				'default' => 1,
			),
			array(
				'id' => 'classiera_display_email',
				'type' => 'switch',
				'title' => __('Contact Page email address', 'classiera'),
				'subtitle' => __('Turn ON/OFF the email address display on contact page.', 'classiera'),
				'default' => 1,
			),
			array(
				'id'=>'contact-email',
				'type' => 'text',
				'title' => __('Your email address', 'classiera'),
				'subtitle' => __('This must be an email address.', 'classiera'),
				'desc' => __('Your email address', 'classiera'),
				'validate' => 'email',
				'default' => ''
			),
			array(
				'id'=>'contact-email-error',
				'type' => 'text',
				'title' => __('Email error message', 'classiera'),
				'subtitle' => __('Email error message', 'classiera'),
				'desc' => __('Email error message', 'classiera'),
				'default' => 'You entered an invalid email.'
			),
			array(
				'id'=>'contact-name-error',
				'type' => 'text',
				'title' => __('Name error message', 'classiera'),
				'subtitle' => __('Name error message', 'classiera'),
				'desc' => __('Name error message', 'classiera'),
				'default' => 'You forgot to enter your name.'
			),
			array(
				'id'=>'contact-message-error',
				'type' => 'text',
				'title' => __('Message error', 'classiera'),
				'subtitle' => __('Message error', 'classiera'),
				'desc' => __('Message error', 'classiera'),
				'default' => 'You forgot to enter your message.'
			),
			array(
				'id'=>'contact-thankyou-message',
				'type' => 'text',
				'title' => __('Thank you message', 'classiera'),
				'subtitle' => __('Thank you message', 'classiera'),
				'desc' => __('Thank you message', 'classiera'),
				'default' => 'Thank you! We will get back to you as soon as possible.'
			),
			array(
				'id'=>'contact-latitude',
				'type' => 'text',
				'title' => __('Google Latitude', 'classiera'),
				'subtitle' => __('Google Latitude', 'classiera'),
				'desc' => __('Enter Google Latitude value of your address.', 'classiera'),
				'default' => '31.516370'
			),
			array(
				'id'=>'contact-longitude',
				'type' => 'text',
				'title' => __('Google Longitude', 'classiera'),
				'subtitle' => __('Google Longitude', 'classiera'),
				'desc' => __('Enter Google Longitude value of your address.', 'classiera'),
				'default' => '74.258727'
			),
			array(
				'id'=>'contact-zoom',
				'type' => 'text',
				'title' => __('MAP Zoom level', 'classiera'),
				'subtitle' => __('MAP Zoom level', 'classiera'),
				'desc' => __('Enter a value for Google Map zoom level.', 'classiera'),
				'default' => '16'
			),
			array(
				'id'=>'contact-radius',
				'type' => 'text',
				'title' => __('Radius on Google MAP', 'classiera'),
				'subtitle' => __('Radius value', 'classiera'),
				'desc' => __('Enter a value for the radius on Google MAP.', 'classiera'),
				'default' => '500'
			),
			array(
				'id'=>'contact-address',
				'type' => 'text',
				'title' => __('Contact Page Address', 'classiera'),
				'subtitle' => __('Contact Page Address', 'classiera'),
				'desc' => __('Contact Page Address', 'classiera'),
				'default' => 'Our business address is 1063 Freelon Street San Francisco, CA 95108'
			),	
			array(
				'id'=>'contact-phone',
				'type' => 'text',
				'title' => __('Contact Page Phone', 'classiera'),
				'subtitle' => __('Contact Page Phone', 'classiera'),
				'desc' => __('Contact Page Phone', 'classiera'),
				'default' => '021.343.7575'
			),	
			array(
				'id'=>'contact-phone2',
				'type' => 'text',
				'title' => __('Contact Page Phone Second', 'classiera'),
				'subtitle' => __('Contact Page Phone Second', 'classiera'),
				'desc' => __('Contact Page Phone Second', 'classiera'),
				'default' => '021.343.7576'
			),
		)
    ) );
    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'classiera' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
	/*==========================
	If Redux is running as a plugin, this will remove the demo notice and links
	===========================*/
	if( function_exists( 'remove_demo' ) ) {
		add_action( 'redux/loaded', 'remove_demo' );
	}
    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/classiera', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'classiera' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'classiera' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }