<?php 
	global $redux_demo;
	$classieraDisplayName = '';
	$templateProfile = '';
	$templateAllAds = '';
	$templateEditPost = '';
	$templateSubmitAd = '';
	$templateFollow = '';
	$templatePlans = '';
	$templateFavourite = '';
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
	$classieraAuthorIMG = get_user_meta($user_ID, "classify_author_avatar_url", true);
	$classieraAuthorIMG = classiera_get_profile_img($classieraAuthorIMG);
	if(empty($classieraAuthorIMG)){
		$classieraAuthorIMG = classiera_get_avatar_url ($classieraAuthorEmail, $size = '150' );
	}	
	$classieraOnlineCheck = classiera_user_last_online($user_ID);
	$UserRegistered = $current_user->user_registered;
	$dateFormat = get_option( 'date_format' );
	$classieraRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
	$classieraProfile = classiera_get_template_url('template-profile.php');
	$classieraAllAds = classiera_get_template_url('template-user-all-ads.php');
	$classieraEditProfile = classiera_get_template_url('template-edit-profile.php');	
	
	$classieraPostAds = classiera_get_template_url('template-submit-ads.php');
	if(empty($classieraPostAds)){
		$classieraPostAds = classiera_get_template_url('template-submit-ads-v2.php');
	}
	$classieraInbox = classiera_get_template_url('template-message.php');
	$classieraFollowerPage = classiera_get_template_url('template-follow.php');
	$classieraUserPlansPage = classiera_get_template_url('template-user-plans.php');
	$classieraUserFavourite = classiera_get_template_url('template-favorite.php');
	$classieraSavedSearch = classiera_get_template_url('template-saved-search.php');
	$classiera_bid_system = $redux_demo['classiera_bid_system'];
?>
<aside class="section-bg-white">
	<div class="author-info border-bottom">
		<div class="media">
			<div class="media-left">
				<img class="media-object" src="<?php echo esc_url( $classieraAuthorIMG ); ?>" alt="<?php echo esc_attr( $classieraDisplayName ); ?>">
			</div><!--media-left-->
			<div class="media-body">
				<h5 class="media-heading text-uppercase">
					<?php echo esc_attr( $classieraDisplayName ); ?>					
					<?php echo classiera_author_verified($user_ID); ?>
				</h5>
				<p class="member_since"><?php esc_html_e('Member Since', 'classiera') ?>&nbsp;<?php echo esc_html( $classieraRegDate ); ?></p>
				<?php if($classieraOnlineCheck == false){?>
				<span class="offline"><i class="fas fa-circle"></i><?php esc_html_e('Offline', 'classiera') ?></span>
				<?php }else{ ?>
				<span><i class="fas fa-circle"></i><?php esc_html_e('Online', 'classiera') ?></span>
				<?php } ?>
			</div><!--media-body-->
		</div><!--media-->
	</div><!--author-info-->
	<ul class="user-page-list list-unstyled">
		<?php if(!empty($classieraProfile)){ ?>
		<li class="<?php if(is_page_template( 'template-profile.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraProfile ); ?>">
				<span>
					<i class="fas fa-user"></i>
					<?php esc_html_e("About Me", 'classiera') ?>
				</span>
			</a>
		</li><!--About-->
		<?php } ?>
		<?php if(!empty($classieraAllAds)){ ?>
		<li class="<?php if(is_page_template( 'template-user-all-ads.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraAllAds ); ?>">
				<span><i class="fas fa-suitcase"></i><?php esc_html_e("My Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip"><?php echo count_user_posts($user_ID);?></span>
			</a>
		</li><!--My Ads-->
		<?php } ?>
		<?php if(!empty($classieraUserFavourite)){ ?>
		<li class="<?php if(is_page_template( 'template-favorite.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraUserFavourite ); ?>">
				<span><i class="fas fa-heart"></i><?php esc_html_e("Watch later Ads", 'classiera') ?></span>
				<span class="in-count pull-right flip">
					<?php 
						global $current_user;
						wp_get_current_user();
						$user_id = $current_user->ID;
						$myarray = classiera_authors_all_favorite($user_id);
						if(!empty($myarray)){
							$args = array(
							   'post_type' => 'post',
							   'post__in'      => $myarray
							);
						$wp_query = new WP_Query( $args );
						$current = -1;
						$current2 = 0;
						while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++; 													
						endwhile;						
						echo esc_attr( $current2 );
						wp_reset_query();
						}else{
							echo "0";
						}
					?>
				</span>
			</a>
		</li><!--Watch later Ads-->
		<?php } ?>
		<?php //if($classiera_bid_system == true){ ?>
		<li class="<?php if(is_page_template( 'template-message.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraInbox ); ?>">
				<span><i class="fas fa-envelope"></i><?php esc_html_e("Message", 'classiera') ?></span>
				<span class="in-count pull-right flip"><?php echo classiera_total_user_bids($user_ID);?></span>
			</a>
		</li><!--Message-->
		<?php //} ?>
		<?php if($classieraUserPlansPage){?>
		<!--<li class="<?php if(is_page_template( 'template-user-plans.php' )){echo "active";}?>">-->
		<!--	<a href="<?php echo esc_url( $classieraUserPlansPage ); ?>">-->
		<!--		<span><i class="fas fa-dollar-sign"></i><?php esc_html_e("Packages", 'classiera') ?></span>-->
		<!--	</a>-->
		<!--</li>-->
		<!--Packeges-->
		<?php } ?>
		<?php if(!empty($classieraFollowerPage)){ ?>
		<li class="<?php if(is_page_template( 'template-follow.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraFollowerPage ); ?>">
				<span><i class="fas fa-users"></i><?php esc_html_e("Follower", 'classiera') ?></span>
			</a>
		</li><!--follower-->
		<?php } ?>
		<?php if(!empty($classieraEditProfile)){ ?>
		<li class="<?php if(is_page_template( 'template-edit-profile.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraEditProfile ); ?>">
				<span><i class="fas fa-cog"></i><?php esc_html_e("Profile Settings", 'classiera') ?></span>
			</a>
		</li><!--Profile Setting-->
		<?php } ?>
		<?php if(!empty($classieraSavedSearch)){ ?>
		<li class="<?php if(is_page_template( 'template-saved-search.php' )){echo "active";}?>">
			<a href="<?php echo esc_url( $classieraSavedSearch ); ?>">
				<span><i class="fas fa-heart"></i><?php esc_html_e("Saved Search", 'classiera') ?></span>
			</a>
		</li>
		<?php } ?>
		<li>
			<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
				<span><i class="fas fa-sign-out-alt"></i><?php esc_html_e("Logout", 'classiera') ?></span>
			</a>
		</li><!--Logout-->
	</ul><!--user-page-list-->
	<?php if(!empty($classieraPostAds)){ ?>
	<div class="user-submit-ad">
		<a href="<?php echo esc_url( $classieraPostAds ); ?>" class="btn btn-primary sharp btn-block btn-sm btn-user-submit-ad">
			<i class="icon-left fas fa-plus-circle"></i>
			<?php esc_html_e("POST NEW AD", 'classiera') ?>
		</a>
	</div><!--user-submit-ad-->
	<?php } ?>
</aside><!--sideBarAffix-->