<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>


<?php 
global $errorMessage, $emailError, $commentError, $subjectError, $humanTestError, $hasError;
global $redux_demo, $allowed_html, $classiera_allow_bids, $current_user, $post; 
$category_icon_code = "";
$category_icon_color = "";
$classieraMapStyle = "";
$your_image_url = "";
$classieraComments = true;
$classieraAuthorInfo = true;
$classieraAuthoremail = false;
$relatedAdsOn = true;
$classieraCompany = false;
$classieraMAPDragging = false;
$classieraMAPScroll = false;
$googleMapadPost = false;
$classieraSearchStyle = 1;
$classieraSingleAdStyle = 1;
$classieraToAuthor = '';
$classieraReportAd = '';
$classiera_bid_system = '';
$locShownBy = 'post_location';
$termsandcondition = '';
$classiera_MAP_location = 'sidebar';
$current_user = wp_get_current_user(); 
$current_user_ID = $current_user->ID;
$postAuthorID = $post->post_author;
$profileLink = get_the_author_meta( 'user_url', $postAuthorID );
$contact_email = get_the_author_meta('user_email', $postAuthorID);
if(isset($redux_demo)){
	$classieraContactEmailError = $redux_demo['contact-email-error'];
	$classieraContactEmail = $redux_demo['contact-email'];
	$classieraContactNameError = $redux_demo['contact-name-error'];
	$classieraConMsgError = $redux_demo['contact-message-error'];
	$classieraContactThankyou = $redux_demo['contact-thankyou-message'];
	$classieraRelatedCount = $redux_demo['classiera_related_ads_count'];
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraSingleAdStyle = $redux_demo['classiera_single_ad_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classieraComments = $redux_demo['classiera_sing_post_comments'];
	$googleMapadPost = $redux_demo['google-map-adpost'];
	$classieraToAuthor = $redux_demo['author-msg-box-off'];
	$classieraReportAd = $redux_demo['classiera_report_ad'];
	$locShownBy = $redux_demo['location-shown-by'];
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$classieraAuthorInfo = $redux_demo['classiera_author_contact_info'];
	$classieraAuthoremail = $redux_demo['classiera_author_contact_email'];
	$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
	$classiera_bid_system = $redux_demo['classiera_bid_system'];	
	$relatedAdsOn = $redux_demo['related-ads-on'];	
	$classieraCompany = $redux_demo['partners-on'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classieraMapStyle = $redux_demo['map-style'];
	$classiera_MAP_location = $redux_demo['classiera_map_post_location'];
	$classieraMAPDragging = $redux_demo['classiera_map_dragging'];	
	$classieraMAPScroll = $redux_demo['classiera_map_scroll'];
	$termsandcondition = $redux_demo['termsandcondition'];
	$classiera_gdpr_url = $redux_demo['classiera_gdpr_url'];	
}

$current_user = wp_get_current_user();
$sender_name=$current_user->display_name;


$login_user_id = $current_user->ID;
$classieraAuthorEmail = $current_user->user_email;
$classieraDisplayName = $current_user->display_name;
if(empty($classieraDisplayName)){
	$classieraDisplayName = $current_user->user_nicename;
}
if(empty($classieraDisplayName)){
	$classieraDisplayName = $current_user->user_login;
}
$login_user_IMG = get_user_meta($login_user_id, "classify_author_avatar_url", true);
$login_user_IMG = classiera_get_profile_img($login_user_IMG);
if(empty($login_user_IMG)){
	$login_user_IMG = classiera_get_avatar_url ($classieraAuthorEmail, $size = '150' );
}

/*==========================
If the form is submitted
===========================*/
if(isset($_POST['submit'])) {
	if($_POST['submit'] == 'send_message'){
		$hasError = false;	
		/*==========================
		Check to make sure that the name field is not empty
		===========================*/
		if(trim($_POST['contactName']) === '') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$errorMessage = $classieraContactNameError;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}
		/*==========================
		Check to make sure that the subject field is not empty
		===========================*/		
		if(trim($_POST['subject']) === '') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$errorMessage = $classiera_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		/*==========================
		Check to make sure sure that a valid email address is submitted
		===========================*/			
		if(trim($_POST['email']) === ''){
			$errorMessage = $classieraContactEmailError;
			$hasError = true;		
		}else{
			$email = trim($_POST['email']);
		}
		/*==========================
		Check to make sure comments were entered
		===========================*/			
		if(trim($_POST['comments']) === '') {
			$errorMessage = $classieraConMsgError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
		/*==========================
		Check to make sure that the human test field is not empty
		===========================*/		
		$classieraCheckAnswer = $_POST['humanAnswer'];
		if(trim($_POST['humanTest']) != $classieraCheckAnswer) {
			$errorMessage = esc_html__('Not Human', 'classiera');			
			$hasError = true;
		}
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];
		/*==========================
		If there is no error, send the email
		===========================*/		
		if($hasError == false) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;		
			contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL);
			$emailSent = true;
		}
	}
	if($_POST['submit'] == 'report_to_admin'){		
		$displayMessage = '';
		$report_ad = $_POST['report_ad_val'];
		if($report_ad == "illegal") {
			$message = esc_html__('This is an illegal/fraudulent ad, please take action.', 'classiera');
		}
		if($report_ad == "spam") {
			$message = esc_html__('This is a SPAM ad, please take action.', 'classiera');			
		}
		if($report_ad == "duplicate") {
			$message = esc_html__('This ad is a duplicate, please take action', 'classiera');			
		}
		if($report_ad == "wrong_category") {
			$message = esc_html__('This ad is in the wrong category, please take action', 'classiera');			
		}
		if($report_ad == "post_rules") {
			$message = esc_html__('The ad goes against posting rules, please take action', 'classiera');			
		}
		if($report_ad == "post_other") {
			$message = $_POST['other_report'];				
		}		
		$classieraPostTitle = $_POST['classiera_post_title'];	
		$classieraPostURL = $_POST['classiera_post_url'];	
		classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL);
		if(!empty($message)){
			$displayMessage = esc_html__('Thanks for reporting the ad. Our team will take action ASAP.', 'classiera');
		}
	}
	
}
if(isset($_POST['favorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classiera_favorite_insert($author_id, $post_id);
}
if(isset($_POST['follower'])){	
	$author_id = sanitize_text_field($_POST['author_id']);
	$follower_id = sanitize_text_field($_POST['follower_id']);
	echo classiera_authors_insert($author_id, $follower_id);
}
if(isset($_POST['unfollow'])){
	$author_id = sanitize_text_field($_POST['author_id']);
	$follower_id = sanitize_text_field($_POST['follower_id']);
	echo classiera_authors_unfollow($author_id, $follower_id);
}
?>
<?php 	
	/*==========================
	Search Styles
	===========================*/
	if($classieraSearchStyle == 1){
		get_template_part( 'templates/searchbar/searchstyle1' );
	}elseif($classieraSearchStyle == 2){
		get_template_part( 'templates/searchbar/searchstyle2' );
	}elseif($classieraSearchStyle == 3){
		get_template_part( 'templates/searchbar/searchstyle3' );
	}elseif($classieraSearchStyle == 4){
		get_template_part( 'templates/searchbar/searchstyle4' );
	}elseif($classieraSearchStyle == 5){
		get_template_part( 'templates/searchbar/searchstyle5' );
	}elseif($classieraSearchStyle == 6){
		get_template_part( 'templates/searchbar/searchstyle6' );
	}elseif($classieraSearchStyle == 7){
		get_template_part( 'templates/searchbar/searchstyle7' );
	}
?>
<section class="inner-page-content single-post-page">
	<div class="container">
		<!-- breadcrumb -->
		<?php classiera_breadcrumbs();?>
		<!-- breadcrumb -->
		<!--Google Section-->
		<?php 
		$homeAd1 = '';		
		global $redux_demo;
		$homeAdImg1 = $redux_demo['home_ad2']['url']; 
		$homeAdImglink1 = $redux_demo['home_ad2_url']; 
		$homeHTMLAds = $redux_demo['home_html_ad2'];		
		if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
		?>
		<section id="classieraDv">
			<div class="container">
				<div class="row">							
					<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">						
						<?php 
						if(!empty($homeHTMLAds)){
							if(function_exists('classiera_escape')) {
								classiera_escape($homeHTMLAds);
							}
						}else{
							echo '<a href="'.esc_url($homeAdImglink1).'" target="_blank"><img class="img-responsive" alt="image" src="'.esc_url($homeAdImg1).'" /></a>';
						}
						?>
					</div>
				</div>
			</div>	
		</section>
		<?php } ?>
		<?php if ( get_post_status ( $post->ID ) == 'private' || get_post_status ( $post->ID ) == 'pending' ) {?>
		<div class="alert alert-info" role="alert">
		  <p>
		  <strong><?php esc_html_e('Congratulations!', 'classiera') ?></strong> <?php esc_html_e('Your ad has been submitted and is pending for review. After the review your ad will be live for all users. You may not preview it more than once!', 'classiera') ?>
		  </p>
		</div>
		<?php } ?>
		<!--Google Section-->
		<?php if($classieraSingleAdStyle == 2){
			get_template_part( 'templates/singlev2' );
		}?>
		<div class="row">
			<div class="col-md-8">
				<!-- single post -->
				<div class="single-post">
					<?php if($classieraSingleAdStyle == 1){
						get_template_part( 'templates/singlev1');
					}?>
					<?php 
					$post_price = get_post_meta($post->ID, 'post_price', true); 
					$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
					$postVideo = get_post_meta($post->ID, 'post_video', true);
					$dateFormat = get_option( 'date_format' );
					$postDate = get_the_date($dateFormat, $post->ID);
					$itemCondition = get_post_meta($post->ID, 'item-condition', true); 
					$post_location = get_post_meta($post->ID, 'post_location', true);
					$post_state = get_post_meta($post->ID, 'post_state', true);
					$post_city = get_post_meta($post->ID, 'post_city', true);
					$post_phone = get_post_meta($post->ID, 'post_phone', true);
					$number_hide = get_post_meta($post->ID, 'number_hide', true);
					$post_whatsapp = get_post_meta($post->ID, 'post_whatsapp', true);
					$post_email = get_post_meta($post->ID, 'post_email', true);
					$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
					$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
					$post_address = get_post_meta($post->ID, 'post_address', true);
					$classieraCustomFields = get_post_meta($post->ID, 'custom_field', true);
					$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
					$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
					$classiera_allow_bids = get_post_meta($post->ID, 'classiera_allow_bids', true);
					$post_web_url = get_post_meta($post->ID, 'post_web_url', true);
					$post_web_url_txt = get_post_meta($post->ID, 'post_web_url_txt', true);
					$post_map_location = get_post_meta($post->ID, $locShownBy, true);
					$postCatgory = get_the_category( $post->ID );
					$postCurCat = $postCatgory[0]->name;
					if( has_post_thumbnail()){
						$classieraIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$classieraIMGURL = $classieraIMG[0];
					}else{
						$classieraIMGURL = get_template_directory_uri() . '/images/nothumb.png';
					}								
					$iconPath = get_template_directory_uri() .'/images/icon-services.png';
					if(is_numeric($post_price)){
						$classieraPostPrice = classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						$classieraPostPrice = esc_attr($post_price); 
					}					
					?>
					<!-- ad deails -->
					<div class="border-section details">
						<!-- <h4 class="border-section-heading text-uppercase"><i class="far fa-file-alt"></i><?php esc_html_e('Ad Details', 'classiera') ?></h4> -->
						<div class="post-details">
							<ul class="list-unstyled clearfix">
								<!-- <li>
									<p class="clearfix"><?php esc_html_e( 'Ad ID', 'classiera' ); ?>:
										<span class="pull-right flip">
											<i class="fas fa-hashtag IDIcon"></i>
											<?php echo esc_attr($post->ID); ?>
										</span>
									</p>
								</li> -->
								<!--PostDate-->
								<!--Price Section -->
								<!-- <?php
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){
								?>
								<?php if(empty($post_old_price)){ ?>
								<?php if(!empty($post_price)){?>
								<li>
									<p class="clearfix"><?php esc_html_e( 'Price', 'classiera' ); ?>:
										<span class="pull-right flip cl__price">
											<?php
											if(is_numeric($post_price)){
												echo classiera_post_price_display($post_currency_tag, $post_price);
																						}else{
												echo esc_attr($post_price);
																				}
											?>
										</span>
									</p>
									</li> -->
									<!--Sale Price-->
									<!-- <?php } ?>
									<?php }else{ ?>
									<?php if(!empty($post_old_price)){?>
									<li>
										<p class="clearfix"><?php esc_html_e( 'Price', 'classiera' ); ?>:
											<span class="pull-right flip cl__price">
												&nbsp; <strike><?php
												if(is_numeric($post_old_price)){
													echo classiera_post_price_display($post_currency_tag, $post_old_price);
												}else{
													echo esc_attr($post_old_price);
												}
												?></strike> 
											</span>
											<span class="pull-right flip cl__price" style="color: #000;">
												<strong><?php
												if(is_numeric($post_price)){
													echo classiera_post_price_display($post_currency_tag, $post_price);
																							}else{
													echo esc_attr($post_price);
																					}
												?></strong>
											</span>
										</p>
									</li> -->
									<!--Regular Price-->
									<!-- <?php } } ?> -->
										<!--Price Section -->
									<!-- <?php } ?> -->
								<!-- <li class="classiera_pdate">
									<p class="clearfix"><?php esc_html_e( 'Posted Date', 'classiera' ); ?>:
										<span class="pull-right flip"><?php echo esc_html($postDate); ?></span>
									</p>
								</li> -->
								<!--PostDate-->
										<?php if(!empty($itemCondition)){?>
								<li>
									<p class="clearfix"><?php esc_html_e( 'Condition', 'classiera' ); ?>:
										<span class="pull-right flip"><?php echo classiera_ad_condition($itemCondition); ?></span>
									</p>
								</li><!--Condition-->
								<?php } ?>
								<?php if(!empty($post_location)){?>
								<!-- <li>
									<p class="clearfix"><?php esc_html_e( 'Location', 'classiera' ); ?>:
										<span class="pull-right flip"><?php echo esc_attr($post_location); ?></span>
									</p>
								</li> -->
								<!--Location-->
								<?php } ?>
								<?php if(!empty($post_state)){?>
								<li>
									<p class="clearfix"><!-- <?php esc_html_e( 'Location', 'classiera' ); ?>: -->
										<i class="fas fa-map-marker-alt"></i>
										<span class="flip"><?php echo esc_attr($post_state); ?>, <?php echo esc_attr($post_city); ?></span>
									</p>
									<p class="clearfix"><i class="far fa-clock"></i> <?php esc_html_e( 'Posted', 'classiera' ); ?>:
										<span class="flip"><?php echo esc_html($postDate); ?></span>
									</p>
								</li><!--state-->
								<?php } ?>
								<!-- <?php if(!empty($post_city)){?>
								<li>
									<p class="clearfix"><?php esc_html_e( 'Muncipality', 'classiera' ); ?>:
										<span class="pull-right flip"><?php echo esc_attr($post_city); ?></span>
									</p>
								</li>
								<?php } ?> -->
								<!-- <li class="classiera_views">
									<p class="clearfix"><?php esc_html_e( 'Views', 'classiera' ); ?>:
										<span class="pull-right flip">
											<?php echo classiera_get_post_views(get_the_ID()); ?>
										</span>
									</p>
								</li> -->
								<!--Views-->
								<?php
								if(!empty($classieraCustomFields)) {
									for ($i = 0; $i < count($classieraCustomFields); $i++){
										if( !isset($classieraCustomFields[$i][2]) || $classieraCustomFields[$i][2] == 'text'){
											if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ) {
								?>
									<li>
										<p class="clearfix"><?php echo esc_attr($classieraCustomFields[$i][0]); ?>:
											<span class="pull-right flip">
												<?php echo esc_attr($classieraCustomFields[$i][1]); ?>
											</span>
										</p>
									</li><!--test-->
									<?php
									}
									}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
									if(isset($classieraCustomFields[$i][2]) && $classieraCustomFields[$i][2] == 'dropdown'){
									if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
									?>
									<li>
										<p class="clearfix"><?php echo esc_attr($classieraCustomFields[$i][0]); ?>:
											<span class="pull-right flip">
												<?php echo esc_attr($classieraCustomFields[$i][1]); ?>
											</span>
										</p>
									</li><!--dropdown-->
									<?php
									}
									}
									}
									for ($i = 0; $i < count($classieraCustomFields); $i++){
									if(isset($classieraCustomFields[$i][2]) && $classieraCustomFields[$i][2] == 'checkbox'){
									if(!empty($classieraCustomFields[$i][1]) && !empty($classieraCustomFields[$i][0]) ){
									?>
									<li>
										<p class="clearfix"><?php echo esc_attr($classieraCustomFields[$i][0]); ?>:
											<span class="pull-right flip">
												<i class="fas fa-check"></i>
											</span>
										</p>
									</li><!--dropdown-->
									<?php
									}
									}
									}
									}
									?>
									<?php if(!empty($post_web_url)){ ?>
									<li>
										<p class="clearfix"><?php esc_html_e( 'Website', 'classiera' ); ?>:
											<span class="pull-right flip">
												<a href="<?php echo esc_url($post_web_url);?>" target="_blank">
													<?php echo esc_html($post_web_url_txt);?>
												</a>
											</span>
										</p>
									</li><!--Views-->
									<?php } ?>
								</ul>
								</div><!--post-details-->
							</div>
					<!-- ad details -->					
					<!-- Google MAP in Description -->	
					<?php if($googleMapadPost == 1 && $classiera_MAP_location == 'descarea'){ ?>
					<div class="border-section border classiera__map_single">
						<h4 class="border-section-heading text-uppercase">
						<?php echo esc_attr($post_map_location); ?>
						</h4>
						<?php if(!empty($post_latitude)){?>
						<div id="classiera_single_map">
							<div class="details_adv_map" id="details_adv_map">
								<script type="text/javascript">
									jQuery(document).ready(function(){
										var addressPoints = [							
											<?php 
											$content = '<a class="classiera_map_div" href="'.get_the_permalink().'"><img class="classiera_map_div__img" src="'.$classieraIMGURL.'" alt="images"><div class="classiera_map_div__body"><p class="classiera_map_div__price">'.__( "Price", 'classiera').' : <span>'.$classieraPostPrice.'</span></p><h5 class="classiera_map_div__heading">'.get_the_title().'</h5><p class="classiera_map_div__cat">'.__( "Category", 'classiera').' : '.esc_attr($postCurCat).'</p></div></a>';
											?>
											[<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>, '<?php if(function_exists('classiera_escape')) { classiera_escape($content); } ?>', "<?php echo esc_url($iconPath); ?>"],							
										];
										var mapopts;
										if(window.matchMedia("(max-width: 1024px)").matches){
											var mapopts =  {
												dragging:false,
												tap:false,
											};
										};
										var map = L.map('details_adv_map', mapopts).setView([<?php echo esc_attr($post_latitude); ?>,<?php echo esc_attr($post_longitude); ?>],13);
										var roadMutant = L.gridLayer.googleMutant({
										<?php if($classieraMapStyle){?>styles: <?php echo wp_kses_post($classieraMapStyle); ?>,<?php }?>
											maxZoom: 20,
											type:'roadmap'
										}).addTo(map);
										var markers = L.markerClusterGroup({
											spiderfyOnMaxZoom: true,
											showCoverageOnHover: true,
											zoomToBoundsOnClick: true,
											maxClusterRadius: 60
										});
										var markerArray = [];
										for (var i = 0; i < addressPoints.length; i++){
											var a = addressPoints[i];
											var newicon = new L.Icon({iconUrl: a[3],
												iconSize: [50, 50], // size of the icon
												iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
												popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
											});
											var title = a[2];
											var marker = L.marker(new L.LatLng(a[0], a[1]));
											marker.setIcon(newicon);
											marker.bindPopup(title);
											marker.title = title;
											marker.on('click', function(e) {
												map.setView(e.latlng, 13);
												
											});				
											markers.addLayer(marker);
											markerArray.push(marker);
											if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
												var group = L.featureGroup(markerArray); //add markers array to featureGroup
												map.fitBounds(group.getBounds());   
											}
										}
										map.addLayer(markers);
										<?php 
										if($classieraMAPDragging == false){
											?>
											map.dragging.disable();					
											<?php
										}
										?>
										<?php 
										if($classieraMAPScroll == false){
											?>
											map.scrollWheelZoom.disable();
											<?php
										}
										?>
									});
								</script>
							</div><!--details_adv_map-->
						</div><!--classiera_single_map-->
						<div id="ad-address">
							<span>
							<i class="fas fa-map-marker-alt"></i>
							<a href="http://maps.google.com/maps?saddr=&daddr=<?php echo esc_html($post_address); ?>" target="_blank">
								<?php esc_html_e( 'Get Directions on Google MAPS to', 'classiera' ); ?>: <?php echo esc_html($post_address); ?>
							</a>
							</span>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
					<!-- Google MAP in Description -->					
					<!--PostVideo-->
					<?php if(!empty($postVideo)) { ?>
					<div class="border-section border postvideo">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Video', 'classiera' ); ?>
						</h4>
						<?php 
						if(preg_match("/youtu.be\/[a-z1-9.-_]+/", $postVideo)) {
							preg_match("/youtu.be\/([a-z1-9.-_]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("/youtube.com(.+)v=([^&]+)/", $postVideo)) {
							preg_match("/v=([^&]+)/", $postVideo, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("#https?://(?:www\.)?vimeo\.com/(\w*/)*(([a-z]{0,2}-)?\d+)#", $postVideo)) {
							preg_match("/vimeo.com\/([1-9.-_]+)/", $postVideo, $matches);
							//print_r($matches); exit();
							if(isset($matches[1])) {
								$url = 'https://player.vimeo.com/video/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
							}
						}else{
							$video = $postVideo;
						}
						?>
						<div class="embed-responsive embed-responsive-16by9">
							<?php echo wpautop($video); ?>
						</div>
					</div>
					<?php } ?>
					<!--PostVideo-->
					<!-- post description -->
					<div class="border-section border description">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Description', 'classiera' ); ?>
						</h4>
						<div class="classiera_entry_content"><?php echo the_content(); ?></div>
						<!-- <div class="tags">
				<span>
					<i class="fas fa-tags"></i>
					<?php esc_html_e( 'Tags', 'classiera' ); ?> :
				</span>
							<?php the_tags('','',''); ?>
			</div> -->
						<!--Post Pagination-->
						<?php 
						$postFormat = get_post_format( $post->ID);
						if (is_singular()) {
							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'classiera' ),
									'after'  => '</div>',
									'link_before'  => '<span class="btn btn-primary sharp btn-sm btn-style-one">',
									'link_after'  => '</span>',
								)
							);
						} 
						?>
						<!--Post Pagination-->
					</div>
					<!-- post description -->
					<!-- <div class="border-section border description">
						<h4 class="border-section-heading text-uppercase">
						<?php esc_html_e( 'Sold By', 'classiera' ); ?>
						</h4>
						<div class="classiera_entry_content kSiZbm">
							<?php 
							$author_ID = $post->post_author;
							$authorName = get_the_author_meta('display_name', $author_ID );
							$authorPhone = get_the_author_meta('phone', $author_ID);
							if(empty($authorName)){
								$authorName = get_the_author_meta('user_nicename', $author_ID );
							}
							if(empty($authorName)){
								$authorName = get_the_author_meta('user_login', $author_ID );
							}

							?>
							<div class="layout__Left-sc-775v9d-1 hZYbkP">
								<div class="TextSubHeading__TextSubHeadingWrapper-sc-1ilszdp-0 bcaUdR">
									<span>sold by</span>
									</div>
									<div class="TextBody__TextBodyWrapper-sc-17pzx5f-0 lbkVoL styled__UserName-sc-1f8y0be-3 hxvVyi">
										<span><?php echo esc_attr($authorName); ?></span>
									</div>
									<div class="styled__UserInfoWrapper-sc-1f8y0be-5 iEKOTI"></div>
								</div>
							<div class="layout__Right-sc-775v9d-2 gwZhET">
								<div>
									<button type="button" data-testid="reply-ad-button" class="Buttonstyles__BaseButton-hz08m4-0 eivKVV">
										<span class="Buttonstyles__ChildrenWrapper-hz08m4-3 fXYiwE">
											<svg viewBox="0 0 32 32" color="#fff" width="24" height="24" class="AdReplyButton__StyledIconMessage-sc-1r21mrb-1 MTymP"><defs><path id="iconMessage_svg__a" d="M16 0c10.168 0 16 4.647 16 12.75 0 5.301-2.483 9.167-7.183 11.186l-10.38 7.408 1.34-5.847C5.748 25.43.002 20.792.002 12.75 0 4.647 5.83 0 16 0zm7.938 22.137C27.959 20.444 30 17.285 30 12.75 30 5.817 25.029 2 16 2 6.973 2 2 5.817 2 12.75c0 6.931 4.973 10.748 14 10.748.34 0 .674-.007 1.003-.018l1.297-.043-.736 3.22 6.373-4.52zM11 16v-2h10v2H11zm0-5V9h10v2H11z"></path></defs><use fill="currentColor" xlink:href="#iconMessage_svg__a" fill-rule="evenodd"></use>
											</svg> 
											<div class="TextCallout1__TextCallout1Wrapper-qzrnab-0 lkIkoj AdReplyButton__StyledAdReplyText-sc-1r21mrb-0 ciqpsO">
												<span> Send Message</span>
											</div>
										</span>
									</button>
								</div>
								 <?php if(empty($post_phone)){?>
									<?php if(!empty($authorPhone)){?>
									<div class="ShowPhoneNumberButton__StyledButton-sc-1fetcgp-0 cMGXxG">
										<a href="tel:<?php echo esc_html($authorPhone);?>" data-replace-number="<?php echo esc_html($authorPhone);?>" class="Buttonstyles__BaseButton-hz08m4-0-a Buttonstyles__BaseAnchor-hz08m4-1 hmzYTq">
											<span class="Buttonstyles__ChildrenWrapper-hz08m4-3 fXYiwE">Call <?php echo esc_html($authorPhone);?></span>
										</a>
									</div>
									<?php } ?>
									<?php }elseif(!empty($post_phone)){ ?>
									<div class="ShowPhoneNumberButton__StyledButton-sc-1fetcgp-0 cMGXxG">
										<a href="tel:<?php echo esc_html($post_phone);?>" data-replace-number="<?php echo esc_html($post_phone);?>" class="Buttonstyles__BaseButton-hz08m4-0-a Buttonstyles__BaseAnchor-hz08m4-1 hmzYTq">
											<span class="Buttonstyles__ChildrenWrapper-hz08m4-3 fXYiwE">Call <?php echo esc_html($post_phone);?></span>
										</a>
									</div>
									<?php } ?>
							</div>
						</div>
						
					</div> -->
					<div class="SafePurchase__StyledCard-sc-10fwtka-0 cziCdm">
						<div>
							<div class="TextSubHeading__TextSubHeadingWrapper-sc-1ilszdp-0 bcaUdR SafePurchase__Subject-sc-10fwtka-1 fIrKqk">
								<span>Safe business</span>
							</div>
							<div class="TextBody__TextBodyWrapper-sc-17pzx5f-0 lbkVoL SafePurchase__StyledText-sc-10fwtka-2 jmAtHX">
								<span>Snakes, lizards, turtles and frogs are exciting pets. But there are some things to keep in mind when buying a warm friend.</span>
							</div>
							<div class="TextBody__TextBodyWrapper-sc-17pzx5f-0 lbkVoL SafePurchase__StyledText-sc-10fwtka-2 jmAtHX">
								<a href="https://swiftcourt.com/sv/kontrakt/blocket/husdjur?ad_id=91642714" class="Link-sc-139ww1j-0 icwVFB">
									<span>Digital purchase contract</span>
								</a>
							</div>
							<div class="TextBody__TextBodyWrapper-sc-17pzx5f-0 lbkVoL SafePurchase__StyledText-sc-10fwtka-2 jmAtHX">
								<a class="Link-sc-139ww1j-0 icwVFB" href="/tips-och-guider/kopa-och-salja-djur">
									<span>Read Blocket's tips for a safe deal</span>
								</a>
							</div>
							<div class="SafePurchase__SafePurchasePartners-sc-10fwtka-3 fExXfX">
								<div data-ref="viewable">
									<div class="SafePurchasePartner__Wrapper-sc-13oaina-0 isPwJi">
										<img src="https://images.ctfassets.net/rvdf5xmxjruf/3FvL87Wgftx0KoetDsTQZW/6cd95d1c1424fe1a013b55b01d86f0fd/badgeAnimal.d9dddc78b07d5da1deb981c9410907bd.svg" class="SafePurchasePartner__Icon-sc-13oaina-2 gniFtI">
										<div>
											<div class="TextSubHeading__TextSubHeadingWrapper-sc-1ilszdp-0 bcaUdR">
												<span>14 days free insurance from Agria Djurförsäkring</span>
											</div>
											<div class="TextBody__TextBodyWrapper-sc-17pzx5f-0 lbkVoL SafePurchasePartner__StyledTextBody-sc-13oaina-1 jxoBmS">
												<div>
													<span>Security for both you and your animal.</span>
												</div>
												<a href="https://www.agria.se/blocket/?PetTypeCode=043&amp;FreeText1=91642714&amp;utm_source=samarbeten&amp;utm_medium=banner&amp;utm_campaign=samarbete_blocket_smadjur_tryggaffar" target="_blank" rel="noopener" class="Link-sc-139ww1j-0 icwVFB">
													<span>Read more and activate your insurance</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="SafePurchase__IconWrapper-sc-10fwtka-4 hMDsIF">
							<span class="Icon__IconWrapper-sc-1px8ohs-0 dlthlM" width="50" height="59"></span>
						</div>
					</div>
					<!-- post description -->					
					<!-- classiera bid system -->
					<?php if($classiera_bid_system == true && $classiera_allow_bids == 'allow'){ ?>
					<div class="border-section border bids">
						<?php 
							global $wpdb;
							$classieraMaxOffer = null;
							$classieraTotalBids = null;
							$post_id = $post->ID;							
							$currentPostOffers = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id =%d ORDER BY id DESC", $post_id));
							$classieraMaxOffer = classiera_max_offer_price($post_id);
							$classieraMaxOffer = classiera_post_price_display($post_currency_tag, $classieraMaxOffer);
							$classieraMinOffer = classiera_min_offer_price($post_id);
							$classieraMinOffer = classiera_post_price_display($post_currency_tag, $classieraMinOffer);
							$classieraTotalBids = classiera_bid_count($post_id);
						?>
						<h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Bids', 'classiera' ); ?></h4>
						<div class="classiera_bid_stats">
							<p class="classiera_bid_stats_text"> 
								<strong><?php esc_html_e( 'Bid Stats', 'classiera' ); ?> :</strong> 
								<?php echo esc_attr($classieraTotalBids); ?>&nbsp;
								<?php esc_html_e( 'Bids posted on this ad', 'classiera' ); ?>
							</p>
							<div class="classiera_bid_stats_prices">
								<?php if($currentPostOffers){?>
								<p class="classiera_bid_price_btn high_price"> 
									<span><?php esc_html_e( 'Highest Bid', 'classiera' ); ?>:</span>
									<?php 
									if(function_exists('classiera_escape')) {
										classiera_escape($classieraMaxOffer);
									}
									?>
								</p>
								<?php } ?>
								<?php if($currentPostOffers){?>
								<p class="classiera_bid_price_btn"> 
									<span><?php esc_html_e( 'Lowest Bid', 'classiera' ); ?>:</span> 
									<?php 
									if(function_exists('classiera_escape')) {
										classiera_escape($classieraMinOffer);
									}
									?>
								</p>
								<?php } ?>
							</div><!--classiera_bid_stats_prices-->
						</div><!--classiera_bid_stats-->
						<div class="classiera_bid_comment_section">
							<?php 
							if($currentPostOffers){
								foreach ( $currentPostOffers as $offerinfo ) {
								$classieraOfferAuthorID = $offerinfo->offer_author_id;
								$classieraOfferPrice = $offerinfo->offer_price;
								$classieraOfferComment = $offerinfo->offer_comment;	
								$classieraOfferDate = $offerinfo->date;
								$classieraOfferDate = date_i18n($dateFormat, $classieraOfferDate);
								$classieraOfferAuthor = get_the_author_meta('display_name', $classieraOfferAuthorID );
								if(empty($classieraOfferAuthor)){
									$classieraOfferAuthor = get_the_author_meta('user_nicename', $classieraOfferAuthorID );
								}
								if(empty($classieraOfferAuthor)){
									$classieraOfferAuthor = get_the_author_meta('user_login', $classieraOfferAuthorID );
								}
								$classieraOfferAuthorEmail = get_the_author_meta('user_email', $classieraOfferAuthorID);
								$classieraOfferAuthorIMG = get_user_meta($classieraOfferAuthorID, "classify_author_avatar_url", true);
								$classieraOfferAuthorIMG = classiera_get_profile_img($classieraOfferAuthorIMG);
								if(empty($classieraOfferAuthorIMG)){										
									$classieraOfferAuthorIMG = classiera_get_avatar_url ($classieraOfferAuthorEmail, $size = '150' );
								}
							?>
							<div class="classiera_bid_media">
								<img class="classiera_bid_media_img img-thumbnail" src="<?php echo esc_url($classieraOfferAuthorIMG); ?>" alt="<?php echo esc_attr($classieraOfferAuthor);?>">
								<div class="classiera_bid_media_body">
									<h6 class="classiera_bid_media_body_heading">
										<?php echo esc_attr($classieraOfferAuthor);?>
										<span><?php esc_html_e( 'Offering', 'classiera' ); ?></span>
									</h6>
									<p class="classiera_bid_media_body_time">
										<i class="far fa-clock"></i><?php echo esc_html($classieraOfferDate); ?>
									</p>
									<p class="classiera_bid_media_body_decription">
										<?php echo esc_html($classieraOfferComment); ?>
									</p>
								</div>
								<div class="classiera_bid_media_price">
									<p class="classiera_bid_price_btn">
										<span><?php esc_html_e( 'Bid', 'classiera' ); ?>:</span> 
										<?php echo classiera_post_price_display($post_currency_tag, $classieraOfferPrice); ?>
									</p>
								</div>
							</div>
							<?php } }?>
							
						</div><!--classiera_bid_comment_section-->
						<div class="comment-form classiera_bid_comment_form">
							<div class="comment-form-heading">
								<h4 class="text-uppercase">
									<?php esc_html_e( 'Let&rsquo;s Create Your Bid', 'classiera' ); ?>
								</h4>
								<p><?php esc_html_e( 'Only registered users can post offers', 'classiera' ); ?>
									<span class="text-danger">*</span>
								</p>
							</div><!--comment-form-heading-->
							<div class="classiera_ad_price_comment">
								<p><?php esc_html_e( 'Ad Price', 'classiera' ); ?></p>
								<h3>
								<?php 
								if(is_numeric($post_price)){
									echo classiera_post_price_display($post_currency_tag, $post_price);
								}else{ 
									echo esc_attr($post_price); 
								}
								?>
								</h3>
							</div><!--classiera_ad_price_comment-->
							<form data-toggle="validator" id="classiera_offer_form" method="post">
								<span class="classiera--loader"><img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader.gif' ?>" alt="classiera loader"></span>
								<div class="form-group">
									<div class="form-inline row">
										<div class="form-group col-sm-12">
											<label class="text-capitalize">
												<?php esc_html_e( 'Enter your bidding price', 'classiera' ); ?> :
												<span class="text-danger">*</span>
											</label>
											<div class="inner-addon left-addon">
												<input type="number" class="form-control form-control-sm offer_price" name="offer_price" placeholder="<?php esc_attr_e( 'Enter bidding price', 'classiera' ); ?>" data-error="<?php esc_attr_e( 'Only integer', 'classiera' ); ?>" required>
												<div class="help-block with-errors"></div>
											</div>
										</div><!--form-group col-sm-12-->                                    
										<div class="form-group col-sm-12">
											<label class="text-capitalize">
												<?php esc_html_e( 'Enter your comment', 'classiera' ); ?> :
												<span class="text-danger">*</span>
											</label>
											<div class="inner-addon">
												<textarea class="offer_comment" data-error="<?php esc_attr_e( 'Please type your comment', 'classiera' ); ?>" name="offer_comment" placeholder="<?php esc_attr_e( 'Type your comment here', 'classiera' ); ?>" required></textarea>
												<div class="help-block with-errors"></div>
											</div>
										</div><!--form-group col-sm-12-->
									</div><!--form-inline row-->
								</div><!--form-group-->
								<?php 
								$postAuthorID = $post->post_author;
								$currentLoggedAuthor = wp_get_current_user();
								$offerAuthorID = $currentLoggedAuthor->ID;
								?>
								<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
								<input type="hidden" class="offer_post_id" name="offer_post_id" value="<?php echo esc_attr($post->ID);?>">
								<input type="hidden" class="post_author_id" name="post_author_id" value="<?php echo esc_attr($postAuthorID); ?>">
								<input type="hidden" class="offer_author_id" name="offer_author_id" value="<?php echo esc_attr($offerAuthorID); ?>">
								<input type="hidden" class="offer_post_price" name="offer_post_price" value="<?php if(is_numeric($post_price)){ echo classiera_post_price_display($post_currency_tag, $post_price); }else{ echo esc_attr($post_price); }?>">
								<div class="form-group">
									<button type="submit" name="submit_bid" class="btn btn-primary sharp btn-md btn-style-one submit_bid">
										<?php esc_html_e( 'Send offer', 'classiera' ); ?>
									</button>
								</div>
								<div class="form-group">
									<div class="classieraOfferResult bg-success text-center"></div>
								</div>
							</form>
						</div><!--comment-form classiera_bid_comment_form-->
					</div>
					<?php } ?>
					<!-- classiera bid system -->
					<!--comments-->
					<?php if($classieraComments == 1){?>
					<?php if ( comments_open()) { ?>
					<div class="border-section border comments">
						<h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Comments', 'classiera' ); ?></h4>
						<?php 
						$file ='';
						$separate_comments ='';
						comments_template( $file, $separate_comments );
						?>
					</div>
					<?php } ?>
					<?php } ?>
					<!--comments-->
				</div>
				<!-- single post -->
			</div><!--col-md-8-->
			<div class="col-md-4">
				<aside class="sidebar single-sidebar">
					<div class="row">
						<?php if($classieraSingleAdStyle == 1){?>
						<!--Widget for style 1-->
						<div class="col-lg-12 col-md-12 col-sm-6 match-height user_info">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraPriceSection = $redux_demo['classiera_sale_price_off'];
								if($classieraPriceSection == 1){									
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
								?>
								<div class="widget-title price">
									<h3 class="post-price">										
										<?php 
										if(!empty($post_price)){
											if(is_numeric($post_price)){
												echo classiera_post_price_display($post_currency_tag, $post_price);
											}else{ 
												echo esc_attr($post_price); 
											}
										}else{
											if(is_numeric($post_old_price)){
												echo classiera_post_price_display($post_currency_tag, $post_old_price);
											}else{ 
												echo esc_attr($post_old_price); 
											}
										}
										if(!empty($classiera_ads_type)){
											?>
											<span class="ad_type_display">
												<?php classiera_buy_sell($classiera_ads_type); ?>
											</span>
											<?php
										}
										?>
									</h3>
								</div><!--price-->
								<?php } ?>	
								<div class="widget-content widget-content-post">
									<div class="author-info border-bottom widget-content-post-area">
									<?php 
									$author_ID = $post->post_author;
									$authorName = get_the_author_meta('display_name', $author_ID );
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_nicename', $author_ID );
									}
									if(empty($authorName)){
										$authorName = get_the_author_meta('user_login', $author_ID );
									}
									$author_avatar_url = get_user_meta($author_ID, "classify_author_avatar_url", true);
									$author_avatar_url = classiera_get_profile_img($author_avatar_url);
									$authorEmail = get_the_author_meta('user_email', $author_ID);
									$authorURL = get_the_author_meta('user_url', $author_ID);
									$authorPhone = get_the_author_meta('phone', $author_ID);
									if(empty($author_avatar_url)){										
										$author_avatar_url = classiera_get_avatar_url ($authorEmail, $size = '150' );
									}
									$UserRegistered = get_the_author_meta( 'user_registered', $author_ID );
									$dateFormat = get_option( 'date_format' );
									$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
									?>	
										<div class="media">
											<div class="media-left">
												<img class="media-object" src="<?php echo esc_url($author_avatar_url); ?>" alt="<?php echo esc_attr($authorName); ?>">
											</div><!--media-left-->
											<div class="media-body">
												<h5 class="media-heading text-uppercase">
													<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo esc_attr($authorName); ?></a>
													<?php echo classiera_author_verified($author_ID);?>
												</h5>
												<!-- <p class="member_since"><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo esc_html($classieraRegDate);?></p> -->
												<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php esc_html_e( 'see all ads', 'classiera' ); ?></a>
												<?php if ( is_user_logged_in()){
													if($author_ID != $current_user_ID){
														echo classiera_authors_follower_check($author_ID, $current_user_ID);
													}
												}				
												?>
											</div><!--media-body-->
										</div><!--media-->
									</div><!--author-info-->
								</div><!--widget-content-->
								<?php if($classieraAuthorInfo == 1){?>
								<div class="widget-content widget-content-post">
									<div class="contact-details widget-content-post-area">
										<h5 class="text-uppercase"><?php esc_html_e('Contact Details', 'classiera') ?> :</h5>
										<ul class="list-unstyled fa-ul c-detail">
										<!--WhatsAPP-->
										
										<!-- <?php if(!empty($post_whatsapp)){?>
										<li>
											<i class="fab fa-whatsapp fa-li"></i>
											<a href="https://api.whatsapp.com/send?phone=<?php echo esc_html($post_whatsapp);?>" target="_blank">
												<?php esc_html_e('Click to chat on WhatsApp', 'classiera') ?>
											</a>
										</li>
										<?php } ?> -->
										<!--WhatsAPP-->
										<?php if($number_hide != 1){ ?>
											<?php if(empty($post_phone)){?>
												<?php if(!empty($authorPhone)){?>
												<li><i class="fas fa-li fa-phone-square"></i>&nbsp;
													<a href="#" class="phNum" data-replace-number="<?php echo esc_html($authorPhone);?>"><?php echo esc_html($authorPhone);?></a>
													<button type="button" id="showNum" class="bm_single_post_ai__list_btn">
														<?php esc_html_e( 'Reveal', 'classiera' ); ?>
													</button>
												</li>
												<?php } ?>
											<?php }elseif(!empty($post_phone)){ ?>
												<li><i class="fas fa-li fa-phone-square"></i>&nbsp;
													<a href="#" class="phNum" data-replace-number="<?php echo esc_html($post_phone);?>"><?php echo esc_html($post_phone);?></a>
													<button type="button" id="showNum" class="bm_single_post_ai__list_btn">
														<?php esc_html_e( 'Reveal', 'classiera' ); ?>
													</button>
												</li>
											<?php } ?>
										<?php } ?>

											<!-- <?php if(!empty($authorURL)){?>
											<li><i class="fas fa-li fa-globe"></i> 
												<a href="<?php echo esc_url($authorURL); ?>" target="_blank">
													<?php echo esc_url($authorURL); ?>
												</a>
											</li>
											<?php } ?>
											<?php if(!empty($post_web_url)){ ?>
											<li><i class="fas fa-li fa-globe"></i> 
												<a href="<?php echo esc_url($post_web_url); ?>" target="_blank">
													<?php echo esc_html($post_web_url_txt); ?>
												</a>
											</li>
											<?php } ?> -->
											<!-- <?php if(!empty($authorEmail) && $classieraAuthoremail == true){ ?>
											<li><i class="fas fa-li fa-envelope"></i> 
												<a href="mailto:<?php echo sanitize_email($authorEmail); ?>">
													<?php echo sanitize_email($authorEmail); ?>
												</a>
											</li>
											<?php } ?>
											<?php if(!empty($post_email)){ ?>
											<li><i class="fas fa-li fa-envelope"></i> 
												<a href="mailto:<?php echo sanitize_email($post_email); ?>">
													<?php echo sanitize_email($post_email); ?>
												</a>
											</li>
											<?php } ?>  -->
											<li><i class="fas fa-li fa-eye"></i>
												<span class="pull-right flip">
													<?php echo classiera_get_post_views(get_the_ID()); ?>
												</span>
											</li>
										</ul>
									</div><!--contact-details-->
								</div><!--widget-content-->
								<?php } ?>
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<!--Widget for style 1-->
						<?php if($classieraToAuthor == 1){?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<?php 
								$classieraWidgetClass = "widget-content-post";
								$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								if($classieraSingleAdStyle == 1){
									$classieraWidgetClass = "widget-content-post";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area";
								}elseif($classieraSingleAdStyle == 2){
									$classieraWidgetClass = "removePadding";
									$classieraMakeOffer = "user-make-offer-message widget-content-post-area border-none removePadding";
								}
								?>
								<div class="widget-content <?php echo esc_attr($classieraWidgetClass); ?>">
									<div class="<?php echo esc_attr($classieraMakeOffer); ?>">
										<ul class="nav nav-tabs" role="tablist">
											<?php if($classieraToAuthor == 1){?>
											<li role="presentation" class="active">
												<a href="#message" aria-controls="message" role="tab" data-toggle="tab"><i class="fas fa-envelope"></i><?php esc_html_e('Send Email', 'classiera') ?></a>
											</li>
											<?php } ?>
										</ul><!--nav nav-tabs-->
										<!-- Tab panes -->
										<div class="tab-content">
											<?php if($classieraToAuthor == 1){?>
											<div role="tabpanel" class="tab-pane active" id="message">
											<!--ShownMessage-->
											<?php if(isset($_POST['submit']) && $_POST['submit'] == 'send_message'){?>
												<div class="row">
													<div class="col-lg-12">
														<?php if($hasError == true){ ?>
														<div class="alert alert-warning">
															<?php echo esc_html($errorMessage); ?>
														</div>
														<?php } ?>
														<?php if($emailSent == true){ ?>
														<div class="alert alert-success">
															<?php echo esc_html($classieraContactThankyou); ?>
														</div>
														<?php } ?>
													</div>
												</div>
												<?php } ?>
												<!--ShownMessage-->
												<form method="post" class="form-horizontal" data-toggle="validator" name="contactForm" action="<?php the_permalink(); ?>">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="name"><?php esc_html_e('Name', 'classiera') ?> :</label>
														<div class="col-sm-9">
															<input id="name" data-minlength="5" type="text" class="form-control form-control-xs" name="contactName" placeholder="<?php esc_attr_e('Type your name', 'classiera') ?>" required>
														</div>
													</div><!--name-->
													<div class="form-group">
														<label class="col-sm-3 control-label" for="email"><?php esc_html_e('Email', 'classiera') ?> :</label>
														<div class="col-sm-9">
															<input id="email" type="email" class="form-control form-control-xs" name="email" placeholder="<?php esc_attr_e('Type your email', 'classiera') ?>" required>
														</div>
													</div><!--Email-->
													<div class="form-group">
														<label class="col-sm-3 control-label" for="subject"><?php esc_html_e('Subject', 'classiera') ?> :</label>
														<div class="col-sm-9">
															<input id="subject" type="text" class="form-control form-control-xs" name="subject" placeholder="<?php esc_attr_e('Type your subject', 'classiera') ?>" required>
														</div>
													</div><!--Subject-->
													<div class="form-group">
														<label class="col-sm-3 control-label" for="msg"><?php esc_html_e('Msg', 'classiera') ?> :</label>
														<div class="col-sm-9">
															<textarea id="msg" name="comments" class="form-control" placeholder="<?php esc_attr_e('Type Message', 'classiera') ?>" required></textarea>
														</div>
													</div><!--Message-->
													<?php 
														$classieraFirstNumber = rand(1,9);
														$classieraLastNumber = rand(1,9);
														$classieraNumberAnswer = $classieraFirstNumber + $classieraLastNumber;
													?>
													<div class="form-group">
														<div class="col-sm-9">
															<p>
															<?php esc_html_e("Please input the result of ", "classiera"); ?>
															<?php echo esc_attr($classieraFirstNumber); ?> + <?php echo esc_attr($classieraLastNumber);?> = 
															</p>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="humanTest"><?php esc_html_e('Answer', 'classiera') ?> :</label>
														<div class="col-sm-9">
															<input id="humanTest" type="text" class="form-control form-control-xs" name="humanTest" placeholder="<?php esc_attr_e('Your answer', 'classiera') ?>" required>
															<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo esc_attr($classieraNumberAnswer); ?>" />
															<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
															<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
														</div>
													</div><!--answer-->
													<!--Checkbox-->
													<div class="form-group">
														<div class="checkbox col-sm-12">
															<input type="checkbox" name="agree" id="agree" value="agree" required>
															<label class="control-label" for="agree"><?php esc_html_e('Agreed to', 'classiera') ?> 
																<a target="_blank" href="<?php echo esc_url($termsandcondition); ?>">
																	<?php esc_html_e('terms & conditions.', 'classiera') ?>
																</a>
															</label>
														</div>
													</div>
													<?php if(!empty($classiera_gdpr_url)){ ?>
													<div class="form-group">
														<div class="checkbox col-sm-12">
															<input type="checkbox" name="gdpr" id="gdpr" value="gdpr">
															<label for="gdpr"><?php esc_html_e('Agreed to', 'classiera') ?> 
																<a target="_blank" href="<?php echo esc_url($classiera_gdpr_url); ?>">
																	<?php esc_html_e('GDPR', 'classiera') ?>
																</a>
																<?php esc_html_e(', keep me informed via email.', 'classiera') ?>
															</label>
														</div>
													</div>
													<?php } ?>
													<!--Checkbox-->
													<input type="hidden" name="submit" value="send_message" />
													<button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="send_message" value="send_message" type="submit"><?php esc_html_e( 'Send Message', 'classiera' ); ?></button>
												</form>
											</div><!--message-->
											<?php } ?>
										</div><!--tab-content-->
										<!-- Tab panes -->
									</div><!--user-make-offer-message-->
								</div><!--widget-content-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<?php if($classieraReportAd == 1){ ?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--ReportAd-->
								<div class="widget-content widget-content-post">
									<div class="user-make-offer-message border-bottom widget-content-post-area">
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="btnWatch btn-block">    
											<?php
												if(isset($current_user_ID)){
													echo classiera_authors_favorite_check($current_user_ID, $post->ID); 
												}
												?>
											</li>
											<li role="presentation" class="active hidden">
												<a href="#report" aria-controls="report" role="tab" data-toggle="tab"><i class="fas fa-exclamation-triangle"></i> <?php esc_html_e( 'Report', 'classiera' ); ?></a>
											</li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content hidden">
											<div role="tabpanel" class="tab-pane active" id="report">
												<form method="post" class="form-horizontal" data-toggle="validator">
													<?php if(!empty($displayMessage)){?>
													<div class="alert alert-success">
														<?php echo esc_html($displayMessage); ?>
													</div>
													<?php } ?>
													<div class="radio">
														<input id="illegal" value="illegal" type="radio" name="report_ad_val">
														<label for="illegal"><?php esc_html_e( 'This is illegal/fraudulent', 'classiera' ); ?></label>
														<input id="spam" value="spam" type="radio" name="report_ad_val">
														<label for="spam"><?php esc_html_e( 'This ad is spam', 'classiera' ); ?></label>
														<input id="duplicate" value="duplicate" type="radio" name="report_ad_val">
														<label for="duplicate"><?php esc_html_e( 'This ad is a duplicate', 'classiera' ); ?></label>
														<input id="wrong_category" value="wrong_category" type="radio" name="report_ad_val">
														<label for="wrong_category"><?php esc_html_e( 'This ad is in the wrong category', 'classiera' ); ?></label>
														<input id="post_rules" value="post_rules" type="radio" name="report_ad_val">
														<label for="post_rules"><?php esc_html_e( 'The ad goes against posting rules', 'classiera' ); ?></label>
														<input id="post_other" value="post_other" type="radio" name="report_ad_val">
														<label for="post_other"><?php esc_html_e( 'Other', 'classiera' ); ?></label>														
													</div>
													<div class="otherMSG">
														<textarea id="other_report" name="other_report" class="form-control"placeholder="<?php esc_attr_e( 'Type here..!', 'classiera' ); ?>"></textarea>
													</div>
													<input type="hidden" name="classiera_post_title" id="classiera_post_title" value="<?php the_title(); ?>" />
													<input type="hidden" name="classiera_post_url" id="classiera_post_url" value="<?php the_permalink(); ?>"  />
													<input type="hidden" name="submit" value="report_to_admin" />
													<button class="btn btn-primary btn-block btn-sm sharp btn-style-one" name="report_ad" value="report_ad" type="submit"><?php esc_html_e( 'Report', 'classiera' ); ?></button>
												</form>
											</div><!--tabpanel-->
										</div><!--tab-content-->
									</div><!--user-make-offer-message-->
								</div><!--widget-content-->
								<!--ReportAd-->
							</div><!--widget-box-->
						</div><!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<?php } ?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height" style="">
							<div class="widget-box ">
								<!--ReportAd-->
								<div class="widget-content widget-content-post">
									<div class="user-make-offer-message border-bottom widget-content-post-area">
										<!-- <form method="post" class="form-horizontal" action="<?php echo get_home_url(); ?>/inbox"> -->
											<input type="hidden" id="receiver_id" name="receiver_id" value="<?= $author_ID ?>">
											<input type="hidden" id="sender_id" name="sender_id" value="<?= $login_user_id ?>">
											<input type="hidden" id="ads_id" name="ads_id" value="<?= $post->ID; ?>">
											<input type="hidden" id="reciever_name" name="reciever_name" value="<?= $authorName ?>">
											<input type="hidden" id="sender_name" name="sender_name" value="<?= $sender_name ?>">
											<input type="hidden" id="receiver_image" name="receiver_image" value="<?= $author_avatar_url ?>">
											<input type="hidden" id="sender_image" name="sender_image" value="<?= $login_user_IMG ?>">
												<button class="btn btn-primary btn-block btn-sm sharp btn-style-one" id="inbox_message"><i class="fas fa-envelope"></i> Send Message</button>
											
										<!-- </form> -->
									</div><!--user-make-offer-message-->
								</div><!--widget-content-->
												<!--ReportAd-->
							</div><!--widget-box-->
						</div>
						<!--Social Widget-->
						<?php 				
						if ( class_exists( 'APSS_Class' ) && $classieraSingleAdStyle == 1) {
						?>
						<!-- <div class="col-lg-12 col-md-12 col-sm-6 match-height"> -->
							<!-- <div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>"> -->
								<!--Share-->
								<!-- <div class="widget-content widget-content-post">
									<div class="share border-bottom widget-content-post-area">
										<h5><?php esc_html_e( 'Share ad', 'classiera' ); ?>:</h5> -->
										<!--AccessPress Socil Login-->
										<!-- <?php echo do_shortcode('[apss-share]'); ?> -->
										<!--AccessPress Socil Login-->
									<!-- </div>
								</div> -->
								<!--Share-->
							<!-- </div> -->
							<!--widget-box-->
						<!-- </div> -->
						<!--col-lg-12 col-md-12 col-sm-6 match-height-->
						<!-- <?php } ?> -->
						<!--Social Widget-->
						<?php
						if($googleMapadPost == 1 && $classiera_MAP_location == 'sidebar'){
						?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box <?php if($classieraSingleAdStyle == 2){echo "border-none";}?>">
								<!--GoogleMAP-->
								<div class="widget-content widget-content-post">
									<div class="share widget-content-post-area">
										<h5><?php echo esc_attr($post_map_location); ?></h5>
										<?php if(!empty($post_latitude)){?>
										<div id="classiera_single_map">
										<!--<div id="single-page-main-map" id="details_adv_map">-->
										<div class="details_adv_map" id="details_adv_map">
											<script type="text/javascript">
											jQuery(document).ready(function(){
												var addressPoints = [							
													<?php 
													$content = '<a class="classiera_map_div" href="'.get_the_permalink().'"><img class="classiera_map_div__img" src="'.$classieraIMGURL.'" alt="images"><div class="classiera_map_div__body"><p class="classiera_map_div__price">'.__( "Price", 'classiera').' : <span>'.$classieraPostPrice.'</span></p><h5 class="classiera_map_div__heading">'.get_the_title().'</h5><p class="classiera_map_div__cat">'.__( "Category", 'classiera').' : '.esc_attr($postCurCat).'</p></div></a>';
													?>
													[<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>, '<?php if(function_exists('classiera_escape')) { classiera_escape($content); } ?>', "<?php echo esc_url($iconPath); ?>"],							
												];
												var mapopts;
												if(window.matchMedia("(max-width: 1024px)").matches){
													var mapopts =  {
														dragging:false,
														tap:false,
													};
												};
												var map = L.map('details_adv_map', mapopts).setView([<?php echo esc_attr($post_latitude); ?>,<?php echo esc_attr($post_longitude); ?>],13);
												var roadMutant = L.gridLayer.googleMutant({
												<?php if($classieraMapStyle){?>styles: <?php echo wp_kses_post($classieraMapStyle); ?>,<?php }?>
													maxZoom: 13,
													type:'roadmap'
												}).addTo(map);
												var markers = L.markerClusterGroup({
													spiderfyOnMaxZoom: true,
													showCoverageOnHover: true,
													zoomToBoundsOnClick: true,
													maxClusterRadius: 60
												});
												var markerArray = [];
												for (var i = 0; i < addressPoints.length; i++){
													var a = addressPoints[i];
													var newicon = new L.Icon({iconUrl: a[3],
														iconSize: [50, 50], // size of the icon
														iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
														popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
													});
													var title = a[2];
													var marker = L.marker(new L.LatLng(a[0], a[1]));
													marker.setIcon(newicon);
													marker.bindPopup(title);
													marker.title = title;
													marker.on('click', function(e) {
														map.setView(e.latlng, 13);
														
													});				
													markers.addLayer(marker);
													markerArray.push(marker);
													if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
														var group = L.featureGroup(markerArray); //add markers array to featureGroup
														map.fitBounds(group.getBounds());   
													}
												}
												map.addLayer(markers);
												<?php 
												if($classieraMAPDragging == false){
													?>
													map.dragging.disable();					
													<?php
												}
												?>
												<?php 
												if($classieraMAPScroll == false){
													?>
													map.scrollWheelZoom.disable();
													<?php
												}
												?>
											});
											</script>
										</div>
										<div id="ad-address">
											<span>
											<i class="fas fa-map-marker-alt"></i>
											<a href="http://maps.google.com/maps?saddr=&daddr=<?php echo esc_html($post_address); ?>" target="_blank">
												<?php esc_html_e( 'Get Directions on Google MAPS to', 'classiera' ); ?>: <?php echo esc_html($post_address); ?>
											</a>
											</span>
										</div>
									</div>
										<?php } ?>
									</div>
								</div>
								<!--GoogleMAP-->
							</div><!--widget-box-->
						</div><!--col-lg-12-->
						<?php } ?>
						<!--SidebarWidgets-->
						<?php 
						if ( is_active_sidebar( 'single' ) ) {
							dynamic_sidebar('single');
						}							
						?>
						<!--SidebarWidgets-->
					</div><!--row-->
				</aside><!--sidebar-->
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php endwhile; ?>
<!-- related post section -->
<?php 
if($relatedAdsOn == 1){
	function related_Post_ID(){
		global $post;
		$post_Id = $post->ID;
		return $post_Id;
	}
	get_template_part( 'templates/related-ads' );
}
?>
<!-- Company Section Start-->
<?php 	
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
<script>
	jQuery(document).ready(function($){
		$("#inbox_message").click(function(){		
			var sender_id = $("#sender_id").val();
			var receiver_id = $('#receiver_id').val();
			var reciever_name = $('#reciever_name').val();
			var sender_name = $('#sender_name').val();
			var receiver_image = $('#receiver_image').val();
			var sender_image = $('#sender_image').val();
			jQuery.ajax({
        type: 'POST',
        url:'https://djurhus.se/laravelchat/public/api/friends',
        
        data:{sender_id:sender_id, receiver_id:receiver_id, reciever_name:reciever_name, sender_name:sender_name, receiver_image:receiver_image, sender_image:sender_image},
        xhrFields: {withCredentials: true},
        success:function(data){
        	console.log(data);
        	window.location = "https://djurhus.se/inbox/";
        }
      });
		});
		
	});
</script>
<!-- Company Section End-->	
<!-- related post section -->
<?php get_footer(); ?>