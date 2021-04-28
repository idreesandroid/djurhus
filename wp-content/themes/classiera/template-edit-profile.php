<?php
/**
 * Template name: Profile Settings
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
global $user_ID, $user_identity, $user_level;
global $redux_demo;
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";
$profile = classiera_get_template_url('template-profile.php');
$current_user = wp_get_current_user();
$user_ID = $current_user->ID;
if ($user_ID){
	
	if($_POST){
		
		$message =  esc_html__( 'Your profile has been updated successfully.', 'classiera' );

		$first = esc_sql($_POST['first_name']);

		$last = esc_sql($_POST['last_name']);

		$email = esc_sql($_POST['email']);
		$current_email = esc_sql($_POST['current_email']);

		$user_url = esc_sql($_POST['website']);

		$user_phone = esc_sql($_POST['phone']);
		
		$user_phone2 = esc_sql($_POST['phone2']);
		$facebook = esc_sql($_POST['facebook']);
		$twitter = esc_sql($_POST['twitter']);
		$googleplus = esc_sql($_POST['google-plus']);
		$linkedin = esc_sql($_POST['linkedin']);
		$pinterest = esc_sql($_POST['pinterest']);
		$instagram = esc_sql($_POST['instagram']);
		$youtube = esc_sql($_POST['youtube']);
		$vimeo = esc_sql($_POST['vimeo']);
		$digg = esc_sql($_POST['digg']);
		$behance = esc_sql($_POST['behance']);
		$dribbble = esc_sql($_POST['dribbble']);
		$flickr = esc_sql($_POST['flickr']);
		$github = esc_sql($_POST['github']);
		$lastfm = esc_sql($_POST['lastfm']);
		$soundcloud = esc_sql($_POST['soundcloud']);
		$vk = esc_sql($_POST['vk']);
		
		$country = esc_sql($_POST['country']);
		$state = esc_sql($_POST['state']);
		$city = esc_sql($_POST['city']);
		$post_code = esc_sql($_POST['post_code']);
		$user_address = esc_sql($_POST['address']);
		
		$description = $_POST['desc'];

		$password = $_POST['pwd'];
		$confirm_password = $_POST['confirm'];
		
		$your_image_url = esc_sql($_POST['your_author_image_url']);

		update_user_meta( $user_ID, 'first_name', $first );

		update_user_meta( $user_ID, 'last_name', $last );

		update_user_meta( $user_ID, 'phone', $user_phone );
		update_user_meta( $user_ID, 'phone2', $user_phone2 );
		
		update_user_meta( $user_ID, 'facebook', $facebook );
		update_user_meta( $user_ID, 'twitter', $twitter );
		update_user_meta( $user_ID, 'googleplus', $googleplus );
		update_user_meta( $user_ID, 'linkedin', $linkedin );
		update_user_meta( $user_ID, 'pinterest', $pinterest );
		update_user_meta( $user_ID, 'instagram', $instagram );
		update_user_meta( $user_ID, 'youtube', $youtube );
		update_user_meta( $user_ID, 'vimeo', $vimeo );
		update_user_meta( $user_ID, 'digg', $digg );
		update_user_meta( $user_ID, 'behance', $behance );
		update_user_meta( $user_ID, 'dribbble', $dribbble );
		update_user_meta( $user_ID, 'flickr', $flickr );
		update_user_meta( $user_ID, 'github', $github );
		update_user_meta( $user_ID, 'lastfm', $lastfm );
		update_user_meta( $user_ID, 'soundcloud', $soundcloud );
		update_user_meta( $user_ID, 'vk', $vk );

		update_user_meta( $user_ID, 'country', $country );
		update_user_meta( $user_ID, 'state', $state );
		update_user_meta( $user_ID, 'city', $city );
		update_user_meta( $user_ID, 'postcode', $post_code );
		update_user_meta( $user_ID, 'address', $user_address );

		update_user_meta( $user_ID, 'description', $description );

		wp_update_user( array ('ID' => $user_ID, 'user_url' => $user_url) );
		if(isset($_POST['gdpr'])){
			$classiera_gdpr = true;
		}else{
			$classiera_gdpr = false;
		}
		if($classiera_gdpr == true){
			update_user_meta($user_ID, 'classiera_gdpr', 'yes');
		}else{
			update_user_meta($user_ID, 'classiera_gdpr', 'no');
		}
		if($email != $current_email){
			wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;
			update_user_meta( $user_ID, 'author_verified', 'unverified');
			$verify_code = '';
			update_user_meta( $user_ID, 'author_vcode', $verify_code );
		}
		$confirmPWD = $_POST['confirm'];
		$confirmPWD2 = $_POST['confirm2'];
		if(isset($password) && !empty($confirmPWD)) {

			if (strlen($password) < 5 || strlen($password) > 25) {
				$message =  esc_html__( 'Password must be 5 to 25 characters in length.', 'classiera' );
			}		
			if(isset($confirmPWD) && $confirmPWD == $confirmPWD2) {
				$update = wp_set_password( $confirmPWD, $user_ID );	
				$message =  esc_html__( 'Your profile updated successfully.', 'classiera' );
			}else{
				$message =  esc_html__( 'Password Mismatch', 'classiera' );
			}			
		}
	}
	/*== ImageUploading ==*/
	if ( isset($_FILES['upload_attachment']) ) {
		$count = '0';
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
				foreach ($_FILES as $file => $array) {					
					$newupload = classiera_insert_userIMG($file);
					$count++;
					$profileImage = $newupload;
					if(!empty($profileImage )){
						update_user_meta( $user_ID, 'classify_author_avatar_url', $profileImage );
					}
				}
			}
		}/*Foreach*/
	}
}

