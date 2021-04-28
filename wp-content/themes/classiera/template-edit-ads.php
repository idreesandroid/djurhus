<?php
/**
 * Template name: Edit Ad
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
?>
<?php 
if ( !is_user_logged_in() ) {
	wp_redirect( home_url() ); exit;
}
/*==========================
Define variables
===========================*/
global $redux_demo, $current_user, $current_post, $allowed;
$hasError = false;
$hasErrorVerify = false;
$hasErrorImage = false;
$hasErrorTitle = false;
$post_whatsapp_on = true;
$featuredADS = '';
$availableADS = '';
$postContent = '';
$caticoncolor = '';
$category_icon_code = '';
$category_icon = '';
$category_icon_color = '';
$postTitleError = '';
$post_priceError = '';
$classieraPostType = '';
$excludeCats = '';
$catError = '';
$getStatesbyID = '';
$featPlanMesage = '';
$current_user = wp_get_current_user();
$userID = $current_user->ID;
$userLogin = $current_user->user_login;
$userEmail = $current_user->user_email;
$classieraProfileURL = classiera_get_template_url('template-profile.php');
if(isset($redux_demo)){
	$googleFieldsOn = $redux_demo['google-lat-long'];
	$classieraLatitude = $redux_demo['contact-latitude'];
	$post_whatsapp_on = $redux_demo['post_whatsapp_on'];
	$classieraLongitude = $redux_demo['contact-longitude'];
	$postCurrency = $redux_demo['classierapostcurrency'];
	$classieraAddress = $redux_demo['classiera_address_field_on'];
	$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
	$termsandcondition = $redux_demo['termsandcondition'];
	$classiera_locations_input = $redux_demo['classiera_locations_input'];
	$classiera_bid_system = $redux_demo['classiera_bid_system'];
	$regularpriceon= $redux_demo['regularpriceon'];	
	$classieraAskingPhone = $redux_demo['phoneon'];
	$adpostCondition= $redux_demo['adpost-condition'];
	$adsTypeShow = $redux_demo['classiera_ads_type_show'];
	$classieraPriceSecOFF = $redux_demo['classiera_sale_price_off'];
	$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
	$paidIMG = $redux_demo['premium-ads-limit'];
	$regularIMG = $redux_demo['regular-ads-limit'];	
	$classiera_video_postads = $redux_demo['classiera_video_postads'];
	$locationsStateOn = $redux_demo['location_states_on'];
	$locationsCityOn= $redux_demo['location_city_on'];
	$googleMapadPost = $redux_demo['google-map-adpost'];
	$regular_ads = $redux_demo['regular-ads'];
	$classieraRegularAdsDays = $redux_demo['ad_expiry'];
	$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];
	$classiera_post_web_url = $redux_demo['classiera_post_web_url'];
	$excludeCats = $redux_demo['classiera_exclude_categories'];
	$excludeCatsUsers = $redux_demo['classiera_exclude_user'];
	$classiera_google_api = $redux_demo['classiera_google_api'];
	$classiera_image_size = $redux_demo['classiera_image_size'];
}

$args = array(
	'post_type' => 'post',
	'post_status' => array('publish', 'pending', 'draft', 'trash', 'private'),
	'posts_per_page' => '1',
	'p' => $_GET['post'],
);
$query = new WP_Query($args);
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
	if(isset($_GET['post'])) {
		if($_GET['post'] == $post->ID){
			$posts_id = $_GET['post'];
			/*==========================
			Get Author ID from post
			===========================*/
			$author = get_post_field( 'post_author', $posts_id );
			if(current_user_can('administrator') ){
				
			}else{
				/*==========================
				Security check
				===========================*/
				if($author != $userID) {
					wp_redirect( home_url() ); exit;
				}
			}
			$current_post = $post->ID;
			$title = get_the_title();
			$content = get_the_content();
			$posttags = get_the_tags($current_post);
			if ($posttags) {
				foreach($posttags as $tag) {
					$tags_list = $tag->name . ' ';
				}
			}
			$postcategory = get_the_category( $current_post );
			$category_id = $postcategory[0]->cat_ID;
			$post_category_type = get_post_meta($post->ID, 'post_category_type', true);
			$classieraPostDate = get_the_date('Y-m-d H:i:s', $posts_id);
			$post_price = get_post_meta($post->ID, 'post_price', true);	
			$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
			$classieraTagDefault = get_post_meta($post->ID, 'post_currency_tag', true);
			$post_phone = get_post_meta($post->ID, 'post_phone', true);
			$number_hide = get_post_meta($post->ID, 'number_hide', true);
			
			$post_whatsapp = get_post_meta($post->ID, 'post_whatsapp', true);
			$post_main_cat = get_post_meta($post->ID, 'post_perent_cat', true);
			$post_child_cat = get_post_meta($post->ID, 'post_child_cat', true);
			$post_inner_cat = get_post_meta($post->ID, 'post_inner_cat', true);
			if($category_id == $post_main_cat || $category_id == $post_child_cat || $category_id == $post_inner_cat){
				if(empty($post_inner_cat)){
					$category_id = $post_child_cat;
				}else{
					$category_id = $post_inner_cat;
				}
				if(empty($category_id)){
					$category_id = $post_main_cat;
				}
			}			
			/*==========================
			Collect custom fields values
			===========================*/
			$post_location = get_post_meta($post->ID, 'post_location', true);
			$post_state = get_post_meta($post->ID, 'post_state', true);
			$post_city = get_post_meta($post->ID, 'post_city', true);
			$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
			$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
			$post_price_plan_id = get_post_meta($post->ID, 'post_price_plan_id', true);
			$post_address = get_post_meta($post->ID, 'post_address', true);
			$post_video = get_post_meta($post->ID, 'post_video', true);
			$featuredIMG = get_post_meta($post->ID, 'featured_img', true);
			$itemCondition = get_post_meta($post->ID, 'item-condition', true);
			$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
			$classiera_week_renewal = get_post_meta($post->ID, 'classiera_week_renewal', true);
			$classiera_allow_bids = get_post_meta($post->ID, 'classiera_allow_bids', true);
			$classiera_post_type = get_post_meta($post->ID, 'classiera_post_type', true);
			$classiera_post_type_featured = get_post_meta($post->ID, 'classiera_post_type_featured', true);
			$classiera_post_type_premium = get_post_meta($post->ID, 'classiera_post_type_premium', true);

			$pay_per_post_product_id = get_post_meta($post->ID, 'pay_per_post_product_id', true);
			$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
			$post_web_url = get_post_meta($post->ID, 'post_web_url', true);
			$post_web_url_txt = get_post_meta($post->ID, 'post_web_url_txt', true);
			$featured_post = "0";
			$post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
			$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
			$todayDate = strtotime(date('d/m/Y H:i:s'));
			$expireDate = strtotime($post_price_plan_expiration_date); 
			if(!empty($post_price_plan_activation_date)) {
				if(($todayDate < $expireDate) or empty($post_price_plan_expiration_date)) {
					$featured_post = "1";
				}
			}
			if(empty($post_latitude)) {
				$post_latitude = 0;
			}
			if(empty($post_longitude)) {
				$post_longitude = 0;
				$mapZoom = 2;
			}else{
				$mapZoom = 16;
			}
			if ( has_post_thumbnail() ) {
				$post_thumbnail = get_the_post_thumbnail_url($current_post, 'thumbnail');

			}
		}/*If Query Post and Get Post is same*/
	}
