<?php
/**
 * Template name: Submit Ad
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

// if ( !is_user_logged_in() ) {	
// 	$login = classiera_get_template_url('template-login.php');
// 	if(empty($login)){
// 		$login = classiera_get_template_url('template-login-v2.php');
// 	}
// 	wp_redirect( $login ); exit;
// }
$errorMsg = '';
$availableADS = '';
$catError = '';
$featPlanMesage = '';
$postContent = '';
$hasError = false;
$hasErrorVerify = false;
$hasErrorImage = false;
$hasErrorTitle = false;
$allowed ='';
$caticoncolor="";
$classieraCatIconCode ="";
$category_icon="";
$category_icon_color="";
$classieraCatIcoIMG="";
global $redux_demo;
$featuredADS = 0;
$regularAvailable = 0;
$featuredAvailable = 0;
$primaryColor = $redux_demo['color-primary'];
$post_whatsapp_on = $redux_demo['post_whatsapp_on'];
$googleFieldsOn = $redux_demo['google-lat-long'];
$classieraLatitude = $redux_demo['contact-latitude'];
$classieraLongitude = $redux_demo['contact-longitude'];
$classieraAddress = $redux_demo['classiera_address_field_on'];
$postCurrency = $redux_demo['classierapostcurrency'];
$classieracat_icon = $redux_demo['classiera_submit_cat_icon'];
$termsandcondition = $redux_demo['termsandcondition'];
$classiera_post_web_url = $redux_demo['classiera_post_web_url'];
$classiera_gdpr_url = $redux_demo['classiera_gdpr_url'];
$classieraProfileURL = classiera_get_template_url('template-profile.php');
$classieraProfileSetting = classiera_get_template_url('template-edit-profile.php');
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
$classiera_bid_system = $redux_demo['classiera_bid_system'];
$classiera_locations_input = $redux_demo['classiera_locations_input'];
$classiera_google_api = $redux_demo['classiera_google_api'];
$paidIMG = $redux_demo['premium-ads-limit'];
$regularIMG = $redux_demo['regular-ads-limit'];	
$classiera_image_size = $redux_demo['classiera_image_size'];	
$classieraRegularAdsOn = $redux_demo['regular-ads'];
if(isset($redux_demo['classiera_exclude_categories'])){
	$excludeCats = $redux_demo['classiera_exclude_categories'];
}else{
	$excludeCats = array();
}
if(isset($redux_demo['classiera_exclude_user'])){
	$excludeCatsUsers = $redux_demo['classiera_exclude_user'];
}else{
	$excludeCatsUsers = array();
}
if($classieraRegularAdsOn == true){
	$regularIMG = $redux_demo['regular-ads-limit'];
}else{
	$regularIMG = 0;
}
$current_user = wp_get_current_user();
$userID = $current_user->ID;
$userLogin = $current_user->user_login;
$userEmail = $current_user->user_email;
$userPhone = $current_user->phone;
$userPhone2 = $current_user->phone2;

//print_r($userPhone);

if(isset($_POST['postTitle'])){
	if(trim($_POST['postTitle']) != '' && $_POST['classiera-main-cat-field'] != ''){		
		if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {			
			if(empty($_POST['postTitle'])){
				$errorMsg =  esc_html__( 'Please enter a title.', 'classiera' );
				$hasErrorTitle = true;
				$hasError = true;
			}else{
				$postTitle = trim($_POST['postTitle']);
			}
			
			if($_POST['classiera-main-cat-field'] == ''){
				$errorMsg = esc_html__( 'Please select a category', 'classiera' );
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
			if($_POST['classiera-main-cat-field'] == 70 && $_POST['post_old_price'] < 1000){				
				$errorMsg = esc_html__('Your ads price should be more then 1000');
				$hasError = true;
				$hasErrorVerify = true;
			}
			if($_POST['classiera-main-cat-field'] == 71 && $_POST['post_old_price'] < 500){
				$errorMsg = esc_html__('Your add price should ne more then 500');
				$hasError = true;
				$hasErrorVerify = true;
			}
			if($_POST['classiera-main-cat-field'] == 70 && empty($_POST['price_confirm_dog'])){
				$errorMsg = esc_html__('You should verify Dog price to proceed');
				$hasError = true;
				$hasErrorVerify = true;
			}
			if($_POST['classiera-main-cat-field'] == 71 && empty($_POST['price_confirm_cat'])){
				$errorMsg = esc_html__('You should verify Cat price to proceed');
				$hasError = true;
				$hasErrorVerify = true;
			}
// 			if($_FILES['upload_attachment']['name'][0] == ''){
// 				$errorMsg = esc_html__('Please upload image to proceed');
// 				$hasError = true;
// 				$hasErrorImage = true;
// 			}
			/*== Image Count check ==*/
			$userIMGCount = 0;
			if($_POST['classiera_post_type'] == 'classiera_regular' || $_POST['classiera_post_type'] == 'classiera_regular_with_plan'){
				$userIMGCount = $regularIMG;
			}else{
				$userIMGCount = $paidIMG;
			}
			if(isset($_POST['attachedids'])){
				$attachedids = $_POST['attachedids'];
				$filenumber = count($attachedids);
				if($filenumber > $userIMGCount){
					$errorMsg = esc_html__( 'Images count has been exceeded.', 'classiera' );
					$hasError = true;
				}
			}
			/*== Image Count check ==*/

			if($hasError == false && !empty($_POST['classiera_post_type'])) {
				$classieraPostType = $_POST['classiera_post_type'];				
				/*== Set Post Status ==*/
				if(is_super_admin() ){
					$postStatus = 'publish';
				}elseif(!is_super_admin()){
					if($redux_demo['post-options-on'] == 1){
						// $postStatus = 'private';
						$postStatus = 'publish';
					}else{
						$postStatus = 'pending';
					}
					if($classieraPostType == 'payperpost'){
						$postStatus = 'pending';
					}
				}
				/*== Check Category ==*/
				$classieraMainCat = '';
				$classieraChildCat = '';
				$classieraThirdCat = '';
				if(isset($_POST['classiera-main-cat-field'])){
					$classieraMainCat = $_POST['classiera-main-cat-field'];
				}
				if(isset($_POST['classiera-sub-cat-field'])){
					$classieraChildCat = $_POST['classiera-sub-cat-field'];
				}
				if(isset($_POST['classiera_third_cat'])){
					$classieraThirdCat = $_POST['classiera_third_cat'];
				}
				if(empty($classieraThirdCat)){
					$classieraCategory = $classieraChildCat;
				}else{
					$classieraCategory = $classieraThirdCat;
				}
				if(empty($classieraCategory)){
					$classieraCategory = $classieraMainCat;
				}

				$username = esc_sql($_POST['username']);
				$email = esc_sql($_POST['email']);
				$password = $_POST['pwd'];
				$confirm_password = esc_sql($_POST['confirm']);
				$registerSuccess = 1;


				if(empty($username)) {					
					$message =  esc_html__( 'User name should not be empty.', 'classiera' );
					$registerSuccess = 0;
				}			
						

				if(isset($email)) {

					if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 

						wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;

					}else { 				 
						$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
						$registerSuccess = 0;
					}						

				}else{
					$registerSuccess = 0;
					$message =  esc_html__( 'Please enter a valid email.', 'classiera' );
				}
				/*If Admin Turn Of Email Verification then this code will work*/
				if($classieraEmailVerify != 1){
					if($password) {

						if (strlen($password) < 5 || strlen($password) > 15) {
							
							$message =  esc_html__( 'Password must be 5 to 15 characters in length.', 'classiera' );
							$registerSuccess = 0;
							
						}elseif(isset($password) && $password != $confirm_password) {
							
							$message =  esc_html__( 'Password Mismatch', 'classiera' );

							$registerSuccess = 0;

						}elseif ( isset($password) && !empty($password) ) {

							$update = wp_set_password( $password, $user_ID );						
							$message =  esc_html__( 'Registration successful', 'classiera' );
							$registerSuccess = 1;

						}

					}
				}else{/*If Admin Turn Of Email Verification then this code will work*/
					$password = wp_generate_password( $length=12, $special_chars=false );
				}				

				
				$status = wp_create_user( $username, $password, $email );
				if ( is_wp_error($status) ) {
					$registerSuccess = 0;
					
					$message =  esc_html__( 'Username or E-mail already exists. Please try another one.', 'classiera' );
				}else{
					if($classiera_gdpr == true){
						update_user_meta($status, 'classiera_gdpr', 'yes');
					}else{
						update_user_meta($status, 'classiera_gdpr', 'no');
					}
					classieraUserNotification( $email, $password, $username );			
					global $redux_demo; 
					$newUsernotification = $redux_demo['newusernotification'];	
						if($newUsernotification == 1){
							classieraNewUserNotifiy($email, $username);	
						}

					$registerSuccess = 1;
					$userID = $status;
				}
				$userID = $status;
				/*If Turn OFF Email verification*/
				if($registerSuccess == 1 && $classieraEmailVerify != 1) {
					$login_data = array();
					$login_data['user_login'] = $username;
					$login_data['user_password'] = $password;
					$user_verify = wp_signon( $login_data, false );						
					// $profile = classiera_get_template_url('template-profile.php');
					// wp_redirect( $profile ); exit;

				}
				elseif($registerSuccess == 1) {					
					$message =  esc_html__( 'Check Your Inbox for User Name And Password', 'classiera' );
				}
				
				/*== Check Category ==*/
				/*== Setup Post Data ==*/				
				if(!is_user_logged_in()){
					$post_information = array(
						'post_title' => esc_attr(strip_tags($_POST['postTitle'])),			
						'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video><br>'),
						'post-type' => 'post',
						'post_category' => array($classieraMainCat, $classieraChildCat, $classieraThirdCat),
						'tags_input'    => explode(',', $_POST['post_tags']),
						'comment_status' => 'open',
						'ping_status' => 'open',
						'post_author' => $userID,
						'post_status' => $postStatus
					);
				}else{
					$post_information = array(
						'post_title' => esc_attr(strip_tags($_POST['postTitle'])),			
						'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video><br>'),
						'post-type' => 'post',
						'post_category' => array($classieraMainCat, $classieraChildCat, $classieraThirdCat),
						'tags_input'    => explode(',', $_POST['post_tags']),
						'comment_status' => 'open',
						'ping_status' => 'open',
						'post_status' => $postStatus
					);
				}

				


				$post_id = wp_insert_post($post_information);
				
				/*== Check If Latitude is OFF ==*/
				$googleLat = '';
				$googleLong = '';
				if(isset($_POST['latitude'])){
					$googleLat = $_POST['latitude'];
				}				
				if(empty($googleLat)){
					$latitude = $classieraLatitude;
				}else{
					$latitude = $googleLat;
				}
				/*== Check If Latitude is OFF ==*/
				if(isset($_POST['longitude'])){
					$googleLong = $_POST['longitude'];
				}				
				if(empty($googleLong)){
					$longitude = $classieraLongitude;
				}else{
					$longitude = $googleLong;
				}			
				$catID = $classieraCategory.'custom_field';		
				$custom_fields = $_POST[$catID];
				
				/*== Get Country Name ==*/
				if(isset($_POST['post_location'])){
					$postLo = $_POST['post_location'];
					$allCountry = get_posts( array( 'include' => $postLo, 'post_type' => 'countries', 'posts_per_page' => -1, 'suppress_filters' => 0, 'orderby'=>'post__in' ) );
					foreach( $allCountry as $country_post ){
						$postCounty = $country_post->post_title;
					}
				}		
				
				/*== If We are using CSC Plugin ==*/
				if(isset($_POST['post_category_type'])){
					update_post_meta($post_id, 'post_category_type', esc_attr( $_POST['post_category_type'] ) );
				}	
				if(isset($_POST['classiera_sub_fields'])){
					$classiera_sub_fields = $_POST['classiera_sub_fields'];
					update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
				}
				if(isset($_POST['classiera_CF_Front_end'])){
					$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];
					update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);
				}
				/*== Setup Price ==*/				
				if(isset($_POST['post_currency_tag'])){
					$postMultiTag = $_POST['post_currency_tag'];
					update_post_meta($post_id, 'post_currency_tag', $postMultiTag, $allowed);
				}
				if(isset($_POST['post_price'])){
					$post_price = trim($_POST['post_price']);
					update_post_meta($post_id, 'post_price', $post_price, $allowed);
				}
				if(isset($_POST['post_old_price'])){
					$post_old_price = trim($_POST['post_old_price']);
					update_post_meta($post_id, 'post_old_price', $post_old_price, $allowed);
				}	
				if(isset($_POST['price_confirm_dog'])){
					update_post_meta($post_id, 'price_confirm_dog', $_POST['price_confirm_dog'], $allowed);
				}		
				if(isset($_POST['price_confirm_cat'])){
					update_post_meta($post_id, 'price_confirm_cat', $_POST['price_confirm_cat'], $allowed);
				}				
				if(isset($_POST['post_phone'])){
					update_post_meta($post_id, 'post_phone', $_POST['post_phone'], $allowed);
				}
				if(isset($_POST['post_whatsapp'])){
					update_post_meta($post_id, 'post_whatsapp', $_POST['post_whatsapp'], $allowed);
				}				
				if(isset($_POST['post_email'])){
					update_post_meta($post_id, 'post_email', $_POST['post_email'], $allowed);
				}
				if(isset($_POST['classiera_ads_type'])){
					update_post_meta($post_id, 'classiera_ads_type', $_POST['classiera_ads_type'], $allowed);
				}
				if(isset($_POST['seller'])){
					update_post_meta($post_id, 'seller', $_POST['seller'], $allowed);
				}
				if(isset($_POST['post_location'])){
					update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));
				}
				if(isset($_POST['post_state'])){
					update_post_meta($post_id, 'post_state', wp_kses($_POST['post_state'], $allowed));
				}
				if(isset($_POST['post_city'])){
					update_post_meta($post_id, 'post_city', wp_kses($_POST['post_city'], $allowed));
				}
				if(!empty($latitude)){
					update_post_meta($post_id, 'post_latitude', wp_kses($latitude, $allowed));
				}
				if(!empty($longitude)){
					update_post_meta($post_id, 'post_longitude', wp_kses($longitude, $allowed));
				}
				if(isset($_POST['address'])){
					update_post_meta($post_id, 'post_address', wp_kses($_POST['address'], $allowed));
				}
				if(isset($_POST['video'])){
					update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);
				}
				if(isset($_POST['item-condition'])){
					update_post_meta($post_id, 'item-condition', $_POST['item-condition'], $allowed);
				}
				if(isset($_POST['pay_per_post_product_id'])){
					update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
				}
				if(isset($_POST['days_to_expire'])){
					update_post_meta($post_id, 'days_to_expire', $_POST['days_to_expire'], $allowed);
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
				if(isset($_POST['classiera_week_renewal'])){
					update_post_meta($post_id, 'classiera_week_renewal', $_POST['classiera_week_renewal'], $allowed);
				}
				if(isset($_POST['classiera_allow_bids'])){
					update_post_meta($post_id, 'classiera_allow_bids', $_POST['classiera_allow_bids'], $allowed);
				}
				if(isset($_POST['classiera-main-cat-field'])){
					update_post_meta($post_id, 'post_perent_cat', $classieraMainCat, $allowed);
				}
				if(isset($_POST['classiera-sub-cat-field'])){
					update_post_meta($post_id, 'post_child_cat', $classieraChildCat, $allowed);
				}
				if(isset($_POST['classiera_third_cat'])){
					update_post_meta($post_id, 'post_inner_cat', $classieraThirdCat, $allowed);
				}
				if(isset($_POST['classiera_featured_img'])){
					$featuredIMG = $_POST['classiera_featured_img'];
					update_post_meta($post_id, 'featured_img', $featuredIMG, $allowed);
				}
				if(isset($_POST['post_web_url'])){
					update_post_meta($post_id, 'post_web_url', $_POST['post_web_url'], $allowed);
				}
				if(isset($_POST['post_web_url_txt'])){
					update_post_meta($post_id, 'post_web_url_txt', $_POST['post_web_url_txt'], $allowed);
				}
				if(isset($_POST['number_hide'])){
					update_post_meta($post_id, 'number_hide', $_POST['number_hide'], $allowed);
				}

				update_post_meta($post_id, 'custom_field', $custom_fields);
				
				
				if($classieraPostType == 'payperpost'){
					$permalink = classiera_cart_url();
				}else{
					$permalink = get_permalink( $post_id );
				}			
				/*== If Its posting featured image ==*/
				if(trim($_POST['classiera_post_type']) != 'classiera_regular'){
					if($_POST['classiera_post_type'] == 'payperpost'){
						$productID = $_POST['pay_per_post_product_id'];
						$postTitle = $_POST['postTitle'];
						$days_to_expire = $_POST['days_to_expire'];
						classiera_pay_per_post($productID, $post_id, $postTitle, $days_to_expire);
					}elseif($_POST['classiera_post_type'] == 'classiera_regular_with_plan'){						
						/*== Regular Ads Posting with Plans ==*/
						$classieraPlanID = trim($_POST['regular_plan_id']);
						global $wpdb;
						if ( !is_user_logged_in() ) {
							$userID = $status;

						}else{
							$current_user = wp_get_current_user();
							$userID = $current_user->ID;						
						}
						$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE id =%d", $classieraPlanID));
						if($result){
							$tablename = $wpdb->prefix . 'classiera_plans';
							foreach ( $result as $info ){
								$newRegularUsed = $info->regular_used +1;
								$update_data = array('regular_used' => $newRegularUsed);
								$where = array('id' => $classieraPlanID);
								$update_format = array('%s');
								$wpdb->update($tablename, $update_data, $where, $update_format);
							}
						}
					}else{						
						/*== Featured Post with Plan Ads ==*/
						$featurePlanID = trim($_POST['classiera_post_type']);
						global $wpdb;
						if ( !is_user_logged_in() ) {
							$userID = $status;

						}else{
							$current_user = wp_get_current_user();
							$userID = $current_user->ID;						
						}						
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
				
				/*== If Its posting featured image ==*/
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
				wp_redirect($permalink); exit();
			}
		}
	}else{
	    if(empty($_POST['classiera-main-cat-field'])) {
			$errorMsg = esc_html__( 'Please select a category.', 'classiera' );
			$hasError = true;
		} 
		if(trim($_POST['postTitle']) === '') {
			$errorMsg = esc_html__( 'Please enter a title.', 'classiera' );	
			$hasError = true;
		}
		if(empty($_POST['dittjur_rules'])){
			$errorMsg = esc_html__('Please check the terms and condition', 'classiera' );
			$hasError = true;
		}
		if(empty($_POST['post_old_price'])){
			$errorMsg = esc_html__('Please enter price', 'classiera' );
			$hasError = true;
		}
// 		if($_FILES['upload_attachment']['name'][0] == ''){
// 			$errorMsg = esc_html__('Please upload image to proceed');
// 			$hasError = true;
// 		}
	}

} 
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$featuredUsed = null;
	$featuredAds = null;
	$regularUsed = null;
	$regularAds = null;
