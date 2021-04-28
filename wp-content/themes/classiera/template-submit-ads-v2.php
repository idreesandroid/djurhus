<?php
/**
 * Template name: Submit Ads FullWidth
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

if ( !is_user_logged_in() ) {
	global $redux_demo; 
	$login = classiera_get_template_url('template-login.php');
	if(empty($login)){
		$login = classiera_get_template_url('template-login-v2.php');
	}
	wp_redirect( $login ); exit;
}
$errorMsg = '';
$post_priceError = '';
$availableADS = '';
$catError = '';
$featPlanMesage = '';
$postContent = '';
$hasError = false;
$allowed ='';
$caticoncolor="";
$category_icon_code ="";
$classieraCatIconCode ="";
$category_icon="";
$category_icon_color="";
global $redux_demo;
$featuredADS = '';
$primaryColor = $redux_demo['color-primary'];
$post_whatsapp_on = $redux_demo['post_whatsapp_on'];
$googleFieldsOn = $redux_demo['google-lat-long'];
$classieraLatitude = $redux_demo['contact-latitude'];
$classieraLongitude = $redux_demo['contact-longitude'];
$postCurrency = $redux_demo['classierapostcurrency'];
$termsandcondition = $redux_demo['termsandcondition'];
$classiera_gdpr_url = $redux_demo['classiera_gdpr_url'];
$classieraAddress = $redux_demo['classiera_address_field_on'];
$classiera_google_api = $redux_demo['classiera_google_api'];
$classiera_post_web_url = $redux_demo['classiera_post_web_url'];
$classieracat_icon = $redux_demo['classiera_submit_cat_icon'];
$classieraProfileURL = classiera_get_template_url('template-profile.php');
$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
$classiera_bid_system = $redux_demo['classiera_bid_system'];
$classiera_locations_input = $redux_demo['classiera_locations_input'];
$paidIMG = $redux_demo['premium-ads-limit'];
$regularIMG = $redux_demo['regular-ads-limit'];	
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
if(isset($_POST['postTitle'])) {
	if(trim($_POST['postTitle']) != '' && $_POST['classiera-main-cat-field'] != '') {
		
		if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
			if(empty($_POST['postTitle'])){
				$errorMsg =  esc_html__( 'Please enter a title.', 'classiera' );
				$hasError = true;
			}else{
				$postTitle = trim($_POST['postTitle']);
			}
			if(empty($_POST['classiera-main-cat-field'])){
				$errorMsg = esc_html__( 'Please select a category', 'classiera' );
				$hasError = true;
			}
			
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
					$errorMsg = esc_html__( 'You selected Images Count is exceeded', 'classiera' );
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
						$postStatus = 'private';
					}else{
						$postStatus = 'publish';
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
				if(empty($classieraChildCat)){
					$classieraCategory = $classieraMainCat;
				}else{
					$classieraCategory = $classieraChildCat;
				}
				if(empty($classieraCategory)){
					$classieraCategory = $classieraMainCat;
				}
				/*== Setup Post Data ==*/
				$post_information = array(
					'post_title' => esc_attr(strip_tags($_POST['postTitle'])),			
					'post_content' => strip_tags($_POST['postContent'], '<h1><h2><h3><strong><b><ul><ol><li><i><a><blockquote><center><embed><iframe><pre><table><tbody><tr><td><video><br>'),
					'post-type' => 'post',
					'post_category' => array($classieraMainCat, $classieraChildCat, $classieraThirdCat),
					'tags_input'    => explode(',', $_POST['post_tags']),
					'tax_input' => array(
					'location' => $_POST['post_location'],
					),
					'comment_status' => 'open',
					'ping_status' => 'open',
					'post_status' => $postStatus
				);

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
				if(isset($_POST['classiera_CF_Front_end'])){
					$classiera_CF_Front_end = $_POST['classiera_CF_Front_end'];
					update_post_meta($post_id, 'classiera_CF_Front_end', $classiera_CF_Front_end);
				}
				if(isset($_POST['classiera_CF_Front_end'])){
					$classiera_sub_fields = $_POST['classiera_sub_fields'];
					update_post_meta($post_id, 'classiera_sub_fields', $classiera_sub_fields);
				}
				/*== Setup Price ==*/
				if(isset($_POST['post_currency_tag'])){
					$postMultiTag = $_POST['post_currency_tag'];
					update_post_meta($post_id, 'post_currency_tag', $postMultiTag, $allowed);
				}
				if(isset($_POST['post_price'])){
					$post_price = $_POST['post_price'];
					update_post_meta($post_id, 'post_price', $post_price, $allowed);
				}
				if(isset($_POST['post_old_price'])){
					$post_old_price = $_POST['post_old_price'];
					update_post_meta($post_id, 'post_old_price', $post_old_price, $allowed);
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
				if(isset($_POST['classiera_allow_bids'])){
					update_post_meta($post_id, 'classiera_allow_bids', $_POST['classiera_allow_bids'], $allowed);
				}
				if(isset($_POST['seller'])){
					update_post_meta($post_id, 'seller', $_POST['seller'], $allowed);
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
				if(isset($_POST['video'])){
					update_post_meta($post_id, 'post_video', $_POST['video'], $allowed);
				}
				if(isset($_POST['item-condition'])){
					$itemCondition = $_POST['item-condition'];
					update_post_meta($post_id, 'item-condition', $itemCondition, $allowed);
				}
				if(isset($_POST['classiera_post_type'])){
					update_post_meta($post_id, 'classiera_post_type', $_POST['classiera_post_type'], $allowed);
				}
				if(isset($_POST['pay_per_post_product_id'])){
					update_post_meta($post_id, 'pay_per_post_product_id', $_POST['pay_per_post_product_id'], $allowed);
				}
				if(isset($_POST['days_to_expire'])){
					update_post_meta($post_id, 'days_to_expire', $_POST['days_to_expire'], $allowed);
				}
				if(isset($_POST['classiera_featured_img'])){
					$featuredIMG = $_POST['classiera_featured_img'];
					update_post_meta($post_id, 'featured_img', $featuredIMG, $allowed);
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
				if(isset($_POST['post_location'])){
					update_post_meta($post_id, 'post_location', wp_kses($postCounty, $allowed));
				}
				if(isset($_POST['post_web_url'])){
					update_post_meta($post_id, 'post_web_url', $_POST['post_web_url'], $allowed);
				}
				if(isset($_POST['post_web_url_txt'])){
					update_post_meta($post_id, 'post_web_url_txt', $_POST['post_web_url_txt'], $allowed);
				}
				update_post_meta($post_id, 'post_latitude', wp_kses($latitude, $allowed));
				update_post_meta($post_id, 'post_longitude', wp_kses($longitude, $allowed));
				update_post_meta($post_id, 'custom_field', $custom_fields);
				
				/*== Set Permalinks ==*/
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
						$current_user = wp_get_current_user();
						$userID = $current_user->ID;						
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
				/*== If Its posting featured image ==*/
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
									classiera_insert_attachment($file,$post_id);
								}
								$count++;
							}

						}

					}/*== Foreach ==*/			

				}
				wp_redirect( $permalink ); exit;
			}
		} 
		
	}else{
		if(trim($_POST['postTitle']) === '') {
			$errorMsg = esc_html__( 'Please enter a title.', 'classiera' );	
			$hasError = true;
		}
		if($_POST['classiera-main-cat-field'] === '-1') {
			$errorMsg = esc_html__( 'Please select a category.', 'classiera' );
			$hasError = true;
		} 
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
			<div class="col-lg-12 user-content-height">
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
				$currentRole = $role[0];
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
				if($classieraAllowPosts == false){
					?>
				<div class="alert alert-warning" role="alert">
					  <p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong><?php esc_html_e('You Ads Posts limit are exceeded, Please Purchase a Plan for posting More Ads.', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $featured_plans ); ?>"><?php esc_html_e('Purchase Plan', 'classiera') ?></a></p>
					  <p><?php esc_html_e('Or select any category to check single featured ads availability.', 'classiera') ?></p>
				</div>
				<?php } ?>
				<?php if($hasError == true){ ?>
				<div class="alert alert-warning" role="alert">
					<p><strong><?php esc_html_e('Hello.', 'classiera') ?></strong>
					<?php echo esc_html($errorMsg); ?>
					<p>
				</div>
				<?php } ?>
				<?php
				$authorVerified = get_the_author_meta('author_verified', $userID);
				if($authorVerified != 'verified'){ ?>
					<div class="alert alert-warning" role="alert">
						<p>
						<?php esc_html_e('You have not verify your account, please go to', 'classiera') ?>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo esc_url( $classieraProfileSetting ); ?>"><?php esc_html_e('Profile Settings', 'classiera') ?></a>
						<?php esc_html_e('page and verify your account by email, otherwise NOT VERIFIED tag will be display with your account.', 'classiera') ?>
						</p>
					</div>
				<?php } ?>
				<div class="submit-post submit-post-v2 section-bg-white">
					<form class="form-horizontal" action="" role="form" id="primaryPostForm" method="POST" data-toggle="validator" enctype="multipart/form-data">
						<h3 class="text-uppercase border-bottom"><?php esc_html_e('MAKE NEW AD', 'classiera') ?></h3>
						<!--Category-->
						<div class="form-main-section classiera-post-cat">
							<div class="classiera-post-main-cat">
								<!--Title-->
								<div class="form-group">
                                    <label class="col-sm-3 control-label" for="title"><?php esc_html_e('Ad title', 'classiera') ?> : <span>*</span></label>
                                    <div class="col-sm-8">
										<input id="title" data-minlength="5" name="postTitle" type="text" class="form-control form-control-md" placeholder="<?php esc_attr_e('Ad Title Goes here', 'classiera') ?>" required>
                                        <div class="help-block text-right flip"><?php esc_html_e('type minimum 5 characters', 'classiera') ?></div>
                                    </div>
                                </div>
								<!--Title-->
								<!--Category-->
								<div class="form-group">
									<label class="col-sm-3 control-label" for="title"><?php esc_html_e('Category', 'classiera') ?> : <span>*</span>
									</label>
									<div class="col-sm-8">
										<ul class="list-unstyled list-inline">
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
											}
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
													if(isset($classieraCatFields[$tag]['category_icon_color'])){
														$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
													}
													if(isset($classieraCatFields[$tag]['category_image'])){
														$category_image = $classieraCatFields[$tag]['category_image'];
													}
												}
												if(empty($classieraCatIconClr)){
													$iconColor = $primaryColor;
												}else{
													$iconColor = $classieraCatIconClr;
												}
												$category_icon = stripslashes($classieraCatIconCode);
												?>
												<li class="match-height">
													<a href="#" id="<?php echo esc_attr( $tag ); ?>" class="border">
														<?php 
														if($classieracat_icon == 'awesome_icons'){
															?>
															<i class="<?php echo esc_html( $category_icon ); ?>" style="color:<?php echo esc_html( $iconColor ); ?>;"></i>
															<?php
														}elseif($classieracat_icon == 'map_pin'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_html(get_cat_name( $tag )); ?>">
															<?php
														}elseif($classieracat_icon == 'cat_thumbnail'){
															?>
															<img src="<?php echo esc_url( $category_image ); ?>" alt="<?php echo esc_html(get_cat_name( $tag )); ?>">
															<?php
														}
														?>		
														<span><?php echo esc_html(get_cat_name( $tag )); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul><!--list-unstyled-->
										<input class="classiera-main-cat-field" name="classiera-main-cat-field" type="hidden" value="">
									</div>
								</div>
								<!--Category-->								
							</div><!--classiera-post-main-cat-->
							<div class="classiera-post-sub-cat">
								<div class="form-group">
									<label class="col-sm-3 control-label" for="title"><?php esc_html_e('Select a Sub Category', 'classiera') ?> :<span>*</span>
									</label>
									<div class="col-sm-8">
										<ul class="list-unstyled classieraSubReturn"></ul>
										<input class="classiera-sub-cat-field" name="classiera-sub-cat-field" type="hidden" value="">
									</div>
								</div>
							</div><!--classiera-post-sub-cat-->
							<!--ThirdLevel-->
							<div class="classiera_third_level_cat">
								<div class="form-group">
									<label class="col-sm-3 control-label" for="title"><?php esc_html_e('Select a Sub Category', 'classiera') ?> :<span>*</span>
									</label>
									<div class="col-sm-8">
										<ul class="list-unstyled classieraSubthird"></ul>
										<input class="classiera_third_cat" name="classiera_third_cat" type="hidden" value="">
									</div>
								</div>
							</div>
							<!--ThirdLevel-->
						</div><!--form-main-section classiera-post-cat-->
						<!--Category-->
						<div class="form-main-section post-detail">
							<h4 class="text-uppercase border-bottom"><?php esc_html_e('Ad Details', 'classiera') ?> :</h4>
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Selected Category', 'classiera') ?> : </label>
                                <div class="col-sm-9">
                                    <p class="form-control-static"></p>
                                </div>
                            </div><!--Selected Category-->
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
							<div class="form-group classiera_aType">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Type of Ad', 'classiera') ?> : <span>*</span></label>
                                <div class="col-sm-9">
									<div class="form-inline row">
									<?php if($classieraShowSell == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5 active-post-type">
											<div class="post-type-box">
												<div class="radio">
                                                    <input id="sell" type="radio" value="sell" name="classiera_ads_type" checked>
                                                    <label for="sell"><?php esc_html_e('I want to sell', 'classiera') ?></label>
                                                </div>
											</div>
										</div>
									<?php } ?>
									<?php if($classieraShowBuy == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="buy" value="buy" type="radio" name="classiera_ads_type">
                                                    <label for="buy"><?php esc_html_e('I want to buy', 'classiera') ?></label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<?php if($classieraShowRent == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="rent" value="rent" type="radio" name="classiera_ads_type">
                                                    <label for="rent"><?php esc_html_e('I want to rent', 'classiera') ?></label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<?php if($classieraShowHire == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="hire" value="hire" type="radio" name="classiera_ads_type">
                                                    <label for="hire"><?php esc_html_e('I want to hire', 'classiera') ?></label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<!--Lost and Found-->
									<?php if($classieraShowFound == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="lostfound" value="lostfound" type="radio" name="classiera_ads_type">
                                                    <label for="lostfound">
														<?php esc_html_e('Lost & Found', 'classiera') ?>
													</label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<!--Lost and Found-->
									<!--Free-->
									<?php if($classieraShowFree == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="typefree" value="free" type="radio" name="classiera_ads_type">
                                                    <label for="typefree">
														<?php esc_html_e('I give for free', 'classiera') ?>
													</label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<!--Free-->
									<!--Event-->
									<?php if($classieraShowEvent == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="event" value="event" type="radio" name="classiera_ads_type">
                                                    <label for="event">
														<?php esc_html_e('I am an event', 'classiera') ?>
													</label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>	
									<!--Event-->
									<!--Professional service-->
									<?php if($classieraShowServices == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="service" value="service" type="radio" name="classiera_ads_type">
                                                    <label for="service">
														<?php esc_html_e('Professional service', 'classiera') ?>
													</label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>
									<!--Professional service-->
									<!--exchange-->
									<?php if($classieraShowexchange == 1){ ?>
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="exchange" value="exchange" type="radio" name="classiera_ads_type">
                                                    <label for="exchange">
														<?php esc_html_e('Exchange', 'classiera') ?>
													</label>
                                                </div>
                                            </div>
										</div>
									<?php } ?>
									<!--exchange-->
									</div><!--row-->
                                </div><!--col-sm-9-->
                            </div><!--Type of Ad-->	
							<?php } ?>
							<div class="form-group">                               
								<label class="col-sm-3 control-label" for="description"><?php esc_html_e('Ad description', 'classiera') ?> : <span>*</span></label>
                                <div class="col-sm-8">
                                    <textarea name="postContent" id="description" class="form-control" data-error="<?php esc_attr_e('Write description', 'classiera') ?>" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><!--Ad description-->
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Keywords', 'classiera') ?> : </label>
                                <div class="col-sm-8">
                                    <div class="form-inline row">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fas fa-tags"></i></div>
                                                <input type="text" name="post_tags" class="form-control form-control-md" placeholder="<?php esc_attr_e('enter keywords for better search..!', 'classiera') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="help-block"><?php esc_html_e('Keywords Example : ads, car, cat, business', 'classiera') ?></div>
                                </div>
                            </div><!--Ad Tags-->
							<!--ContactMobile-->
							<?php $classieraAskingPhone = $redux_demo['phoneon'];?>
							<?php if($classieraAskingPhone == 1){?>
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Phone/Mobile', 'classiera') ?> : </label>
                                <div class="col-sm-8">
                                    <div class="form-inline row">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-addon">
													<i class="fas fa-mobile-alt"></i>
												</div>
                                                <input type="text" name="post_phone" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your phone number or Mobile number', 'classiera') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="help-block"><?php esc_html_e('Its Not required, but if you will put phone here then it will show publicly', 'classiera') ?></div>
                                </div>
                            </div>
							<?php } ?>
							<?php if($post_whatsapp_on == true){ ?>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php esc_html_e('Your WhatsApp', 'classiera') ?> : </label>
								<div class="col-sm-8">
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
							<?php } ?>
							<!--ContactMobile-->
							<!--ContactEmail-->
							<?php $email_on = $redux_demo['email_on'];?>
							<?php if($email_on == 1){?>
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Email', 'classiera') ?> : </label>
                                <div class="col-sm-8">
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
							<!--ContactEmail-->
							<!--Website URL-->
							<?php if($classiera_post_web_url == true){ ?>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									<?php esc_html_e('Website URL :', 'classiera') ?>
								</label>
								<div class="col-sm-8">
									<div class="form-inline row">
										<div class="col-md-5 col-sm-6">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fas fa-link"></i>
												</div>
												<input type="text" name="post_web_url" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your website URL', 'classiera') ?>">
											</div>
										</div>
										<div class="col-md-5 col-sm-6">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fas fa-font"></i>
												</div>	
												<input type="text" name="post_web_url_txt" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter URL title', 'classiera') ?>">
											</div>
										</div>
									</div>
									<div class="help-block"><?php esc_html_e('Its Not required, but if you will insert URL then you must need to insert title.', 'classiera') ?></div>
								</div>
							</div>
							<?php } ?>
							<!--Website URL-->
							<?php 
							$classieraPriceSecOFF = $redux_demo['classiera_sale_price_off'];
							$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
							$regularpriceon= $redux_demo['regularpriceon'];
							$postCurrency = $redux_demo['classierapostcurrency'];
							$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
							?>
							<?php if($classieraPriceSecOFF == 1){?>
							<div class="form-group classiera_hide_price">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Ad price', 'classiera') ?> : </label>
                                <div class="col-sm-8">
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
                                        <div class="col-md-5 col-sm-6">
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
                                                <input type="text" name="post_price" class="form-control form-control-md" placeholder="<?php esc_attr_e('Sale Price', 'classiera') ?>">
                                            </div>
                                        </div>										
										<?php if($regularpriceon == 1){?>
                                        <div class="col-md-5 col-sm-6">
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
                                                <input type="text" name="post_old_price" class="form-control form-control-md" placeholder="<?php esc_attr_e('Regular price', 'classiera') ?>">
                                            </div>
                                        </div>
										<?php } ?>
                                    </div>								
									<?php if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){?>
                                    <div class="help-block"><strong><?php esc_html_e('Currency sign is already set as', 'classiera') ?>&nbsp;<?php echo esc_html( $postCurrency );?>&nbsp;<?php esc_html_e('Please do not use currency sign in price field. Only use numbers ex: 12345', 'classiera') ?></strong></div>
									<?php } ?>
                                </div>
                            </div><!--Ad Price-->
							<?php } ?>
							<!--Bidding System-->
							<?php if($classiera_bid_system == true){ ?>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									<?php esc_html_e('Bidding', 'classiera') ?> : <span>*</span>
								</label>
								<div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-lg-3 col-md-4 col-sm-5 active-post-type">
											<div class="post-type-box">
												<div class="radio">
													<input id="allowbid" value="allow" type="radio" name="classiera_allow_bids" checked>
													<label for="allowbid">
														<?php esc_html_e('Allow users to bid on this ad.', 'classiera') ?>
													</label>
												</div><!--radio-->
											</div><!--post-type-box-->
										</div><!--col-lg-3-->
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
												<div class="radio">
													<input id="disallowbid" value="disallow" type="radio" name="classiera_allow_bids">
													<label for="disallowbid">
														<?php esc_html_e('Disallow bids from this ad.', 'classiera') ?>
													</label>
												</div><!--radio-->
											</div><!--post-type-box-->
										</div><!--col-lg-3-->
									</div><!--form-inline row-->
									<div class="help-block"><?php esc_html_e('From here you can disable user bidding option on your current ad.', 'classiera') ?></div><!--help-block-->
								</div><!--col-sm-9-->
							</div>
							<?php } ?>
							<!--Bidding System-->							
							<?php 
								$adpostCondition= $redux_demo['adpost-condition'];
								if($adpostCondition == 1){
							?>
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Item Condition', 'classiera') ?> : <span>*</span></label>
                                <div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-lg-3 col-md-4 col-sm-5 active-post-type">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="new" type="radio" name="item-condition" value="new" name="item-condition" checked>
                                                    <label for="new"><?php esc_html_e('Brand New', 'classiera') ?></label>
                                                </div>
                                            </div>
										</div><!--col-lg-3-->
										<div class="col-lg-3 col-md-4 col-sm-5">
											<div class="post-type-box">
                                                <div class="radio">
                                                    <input id="used" type="radio" name="item-condition" value="used" name="item-condition">
                                                    <label for="used"><?php esc_html_e('Used', 'classiera') ?></label>
                                                </div>
                                            </div>
										</div><!--col-lg-3-->
									</div><!--form-inline-->
                                </div><!--col-sm-9-->
                            </div><!--Item condition-->
								<?php } ?>
						</div><!---form-main-section post-detail-->
						<!-- extra fields -->
						<div class="classieraExtraFields" style="display:none;"></div>
						<!-- extra fields -->
						<!-- add photos and media -->
						<div class="form-main-section media-detail">
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
								foreach ( $result as $info ) {										
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
							?>
                            <h4 class="text-uppercase border-bottom"><?php esc_html_e('Image And Video', 'classiera') ?> :</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Photos and Video for your ad', 'classiera') ?> :</label>
                                <div class="col-md-7 col-sm-9">
									<!--dropzone-->
									<div class="dropzone dz-clickable mb-4" id="classiera_dropzone" data-max-file="<?php echo esc_attr( $imageLimit ); ?>">
										<div class="dz-default dz-message" data-dz-message="">
											<p class="text-center"><i class="far fa-images fa-3x"></i></p>
											<span><?php esc_html_e( 'Drop files here to upload', 'classiera' ); ?></span>
											<span><?php esc_html_e( 'or', 'classiera' ); ?></span>
											<strong>
												<?php esc_html_e( 'Click here', 'classiera' ); ?>
											</strong>
											<span><?php esc_html_e( 'to select images', 'classiera' ); ?></span>
											<p class="text-muted">(<?php esc_html_e( 'Your first image will be used as a featured image, and it will be shown as thumbnail.', 'classiera' ); ?>)</p>
										</div>
										<div class="dz-max-file-msg">
											<div class="alert alert-danger text-center">
												<?php esc_html_e( 'We are sorry but your upload limit is reached.', 'classiera' ); ?>
												<?php esc_html_e('You can upload', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images maximum.', 'classiera') ?>
											</div>
										</div>
										<div class="dz-remove" data-dz-remove>
											<span><?php esc_html_e('Remove', 'classiera') ?></span>
										</div>								
									</div>
									<p class="visible-xs visible-sm alert alert-warning classiera_img_info">
										<strong><?php esc_html_e('Alert', 'classiera') ?> :</strong>
										<?php esc_html_e('If you are using Opera, UC Browser, Firefox or KaiOS Mobile browser then you need to select images one by one, multi selection is not supported by these browsers.', 'classiera') ?>
									</p>
									<p class="alert alert-info classiera_img_info">
										<strong><?php esc_html_e('Note', 'classiera') ?> :</strong>
										<?php esc_html_e('You can upload maximum', 'classiera') ?>&nbsp;<?php echo esc_attr( $imageLimit ); ?>&nbsp;<?php esc_html_e('images .', 'classiera') ?>
										<?php esc_html_e('If you are posting a regular ad then select only', 'classiera') ?>&nbsp;<?php echo esc_attr( $regularIMG ); ?>&nbsp;<?php esc_html_e('images, otherwise you will not be able to post your ad.', 'classiera') ?>
									</p>
									<!--drop-zone-->					
									<?php 
									$classiera_video_postads = $redux_demo['classiera_video_postads'];
									if($classiera_video_postads == 1){
									?>
                                    <div class="iframe">
                                        <div class="iframe-heading">
                                            <i class="fas fa-video"></i>
                                            <span><?php esc_html_e('Put here iframe or video url.', 'classiera') ?></span>
                                        </div>
                                        <textarea class="form-control" name="video" id="video-code" placeholder="<?php esc_attr_e('Put here iframe or video url.', 'classiera') ?>"></textarea>
                                        <div class="help-block">
                                            <p><?php esc_html_e('Add iframe or video URL (iframe 710x400) (youtube, vimeo, etc)', 'classiera') ?></p>
                                        </div>
                                    </div>
									<?php } ?>
                                </div>
                            </div>
                        </div>
						<!-- add photos and media -->
						<!-- post location -->
						<?php
						$classiera_ad_location_remove = $redux_demo['classiera_ad_location_remove'];
						if($classiera_ad_location_remove == 1){
						?>
						<div class="form-main-section post-location">
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
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Select Country', 'classiera') ?>: <span>*</span></label>
                                <div class="col-md-4 col-sm-6">
                                    <div class="inner-addon right-addon input-group">
										<div class="input-group-addon">
											<i class="fas fa-globe"></i>
										</div>
                                        <i class="form-icon right-form-icon fas fa-angle-down"></i>
                                        <select name="post_location" id="post_location" class="form-control form-control-md">
                                            <option value="-1" selected disabled><?php esc_html_e('Select Country', 'classiera'); ?></option>
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
							$locationsStateOn = $redux_demo['location_states_on'];
							if($locationsStateOn == 1){
								if($classiera_locations_input == 'input'){
									?>
									<div class="form-group">
										<label class="col-sm-3 control-label">
											<?php esc_html_e('State', 'classiera'); ?>  : 
										</label>
										<div class="col-sm-8">
											<div class="form-inline row">
												<div class="col-sm-12">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fas fa-globe"></i>
														</div>
														<input type="text" name="post_state" class="form-control form-control-md" placeholder="<?php esc_attr_e('Type your state name..!', 'classiera') ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
								}else{
								?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php esc_html_e('Select State', 'classiera') ?>: <span>*</span></label>
									<div class="col-md-4 col-sm-6">
										<div class="inner-addon right-addon input-group">
											<div class="input-group-addon">
												<i class="fas fa-globe"></i>
											</div>
											<i class="form-icon right-form-icon fas fa-angle-down"></i>
											<select name="post_state" id="post_state" class="selectState form-control form-control-md" required>
												<option value=""><?php esc_html_e('Select State', 'classiera'); ?></option>
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
										<label class="col-sm-3 control-label">
											<?php esc_html_e('City', 'classiera'); ?>  : 
										</label>
										<div class="col-sm-8">
											<div class="form-inline row">
												<div class="col-sm-12">
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fas fa-globe"></i>
														</div>
														<input type="text" name="post_city" class="form-control form-control-md" placeholder="<?php esc_attr_e('Type your city name..!', 'classiera') ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
								}else{
								?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php esc_html_e('Select City', 'classiera'); ?>: <span>*</span></label>
									<div class="col-md-4 col-sm-6">
										<div class="inner-addon right-addon input-group">
											<div class="input-group-addon">
												<i class="fas fa-globe"></i>
											</div>
											<i class="form-icon right-form-icon fas fa-angle-down"></i>
											<select name="post_city" id="post_city" class="selectCity form-control form-control-md" required>
												<option value=""><?php esc_html_e('Select City', 'classiera'); ?></option>
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
                                <label class="col-sm-3 control-label"><?php esc_html_e('Address', 'classiera'); ?> : <span>*</span></label>
                                <div class="col-sm-6">
									<div class="form-inline row">
										<div class="col-sm-12">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fas fa-route"></i>
												</div>
												<input id="address" type="text" name="address" class="form-control form-control-md" placeholder="<?php esc_attr_e('Address or City', 'classiera') ?>" required>
											</div><!--input-group-->
										</div><!--col-sm-12-->
									</div>
                                </div>
                            </div>
							<?php } ?>
							<!--Address-->
							<!--Google Value-->
							<div class="form-group">
								<?php 
									$googleFieldsOn = $redux_demo['google-lat-long']; 
									if($googleFieldsOn == 1){
								?>
                                <label class="col-sm-3 control-label"><?php esc_html_e('Set Latitude & Longitude', 'classiera') ?> :</label>
									<?php } ?>
                                <div class="col-md-6 col-sm-8">
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
                                    <div id="post-map" class="submitMAp">
                                        <div id="map-canvas"></div>
                                    </div>
									<?php } ?>
                                </div>
                            </div>
							<!--Google Value-->
						</div>
						<?php } ?>
						<!-- post location -->
						<!-- seller information without login-->
						<?php if( !is_user_logged_in()){?>
						<div class="form-main-section seller">
                            <h4 class="text-uppercase border-bottom"><?php esc_html_e('Seller Information', 'classiera') ?> :</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Are', 'classiera') ?> : <span>*</span></label>
                                <div class="col-sm-9">
									<div class="form-inline row">
										<div class="col-md-3 col-sm-6 active-post-type">
                                            <div class="post-type-box">
                                                <div class="radio">
                                                    <input id="individual" type="radio" name="seller" checked>
                                                    <label for="individual"><?php esc_html_e('Individual', 'classiera') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="post-type-box">
                                                <div class="radio">
                                                    <input id="dealer" type="radio" name="seller">
                                                    <label for="dealer"><?php esc_html_e('Dealer', 'classiera') ?></label>
                                                </div>
                                            </div>
                                        </div>
									</div><!--form-inline row-->
                                </div><!--col-sm-9-->
                            </div><!--form-group-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Name', 'classiera') ?>: <span>*</span></label>
                                <div class="col-md-4 col-sm-6">
                                    <input type="text" name="user_name" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter Your Name', 'classiera') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Email', 'classiera') ?> : <span>*</span></label>
                                <div class="col-md-4 col-sm-6">
                                    <input type="email" name="user_email" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your email', 'classiera') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php esc_html_e('Your Phone or Mobile No', 'classiera') ?> :<span>*</span></label>
                                <div class="col-md-4 col-sm-6">
                                    <input type="tel" name="user_phone" class="form-control form-control-md" placeholder="<?php esc_attr_e('Enter your Mobile or Phone number', 'classiera') ?>">
                                </div>
                            </div>
                        </div>
						<?php }?>
						<!-- seller information without login -->
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
						<div class="form-main-section post-type">
                            <h4 class="text-uppercase border-bottom"><?php esc_html_e('Select Ad Post Type', 'classiera') ?> :</h4>
                            <p class="col-md-offset-3 help-block"><?php esc_html_e('Select an Option to make your ad featured or regular', 'classiera') ?></p>
                            <div class="form-group">
								<!--Regular Ad with plans-->
								<?php 
								if($postLimitOn == true && $countPosts >= $regularCount && $currentRole != "administrator"){
									if(!empty($result)){
										$count = 0;
										foreach( $result as $info ){
											$regularID = $info->id;
											$totalRegularAds = $info->regular_ads;
											$usedRegularAds = $info->regular_used;
											$availableRegularADS = $totalRegularAds-$usedRegularAds;
											$planName = $info->plan_name;
											if($availableRegularADS != 0){
											?>
											<div class="col-md-offset-3 col-sm-4 col-md-2 col-lg-2 end">
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
											</div><!--col-md-offset-3-->
											<?php
											}
										}
									}
								}else{
									if($classieraRegularAdsOn == 1 ){ ?>
										<div class="col-md-offset-3 col-sm-4 col-md-2 col-lg-2 active-post-type end">
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
									<?php }  ?>
								<?php } ?>
								<!--Regular Ad with plans-->
								<?php 
									if(!empty($result)){
										foreach($result as $info){
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
												<div class="col-sm-4 col-md-2 col-lg-2 end">
													<div class="post-type-box">
														<h3 class="text-uppercase">
															<?php esc_html_e('Featured with ', 'classiera') ?>&nbsp;<?php echo esc_html($name); ?>
														</h3>
														<p>
															<?php esc_html_e('Total Ads Available', 'classiera') ?> : 
															<?php echo esc_attr($availableADS); ?>
														</p>
														<p>
															<?php esc_html_e('Used Ads with this Plan', 'classiera') ?> : 
															<?php echo esc_attr($usedAds); ?>
														</p>
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
								<div class="col-sm-4 col-md-2 col-lg-2 classieraPayPerPost">
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
										</DIV>
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
						<div class="row">
                            <div class="col-md-offset-3 col-sm-7">
                                <div class="help-block terms-use">
                                    <?php esc_html_e('Currently you have no active plan for featured ads. You must purchase a', 'classiera') ?> <strong><a href="<?php echo esc_url($featured_plans); ?>" target="_blank"><?php esc_html_e('Featured Pricing Plan', 'classiera') ?></a></strong> <?php esc_html_e('to be able to publish a Featured Ad.', 'classiera') ?>&nbsp;<?php esc_html_e('Or select any category to check single featured ads availability.', 'classiera') ?>
                                </div>
                            </div>
                        </div>
						<?php }} ?>
						<div class="row">
                            <div class="col-md-offset-3 col-sm-7">
                                <div class="help-block terms-use">
                                    <?php esc_html_e('By clicking "Publish Ad", you agree to our', 'classiera') ?> <a href="<?php echo esc_url($termsandcondition); ?>" target="_blank"><?php esc_html_e('Terms of Use', 'classiera') ?></a> &amp; <a href="<?php echo esc_url($classiera_gdpr_url); ?>" target="_blank"><?php esc_html_e('GDPR', 'classiera') ?></a> <?php esc_html_e('and acknowledge that you are the rightful owner of this item', 'classiera') ?>
                                </div>
                            </div>
                        </div>
						<div class="form-main-section publishbtn" <?php if($classieraAllowPosts == false){ ?>style="display:none;" <?php } ?>>
                            <div class="col-sm-4 col-md-offset-3">
								<input type="hidden" class="regular_plan_id" name="regular_plan_id" value="">
								<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
								<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
								<input type="hidden" name="submitted" id="submitted" value="true">
                                <button class="post-submit btn btn-primary sharp btn-md btn-style-one btn-block" type="submit" name="op" value="Publish Ad"><?php esc_html_e('Publish Ad', 'classiera') ?></button>
                            </div>
                        </div>
					</form>
				</div><!--submit-post-->
			</div><!--col-lg-9 col-md-8 user-content-heigh-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->
<?php endwhile; ?>
<div class="loader_submit_form">
	<img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader180.gif' ?>">
</div>
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<!-- Company Section End-->	
<?php if(!empty($classiera_google_api)){?>
<script type="text/javascript">
jQuery(document).ready(function($){
	var geocoder;
	var map;
	var marker;
	var geocoder = new google.maps.Geocoder();
	function geocodePosition(pos){
			geocoder.geocode({
			latLng: pos
		},function(responses){
			if (responses && responses.length > 0) {
			  updateMarkerAddress(responses[0].formatted_address);
			} else {
			  updateMarkerAddress('Cannot determine address at this location.');
			}
		});
	}
	function updateMarkerPosition(latLng){
		jQuery('#latitude').val(latLng.lat());
		jQuery('#longitude').val(latLng.lng());
	}
	function updateMarkerAddress(str){
		jQuery('#address').val(str);
	}
	function initialize(){
		var latlng = new google.maps.LatLng(0, 0);
		var mapOptions = {
			zoom: 2,
			center: latlng,
			draggable: true
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
	jQuery(document).ready(function(){
		initialize();
		jQuery(function(){
			jQuery("#address").autocomplete({
			  //This bit uses the geocoder to fetch address values
				source: function(request, response){
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
<?php } ?>
<?php get_footer(); ?>