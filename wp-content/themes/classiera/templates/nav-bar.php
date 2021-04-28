<?php 
	global $redux_demo;
	$classieraSecClass = '';
	$classieraNavClass = '';
	$offcanvasDark = '';
	$classieraStickyClass = '';
	$affixClass = '';
	$container = 'container';
	$classieraNavStyle = 1;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraStickyNav = $redux_demo['classiera_sticky_nav'];
	$classieraLogo = $redux_demo['logo']['url'];	
	$classieraOffcanvas = $redux_demo['logo_offcanvas']['url'];
	if(empty($classieraOffcanvas)){
		$classieraOffcanvas = $redux_demo['logo']['url'];
	}
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

	//Socail Links
	$classieraFacebook = $redux_demo['facebook-link'];
	$classieraTwitter = $redux_demo['twitter-link'];
	$classieraDribbble = $redux_demo['dribbble-link'];
	$classieraFlickr = $redux_demo['flickr-link'];
	$classieraGithub = $redux_demo['github-link'];
	$classieraPinterest = $redux_demo['pinterest-link'];	
	$classieraYouTube = $redux_demo['youtube-link'];
	$classieraGoogle = $redux_demo['google-plus-link'];
	$classieraLinkedin = $redux_demo['linkedin-link'];
	$classieraInstagram = $redux_demo['instagram-link'];
	$classieraVimeo = $redux_demo['vimeo-link'];
	$classieraVK = $redux_demo['vk-link'];
	$classieraOK = $redux_demo['odnoklassniki-link'];
	$primaryColor = $redux_demo['color-primary'];
	

	$classieraNavStyle = $redux_demo['nav-style'];

	if($classieraStickyNav == 1){
		$classieraStickyClass = 'navbar-fixed-top';
		$affixClass = 'classieraNavAffix';
	}
	if(empty($classieraNavStyle)){
		$classieraNavStyle = 1;
	}
	if($classieraNavStyle == 1){
		echo "testt";
		$container = 'container';
		$classieraSecClass = 'classiera-navbar-v1';
		$classieraNavClass = 'classiera-custom-navbar-v1';
	}elseif($classieraNavStyle == 2){
		$container = 'container';
		$classieraSecClass = 'classiera-navbar-v2';
	}elseif($classieraNavStyle == 3){
		$container = '';
		$classieraSecClass = 'classiera-navbar-v3';
		$classieraNavClass = 'classiera-custom-navbar-v1';
		$container = 'container-fluid';
	}elseif($classieraNavStyle == 4){
		$container = 'container';
		$classieraSecClass = 'classiera-navbar-v4';
		$classieraNavClass = '';
	}elseif($classieraNavStyle == 5){
		$container = '';
		$classieraSecClass = 'classiera-navbar-v5 '.$classieraStickyClass;
		$offcanvasDark = 'offcanvas-dark';
		$classieraNavClass = '';
	}elseif($classieraNavStyle == 6){
		$container = 'container';
		$classieraSecClass = 'classiera-navbar-v6 '.$classieraStickyClass;
	}elseif($classieraNavStyle == 7){
		$container = '';
		$classieraSecClass = 'classiera-navbar-v6 classiera-navbar-v7 '.$classieraStickyClass;
	}elseif($classieraNavStyle == 8){
		$classieraSecClass = 'classiera-navbar-v5 classiera-navbar-minimal '.$classieraStickyClass;
	}
	