?>
<section class="user-pages section-gray-bg">
	<div class="container">
		<div class="row">
			<?php 
			if ( !is_user_logged_in() ) {	
				$login = classiera_get_template_url('template-login.php');
				if(empty($login)){
					$login = classiera_get_template_url('template-login-v2.php');
				}?>
				<?php classiera_get_template_url('template-login.php'); ?>
			<?php }else{
				?>
				<div class="col-lg-3 col-md-4">
					<?php get_template_part( 'templates/profile/userabout' ); ?>
				</div><!--col-lg-3 col-md-4-->
			<?php  }?>
			<div class="col-lg-9 col-md-8 user-content-height">
				<?php 
				global $redux_demo;
				global $wpdb;
				$current_user = wp_get_current_user();
				$userID = $current_user->ID;			
				$featured_plans = classiera_get_template_url('template-pricing-plans.php');				
				$postLimitOn = $redux_demo['regular-ads-posting-limit'];
				$regularCount = $redux_demo['regular-ads-user-limit'];
				$cUserCheck = current_user_can( 'administrator' );
				$role = $current_user->roles;
				// print_r($role);
				// $currentRole = $role[0];
				$currentRole = 'administrator';
				$classieraAllowPosts = false;				
				$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d ORDER BY id DESC", $userID));
				foreach ($result as $info){											
					$featuredAdscheck = $info->ads;											
					if (is_numeric($featuredAdscheck)){
						$featuredAds += $info->ads;
						$featuredUsed += $info->used;
					}
					$regularAdscheck = $info->regular_ads;
					if (is_numeric($regularAdscheck)){
						$regularAds += $info->regular_ads;
						$regularUsed += $info->regular_used;
					}
				}
				if (is_numeric($featuredAds) && is_numeric($featuredUsed)){
					$featuredAvailable = $featuredAds-$featuredUsed;
				}
				if (is_numeric($regularAds) && is_numeric($regularUsed)){
					$regularAvailable = $regularAds-$regularUsed;
				}
				
				$curUserargs = array(					
					'author' => $user_ID,
					'numberposts' => -1,
					'post_status' => array('publish', 'pending', 'draft', 'private', 'trash')    
				);
				$countPosts = count(get_posts($curUserargs));
				if($currentRole == "administrator"){
					$classieraAllowPosts = true;
				}else{
					if($postLimitOn == true){
						if($regularAvailable == 0 && $featuredAvailable == 0 && $countPosts >= $regularCount){
							$classieraAllowPosts = false;
						}else{
							$classieraAllowPosts = true;
						}
					}else{
						$classieraAllowPosts = true;
					}
				}				
				if($classieraAllowPosts == false){ ?>
					<div class="alert alert-warning" role="alert">
						<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
							<?php esc_html_e('Your ad posting limit has been reached. Please purchase a plan for posting more ads.', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $featured_plans ); ?>"><?php esc_html_e('Purchase Plan', 'classiera') ?></a></p>
							<p><?php esc_html_e('Or select any category to check single featured ads availability.', 'classiera'); ?></p>
						</div>
					<?php } ?>
					<?php if($hasError == true){ ?>
						<div class="alert alert-warning" role="alert">
							<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
								<?php echo esc_html($errorMsg); ?>
								<p>
								</div>
							<?php } ?>
							
								<div class="submit-post section-bg-white">
									<form class="form-horizontal" action="" role="form" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
										<h4 class="text-uppercase border-bottom"><?php esc_html_e('MAKE NEW AD', 'classiera') ?></h4>
										<!-- seller information without login-->
										
										<div class="form-main-section seller">
											<h4 class="text-uppercase border-bottom"><?php esc_html_e('User Information', 'classiera') ?> :</h4>
                          <!-- <div class="form-group">
                              <label class="col-sm-3 text-left flip"><?php esc_html_e('You are', 'classiera') ?> : <span>*</span></label>
                              <div class="col-sm-9">
                                  <div class="radio">
                                      <input id="individual" type="radio" name="seller" checked>
                                      <label for="individual"><?php esc_html_e('Individual', 'classiera') ?></label>
                                      <input id="dealer" type="radio" name="seller">
                                      <label for="dealer"><?php esc_html_e('Dealer', 'classiera') ?></label>
                                  </div>
                              </div>
                            </div> -->
                            <!--Username-->
                            <div class="form-group">
                          		<div class="col-lg-3 col-sm-3 single-label">
                          			<label for="username"><?php esc_html_e('Username', 'classiera') ?> : 
                          				<span class="text-danger">*</span>
                          			</label>
                          		</div>
                          		<div class="col-lg-9 col-sm-9">
                        				<input type="text" id="username" name="username" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter username', 'classiera') ?>" data-error="<?php esc_attr_e('Username required', 'classiera') ?>" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : $userLogin; ?>" pattern="[a-zA-Z0-9]+" required>
                        				<div class="help-block with-errors"></div>
                          		</div>
                            </div>
                            <!--Username-->
                            <!--EmailAddress-->
                            <div class="form-group">
                          		<div class="col-lg-3 col-sm-3 single-label">
                          			<label for="email"><?php esc_html_e('Email Address', 'classiera') ?> : <span class="text-danger">*</span></label>
                          		</div>
                          		<div class="col-lg-9 col-sm-9">
                        				<input id="email" type="email" name="email" class="form-control form-control-md sharp-edge" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : $userEmail; ?>" placeholder="<?php esc_attr_e('example@example.com', 'classiera') ?>" data-error="<?php esc_attr_e('Email required', 'classiera') ?>" required>
                        				<div class="help-block with-errors"></div>
                          		</div>
                            </div>
                            <!--EmailAddress-->
                            <!--Password-->
                          <?php if( !is_user_logged_in()){?>
                          	<div class="form-group">
                        			<div class="col-lg-3 col-sm-3 single-label">
                        				<label for="registerPass"><?php esc_html_e('Password', 'classiera') ?> : <span class="text-danger">*</span></label>
                        			</div>
                        			<div class="col-lg-9 col-sm-9">
                      					<input type="password" name="pwd" data-minlength="5" class="form-control form-control-md sharp-edge" placeholder="<?php esc_attr_e('enter password', 'classiera') ?>" id="registerPass" data-error="<?php esc_attr_e('Password required', 'classiera') ?>" required>
                      					<div class="help-block"><?php esc_html_e('Minimum of 5 characters', 'classiera') ?></div>
                        			</div>
                          	</div>
                          <?php }?>
                            <!--Password-->
                            <!-- <div class="form-group">
                            	<label class="col-sm-3 text-left flip"><?php esc_html_e('Your Name', 'classiera') ?>: <span>*</span></label>
                            	<div class="col-sm-6">
                            		<input type="text" name="user_name" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter Your Name', 'classiera') ?>">
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label class="col-sm-3 text-left flip"><?php esc_html_e('Your Email', 'classiera') ?> : <span>*</span></label>
                            	<div class="col-sm-6">
                            		<input type="email" name="user_email" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your email', 'classiera') ?>">
                            	</div>
                            </div> -->
                            <div class="form-group">
                            	<label class="col-lg-3 col-sm-3 text-left flip"><?php esc_html_e('Your Phone or Mobile No', 'classiera') ?> :</label>
                            	<div class="col-lg-7 col-sm-7">
                            		<input type="tel" name="post_phone" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your Mobile or Phone number', 'classiera') ?>" value="<?php echo isset($_POST["post_phone"]) ? $_POST["post_phone"] : $userPhone; ?>">
                            	</div>
                            	<div class="checkbox col-sm-2 col-lg-2">
                            		<input type="checkbox" name="number_hide" id="number_hide" value="1" data-error="<?php esc_attr_e('hide in the ad') ?>">
                            		<label for="number_hide"><?php esc_html_e('hide in the ad', 'classiera') ?>
                            		</label>
                            	</div>
                            </div>
                          </div>
                        
                        <!-- seller information without login -->

										<div class="form-main-section post-detail">
											<!-- <h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Details', 'classiera') ?> :</h4> -->
											<!-- <div class="form-group">
												<label class="col-sm-3 text-left flip"><?php esc_html_e('Selected Category', 'classiera') ?> : </label>
												<div class="col-sm-9">
													<p class="form-control-static"></p>
													<input type="text" id="selectCatCheck" value="" data-error="<?php esc_attr_e('Please select a category.', 'classiera') ?>" required >
													<div class="help-block with-errors selectCatDisplay"></div>
												</div>
											</div> -->
											<!--Category-->
											<div class="classiera-post-cat">
												<div class="classiera-post-main-cat">
													<!-- <h4 class="classiera-post-inner-heading">
														<?php esc_html_e('Select a Category', 'classiera') ?> :
													</h4> -->
													<div class="form-group">
														<label class="col-sm-3 text-left flip"><?php esc_html_e('Select a Category', 'classiera') ?> :<span>*</span> </label>
														<div class="col-sm-9">
															<select name="classiera-main-cat-field" class="form-control form-control-md classiera-main-cat-field" required>
															    <option value="">Select Category</option>
																<?php
																if(is_array($excludeCatsUsers) && array_intersect($excludeCatsUsers, $current_user->roles )){
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
																}	?>
																
																<?php							
																$categories = get_terms('category', $argscat);
																foreach ($categories as $category){
																	$tag = $category->term_id;
																	$classieraCatFields = get_option(MY_CATEGORY_FIELDS);
																	if (isset($classieraCatFields[$tag])){
																		if(isset($classieraCatFields[$tag]['category_icon_code'])){
																			$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
																		}
																		if(isset($classieraCatFields[$tag]['your_image_url'])){
																			$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
																		}
																		if(isset($classieraCatFields[$tag]['category_image'])){
																			$category_image = $classieraCatFields[$tag]['category_image'];
																		}
																		if(isset($classieraCatFields[$tag]['category_icon_color'])){
																			$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
																		}											
																	}
																	if(empty($classieraCatIconClr)){
																		$iconColor = $primaryColor;
																	}else{
																		$iconColor = $classieraCatIconClr;
																	}
																	$category_icon = stripslashes($classieraCatIconCode);
																	?>
																	<option id="<?php echo esc_attr( $tag ); ?>" <?php if($_POST['classiera-main-cat-field'] == esc_attr( $tag )){echo "selected";} ?> value="<?php echo esc_html(($tag)); ?>"><?php echo esc_html(get_cat_name( $tag )); ?></option>
																	<?php
																}
																?>
															</select>
															<div class="help-block with-errors selectCatDisplay"></div>
														</div>
														
													</div>
													
												</div><!--classiera-post-main-cat-->
												<div class="classiera-post-sub-cat">
													<h4 class="classiera-post-inner-heading">
														<?php esc_html_e('Select a Sub Category', 'classiera') ?> :
													</h4>
													<ul class="list-unstyled classieraSubReturn">
													</ul>
													<input class="classiera-sub-cat-field" name="classiera-sub-cat-field" type="hidden" value="">
												</div><!--classiera-post-sub-cat-->
												<!--ThirdLevel-->
												<div class="classiera_third_level_cat">
													<h4 class="classiera-post-inner-heading">
														<?php esc_html_e('Select a Sub Category', 'classiera') ?> :
													</h4>
													<ul class="list-unstyled classieraSubthird">
													</ul>
													<input class="classiera_third_cat" name="classiera_third_cat" type="hidden" value="">
												</div>
												<!--ThirdLevel-->
											</div>
											<!--Category-->
											<!--Selected Category-->
											<?php if($classiera_ads_typeOn == 1){?>
												<?php 
												$adsTypeShow = $redux_demo['classiera_ads_type_show'];
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
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Type of Ad', 'classiera') ?> : <span>*</span></label>
													<div class="col-sm-9">
														<div class="radio">
															<?php if($classieraShowSell == 1){ ?>
																<input id="sell" value="sell" type="radio" name="classiera_ads_type" checked>
																<label for="sell"><?php esc_html_e('I want to sell', 'classiera') ?></label>
															<?php } ?>
															<?php if($classieraShowBuy == 1){ ?>
																<input id="buy" value="buy" type="radio" name="classiera_ads_type">
																<label for="buy"><?php esc_html_e('I want to buy', 'classiera') ?></label>
															<?php } ?>
															<?php if($classieraShowexchange == 1){ ?>
																<input id="exchange" value="exchange" type="radio" name="classiera_ads_type">
																<label for="exchange"><?php esc_html_e('Exchange', 'classiera') ?></label>
															<?php } ?>
															<?php if($classieraShowRent == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="rent" id="rent">
																<label for="rent"><?php esc_html_e('I want to rent', 'classiera') ?></label>
															<?php } ?>
															<?php if($classieraShowHire == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="hire" id="hire">
																<label for="hire"><?php esc_html_e('I want to hire', 'classiera') ?></label>
															<?php } ?>
															<!--Lost and Found-->
															<?php if($classieraShowFound == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="lostfound" id="lostfound">
																<label for="lostfound"><?php esc_html_e('Lost & Found', 'classiera') ?></label>
															<?php } ?>
															<!--Lost and Found-->
															<!--Free-->
															<?php if($classieraShowFree == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="free" id="typefree">
																<label for="typefree"><?php esc_html_e('I want to give for free', 'classiera') ?></label>
															<?php } ?>
															<!--Free-->
															<!--Event-->
															<?php if($classieraShowEvent == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="event" id="event">
																<label for="event"><?php esc_html_e('I am an event', 'classiera') ?></label>
															<?php } ?>
															<!--Event-->
															<!--Professional service-->
															<?php if($classieraShowServices == 1){ ?>
																<input type="radio" name="classiera_ads_type" value="service" id="service">
																<label for="service">
																	<?php esc_html_e('Professional service', 'classiera') ?>
																</label>
															<?php } ?>
															<!--Professional service-->
														</div>
													</div>
												</div><!--Type of Ad-->
											<?php } ?>
											<div class="form-group">
												<label class="col-sm-3 text-left flip" for="title"><?php esc_html_e('Ad title', 'classiera') ?> : <span>*</span></label>
												<div class="col-sm-9">
													<input id="title" data-minlength="5" name="postTitle" type="text" class="form-control form-control-md" value="<?php echo isset($_POST["postTitle"]) ? $_POST["postTitle"] : ''; ?>"  placeholder="<?php esc_attr_e('Ad Title Goes here', 'classiera') ?>" required>
													<div class="help-block"><?php esc_html_e('Type minimum 5 characters', 'classiera') ?></div>
												<?php if($hasErrorTitle == true){ ?>
            						<div class="alert alert-warning" role="alert">
            							<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
            								<?php echo esc_html($errorMsg); ?>
          								<p>
        								</div>
          							<?php } ?>
												</div>
											</div><!--Ad title-->
											<div class="form-group">
												<label class="col-sm-3 text-left flip" for="description"><?php esc_html_e('Ad description', 'classiera') ?> : <span>*</span></label>
												<div class="col-sm-9">
													<textarea name="postContent" id="description" class="form-control" data-error="<?php esc_attr_e('Write description', 'classiera') ?>"  required><?php echo isset($_POST["postContent"]) ? $_POST["postContent"] : ''; ?></textarea>
													<div class="help-block with-errors"></div>
												</div>
											</div><!--Ad description-->
											<div class="form-group">
												<label class="col-sm-3 text-left flip"><?php esc_html_e('Keywords', 'classiera') ?> (Optional) : </label>
												<div class="col-sm-9">
													<div class="form-inline row">
														<div class="col-sm-12">
															<div class="input-group">
																<div class="input-group-addon"><i class="fas fa-tags"></i></div>
																<input type="text" name="post_tags" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter keywords for a better search', 'classiera') ?>" value="<?php echo isset($_POST["post_tags"]) ? $_POST["post_tags"] : ''; ?>">
															</div>
														</div>
													</div>
													<div class="help-block"><?php esc_html_e('Keywords example: ads, car, cat, business', 'classiera') ?></div>
												</div>
											</div><!--Ad Tags-->
											<?php 
											$classieraPriceSecOFF = $redux_demo['classiera_sale_price_off'];
											$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
											$regularpriceon= $redux_demo['regularpriceon'];
											$postCurrency = $redux_demo['classierapostcurrency'];
											$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
											?>
											<?php if($classieraPriceSecOFF == 1){?>
												<div class="form-group">
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
															<?php if($regularpriceon == 1){?>
																<div class="col-sm-12">
																	<div class="input-group">
																		
																		<input type="text" name="post_old_price" class="form-control form-control-md" placeholder="<?php esc_attr_e('Price', 'classiera') ?>" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;" value="<?php echo isset($_POST["post_old_price"]) ? $_POST["post_old_price"] : ''; ?>" required>
																	</div>
																	<div class="help-block"><?php esc_html_e('Add price to publish ad', 'classiera') ?></div>
																</div>
															<?php } ?>
															<!-- <div class="col-sm-12 hidden">
																<div class="input-group">
																	<div class="input-group-addon">
																		<span class="currency__symbol">
																			<?php 
																			if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
																				echo esc_html( $postCurrency );
																			}elseif($classieraMultiCurrency == 'multi'){
																				echo classiera_Display_currency_sign($classieraTagDefault);
																			}else{
																				echo "&dollar;";		
																			}
																			?>	
																		</span>
																	</div>
																	<input type="text" name="post_price" class="form-control form-control-md" placeholder="<?php esc_attr_e('Lowered price', 'classiera') ?>">
																</div>
															</div> -->										
															
														</div>									
														<?php if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){?>
															<!--<div class="help-block" style="color: black;"><?php esc_html_e('Currency sign is already set as', 'classiera') ?>&nbsp;<?php echo esc_html( $postCurrency ); ?>&nbsp;<?php esc_html_e('Please do not include a currency sign in the price field. Only use numbers, ex: 12345', 'classiera') ?></div>-->
														<?php } ?>
													</div>								
												</div><!--Ad Price-->
											<?php } ?>
											
											<!-- categories Price condition -->
											<div class="form-group <?php if($_POST['classiera-main-cat-field'] != 70){ echo "hidden";} ?> " id="dog_price">
												<label class="col-sm-3 text-left flip" for="description"></label>
												<div class="checkbox col-sm-9">
														<input type="checkbox" name="price_confirm_dog" id="price_confirm_dog" value="confirm"  data-error="<?php esc_attr_e('Please check the price confirm box', 'classiera') ?>" <?php echo isset($_POST["price_confirm_dog"]) ? 'checked' : ''; ?>>
													<label for="price_confirm_dog">
														<?php esc_html_e('I certify that the dog at the time of sale is at least 8 weeks old and has a price of at least SEK 1,000.', 'classiera') ?>
													</label>
												</div>
											</div>
											<div class="form-group  <?php if($_POST['classiera-main-cat-field'] != 71){ echo "hidden";} ?> " id="cat_price">
												<label class="col-sm-3 text-left flip" for="description"></label>
												<div class="checkbox col-sm-9">
													
														<input type="checkbox" name="price_confirm_cat" id="price_confirm" value="confirm"  data-error="<?php esc_attr_e('Please check the price confirm box', 'classiera') ?>" <?php echo isset($_POST["price_confirm_cat"]) ? 'checked' : ''; ?>>
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
															<input id="allowbid" value="allow" type="radio" name="classiera_allow_bids" checked>
															<label for="allowbid">
																<?php esc_html_e('Allow users to bid on this ad.', 'classiera') ?>
															</label>
															<input id="disallowbid" value="disallow" type="radio" name="classiera_allow_bids">
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
											<?php $classieraAskingPhone = $redux_demo['phoneon'];?>
											<?php if($classieraAskingPhone == 1){?>
												<div class="form-group">
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Your Phone/Mobile', 'classiera') ?> :</label>
													<div class="col-sm-9">
														<div class="form-inline row">
															<div class="col-sm-12">
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-mobile-alt"></i>
																	</div>
																	<input type="text" name="post_phone" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your phone or mobile number', 'classiera') ?>">
																</div>
															</div>
														</div>
														<div class="help-block"><?php esc_html_e('It&rsquo;s not required, but if you enter your phone number here, it will be shown publicly.', 'classiera') ?></div>
													</div>
												</div>
											<?php } ?>
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
																	<input type="text" name="post_whatsapp" class="form-control form-control-md" placeholder="<?php esc_attr_e('WhatsApp number (Ex:+1234567)', 'classiera') ?>">
																</div>
															</div>
														</div>
														<div class="help-block"><?php esc_html_e('Enter your WhatsApp number in international format (Ex:+123456789) , It&rsquo;s not required, but if you enter your WhatsApp number here, it will be shown publicly.', 'classiera') ?></div>
													</div>
												</div>
												<!--WhatsAPP-->
											<?php } ?>
											<!--ContactPhone-->
											<!--ContactEmil-->
											<?php $classieraemail_on = $redux_demo['email_on'];?>
											<?php if($classieraemail_on == 1){?>
												<div class="form-group">
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Your Email', 'classiera') ?> :</label>
													<div class="col-sm-9">
														<div class="form-inline row">
															<div class="col-sm-12">
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-envelope"></i>
																	</div>
																	<input type="email" name="post_email" class="form-control form-control-md" placeholder="<?php esc_attr_e('email@example.com', 'classiera') ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php } ?>
											<!--ContactPhone-->	
											<!--Website URL-->
											<?php if($classiera_post_web_url == true){ ?>
												<div class="form-group">
													<label class="col-sm-3 text-left flip">
														<?php esc_html_e('Website URL :', 'classiera') ?>
													</label>
													<div class="col-sm-9">
														<div class="form-inline row">
															<div class="col-sm-6">
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-link"></i>
																	</div>
																	<input type="text" name="post_web_url" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your website URL', 'classiera') ?>">
																</div>
															</div>
															<div class="col-sm-6">
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-font"></i>
																	</div>
																	<input type="text" name="post_web_url_txt" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter URL title', 'classiera') ?>">
																</div>
															</div>
														</div>
														<div class="help-block"><?php esc_html_e('It&rsquo;s not required, but if you enter a URL, then you must also enter a title.', 'classiera') ?></div>
													</div>
												</div>
											<?php } ?>
											<!--Website URL-->							
											<?php 
											$adpostCondition= $redux_demo['adpost-condition'];
											if($adpostCondition == 1){
												?>
												<div class="form-group">
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Item Condition', 'classiera') ?> : <span>*</span></label>
													<div class="col-sm-9">
														<div class="radio">
															<input id="new" type="radio" name="item-condition" value="new" name="item-condition" checked>
															<label for="new"><?php esc_html_e('Brand New', 'classiera') ?></label>
															<input id="used" type="radio" name="item-condition" value="used" name="item-condition">
															<label for="used"><?php esc_html_e('Used', 'classiera') ?></label>
														</div>
													</div>
												</div><!--Item condition-->
											<?php } ?>
										</div><!---form-main-section post-detail-->
										<!-- extra fields -->
										<div class="classieraExtraFields" style="display:none;"></div>
										<!-- extra fields -->
										<!-- add photos and media -->
										<?php								
										/*== Image Count Check== */
										global $redux_demo;
										global $wpdb;
										$current_user = wp_get_current_user();
										$userID = $current_user->ID;
										$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d ORDER BY id DESC", $userID));
										$totalAds = 0;
										$usedAds = 0;
										$availableADS = '';
										if(!empty($result)){
											foreach ( $result as $info ){
												$availAds = $info->ads;
												if (is_numeric($availAds)) {
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
										if($currentRole == "administrator"){
											$imageLimit = $paidIMG;
										}
										if($imageLimit != 0){	
											?>
											<div class="form-main-section media-detail">

												<h4 class="text-uppercase border-bottom"><?php esc_html_e('Image', 'classiera') ?> :</h4>
												<div class="form-group">
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Photos for your ad', 'classiera') ?> :</label>
													<div class="col-sm-9">
														<div class="image_items_container">
															<div id="user_image_0" class="user_image empty extra image highlighted">  
																<!--<span class="rotate button hidden sprite_ai_rotate_image_cw" data-auto-save-trigger=""></span>  -->
																<!--<span class="remove button hidden sprite_ai_upload_image_delete"></span> -->
																<div class="centerer" data-trackable="add_image_clicked"> 
																	<img class="image north" data-transform-rotation="0" data-scale="1" data-rotation="0" src="https://www.blocket.se/img/transparent.gif" alt=""> 
																	<div class="image_icon sprite_ai_camera_dark"></div> 
																	<div class="text"> 
																		<span class="img_desc"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">choose picture</font></font></span> 
																	</div> 
																	<div style="position: absolute; overflow: hidden; opacity: 1; zoom: 1; width: 108px; height: 81px; z-index: 1; top: 0px; left: 0px;">
																		<input style="border: none; position: relative; opacity: 0; cursor: pointer; top: 12.5625px; left: -82.5px;">
																	</div>
																</div> 
																<span class="progress"></span> 
															</div>
															<?php for($i=1; $i<=$imageLimit-1; $i++) {
																
																echo '<div id="user_image_'.$i.'" class="user_image empty image">  
																 
																	<div class="centerer" data-trackable="add_image_clicked"> 
																		<img class="image north" data-transform-rotation="0" data-scale="1" data-rotation="0" src="https://www.blocket.se/img/transparent.gif" alt=""> 
																		<div class="sprite_ai_camera_light image_icon"></div> 
																		<div class="text"> 
																			<span class="img_desc">choose picture</span> 
																		</div> 
																		<div style="position: absolute; overflow: hidden; opacity: 1; zoom: 1; width: 108px; height: 81px; z-index: 1; top: 0px; left: 0px;">
																			<input name="" style="border: none; position: relative; opacity: 0; cursor: pointer; top: -0.4375px; left: -79.5px;">
																		</div>
																	</div> 
																	<span class="progress"></span> 
																</div>';
															 } ?>
															 
														</div>
														<!--dropzone-->
														 <div class="dropzone dz-clickable mb-4" id="classiera_dropzone" data-max-file="<?php echo esc_attr( $imageLimit ); ?>" data-max-size="<?php echo esc_attr($classiera_image_size);?>">
															<div class="dz-default dz-message hidden" data-dz-message>
																<p class="text-center"><i class="far fa-images fa-3x"></i></p>
																<span><?php esc_html_e( 'Drop files here to upload', 'classiera' ); ?></span>
																<span><?php esc_html_e( 'or', 'classiera' ); ?></span>
																<strong>
																	<?php esc_html_e( 'Click here', 'classiera' ); ?>
																</strong>
																<span><?php esc_html_e( 'to select images', 'classiera' ); ?></span>
																<p class="text-muted hidden">(<?php esc_html_e( 'Your first image will be used as a featured image, and it will be shown as thumbnail.', 'classiera' ); ?>)</p>
															</div>
															<div class="dz-max-file-msg hidden">
																<div class="dropzoneAlert alert alert-danger text-center">
																	<?php esc_html_e( 'We are sorry but your upload limit is reached.', 'classiera' ); ?>
																	<?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images maximum.', 'classiera') ?>
																</div>
															</div>
															<div class="dz-remove" data-dz-remove>
																<span><?php esc_html_e('Remove', 'classiera') ?></span>
															</div>
														</div> 
														 <p class="visible-xs visible-sm alert alert-warning classiera_img_info hidden">
															<strong><?php esc_html_e('Alert', 'classiera') ?> :</strong>
															<?php esc_html_e('If you are using Opera, UC Browser, Firefox or KaiOS Mobile browser then you need to select images one by one, multi selection is not supported by these browsers.', 'classiera') ?>
														</p>
														<p style="height:135px"></p>
														<p class="alert alert-info classiera_img_info hidden">
															<strong><?php esc_html_e('Note', 'classiera') ?> :</strong>
															<?php esc_html_e('You can upload maximum', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images .', 'classiera') ?>
															<?php esc_html_e('Max file size need to be', 'classiera') ?>&nbsp;<?php echo esc_attr($classiera_image_size*1024 / 1024);?>&nbsp;<?php esc_html_e('KB .', 'classiera') ?>
															<?php esc_html_e('If you are posting a regular ad then select only', 'classiera') ?>&nbsp;<?php echo esc_attr( $regularIMG ); ?>&nbsp;<?php esc_html_e('images, otherwise you will not be able to post your ad.', 'classiera') ?>
														</p> -->
														<!--drop-zone-->
														<?php 
														$classiera_video_postads = $redux_demo['classiera_video_postads'];
														if($classiera_video_postads == 1){
															?>
															<div class="iframe">
																<div class="iframe-heading">
																	<i class="fas fa-video"></i>
																	<span><?php esc_html_e('Paste iframe or video URL here.', 'classiera') ?></span>
																</div>
																<textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_attr_e('Paste iframe or video URL here.', 'classiera') ?>"></textarea>
																<div class="help-block">
																	<p><?php esc_html_e('Add iframe or video URL (iframe 710x400). YouTube, Vimeo, etc.', 'classiera') ?></p>
																</div>
															</div>
														<?php } ?>
													</div>
													<?php if($hasErrorImage == true){ ?>
                    						<div class="alert alert-warning" role="alert">
                    							<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
                    								<?php echo esc_html($errorMsg); ?>
                    								<p>
                    								</div>
                    							<?php } ?>
												</div>
											</div>
										<?php } ?>
										<!-- add photos and media -->
										<!-- post location -->
										<?php
										$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];
										if($classiera_ad_location_remove == 1){
											?>
											<div class="form-main-section post-location location-mobile">
												<h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Location', 'classiera') ?> :</h4>
												<?php 
												$args = array(
													'post_type' => 'countries',
													'posts_per_page'   => -1,
													'orderby'          => 'title',
													'order'            => 'ASC',
													'post_status'      => 'publish',
													'suppress_filters' => false 
												);
												$country_posts = get_posts($args);
												if(!empty($country_posts)){
													?>
													<!--Select Country-->
													<div class="form-group hidden">
														<label class="col-sm-3 text-left flip"><?php esc_html_e('Select Country', 'classiera') ?>: <span>*</span></label>
														<div class="col-sm-6">
															<div class="inner-addon right-addon input-group">
																<div class="input-group-addon">
																	<i class="fas fa-globe"></i>
																</div>
																<i class="form-icon right-form-icon fas fa-angle-down"></i>
																<select name="post_location" id="post_location" class="form-control form-control-md select_country">
																	<!-- <option value="-1" selected disabled><?php esc_html_e('Select Country', 'classiera'); ?></option> -->
																	<?php 
																	foreach( $country_posts as $country_post ){
																		?>
																		<option value="<?php echo esc_attr( $country_post->ID ); ?>">
																			<?php echo esc_html( $country_post->post_title ); ?>
																		</option>
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
												$args = array(
													'post_type' => 'states',
													'posts_per_page'   => -1,
													'orderby'          => 'title',
													'order'            => 'ASC',
													'post_status'      => 'publish',
													'suppress_filters' => false 
												);
												$state_posts = get_posts($args);
												$statesList = "";
												if(!empty($state_posts)){		
													foreach( $state_posts as $state_post ){
														$state = $state_post->ID;					
														$statesList .= get_post_meta($state, "classiera-all-states", true).",";				
													}
												}	
												$singleState = explode(",", $statesList);

												$locationsStateOn = $redux_demo['location_states_on'];
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
																			<input type="text" name="post_state" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your state name.', 'classiera') ?>">
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
																<div class="inner-addon right-addon input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-globe"></i>
																	</div>
																	<i class="form-icon right-form-icon fas fa-angle-down"></i>
																	<select name="post_state" id="post_state" class="selectState form-control form-control-md" required>
																		<!-- <option value=""><?php esc_html_e('Select State', 'classiera'); ?></option> -->
																		<?php if(!empty($singleState)){
																			foreach( $singleState as $state_post ){
																				if(!empty($state_post)){
																					$state_ops .= '<option value="'.$state_post.'">'.$state_post."</option>";
																				}
																			}
																		} ?>
																		<?php echo $state_ops; ?>
																	</select>
																</div>
															</div>
														</div>
													<?php } ?>
												<?php } ?>
												<!--Select States-->
												<!--Select City-->
												<?php 
												$locationsCityOn= $redux_demo['location_city_on'];
												if($locationsCityOn == 1){
													if($classiera_locations_input == 'input'){
														?>
														<div class="form-group">
															<label class="col-sm-3 text-left flip">
																<?php esc_html_e('Municipality', 'classiera'); ?> :
															</label>
															<div class="col-sm-9">
																<div class="form-inline row">
																	<div class="col-sm-12">
																		<div class="input-group">
																			<div class="input-group-addon">
																				<i class="fas fa-globe"></i>
																			</div>
																			<input type="text" name="post_city" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your city name.', 'classiera') ?>">
																		</div><!--input-group-->
																	</div><!--col-sm-12-->
																</div><!--form-inline row-->
															</div><!--col-sm-9-->
														</div><!--form-group-->
														<?php
													}else{
														?>
														<div class="form-group">
															<label class="col-sm-3 text-left flip"><?php esc_html_e('Select Municipality', 'classiera'); ?>: <span>*</span></label>
															<div class="col-sm-6">
																<div class="inner-addon right-addon input-group">
																	<div class="input-group-addon">
																		<i class="fas fa-globe"></i>
																	</div>
																	<i class="form-icon right-form-icon fas fa-angle-down"></i>
																	<select name="post_city" id="post_city" class="selectCity form-control form-control-md" required>
																		
																		<option value=""><?php esc_html_e('Select Municipality', 'classiera'); ?></option>
																		<option value="Karlshamn">Karlshamn</option>
																		<option value="Karlskrona">Karlskrona</option>
																		<option value="Olofström">Olofström</option>
																		<option value="Ronneby">Ronneby</option>
																		<option value="Sölvesborg">Sölvesborg</option>
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
															<div class="form-inline row">
																<div class="col-sm-12">
																	<div class="input-group">
																		<div class="input-group-addon">
																			<i class="fas fa-route"></i>
																		</div>
																		<input id="address" type="text" name="address" class="form-control form-control-md" placeholder="<?php esc_attr_e('Address or City', 'classiera') ?>">
																	</div><!--input-group-->
																</div><!--col-sm-12-->
															</div><!--form-inline row-->
														</div><!--col-sm-9-->
													</div><!--form-group-->
												<?php } ?>
												<!--Address-->
												<!--Google Value-->
												<div class="form-group">
													<?php 
													$googleFieldsOn = $redux_demo['google-lat-long']; 
													if($googleFieldsOn == 1){
														?>
														<label class="col-sm-3 text-left flip"><?php esc_html_e('Set Latitude & Longitude', 'classiera') ?> :</label>
													<?php } ?>
													<div class="col-sm-9">
														<?php 
														$googleFieldsOn = $redux_demo['google-lat-long']; 
														if($googleFieldsOn == 1){
															?>
															<div class="form-inline row">
																<div class="col-sm-6">
																	<div class="input-group">
																		<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
																		<input type="text" name="latitude" id="latitude" class="form-control form-control-md" placeholder="<?php esc_attr_e('Latitude', 'classiera') ?>">
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="input-group">
																		<div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
																		<input type="text" name="longitude" id="longitude" class="form-control form-control-md" placeholder="<?php esc_attr_e('Longitude', 'classiera') ?>">
																	</div>
																</div>
															</div>
														<?php }else{ ?>
															<input type="hidden" id="latitude" name="latitude">
															<input type="hidden" id="longitude" name="longitude">
														<?php } ?>
														<?php 
														$googleMapadPost = $redux_demo['google-map-adpost']; 
														if(!empty($classiera_google_api) && $googleMapadPost == 1){
															?>
															<!--<div id="post-map" class="submitMAp">-->
															<!--	<div id="map-canvas"></div>-->
															<!--</div>-->
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
																										<input name="classiera_post_type" id="classiera_regular" type="checkbox" value="classiera_regular" checked>
																										<span>Regular Post</span>   
																									</div>
																									<input type="hidden" value="20" name="regularPrice" id="regularPrice">
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
																	 									<input name="classiera_post_type_featured" id="classiera_featured" type="checkbox" value="classiera_featured">
																	 									<span>Featured post</span> 
																	 								</div>
																	 								<input type="hidden" name="featurePrice" id="featurePrice" value="60">
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
																	 									<input name="classiera_post_type_premium" id="classiera_premium" type="checkbox" value="classiera_premium">
																	 									<span>Premium post</span>  
																	 								</div> 
																	 									<input type="hidden" id="premiumPrice" value="100">
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
															 		 								<!-- <span>Add Weekly Renewal. + </span> -->
															 		 								<input type="hidden" name="" id="renewPrice" value="200">
														 		 									<div> 
														 		 										<input name="classiera_week_renewal" id="classiera_week_renewal" type="checkbox" value="classiera_weekly_renewal">
														 		 										<span>10 week renewal</span> 
															 		 								</div>
															 		 								<span class="autobump_price">200</span>
															 		 								<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
															 		 							</label> 
															 		 						</div> 
															 		 		 			</div> 
															 		 		 		</div> 
															 		 		 	</div>
													</div>
												</div>
												<!-- <div class="row form-group"> 
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Weekly renewal', 'classiera') ?> :</label>
													<div id="autobump_container" class="col-sm-6  mtxl"> 
														<div class="extras"> 
															<div class="row"> 
																<div class="col-sm-8 col-xs-7 "> 
																	<div> 
																		<span>Your ad ends up at the top every week.</span> 
																		  
																	</div> 
																	<label for="add_autobump" class="mts"> 
																		<input name="add_autobump" id="add_autobump" type="checkbox" value="1">
																		<span>Add Weekly Renewal. + </span>
																		<span class="autobump_price">160</span>
																		<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
																	</label> 
																</div> 
																<div class="extra_services_image_container col-xs-5 col-sm-4 text-right"> 
																	<img src="https://www.blocket.se/img/transparent.gif" class="sprite_campaigns_extra_services_ai_weekbump_b" alt="Weekly renewal" title="">
											 						<div class="extra_services_image_holder" style="background-image: url(&quot;https://www.blocket.se/img/transparent.gif&quot;);">
												 	
												 					</div> 
												 				</div> 
												 			</div> 
												 		</div> 
												 	</div> 
												</div> -->
												<!-- <div class="row form-group"> 
													<label class="col-sm-3 text-left flip"><?php esc_html_e('Weekly renewal', 'classiera') ?> :</label>
													<div id="autobump_container" class="col-sm-6  mtxl"> 
														<div class="extras"> 
															<div class="row"> 
																<div class="col-sm-8 col-xs-7 "> 
																	<div> 
																		<span>10 week renewal</span> 
																		  
																	</div> 
																	<label for="add_autobump" class="mts"> 
																		<input name="add_autobump" id="add_autobump" type="checkbox" value="1">
																		<span>Add Weekly Renewal. + </span>
																		<span class="autobump_price">200</span>
																		<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> kr</font></font>
																	</label> 
																</div> 
																<div class="extra_services_image_container col-xs-5 col-sm-4 text-right"> 
																	<img src="https://www.blocket.se/img/transparent.gif" class="sprite_campaigns_extra_services_ai_weekbump_b" alt="Weekly renewal" title="">
											 						<div class="extra_services_image_holder" style="background-image: url(&quot;https://www.blocket.se/img/transparent.gif&quot;);">
												 	
												 					</div> 
												 				</div> 
												 			</div> 
												 		</div> 
												 	</div> 
												</div> -->
											<!-- <div class="row form-group" id="extra_services">
													<label class="col-sm-3 text-left flip"><?php esc_html_e('The gallery', 'classiera') ?> :</label>	
												<div class="col-sm-6" id="gallery_container">	
														<div class="extras"> 
															<div class="row"> 
																<div class="col-xs-7 col-sm-8"> 
																	<div> 
																		<span>In the Gallery, your ad will appear at the top of the page next to the search results for seven days.</span>
																		<br> 
																	</div> 
																	<label for="add_gallery" class="mts"> 
																		<input name="add_gallery" id="add_gallery" type="checkbox" value="1">
																			<span>Add the Gallery + </span>
																			<span>SEK </span>
																		<span class="gallery_price">
																			<span>70</span>
																		</label> 
																	</div> 
																	<div class="col-xs-5 col-sm-4 extra_services_image_container text-right"> <img src="https://www.blocket.se/img/transparent.gif" class="sprite_campaigns_extra_services_ai_gallery_b" alt="The gallery" title="">
														 <div class="extra_services_image_holder" style="background-image: url(&quot;https://www.blocket.se/img/transparent.gif&quot;);">
														 	
														 </div> 
														</div> 
													</div> 
												</div>
												</div>

											</div> -->
											
										</div>
										<!-- End Faster Sale -->
										<!-- Regular Coupon -->
										<div class="form-group" id="regular_coupon">
											<label class="col-sm-3 text-left flip"><?php esc_html_e('Coupon', 'classiera') ?>: </label>
											<div class="col-sm-9">
												<div class="form-inline row">
													<div class="col-sm-12">
														<?php echo do_shortcode('[wpcd_coupon id=3474]'); ?>
													</div>
												</div>
											</div>
										</div>
										<!-- Featured Coupon -->
										<div class="form-group" id="featured_coupon" style="display: none;">
											<label class="col-sm-3 text-left flip"><?php esc_html_e('Coupon', 'classiera') ?>: </label>
											<div class="col-sm-9">
												<div class="form-inline row">
													<div class="col-sm-12">
														<?php echo do_shortcode('[wpcd_coupon id=3677]'); ?>
													</div>
												</div>
											</div>
										</div>
										<!-- Premium Coupon -->
										<div class="form-group" id="premium_coupon" style="display: none;">
											<label class="col-sm-3 text-left flip"><?php esc_html_e('Coupon', 'classiera') ?>: </label>
											<div class="col-sm-9">
												<div class="form-inline row">
													<div class="col-sm-12">
														<?php echo do_shortcode('[wpcd_coupon id=3678]'); ?>
													</div>
												</div>
											</div>
										</div>
										<!-- Bump Ads Coupon -->
										<div class="form-group" id="bump_coupon" style="display: none;">
											<label class="col-sm-3 text-left flip"><?php esc_html_e('Coupon', 'classiera') ?>: </label>
											<div class="col-sm-9">
												<div class="form-inline row">
													<div class="col-sm-12">
														<?php echo do_shortcode('[wpcd_coupon id=3679]'); ?>
													</div>
												</div>
											</div>
										</div><!--Ad Tags-->
										<div class="form-group">
											<label class="col-sm-3 text-left flip"><?php esc_html_e('Total', 'classiera') ?>: </label>
											<div class="col-sm-9">
												<div class="form-inline row">
													<div class="col-sm-12">
														<h4 id="total_price"></h4>
														<input type="hidden" id="inp_sub_total" value="">
                            <input type="hidden" id="inp_discount" value="">
                            <input type="hidden" id="inp_grand_total" value="">
														<table style="width: 100%;">
															<tr>
																<th>Sub Total</th>
																<th>Discount</th>
																<th>Total</th>
															</tr>
															<tr>
																<td id="sub_total"></td>
																<td id="discount"></td>
																<td id="grand_total"></td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
										<!-- End Coupon -->
										<!-- Choose Payment -->
										<div class="form-main-section post-location">
											<h4 class="text-uppercase border-bottom"><?php esc_html_e('Choose Payment', 'classiera') ?> :</h4>
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
											<!--Select Country-->
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
													<input type="checkbox" name="dittjur_rules" id="dittjur_rules" value="1" data-error="<?php esc_attr_e('Please check terms and condition', 'classiera') ?>" required>
													<label for="dittjur_rules">
														<?php esc_html_e('Yes, I accept Djurhus terms of use', 'classiera') ?>
													</label>
												</div>
											</div>
										</div>
                    <!--Select Ads Type-->
                    <?php 
                    $totalAds = '';
                    $usedAds = '';
                    $availableADS = '';
                    $planCount = 0;	
                    $classieraRegularAdsDays = $redux_demo['ad_expiry'];
                    $current_user = wp_get_current_user();
                    $userID = $current_user->ID;						
                    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d ORDER BY id DESC", $userID));
                    ?>
                    <div class="form-main-section post-type hidden">
                    	<h4 class="text-uppercase border-bottom"><?php esc_html_e('Select Ad Post Type', 'classiera') ?> :</h4>
                    	<p class="help-block"><?php esc_html_e('Select an Option to make your ad featured or regular', 'classiera') ?></p>
                    	<div class="form-group">
                    		<!--Regular Ad with plans-->
                    		<?php							
                    		if($postLimitOn == true && $countPosts >= $regularCount && $currentRole != "administrator"){
                    			if(!empty($result)){
                    				$count = 0;
                    				foreach( $result as $info ){
                    					$totalRegularAds = $info->regular_ads;
                    					$usedRegularAds = $info->regular_used;
                    					$regularID = $info->id;
                    					$availableRegularADS = $totalRegularAds-$usedRegularAds;
                    					$planName = $info->plan_name;
                    					if($availableRegularADS != 0){
                    						?>
                    						<div class="col-sm-4 col-md-3 col-lg-3">
                    							<div class="post-type-box">
                    								<h3 class="text-uppercase">
                    									<?php esc_html_e('Regular with ', 'classiera') ?>
                    									<?php echo esc_html($planName); ?>
                    								</h3>
                    								<p>
                    									<?php esc_html_e('Available Regular ads ', 'classiera') ?> :
                    									<?php echo esc_attr($availableRegularADS); ?>
                    								</p>
                    								<p>
                    									<?php esc_html_e('Used Regular ads', 'classiera') ?> : 
                    									<?php echo esc_attr($usedRegularAds); ?>
                    								</p>
                    								<div class="radio">
                    									<input id="regularPlan<?php echo esc_attr($regularID); ?>" class="classieraGetID" type="radio" name="classiera_post_type" value="classiera_regular_with_plan" data-regular-id="<?php echo esc_attr($info->id); ?>">
                    									<label for="regularPlan<?php echo esc_attr($regularID); ?>">
                    										<?php esc_html_e('Select', 'classiera') ?>
                    									</label>
                    								</div><!--radio-->
                    							</div><!--post-type-box-->
                    						</div><!--col-sm-4-->
                    						<?php
                    					}
                    				}
                    			}
                    		}else{
                    			if($classieraRegularAdsOn == 1){
                    				?>
                    				<!--Regular Ad-->
                    				<div class="col-sm-4 col-md-3 col-lg-3 active-post-type">
                    					<div class="post-type-box">
                    						<h3 class="text-uppercase"><?php esc_html_e('Regular', 'classiera') ?></h3>
                    						<p>
                    							<?php
                    							esc_html_e('For', 'classiera');
                    							if($classieraRegularAdsDays == 'lifetime'){
                    								esc_html_e('Life time', 'classiera');
                    							}else{
                    								echo esc_attr($classieraRegularAdsDays);
                    							}										
                    							if($classieraRegularAdsDays !='lifetime'){
                    								esc_html_e('days', 'classiera');
                    							}
                    							?>
                    						</p>
                    						<div class="radio">
                    							<input id="regular" type="radio" name="classiera_post_type" value="classiera_regular" checked>
                    							<label for="regular"><?php esc_html_e('Select', 'classiera') ?></label>
                    						</div>
                    						<input type="hidden" name="regular-ads-enable" value=""  >
                    					</div>
                    				</div>
                    				<!--Regular Ad-->
                    				<?php
                    			}
                    		}
                    		?>
                    		<!--Regular Ad with plans-->
                    		<?php
                    		if(!empty($result)){
                    			foreach ( $result as $info ) {										
                    				$premiumID = $info->id;
                    				$name = $info->plan_name;
                    				$totalAds = $info->ads;
                    				$usedAds = $info->used;
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
                    								<?php esc_html_e('Featured with ', 'classiera') ?>&nbsp;<?php echo esc_html($name); ?>
                    							</h3>
                    							<p><?php esc_html_e('Total Ads Available', 'classiera') ?> : <?php echo esc_attr($availableADS); ?></p>
                    							<p><?php esc_html_e('Ads used with this plan', 'classiera') ?> : <?php echo esc_attr($usedAds); ?></p>
                    							<div class="radio">
                    								<input id="featured<?php echo esc_attr($premiumID); ?>" type="radio" name="classiera_post_type" value="<?php echo esc_attr($info->id); ?>">
                    								<label for="featured<?php echo esc_attr($premiumID); ?>">
                    									<?php esc_html_e('Select', 'classiera') ?>
                    								</label>
                    							</div>
                    						</div>
                    					</div>
                    					<?php
                    				}										
                    			}
                    		}
                    		?>	
                    		<!--Pay Per Post Per Category Base-->
                    		<div class="col-sm-4 col-md-3 col-lg-3 classieraPayPerPost">
                    			<div class="post-type-box">
                    				<h3 class="text-uppercase">
                    					<?php esc_html_e('Featured Ad', 'classiera') ?>
                    				</h3>	
                    				<p class="classieraPPP"></p>
                    				<div class="radio">
                    					<input id="payperpost" type="radio" name="classiera_post_type" value="payperpost">
                    					<label for="payperpost">
                    						<?php esc_html_e('select', 'classiera') ?>
                    					</label>
                    				</div>										
                    			</div>
                    		</div>
                    		<!--Pay Per Post Per Category Base-->
                    	</div>
                    </div>
                    <!--Select Ads Type-->
                    <?php 
                    $featured_plans = classiera_get_template_url('template-pricing-plans.php');
                    if(!empty($featured_plans)){
                    	foreach ($result as $info){											
                    		$featuredAdscheck = $info->ads;											
                    		if (is_numeric($featuredAdscheck)){
                    			$featuredAds += $info->ads;
                    			$featuredUsed += $info->used;
                    		}
                    		$featuredAvailable = $featuredAds-$featuredUsed;
                    	}
                    	if($featuredAvailable == "0" || empty($result)){
                    		?>
                    		<div class="row hidden">
                    			<div class="col-sm-9">
                    				<div class="help-block terms-use">
                    					<?php esc_html_e('Currently you have no active plan for featured ads. You must purchase a', 'classiera') ?> <strong><a href="<?php echo esc_url($featured_plans); ?>" target="_blank"><?php esc_html_e('Featured Pricing Plan', 'classiera') ?></a></strong> <?php esc_html_e('to be able to publish a Featured Ad.', 'classiera') ?>&nbsp;<?php esc_html_e('Or select any category to check single featured ads availability.', 'classiera') ?>
                    				</div>
                    			</div>
                    		</div>
                    	<?php }} ?>
                    	<div class="row hidden">
                    		<div class="col-sm-9">
                    			<div class="help-block terms-use">
                    				<?php esc_html_e('By clicking "Publish Ad", you agree to our', 'classiera') ?> <a href="<?php echo esc_url($termsandcondition); ?>" target="_blank"><?php esc_html_e('Terms of Use', 'classiera') ?></a> &amp; <a href="<?php echo esc_url($classiera_gdpr_url); ?>" target="_blank"><?php esc_html_e('GDPR', 'classiera') ?></a> <?php esc_html_e('and acknowledge that you are the rightful owner of this item', 'classiera') ?>
                    			</div>
                    		</div>
                    	</div>
                    	<div class="form-main-section publishbtn row" <?php if($classieraAllowPosts == false){ ?>style="display:none;" <?php } ?>>
                    		<div class="col-sm-4">								
                    			<input type="hidden" class="regular_plan_id" name="regular_plan_id" value="">
                    			<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
                    			<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
                    			<input type="hidden" name="submitted" id="submitted" value="true">
                    			<button class="post-submit btn btn-primary sharp btn-md btn-style-one btn-block" type="submit" name="op" value="Publish Ad"><?php esc_html_e('Publish Ad', 'classiera') ?></button>
                    		</div>
                    	</div>
                    </form>
                    <!-- <form action="/charge" method="post" id="payment-form">
                      <div class="form-row">
                        <label for="card-element">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          
                        </div>

                        
                        <div id="card-errors" role="alert"></div>
                      </div>

                      <button>Submit Payment</button>
                    </form> -->
                  </div><!--submit-post-->
                  <?php
                  if (is_user_logged_in() ) {	
                  	$authorVerified = get_the_author_meta('author_verified', $userID);
                  	if($authorVerified != 'verified'){ ?>
                  		<div class="alert alert-warning classiera_verified" role="alert">
                  			<p>
                  				<?php esc_html_e('You have not verify your account, please go to', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $classieraProfileSetting ); ?>"><?php esc_html_e('Profile Settings', 'classiera') ?></a>
                  				<?php esc_html_e('page and verify your account by email, otherwise NOT VERIFIED tag will be display with your account.', 'classiera') ?>
                  			</p>
                  		</div>
                  	<?php } } ?>
                </div><!--col-lg-9 col-md-8 user-content-heigh-->
              </div><!--row-->
            </div><!--container-->
          </section><!--user-pages-->
<?php endwhile; ?>
<div class="loader_submit_form">
	<img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader180.gif' ?>">
</div>
<?php if(!empty($classiera_google_api)){?>
<script type="text/javascript">
jQuery(document).ready(function($){
// 	var geocoder;
// 	var map;
// 	var marker;
// 	var geocoder = new google.maps.Geocoder();
// 	function geocodePosition(pos){
// 			geocoder.geocode({
// 			latLng: pos
// 		},function(responses){
// 			if (responses && responses.length > 0) {
// 			  updateMarkerAddress(responses[0].formatted_address);
// 			} else {
// 			  updateMarkerAddress('Cannot determine address at this location.');
// 			}
// 		});
// 	}
// 	function updateMarkerPosition(latLng){
// 		jQuery('#latitude').val(latLng.lat());
// 		jQuery('#longitude').val(latLng.lng());
// 	}
// 	function updateMarkerAddress(str){
// 		jQuery('#address').val(str);
// 	}
// 	function initialize(){
// 		var latlng = new google.maps.LatLng(0, 0);
// 		var mapOptions = {
// 			zoom: 2,
// 			center: latlng,
// 			draggable: true
// 		}
// 		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
// 		geocoder = new google.maps.Geocoder();
// 		marker = new google.maps.Marker({
// 			position: latlng,
// 			map: map,
// 			draggable: true
// 		});
// 		// Add dragging event listeners.
// 		google.maps.event.addListener(marker, 'dragstart', function() {
// 			updateMarkerAddress('Dragging...');
// 		});
// 		google.maps.event.addListener(marker, 'drag', function() {
// 			updateMarkerPosition(marker.getPosition());
// 		});
// 		google.maps.event.addListener(marker, 'dragend', function() {
// 			geocodePosition(marker.getPosition());
// 		});
// 	}
// 	google.maps.event.addDomListener(window, 'load', initialize);
// 	jQuery(document).ready(function(){
// 		initialize();
// 		jQuery(function(){
// 			jQuery("#address").autocomplete({
// 			  //This bit uses the geocoder to fetch address values
// 				source: function(request, response){
// 					geocoder.geocode( {'address': request.term }, function(results, status) {
// 				  		response(jQuery.map(results, function(item) {
// 						return {
// 							label:  item.formatted_address,
// 					  		value: item.formatted_address,
// 					  		latitude: item.geometry.location.lat(),
// 					  		longitude: item.geometry.location.lng()
// 						}
// 						}));
// 					})
// 				},
// 				//This bit is executed upon selection of an address
// 				select: function(event, ui) {
// 					jQuery("#latitude").val(ui.item.latitude);
// 					jQuery("#longitude").val(ui.item.longitude);
// 					var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
// 					marker.setPosition(location);
// 					map.setZoom(16);
// 					map.setCenter(location);
// 				}
// 			});
// 		});
// 		//Add listener to marker for reverse geocoding
// 		google.maps.event.addListener(marker, 'drag', function() {
// 			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
// 				if (status == google.maps.GeocoderStatus.OK) {
// 					if (results[0]) {
// 					  jQuery('#address').val(results[0].formatted_address);
// 					  jQuery('#latitude').val(marker.getPosition().lat());
// 					  jQuery('#longitude').val(marker.getPosition().lng());
// 					}
// 				}
// 			});
// 		});
// 	});

	//$("#classiera_regular").prop("checked", true);

	$(":file").change(function() {
		box_id = $(this).parent().parent().parent();
		var file_size = this.files[0].size;
		
// 		if( file_size > 400000){
//                 alert("please upload image less then 500 KB");
//         }else{
            if (this.files && this.files[0]) {
            //     var reader = new FileReader();
            //     var image = new Image();
            //     // reader.onload = imageIsLoaded;
            //     reader.onload = function(){
                   
                   
            
                    
               
        
            //     box_id.children('.centerer').children('.image').attr("src", reader.result);
                    
            //       //$(".image").attr("src", reader.result);
            //   	}
            //     reader.readAsDataURL(this.files[0]);
                // Load the image
                    var reader = new FileReader();
                    reader.onload = function (readerEvent) {
                        var image = new Image();
                        image.onload = function (imageEvent) {
            
                            // Resize the image
                            var canvas = document.createElement('canvas'),
                                max_size = 1200,
                                width = image.width,
                                height = image.height;
                                
                            if (width > height) {
                                if (width > max_size) {
                                    height *= max_size / width;
                                    width = max_size;
                                    
                                }
                            } else {
                                if (height > max_size) {
                                    width *= max_size / height;
                                    height = max_size;
                                    
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            
                            canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                            resizedImage = canvas.toDataURL('image/jpeg');
                            
                        //     box_id.children('.centerer').children('.image').attr("src", resizedImage);
                        // image.src = readerEvent.target.result;
                        }
                        box_id.children('.centerer').children('.image').attr("src", readerEvent.target.result);
                        image.src = readerEvent.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
            }
            box_id.removeClass('highlighted empty');
            box_id.children('.remove').removeClass('hidden');
            box_id.children('.rotate').removeClass('hidden');
            box_id.next('.user_image').addClass('highlighted empty');
            box_id.children('.centerer').children('.image_icon').addClass('hidden');
            box_id.children('.centerer').children('.text').addClass('hidden');
            box_id.children('.centerer').children('.image').css('display', 'inline');
            box_id.next('.user_image').children('.centerer').children('.image_icon').addClass('sprite_ai_camera_dark').removeClass('sprite_ai_camera_light');
        	
        // }
	});
    // box_id = $(this).parent().parent().parent();
    
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

    var grandTotal = 0;
		var discount_get = 0;
		var subtotal_get = 0;
		var ab_subtotal =  0;

		var discount =  0;
		var ab_totalPrice =0 ;
		var grandtotalPrice =0;

		var coupon_perc = $('.wpcd-coupon-id-3474 .wpcd-coupon-discount-text').text().match(/\d+/);
		// var coupon_perc_feature = $('.wpcd-coupon-id-3474 .wpcd-coupon-discount-text').text().match(/\d+/);
		// var coupon_perc_regular = $('.wpcd-coupon-id-3474 .wpcd-coupon-discount-text').text().match(/\d+/);
		// var coupon_perc_regular = $('.wpcd-coupon-id-3474 .wpcd-coupon-discount-text').text().match(/\d+/);
	$('#classiera_regular').click(function(){
		var regPrice = Number($('#regularPrice').val());
		
		if($('#classiera_regular').is(":checked"))
		{	
			// $('#regular_coupon').show();
			// $('#featured_coupon').hide();
			// $('#premium_coupon').hide();
			// $('#bump_coupon').hide();
      grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());
      console.log(grandTotal,discount_get,subtotal_get);

			ab_subtotal =  (regPrice)+(subtotal_get);

			discount =  ab_subtotal/coupon_perc;
			console.log(discount);
			ab_totalPrice =ab_subtotal-discount;
	      
      $('#inp_grand_total').val(ab_totalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(discount);
		  $('#grand_total').html(ab_totalPrice);
		}else{
			grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());

			ab_subtotal = (subtotal_get)-(regPrice);
			discount =  regPrice/coupon_perc;

			new_discount = regPrice-discount;

			console.log(new_discount);
			Ab_discount =discount_get-discount;

			// console.log(Ab_discount);
			ab_total_discount =grandTotal/discount;
			grandtotalPrice =grandTotal-new_discount;

			// console.log(ab_total_discount+' '+grandtotalPrice);

      $('#inp_grand_total').val(grandtotalPrice);
      $('#inp_discount').val(Ab_discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(Ab_discount);
		  $('#grand_total').html(grandtotalPrice);
		}
			
	});

	$('#classiera_featured').click(function(){
		var regPrice = Number($('#featurePrice').val());
		if($('#classiera_featured').is(":checked"))
		{
			// $('#regular_coupon').hide();
			// $('#featured_coupon').show();
			// $('#premium_coupon').hide();
			// $('#bump_coupon').hide();
			grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());

			ab_subtotal = (subtotal_get)+(regPrice);
      console.log(subtotal_get,regPrice);
			discount =  ab_subtotal/coupon_perc;
			console.log(discount);
			ab_totalPrice =ab_subtotal-discount;

      $('#inp_grand_total').val(ab_totalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(discount);
		  $('#grand_total').html(ab_totalPrice);
		}else{
			grandTotal =   Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());
			ab_subtotal = (subtotal_get)-(regPrice);
			discount =  regPrice/coupon_perc;

			new_discount = regPrice-discount;

			Ab_discount =discount_get-discount;

			console.log(Ab_discount);
			ab_total_discount =grandTotal/Ab_discount;
			grandtotalPrice =grandTotal-new_discount;

			console.log(ab_total_discount+' '+grandtotalPrice);

      $('#inp_grand_total').val(grandtotalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);
				 
			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(Ab_discount);
		  $('#grand_total').html(grandtotalPrice);
		}
	});

	$('#classiera_premium').click(function(){
		regPrice = Number($('#premiumPrice').val());
		if($('#classiera_premium').is(":checked"))
		{	
			// $('#regular_coupon').hide();
			// $('#featured_coupon').hide();
			// $('#premium_coupon').show();
			// $('#bump_coupon').hide();
      grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());
      console.log(grandTotal,discount_get,subtotal_get);

			ab_subtotal =  (regPrice)+(subtotal_get);
			console.log(ab_subtotal); 
			discount =  ab_subtotal/coupon_perc;
			console.log(discount);
			ab_totalPrice =ab_subtotal-discount;
	      
      $('#inp_grand_total').val(ab_totalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
			$('#discount').html(discount);
			$('#grand_total').html(ab_totalPrice);
		}else{
			grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());

			ab_subtotal = (subtotal_get)-(regPrice);
			discount =  regPrice/coupon_perc;

			Ab_discount =discount_get-discount;
			new_discount = regPrice-discount;

			console.log(Ab_discount);
			ab_total_discount =grandTotal/Ab_discount;
			grandtotalPrice =grandTotal-new_discount;

			console.log(ab_total_discount+' '+grandtotalPrice);

      $('#inp_grand_total').val(grandtotalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(Ab_discount);
		  $('#grand_total').html(grandtotalPrice);
		}
	});

	$('#classiera_week_renewal').click(function(){
		regPrice = Number($('#renewPrice').val());
		if($('#classiera_week_renewal').is(":checked"))
		{	
			// $('#regular_coupon').hide();
			// $('#featured_coupon').hide();
			// $('#premium_coupon').hide();
			// $('#bump_coupon').show();
      grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());
      console.log(grandTotal,discount_get,subtotal_get);

			ab_subtotal =  (regPrice)+(subtotal_get);

			discount =  ab_subtotal/coupon_perc;
			console.log(discount);
			ab_totalPrice =ab_subtotal-discount;
	      
      $('#inp_grand_total').val(ab_totalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(discount);
		  $('#grand_total').html(ab_totalPrice);
		}else{
			grandTotal =  Number($('#inp_grand_total').val());
      discount_get = Number($('#inp_discount').val());
      subtotal_get = Number($('#inp_sub_total').val());

			ab_subtotal = (subtotal_get)-(regPrice);
			discount =  regPrice/coupon_perc;

			Ab_discount =discount_get-discount;
			new_discount = regPrice-discount;

			console.log(Ab_discount);
			ab_total_discount =grandTotal/Ab_discount;
			grandtotalPrice =grandTotal-new_discount;

			// console.log(ab_total_discount+' '+grandtotalPrice);

      $('#inp_grand_total').val(grandtotalPrice);
      $('#inp_discount').val(discount);
      $('#inp_sub_total').val(ab_subtotal);

			$('#sub_total').html(ab_subtotal);
		  $('#discount').html(Ab_discount);
		  $('#grand_total').html(grandtotalPrice);
		}
	});
	
	
	$('.classiera-main-cat-field').on('change', function(){
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


});
</script>
<!-- <script src="https://js.stripe.com/v3/"></script> -->
<script>
    // Create a Stripe client.
var stripe = Stripe('pk_test_51Gzo9zEjbxiB0vaPUMeXfDbLtEfrhBU662ir6cSZHuJEjeUi2qWMsnPjzKue0WGRp7xAFGQh1iwOvKFyV1zZggvD00kwVQ2Xms');
//alert(stripe);
// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      $('#pay_btn').prop('disabled', true);
      $('#pay_btn').html('Processing ...');
      $('#pay_btn').addClass('btn-green');
      $('#pay_btn').css({'background':'#10C5A7', 'color':'white'});
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>
<?php } ?>
<?php get_footer(); ?>