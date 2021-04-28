<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php 	
	global $redux_demo;
	$favicon = '';
	$classieraLogo = '';
	$classiera_header_code = '';
	$classieraNavStyle = 1;
	$classiera_mobile_btn = true;
	if(isset($redux_demo)){
		$favicon = $redux_demo['favicon']['url'];
		$classieraLogo = $redux_demo['logo']['url'];
		$classieraNavStyle = $redux_demo['nav-style'];
		$classiera_header_code = $redux_demo['classiera_header_code'];
		$classiera_mobile_btn = $redux_demo['classiera_mobile_btn'];
	}
	$current_user = wp_get_current_user();
	$user_ID = $current_user->ID;
	$classieraAuthorEmail = $current_user->user_email;
	$classieraDisplayName = $current_user->display_name;
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_nicename;
	}
	if(empty($classieraDisplayName)){
		$classieraDisplayName = $current_user->user_login;
	}
?>
	<head>		
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php 
	if(is_front_page()){
		?>
	<meta property="og:image" content="<?php echo esc_url($classieraLogo); ?>"/>
		<?php
	}elseif(is_single()){
		$ID = $wp_query->post->ID;
		$classieraOGIMG = wp_get_attachment_url( get_post_thumbnail_id($ID) );
		?>
	<meta property="og:image" content="<?php echo esc_url($classieraOGIMG); ?>"/>
		<?php
	}
	?>
	<?php
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {			
		if (!empty($favicon)){
		?>
		<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" type="image/x-icon" />
		<?php }else{ ?>
		<link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico" type="image/x-icon">
		<?php
		}
	}
	?>	
	<?php wp_head(); ?>
	<?php 
	if(!empty($classiera_header_code)){
		if(function_exists('classiera_escape')) {
			classiera_escape($classiera_header_code);
		}
	}
	?>
	</head>
	
<body <?php body_class(); ?>>
	<?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }
    ?>
	<header>
	<div class="top-bar-line"></div>
	<?php 
	if($classieraNavStyle != 5){
		get_template_part('templates/top-bar'); 
	}	
	?>
	<?php get_template_part('templates/nav-bar'); ?>
	<?php if($classiera_mobile_btn == true){ ?>
	<!-- Mobile App button -->
	<div class="mobile-submit affix">
        <ul class="list-unstyled list-inline mobile-app-button">
			<li>
                <a href="<?php echo esc_url(home_url()); ?>">
                    <i class="fas fa-home"></i>
                    <span><?php esc_html_e( 'Home', 'classiera' ); ?></span>
                </a>
            </li>
            1213
		<?php 	
			$classieraProfileURL = classiera_get_template_url('template-profile.php');	
			$classieraLoginURL = classiera_get_template_url('template-login.php');
			if(empty($classieraLoginURL)){
				$classieraLoginURL = classiera_get_template_url('template-login-v2.php');
			}		
			$classieraRegisterURL = classiera_get_template_url('template-register.php');
			if(empty($classieraRegisterURL)){
				$classieraRegisterURL = classiera_get_template_url('template-login-v2.php');
			}
			$classieraSubmitPost = classiera_get_template_url('template-submit-ads.php');
			if(empty($classieraSubmitPost)){
				$classieraSubmitPost = classiera_get_template_url('template-submit-ads-v2.php');
			}
			$classieraInbox = classiera_get_template_url('template-message.php');		
			if(is_user_logged_in()){
		?>
			<?php if(!empty($classieraSubmitPost)){ ?>
			<li>
                <a href="<?php echo esc_url($classieraSubmitPost); ?>">
                    <i class="fas fa-edit"></i>
                    <span><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="<?php echo esc_url($classieraInbox); ?>">
                    <i class="fas fa-envelope"></i>
                    <span><?php esc_html_e("Message", 'classiera') ?></span>
                </a>
            </li>
			<li>
                <a href="<?php echo esc_url($classieraProfileURL); ?>">
                    <i class="fas fa-user"></i>
                    <span><?php echo esc_attr( $classieraDisplayName ); ?></span>
                </a>
            </li>
			<li>
                <a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span><?php esc_html_e( 'Log out', 'classiera' ); ?></span>
                </a>
            </li>
		 <?php }else{?>
            <li>
                <a href="<?php echo esc_url($classieraLoginURL); ?>">
                    <i class="fas fa-sign-in-alt"></i>
                    <span><?php esc_html_e( 'Login', 'classiera' ); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url($classieraRegisterURL); ?>">
                    <i class="fas fa-user"></i>
                    <span><?php esc_html_e( 'Get Registered', 'classiera' ); ?></span>
                </a>
            </li>
			<?php if(!empty($classieraSubmitPost)){ ?>
			<li>
                <a href="<?php echo esc_url($classieraSubmitPost); ?>">
                    <i class="fas fa-edit"></i>
                    <span><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></span>
                </a>
            </li>
			<?php } ?>
		 <?php } ?>
        </ul>
    </div>
	<!-- Mobile App button -->
	<?php } ?>
	

<?php get_template_part('searchbar/searchminimal'); ?>
</header>

