<?php 
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
 function classiera_register_required_plugins(){
 
    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
		 
		/*==========================
		Redux Framework
		===========================*/
        array(            
			'name' => esc_html__( 'Redux Framework', 'classiera' ),
            'slug' => 'redux-framework',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		/*==========================
		Classiera Helper
		===========================*/		
		array(            
			'name' => esc_html__( 'Classiera Helper', 'classiera' ),
            'slug' => 'classiera-helper',
            'required' => true,
            'version' => '2.0.12',
            'force_activation' => false,
            'force_deactivation' => false,
            'source' => 'https://s3.amazonaws.com/joinwebs/plugins/classiera-helper.zip',
        ),
		/*==========================
		Classiera Locations
		===========================*/		
		array(            
			'name' => esc_html__( 'Classiera Locations', 'classiera' ),
            'slug' => 'classiera-locations',
            'required' => true,
            'version' => '2.0.3',
            'force_activation' => false,
            'force_deactivation' => false,
            'source' => 'https://s3.amazonaws.com/joinwebs/plugins/classiera-locations.zip',
        ),
		/*==========================
		Classiera Demo Importer
		===========================*/		
		array(            
			'name' => esc_html__( 'Classiera demo importer', 'classiera' ),
            'slug' => 'classiera-demo-importer',
            'required' => true,
            'version' => '1.3',
            'force_activation' => false,
            'force_deactivation' => false,
            'source' => 'https://s3.amazonaws.com/joinwebs/plugins/classiera-demo-importer.zip',
        ),
		/*==========================
		LayerSlider
		===========================*/
		array(            
			'name' => esc_html__( 'LayerSlider', 'classiera' ),
            'slug' => 'LayerSlider',
            'required' => false,
            'version' => '6.9.2',
            'force_activation' => false,
            'force_deactivation' => false,
            'source' => 'https://s3.amazonaws.com/joinwebs/plugins/LayerSlider.zip',
        ),
		/*==========================
		WooCommerce
		===========================*/
        array(            
            'name' => esc_html__( 'WooCommerce', 'classiera' ),
            'slug' => 'woocommerce',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),	
		/*==========================
		AccessPress Social Login Lite
		===========================*/
        array(
            'name' => esc_html__( 'Social Login WordPress Plugin &ndash; AccessPress Social Login Lite', 'classiera' ),
            'slug' => 'accesspress-social-login-lite',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		/*==========================
		AccessPress Social Share
		===========================*/
		array(            
            'name' => esc_html__( 'Social Share WordPress Plugin &ndash; AccessPress Social Share', 'classiera' ),
            'slug' => 'accesspress-social-share',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		/*==========================
		Nextend Social Login
		===========================*/
		array(            
            'name' => esc_html__( 'Nextend Social Login and Register', 'classiera' ),
            'slug' => 'nextend-facebook-connect',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		/*==========================
		Google Captcha
		===========================*/
		array(           
            'name' => esc_html__( 'Google Captcha (reCAPTCHA) by BestWebSoft', 'classiera' ),
            'slug' => 'google-captcha',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
    );
	$config = array(
		'id'           => 'classiera',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	); 
    if ( function_exists( 'tgmpa' ) ){
		tgmpa( $plugins, $config );
	} 
}