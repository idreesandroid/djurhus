<?php
/**
 * Template name: Login Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera
 */

if ( is_user_logged_in() ) { 

	global $redux_demo; 
	$profile = classiera_get_template_url('template-profile.php');
	wp_redirect( $profile ); exit;

}

global $user_ID, $username, $password, $remember;
$errorMSG = '';

//We shall SQL escape all inputs
$username = esc_sql(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
$remember = esc_sql(isset($_REQUEST['rememberme']) ? $_REQUEST['rememberme'] : '');
	
if($remember) $remember = "true";
else $remember = "false";
$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$login_data['remember'] = $remember;
$user_verify = wp_signon( $login_data, false ); 

//wp_signon is a wordpress function which authenticates a user. It accepts user info parameters as an array.
if(isset($_POST['submit'])){
	if($_POST['submit'] == 'Login'){
		//print_r($_POST);
		/*==========================
		 Google (reCAPTCHA) plugin
		===========================*/
		if ( function_exists( "gglcptch_display" ) && isset($_POST['g-recaptcha-response'])){
			if(!empty($_POST['g-recaptcha-response'])){
				if ( is_wp_error($user_verify)){		
					$errorMSG =  esc_html__( 'Invalid username or password. Please try again!', 'classiera' );
				}else{
					global $redux_demo; 
					$profile = classiera_get_template_url('template-profile.php');
					wp_redirect( $profile ); exit;
				}
			}else{
				$errorMSG = esc_html__( 'Please complete reCAPTCHA.', 'classiera' );
			}
		}else{
			/*==========================
			 If We are not using Google (reCAPTCHA) plugin
			===========================*/
			if ( is_wp_error($user_verify)){		
				$errorMSG =  esc_html__( 'Invalid username or password. Please try again!', 'classiera' );
			}else{
				global $redux_demo; 
				$profile = classiera_get_template_url('template-profile.php');
				wp_redirect( $profile ); exit;
			}
		}
		
	}
}
global $redux_demo; 
$login = classiera_get_template_url('template-login.php');
if(empty($login)){
	$login = classiera_get_template_url('template-login-v2.php');
}
$reset = classiera_get_template_url('template-reset.php');
$register = classiera_get_template_url('template-register.php');
if(empty($register)){
	$register = classiera_get_template_url('template-login-v2.php');
}
$classieraSocialLogin = $redux_demo['classiera_social_login'];
$rand1 = rand(0,9);
$rand2 = rand(0,9);
$rand_answer = $rand1 + $rand2;
get_header(); ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<!-- page content -->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="login-register login-register-v1">
		<div class="container">
			<div class="row login_box">
				<div class="col-lg-7 col-md-11 col-sm-12 hidden-xs">
					<div class="iframe_container">
						<img src="https://djurhus.se/wp-content/uploads/2020/11/pexels-sam-lion-5731804-1.jpg" width="100%">
						<!-- <iframe src="//d3iwtia3ndepsv.cloudfront.net/clients/teasers/54fdbd1aa24e7b191d360df8_5f475deb6e6cc.html" width="100%" height="100%" frameborder="0" style="max-height: 100%; width: 100%;"></iframe> -->
					</div>
				</div>
				<div class="col-lg-5 col-md-11 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="classiera-login-register-heading border-bottom text-center">
								<h3 class="text-uppercase"><?php esc_html_e('Login', 'classiera') ?></h3>
							</div><!--classiera-login-register-heading-->
							<?php if($classieraSocialLogin == 1){?>
								<div class="social-login border-bottom">
									<h5 class="text-uppercase text-center">
										<?php esc_html_e('Log in or sign up with a social account', 'classiera') ?>
									</h5>
									<!--NextendSocialLogin-->
									<?php
									if(class_exists('NextendSocialLogin', false)){
										echo NextendSocialLogin::renderButtonsWithContainer();
									}
									?>
									<!--AccessPress Socil Login-->
									<?php 
									if( class_exists( 'APSL_Lite_Class' ) ) {
										echo do_shortcode('[apsl-login-lite]');
									}
									if ( class_exists( 'APSL_Class' ) ) {									
										echo do_shortcode('[apsl-login]');
									}
									?>
									<!--AccessPress Socil Login-->
									<!--Social Plugins-->
									<div class="social-login-or">
										<span><?php esc_html_e('OR', 'classiera') ?></span>
									</div>
								</div><!--social-login-->
							<?php } ?>
						</div><!--col-lg-12-->
					</div><!--row-->
					<div class="row">
						<div class="col-lg-12 center-block">
							<form data-toggle="validator" method="POST" id="classiera_login_form" name="classiera_login_form">
								<?php if(!empty($errorMSG)) { ?>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<h4 class="text-center text-danger text-uppercase" style="letter-spacing: 2px;">
													<?php echo esc_html( $errorMSG ); ?>
												</h4>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
									<div>
										<label for="username"><?php esc_html_e( 'Username', 'classiera' ); ?> : <span class="text-danger">*</span></label>
									</div><!--col-lg-3-->
									<div class="">
										<div class="inner-addon left-addon">
											<i class="left-addon form-icon fas fa-user"></i>
											<input type="text" id="username" name="username" class="form-control form-control-md sharp-edge" placeholder="<?php esc_attr_e( 'Your Username', 'classiera' ); ?>" data-error="<?php esc_attr_e( 'Username is required', 'classiera' ); ?>" required>
											<div class="help-block with-errors"></div>
										</div>
									</div><!--col-lg-9-->
								</div><!--UserName-->
								<div class="form-group">
									<div>
										<label for="password"><?php esc_html_e( 'Password', 'classiera' ); ?> : <span class="text-danger">*</span></label>
									</div>
									<div class="">
										<div class="inner-addon left-addon">
											<i class="left-addon form-icon fas fa-lock"></i>
											<input id="password" type="password" name="password" class="form-control form-control-md sharp-edge" placeholder="<?php esc_attr_e( 'Enter Password', 'classiera' ); ?>" data-error="<?php esc_attr_e( 'Password required', 'classiera' ); ?>" required>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								</div><!--Password-->
								<div class="flip">
									<div class="form-group clearfix">
										<div class="checkbox pull-left flip">
											<input type="checkbox" id="remember" name="rememberme" value="forever">
											<label for="remember"><?php esc_html_e( 'Remember me', 'classiera' ); ?></label>
										</div>
										<p class="forget-pass pull-right flip">
											<a href="<?php echo esc_url( $reset ); ?>"><?php esc_html_e('Forgot Password?', 'classiera') ?></a>
										</p>
									</div>
									<!--Google-->
									<?php
									if ( function_exists( 'gglcptch_display' ) ) {
										?>
										<div class="form-group">
											<?php 
											echo apply_filters( 'gglcptch_display_recaptcha', '', 'classiera_login_form');
											?>										
										</div>
										<?php
									}
									?>									
									<!--Google-->
									<div class="form-group">
										<input type="hidden" id="submitbtn" name="submit" value="Login" />				
										<button class="btn btn-primary sharp btn-md btn-style-one btn-block" id="edit-submit" name="op" value="Login" type="submit"><?php esc_html_e('LOGIN NOW', 'classiera') ?></button>
									</div>									
									<div class="form-group">
										<p><?php esc_html_e('Don&rsquo;t have an account?', 'classiera') ?> 
										<a href="<?php echo esc_url( $register ); ?>"><?php esc_html_e('Create one here.', 'classiera') ?></a>
									</p>
								</div>
							</div><!--Rememberme-->
						</form>
					</div><!--col-lg-8-->
				</div><!--row-->
			</div><!--col-lg-10-->
		</div><!--row-->	
	</div><!--container-->	
</div><!--login-register login-register-v1-->
</section>
<!-- page content -->
<?php get_footer(); ?>