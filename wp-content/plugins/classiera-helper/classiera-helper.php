<?php
/**
 * Plugin Name: Classiera Helper
 * Plugin URI: http://joinwebs.com/
 * Description: Classiera Custom Post Type for Pricing Plans And Blog Post.
 * Version: 2.0.12
 * Author: JoinWebs
 * Author URI: http://joinwebs.com/
 * Text Domain: classiera-helper
 * @package Classiera
**/
?>
<?php 
	define( 'CH_VERSION', '2.0.7' );
	define( 'CH_REQUIRED_WP_VERSION', '4.8' );
	define( 'CH_PLUGIN', __FILE__ );
	define( 'CH_PLUGIN_BASENAME', plugin_basename( CH_PLUGIN ) );
	define( 'CH_PLUGIN_NAME', trim( dirname( CH_PLUGIN_BASENAME ), '/' ) );
	define( 'WPCH_PLUGIN_DIR', untrailingslashit( dirname( CH_PLUGIN ) ) );
	define( 'WPCH_PLUGIN_INCLUDES_DIR', WPCH_PLUGIN_DIR . '/includes/' );
	define( 'WPCH_PLUGIN_JS_DIR', plugin_dir_url( __FILE__ ).'js/' );
	/*==========================
	Call Language
	===========================*/
	function classiera_helper_textdomain() { 		
		load_plugin_textdomain( 'classiera-helper', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'classiera_helper_textdomain' );
	/*==========================
	Load Scripts
	===========================*/
	if (!function_exists('classiera_helper_scripts')) {
		function classiera_helper_scripts(){
			wp_enqueue_script('classiera-helper', WPCH_PLUGIN_JS_DIR . 'classiera-helper.js', 'jquery', '', true);
			/*==========================
			Define Global Variables
			===========================*/
			$current_user = wp_get_current_user();
			$user_ID = $current_user->ID;
			$redirectURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if($redirectURL){
				$redirectURL = $redirectURL;
			}
			else{
				$redirectURL = home_url();
			}
			wp_localize_script( 'classiera-helper', 'classiera', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'home_url' => home_url(),
				'current_user' => $user_ID,
				'redirectURL' => $redirectURL,
			));
		}
		add_action('wp_enqueue_scripts','classiera_helper_scripts');
	}
	/*==========================
	Call required files for post meta
	===========================*/
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'page_meta.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'post_meta.php';
	/*==========================
	Call Widgets 
	===========================*/
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/blog-categories.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/categories.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/contact-info.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/recent_posts_widget.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/recent-blog-post.php';
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'widgets/social_widget.php';
	/*==========================
	Call Email functions 
	===========================*/
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'email_functions.php';
	/*==========================
	Call Helper ajax functions 
	===========================*/
	require_once WPCH_PLUGIN_INCLUDES_DIR . 'classiera_helper_ajax.php';
	/*==========================
	Register Pricing Plans Post Method
	===========================*/
	function classiera_Pricing_Plans(){
		$labels = array(
	    	'name' => _x('Pricing Plans', 'post type general name', 'classiera-helper'),
	    	'singular_name' => _x('Price Plans', 'post type singular name', 'classiera-helper'),
	    	'add_new' => _x('Add New Price Plan', 'book', 'classiera-helper'),
	    	'add_new_item' => __('Add New Price Plan', 'classiera-helper'),
	    	'edit_item' => __('Edit Price Plan', 'classiera-helper'),
	    	'new_item' => __('New Price Plan', 'classiera-helper'),
	    	'view_item' => __('View Price Plan', 'classiera-helper'),
	    	'search_items' => __('Search Price Plans', 'classiera-helper'),
	    	'not_found' =>  __('No Price Plan found', 'classiera-helper'),
	    	'not_found_in_trash' => __('No Price Plans found in Trash', 'classiera-helper'), 
	    	'parent_item_colon' => ''
		);		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
	    	'publicly_queryable' => true,
	    	'show_ui' => true, 
	    	'query_var' => true,
	    	'rewrite' => true,
	    	'capability_type' => 'post',
	    	'hierarchical' => false,
	    	'menu_position' => null,
	    	'supports' => array('title','editor', 'thumbnail'),
	    	'menu_icon' => 'dashicons-tag',
		); 		

		register_post_type( 'price_plan', $args ); 				  
	}
	add_action('init', 'classiera_Pricing_Plans');

	/*==========================
	Free Plans
	===========================*/
	add_action( 'add_meta_boxes', 'make_Free_Plans' );
	function make_Free_Plans() {
	    add_meta_box( 
	        'free_plans',
	        __( 'Is this a free plan', 'classiera-helper' ),
	        'classiera_Free_Plans',
	        'price_plan',
	        'side',
	        'high'
	    );
	}
	function classiera_Free_Plans() {
		global $post;
		
		// Noncename needed to verify where the data originated	
		wp_nonce_field( 'classiera_freeplans_check_box', 'classiera_freeplans_check_box_nonce' );
		
		// Get the location data if its already been entered
		$free_plans = get_post_meta($post->ID, 'free_plans', true);
		
		// Echo out the field
		echo '<span class="text overall" style="margin-right: 20px;">'.__( 'If you check this option, leave the price field below empty.', 'classiera-helper' ).':</span>';
		
		$checked = get_post_meta($post->ID, 'free_plans', true) == '1' ? "checked" : "";
		
		echo '<input type="checkbox" name="free_plans" id="free_plans" value="1" '. $checked .'/>';

	}
	add_action( 'save_post', 'free_Plans_save_meta' );
	function free_Plans_save_meta($post_id){
		global $post;
		/*== verify this came from the our screen and with proper authorization ==*/
		/*== because save_post can be triggered at other times ==*/		
		if ( ! isset( $_POST['classiera_freeplans_check_box_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['classiera_freeplans_check_box_nonce'], 'classiera_freeplans_check_box' ) ) {
			return;
		}
		
		/*== Is the user allowed to edit the post or page? ==*/	
		if ( !current_user_can( 'edit_post', $post->ID )){
			return $post->ID;
		}
		/*== OK, we're authenticated: we need to find and save the data ==*/
		/*== We'll put it into an array to make it easier to loop though ==*/
		
		$events_meta['free_plans'] = $_POST['free_plans'];
		
		$chk = ( isset( $_POST['free_plans'] ) && $_POST['free_plans'] ) ? '1' : '2';
		update_post_meta( $post_id, 'free_plans', $chk );
		
		/*== Add values of $events_meta as custom fields ==*/
		foreach ($events_meta as $key => $value) {
			/*== Cycle through the $events_meta array! ==*/
			if( $post->post_type == 'post' ){
				return;
			} /*== Don't store custom data twice ==*/
			$value = implode(',', (array)$value); /*== If $value is an array, make it a CSV (unlikely) ==*/
			if(get_post_meta($post->ID, $key, FALSE)) {
				/*== If the custom field already has a value ==*/
				update_post_meta($post->ID, $key, $value);
			} else {
				/*== If the custom field doesn't have a value ==*/				
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) {
				delete_post_meta($post->ID, $key);
			}/*== Delete if blank ==*/
		}

	}	
	/*==========================
	Free Plans
	===========================*/
	add_action( 'add_meta_boxes', 'plan_ads_box' );
	function plan_ads_box() {
	    add_meta_box( 
	        'plan_ads_box',
	        __( 'Featured ads: How many featured ads do you want to allow with this plan?', 'classiera-helper' ),
	        'plan_ads_content',
	        'price_plan'	        
	    );
	}

	function plan_ads_content( $post ) {

		$featured_ads = get_post_meta( $post->ID, 'featured_ads', true );

		echo '<label for="featured_ads"></label>';
		echo '<input type="text" id="featured_ads" name="featured_ads" placeholder="Featured ads number" value="';
		echo $featured_ads; 
		echo '">';
		
	}

	add_action( 'save_post', 'project_link_box_save' );
	function project_link_box_save( $post_id ) {		

		global $featured_ads;

		if(isset($_POST["featured_ads"]))
		$featured_ads = $_POST['featured_ads'];
		update_post_meta( $post_id, 'featured_ads', $featured_ads );

	}
	/*==========================
	Classiera Regular Ads Count
	===========================*/
	add_action( 'add_meta_boxes', 'regular_plan_ads_box' );
	function regular_plan_ads_box() {
	    add_meta_box( 
	        'regular_plan_ads_box',
	        __( 'Regular ads : How many regular ads do you want to allow with this plan? ', 'classiera-helper' ),
	        'regular_plan_ads_content',
	        'price_plan'	        
	    );
	}
	function regular_plan_ads_content( $post ) {
		$regular_ads = get_post_meta( $post->ID, 'regular_ads', true );
		echo '<label for="regular_ads"></label>';
		echo '<input type="text" id="regular_ads" name="regular_ads" placeholder="Put a number" value="';
		echo $regular_ads; 
		echo '">';		
	}
	add_action( 'save_post', 'regular_ads_box_save' );
	function regular_ads_box_save( $post_id ) {
		global $regular_ads;
		if(isset($_POST["regular_ads"]))
		$regular_ads = $_POST['regular_ads'];
		update_post_meta( $post_id, 'regular_ads', $regular_ads );
	}		
	/*==========================
	Classiera Regular Ads Count
	===========================*/
	/*==========================
	WooCommerece ID
	===========================*/
	add_action( 'add_meta_boxes', 'plan_woo_id' );
	function plan_woo_id() {
	    add_meta_box( 
	        'plan_woo_id',
	        __( 'Put your WooCommerece Product ID : The WooCommerce product price and this plan price must be of the same value.', 'classiera-helper' ),
	        'plan_woo_content',
	        'price_plan'
	    );
	}
	
	function plan_woo_content( $post ) {

		$woo_id = get_post_meta( $post->ID, 'woo_id', true );

		echo '<label for="woo_id"></label>';
		echo '<input type="text" id="woo_id" name="woo_id" placeholder="'.__( 'Product ID', 'classiera-helper' ).'" value="';
		echo $woo_id; 
		echo '">';
		
	}
	
	add_action( 'save_post', 'plan_woo_save' );
	function plan_woo_save( $post_id ) {		

		global $woo_id;

		if(isset($_POST["woo_id"]))
		$woo_id = $_POST['woo_id'];
		update_post_meta( $post_id, 'woo_id', $woo_id );

	}	
	/*==========================
	WooCommerece ID
	===========================*/
	/*==========================
	Pricing Plans Days
	===========================*/
	add_action( 'add_meta_boxes', 'plan_time_box' );
	function plan_time_box() {
	    add_meta_box( 
	        'plan_time_box',
	        __( 'Days : Days: How many days ads will be shown at the premium place.', 'classiera-helper' ),
	        'plan_time_content',
	        'price_plan'	        
	    );
	}
	function plan_time_content( $post ) {

		$plan_time = get_post_meta( $post->ID, 'plan_time', true );

		echo '<label for="plan_time"></label>';
		echo '<input type="text" id="plan_time" name="plan_time" placeholder="Days" value="';
		echo $plan_time; 
		echo '">';
		
	}
	add_action( 'save_post', 'plan_time_save' );
	function plan_time_save( $post_id ) {		

		global $plan_time;

		if(isset($_POST["plan_time"]))
		$plan_time = $_POST['plan_time'];
		update_post_meta( $post_id, 'plan_time', $plan_time );

	}
	/*==========================
	Pricing Plans Days
	===========================*/
	add_action( 'add_meta_boxes', 'plan_text_box' );
	function plan_text_box() {
	    add_meta_box( 
	        'plan_text_box',
	        __( 'Replace the default text with your own.', 'classiera-helper' ),
	        'plan_text_content',
	        'price_plan'
	    );
	}
	
	function plan_text_content( $post ) {

		$plan_text = get_post_meta( $post->ID, 'plan_text', true );

		echo '<label for="plan_text"></label>';
		echo '<input type="text" id="plan_text" name="plan_text" placeholder="'.__( 'Start the free trial with Classiera', 'classiera-helper' ).'" value="';
		echo $plan_text; 
		echo '">';
		
	}
	
	add_action( 'save_post', 'plan_text_save' );
	function plan_text_save( $post_id ) {		

		global $plan_text;

		if(isset($_POST["plan_text"]))
		$plan_text = $_POST['plan_text'];
		update_post_meta( $post_id, 'plan_text', $plan_text );

	}
	/*==========================
	Free Ads Posting
	===========================*/
	add_action( 'add_meta_boxes', 'plan_free_text_box' );
	function plan_free_text_box() {
	    add_meta_box( 
	        'plan_free_text_box',
	        __( 'Replace the default text with your own.', 'classiera-helper' ),
	        'plan_free_text_content',
	        'price_plan'
	    );
	}

	function plan_free_text_content( $post ) {
		wp_nonce_field( 'plantextfree_meta_box', 'plantextfree_meta_box_nonce' );
		$plan_free_text = get_post_meta( $post->ID, 'plan_free_text', true );

		echo '<label for="plan_free_text"></label>';
		echo '<input type="text" id="plan_free_text" name="plan_free_text" placeholder="'.__( 'Featured ad posting', 'classiera-helper' ).'" value="';
		echo $plan_free_text; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_free_text_save' );
	function plan_free_text_save( $post_id ) {		

		global $plan_free_text;
		
		if ( ! isset( $_POST['plantextfree_meta_box_nonce'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['plantextfree_meta_box_nonce'], 'plantextfree_meta_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if(isset($_POST["plan_free_text"]))
		$plan_free_text = $_POST['plan_free_text'];
		update_post_meta( $post_id, 'plan_free_text', $plan_free_text );

	}	
	/*==========================
	Free Ads Posting
	===========================*/
	/*==========================
	 100% Secure
	===========================*/
	add_action( 'add_meta_boxes', 'plan_secure_text_box' );
	function plan_secure_text_box() {
	    add_meta_box( 
	        'plan_secure_text_box',
	        __( 'Replace the default text with your own.', 'classiera-helper' ),
	        'plan_secure_text_content',
	        'price_plan'
	    );
	}

	function plan_secure_text_content( $post ) {
		wp_nonce_field( 'plantextsecure_meta_box', 'plantextsecure_meta_box_nonce' );
		$plan_secure_text = get_post_meta( $post->ID, 'plan_secure_text', true );

		echo '<label for="plan_secure_text"></label>';
		echo '<input type="text" id="plan_secure_text" name="plan_secure_text" placeholder="'.__( '100% Secure!', 'classiera-helper' ).'" value="';
		echo $plan_secure_text; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_secure_text_save' );
	function plan_secure_text_save( $post_id ) {		

		global $plan_secure_text;
		
		if ( ! isset( $_POST['plantextsecure_meta_box_nonce'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['plantextsecure_meta_box_nonce'], 'plantextsecure_meta_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if(isset($_POST["plan_secure_text"]))
		$plan_secure_text = $_POST['plan_secure_text'];
		update_post_meta( $post_id, 'plan_secure_text', $plan_secure_text );

	}
	/*==========================
	 100% Secure
	===========================*/
	/*==========================
	 Plans Titles
	===========================*/
	add_action( 'add_meta_boxes', 'plan_price_box' );
	function plan_price_box() {
	    add_meta_box( 
	        'plan_price_box',
	        __( 'Price :Don&rsquo;t put a currency tag', 'classiera-helper' ),
	        'plan_price_content',
	        'price_plan',
	        'side',
	        'high'
	    );
	}

	function plan_price_content( $post ) {

		$plan_price = get_post_meta( $post->ID, 'plan_price', true );

		echo '<label for="plan_price"></label>';
		echo '<input type="text" id="plan_price" name="plan_price" placeholder="'.__( 'Ex:5', 'classiera-helper' ).'" value="';
		echo $plan_price; 
		echo '">';
		
	}


	add_action( 'save_post', 'plan_price_save' );
	function plan_price_save( $post_id ) {		

		global $plan_price;

		if(isset($_POST["plan_price"]))
		$plan_price = $_POST['plan_price'];
		update_post_meta( $post_id, 'plan_price', $plan_price );

	}
	
	add_action( 'add_meta_boxes', 'plan_user_box_cancel' );
	function plan_user_box_cancel() {
	    add_meta_box( 
	        'plan_user_box_cancel',
	        __( 'Enter a USERNAME to cancel this plan for a particular user (leave empty for no cancellation)', 'classiera-helper' ),
	        'plan_user_content_cancel',
			'price_plan'

	    );
	}

	function plan_user_content_cancel( $post ) {
		
		echo '<label for="plan_cancel"></label>';
		echo '<input type="text" id="plan_cancel" name="plan_cancel" placeholder="'.__( 'Enter a USERNAM', 'classiera-helper' ).'" value="';

		echo '">';
	}
	
	add_action( 'save_post', 'plan_user_del_save' );
	function plan_user_del_save( $post_id ) {
		global $plan_time;
		global $featured_ads;
		global $regular_ads;
		global $plan_price;
		global $post_title;
		global $woo_id;
		global $wpdb;
		if (isset($_POST['plan_cancel'])) {
		$plan_cancel = $_POST['plan_cancel'];
			if(!empty($plan_cancel)){
				$user = get_user_by( 'login', $plan_cancel );		
				$user_cancel = $user->ID;
				$posttitle  = get_the_title($post->ID);
				$tablename = $wpdb->prefix . 'classiera_plans';
				$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id = $user_cancel AND plan_name = '$posttitle'  ORDER BY id DESC" );
				if (!empty($result )) {
					foreach ( $result as $key => $row ){
						if($row->ads == '0'){
							$wpdb->update($tablename, array('ads'=> '2', 'used'=>'2'), array( 'id'=>$row->id) );
							$wpdb->update($tablename, array('status'=> 'rejected'), array( 'id'=>$row->id) );
						}else{
							$wpdb->update($tablename, array('used'=>$row->ads), array( 'id'=>$row->id) );
							$wpdb->update($tablename, array('status'=> 'rejected'), array( 'id'=>$row->id) );
						}
						if($row->regular_ads == '0'){
							$wpdb->update($tablename, array('regular_ads'=> '2', 'regular_used'=>'2'), array( 'id'=>$row->id) );
						}else{
							$wpdb->update($tablename, array('regular_used'=>$row->regular_ads), array( 'id'=>$row->id) );
						}
					}
				}
			}	
		}
	}
	add_action( 'add_meta_boxes', 'plan_user_box' );
	function plan_user_box() {
	    add_meta_box( 
	        'plan_user_box',
	        __( 'Enter a USERNAME to assign this plan for a particular user (leave empty for no assignment).', 'classiera-helper' ),
	        'plan_user_content',
			'price_plan'

	    );
	}

	function plan_user_content( $post ) {
		
		echo '<label for="plan_add"></label>';
		echo '<input type="text" id="plan_add" name="plan_add" placeholder="'.__( 'Enter a USERNAME', 'classiera-helper' ).'" value="';

		echo '">';
	}
	
	add_action( 'save_post', 'plan_user_add_save' );
	function plan_user_add_save( $post_id ) {
				global $plan_time;
				global $featured_ads;
				global $regular_ads;
				global $plan_price;
				global $post_title;
				global $woo_id;
				global $wpdb;
		if (!empty($_POST['plan_add'])) {
			$plan_add = $_POST['plan_add'];		
			$user = get_user_by( 'login', $plan_add );
			$user_add = $user->ID;
			
			$posttitle  = get_the_title($post->ID);
			$planID = $post_id;
			$price_plan_information = array(
				'id' =>'', 
				'product_id' => $woo_id, 
				'user_id' => $user_add, 
				'plan_id' => $planID, 
				'regular_ads' => $regular_ads, 
				'plan_name' => $posttitle, 
				'price' => $plan_price, 
				'ads' => $featured_ads, 
				'days' => $plan_time, 
				'status' => "complete", 
				'used' => "0", 
				'regular_used' => "0", 
				'created' => time() 
			);			
			$insert_format = array('%d', '%d', '%d', '%d', '%d', '%s', '%s','%d', '%s', '%s', '%s', '%s', '%s');
			$tablename = $wpdb->prefix . 'classiera_plans';
			$wpdb->insert($tablename, $price_plan_information, $insert_format);
		}
	}
	
	add_action( 'add_meta_boxes', 'popular_plan_box' );
	function popular_plan_box() {
	    add_meta_box( 
	        'popular_plan',
	        __( 'Most popular plan', 'classiera-helper' ),
	        'popular_plan',
			'price_plan'

	    );
	}
	function popular_plan( $post ) {
		global $post;
		$popular_plan = get_post_meta($post->ID, 'popular_plan', true);
		$checked = $popular_plan == 'true' ? "checked" : "";
		echo '<label for="popular_plan"></label>';
		echo '<input type="checkbox" name="popular_plan" id="popular_plan" value="true" '. $checked .'/>';
	}
	
	add_action( 'save_post', 'popular_plan_save' );
	function popular_plan_save( $post_id ) {
		global $wpdb;
		if (isset($_POST['popular_plan']) && !empty($_POST['popular_plan'])) {
			$plan_pop = $_POST['popular_plan'];			
		}else{
			$plan_pop = '';
			
		}
		update_post_meta( $post_id, 'popular_plan', $plan_pop );
	}
	/*==========================
	 Register Blog Post Type
	===========================*/
	function classiera_blogs_category() {
		$labels = array(		
			'name' => _x('Blog Categories', 'taxonomy general name', 'classiera-helper'),
			'singular_name'     => _x( 'Blog Category', 'classiera-helper' ),
			'search_items'      => __( 'Search Blogs Categories', 'classiera-helper'),
			'all_items'         => __( 'All Blog Categories', 'classiera-helper'),
			'parent_item'       => __( 'Parent Blog Category', 'classiera-helper'),
			'parent_item_colon' => __( 'Parent Blog Category:', 'classiera-helper'),
			'edit_item'         => __( 'Edit Blog Category', 'classiera-helper'), 
			'update_item'       => __( 'Update Blog Category', 'classiera-helper'),
			'add_new_item'      => __( 'Add new Blog Category', 'classiera-helper'),
			'new_item_name'     => __( 'New Blog Category', 'classiera-helper'),
			'menu_name'         => __( 'Blog Categories', 'classiera-helper'),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'blog_category', 'blog', $args );	
	}
	add_action( 'init', 'classiera_blogs_category', 0 );
	function classiera_post_type_blogs(){
		$labels = array(
			'name' => _x('Blog', 'post type general name', 'classiera-helper'),
			'singular_name' => _x('Blog', 'post type singular name', 'classiera-helper'),
			'add_new' => _x('Add new Blog Post', 'book', 'classiera-helper'),
			'add_new_item' => __('Add new Blog Post', 'classiera-helper'),
			'edit_item' => __('Edit Blog Post', 'classiera-helper'),
			'new_item' => __('New Blog Post', 'classiera-helper'),
			'view_item' => __('View Blog Post', 'classiera-helper'),
			'search_items' => __('Search Blog Post', 'classiera-helper'),
			'not_found' =>  __('No Blog Post found', 'classiera-helper'),
			'not_found_in_trash' => __('No Blog Post found in Trash', 'classiera-helper'), 
			'parent_item_colon' => ''
		);		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false, 
			'show_ui' => true, 
			'query_var' => true,
			'menu_position' => null,
			'hierarchical' => false,
			'rewrite' => array( 'slug' => 'blog', 'with_front' => true ),
			'has_archive' => true,
			'capability_type' => 'post',		
			'supports' => array('title','editor', 'thumbnail', 'comments', 'author'),
			'taxonomies' => array('post_tag', 'blog_category'),
			'menu_icon' => 'dashicons-admin-post'
		);
		register_post_type('blog', $args ); 
		//flush_rewrite_rules(true);	
	} 
	add_action('init', 'classiera_post_type_blogs');
	/*==========================
	 Register Blog Post Type
	===========================*/
	if (!function_exists('classiera_remove_admin_bar')) {
		add_action('after_setup_theme', 'classiera_remove_admin_bar');
		function classiera_remove_admin_bar(){
			if (!current_user_can('administrator') && !is_admin()){
			  show_admin_bar(false);
			}
		}
	}
	/*==========================
	 Disable Disqus comments on woocommerce product
	===========================*/
	if (!function_exists('disqus_override_tabs')) {
		function disqus_override_tabs($tabs){
			if ( has_filter( 'comments_template', 'dsq_comments_template' ) ){
				remove_filter( 'comments_template', 'dsq_comments_template' );
				add_filter('comments_template', 'dsq_comments_template',90);
				/*== higher priority, so the filter is called after woocommerce filter ==*/
			}
			return $tabs;
		}	
	}	
	/*==========================
	 Removes the demo link and the notice of integrated demo from the redux-framework plugin
	===========================*/
	 if ( ! function_exists( 'remove_demo' ) ) {
		function remove_demo() {		
			/*== Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin ==*/
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array(
					ReduxFrameworkPlugin::instance(),
					'plugin_metalinks'
				), null, 2 );
				/*== Used to hide the activation notice informing users of the demo panel. ==*/
				/*==Only used when Redux is a plugin. ==*/			
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
			}
		}
	}
	/*==========================
	 Remove Notification from redux framework
	===========================*/
	if ( ! function_exists( 'classieraRemoveReduxDemoModeLink' ) ) { 
		function classieraRemoveReduxDemoModeLink() {
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2 );
			}
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
				remove_action('admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );    
			}
		}
		add_action('init', 'classieraRemoveReduxDemoModeLink');
	}
	/*==========================
	 Classiera Send Email Function
	===========================*/
	if (!function_exists('classiera_send_wp_mail')) {
		function classiera_send_wp_mail($emailTo, $subject, $body){
			wp_mail($emailTo, $subject, $body);
		}
	}
	if (!function_exists('classiera_send_mail_with_headers')) {
		function classiera_send_mail_with_headers($emailTo, $subject, $body, $headers){
			wp_mail($emailTo, $subject, $body, $headers);
		}
	}
	/*==========================
	 Classiera : Author add new contact details
	===========================*/
	add_filter('user_contactmethods','classiera_author_new_contact',10,1); 
	if (!function_exists('classiera_author_new_contact')) {
		function classiera_author_new_contact( $contactmethods ) {
			/*== Add telephone ==*/	
			$contactmethods['phone'] = esc_html__( 'Phone', 'classiera-helper');
			$contactmethods['phone2'] = esc_html__( 'Mobile', 'classiera-helper');				
			/*== add address ==*/	
			$contactmethods['address'] = esc_html__( 'Address', 'classiera-helper');			
			/*== add social ==*/
			$contactmethods['facebook'] = esc_html__( 'Facebook', 'classiera-helper');
			$contactmethods['instagram'] = esc_html__( 'Instagram', 'classiera-helper');
			$contactmethods['twitter'] = esc_html__( 'Twitter', 'classiera-helper');
			$contactmethods['googleplus'] = esc_html__( 'Google Plus', 'classiera-helper');
			$contactmethods['linkedin'] = esc_html__( 'Linkedin', 'classiera-helper');
			$contactmethods['pinterest'] = esc_html__( 'Pinterest', 'classiera-helper');
			$contactmethods['vimeo'] = esc_html__( 'Vimeo', 'classiera-helper');
			$contactmethods['digg'] = esc_html__( 'Digg', 'classiera-helper');
			$contactmethods['behance'] = esc_html__( 'Behance', 'classiera-helper');
			$contactmethods['dribbble'] = esc_html__( 'Dribbble', 'classiera-helper');
			$contactmethods['flickr'] = esc_html__( 'Flickr', 'classiera-helper');
			$contactmethods['github'] = esc_html__( 'Github', 'classiera-helper');
			$contactmethods['lastfm'] = esc_html__( 'Lastfm', 'classiera-helper');
			$contactmethods['soundcloud'] = esc_html__( 'Soundcloud', 'classiera-helper');
			$contactmethods['vk'] = esc_html__( 'VK', 'classiera-helper');			
			$contactmethods['youtube'] = esc_html__( 'YouTube', 'classiera-helper');
			$contactmethods['country'] = esc_html__( 'Country', 'classiera-helper');
			$contactmethods['state'] = esc_html__( 'State', 'classiera-helper');
			$contactmethods['city'] = esc_html__( 'City', 'classiera-helper');
			$contactmethods['postcode'] = esc_html__( 'Postcode', 'classiera-helper'); 
			return $contactmethods;	
		}
	} 
	/*==========================
	 Lost Password and Login Error
	===========================*/
	add_action( 'wp_login_failed', 'classiera_front_end_login_fail' ); /*== hook failed login ==*/
	function classiera_front_end_login_fail( $username ) {
		global $user, $user_verify;
	   $referrer = $_SERVER['HTTP_REFERER'];	  
	   /*== where did the post submission come from? ==*/
	   /*== if there's a valid referrer, and it's not the default log-in screen ==*/
	   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
			wp_redirect( $referrer . '?login=failed' ); 
			/*== let's append some information (login=failed) to the URL for the theme to use ==*/
			exit;
	   }elseif ( is_wp_error($user_verify) )  {
			wp_redirect( $referrer . '?login=failed-user' );
			/*== let's append some information (login=failed) to the URL for the theme to use ==*/
			exit;
	   }
	}
	/*==========================
	 Classiera : Submit Comment AJAX Function
	 @since classiera 1.0
	===========================*/
	function classiera_ajax_comments($comment_ID, $comment_status){
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			switch ($comment_status) {
				case '0':			
				case '1': /*== Approved comment ==*/			
				$commentdata = get_comment($comment_ID, ARRAY_A);
				$authorEmail = $commentdata['comment_author_email'];			
				$author_avatar_url = classiera_get_avatar_url ($authorEmail, $size = '150' );
				$authorName = $commentdata['comment_author'];
				$comment_date_gmt = $commentdata['comment_date_gmt'];

				if($commentdata['comment_parent'] == 0){				
					$output = '<ul class="media-list"><li class="media"><div class="media-left"><img class="media-object img-thumbnail" src="'.$author_avatar_url.'"></div><div class="media-body"><h5 class="media-heading">'.$authorName.'&nbsp;&nbsp;<span class="normal">'.esc_html__( 'Said', 'classiera-helper').'&nbsp;:</span><span class="time pull-right flip">'.$comment_date_gmt .'</span></h5><p>' . $commentdata['comment_content'] . '</p></div></li></ul>';
					
					echo $output;
				}else{
					$output = '<div class="media children" id="comment-' . $commentdata['comment_ID'] . '"><div class="media-left"><img class="media-object img-thumbnail" src="'.$author_avatar_url.'"></div><div class="media-body"><h5 class="media-heading">'.$authorName.'<span class="normal">'.esc_html_e( 'Said', 'classiera-helper').'</span><span class="time pull-right flip">'.$comment_date_gmt .'</span></h5><p>' . $commentdata['comment_content'] . '</p></div></div>';
					
					echo $output;
				}
					$post = get_post($commentdata['comment_post_ID']);
				break;
				default:
				echo "error";
			}
			die();
		exit;
		}
		die();
	}
	add_action('comment_post', 'classiera_ajax_comments', 25, 2);
	/*==========================
	 Classiera : Login , Register, Reset Password redirect option.
	 @since classiera 1.0
	===========================*/
if( !class_exists('NextendSocialLogin', false)){
	if (!function_exists('classiera_cubiq_login_init')) {
		function classiera_cubiq_login_init () {
			$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';	
			$login = classiera_get_template_url('template-login.php');
			if(empty($login)){
				$login = classiera_get_template_url('template-login-v2.php');
			}	
			$reset = classiera_get_template_url('template-reset.php');
			if ( isset( $_POST['wp-submit'] ) ) {
				$action = 'post-data';
			} else if ( isset( $_GET['reauth'] ) ) {
				$action = 'reauth';
			} else if ( isset($_GET['key']) ) {
				$action = 'resetpass-key';
			}
			
			/*== redirect to change password form ==*/
			if ( $action == 'rp' || $action == 'resetpass' ) {
				wp_redirect( $login.'/?action=resetpass' );
				exit;
			}		
			
			/*== redirect to change password form ==*/
			if ( $action == 'register') {
				wp_redirect( $login.'/?action=resetpass' );
				exit;
			}
			/*== redirect from wrong key when resetting password ==*/
			
			if ( $action == 'lostpassword' && isset($_GET['error']) && ( $_GET['error'] == 'expiredkey' || $_GET['error'] == 'invalidkey' ) ) {
				wp_redirect($reset.'/?action=forgot&failed=wrongkey' );
				exit;
			}

			if (
				$action == 'post-data'        ||            /*== don't mess with POST requests ==*/
				$action == 'reauth'           ||            /*== need to reauthorize ==*/
				$action == 'resetpass-key'    ||            /*== password recovery ==*/
				$action == 'logout'           ||            /*== user is logging out ==*/
				$action == 'postpass'
			) {
				return;
			}   
			wp_redirect($login);
			exit;
		}
		add_action('login_init', 'classiera_cubiq_login_init');
	}
}
	/*==========================
	 Classiera : Redirect on Registration
	 @since classiera 1.0
	===========================*/
	if (!function_exists('classiera_cubiq_login_init')) {
		function classiera_cubiq_registration_redirect ($errors, $sanitized_user_login, $user_email) {	
			$login = classiera_get_template_url('template-login.php');
			if(empty($login)){
				$login = classiera_get_template_url('template-login-v2.php');
			}	
			$register = classiera_get_template_url('template-register.php');
			if(empty($register)){
				$register = classiera_get_template_url('template-login-v2.php');
			}			
			/*== don't lose your time with spammers, redirect them to a success page ==*/
			if ( !isset($_POST['confirm_email']) || $_POST['confirm_email'] !== '' ) {
				wp_redirect($login. '?action=register&success=1' );
				exit;
			}
			if ( !empty( $errors->errors) ) {
				if ( isset( $errors->errors['username_exists'] ) ) {
					wp_redirect( $register . '?action=register&failed=username_exists' );
				} else if ( isset( $errors->errors['email_exists'] ) ) {
					wp_redirect( $register . '?action=register&failed=email_exists' );
				} else if ( isset( $errors->errors['empty_username'] ) || isset( $errors->errors['empty_email'] ) ) {
					wp_redirect($register . '?action=register&failed=empty' );
				} else if ( !empty( $errors->errors ) ) {
					wp_redirect( $register . '?action=register&failed=generic' );
				}
				exit;
			}
			return $errors;
		}
		add_filter('registration_errors', 'classiera_cubiq_registration_redirect', 10, 3);
	}
	/*==========================
	 Classiera : Fix nextend facebook connect doesn't remove cookie after logout
	 @since classiera 1.0
	===========================*/
	if (!function_exists('classiera_clear_nextend_cookie')) {
		function classiera_clear_nextend_cookie(){
			setcookie( 'nextend_uniqid',' ', time() - YEAR_IN_SECONDS, '/', COOKIE_DOMAIN );
			return 0;
		}
		add_action('clear_auth_cookie', 'classiera_clear_nextend_cookie');
	}
	/*==========================
	 Remove dash-icons for non admin
	===========================*/
	if (!function_exists('classiera_dequeue_dashicon')) {
		function classiera_dequeue_dashicon() {
			if (current_user_can( 'update_core' )){
				return;
			}
			wp_deregister_style('dashicons');
		}
		add_action( 'wp_enqueue_scripts', 'classiera_dequeue_dashicon' );
	}
	/*==========================
	Classiera escape
	===========================*/
	if(!function_exists('classiera_display_html_code')) { 
		function classiera_display_html_code($htmladcode){
			$displayCode = $htmladcode;
			return $displayCode;
		}
	} 
	if(!function_exists('classiera_escape')) { 
		function classiera_escape($htmladcode){
			$displayCode = $htmladcode;
			echo $displayCode;
		}
	}
	/*==========================
	WordPress Optimization
	===========================*/
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');