endwhile; endif;
wp_reset_query();
$imgargs = array(
	'post_parent' => $current_post,
	'post_status' => 'inherit',
	'post_type'   => 'attachment', 
	'post_mime_type'   => 'image', 
	'order' => 'ASC',
	'orderby' => 'menu_order',
);
$attachments = get_children($imgargs);
/*==========================
Submit Form
===========================*/
if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
	if(trim($_POST['postTitle']) === '') {
		$postTitleError =  esc_html__( 'Please select a title.', 'classiera' );
		$hasError = true;
		$hasErrorTitle = true;
	}else{
		$postTitle = trim($_POST['postTitle']);
	}
	if(empty($_POST['cat']) || $_POST['cat'] === '-1'){
		$catError =  esc_html__( 'Please select a category.', 'classiera' );
		$hasError = true;
	}
	if(empty($_POST['dittjur_rules'])){
		$errorMsg = esc_html__('Please check the terms and condition');
		$hasError = true;
	}
	if(empty($_POST['post_old_price'])){
		$errorMsg = esc_html__('Please add price to publish ad');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 70 && $_POST['post_price'] < 1000){				
		$errorMsg = esc_html__('Your ads price should be more then 1000');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 71 && $_POST['post_price'] < 500){
		$errorMsg = esc_html__('Your add price should ne more then 500');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 70 && empty($_POST['price_confirm_dog'])){
		$errorMsg = esc_html__('You should verify Dog price to proceed');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 71 && empty($_POST['price_confirm_cat'])){
		$errorMsg = esc_html__('You should verify Cat price to proceed');
		$hasError = true;
		$hasErrorVerify = true;
	}

	if($_POST['cat'] == 70 && !empty($_POST['post_price']) < 1000){				
		$errorMsg = esc_html__('Your ads price should be more then 1000');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 71 && !empty($_POST['post_price']) < 500){
		$errorMsg = esc_html__('Your add price should ne more then 500');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 70 && empty($_POST['price_confirm_dog'])){
		$errorMsg = esc_html__('You should verify Dog price to proceed');
		$hasError = true;
		$hasErrorVerify = true;
	}
	if($_POST['cat'] == 71 && empty($_POST['price_confirm_cat'])){
		$errorMsg = esc_html__('You should verify Cat price to proceed');
		$hasError = true;
		$hasErrorVerify = true;
	}
	/*==========================
	If Use have insert title and 
	have select category then we will
	send form data.
	===========================*/
	if($hasError == false) {
		if(isset($_POST['classiera_post_type'])){
			$classieraPostType = $_POST['classiera_post_type'];	
		}		
		/*==========================
		Decide Post status
		===========================*/
		if(is_super_admin() ){
			$postStatus = 'publish';
		}elseif(!is_super_admin()){	
			if($redux_demo['post-options-edit-on'] == 1){
				$postStatus = 'private';
			}else{
				$postStatus = $_POST['post_status'];
			}
			if($classieraPostType == 'payperpost'){
				$postStatus = 'pending';
			}
		}
		/*==========================
		Check Category
		===========================*/
		$mCatID = $_POST['cat'];
		$classieraGetCats = classiera_get_cats_on_edit($mCatID);
		$categoriesID = get_ancestors($mCatID, 'category', 'taxonomy');
		if(!empty($categoriesID)){
			$cats = "";
			foreach ($categoriesID as $id) {
				$cats .= $id.', ';	
			}
			$catsString = $cats.$mCatID;
			$catsArray = explode(",", $catsString);
		}else{
			$catsArray = array($mCatID);
		}
		$post_main_cat = $classieraGetCats['post_main_cat'];
		$post_child_cat = $classieraGetCats['post_child_cat'];
		$post_inner_cat = $classieraGetCats['post_inner_cat'];
		$post_date = $_POST['classiera_post_date'];	
		$post_information = array(
			'ID' => $current_post,
			'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
			'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video>'),
			'post-type' => 'post',
			'post_date' => $post_date,
			'post_category' => $catsArray,
	        'tags_input'    => explode(',', $_POST['post_tags']),
			'post_author' => $_POST['postAuthor'],
			'post_status' => $postStatus,
			'comment_status' => 'open',
			'ping_status' => 'open',
		);
		$post_id = wp_insert_post($post_information);
		/*==========================
		Collect Post Custom Fields values
		===========================*/
		
		$catID = $mCatID.'custom_field';
		$custom_fields = $_POST[$catID];
		
		/*==========================
		Get Country Name
		===========================*/
		$postCounty = '';
		if(isset($_POST['post_location'])){
			$postLo = $_POST['post_location'];
			$args = array(
				'include' => $postLo,
				'post_type' => 'countries',
				'orderby' => 'post__in',
				'posts_per_page' => -1,
				'suppress_filters' => false,
			);
			$allCountry = get_posts($args);
			foreach( $allCountry as $country_post ){
				$postCounty = $country_post->post_title;
			}
		}		
		if(isset($_POST['classiera_CF_Front_end'])){
			$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];
		}
		if(isset($_POST['classiera_sub_fields'])){
			$classiera_sub_fields = $_POST['classiera_sub_fields'];
		}
		if(isset($_POST['new_featured'])){
			$new_featured = $_POST['new_featured'];
		}
		if(isset($new_featured) && !empty($new_featured)){
			update_post_meta($post_id, '_thumbnail_id', $new_featured);
		}
		if(isset($_POST['post_category_type'])){
			update_post_meta($post_id, 'post_category_type', esc_attr( $_POST['post_category_type'] ) );
		}
		$postMultiTag = $_POST['post_currency_tag'];
		/*==========================
		Update Post meta
		===========================*/
		update_post_meta($post_id, 'custom_field', $custom_fields);
		if(isset($_POST['classiera_CF_Front_end'])){
			update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);
		}
		if(isset($_POST['classiera_sub_fields'])){
			update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
		}
		if(isset($_POST['post_whatsapp'])){
			update_post_meta($post_id, 'post_whatsapp', $_POST['post_whatsapp'], $allowed);
		}
		if(isset($_POST['classiera_ads_type'])){
			update_post_meta($post_id, 'classiera_ads_type', $_POST['classiera_ads_type'], $allowed);
		}
		if(isset($_POST['classiera_week_renewal'])){
			update_post_meta($post_id, 'classiera_week_renewal', $_POST['classiera_week_renewal'], $allowed);
		}
		if(isset($_POST['classiera_allow_bids'])){
			update_post_meta($post_id, 'classiera_allow_bids', $_POST['classiera_allow_bids'], $allowed);
		}
		if(isset($_POST['post_web_url'])){
			update_post_meta($post_id, 'post_web_url', $_POST['post_web_url'], $allowed);
		}
		if(isset($_POST['post_web_url_txt'])){
			update_post_meta($post_id, 'post_web_url_txt', $_POST['post_web_url_txt'], $allowed);
		}		
		update_post_meta($post_id, 'post_perent_cat', $post_main_cat, $allowed);
		update_post_meta($post_id, 'post_child_cat', $post_child_cat, $allowed);
		update_post_meta($post_id, 'post_inner_cat', $post_inner_cat, $allowed);
		update_post_meta($post_id, 'post_currency_tag', $postMultiTag, $allowed);
		if(isset($_POST['post_price'])){
			$post_price_status = trim($_POST['post_price']);
			update_post_meta($post_id, 'post_price', $post_price_status, $allowed);
		}		
		if(isset($_POST['post_old_price'])){
			$old_price_status = trim($_POST['post_old_price']);
			update_post_meta($post_id, 'post_old_price', $old_price_status, $allowed);
		}
		if(isset($_POST['post_phone'])){
			update_post_meta($post_id, 'post_phone', $_POST['post_phone'], $allowed);
		}
		if(isset($_POST['number_hide'])){
			update_post_meta($post_id, 'number_hide', $_POST['number_hide'], $allowed);
		}
		if(isset($_POST['post_state'])){
			$poststate = $_POST['post_state'];
			update_post_meta($post_id, 'post_state', wp_kses($poststate, $allowed));
		}
		if(isset($_POST['post_city'])){
			$postCity = $_POST['post_city'];
			update_post_meta($post_id, 'post_city', wp_kses($postCity, $allowed));
		}
		if(isset($_POST['address'])){
			update_post_meta($post_id, 'post_address', wp_kses($_POST['address'], $allowed));
		}
		update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));
		
		if(isset($_POST['latitude'])){
			$googleLat = $_POST['latitude'];
			if(empty($googleLat)){
				$latitude = $classieraLatitude;
			}else{
				$latitude = $googleLat;
			}
			update_post_meta($post_id, 'post_latitude', wp_kses($latitude, $allowed));
		}	
		if(isset($_POST['longitude'])){
			$googleLong = $_POST['longitude'];
			if(empty($googleLong)){
				$longitude = $classieraLongitude;
			}else{
				$longitude = $googleLong;
			}
			update_post_meta($post_id, 'post_longitude', wp_kses($longitude, $allowed));
		}		
		if(isset($_POST['video'])){
			update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);
		}
		if(isset($_POST['featured-image'])){
			update_post_meta($post_id, 'featured_img', $_POST['featured-image'], $allowed);
		}
		if(isset($_POST['item-condition'])){
			$itemCondition = $_POST['item-condition'];
			update_post_meta($post_id, 'item-condition', $itemCondition, $allowed);
		}
		if(isset($_POST['classiera_post_type'])){
			update_post_meta($post_id, 'classiera_post_type', $_POST['classiera_post_type'], $allowed);
		}
		if(isset($_POST['classiera_post_type_premium'])){
			update_post_meta($post_id, 'classiera_post_type_premium', $_POST['classiera_post_type_premium'], $allowed);
		}
		if(isset($_POST['classiera_post_type_featured'])){
			update_post_meta($post_id, 'classiera_post_type_featured', $_POST['classiera_post_type_featured'], $allowed);
			update_post_meta($post_id, 'featured_post', "1" );
		}		
		if(isset($_POST['pay_per_post_product_id'])){
			update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
		}
		if(isset($_POST['days_to_expire'])){
			update_post_meta($post_id, 'days_to_expire', $_POST['days_to_expire'], $allowed);
		}		
		if(isset($_POST['classiera_featured_img'])){
			$imageID = $_POST['classiera_featured_img'];
			set_post_thumbnail( $post_id, $imageID );
		}
		if($classieraPostType == 'payperpost'){
			$permalink = $classieraProfileURL;
		}else{
			$permalink = get_permalink( $post_id );
		}
		/*==========================
		Paid Post Values
		===========================*/
		if(trim($_POST['classiera_post_type']) != 'classiera_regular'){
			if($_POST['classiera_post_type'] == 'payperpost'){
				/*==========================
				Do Nothing for Pay Per post
				===========================*/
			}elseif($_POST['classiera_post_type'] == 'classiera_regular_with_plan'){
				/*==========================
				Regular ad post with plans
				===========================*/
				$classieraPlanID = trim($_POST['regular_plan_id']);
				global $wpdb;
				$current_user = wp_get_current_user();
				$userID = $current_user->ID;				
				$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id =%d", $classieraPlanID));
				if($result){
					$tablename = $wpdb->prefix . 'classiera_plans';
					$newRegularUsed = $info->regular_used +1;
					$update_data = array('regular_used' => $newRegularUsed);
					$where = array('id' => $classieraPlanID);
					$update_format = array('%s');
					$wpdb->update($tablename, $update_data, $where, $update_format);
				}
			}else{
				/*==========================
				Featured Ad Posting
				===========================*/
				$featurePlanID = trim($_POST['classiera_post_type']);
				global $wpdb;
				$current_user = wp_get_current_user();
				$userID = $current_user->ID;				
				$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id =%d", $featurePlanID));
				if ($result){
					$featuredADS = 0;
					$tablename = $wpdb->prefix . 'classiera_plans';
					foreach ( $result as $info ){
						$totalAds = $info->ads;
						if (is_numeric($totalAds)){
							$totalAds = $info->ads;
							$usedAds = $info->used;
							$infoDays = $info->days;
						}
						if($totalAds == 'unlimited'){
							$availableADS = 'unlimited';
						}else{
							$availableADS = $totalAds-$usedAds;
						}
						if($usedAds < $totalAds && $availableADS != "0" || $totalAds == 'unlimited'){
							global $wpdb;
							$newUsed = $info->used +1;
							$update_data = array('used' => $newUsed);
							$where = array('id' => $featurePlanID);
							$update_format = array('%s');
							$wpdb->update($tablename, $update_data, $where, $update_format);
							update_post_meta($post_id, 'post_price_plan_id', $featurePlanID );
							
							$dateActivation = date('m/d/Y H:i:s');
							update_post_meta($post_id, 'post_price_plan_activation_date', $dateActivation );
							
							$daysToExpire = $infoDays;
							$dateExpiration_Normal = date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days"));
							update_post_meta($post_id, 'post_price_plan_expiration_date_normal', $dateExpiration_Normal );
							
							$dateExpiration = strtotime(date("m/d/Y H:i:s", strtotime("+ ".$daysToExpire." days")));
							update_post_meta($post_id, 'post_price_plan_expiration_date', $dateExpiration );
							update_post_meta($post_id, 'featured_post', "1" );
						}
					}
				}
			}
		}
		/*==========================
		Upload attachment
		===========================*/
		if(isset($_POST['attachedids'])){
			$attachedids = $_POST['attachedids'];
			$count = 1;
			foreach($attachedids as $ids){
				if($count == 1){
					set_post_thumbnail( $post_id, $ids );
				}
				wp_update_post( array(
						'ID' => $ids,
						'post_parent' => $post_id
					)
				);
				$count++;
			}
		}
		if ( isset($_FILES['upload_attachment']) ) {
			$count = 0;
			$files = $_FILES['upload_attachment'];
			foreach ($files['name'] as $key => $value) {				
				if ($files['name'][$key]) {
					$file = array(
						'name'     => $files['name'][$key],
						'type'     => $files['type'][$key],
						'tmp_name' => $files['tmp_name'][$key],
						'error'    => $files['error'][$key],
						'size'     => $files['size'][$key]
					);
					$_FILES = array("upload_attachment" => $file);
					
					foreach ($_FILES as $file => $array){								
						$featuredimg = $_POST['classiera_featured_img'];
						if($count == $featuredimg){
							$attachment_id = classiera_insert_attachment($file,$post_id);
							set_post_thumbnail( $post_id, $attachment_id );
						}else{
							$attachment_id = classiera_insert_attachment($file,$post_id);
						}								
						$count++;
					}
					
				}						
			}/*== Foreach ==*/
		}
		if (isset($_POST['att_remove'])) {
			foreach ($_POST['att_remove'] as $att_id){
				wp_delete_attachment($att_id);
			}
		}
		wp_redirect( $permalink ); exit;
	}/*If there is no error*/
}
get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>
<section class="user-pages section-gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' ); ?>
			</div><!--col-lg-3 col-md-4-->
			<div class="col-lg-9 col-md-8 user-content-height">
			    <?php if($hasError == true){ ?>
					<div class="alert alert-warning" role="alert">
					    <p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
						<?php echo esc_html($errorMsg); ?>
						<p>
					</div>
				<?php } ?>
				<div class="submit-post section-bg-white classiera_edit__post">
					<form class="form-horizontal" action="" role="form" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
						<h4 class="text-uppercase border-bottom">
							<?php esc_html_e('EDIT YOUR AD', 'classiera') ?>
						</h4>
						<?php 
						$post_id = $_GET['post'];
						$author = get_post_field ('post_author', $post_id);
						$postStatus = get_post_status($post_id);
						?>
						<input type="hidden" id="postAuthor"  name="postAuthor" value="<?php echo esc_attr($author); ?>">
						<input type="hidden" id="postAuthor"  name="post_status" value="<?php echo esc_attr($postStatus); ?>">
						<input type="hidden" id="classiera_post_date" name="classiera_post_date" value="<?php echo esc_attr( $classieraPostDate ); ?>">
						
						<div class="form-main-section post-detail">
							<!-- <h4 class="text-uppercase border-bottom">
								<?php esc_html_e('Ad Details', 'classiera') ?> :
							</h4> -->
							<div class="classiera-post-cat">
								<div class="form-group">
									<label class="col-sm-3 text-left flip">
										<?php esc_html_e('Select a Category', 'classiera') ?> :
									</label>
									<div class="col-sm-9">
										<select id="cat" class="postform" name="cat">
											<option value="All" disabled>
												<?php esc_html_e('Select Category..', 'classiera') ?>
											</option>
											<?php 
											$currCatID = $category_id;
											if( array_intersect($excludeCatsUsers, $current_user->roles ) ) {
												$argscat = array(
													'hide_empty' => 0,
													'parent' => 0,
													'order' => 'ASC',
													'exclude' => $excludeCats,
												);
											}else{
												$argscat = array(
													'hide_empty' => 0,
													'parent' => 0,
													'order' => 'ASC',
												);
											}
											$categories = get_categories($argscat);
											foreach ($categories as $cat){
												if($cat->category_parent == 0){
													$catID = $cat->cat_ID;
													?>
													<?php if(!empty($_POST['cat'])){ ?>
														<option <?php if($_POST['cat'] == $catID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">
															<?php echo esc_attr($cat->cat_name); ?>
														</option>
													<?php }else{ ?>
													<option <?php if($currCatID == $catID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">
														<?php echo esc_attr($cat->cat_name); ?>
													</option>
													<?php } ?>
													<?php
													$args2 = array(
														'hide_empty' => '0',
														'parent' => $catID,
													);
													$subcategories = get_categories($args2);
													foreach($subcategories as $cat){
														$catSubID = $cat->cat_ID;
														?>
														<option <?php if($currCatID == $cat->cat_ID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">-- 
															<?php echo esc_attr($cat->cat_name); ?>
														</option>
														<?php
														$args3 = array(
															'hide_empty' => '0',
															'parent' => $catSubID,
														);
														$thirdlevelcategories = get_categories($args3);
														foreach($thirdlevelcategories as $cat){
															?>
															<option <?php if($currCatID == $cat->cat_ID){echo "selected";} ?> value="<?php echo esc_attr($cat->cat_ID); ?>">---
																<?php echo esc_attr($cat->cat_name); ?>
															</option>
															<?php
														}
													}
												}
											}
											?>
										</select>
									</div>
								</div><!--classiera-post-main-cat-->
							</div><!--form-main-section-->
							<?php 
							if($classiera_ads_typeOn == 1){								
								$classieraShowSell = $adsTypeShow[1];
								$classieraShowBuy = $adsTypeShow[2];
								$classieraShowRent = $adsTypeShow[3];
								$classieraShowHire = $adsTypeShow[4];
								$classieraShowFound = $adsTypeShow[5];
								$classieraShowFree = $adsTypeShow[6];
								$classieraShowEvent = $adsTypeShow[7];
								$classieraShowServices = $adsTypeShow[8];
								$classieraShowexchange = $adsTypeShow[9];
								?>
								<div class="form-group">
									<label class="col-sm-3 text-left flip">
										<?php esc_html_e('Type of Ad', 'classiera') ?> : <span>*</span>
									</label>
									<div class="col-sm-9">
										<div class="radio">	
										<?php if($classieraShowSell == 1){ ?>	
											<input id="sell" type="radio" value="sell" name="classiera_ads_type" <?php if($classiera_ads_type == 'sell'){echo "checked";}?>>
											<label for="sell"><?php esc_html_e('I want to sell', 'classiera') ?></label>
										<?php } ?>
										<?php if($classieraShowBuy == 1){ ?>
											<input id="buy" type="radio" value="buy" name="classiera_ads_type" <?php if($classiera_ads_type == 'buy'){echo "checked";}?>>
											<label for="buy"><?php esc_html_e('I want to buy', 'classiera') ?></label>
										<?php } ?>	
										<?php if($classieraShowRent == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="rent" id="rent" <?php if($classiera_ads_type == 'rent'){echo "checked";}?>>
											<label for="rent"><?php esc_html_e('I want to rent', 'classiera') ?></label>
										<?php } ?>
										<?php if($classieraShowHire == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="hire" id="hire" <?php if($classiera_ads_type == 'hire'){echo "checked";}?>>
											<label for="hire"><?php esc_html_e('I want to hire', 'classiera') ?></label>
										<?php } ?>	
										<!--Lost and Found-->
										<?php if($classieraShowFound == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="lostfound" id="lostfound" <?php if($classiera_ads_type == 'lostfound'){echo "checked";}?>>
											<label for="lostfound"><?php esc_html_e('Lost & Found', 'classiera') ?></label>
										<?php } ?>
										<!--Lost and Found-->
										<!--Free-->
										<?php if($classieraShowFree == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="free" id="typefree" <?php if($classiera_ads_type == 'free'){echo "checked";}?>>
											<label for="typefree"><?php esc_html_e('I want to give for free', 'classiera') ?></label>
										<?php } ?>
										<!--Free-->
										<!--Event-->
										<?php if($classieraShowEvent == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="event" id="event" <?php if($classiera_ads_type == 'event'){echo "checked";}?>>
											<label for="event"><?php esc_html_e('I am an event', 'classiera') ?></label>
										<?php } ?>
										<!--Event-->
										<!--Professional service-->
										<?php if($classieraShowServices == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="service" id="service" <?php if($classiera_ads_type == 'service'){echo "checked";}?>>
											<label for="service">
												<?php esc_html_e('Professional service', 'classiera') ?>
											</label>
										<?php } ?>
										<!--exchange-->
										<?php if($classieraShowexchange == 1){ ?>
											<input type="radio" name="classiera_ads_type" value="exchange" id="exchange" <?php if($classiera_ads_type == 'exchange'){echo "checked";}?>>
											<label for="exchange">
												<?php esc_html_e('Exchange', 'classiera') ?>
											</label>
										<?php } ?>
										<!--exchange-->
											<input id="sold" type="radio" value="sold" name="classiera_ads_type" <?php if($classiera_ads_type == 'sold'){echo "checked";}?>>
											<label for="sold"><?php esc_html_e('Sold', 'classiera') ?></label>
										</div>
									</div>
								</div><!--Type of Ad-->
							<?php }	?>
							<!--Ad title-->
							<div class="form-group">
								<label class="col-sm-3 text-left flip" for="title">
									<?php esc_html_e('Ad title', 'classiera') ?> : <span>*</span>
								</label>
								<div class="col-sm-9">
									<input id="title" data-minlength="5" name="postTitle" type="text" class="form-control form-control-md" value="<?php echo isset($_POST["postTitle"]) ? $_POST["postTitle"] : esc_html($title); ?>" placeholder="<?php esc_attr_e('Ad Title Goes here', 'classiera') ?>" required>
									<div class="help-block"><?php esc_html_e('type minimum 5 characters', 'classiera') ?></div>
								</div><!--col-sm-9-->
								<?php if($hasErrorTitle == true){ ?>
        						<div class="alert alert-warning" role="alert">
        							<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
        								<?php echo esc_html($errorMsg); ?>
      								<p>
    							</div>
      							<?php } ?>
							</div>
							<!--Ad title-->
							<!--Ad Description-->
							<div class="form-group">
								<label class="col-sm-3 text-left flip" for="description">
									<?php esc_html_e('Ad description', 'classiera') ?> : <span>*</span>
								</label>
								<div class="col-sm-9">
									<textarea name="postContent" id="description" class="form-control" data-error="<?php esc_attr_e('Write description', 'classiera') ?>" required><?php echo isset($_POST["postContent"]) ? $_POST["postContent"] : esc_html($content); ?></textarea>
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<!--Ad Description-->
							<!--Ad Tags-->
							<div class="form-group">
								<label class="col-sm-3 text-left flip"><?php esc_html_e('Keywords', 'classiera') ?> : </label>
								<div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-sm-12">
											<div class="input-group">
												<div class="input-group-addon"><i class="fas fa-tags"></i></div>
												<?php 
												echo "<input type='text' id='post_tags' placeholder='".esc_html__('enter keywords for better search..!', 'classiera')."' name='post_tags' value='";
												$posttags = get_the_tags($current_post);
												if ($posttags) {
													foreach($posttags as $tag) {
														$tags_list = $tag->name . ', ';
														echo esc_html($tags_list);
													}
												}
												echo "' size='' maxlength='' class='form-control form-control-md'>";
												?>
											</div>
										</div>
									</div><!--form-inline row-->
									<div class="help-block">
										<?php esc_html_e('Tags example: ads, car, cat, business', 'classiera') ?>
									</div>
								</div><!--col-sm-9-->
							</div>
							<!--Ad Tags-->
							<!--Ad Price-->
							<?php if($classieraPriceSecOFF == 1){ ?>
							<div class="form-group classiera_hide_price">
								<label class="col-sm-3 text-left flip"><?php esc_html_e('Ad price', 'classiera') ?> : </label>
								<div class="col-sm-9">
									<div class="form-inline row">
										<?php if($classieraMultiCurrency == 'multi'){?>
										<div class="col-sm-12">
											<div class="inner-addon right-addon input-group price__tag">
												<div class="input-group-addon">
													<span class="currency__symbol">
														<?php echo classiera_Display_currency_sign($classieraTagDefault); ?>
													</span>
												</div>
												<i class="form-icon right-form-icon fas fa-angle-down"></i>
												<?php echo classiera_Select_currency_dropdow($classieraTagDefault); ?>
											</div>
										</div>
										<?php } ?>
										<!--Regular Price-->
										<?php if($regularpriceon == 1){ ?>
										<div class="col-sm-6">
											<div class="input-group">
												<!-- <div class="input-group-addon">
													<span class="currency__symbol">
														<?php 
														if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
															echo esc_html($postCurrency);
														}elseif($classieraMultiCurrency == 'multi'){
															echo classiera_Display_currency_sign($classieraTagDefault);
														}else{
															echo "&dollar;";
														}
														?>
													<span>
												</div> -->
												<input type="text" name="post_old_price" value="<?php echo isset($_POST["post_old_price"]) ? $_POST["post_old_price"] : esc_attr($post_old_price); ?>" class="form-control form-control-md" placeholder="<?php esc_attr_e('Price', 'classiera') ?>" readonly>
											</div>
										</div>
										<?php } ?>
										<div class="col-sm-6">
											<div class="input-group">
												<!-- <div class="input-group-addon">
													<span class="currency__symbol">
														<?php 
														if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
															echo esc_html($postCurrency);
														}elseif($classieraMultiCurrency == 'multi'){
															echo classiera_Display_currency_sign($classieraTagDefault);
														}else{
															echo "&dollar;";
														}
														?>
													</span>
												</div> -->
												<input type="text" name="post_price" value="<?php echo isset($_POST["post_price"]) ? $_POST["post_price"] : esc_html($post_price); ?>" class="form-control form-control-md" placeholder="<?php esc_attr_e('Lowered price', 'classiera') ?>">
											</div>
										</div><!--col-sm-6-->
										
									</div><!--form-inline row-->
									<?php if (!empty($postCurrency)){?>
									<!--<div class="help-block">-->
									<!--	<?php esc_html_e('Currency sign is already set as', 'classiera') ?>&nbsp;<?php echo esc_html($postCurrency); ?>&nbsp;<?php esc_html_e('Please do not use currency sign in the price field. Only use numbers, ex: 12345.', 'classiera') ?>-->
									<!--</div>-->
									<?php } ?>
								</div><!--col-sm-9-->
							</div>
							<?php } ?>
							<!--Ad Price-->
							<!-- categories Price condition -->
							<div class="form-group <?php if($category_id != 70){ echo "hidden";} ?> " id="dog_price">
								<label class="col-sm-3 text-left flip" for="description"></label>
								<div class="checkbox col-sm-9">
										<input type="checkbox" name="price_confirm_dog" id="price_confirm_dog" value="confirm"  data-error="<?php esc_attr_e('Please check the price confirm box', 'classiera') ?>">
									<label for="price_confirm_dog">
										<?php esc_html_e('I certify that the dog at the time of sale is at least 8 weeks old and has a price of at least SEK 1,000.', 'classiera') ?>
									</label>
								</div>
							</div>
							<div class="form-group <?php if($category_id != 71){ echo "hidden";} ?> " id="cat_price">
								<label class="col-sm-3 text-left flip" for="description"></label>
								<div class="checkbox col-sm-9">
									
										<input type="checkbox" name="price_confirm_cat" id="price_confirm" value="confirm"  data-error="<?php esc_attr_e('Please check the price confirm box', 'classiera') ?>">
									<label for="price_confirm">
										<?php esc_html_e('I certify that the cat at the time of sale is at least 12 weeks old and has a price of at least SEK 500.', 'classiera') ?>
									</label>
								</div>
							</div>
							<?php if($hasErrorVerify == true){ ?>
            						<div class="alert alert-warning" role="alert">
            							<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
            								<?php echo esc_html($errorMsg); ?>
          								<p>
        								</div>
        							<?php } ?>
							<!-- categories price conmdition end -->
							<!--Bidding System-->
							<?php if($classiera_bid_system == true){ ?>
							<div class="form-group">
								<label class="col-sm-3 text-left flip">
									<?php esc_html_e('Bidding', 'classiera') ?> : <span>*</span>
								</label>
								<div class="col-sm-9">
									<div class="radio">
										<input id="allowbid" value="allow" type="radio" name="classiera_allow_bids" <?php if($classiera_allow_bids == 'allow'){ echo "checked"; }?>>
										<label for="allowbid">
											<?php esc_html_e('Allow users to bid on this ad.', 'classiera') ?>
										</label>
										<input id="disallowbid" value="disallow" type="radio" name="classiera_allow_bids" <?php if($classiera_allow_bids == 'disallow'){ echo "checked"; }?>>
										<label for="disallowbid">
											<?php esc_html_e('Disallow bids from this ad.', 'classiera') ?>
										</label>
									</div><!--radio-->
									<div class="help-block"><?php esc_html_e('From here you can disable user bidding option on your current ad.', 'classiera') ?></div>
								</div><!--col-sm-9-->
							</div><!--form-group-->
							<?php } ?>
							<!--Bidding System-->
							<!--ContactPhone-->
							<!--<?php //if($classieraAskingPhone == 1){ ?>-->
							<div class="form-group">
								<label class="col-sm-3 text-left flip">
									<?php esc_html_e('Your Phone/Mobile', 'classiera') ?> :
								</label>
								<div class="col-lg-7 col-sm-7">
									<div class="form-inline row">
										<div class="col-sm-12">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-mobile-alt"></i>
												</div>
												<input type="text" name="post_phone" value="<?php echo isset($_POST["post_phone"]) ? $_POST["post_phone"] : esc_html($post_phone); ?>" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your phone number or Mobile number', 'classiera') ?>">
											</div><!--input-group-->
										</div><!--col-sm-12-->
									</div><!--form-inline row-->
									<!--<div class="help-block"><?php esc_html_e('It is not required, but if you enter your phone number here, it will be shown publicly.', 'classiera') ?></div>-->
								</div><!--col-sm-9-->
								<div class="checkbox col-sm-2 col-lg-2">
                            		<input type="checkbox" name="number_hide" id="number_hide" value="1" <?php if($number_hide == 1){ echo "checked"; } ?> data-error="hide in the ad">
                            		<label for="number_hide">hide in the ad                            		</label>
                            	</div>
							</div><!--form-group-->
							<!--<?php //} ?>-->
							<!--ContactPhone-->
							<?php if($post_whatsapp_on == true){ ?>
							<!--WhatsAPP-->
							<div class="form-group">
								<label class="col-sm-3 text-left flip"><?php esc_html_e('Your WhatsApp', 'classiera') ?> :</label>
								<div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-sm-12">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fab fa-whatsapp"></i>
												</div>
												<input type="text" name="post_whatsapp" class="form-control form-control-md" placeholder="<?php esc_attr_e('WhatsApp number (Ex:+1234567)', 'classiera') ?>" value="<?php echo esc_html($post_whatsapp); ?>">
											</div>
										</div>
									</div>
									<div class="help-block"><?php esc_html_e('Enter your WhatsApp number in international format (Ex:+123456789) , It&rsquo;s not required, but if you enter your WhatsApp number here, it will be shown publicly.', 'classiera') ?></div>
								</div>
							</div>
							<!--WhatsAPP-->
							<?php } ?>
							<!--Website URL-->
							<?php if($classiera_post_web_url == true){ ?>
							<div class="form-group">
								<label class="col-sm-3 text-left flip">
									<?php esc_html_e('Website URL:', 'classiera') ?>
								</label>
								<div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-sm-6">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fas fa-link"></i>
												</div>
												<input type="text" name="post_web_url" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your website URL', 'classiera') ?>" value="<?php echo esc_url($post_web_url); ?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fas fa-font"></i>
												</div>
												<input type="text" name="post_web_url_txt" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter URL title', 'classiera') ?>" value="<?php echo esc_html($post_web_url_txt); ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
							<!--Website URL-->	
							<!--Item Condition-->
							<?php if($adpostCondition == 1){ ?>
								<div class="form-group">
									<label class="col-sm-3 text-left flip">
										<?php esc_html_e('Item Condition', 'classiera') ?> : <span>*</span>
									</label>
									<div class="col-sm-9">
										<div class="radio">
											<input id="new" type="radio" name="item-condition" value="new" name="item-condition" <?php if($itemCondition == 'new'){echo "checked";}?>>
											<label for="new"><?php esc_html_e('Brand New', 'classiera') ?></label>
											<input id="used" type="radio" name="item-condition" value="used" name="item-condition" <?php if($itemCondition == 'used'){echo "checked";}?>>
											<label for="used"><?php esc_html_e('Used', 'classiera') ?></label>
										</div>
									</div>
								</div><!--Item condition-->
							<?php } ?>
							<!--Item Condition-->
						</div><!--form-main-section-->
						<!--CustomDetails-->
						<div class="classieraExtraFields">
							<?php 
							$thisCatID = $category_id;
							$classieraCategoryFields = '';
							$classieraCategoryFieldsType = '';
							$thisCatName = get_cat_name( $thisCatID );
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if(isset($tag_extra_fields[$thisCatID]['category_custom_fields'])){
								$classieraCategoryFields = $tag_extra_fields[$thisCatID]['category_custom_fields'];
							}
							if(isset($tag_extra_fields[$thisCatID]['category_custom_fields_type'])){
								$classieraCategoryFieldsType = $tag_extra_fields[$thisCatID]['category_custom_fields_type'];
							}							
							if(empty($classieraCategoryFields)) {								
								$catobject = get_category($thisCatID, false);
								$parentcat = $catobject->category_parent;
								if(!empty($parentcat) || $parentcat != 0){
									if(isset($tag_extra_fields[$parentcat]['category_custom_fields'])){
										$classieraCategoryFields = $tag_extra_fields[$parentcat]['category_custom_fields'];
									}
									if(isset($tag_extra_fields[$parentcat]['category_custom_fields_type'])){
										$classieraCategoryFieldsType = $tag_extra_fields[$parentcat]['category_custom_fields_type'];
									}									
								}
							}
							if(!empty($classieraCategoryFields)){ 
							?>
							<div class="form-main-section extra-fields wrap-content" id="cat-<?php echo esc_attr($thisCatID); ?>" <?php if($currCatID == $thisCatID) { ?>style="display: block;"<?php  } else { ?>style="display: none;"<?php } ?>>
								<?php $wpcrown_custom_fields = get_post_meta($current_post, 'custom_field', true);?>
								<h4 class="text-uppercase border-bottom">
									<?php esc_html_e('Extra Fields For', 'classiera') ?>&nbsp;
									<?php echo esc_attr($thisCatName);?> :
								</h4>
								<?php 
									for($i = 0; $i < (count($classieraCategoryFields)); $i++){ 
										if($classieraCategoryFieldsType[$i][1] == 'text'){
											?>
											<div class="form-group" id="cat-<?php echo esc_attr($thisCatID); ?>">
												<label class="col-sm-3 text-left flip"><?php echo esc_html($classieraCategoryFields[$i][0]); ?>: <span>*</span></label>
												<div class="col-sm-6">
													<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][0]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][0]" value="<?php echo esc_attr($classieraCategoryFields[$i][0]) ?>" size="12">
											
													<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][2]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][2]" value="<?php echo esc_attr($classieraCategoryFieldsType[$i][1]) ?>" size="12">
													
													<input type="text" placeholder="<?php if (!empty($classieraCategoryFields[$i][0])) echo esc_attr($classieraCategoryFields[$i][0]); ?>" class="form-control form-control-md" id="custom_field[<?php echo esc_attr($i); ?>][1]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][1]" value="<?php if($currCatID == $thisCatID) { echo esc_attr($wpcrown_custom_fields[$i][1]); } ?>" size="12">
												</div>
											</div>
											<?php
										}
									}
								?>
								<?php 
								/*If Custom Fields is dropdown*/
								for ($i = 0; $i < (count($classieraCategoryFields)); $i++) {
									if($classieraCategoryFieldsType[$i][1] == 'dropdown'){
								?>
									<div class="form-group" id="cat-<?php echo esc_attr($thisCatID); ?>">
										<label class="col-sm-3 text-left flip"><?php echo esc_html($classieraCategoryFields[$i][0]); ?>: <span>*</span></label>
										<div class="col-sm-6">
											<div class="inner-addon right-addon">
												<i class="form-icon right-form-icon fas fa-angle-down"></i>
												<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][0]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][0]" value="<?php echo esc_attr($classieraCategoryFields[$i][0]) ?>" size="12">
												<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][2]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][2]" value="<?php echo esc_attr($classieraCategoryFieldsType[$i][1]); ?>" size="12">
												
												<select class="form-control form-control-md" id="custom_field[<?php echo esc_attr($i); ?>][1]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][1]">
													<?php
													echo '<option value="">'.$classieraCategoryFields[$i][0].'</option>';
													$options = $classieraCategoryFieldsType[$i][2];
													$optionsarray = explode(',',$options);
													foreach($optionsarray as $option){
														if($wpcrown_custom_fields[$i][1] == $option){
															$selected = 'selected';
														}
														else{
															$selected = '';
														}
														echo '<option '.$selected.' value="'.$option.'">'.$option.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
								<?php } 
								}
								?>
								<?php 
								 for($i = 0; $i < (count($classieraCategoryFields)); $i++) {
									 if($classieraCategoryFieldsType[$i][1] == 'checkbox'){
										if($wpcrown_custom_fields[$i][1] == 'on'){
											$checked = 'checked';
										}else{
											$checked = '';
										} 
								?>
									<div class="form-group" id="cat-<?php echo esc_attr($thisCatID); ?>">
										<p class="featurehide featurehide<?php echo esc_attr($i); ?>"><?php esc_html_e('Select Features', 'classiera') ?></p>
										<div class="col-sm-6">
											<div class="inner-addon right-addon">
												<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][0]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][0]" value="<?php echo esc_attr($classieraCategoryFields[$i][0]); ?>" size="12">
												
												<input type="hidden" class="custom_field" id="custom_field[<?php echo esc_attr($i); ?>][2]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][2]" value="<?php echo esc_attr($classieraCategoryFieldsType[$i][1]); ?>" size="12">
												
												
												<div class="checkbox">
													<input type="checkbox" <?php echo esc_attr($checked); ?> class="custom_field custom_field_visible input-textarea newcehckbox" id="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][1]" name="<?php echo esc_attr($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][1]">
													<label for="<?php echo esc_html($thisCatID); ?>custom_field[<?php echo esc_attr($i); ?>][1]" class="newcehcklabel"><?php echo esc_attr($classieraCategoryFields[$i][0]); ?></label>
												</div>
											</div>
										</div>
									</div>
								<?php 
									}
								}
								?>	
							</div>
							<?php } ?>
						</div>
						<!--CustomDetails-->
						<!-- add photos and media -->
						<div class="form-main-section media-detail">
							<?php
							/*Image Count Check*/							
							global $wpdb;
							$current_user = wp_get_current_user();
							$userID = $current_user->ID;
							$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d ORDER BY id DESC", $author));
							$totalAds = 0;
							$usedAds = 0;
							$availableADS = '';
							if(!empty($result)){
								foreach ( $result as $info ) {
									$availAds = $info->ads;
									if(is_numeric($availAds)){
										$totalAds += $info->ads;
										$usedAds += $info->used;
									}									
								}
							}
							$availableADS = $totalAds-$usedAds;
							if($availableADS == "0" || empty($result)){
								$imageLimit = $regularIMG;
							}else{
								$imageLimit = $paidIMG;
							}
							?>
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Image', 'classiera') ?> :</h4>
							<div class="form-group">
								<label class="col-sm-3 text-left flip"><?php esc_html_e('Photos for your ad', 'classiera') ?> :</label>
								<div class="col-sm-9">
									
									<!--dropzone-->
									<div class="image_items_container">
										
										<?php for($i=1; $i<=$imageLimit; $i++) {
												
											echo '<div id="user_image_'.$i.'" class="user_image empty image">  
												
												<div class="centerer" data-trackable="add_image_clicked"> 
													<img class="image north" data-transform-rotation="0" data-scale="1" data-rotation="0" alt=""> 
													<div class="sprite_ai_camera_light image_icon"></div> 
													<div class="text"> 
														<span class="img_desc">choose picture</span> 
													</div> 
													<div style="position: absolute; overflow: hidden; opacity: 1; zoom: 1; width: 108px; height: 81px; z-index: 1; top: 0px; left: 0px;">
														<input style="border: none; position: relative; opacity: 0; cursor: pointer; top: -0.4375px; left: -79.5px;">
													</div>
												</div> 
												<span class="progress"></span> 
											</div>';
										  } ?>

									</div>
									<div class="dropzone dz-clickable mb-4" id="classiera_editdropzone" data-max-file="<?php echo esc_attr( $imageLimit ); ?>" data-max-size="<?php echo esc_attr($classiera_image_size);?>">
										<div class="dz-default dz-message hidden" data-dz-message="">
											<p class="text-center"><i class="far fa-images fa-3x"></i></p>
											<span><?php esc_html_e( 'Drop files here to upload', 'classiera' ); ?></span>
											<span><?php esc_html_e( 'or', 'classiera' ); ?></span>
											<strong>
												<?php esc_html_e( 'Click here', 'classiera' ); ?>
											</strong>
											<span><?php esc_html_e( 'to select images', 'classiera' ); ?></span>
											<p class="text-muted">(<?php esc_html_e( 'Your first image will be used as a featured image, and it will be shown as thumbnail.', 'classiera' ); ?>)</p>
										</div>
										<div class="dz-max-file-msg hidden">
											<div class="alert alert-danger text-center">
												<?php esc_html_e( 'We are sorry but your upload limit is reached.', 'classiera' ); ?>
												<?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images maximum.', 'classiera') ?>
											</div>
										</div>
										<div class="dz-remove" data-dz-remove>
											<span><?php esc_html_e('Remove', 'classiera') ?></span>
										</div>						
									</div>
									<p style="height:195px"></p>
									<!-- <p class="visible-xs visible-sm alert alert-warning classiera_img_info">
										<strong><?php esc_html_e('Alert', 'classiera') ?> :</strong>
										<?php esc_html_e('If you are using Opera, UC Browser, Firefox or KaiOS Mobile browser then you need to select images one by one, multi selection is not supported by these browsers.', 'classiera') ?>
									</p>
									<p class="alert alert-info classiera_img_info">
										<strong><?php esc_html_e('Note', 'classiera') ?> :</strong>
										<?php esc_html_e('You can upload maximum', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images .', 'classiera') ?>
										<?php esc_html_e('If you are posting a regular ad then select only', 'classiera') ?>&nbsp;<?php echo esc_attr( $regularIMG ); ?>&nbsp;<?php esc_html_e('images, otherwise you will not be able to post your ad.', 'classiera') ?>
									</p> -->
									<!--dropzone-->					
									<!--Video-->
									<?php 									
									if($classiera_video_postads == 1){
									?>
									<div class="iframe">
										<div class="iframe-heading">
											<i class="fas fa-video"></i>
											<span><?php esc_html_e('Paste an iframe or a video URL here.', 'classiera') ?></span>
										</div>
										<textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_attr_e('Put here iframe or video url.', 'classiera') ?>"><?php echo esc_html($post_video); ?></textarea>
										<div class="help-block">
											<p><?php esc_html_e('Add iframe or video URL (iframe 710x400). YouTube, Vimeo, etc.', 'classiera') ?></p>
										</div>
									</div>
									<?php } ?>
									<!--Video-->
								</div><!--col-sm-9-->
							</div>
						</div>
						<!-- add photos and media -->
						<!-- post location -->
						<?php if($classiera_ad_location_remove == 1){ ?>
						<div class="form-main-section post-location">
							<?php 
							$countryargs = array(
								'post_type' => 'countries',
								'posts_per_page' => -1,
								'suppress_filters' => false,
							);
							$country_posts = get_posts($countryargs);
							if(!empty($country_posts)){
							?>
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Location', 'classiera') ?> :</h4>
							<?php }							
							if(!empty($country_posts)){
								?>
							<!--Select Country-->
							<div class="form-group hidden">
								<label class="col-sm-3 text-left flip"><?php esc_html_e('Select Country', 'classiera') ?>: <span>*</span></label>
								<div class="col-sm-6">
									<div class="inner-addon right-addon">
										<i class="form-icon right-form-icon fas fa-angle-down"></i>
										<select name="post_location" id="post_location" class="form-control form-control-md">
											<option <?php if(empty($post_location)){ echo "selected"; }?> disabled value="">
												<?php esc_html_e('Select Country', 'classiera'); ?>
											</option>
											<?php 
											foreach( $country_posts as $country_post ){
												if($post_location == $country_post->post_title){
													$getStatesbyID = $country_post->ID;
												}
												?>
												<option <?php if($post_location == $country_post->post_title){ echo "selected"; }?> value="<?php echo esc_attr($country_post->ID); ?>"><?php echo esc_html($country_post->post_title); ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<?php } ?>
							<!--Select Country-->	
							<!--Select States-->
							<?php 							
							if($locationsStateOn == 1){
								if($classiera_locations_input == 'input'){
									?>
									<div class="form-group">
										<label class="col-sm-3 text-left flip">
											<?php esc_html_e('State', 'classiera'); ?> :
										</label>
										<div class="col-sm-9">
											<div class="form-inline row">
												<div class="col-sm-12">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fas fa-globe"></i>
														</div>
														<input type="text" name="post_state" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your state name', 'classiera') ?>" value="<?php echo esc_attr($post_state); ?>">
													</div><!--input-group-->
												</div><!--col-sm-12-->
											</div><!--form-inline row-->
										</div><!--col-sm-9-->
									</div><!--form-group-->
									<?php
								}else{
								?>
								<div class="form-group">
									<label class="col-sm-3 text-left flip"><?php esc_html_e('Location', 'classiera') ?>: <span>*</span></label>
									<div class="col-sm-6">
										<div class="inner-addon right-addon">
											<i class="form-icon right-form-icon fas fa-angle-down"></i>
											<select name="post_state" id="post_state" class="selectState form-control form-control-md" required>
												<option value="" disabled>
													<?php esc_html_e('Select State', 'classiera'); ?>
												</option>
												<?php 
												if (function_exists('classiera_get_states_by_country_id')) {
													echo classiera_get_states_by_country_id($getStatesbyID, $post_state);
												}											
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
							<!--Select States-->
							<!--Select City-->
							<?php 							
							if($locationsCityOn == 1){
								if($classiera_locations_input == 'input'){
									?>
									<div class="form-group">
										<label class="col-sm-3 text-left flip">
											<?php esc_html_e('City', 'classiera'); ?> :
										</label>
										<div class="col-sm-9">
											<div class="form-inline row">
												<div class="col-sm-12">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fas fa-globe"></i>
														</div>
														<input type="text" name="post_city" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your city name', 'classiera') ?>" value="<?php echo esc_attr($post_city); ?>">
													</div><!--input-group-->
												</div><!--col-sm-12-->
											</div><!--form-inline row-->
										</div><!--col-sm-9-->
									</div><!--form-group-->
									<?php
								}else{
								?>
								<div class="form-group">
									<label class="col-sm-3 text-left flip"><?php esc_html_e('Select Muncipality', 'classiera'); ?>: <span>*</span></label>
									<div class="col-sm-6">
										<div class="inner-addon right-addon">
											<i class="form-icon right-form-icon fas fa-angle-down"></i>
											<select name="post_city" id="post_city" class="selectCity form-control form-control-md" required>
												<option disabled><?php esc_html_e('Select Muncipality', 'classiera'); ?></option>
												<?php 
												if (function_exists('classiera_get_cities_by_state')) {
													echo classiera_get_cities_by_state($post_state, $post_city);
												}											
												?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
							<!--Select City-->
							<!--Address-->
							<?php if($classieraAddress == 1){?>
								<div class="form-group">
									<label class="col-sm-3 text-left flip"><?php esc_html_e('Address', 'classiera'); ?> : <span>*</span></label>
									<div class="col-sm-9">
										<input id="address" type="text" name="address" value="<?php echo esc_html($post_address); ?>" class="form-control form-control-md" placeholder="<?php esc_attr_e('Address or City', 'classiera') ?>" required>
									</div>
								</div>
							<?php } ?>
							<!--Address-->
							<!--Google Value-->
							<div class="form-group">
								<?php if($googleFieldsOn == 1){ ?>
									<label class="col-sm-3 text-left flip"><?php esc_html_e('Set Latitude & Longitude', 'classiera') ?> : <span>*</span></label>
								<?php } ?>
								<div class="col-sm-9">
									<?php  if($googleFieldsOn == 1){ ?>
										<div class="form-inline row">
											<div class="col-sm-6">
												<div class="input-group">
													<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
													<input type="text" name="latitude" id="latitude" value="<?php echo esc_attr($post_latitude); ?>" class="form-control form-control-md" placeholder="<?php esc_attr_e('Latitude', 'classiera') ?>">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group">
													<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
													<input type="text" name="longitude" value="<?php echo esc_attr($post_longitude); ?>" id="longitude" class="form-control form-control-md" placeholder="<?php esc_attr_e('Longitude', 'classiera') ?>">
												</div>
											</div>
										</div>
									<?php }else{ ?>
										<input type="hidden" id="latitude" name="latitude" value="<?php echo esc_attr($post_latitude); ?>">
										<input type="hidden" id="longitude" name="longitude" value="<?php echo esc_attr($post_longitude); ?>">
									<?php } ?>
									<?php if(!empty($classiera_google_api) && $googleMapadPost == 1){ ?>
										<div id="post-map" class="submitMAp">
											<div id="map-canvas"></div>
											<script type="text/javascript">
												jQuery(document).ready(function($) {
													var geocoder;
													var map;
													var marker;
													var geocoder = new google.maps.Geocoder();
													function geocodePosition(pos) {
														geocoder.geocode({
															latLng: pos
														}, function(responses) {
															if (responses && responses.length > 0) {
																updateMarkerAddress(responses[0].formatted_address);
															} else {
																updateMarkerAddress('Cannot determine address at this location.');
															}

														});

													}

													function updateMarkerPosition(latLng) {
														jQuery('#latitude').val(latLng.lat());
														jQuery('#longitude').val(latLng.lng());
													}

													function updateMarkerAddress(str) {
														jQuery('#address').val(str);
													}

													function initialize() {
														var latlng = new google.maps.LatLng(<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>);
														var mapOptions = {
															zoom: <?php echo esc_attr($mapZoom); ?>,
															center: latlng
														}

														map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
														geocoder = new google.maps.Geocoder();
														marker = new google.maps.Marker({
															position: latlng,
															map: map,
															draggable: true
														});
												  // Add dragging event listeners.
												  google.maps.event.addListener(marker, 'dragstart', function() {
												  	updateMarkerAddress('Dragging...');
												  });									  

												  google.maps.event.addListener(marker, 'drag', function() {
												  	updateMarkerPosition(marker.getPosition());
												  });									  

												  google.maps.event.addListener(marker, 'dragend', function() {
												  	geocodePosition(marker.getPosition());
												  });
												}

													google.maps.event.addDomListener(window, 'load', initialize);
													jQuery(document).ready(function() {							         

														initialize();									          

														jQuery(function(){
															jQuery("#address").autocomplete({
														  //This bit uses the geocoder to fetch address values
														  source: function(request, response) {
														  	geocoder.geocode( {'address': request.term }, function(results, status) {
														  		response(jQuery.map(results, function(item) {
														  			return {
														  				label:  item.formatted_address,
														  				value: item.formatted_address,
														  				latitude: item.geometry.location.lat(),
														  				longitude: item.geometry.location.lng()
														  			}

														  		}));

														  	})

														  },

														  //This bit is executed upon selection of an address

														  select: function(event, ui) {
														  	jQuery("#latitude").val(ui.item.latitude);
														  	jQuery("#longitude").val(ui.item.longitude);
														  	var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
														  	marker.setPosition(location);
														  	map.setZoom(16);
														  	map.setCenter(location);
														  }

														});

														});



													  //Add listener to marker for reverse geocoding
													  google.maps.event.addListener(marker, 'drag', function() {
													  	geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
													  		if (status == google.maps.GeocoderStatus.OK) {
													  			if (results[0]) {
													  				jQuery('#address').val(results[0].formatted_address);
													  				jQuery('#latitude').val(marker.getPosition().lat());
													  				jQuery('#longitude').val(marker.getPosition().lng());
													  			}

													  		}
													  	});
													  });							  

													});
												});
											</script>
										</div>
									<?php } ?>
								</div>
							</div>
							<!--Google Value-->
						</div>
						<?php } ?>
						<!-- post location -->
						<!-- For Faster Sale -->
						<div class="form-main-section post-location">
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('For faster sales', 'classiera') ?> :</h4>
								
							<div class="row form-group"> 
								<label class="col-sm-3 col-xs-12 text-left flip"><?php esc_html_e('Ads Type', 'classiera') ?> :</label>
								<div class="col-sm-6">
									<div id="autobump_container" class="col-sm-6 col-xs-6  mtxl"> 
										<div class="extras"> 
											<div class="row"> 
												<div class="col-sm-12 col-xs-12 text-center"> 
													
													<label for="classiera_regular" class="mts"> 
														<img src="https://djurhus.se/wp-content/uploads/2020/11/regular.png" height="180px">
														<div> 
															<input name="classiera_post_type" id="classiera_regular" type="checkbox" value="classiera_regular" <?php if($classiera_post_type == 'classiera_regular'){ echo "checked"; }?>>
															<span>Regular Post</span>  
														</div> 
														
														<!-- <span>Add Weekly Renewal. + </span> -->
														<span class="autobump_price">20</span>
														<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
													</label> 
												</div>  
								 			</div> 
								 		</div> 
								 	</div>
						 			<div id="autobump_container" class="col-sm-6 col-xs-6 mtxl"> 
						 				<div class="extras"> 
						 					<div class="row"> 
						 						<div class="col-sm-12 col-xs-12 text-center"> 
						 							<label for="classiera_featured" class="mts"> 
						 								<img src="https://djurhus.se/wp-content/uploads/2020/11/featured.png" height="180px">
						 								<div>
						 									<input name="classiera_post_type_featured" id="classiera_featured" type="checkbox" value="classiera_featured" <?php if($classiera_post_type_featured == 'classiera_featured'){ echo "checked"; }?>> 
						 									<span>Featured post</span> 
						 								</div>
						 								<!-- <span>Add Weekly Renewal. + </span> -->
						 								<span class="autobump_price">60</span>
						 								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
						 							</label> 
						 						</div>  
						 		 			</div> 
						 		 		</div> 
						 		 	</div>
						 			<div id="autobump_container" class="col-sm-6 col-xs-6  mtxl"> 
						 				<div class="extras"> 
						 					<div class="row"> 
						 						<div class="col-sm-12 col-xs-12 text-center"> 
						 							 
						 							<label for="classiera_premium" class="mts"> 
						 								<img src="https://djurhus.se/wp-content/uploads/2020/11/premium.png" height="180px">
						 								<div> 
						 									<input name="classiera_post_type_premium" id="classiera_premium" type="checkbox" value="classiera_premium" <?php if($classiera_post_type_premium == 'classiera_premium'){ echo "checked"; }?>>
						 									<span>Premium post</span>  
						 								</div>
						 								<!-- <span>Add Weekly Renewal. + </span> -->
						 								<span class="autobump_price">100</span>
						 								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
						 							</label> 
						 						</div>  
						 		 			</div> 
						 		 		</div> 
						 		 	</div>
				 		 			<div id="autobump_container" class="col-sm-6 col-xs-6  mtxl"> 
				 		 				<div class="extras"> 
				 		 					<div class="row"> 
				 		 						<div class="col-sm-12 col-xs-12 text-center">
				 		 							<label for="classiera_week_renewal" class="mts"> 
				 		 								<img src="https://djurhus.se/wp-content/uploads/2020/11/bumpup.png" height="180px">
				 		 								<div> 
				 		 									<input name="classiera_week_renewal" id="classiera_week_renewal" type="checkbox" value="classiera_weekly_renewal">
				 		 									<span>10 week renewal</span> 
				 		 								</div>
				 		 								<!-- <span>Add Weekly Renewal. + </span> -->
				 		 								<span class="autobump_price">200</span>
				 		 								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
				 		 							</label> 
				 		 						</div>  
				 		 		 			</div> 
				 		 		 		</div> 
				 		 		 	</div>
								</div>
							</div>
						</div>
						<!-- End Faster Sale -->
						<!-- Choose Payment -->
						<div class="form-main-section post-location">
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Choose Payment', 'classiera') ?> :</h4>
							<!--Select Country-->
							<!-- card type -->
							<div class="form-group">
								<label class="col-sm-3 text-left flip hidden-xs"></label>
								<div class="checkbox col-sm-9">
									<input type="radio" name="pay_type" id="pay_type_card" value="card">
									<label for="pay_type_card" class="radio-vertical">
										<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Cards - Visa, Mastercard or American Express </font></font>
										<div class="credit_card_logos"> 
											<img class="credit_card_visa_master" src="https://www.blocket.se/img/credit_card_logos.svg"> 
											<img class="credit_card_amex" src="https://www.blocket.se/img/amex.png"> 
										</div>  
										
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 text-left flip hidden-xs"></label>
								<div class="checkbox col-sm-9">
									<input type="radio" name="pay_type" id="pay_type_swish" value="swish" checked="">
									<label for="pay_type_swish" class="radio-vertical">
										<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Swish </font></font>
										<div class="swish-logo-container"> 
											<img class="swish-logo" src="https://www.blocket.se/img/swish.svg" height="50px"> 
										</div> 
									</label>
								</div>
							</div>
							<!-- Telephone Pay -->
							<!-- <div class="form-group">
								<label class="col-sm-3 text-left flip hidden-xs"></label>
								<div class="checkbox col-sm-9">
									<input type="radio" name="pay_type" id="pay_type_phone" value="phone">
									<label for="pay_type_phone" class="radio-vertical">
										  
										<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">  telephone-call and pay  </font></font>
									</label>
								</div>
							</div> -->
						</div>
						<!-- End Choose Payment -->
						<div class="form-main-section post-location">
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Accept terms and Condition', 'classiera') ?> :</h4>
							<div class="form-group">
								<div class="checkbox col-sm-9">
									<input type="checkbox" name="dittjur_rules" id="dittjur_rules" value="1" data-error="<?php esc_attr_e('Please check the terms and condition', 'classiera') ?>" required>
									<label for="dittjur_rules">
										<?php esc_html_e('Yes, I accept Djurhus terms of use', 'classiera') ?>
									</label>
								</div>
							</div>
						</div>
						<!--Select Ads Type-->
						<div class="form-main-section post-type hidden">
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Select Ad Post Type', 'classiera') ?> :</h4>
							<p class="help-block"><?php esc_html_e('Select an Option to make your ad featured or regular', 'classiera') ?></p>
							<div class="form-group">
							<?php
							/*Get Current Ad Type*/
							$featured_post = "0";
							$post_price_plan_activation_date = get_post_meta($current_post, 'post_price_plan_activation_date', true);
							$post_price_plan_expiration_date = get_post_meta($current_post, 'post_price_plan_expiration_date', true);
							$post_price_plan_expiration_date_noarmal = get_post_meta($current_post, 'post_price_plan_expiration_date_normal', true);
							$todayDate = strtotime(date('m/d/Y h:i:s'));
							$expireDate = $post_price_plan_expiration_date;
							if(!empty($post_price_plan_activation_date)) {
								if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0) {
									$featured_post = "1";
								}
							}
							/*Get Current Ad Type*/
							?>
							<?php if($featured_post == "1") { ?>
							<div class="col-sm-4 col-md-3 col-lg-3 active-post-type">
								<h3 class="text-uppercase">
									<?php esc_html_e('Featured:', 'classiera') ?>
								</h3>
								<div class="radio">
									<input type="radio" id="feature-post" name="feature-post" value="featured" class="form-checkbox" checked><?php esc_html_e('Expiry:', 'classiera') ?> <?php if($post_price_plan_expiration_date_noarmal == 0) { ?> <?php esc_html_e( 'Never', 'classiera' ); ?> <?php } else { echo esc_html($post_price_plan_expiration_date_noarmal); } ?>
								</div>
							</div>
							<?php }else{ ?>
							<?php 
								$current_user = wp_get_current_user();
								$userID = $current_user->ID;								
								$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d ORDER BY id DESC", $userID));
								$totalAds = '';
								$usedAds = '';
								$availableADS = '';
								$planCount = 0;
									if(!empty($result)){
										foreach ( $result as $info ) {											
											$totalAds = $info->ads;
											$usedAds = $info->used;											
											$name = $info->plan_name;
											if($totalAds == 'unlimited'){
												$name = esc_html__( 'Unlimited for Admin Only', 'classiera' );
												$availableADS = 'unlimited';
											}else{
												$availableADS = $totalAds-$usedAds;
											}
											if($availableADS != 0 || $totalAds == 'unlimited'){
											?>
												<div class="col-sm-4 col-md-3 col-lg-3">
													<div class="post-type-box">
														<h3 class="text-uppercase">
															<?php echo esc_html($name); ?>
														</h3>
														<p><?php esc_html_e('Total Ads Available', 'classiera') ?> : <?php echo esc_attr($availableADS); ?></p>
														<p><?php esc_html_e('Ads used with this plan', 'classiera') ?> : <?php echo esc_attr($usedAds); ?></p>
														<div class="radio">
															<input id="featured<?php echo esc_attr($planCount); ?>" type="radio" name="classiera_post_type" value="<?php echo esc_attr($info->id); ?>">
															<label for="featured<?php echo esc_attr($planCount); ?>"><?php esc_html_e('Select', 'classiera') ?></label>
														</div>
													</div>
												</div>
											<?php
											}
											$planCount++;
										}
									}
							?>
								<?php if($regular_ads == 1 ){?>
									<div class="col-sm-4 col-md-3 col-lg-3 active-post-type">
										<div class="post-type-box">
											<h3 class="text-uppercase"><?php esc_html_e('Regular', 'classiera') ?></h3>
											<p><?php esc_html_e('For', 'classiera') ?>&nbsp;<?php echo esc_attr($classieraRegularAdsDays); ?>&nbsp;<?php esc_html_e('days', 'classiera') ?></p>
											<div class="radio">
												<input id="regular" type="radio" name="classiera_post_type" value="classiera_regular" checked>
												<label for="regular"><?php esc_html_e('Select', 'classiera') ?></label>
											</div>
											<input type="hidden" name="regular-ads-enable" value=""  >
										</div>
									</div>
								<?php } ?>
									<!--Pay Per Post Per Category Base-->
								<div class="col-sm-4 col-md-3 col-lg-3 classieraPayPerPost">
									<div class="post-type-box">
										<h3 class="text-uppercase">
											<?php esc_html_e('Featured Ad', 'classiera') ?>
											<p class="classieraPPP"></p>
											<input id="payperpost" type="radio" name="classiera_post_type" value="payperpost">
											<label for="payperpost">
											<?php esc_html_e('select', 'classiera') ?>
											</label>
										</h3>
									</div>
								</div>
								<!--Pay Per Post Per Category Base-->
							<?php } ?>
							</div>
						</div>
						<!--Select Ads Type-->
						<?php
						$featured_plans = classiera_get_template_url('template-pricing-plans.php');
						if(!empty($featured_plans)){
							if($featuredADS == "0" || empty($result)){
						?>
							<div class="row hidden">
								<div class="col-sm-9">
									<div class="help-block terms-use">
										<?php esc_html_e('Currently you have no active plan for featured ads. You must purchase a', 'classiera') ?> <strong><a href="<?php echo esc_url($featured_plans); ?>" target="_blank"><?php esc_html_e('Featured Pricing Plan', 'classiera') ?></a></strong> <?php esc_html_e('to be able to publish a Featured Ad.', 'classiera') ?>
									</div>
								</div>
							</div>
						<?php }} ?>
						<div class="row">
							<!-- <div class="col-sm-9">
								<div class="help-block terms-use">
									<?php esc_html_e('By clicking "Update Ad", you agree to our', 'classiera') ?> <a href="<?php echo esc_url($termsandcondition); ?>"><?php esc_html_e('Terms of Use', 'classiera') ?></a> <?php esc_html_e('and acknowledge that you are the rightful owner of this item', 'classiera') ?>
								</div>
							</div> -->
						</div>
            <div class="form-main-section row">
            	<div class="col-sm-4">
            		<input type="hidden" class="regular_plan_id" name="regular_plan_id" value="">
            		<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
            		<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
            		<input type="hidden" name="submitted" id="submitted" value="true">
            		<button class="post-submit btn btn-primary sharp btn-md btn-style-one btn-block" type="submit" name="op" value="<?php esc_attr_e('Update Ad', 'classiera') ?>"><?php esc_html_e('Update Ad', 'classiera') ?></button>
            	</div>
            </div>
					</form>
				</div><!--submit-post-->
			</div><!--col-lg-9 col-md-8-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php endwhile; ?>

<script>
jQuery(document).ready(function () {
	jQuery.noConflict();
	if(jQuery('div').is('#classiera_editdropzone')){
		Dropzone.autoDiscover = false;
		var classiera_editdropzone = jQuery("#classiera_editdropzone");
		var maxfile = classiera_editdropzone.data("max-file");
		var maxsize = classiera_editdropzone.data("max-size");
		var filemsg = jQuery(".dz-max-file-msg");
		var removemsg = jQuery(".dz-remove").html();
		classiera_editdropzone.dropzone ({
			url: ajaxurl,
			acceptedFiles: "image/*",			
			maxFiles: maxfile,
			parallelUploads: 1,
			uploadMultiple: true,					
			addRemoveLinks: true,
			maxFilesize: maxsize,
			dictRemoveFile: removemsg,
			init: function() {
				<?php
				foreach ($attachments as $att_id => $attachment){
					$attachment_ID = $attachment->ID;
					$fileName = $attachment->post_title;
					$imgURL = wp_get_attachment_url($attachment->ID);
					?>
					var attID = <?php echo esc_attr($attachment_ID); ?>;
					var mockFile = {
						name: "<?php echo esc_html($fileName); ?>",
						size: 12345,
						id: attID,
						accepted:true
					};
					this.emit("addedfile", mockFile);
					this.emit("thumbnail", mockFile, '<?php echo esc_url($imgURL);?>');
					this.emit("complete", mockFile);
					jQuery(mockFile.previewElement).attr("id", attID);
					jQuery(mockFile.previewElement).append('<input name="attachedids[]" type="hidden" value="'+ attID +'">');
					mockFile.previewElement.classList.add(attID);
					jQuery('#classiera_editdropzone').sortable();
					<?php
				}
				?>
				this.on("sending", function(file, xhr, formData) {
					formData.append("action", "classiera_media_upload");
				});
				this.on("complete", function(file, response) {
					jQuery(file.previewElement).append('<input name="attachedids[]" type="hidden" value="'+ response +'">');
					jQuery(file.previewElement).attr("id", response);
				});
				this.on("success", function(file, response) {
					jQuery(file.previewElement).append('<input name="attachedids[]" type="hidden" value="'+ response +'">');
					jQuery(file.previewElement).attr("id", response);
				});
				this.on("complete", function(file, response) {
					jQuery('#classiera_editdropzone').sortable();
				});
				this.on("removedfile", function(file) {
					var attachedID = jQuery(file.previewElement).attr("id");
					var attachedData = {
						'action': 'classiera_media_upload',			
						'delete_attached': attachedID
					};
					jQuery.ajax({
						type : 'POST',
						dataType : 'json',
						url : ajaxurl,
						data : attachedData,						
					});
				});
			}
		});
	}

});
jQuery(document).ready(function ($) {
	$(":file").change(function() {
		box_id = $(this).parent().parent().parent();
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        // reader.onload = imageIsLoaded;
        reader.onload = function(){
        	box_id.children('.centerer').children('.image').attr("src", reader.result);
          // $(".image").attr("src", reader.result);
      	}
        reader.readAsDataURL(this.files[0]);
    }
    // box_id = $(this).parent().parent().parent();
    box_id.removeClass('highlighted empty');
    box_id.children('.remove').removeClass('hidden');
    box_id.children('.rotate').removeClass('hidden');
    box_id.next('.user_image').addClass('highlighted empty');
    box_id.children('.centerer').children('.image_icon').addClass('hidden');
    box_id.children('.centerer').children('.text').addClass('hidden');
    box_id.children('.centerer').children('.image').css('display', 'inline');
    box_id.next('.user_image').children('.centerer').children('.image_icon').addClass('sprite_ai_camera_dark').removeClass('sprite_ai_camera_light');
	});
	$('.remove').click(function(){
		box_id = $(this).parent();
		box_id.children('.remove').addClass('hidden');
		box_id.children('.rotate').addClass('hidden');
		box_id.children('.centerer').children('.image').attr("src", '');
		box_id.addClass('highlighted empty');
		box_id.children('.centerer').children('.image_icon').removeClass('hidden');
		box_id.children('.centerer').children('.text').removeClass('hidden');
		box_id.children('.centerer').children('.image').css('display', 'none');
		box_id.next('.user_image').children('.centerer').children('.image_icon').removeClass('sprite_ai_camera_dark').addClass('sprite_ai_camera_light');
		box_id.next('.user_image').children('.centerer').children('.text').addClass('hidden');
		box_id.next('.user_image').removeClass('highlighted empty');
	});
	$('.rotate').click(function(){
		box_id = $(this).parent();

		var img = box_id.children('.centerer').children('img');
    if(img.hasClass('north')){
        img.addClass('west');
        img.removeClass('north');
    }else if(img.hasClass('west')){
        img.addClass('south');
        img.removeClass('west');
    }else if(img.hasClass('south')){
        img.addClass('east');
        img.removeClass('south');
    }else if(img.hasClass('east')){
        img.addClass('north');
        img.removeClass('east');
    }
	});
	
	
	
	$('#cat').on('change', function(){
		var id = (this.value);
		if(id == 70){
			$('#dog_price').removeClass('hidden');
			$('#cat_price').addClass('hidden');
		}else if(id == 71){
			$('#cat_price').removeClass('hidden');
			$('#dog_price').addClass('hidden');
		}else{
			$('#cat_price').addClass('hidden');
			$('#dog_price').addClass('hidden');
		}
	});

	var post_type = "<?php echo $classiera_post_type ?>";
	if(post_type == 'classiera_regular'){
		$("#classiera_regular").prop("checked", true);
	}
	if(post_type == 'classiera_featured'){
		$("#classiera_featured").prop("checked", true);
	}
	if(post_type == 'classiera_premium'){
		$("#classiera_premium").prop("checked", true);
	}

	var weekly_renewal = "<?php echo $classiera_week_renewal; ?>";
	if(weekly_renewal == 'classiera_weekly_renewal'){
		$('#classiera_week_renewal').prop("checked", true);
	}

});
</script>
<?php get_footer(); ?>