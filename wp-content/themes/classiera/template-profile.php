<?php
/**
 * Template name: Profile Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 
	global $redux_demo; 
	$login = classiera_get_template_url('template-login.php');
	if(empty($login)){
		$login = classiera_get_template_url('template-login-v2.php');
	}
	wp_redirect( $login ); exit;
}

global $redux_demo; 
$edit = classiera_get_template_url('template-edit-profile.php');
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = sanitize_text_field($_GET['delete_id']);
	$deletePostAuthorId = get_post_field( 'post_author', $deleteUrl);
	$current_user = wp_get_current_user();
	$current_userID = $current_user->ID;
	if($current_userID == $deletePostAuthorId){
		wp_delete_post($deleteUrl);
	}
}
if(isset($_POST['unfavorite'])){
	$author_id = sanitize_text_field($_POST['author_id']);
	$post_id = sanitize_text_field($_POST['post_id']);
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
if(isset($_GET['sold_id'])){
	$sold_post_id = sanitize_text_field($_GET['sold_id']);
	echo classiera_post_mark_as_sold($sold_post_id);
}
if(isset($_GET['un_sold_id'])){
	$un_sold_id = sanitize_text_field($_GET['un_sold_id']);
	echo classiera_post_mark_as_unsold($un_sold_id);
}
if(isset($_GET['restore_id'])){
	$restore_id = sanitize_text_field($_GET['restore_id']);
	global $post;
	$time = current_time('mysql');
	$args = array(
		'ID' => $restore_id,
		'post_date' => $time,
		'post_date_gmt' => get_gmt_from_date( $time ),
		'post_status' => 'publish',
	);
	wp_update_post($args);
}
	global $current_user, $user_id;
	$current_user = wp_get_current_user();
	$user_info = get_userdata($user_ID);
	$user_id = $current_user->ID; 
	get_header(); 
?>
<?php 
	global $redux_demo; 
	$all_adds = classiera_get_template_url('template-user-all-ads.php');
	$classiera_cart_url = classiera_cart_url();
	$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
	$bumpProductID = $redux_demo['classiera_bump_ad_woo_id'];
	$dateFormat = get_option( 'date_format' );
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$iconClass = 'icon-left';
	if(is_rtl()){
		$iconClass = 'icon-right';
	}
?>
<!-- user pages -->
<section class="user-pages section-gray-bg">
	<div class="container">
        <div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- about me -->
					<div class="about-me">
						<h4 class="user-detail-section-heading text-uppercase"><?php esc_html_e("About Me", 'classiera') ?></h4>
						<p>
							<?php 
							$user_id = $current_user->ID; 
							$author_desc = get_the_author_meta('description', $user_id);  
							echo esc_html( $author_desc );
							?>
						</p>
					</div>
					<!-- about me -->
					<!-- contact details -->
					<div class="user-contact-details">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Contact Details", 'classiera') ?>
						</h4>
						<ul class="list-unstyled">
							<?php 
							$classiera_gdpr = get_the_author_meta('classiera_gdpr', $user_id);
							$userPhone = get_the_author_meta('phone', $user_id);
							$userPhone2 = get_the_author_meta('phone2', $user_id);
							$userEmail = get_the_author_meta('user_email', $user_id);
							$userwebsite = get_the_author_meta('user_url', $user_id);
							?>
							<?php if(!empty($userPhone)){?>
								<li>
									<i class="fas fa-phone-square"></i>
									<?php echo esc_html( $userPhone ); ?>
								</li>
							<?php } ?>
							<?php if(!empty($userPhone2)){?>
								<li>
									<i class="fas fa-mobile-alt"></i>								
									<?php echo esc_html( $userPhone2 ); ?>
								</li>
							<?php } ?>
							<?php if(!empty($userwebsite)){?>
								<li>
									<i class="fas fa-globe"></i>
									<a href="<?php echo esc_url( $userwebsite ); ?>">
										<?php echo esc_url( $userwebsite ); ?>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($userEmail)){?>
								<li>
									<i class="fas fa-envelope"></i>
									<a href="mailto:<?php echo sanitize_email( $userEmail ); ?>"><?php echo sanitize_email( $userEmail ); ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<!-- contact details -->
					<!-- social profile -->
					<div class="user-social-profile-links hidden">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("Social profile Links", 'classiera') ?>
						</h4>
						<ul class="list-unstyled list-inline">
							<?php 
							$userFB = $user_info->facebook;
							$userTW = $user_info->twitter;
							$userGoogle = $user_info->googleplus;
							$userPin = $user_info->pinterest;
							$userLin = $user_info->linkedin;
							$userInsta = $user_info->instagram;
							$userVimeo = $user_info->vimeo;
							$userYouTube = $user_info->youtube;
							
							$digg = $user_info->digg;
							$behance = $user_info->behance;
							$dribbble = $user_info->dribbble;
							$flickr = $user_info->flickr;
							$github = $user_info->github;
							$lastfm = $user_info->lastfm;
							$soundcloud = $user_info->soundcloud;
							$vk = $user_info->vk;
							?>
							<?php if(!empty($userFB)){?>
								<li>
									<a href="<?php echo esc_url( $userFB ); ?>">
										<i class="fab fa-facebook-f"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($userTW)){?>
								<li>
									<a href="<?php echo esc_url( $userTW ); ?>">
										<i class="fab fa-twitter"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userGoogle)){?>	
								<li>
									<a href="<?php echo esc_url( $userGoogle ); ?>">
										<i class="fab fa-google-plus-g"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userInsta)){?>	
								<li>
									<a href="<?php echo esc_url( $userInsta ); ?>">
										<i class="fab fa-instagram"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userPin)){?>	
								<li>
									<a href="<?php echo esc_url( $userPin ); ?>">
										<i class="fab fa-pinterest-p"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userLin)){?>	
								<li>
									<a href="<?php echo esc_url( $userLin ); ?>">
										<i class="fab fa-linkedin"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userVimeo)){?>	
								<li>
									<a href="<?php echo esc_url( $userVimeo ); ?>">
										<i class="fab fa-vimeo"></i>
									</a>
								</li>
							<?php } ?>	
							<?php if(!empty($userYouTube)){ ?>	
								<li>
									<a href="<?php echo esc_url( $userYouTube ); ?>">
										<i class="fab fa-youtube"></i>
									</a>
								</li>
							<?php } ?>

							<?php if(!empty($digg)){ ?>	
								<li>
									<a href="<?php echo esc_url( $digg ); ?>">
										<i class="fab fa-digg"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($behance)){ ?>	
								<li>
									<a href="<?php echo esc_url( $behance ); ?>">
										<i class="fab fa-behance"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($flickr)){ ?>	
								<li>
									<a href="<?php echo esc_url( $flickr ); ?>">
										<i class="fab fa-flickr"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($github)){ ?>	
								<li>
									<a href="<?php echo esc_url( $github ); ?>">
										<i class="fab fa-github"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($lastfm)){ ?>	
								<li>
									<a href="<?php echo esc_url( $lastfm ); ?>">
										<i class="fab fa-lastfm"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($soundcloud)){ ?>	
								<li>
									<a href="<?php echo esc_url( $soundcloud ); ?>">
										<i class="fab fa-soundcloud"></i>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($vk)){ ?>	
								<li>
									<a href="<?php echo esc_url( $vk ); ?>">
										<i class="fab fa-vk"></i>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<!-- social profile -->
					<!-- my ads -->
					<div class="user-ads user-my-ads">
						<h4 class="user-detail-section-heading text-uppercase">
							<?php esc_html_e("My Ads", 'classiera') ?>
						</h4>
						<?php 
							global $wp_query, $wp;
							$wp_query = new WP_Query();
							$kulPost = array(
								'post_type'  => 'post',
								'author' => $user_id,
								'posts_per_page' => 10,	
								'post_status' => array( 'publish', 'pending', 'future', 'draft', 'private', 'expired'),
							);
							$wp_query = new WP_Query($kulPost);
						while ($wp_query->have_posts()) : $wp_query->the_post();
						$title = get_the_title($post->ID);						
						$classieraPstatus = get_post_status( $post->ID );						
						$postDate = get_the_date($dateFormat, $post->ID);
						$postStatus = get_post_status($post->ID);
						$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
						$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
						$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
						?>
						<div class="media border-bottom">
							<div class="media-left">
								<?php 
								if ( has_post_thumbnail()){								
								$imgURL = get_the_post_thumbnail_url();
								?>
                                <img class="media-object" src="<?php echo esc_url( $imgURL ); ?>" alt="<?php echo esc_attr( $title ); ?>">
								<?php } ?>
                            </div><!--media-left-->
							<div class="media-body">
								<h5 class="media-heading">
									<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
										<?php echo esc_attr( $title ); ?>
									</a>
								</h5>
								<p>
                                    <span class="published">
                                        <i class="fas fa-check-circle"></i>
                                        <?php classieraPStatusTrns($classieraPstatus); ?>
                                    </span>
                                    <span class="classiera_views">
                                        <i class="far fa-eye"></i>
                                        <?php echo classiera_get_post_views($post->ID); ?>
                                    </span>
                                    <span class="classiera_pdate">
                                        <i class="far fa-clock"></i>                                       
										<?php echo esc_html( $postDate ); ?>
                                    </span>	
									<span>
										<i class="removeMargin fa fa-hashtag"></i>
										<?php esc_html_e( 'ID', 'classiera' ); ?> : 
										<?php echo esc_attr($post->ID); ?>
                                    </span>
                                </p>
							</div><!--media-body-->
							<div class="classiera_posts_btns">
								<!--PayPerPostbtn-->
								<?php if(!empty($productID) && $postStatus == 'pending'){?>
								<div class="classiera_main_cart">
									<a href="#" class="btn btn-success btn-sm sharp btn-style-one classiera_ppp_btn" data-quantity="1" data-product_id="<?php echo esc_attr($productID); ?>" data-product_sku="">
										<?php esc_html_e( 'Pay to Publish', 'classiera' ); ?>
									</a>
									<form method="post" class="classiera_ppp_ajax">				
										<input type="hidden" class="product_id" name="product_id" value="<?php echo esc_attr($productID); ?>">
										<input type="hidden" class="post_id" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
										<input type="hidden" class="post_title" name="post_title" value="<?php echo esc_html(the_title()); ?>">
										<input type="hidden" class="days_to_expire" name="days_to_expire" value="<?php echo esc_attr($days_to_expire); ?>">
										<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
									</form>
									<a class="btn btn-success btn-sm classiera_ppp_cart" href="<?php echo esc_url($classiera_cart_url); ?>">
										<?php esc_html_e( 'View Cart', 'classiera' ); ?>
									</a>
								</div>
								<?php } ?>
								<!--PayPerPostbtn-->
								<!--BumpAds-->
								<?php if(!empty($bumpProductID) && $postStatus == 'publish'){?>
								<div class="classiera_bump_ad d-inline-block">
									<a href="#" class="btn btn-success btn-sm sharp btn-style-one classiera_bump_btn" data-quantity="1" data-product_id="<?php echo esc_attr($bumpProductID); ?>" data-product_sku="">
										<i class="fas fa-sort-amount-up"></i>
										<?php esc_html_e( 'Bump Ad', 'classiera' ); ?>
									</a>
									<form class="classiera_bump_ad_form">
										<input type="hidden" class="product_id" name="product_id" value="<?php echo esc_attr($bumpProductID); ?>">
										<input type="hidden" class="post_id" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
										<input type="hidden" class="post_title" name="post_title" value="<?php echo esc_html(the_title()); ?>">
										<input type="hidden" name="classiera_nonce" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
									</form>
									<a class="btn btn-success btn-sm btn-style-one classiera_bump_cart" href="<?php echo esc_url($classiera_cart_url); ?>">
										<?php esc_html_e( 'View Cart', 'classiera' ); ?>
									</a>
								</div>
								<?php } ?>
								<!--BumpAds-->
								<?php 
									global $redux_demo;
									$edit_post_page_id = classiera_get_template_url('template-edit-ads.php');
									$postID = $post->ID;
									global $wp_rewrite;
									if ($wp_rewrite->permalink_structure == ''){
										//we are using ?page_id
										$edit_post = $edit_post_page_id."&post=".$post->ID;
										$del_post = $pagepermalink."&delete_id=".$post->ID;
										$soldpost = $pagepermalink."&sold_id=".$post->ID;
										$unsold = $pagepermalink."&un_sold_id=".$post->ID;
										$restore = $pagepermalink."&restore_id=".$post->ID;
									}else{
										//we are using permalinks
										$edit_post = $edit_post_page_id."?post=".$post->ID;
										$del_post = $pagepermalink."?delete_id=".$post->ID;
										$soldpost = $pagepermalink."?sold_id=".$post->ID;
										$unsold = $pagepermalink."?un_sold_id=".$post->ID;
										$restore = $pagepermalink."?restore_id=".$post->ID;
									}
								if($postStatus != 'expired'){ 	
								?>
								<a href="<?php echo esc_url($edit_post); ?>" class="btn btn-primary sharp btn-style-one btn-sm">
									<i class="<?php echo esc_attr($iconClass); ?> far fa-edit"></i>
									<?php esc_html_e("Edit", 'classiera') ?>
								</a>
								<?php } ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=examplePopup<?php echo esc_attr($post->ID); ?>">
									<i class="<?php echo esc_attr($iconClass); ?> fas fa-trash-alt"></i>
									<?php esc_html_e("Delete", 'classiera') ?>
								</a>
								<div class="delete-popup" id="examplePopup<?php echo esc_attr($post->ID); ?>" style="display:none">
									<h4>
										<?php esc_html_e("Are you sure you want to delete this ad?", 'classiera') ?>
									</h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($del_post); ?>">
										<span class="button-inner">
											<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
									</a>
								</div>
								<!--Mark As Sold-->
								<?php if($postStatus != 'expired'){ ?>
								<?php if($classiera_ads_type == 'sold'){ ?>
									<!--unsold-->
									<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=unsoldPop<?php echo esc_attr($post->ID); ?>">
										<i class="<?php echo esc_attr($iconClass); ?> fas fa-check-square"></i>
										<?php esc_html_e("Unsell", 'classiera') ?>
									</a>
									<div class="delete-popup" id="unsoldPop<?php echo esc_attr($post->ID); ?>" style="display:none">
										<h4>
											<?php esc_html_e("Are you sure you want to mark this ad as un-sold?", 'classiera') ?>
										</h4>
										<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($unsold); ?>">
											<span class="button-inner">
												<?php esc_html_e("Confirm", 'classiera') ?>
											</span>
										</a>
									</div>
									<!--unsold-->
								<?php }else{ ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=soldPop<?php echo esc_attr($post->ID); ?>">
									<i class="<?php echo esc_attr($iconClass); ?> far fa-check-square"></i>
									<?php esc_html_e("Mark as sold", 'classiera') ?>
								</a>
								<div class="delete-popup" id="soldPop<?php echo esc_attr($post->ID); ?>" style="display:none">
									<h4>
										<?php esc_html_e("Are you sure you want to mark this ad as sold?", 'classiera') ?>
									</h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($soldpost); ?>">
										<span class="button-inner">
											<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
									</a>
								</div>
								<?php } ?>
								<?php } ?>
								<!--Mark As Sold-->
								<!--Restore Button for Expired Ads-->
								<?php if($postStatus == 'expired'){ ?>
								<a class="thickbox btn btn-primary sharp btn-style-one btn-sm" href="#TB_inline?height=150&amp;width=400&amp;inlineId=restore<?php echo esc_attr($post->ID); ?>">
									<i class="fas fa-redo far fa-check-square"></i>
									<?php esc_html_e("Restore", 'classiera') ?>
								</a>
								<div class="delete-popup" id="restore<?php echo esc_attr($post->ID); ?>" style="display:none">
									<h4>
										<?php esc_html_e("Are you sure you want to publish this ad again?", 'classiera') ?>
									</h4>
									<a class="btn btn-primary sharp btn-style-one btn-sm" href="<?php echo esc_url($restore); ?>">
										<span class="button-inner">
											<?php esc_html_e("Confirm", 'classiera') ?>
										</span>
									</a>
								</div>
								<?php } ?>
								<!--Restore Button for Expired Ads-->
							</div><!--classiera_posts_btns-->
							
						</div><!--media border-bottom-->
						<?php endwhile;	?>
						<?php wp_reset_query(); ?>
						<div class="user-view-all text-center">
                            <a href="<?php echo esc_url($all_adds); ?>" class="btn btn-primary btn-md btn-style-one sharp">
								<?php esc_html_e("View All", 'classiera') ?>
							</a>
                        </div>
					</div>
					<!-- my ads -->
					<!-- favorite ads -->
					<div class="user-ads favorite-ads">
						<h4 class="user-detail-section-heading text-uppercase">
						<?php esc_html_e("Favorite Ads", 'classiera') ?>
						</h4>
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$cat_id = get_cat_ID(single_cat_title('', false));
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							global $current_user;
							wp_get_current_user();
							$user_id = $current_user->ID;
							$myarray = classiera_authors_all_favorite($user_id);
							if(!empty($myarray)){
								$args = array(
								   'post_type' => 'post',
								   'posts_per_page' => 10,
								   'post__in' => $myarray,
								);
								// The Query
							$wp_query = new WP_Query( $args );
							while ($wp_query->have_posts()) : $wp_query->the_post();
							$postDate = get_the_date($dateFormat, $post->ID);
							$title = get_the_title($post->ID);
							$post_price = get_post_meta($post->ID, 'post_price', true);
							$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
						?>
						<div class="media border-bottom">
							<div class="media-left">
								<?php 
								if ( has_post_thumbnail()){								
								$imgURL = get_the_post_thumbnail_url();
								?>
                                <img class="media-object" src="<?php echo esc_url($imgURL); ?>" alt="<?php echo esc_html($title); ?>">
								<?php } ?>
                            </div><!--media-left-->
							<div class="media-body">
								<h5 class="media-heading">
									<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
										<?php echo esc_html($title); ?>
									</a>
								</h5>
								<p>
									<?php $post_user_ID = $post->post_author; ?>
                                    <span>
                                        <i class="fas fa-user"></i>
                                        <?php echo get_the_author_meta('display_name', $post_user_ID ); ?>
                                    </span>                                    
                                    <span class="classiera_pdate">
                                        <i class="fas fa-clock"></i>
										<?php echo esc_html($postDate); ?>
                                    </span>
                                </p>
							</div><!--media-body-->
							<div class="media-right">
								<?php  ?>
                                <h4>
									<?php 
									if(is_numeric($post_price)){
										echo classiera_post_price_display($post_currency_tag, $post_price);
									}else{ 
										echo esc_html($post_price);
									}
									?>
								</h4>
                                <?php echo classiera_authors_favorite_remove($user_id, $post->ID);?>
							</div><!--media-right-->
						</div><!--media border-bottom-->
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
						<?php }else{ ?>
							<p><?php esc_html_e("You do not have any favorite ads yet!", 'classiera') ?></p>
						<?php } ?>
					</div>
					<!-- favorite ads -->
				</div>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<!-- user pages -->
<?php get_footer(); ?>