get_header();

$profile = classiera_get_template_url('template-profile.php');
$user_info = get_userdata($user_ID);
$classiera_gdpr = get_the_author_meta('classiera_gdpr', $user_ID);
$page = get_page($post->ID);
$current_page_id = $page->ID;	
?>
<!-- user pages -->
<section class="user-pages section-gray-bg">
    <div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<?php if($_POST){?>
				<div class="alert alert-success" role="alert">					
					<?php echo esc_html( $message ); ?>
				</div>
				<?php } ?>
				<div class="user-detail-section section-bg-white">
					<div class="user-ads user-profile-settings">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Profile Settings", 'classiera') ?>
						</h4>						
						<form data-toggle="validator" role="form" method="POST" id="primaryPostForm" action="" enctype="multipart/form-data" autocomplete="off">
							<!-- upload avatar -->
							<div class="media">
								<div class="media-left uploadImage">
									<?php 
									$profileIMGID = get_user_meta($user_ID, "classify_author_avatar_url", true);
									$profileIMG = classiera_get_profile_img($profileIMGID);
									$authorName = get_the_author_meta('display_name', $user_ID);
									$author_verified = get_the_author_meta('author_verified', $user_ID);
									if(empty($profileIMG)){
										$profileIMG = classiera_get_avatar_url ( get_the_author_meta('user_email', $user_ID), $size = '130' );
										?>
										<img class="media-object img-circle author-avatar" src="<?php echo esc_url( $profileIMG ); ?>" alt="<?php echo esc_attr( $authorName ); ?>">	
										<?php
									}else{ ?>
										<img class="media-object img-circle author-avatar" src="<?php echo esc_url( $profileIMG ); ?>" alt="<?php echo esc_attr( $authorName ); ?>">	
									<?php } ?>
									<input class="criteria-image-url" id="your_image_url" type="text" size="36" name="your_author_image_url" style="display: none;" value="" />
								</div>
								<div class="media-body">
									<h5 class="media-heading text-uppercase">
										<?php esc_html_e( 'Update your Profile Photo', 'classiera' ); ?>
									</h5>
									<p><?php esc_html_e( 'Update your avatar manually. If you don&rsquo;t update it here, the Gravatar profile image will be used if you have Gravatar profile associated with your registered email address', 'classiera' ); ?></p>
									<div class="choose-image">
										<input type="file" id="file-1" name="upload_attachment[]" class="inputfile inputfile-1 author-UP" data-multiple-caption="{count} files selected" multiple />
										<label for="file-1" class="upload-author-image"><i class="fas fa-camera"></i>
											<span><?php esc_html_e( 'Upload photo', 'classiera' ); ?></span>
										</label>
										<!-- verify profile btn-->
										<?php if($author_verified != 'verified'){ ?>										
											<button class="classiera_verify_btn classiera_verified" data-toggle="modal" data-target="#verifyModal" type="button"> <i class="fas fa-check"></i> <?php esc_html_e( 'Verify your account', 'classiera' ); ?></button>
										<?php } ?>
										<!-- verify profile btn-->
									</div>									
								</div>
							</div><!-- /.upload avatar -->
							<!-- user basic information -->
							<h4 class="user-detail-section-heading text-uppercase">
								<?php esc_html_e( 'Basic Information', 'classiera' ); ?>
							</h4>
							<div class="form-inline row form-inline-margin">
								<div class="form-group col-sm-5">
									<label for="first-name"><?php esc_html_e( 'First Name', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="first-name" name="first_name" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your first name', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->first_name ); ?>">
									</div>
								</div><!--Firstname-->
								<div class="form-group col-sm-5">
									<label for="last-name"><?php esc_html_e( 'Last Name', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="last-name" name="last_name" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your last name', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->last_name ); ?>">
									</div>
								</div><!--Last name-->
								<div class="form-group col-sm-12">
									<label for="bio"><?php esc_html_e( 'Biography', 'classiera' ); ?></label>
									<div class="inner-addon">
										<textarea name="desc" id="bio" placeholder="<?php esc_attr_e( 'Type a short info about yourself', 'classiera' ); ?>"><?php echo esc_html( $user_info->description ); ?></textarea>
									</div>
								</div><!--biography-->
							</div>
							<!-- user basic information -->
							<!-- Contact Details -->
							<h4 class="user-detail-section-heading text-uppercase">
								<?php esc_html_e( 'Contact Details', 'classiera' ); ?>
							</h4>
							<div class="form-inline row form-inline-margin">
								<div class="form-group col-sm-5">
									<label for="phone"><?php esc_html_e( 'Phone Number', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="tel" id="phone" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your phone number', 'classiera' ); ?>" name="phone" value="<?php echo esc_html( $user_info->phone ); ?>">
									</div>
								</div><!--Phone Number-->
								<div class="form-group col-sm-5">
									<label for="mobile"><?php esc_html_e( 'Mobile Number', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="tel" id="mobile" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your mobile number', 'classiera' ); ?>" name="phone2" value="<?php echo esc_html( $user_info->phone2 ); ?>">
									</div>
								</div><!--Mobile Number-->
								<div class="form-group col-sm-5">
									<label for="website"><?php esc_html_e( 'Your Website', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="url" id="website" name="website" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your website link', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->user_url ); ?>">
									</div>
								</div><!--Your Website-->
								<div class="form-group col-sm-5">
									<label for="email"><?php esc_html_e( 'Your Email', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="email" name="email" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your email address', 'classiera' ); ?>" value="<?php echo sanitize_email( $user_info->user_email ); ?>">
										<input type="hidden" name="current_email" value="<?php echo sanitize_email( $user_info->user_email ); ?>">
									</div>
								</div><!--Your Email-->
								<!--<div class="form-group col-sm-5">-->
								<!--	<label for="email"><?php esc_html_e( 'Your Country', 'classiera' ); ?></label>-->
								<!--	<div class="inner-addon">-->
								<!--		<input type="text" id="country" name="country" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your country', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->country ); ?>">-->
								<!--	</div>-->
								<!--</div>-->
								<!--Your Country-->
								<div class="form-group col-sm-5">
									<label for="email"><?php esc_html_e( 'Your State', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="state" name="state" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your state', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->state ); ?>">
									</div>
								</div><!--Your State-->
								<div class="form-group col-sm-5">
									<label for="email"><?php esc_html_e( 'Your City', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="city" name="city" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your city', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->city ); ?>">
									</div>
								</div><!--Your City-->
								<div class="form-group col-sm-5">
									<label for="email"><?php esc_html_e( 'Your Post Code', 'classiera' ); ?></label>
									<div class="inner-addon">
										<input type="text" id="post_code" name="post_code" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your post code', 'classiera' ); ?>" value="<?php echo esc_attr( $user_info->postcode ); ?>">
									</div>
								</div><!--Your Post Code-->
								<div class="form-group col-sm-12">
									<label for="address"><?php esc_html_e( 'Address', 'classiera' ); ?></label>
									<div class="inner-addon">
										<textarea name="address" id="address" placeholder="<?php esc_attr_e( 'Enter your address', 'classiera' ); ?>"><?php echo esc_html( $user_info->address ); ?></textarea>
									</div>
								</div><!--Address-->
							</div>
							<!-- Contact Details -->
							<!-- Social Profile Links -->
							<h4 class="user-detail-section-heading text-uppercase hidden">
								<?php esc_html_e( 'Social Profile Links', 'classiera' ); ?>
							</h4>							
							<div class="form-inline row form-inline-margin hidden">
								<div class="form-group col-sm-5">
									<label for="facebook"><?php esc_html_e( 'Facebook', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-facebook-f"></i></div>
											<input type="url" id="facebook" name="facebook" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Facebook URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->facebook ); ?>">
										</div>
									</div>
								</div><!--facebook-->
								<div class="form-group col-sm-5">
									<label for="twitter"><?php esc_html_e( 'Twitter', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-twitter"></i></div>
											<input type="url" id="twitter" name="twitter" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Twitter URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->twitter ); ?>">
										</div>
									</div>
								</div><!--twitter-->
								<div class="form-group col-sm-5">
									<label for="googleplus"><?php esc_html_e( 'Google Plus', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-google-plus-g"></i></div>
											<input type="url" id="googleplus" name="google-plus" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Google Plus URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->googleplus); ?>">
										</div>
									</div>
								</div><!--Google Plus-->
								<div class="form-group col-sm-5">
									<label for="instagram"><?php esc_html_e( 'Instagram', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-instagram"></i></div>
											<input type="url" id="instagram" name="instagram" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Instagram URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->instagram ); ?>">
										</div>
									</div>
								</div><!--instagram-->
								<div class="form-group col-sm-5">
									<label for="pinterest"><?php esc_html_e( 'Pinterest', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-pinterest-p"></i></div>
											<input type="url" id="pinterest" name="pinterest" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Pinterest URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->pinterest ); ?>">
										</div>
									</div>
								</div><!--pinterest-->
								<div class="form-group col-sm-5">
									<label for="linkedin"><?php esc_html_e( 'LinkedIn', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-linkedin"></i></div>
											<input type="url" id="linkedin" name="linkedin" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Linkedin URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->linkedin ); ?>">
										</div>
									</div>
								</div><!--linkedin-->
								<div class="form-group col-sm-5">
									<label for="vimeo"><?php esc_html_e( 'Vimeo', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-vimeo"></i></div>
											<input type="url" id="vimeo" name="vimeo" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Vimeo URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->vimeo ); ?>">
										</div>
									</div>
								</div><!--vimeo-->
								<div class="form-group col-sm-5">
									<label for="youtube"><?php esc_html_e( 'YouTube', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm"><i class="fab fa-youtube"></i></div>
											<input type="url" id="youtube" name="youtube" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your YouTube URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->youtube ); ?>">
										</div>
									</div>
								</div><!--youtube-->
								<div class="form-group col-sm-5">
									<label for="digg"><?php esc_html_e( 'Digg', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-digg"></i>
											</div>
											<input type="url" id="digg" name="digg" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Digg URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->digg ); ?>">
										</div>
									</div>
								</div><!--digg-->
								<div class="form-group col-sm-5">
									<label for="behance"><?php esc_html_e( 'Behance', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-behance"></i>
											</div>
											<input type="url" id="behance" name="behance" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Behance URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->behance ); ?>">
										</div>
									</div>
								</div><!--behance-->
								<div class="form-group col-sm-5">
									<label for="dribbble"><?php esc_html_e( 'Dribbble', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-dribbble"></i>
											</div>
											<input type="url" id="dribbble" name="dribbble" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Dribble URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->dribbble ); ?>">
										</div>
									</div>
								</div><!--dribbble-->
								<div class="form-group col-sm-5">
									<label for="flickr"><?php esc_html_e( 'Flickr', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-flickr"></i>
											</div>
											<input type="url" id="flickr" name="flickr" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Flickr URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->flickr ); ?>">
										</div>
									</div>
								</div><!--flickr-->
								<div class="form-group col-sm-5">
									<label for="github"><?php esc_html_e( 'GitHub', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-github"></i>
											</div>
											<input type="url" id="github" name="github" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your GitHub URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->github ); ?>">
										</div>
									</div>
								</div><!--github-->
								<div class="form-group col-sm-5">
									<label for="lastfm"><?php esc_html_e( 'Last.fm', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-lastfm"></i>
											</div>
											<input type="url" id="lastfm" name="lastfm" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your Last.fm URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->lastfm ); ?>">
										</div>
									</div>
								</div><!--lastfm-->
								<div class="form-group col-sm-5">
									<label for="soundcloud"><?php esc_html_e( 'SoundCloud', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-soundcloud"></i>
											</div>
											<input type="url" id="soundcloud" name="soundcloud" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your SoundCloud URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->soundcloud ); ?>">
										</div>
									</div>
								</div><!--soundcloud-->
								<div class="form-group col-sm-5">
									<label for="vk"><?php esc_html_e( 'VK', 'classiera' ); ?></label>
									<div class="inner-addon">
										<div class="input-group">
											<div class="input-group-addon input-group-addon-width-sm">
												<i class="fab fa-vk"></i>
											</div>
											<input type="url" id="vk" name="vk" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your VK URL', 'classiera' ); ?>" value="<?php echo esc_url( $user_info->vk ); ?>">
										</div>
									</div>
								</div><!--vk-->
							</div><!--form-inline-->
							<!-- Socail Profile Links -->							
							<!-- Update your Password -->
							<h4 class="user-detail-section-heading text-uppercase"><?php esc_html_e( 'Update your Password', 'classiera' ); ?></h4>
							<div class="form-inline row">
								<div class="form-group col-sm-5">
									<label for="current-pass">
										<?php esc_html_e( 'Enter your current password', 'classiera' ); ?>
									</label>
									<div class="inner-addon">
										<input type="password" id="current-pass" name="pwd" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your current password', 'classiera' ); ?>" autocomplete="new-password">
									</div>
								</div>
							</div><!--currentpass-->
							<div class="form-inline row">
								<div class="form-group col-sm-5">
									<label for="new-pass">
										<?php esc_html_e( 'Enter New Password', 'classiera' ); ?>
									</label>
									<div class="inner-addon">
										<input type="password" name="confirm" data-minlength="5" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter new password', 'classiera' ); ?>" id="new-pass" data-error="<?php esc_attr_e( 'Password required', 'classiera' ); ?>">
										<div class="help-block">
											<?php esc_html_e( 'Minimum of 5 characters', 'classiera' ); ?>
										</div>
									</div>
								</div>
							</div><!--Enter New Password-->
							<div class="form-inline row">
								<div class="form-group col-sm-5">
									<label for="re-enter">
										<?php esc_html_e( 'Re-enter New Password', 'classiera' ); ?>
									</label>
									<div class="inner-addon">
										<input type="password" id="re-enter" name="confirm2" class="form-control form-control-sm sharp-edge" placeholder="<?php esc_attr_e( 'Re-enter New Password', 'classiera' ); ?>" data-match="#new-pass" data-match-error="<?php esc_attr_e( 'Whoops, these don&rsquo;t match', 'classiera' ); ?>">
										<div class="help-block with-errors"></div>
									</div>
								</div>
							</div><!--Enter New Password-->
							<!--GDPR-->
							<div class="form-inline row">
								<div class="form-group col-sm-12">
									<div class="checkbox">
										<input type="checkbox" name="gdpr" id="gdpr" value="gdpr" <?php if($classiera_gdpr == 'yes'){ echo "checked";}?>>
										<label for="gdpr">
											<?php esc_html_e('Keep me informed via email about my account info and my all ads related emails.', 'classiera') ?>
										</label>
									</div>
								</div>
							</div>
							<!--GDPR-->
							<p><?php esc_html_e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'classiera' ); ?></p>
							<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
							<input type="hidden" name="submitted" id="submitted" value="true" />
							<button type="submit" name="op" value="update_profile" class="btn btn-primary sharp btn-sm btn-style-one"><?php esc_html_e('Update Now', 'classiera') ?></button>
							<!-- Update your Password -->
						</form>
					</div><!--user-ads user-profile-settings-->
				</div><!--user-detail-section-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->	
</section><!--user-pages section-gray-bg-->	
<!-- user pages -->
<!--Verify Profile Modal-->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<?php 
	$authorEmail = $user_info->user_email;
	$dbcode = get_the_author_meta('author_vcode', $user_ID);
	$classieraVerifyCode = md5($authorEmail);
	?>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-uppercase text-center" id="myModalLabel">
					<?php esc_html_e('Verify Your Account Now', 'classiera') ?>
				</h4>
				<p class="text-uppercase text-center">
					<?php esc_html_e('Following these Steps', 'classiera') ?>
				</p>
			</div><!--modal-header-->
			<div class="modal-body">
				<form method="post" class="form-inline row classiera_get_code_form">
					<span class="classiera--loader"><img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader.gif' ?>" alt="classiera loader"></span>
					<div class="form-group col-sm-9">
						<input type="text" class="form-control verify_email" placeholder="<?php esc_attr_e('example@email.com', 'classiera') ?>" value="<?php echo sanitize_email( $authorEmail ); ?>" disabled>
						<input type="hidden" value="<?php echo esc_html( $classieraVerifyCode ); ?>" name="" class="verify_code">
						<input type="hidden" value="<?php echo esc_attr( $user_ID ); ?>" name="" class="verify_user_id">
						<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
					</div>
					<div class="form-group col-sm-3">
						<button type="submit" class="btn btn-primary sharp btn-sm btn-style-one verify_get_code">
							<?php esc_html_e('Get verification Code', 'classiera') ?>
						</button>
					</div>
				</form><!--classiera_get_code_form-->			
				<form method="post" class="form-inline row classiera_verify_form" <?php if($dbcode){ ?>style="display:block;" <?php } ?>>
					<span class="classiera--loader"><img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader.gif' ?>" alt="classiera loader"></span>
					<h5 class="text-center text-uppercase">
						<?php esc_html_e('Check your email inbox and paste code below', 'classiera') ?>
					</h5>
					<div class="form-group col-sm-9">
						<input type="text" class="form-control verification_code" placeholder="<?php esc_attr_e('Enter your verification code', 'classiera') ?>" value="" required>
						<input type="hidden" value="<?php echo esc_attr( $user_ID ); ?>" name="" class="verify_user_id">
						<input type="hidden" value="<?php echo sanitize_email( $authorEmail ); ?>" name="" class="verify_email">
						<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
					</div>
					<div class="form-group col-sm-3">
						<button type="submit" class="btn btn-primary sharp btn-sm btn-style-one verify_code_btn">
							<?php esc_html_e('Verify Now', 'classiera') ?>
						</button>
					</div>
				</form><!--classiera_verify_form-->
				<div class="classiera_verify_congrats text-center">
					
				</div><!--classiera_verify_congrats-->
			</div><!--modal-body-->
		</div><!--modal-content-->
	</div><!--modal-dialog modal-lg-->
</div><!--modal fade-->
<!--Verify Profile Modal-->
<?php get_footer(); ?>