?>
<!-- NavBar -->
<section class="classiera-navbar  <?php echo esc_attr($affixClass);?> <?php echo esc_attr($classieraSecClass); ?>">
	<?php if($classieraNavStyle == 4 || $classieraNavStyle == 6 || $classieraNavStyle == 7){?>
		<!--Only Shown For Nav Style 4-->
		<nav id="myNavmenu" class="navmenu navmenu-default offcanvas offcanvas-light <?php if(is_rtl()){echo "navmenu-fixed-right";}else{ echo "navmenu-fixed-left"; } ?>" role="navigation">
			<div class="navmenu-brand clearfix">
				<a href="<?php echo esc_url(home_url()); ?>">
					<?php if(empty($classieraOffcanvas)){?>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
					<?php }else{ ?>
						<img src="<?php echo esc_url($classieraOffcanvas); ?>" alt="<?php bloginfo( 'name' ); ?>">
					<?php } ?>
				</a>
				<button type="button" class="offcanvas-button" data-toggle="offcanvas" data-target="#myNavmenu">
					<i class="fas fa-times"></i>
				</button>
			</div><!--navmenu-brand clearfix-->
			<div class="log-reg-btn text-center">
				<?php if(is_user_logged_in()){?>
					<a href="<?php echo esc_url($classieraProfileURL); ?>" class="offcanvas-log-reg-btn">
						<?php echo esc_attr( $classieraDisplayName ); ?>
					</a>
					<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Log out', 'classiera' ); ?>
					</a>
				<?php }else{ ?>
					<a href="<?php echo esc_url($classieraLoginURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Login', 'classiera' ); ?>
					</a>
					<a href="<?php echo esc_url($classieraRegisterURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
					</a>
				<?php } ?>
			</div>
			<?php 
				//enque Menu Function
				classieraMobileNav();
			?>
			<?php if(!empty($classieraSubmitPost)){ ?>
			<div class="submit-post">
				<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-block btn-primary btn-md active">
					<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
				</a>
			</div><!--submit-post-->
			<?php } ?>
			<div class="social-network">
				<h5><?php esc_html_e( 'Social network', 'classiera' ); ?></h5>
				<!--FacebookLink-->
				<?php if(!empty($classieraFacebook)){?>
				<a href="<?php echo esc_url($classieraFacebook); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-facebook-f"></i>
				</a>
				<?php } ?>
				<!--twitter-->
				<?php if(!empty($classieraTwitter)){?>
				<a href="<?php echo esc_url($classieraTwitter); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-twitter"></i>
				</a>
				<?php } ?>
				<!--Dribbble-->
				<?php if(!empty($classieraDribbble)){?>
				<a href="<?php echo esc_url($classieraDribbble); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-dribbble"></i>
				</a>
				<?php } ?>
				<!--Flickr-->
				<?php if(!empty($classieraFlickr)){?>
				<a href="<?php echo esc_url($classieraFlickr); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-flickr"></i>
				</a>
				<?php } ?>
				<!--Github-->
				<?php if(!empty($classieraGithub)){?>
				<a href="<?php echo esc_url($classieraGithub); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-github"></i>
				</a>
				<?php } ?>
				<!--Pinterest-->
				<?php if(!empty($classieraPinterest)){?>
				<a href="<?php echo esc_url($classieraPinterest); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-pinterest-p"></i>
				</a>
				<?php } ?>
				<!--YouTube-->
				<?php if(!empty($classieraYouTube)){?>
				<a href="<?php echo esc_url($classieraYouTube); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-youtube"></i>
				</a>
				<?php } ?>
				<!--Google-->
				<?php if(!empty($classieraGoogle)){?>
				<a href="<?php echo esc_url($classieraGoogle); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-google-plus-g"></i>
				</a>
				<?php } ?>
				<!--Linkedin-->
				<?php if(!empty($classieraLinkedin)){?>
				<a href="<?php echo esc_url($classieraLinkedin); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-linkedin"></i>
				</a>
				<?php } ?>
				<!--Instagram-->
				<?php if(!empty($classieraInstagram)){?>
				<a href="<?php echo esc_url($classieraInstagram); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-instagram"></i>
				</a>
				<?php } ?>
				<!--Vimeo-->
				<?php if(!empty($classieraVimeo)){?>
				<a href="<?php echo esc_url($classieraVimeo); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-vimeo"></i>
				</a>
				<?php } ?>
				<!--VK-->
				<?php if(!empty($classieraVK)){?>
				<a href="<?php echo esc_url($classieraVK); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-vk"></i>
				</a>
				<?php } ?>
				<!--OK-->
				<?php if(!empty($classieraOK)){?>
				<a href="<?php echo esc_url($classieraOK); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-odnoklassniki"></i>
				</a>
				<?php } ?>
			</div>
		</nav>
		<!--Only Shown For Nav Style 4-->
	<?php } ?>
	<div class="<?php echo esc_attr($container); ?>">
		<?php if($classieraNavStyle == 4){?>
		<div class="row">
		<div class="col-lg-12">
		<?php } ?>
		<!-- mobile off canvas nav -->
		<?php if($classieraNavStyle == 1 || $classieraNavStyle == 2 || $classieraNavStyle == 3 || $classieraNavStyle == 5 || $classieraNavStyle == 8){?>
		<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas offcanvas-light <?php if(is_rtl()){echo "navmenu-fixed-right";}else{ echo "navmenu-fixed-left"; } ?> <?php echo esc_attr($offcanvasDark); ?>" role="navigation">
			<div class="navmenu-brand clearfix">
				<a href="<?php echo esc_url(home_url()); ?>">
					<?php if(empty($classieraOffcanvas)){?>
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
					<?php }else{ ?>
						<img src="<?php echo esc_url($classieraOffcanvas); ?>" alt="<?php bloginfo( 'name' ); ?>">
					<?php } ?>
				</a>
				<button type="button" class="offcanvas-button" data-toggle="offcanvas" data-target="#myNavmenu">
					<i class="fas fa-times"></i>
				</button>
			</div><!--navmenu-brand clearfix-->
			<div class="log-reg-btn text-center">
				<?php if(is_user_logged_in()){?>
					<a href="<?php echo esc_url($classieraProfileURL); ?>" class="offcanvas-log-reg-btn">
						<?php echo esc_attr( $classieraDisplayName ); ?>
					</a>
					<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Log out', 'classiera' ); ?>
					</a>
				<?php }else{ ?>
					<a href="<?php echo esc_url($classieraLoginURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Login', 'classiera' ); ?>
					</a>
					<a href="<?php echo esc_url($classieraRegisterURL); ?>" class="offcanvas-log-reg-btn">
						<?php esc_html_e( 'Get Registered', 'classiera' ); ?>
					</a>
				<?php } ?>
			</div>
			<?php 
				//enque Menu Function
				classieraMobileNav();
			?>
			<?php if(!empty($classieraSubmitPost)){ ?>
			<div class="submit-post">
				<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-block btn-primary btn-md active">
					<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
				</a>
			</div><!--submit-post-->
			<?php } ?>
			<div class="social-network">
				<h5><?php esc_html_e( 'Social network', 'classiera' ); ?></h5>
				<!--FacebookLink-->
				<?php if(!empty($classieraFacebook)){?>
				<a href="<?php echo esc_url($classieraFacebook); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-facebook-f"></i>
				</a>
				<?php } ?>
				<!--twitter-->
				<?php if(!empty($classieraTwitter)){?>
				<a href="<?php echo esc_url($classieraTwitter); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-twitter"></i>
				</a>
				<?php } ?>
				<!--Dribbble-->
				<?php if(!empty($classieraDribbble)){?>
				<a href="<?php echo esc_url($classieraDribbble); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-dribbble"></i>
				</a>
				<?php } ?>
				<!--Flickr-->
				<?php if(!empty($classieraFlickr)){?>
				<a href="<?php echo esc_url($classieraFlickr); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-flickr"></i>
				</a>
				<?php } ?>
				<!--Github-->
				<?php if(!empty($classieraGithub)){?>
				<a href="<?php echo esc_url($classieraGithub); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-github"></i>
				</a>
				<?php } ?>
				<!--Pinterest-->
				<?php if(!empty($classieraPinterest)){?>
				<a href="<?php echo esc_url($classieraPinterest); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-pinterest-p"></i>
				</a>
				<?php } ?>
				<!--YouTube-->
				<?php if(!empty($classieraYouTube)){?>
				<a href="<?php echo esc_url($classieraYouTube); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-youtube"></i>
				</a>
				<?php } ?>
				<!--Google-->
				<?php if(!empty($classieraGoogle)){?>
				<a href="<?php echo esc_url($classieraGoogle); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-google-plus-g"></i>
				</a>
				<?php } ?>
				<!--Linkedin-->
				<?php if(!empty($classieraLinkedin)){?>
				<a href="<?php echo esc_url($classieraLinkedin); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-linkedin"></i>
				</a>
				<?php } ?>
				<!--Instagram-->
				<?php if(!empty($classieraInstagram)){?>
				<a href="<?php echo esc_url($classieraInstagram); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-instagram"></i>
				</a>
				<?php } ?>
				<!--Vimeo-->
				<?php if(!empty($classieraVimeo)){?>
				<a href="<?php echo esc_url($classieraVimeo); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-vimeo"></i>
				</a>
				<?php } ?>
				<!--VK-->
				<?php if(!empty($classieraVK)){?>
				<a href="<?php echo esc_url($classieraVK); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-vk"></i>
				</a>
				<?php } ?>
				<!--OK-->
				<?php if(!empty($classieraOK)){?>
				<a href="<?php echo esc_url($classieraOK); ?>" class="social-icon social-icon-sm offcanvas-social-icon" target="_blank">
					<i class="fab fa-odnoklassniki"></i>
				</a>
				<?php } ?>
			</div>
		</nav>
		<?php } ?>
		<!-- mobile off canvas nav -->
		<!--Primary Nav-->
		<nav class="navbar navbar-default <?php echo esc_attr($classieraNavClass); ?>">
		<?php if($classieraNavStyle == 1 || $classieraNavStyle == 3 || $classieraNavStyle == 4 || $classieraNavStyle == 5 || $classieraNavStyle == 6 || $classieraNavStyle == 7 || $classieraNavStyle == 8){?>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand-custom" href="<?php echo esc_url(home_url()); ?>">
				<?php if(empty($classieraLogo)){?>
					<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
				<?php }else{ ?>
					<img class="img-responsive" src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php } ?>
				</a>
			</div><!--navbar-header-->
		<?php }elseif($classieraNavStyle == 2){?>
			<div class="navbar-header dropdown category-menu-dropdown">
				<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<button class="btn btn-primary round btn-md btn-style-two btn-style-two-left category-menu-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<span class="icon-left"><i class="fas fa-bars"></i></span>
					<?php esc_html_e( 'categories', 'classiera' ); ?>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<?php 
						$classieraCatIconCode = "";
						$args = array(
							'hierarchical' => '0',
							'hide_empty' => '0'
						);
						$categories = get_categories($args);
						foreach($categories as $cat){
							if ($cat->category_parent == 0){
								$tag = $cat->term_id;
								$catName = $cat->term_id;
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
								}
								if(empty($classieraCatIconClr)){
									$iconColor = $primaryColor;
								}else{
									$iconColor = $classieraCatIconClr;
								}
								$category_icon = stripslashes($classieraCatIconCode);
								$categoryLink = get_category_link( $cat->term_id );
								?>
								<li>
									<a href="<?php echo esc_url($categoryLink); ?>">
										<?php if(!empty($category_icon) || !empty($classieraCatIcoIMG)){?>
											<?php 
											if($classieraIconsStyle == 'icon'){
												?>
												<i class="<?php echo esc_html($category_icon); ?>" style="color:<?php echo esc_html($iconColor); ?>;"></i>
												<?php
											}elseif($classieraIconsStyle == 'img'){
												?>
												<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
												<?php
											}
											?>
										<?php } ?>
										<?php echo esc_html(get_cat_name( $catName )); ?>
									</a>
								</li>
								<?php
							} 
						}
					?>
				</ul>
			</div>
		<?php } ?>
			<div class="collapse navbar-collapse visible-lg" id="navbarCollapse">
			<?php if($classieraNavStyle == 1){?>
				<div class="nav navbar-nav navbar-right betube-search flip">
					<?php if(!empty($classieraSubmitPost)){ ?>
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary sharp outline btn-sm">
						<i class="icon-left fas fa-plus-circle"></i>
						<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
					</a>
					<?php } ?>
				</div><!--nav navbar-nav navbar-right betube-search flip-->
			<?php }elseif($classieraNavStyle == 3){ ?>	
				<div class="nav navbar-nav navbar-right nav-v3-follow flip">
					<p>
						<?php esc_html_e( 'Follow us', 'classiera' ); ?>:
						<?php if(!empty($classieraFacebook)){?>
						<a href="<?php echo esc_url($classieraFacebook); ?>" target="_blank">
							<i class="fab fa-facebook-f"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraTwitter)){?>
                        <a href="<?php echo esc_url($classieraTwitter); ?>" target="_blank">
							<i class="fab fa-twitter"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraGoogle)){?>
                        <a href="<?php echo esc_url($classieraGoogle); ?>" target="_blank">
							<i class="fab fa-google-plus-g"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraInstagram)){?>
                        <a href="<?php echo esc_url($classieraInstagram); ?>" target="_blank">
							<i class="fab fa-instagram"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraPinterest)){?>
                        <a href="<?php echo esc_url($classieraPinterest); ?>" target="_blank">
							<i class="fab fa-pinterest-p"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraVK)){?>
                        <a href="<?php echo esc_url($classieraVK); ?>" target="_blank">
							<i class="fab fa-vk"></i>
						</a>
						<?php } ?>
						<?php if(!empty($classieraOK)){?>
                        <a href="<?php echo esc_url($classieraOK); ?>" target="_blank">
							<i class="fab fa-odnoklassniki"></i>
						</a>
						<?php } ?>
					</p>
				</div>
				<div class="nav navbar-nav navbar-right betube-search flip">
					<?php if(!empty($classieraSubmitPost)){ ?>
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary radius btn-md btn-style-three active"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
					<?php } ?>
				</div>
			<?php }elseif($classieraNavStyle == 4){ ?>
				<div class="nav navbar-nav navbar-right betube-search flip">
					<?php if(!empty($classieraSubmitPost)){ ?>
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary radius btn-md btn-style-four active"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
					<?php } ?>
				</div>
			<?php }elseif($classieraNavStyle == 5 || $classieraNavStyle == 8){ ?>
				<div class="custom-menu-v5">
					<a href="#" class="pull-left flip menu-btn">
                        <i class="fas fa-bars"></i>
                    </a>
			<?php }elseif($classieraNavStyle == 6){ ?>
				<?php if(!empty($classieraSubmitPost)){ ?>
                <a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary outline round submit-btn"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
				<?php } ?>
				<div class="navbar-right login-reg flip">
					<?php if(is_user_logged_in()){?>
                    <a href="<?php echo esc_url($classieraProfileURL); ?>" class="my-account" style="border-color: transparent !important;"><?php echo esc_attr( $classieraDisplayName ); ?> <i class="zmdi zmdi-account"></i></a>
					<?php }else{ ?>
					<a href="<?php echo esc_url($classieraLoginURL); ?>" class="my-account" style="border-color: transparent !important;"><?php esc_html_e( 'Login', 'classiera' ); ?> <i class="zmdi zmdi-account"></i></a>
					<?php } ?>
					<!-- <?php if(!empty($classieraSubmitPost)){ ?>
                    <a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary outline round"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
					<?php } ?> -->
                </div>
			<?php }elseif($classieraNavStyle == 7){ ?>
				<div class="navbar-right login-reg flip">
					<?php if(is_user_logged_in()){?>
					<a href="<?php echo esc_url($classieraProfileURL); ?>"><?php echo esc_attr( $classieraDisplayName ); ?> <i class="zmdi zmdi-account"></i></a>
					<?php }else{ ?>
					<a href="<?php echo esc_url($classieraLoginURL); ?>"><?php esc_html_e( 'Login', 'classiera' ); ?> <i class="zmdi zmdi-account"></i></a>
					<?php } ?>
					<?php if(!empty($classieraSubmitPost)){ ?>
					<a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary outline radius"><?php esc_html_e( 'Submit Ad', 'classiera' ); ?></a>
					<?php } ?>
				</div>

			<?php } ?>
				<?php 
					//Primary Menu.
					classieraPrimaryNav();
				?>
				<?php if($classieraNavStyle == 5 || $classieraNavStyle == 8){?>
					<div class="navbar-right login-reg flip">
						<?php if(is_user_logged_in()){?>
							<a href="<?php echo esc_url($classieraProfileURL); ?>" class="lr-with-icon">
								<i class="zmdi zmdi-lock"></i><?php echo esc_attr( $classieraDisplayName ); ?>
							</a>
							<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" class="lr-with-icon">
								<i class="zmdi zmdi-border-color"></i><?php esc_html_e( 'Log out', 'classiera' ); ?>
							</a>							
						<?php }else{ ?>
                        <a href="<?php echo esc_url($classieraLoginURL); ?>" class="lr-with-icon">
							<i class="zmdi zmdi-lock"></i><?php esc_html_e( 'Login', 'classiera' ); ?>
						</a>
                        <a href="<?php echo esc_url($classieraRegisterURL); ?>" class="lr-with-icon">
							<i class="zmdi zmdi-border-color"></i><?php esc_html_e( 'Get Registered', 'classiera' ); ?>
						</a>
						<?php } ?>
						<?php if(!empty($classieraSubmitPost)){ ?>
                        <a href="<?php echo esc_url($classieraSubmitPost); ?>" class="btn btn-primary btn-submit active">
							<?php esc_html_e( 'Submit Ad', 'classiera' ); ?>
						</a>
						<?php } ?>
                    </div>
				</div><!--custom-menu-v5-->
				<?php } ?>
			</div><!--collapse navbar-collapse visible-lg-->
		</nav>
		<!--Primary Nav-->
	<?php if($classieraNavStyle == 4){?>
		</div><!--col-lg-12-->
		</div><!--row-->
	<?php } ?>
	</div><!--container-->
</section>
<!-- NavBar -->