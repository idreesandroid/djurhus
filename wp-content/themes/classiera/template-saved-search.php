<?php
/**
 * Template name: Saved Search
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
get_header(); 
if(isset($_POST['unfavorite'])){
	$author_id = sanitize_text_field($_POST['author_id']);
	$post_id = sanitize_text_field($_POST['post_id']);
	echo classiera_authors_unfavorite($author_id, $post_id);	
}

$get_save_search = $wpdb->get_results("Select * from saved_search");

//print_r($get_save_search);
if(!empty($get_save_search)){
    foreach($get_save_search as $key=>$row){
        
        
        $get_usrs = $wpdb->get_results("Select * from wp_users where ID=$row->user_id");
        // WP_User_Query arguments
        // print_r($row->saved_query);
        // $get_posts = $wpdb->get_results("SELECT wp_posts.*, wp_postmeta.post_id FROM wp_posts INNER JOIN wp_postmeta ON wp_posts.ID=wp_postmeta.post_id WHERE wp_posts.post_date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        // // $row_requets = $get_posts->rowCount()
        // $get_postsss = $wpdb->get_results("SELECT COUNT(*) FROM wp_posts WHERE post_date >= NOW() - INTERVAL 1 DAY");
        // print_r($get_posts);
        // print_r($get_postsss);
    }
    
}

global $current_user, $user_id;
global $redux_demo;
wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.
$edit = classiera_get_template_url('template-edit-profile.php');
$pagepermalink = get_permalink($post->ID);
$profile = classiera_get_template_url('template-profile.php');
$all_adds = classiera_get_template_url('template-user-all-ads.php');
$allFavourite = classiera_get_template_url('template-favorite.php');
$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
$classieraAdsView = $redux_demo['home-ads-view'];
$newPostAds = classiera_get_template_url('template-submit-ads.php');
if(empty($newPostAds)){
	$newPostAds = classiera_get_template_url('template-submit-ads-v2.php');
}
$dateFormat = get_option( 'date_format' );
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";
$page = get_page($post->ID);
$current_page_id = $page->ID;	
$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true); ?>

<?php 
    $current_user = wp_get_current_user();
	$userID = $current_user->ID;
	
	if(isset($_POST['email_monitor'])){
	   
		$email_monitor = $_POST['email_monitor'];
		
        $results = $wpdb->get_results( "SELECT * FROM email_notification where user_id=$userID"); 
    	if(empty($results))                        
    	{
		$wpdb->insert('email_notification', array(
				'user_id' => $userID,
		    'email_monitor' => $email_monitor,
		)); 
    	}else{
    	 
        $wpdb->update('email_notification', array('email_monitor'=>$email_monitor), array('user_id' => $userID));
    	}
	}
	
	$results = $wpdb->get_results( "SELECT * FROM email_notification where user_id=$userID"); 
	if(!empty($results))                        
	{
		$query_user_id = $results[0]->email_monitor;
		$email_monitor = $results[0]->email_monitor;
	}
?>
<section class="user-pages section-gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
			 <?php 
				global $paged, $wp_query, $wp;
				
				global $current_user;
				wp_get_current_user();
				$user_id = $current_user->ID;
				$get_save_search = $wpdb->get_results("Select * from saved_search where user_id=$user_id ORDER BY id DESC");
				 					
				if(!empty($get_save_search)){
			   								
			?>
			
			
			<ul class="nav nav-tabs tabs-left nav-tabs-dropdown profile-tabs" role="tablist">
			<?php 
			foreach($get_save_search as $key=>$row){
			    global $wp_query, $wp;

				

				$wp_query = new WP_Query();
				$kulPost = array(
					'post_type'  => 'post',
					'category_name' => $row->category_name,
					's' => $row->saved_query,
					'posts_per_page' => -1,	
					'meta_query' => array(
						array(
							'key' => 'post_state',
							'value' => $row->saved_state,
							'compare' => '=',
						)
					),
					
					
				);
				$wp_query = new WP_Query($kulPost);
				$count = $wp_query->found_posts;
				
			?>
    			<li class="<?php if($key == 0){ echo "active"; } ?>" role="presentation"><a href="#<?php echo $row->id ?>"  aria-controls="<?php echo $row->id ?>" role="tab" data-toggle="tab"> <strong>&quot;<?php echo $row->saved_query; ?>&quot;</strong><span style="text-transform: capitalize;"><?php if($row->category_name != ''){ echo ","; echo ' '.$row->category_name; } ?></span> in <?php echo $row->saved_state; ?> <br> <?= $count; ?> ads</a></li>
			<?php } ?>
    		</ul>
    		<div class="switch-section" style="margin-top: 15px;">
			    <a>Monitor by email <br> Get a summary of your saved data via email once a day.</a>
			    <form action="" method="post" id="target">
    			    <label class="switch">
                      <input id="togBtn" name="email_monitor_checkbox" type="checkbox" <?php if($email_monitor == 1){ echo "checked"; } ?>>
                      
                      <span class="slider round"></span>
                    </label>
                    <input type="hidden" name="email_monitor" id="email_monitor" >
                    
                </form>
			</div>
			<?php }else{ ?>
					<p><?php esc_html_e("You do not have any Saved Search yet!", 'classiera') ?></p>
				<?php }?>
			
			<?php //get_template_part( 'templates/profile/userabout' );?>
			</div><!--col-lg-3-->
			<div class="col-lg-9 col-md-8 user-content-height section-bg-white" style="min-height:auto;">
				<div class="user-detail-section section-bg-white classiera-advertisement">
					<!-- favorite ads -->
					<div class="user-ads favorite-ads">
						<div class="tab-content profile-tabs-content">
					   
							<!-- Profile Tab -->
							 <?php 
								global $paged, $wp_query, $wp;
								
								global $current_user;
								wp_get_current_user();
								$user_id = $current_user->ID;
								$get_save_search = $wpdb->get_results("Select * from saved_search where user_id=$user_id");
											
								if(!empty($get_save_search)){

							   foreach($get_save_search as $key=>$row){		
							   $catSearchID = $row->category_name;	
							   $keyword = $row->saved_query;
							   $states = $row->saved_state;					
							?>
							<div role="tabpanel" class="tab-pane fade <?php if($key == 0){ echo "in active";} ?>" id="<?= $row->id; ?>">
							     <div class="filter_section saved_search_filter">
								<div class="conatiner">	
									<div class="row">	
										<div class="col-xs-4 col-sm-6 col-lg-5">
											<a href="javascript:void(0)" class="remove_save_search" data-id="<?= $row->id; ?>"><i class="far fa-trash-alt"></i> Remove</a>
										</div>	
										<div class="col-xs-8 col-sm-6 col-lg-3">
											<div class="sort_section text-right">
												<label><strong><?php esc_html_e( 'Sort By', 'classiera' ); ?> : </strong></label>
												<select id="sort_by<?= $row->id; ?>" class="filter_save" data-id="<?= $row->id; ?>">
													<option value="latest">Latest</option>
													<option value="oldest">Oldest</option>
													<option value="cheapest">Cheapest</option>
													<option value="expensive">Most Expensive</option>
													<option value="lowered">Lowered Price</option>
												</select>
											</div>
										</div>
										<div class="col-lg-4 col-sm-6 col-xs-5">
											<div class="view-as text-right flip">
												<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
												<a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#">
													<i class="fas fa-th"></i>
												</a>
												<a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#">
													<i class="fas fa-bars"></i>
												</a>
											</div><!--view-as text-right flip-->
										</div><!--col-lg-6 col-sm-6 col-xs-6-->
									</div>
								</div>	
							</div>
						<!-- Filter Section End -->
								<!-- All Ads -->
								<div id="all_ads<?= $row->id; ?>">
									<?php 
										global $wp_query, $wp;

										

										$wp_query = new WP_Query();
										$kulPost = array(
											'post_type'  => 'post',
											'category_name' => $row->category_name,
											's' => $row->saved_query,
											'posts_per_page' => -1,	
											'orderby' => 'ID',
											'order' => 'DESC',
											'meta_query' => array(
												array(
													'key' => 'post_state',
													'value' => $row->saved_state,
													'compare' => '=',
												)
											),
											
										);
										$wp_query = new WP_Query($kulPost);
										// print_r($wp_query);die();
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID);						
									$classieraPstatus = get_post_status( $post->ID );						
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									$theDate = get_the_date();
									$theTime = get_the_time();
									$theTitle = get_the_title();
									$post_location = get_post_meta($post->ID, 'post_location', true);
									$post_state = get_post_meta($post->ID, 'post_state', true);
									$post_city = get_post_meta($post->ID, 'post_city', true);
									$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item item-list">
										<div class="classiera-box-div classiera-box-div-v1">
											<figure class="clearfix">
												<div class="premium-img">
												<?php 
												$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
												if($classieraFeaturedPost == 1){
													?>
													<div class="featured-tag">
														<span class="left-corner"></span>
														<span class="right-corner"></span>
														<div class="featured">
															<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
														</div>
													</div>
													<?php
												}
												if( has_post_thumbnail()){
													$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
													$thumb_id = get_post_thumbnail_id($post->ID);
													?>
													<img class="img-responsive" src="<?php echo esc_url( $imageurl[0] ); ?>" alt="<?php echo esc_html( $theTitle ); ?>">
													<?php
												}else{
													?>
													<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
													<?php
												}
												?>
													<span class="hover-posts">
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
												<!-- <?php if(!empty($post_price)){?>
												<span class="classiera-price-tag" style="background-color:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>;">
													<span class="price-text">
														<?php 
														if(is_numeric($post_price)){
															echo classiera_post_price_display($post_currency_tag, $post_price);
														}else{ 						 
															echo esc_attr( $post_price ); 
														}
														?>
													</span>
												</span>
												<?php } ?> -->
												<?php 
												$origin = new DateTime();
												$target = new DateTime($theDate);
												$interval = $origin->diff($target);
												$date_diff = $interval->format('%R%a');
												$short_date = date("F d", strtotime($theDate));
												?>
												<span class="classiera-time">
													<?php 
														if($date_diff == 0){
															echo "Today "; echo $theTime;
														}elseif($date_diff == -1){
															echo "Yesterday "; echo $theTime;
														}else{
															echo $short_date.' ';
															echo $theTime;
														}
													?>	
												</span>
												<figcaption>
													<h5>
														<a href="<?php echo esc_url(the_permalink()); ?>">
															<?php echo esc_html( $theTitle ); ?>
														</a>
													</h5>
													<p>
														<!-- <?php esc_html_e( 'Category', 'classiera' ); ?> :  -->
														<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
															<?php echo classiera_get_category($post->ID); ?>,
														</a> 
														<!-- <span><?php esc_html_e( 'Location', 'classiera' ); ?></span> :  -->
														<span><?php echo $post_state; ?></span> 
													</p>
													<p class="location">
														<!-- <?php esc_html_e( 'Location', 'classiera' ); ?> : 
														<a href="<?php echo esc_url( classiera_get_category_link($post_city)); ?>">
															<?php echo $post_city; ?>
														</a> -->
													</p><br class="location">
													<!-- <p>
														<span class="classiera-time"><?php echo $theDate; ?> <?php echo $theTime; ?></span>
													</p> -->
													<!-- <?php if(!empty($category_icon_code) || !empty($classieraCatIcoIMG)){?>
													<span class="category-icon-box" style=" background:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>; ">
														<?php 
														if($classieraIconsStyle == 'icon'){
															?>
															<i class="<?php echo esc_attr( $category_icon_code ); ?>"></i>
															<?php
														}elseif($classieraIconsStyle == 'img'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_attr( $postCatgory[0]->name ); ?>">
															<?php
														}
														?>
													</span>
													<?php } ?> -->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_price)){
																echo classiera_post_price_display($post_currency_tag, $post_price);
															}else{ 						 
																echo esc_attr( $post_price ); 
															}
															?>
														</span>
													</span>
													<?php }else{ ?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_old_price)){
																echo classiera_post_price_display($post_currency_tag, $post_old_price);
															}else{ 						 
																echo esc_attr( $post_old_price ); 
															}
															?>
														</span>
													</span>
													<?php } ?>
													<!-- <p class="description">
														<?php echo substr(get_the_excerpt(), 0,260); ?> 
													</p> -->
													<!-- <div class="post-tags">
														<span><i class="fas fa-tags"></i>
														<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
														</span>
														<?php the_tags('','',''); ?>
													</div> -->
													<!--post-tags-->
												</figcaption>
											</figure>
										</div><!--classiera-box-div-->
									</div><!--col-lg-4-->
									<?php endwhile;	?>
								</div>
								<!-- End All Ads -->
								<!-- Lowered Price -->
								<div id="lowered_price<?= $row->id; ?>" style="display: none;">
									<?php 
										global $wp_query, $wp;

										
										$wp_query = new WP_Query();
										$kulPost = array(
											'post_type'  => 'post',
											'category_name' => $row->category_name,
											's' => $row->saved_query,
											'posts_per_page' => -1,	
											'meta_query' => array(
												array(
													'key' => 'post_state',
													'value' => $row->saved_state,
													'compare' => '=',
												),
												array(
													'key' => 'post_price',
													'value' => '',
													'compare' => '!='
												),
											),
											
										);
										$wp_query = new WP_Query($kulPost);
										// print_r($wp_query);die();
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID);						
									$classieraPstatus = get_post_status( $post->ID );						
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									$theDate = get_the_date();
									$theTime = get_the_time();
									$theTitle = get_the_title();
									$post_location = get_post_meta($post->ID, 'post_location', true);
									$post_state = get_post_meta($post->ID, 'post_state', true);
									$post_city = get_post_meta($post->ID, 'post_city', true);
									$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item item-list">
										<div class="classiera-box-div classiera-box-div-v1">
											<figure class="clearfix">
												<div class="premium-img">
												<?php 
												$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
												if($classieraFeaturedPost == 1){
													?>
													<div class="featured-tag">
														<span class="left-corner"></span>
														<span class="right-corner"></span>
														<div class="featured">
															<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
														</div>
													</div>
													<?php
												}
												if( has_post_thumbnail()){
													$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
													$thumb_id = get_post_thumbnail_id($post->ID);
													?>
													<img class="img-responsive" src="<?php echo esc_url( $imageurl[0] ); ?>" alt="<?php echo esc_html( $theTitle ); ?>">
													<?php
												}else{
													?>
													<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
													<?php
												}
												?>
													<span class="hover-posts">
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
												<!-- <?php if(!empty($post_price)){?>
												<span class="classiera-price-tag" style="background-color:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>;">
													<span class="price-text">
														<?php 
														if(is_numeric($post_price)){
															echo classiera_post_price_display($post_currency_tag, $post_price);
														}else{ 						 
															echo esc_attr( $post_price ); 
														}
														?>
													</span>
												</span>
												<?php } ?> -->
												<?php 
												$origin = new DateTime();
												$target = new DateTime($theDate);
												$interval = $origin->diff($target);
												$date_diff = $interval->format('%R%a');
												$short_date = date("F d", strtotime($theDate));
												?>
												<span class="classiera-time">
													<?php 
														if($date_diff == 0){
															echo "Today "; echo $theTime;
														}elseif($date_diff == -1){
															echo "Yesterday "; echo $theTime;
														}else{
															echo $short_date.' ';
															echo $theTime;
														}
													?>	
												</span>
												<figcaption>
													<h5>
														<a href="<?php echo esc_url(the_permalink()); ?>">
															<?php echo esc_html( $theTitle ); ?>
														</a>
													</h5>
													<p>
														<!-- <?php esc_html_e( 'Category', 'classiera' ); ?> :  -->
														<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
															<?php echo classiera_get_category($post->ID); ?>,
														</a> 
														<!-- <span><?php esc_html_e( 'Location', 'classiera' ); ?></span> :  -->
														<span><?php echo $post_state; ?></span> 
													</p>
													<p class="location">
														<!-- <?php esc_html_e( 'Location', 'classiera' ); ?> : 
														<a href="<?php echo esc_url( classiera_get_category_link($post_city)); ?>">
															<?php echo $post_city; ?>
														</a> -->
													</p><br class="location">
													<!-- <p>
														<span class="classiera-time"><?php echo $theDate; ?> <?php echo $theTime; ?></span>
													</p> -->
													<!-- <?php if(!empty($category_icon_code) || !empty($classieraCatIcoIMG)){?>
													<span class="category-icon-box" style=" background:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>; ">
														<?php 
														if($classieraIconsStyle == 'icon'){
															?>
															<i class="<?php echo esc_attr( $category_icon_code ); ?>"></i>
															<?php
														}elseif($classieraIconsStyle == 'img'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_attr( $postCatgory[0]->name ); ?>">
															<?php
														}
														?>
													</span>
													<?php } ?> -->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_price)){
																echo classiera_post_price_display($post_currency_tag, $post_price);
															}else{ 						 
																echo esc_attr( $post_price ); 
															}
															?>
														</span>
														<div class="price_arrow"></div>
													</span>
													<?php } ?>
													<!--
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_old_price)){
																echo classiera_post_price_display($post_currency_tag, $post_old_price);
															}else{ 						 
																echo esc_attr( $post_old_price ); 
															}
															?>
														</span>
													</span> -->
													<!-- <p class="description">
														<?php echo substr(get_the_excerpt(), 0,260); ?> 
													</p> -->
													<!-- <div class="post-tags">
														<span><i class="fas fa-tags"></i>
														<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
														</span>
														<?php the_tags('','',''); ?>
													</div> -->
													<!--post-tags-->
												</figcaption>
											</figure>
										</div><!--classiera-box-div-->
									</div><!--col-lg-4-->
									<?php endwhile;	?>
								</div>
								<!-- End Lowere Price -->
								<!-- Oldest -->
								<div id="oldest_ads<?= $row->id; ?>" style="display: none;">
									<?php 
										global $wp_query, $wp;

										

										$wp_query = new WP_Query();
										$kulPost = array(
											'post_type'  => 'post',
											'category_name' => $row->category_name,
											's' => $row->saved_query,
											'posts_per_page' => -1,	
											'orderby' => 'ID',
											'order' => 'ASC',
											'meta_query' => array(
												array(
													'key' => 'post_state',
													'value' => $row->saved_state,
													'compare' => '=',
												)
											),
											
										);
										$wp_query = new WP_Query($kulPost);
										// print_r($wp_query);die();
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID);						
									$classieraPstatus = get_post_status( $post->ID );						
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									$theDate = get_the_date();
									$theTime = get_the_time();
									$theTitle = get_the_title();
									$post_location = get_post_meta($post->ID, 'post_location', true);
									$post_state = get_post_meta($post->ID, 'post_state', true);
									$post_city = get_post_meta($post->ID, 'post_city', true);
									$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item item-list">
										<div class="classiera-box-div classiera-box-div-v1">
											<figure class="clearfix">
												<div class="premium-img">
												<?php 
												$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
												if($classieraFeaturedPost == 1){
													?>
													<div class="featured-tag">
														<span class="left-corner"></span>
														<span class="right-corner"></span>
														<div class="featured">
															<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
														</div>
													</div>
													<?php
												}
												if( has_post_thumbnail()){
													$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
													$thumb_id = get_post_thumbnail_id($post->ID);
													?>
													<img class="img-responsive" src="<?php echo esc_url( $imageurl[0] ); ?>" alt="<?php echo esc_html( $theTitle ); ?>">
													<?php
												}else{
													?>
													<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
													<?php
												}
												?>
													<span class="hover-posts">
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
												<!-- <?php if(!empty($post_price)){?>
												<span class="classiera-price-tag" style="background-color:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>;">
													<span class="price-text">
														<?php 
														if(is_numeric($post_price)){
															echo classiera_post_price_display($post_currency_tag, $post_price);
														}else{ 						 
															echo esc_attr( $post_price ); 
														}
														?>
													</span>
												</span>
												<?php } ?> -->
												<?php 
												$origin = new DateTime();
												$target = new DateTime($theDate);
												$interval = $origin->diff($target);
												$date_diff = $interval->format('%R%a');
												$short_date = date("F d", strtotime($theDate));
												?>
												<span class="classiera-time">
													<?php 
														if($date_diff == 0){
															echo "Today "; echo $theTime;
														}elseif($date_diff == -1){
															echo "Yesterday "; echo $theTime;
														}else{
															echo $short_date.' ';
															echo $theTime;
														}
													?>	
												</span>
												<figcaption>
													<h5>
														<a href="<?php echo esc_url(the_permalink()); ?>">
															<?php echo esc_html( $theTitle ); ?>
														</a>
													</h5>
													<p>
														<!-- <?php esc_html_e( 'Category', 'classiera' ); ?> :  -->
														<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
															<?php echo classiera_get_category($post->ID); ?>,
														</a> 
														<!-- <span><?php esc_html_e( 'Location', 'classiera' ); ?></span> :  -->
														<span><?php echo $post_state; ?></span> 
													</p>
													<p class="location">
														<!-- <?php esc_html_e( 'Location', 'classiera' ); ?> : 
														<a href="<?php echo esc_url( classiera_get_category_link($post_city)); ?>">
															<?php echo $post_city; ?>
														</a> -->
													</p><br class="location">
													<!-- <p>
														<span class="classiera-time"><?php echo $theDate; ?> <?php echo $theTime; ?></span>
													</p> -->
													<!-- <?php if(!empty($category_icon_code) || !empty($classieraCatIcoIMG)){?>
													<span class="category-icon-box" style=" background:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>; ">
														<?php 
														if($classieraIconsStyle == 'icon'){
															?>
															<i class="<?php echo esc_attr( $category_icon_code ); ?>"></i>
															<?php
														}elseif($classieraIconsStyle == 'img'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_attr( $postCatgory[0]->name ); ?>">
															<?php
														}
														?>
													</span>
													<?php } ?> -->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_price)){
																echo classiera_post_price_display($post_currency_tag, $post_price);
															}else{ 						 
																echo esc_attr( $post_price ); 
															}
															?>
														</span>
													</span>
													<?php }else{ ?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_old_price)){
																echo classiera_post_price_display($post_currency_tag, $post_old_price);
															}else{ 						 
																echo esc_attr( $post_old_price ); 
															}
															?>
														</span>
													</span>
													<?php } ?>
													<!-- <p class="description">
														<?php echo substr(get_the_excerpt(), 0,260); ?> 
													</p> -->
													<!-- <div class="post-tags">
														<span><i class="fas fa-tags"></i>
														<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
														</span>
														<?php the_tags('','',''); ?>
													</div> -->
													<!--post-tags-->
												</figcaption>
											</figure>
										</div><!--classiera-box-div-->
									</div><!--col-lg-4-->
									<?php endwhile;	?>
								</div>
								<!-- End Oldest -->
								<!-- Cheapest Ads -->
								<div id="cheapest_ads<?= $row->id; ?>" style="display: none;">
									<?php 
										global $wp_query, $wp;

										$wp_query = new WP_Query();
										$kulPost = array(
											'post_type'  => 'post',
											'category_name' => $row->category_name,
											's' => $row->saved_query,
											'posts_per_page' => -1,
											'meta_key' => 'post_old_price',
                      'orderby'   => 'meta_value_num',
                      'order' => 'ASC',	
											'meta_query' => array(
												array(
													'key' => 'post_state',
													'value' => $row->saved_state,
													'compare' => '=',
												)
											),
											
										);
										$wp_query = new WP_Query($kulPost);
										// print_r($wp_query);die();
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID);						
									$classieraPstatus = get_post_status( $post->ID );						
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									$theDate = get_the_date();
									$theTime = get_the_time();
									$theTitle = get_the_title();
									$post_location = get_post_meta($post->ID, 'post_location', true);
									$post_state = get_post_meta($post->ID, 'post_state', true);
									$post_city = get_post_meta($post->ID, 'post_city', true);
									$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item item-list">
										<div class="classiera-box-div classiera-box-div-v1">
											<figure class="clearfix">
												<div class="premium-img">
												<?php 
												$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
												if($classieraFeaturedPost == 1){
													?>
													<div class="featured-tag">
														<span class="left-corner"></span>
														<span class="right-corner"></span>
														<div class="featured">
															<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
														</div>
													</div>
													<?php
												}
												if( has_post_thumbnail()){
													$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
													$thumb_id = get_post_thumbnail_id($post->ID);
													?>
													<img class="img-responsive" src="<?php echo esc_url( $imageurl[0] ); ?>" alt="<?php echo esc_html( $theTitle ); ?>">
													<?php
												}else{
													?>
													<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
													<?php
												}
												?>
													<span class="hover-posts">
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
												<!-- <?php if(!empty($post_price)){?>
												<span class="classiera-price-tag" style="background-color:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>;">
													<span class="price-text">
														<?php 
														if(is_numeric($post_price)){
															echo classiera_post_price_display($post_currency_tag, $post_price);
														}else{ 						 
															echo esc_attr( $post_price ); 
														}
														?>
													</span>
												</span>
												<?php } ?> -->
												<?php 
												$origin = new DateTime();
												$target = new DateTime($theDate);
												$interval = $origin->diff($target);
												$date_diff = $interval->format('%R%a');
												$short_date = date("F d", strtotime($theDate));
												?>
												<span class="classiera-time">
													<?php 
														if($date_diff == 0){
															echo "Today "; echo $theTime;
														}elseif($date_diff == -1){
															echo "Yesterday "; echo $theTime;
														}else{
															echo $short_date.' ';
															echo $theTime;
														}
													?>	
												</span>
												<figcaption>
													<h5>
														<a href="<?php echo esc_url(the_permalink()); ?>">
															<?php echo esc_html( $theTitle ); ?>
														</a>
													</h5>
													<p>
														<!-- <?php esc_html_e( 'Category', 'classiera' ); ?> :  -->
														<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
															<?php echo classiera_get_category($post->ID); ?>,
														</a> 
														<!-- <span><?php esc_html_e( 'Location', 'classiera' ); ?></span> :  -->
														<span><?php echo $post_state; ?></span> 
													</p>
													<p class="location">
														<!-- <?php esc_html_e( 'Location', 'classiera' ); ?> : 
														<a href="<?php echo esc_url( classiera_get_category_link($post_city)); ?>">
															<?php echo $post_city; ?>
														</a> -->
													</p><br class="location">
													<!-- <p>
														<span class="classiera-time"><?php echo $theDate; ?> <?php echo $theTime; ?></span>
													</p> -->
													<!-- <?php if(!empty($category_icon_code) || !empty($classieraCatIcoIMG)){?>
													<span class="category-icon-box" style=" background:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>; ">
														<?php 
														if($classieraIconsStyle == 'icon'){
															?>
															<i class="<?php echo esc_attr( $category_icon_code ); ?>"></i>
															<?php
														}elseif($classieraIconsStyle == 'img'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_attr( $postCatgory[0]->name ); ?>">
															<?php
														}
														?>
													</span>
													<?php } ?> -->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_price)){
																echo classiera_post_price_display($post_currency_tag, $post_price);
															}else{ 						 
																echo esc_attr( $post_price ); 
															}
															?>
														</span>
													</span>
													<?php }else{ ?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_old_price)){
																echo classiera_post_price_display($post_currency_tag, $post_old_price);
															}else{ 						 
																echo esc_attr( $post_old_price ); 
															}
															?>
														</span>
													</span>
													<?php } ?>
													<!-- <p class="description">
														<?php echo substr(get_the_excerpt(), 0,260); ?> 
													</p> -->
													<!-- <div class="post-tags">
														<span><i class="fas fa-tags"></i>
														<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
														</span>
														<?php the_tags('','',''); ?>
													</div> -->
													<!--post-tags-->
												</figcaption>
											</figure>
										</div><!--classiera-box-div-->
									</div><!--col-lg-4-->
									<?php endwhile;	?>
								</div>
								<!-- End Cheapest Ads -->
								<!-- Expensive Ads -->
								<div id="expensive_ads<?= $row->id; ?>" style="display: none;">
									<?php 
										global $wp_query, $wp;

										

										$wp_query = new WP_Query();
										$kulPost = array(
											'post_type'  => 'post',
											'category_name' => $row->category_name,
											's' => $row->saved_query,
											'posts_per_page' => -1,
											'meta_key' => 'post_old_price',
                      'orderby'   => 'meta_value_num',
                      'order' => 'DESC',	
											'meta_query' => array(
												array(
													'key' => 'post_state',
													'value' => $row->saved_state,
													'compare' => '=',
												)
											),
											
										);
										$wp_query = new WP_Query($kulPost);
										// print_r($wp_query);die();
									while ($wp_query->have_posts()) : $wp_query->the_post();
									$title = get_the_title($post->ID);						
									$classieraPstatus = get_post_status( $post->ID );						
									$postDate = get_the_date($dateFormat, $post->ID);
									$postStatus = get_post_status($post->ID);
									$productID = get_post_meta($post->ID, 'pay_per_post_product_id', true);
									$days_to_expire = get_post_meta($post->ID, 'days_to_expire', true);
									$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
									$post_price = get_post_meta($post->ID, 'post_price', true);
									$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
									$theDate = get_the_date();
									$theTime = get_the_time();
									$theTitle = get_the_title();
									$post_location = get_post_meta($post->ID, 'post_location', true);
									$post_state = get_post_meta($post->ID, 'post_state', true);
									$post_city = get_post_meta($post->ID, 'post_city', true);
									$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
									?>
									<div class="col-lg-4 col-md-4 col-sm-6 match-height item item-list">
										<div class="classiera-box-div classiera-box-div-v1">
											<figure class="clearfix">
												<div class="premium-img">
												<?php 
												$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
												if($classieraFeaturedPost == 1){
													?>
													<div class="featured-tag">
														<span class="left-corner"></span>
														<span class="right-corner"></span>
														<div class="featured">
															<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
														</div>
													</div>
													<?php
												}
												if( has_post_thumbnail()){
													$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
													$thumb_id = get_post_thumbnail_id($post->ID);
													?>
													<img class="img-responsive" src="<?php echo esc_url( $imageurl[0] ); ?>" alt="<?php echo esc_html( $theTitle ); ?>">
													<?php
												}else{
													?>
													<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
													<?php
												}
												?>
													<span class="hover-posts">
														<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-sm active"><?php esc_html_e( 'view ad', 'classiera' ); ?></a>
													</span>
													<?php if(!empty($classiera_ads_type)){?>
													<span class="classiera-buy-sel">
														<?php classiera_buy_sell($classiera_ads_type); ?>
													</span>
													<?php } ?>
												</div><!--premium-img-->
												<!-- <?php if(!empty($post_price)){?>
												<span class="classiera-price-tag" style="background-color:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>;">
													<span class="price-text">
														<?php 
														if(is_numeric($post_price)){
															echo classiera_post_price_display($post_currency_tag, $post_price);
														}else{ 						 
															echo esc_attr( $post_price ); 
														}
														?>
													</span>
												</span>
												<?php } ?> -->
												<?php 
												$origin = new DateTime();
												$target = new DateTime($theDate);
												$interval = $origin->diff($target);
												$date_diff = $interval->format('%R%a');
												$short_date = date("F d", strtotime($theDate));
												?>
												<span class="classiera-time">
													<?php 
														if($date_diff == 0){
															echo "Today "; echo $theTime;
														}elseif($date_diff == -1){
															echo "Yesterday "; echo $theTime;
														}else{
															echo $short_date.' ';
															echo $theTime;
														}
													?>	
												</span>
												<figcaption>
													<h5>
														<a href="<?php echo esc_url(the_permalink()); ?>">
															<?php echo esc_html( $theTitle ); ?>
														</a>
													</h5>
													<p>
														<!-- <?php esc_html_e( 'Category', 'classiera' ); ?> :  -->
														<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
															<?php echo classiera_get_category($post->ID); ?>,
														</a> 
														<!-- <span><?php esc_html_e( 'Location', 'classiera' ); ?></span> :  -->
														<span><?php echo $post_state; ?></span> 
													</p>
													<p class="location">
														<!-- <?php esc_html_e( 'Location', 'classiera' ); ?> : 
														<a href="<?php echo esc_url( classiera_get_category_link($post_city)); ?>">
															<?php echo $post_city; ?>
														</a> -->
													</p><br class="location">
													<!-- <p>
														<span class="classiera-time"><?php echo $theDate; ?> <?php echo $theTime; ?></span>
													</p> -->
													<!-- <?php if(!empty($category_icon_code) || !empty($classieraCatIcoIMG)){?>
													<span class="category-icon-box" style=" background:<?php echo esc_html( $category_icon_color ); ?>; color:<?php echo esc_html( $category_icon_color ); ?>; ">
														<?php 
														if($classieraIconsStyle == 'icon'){
															?>
															<i class="<?php echo esc_attr( $category_icon_code ); ?>"></i>
															<?php
														}elseif($classieraIconsStyle == 'img'){
															?>
															<img src="<?php echo esc_url( $classieraCatIcoIMG ); ?>" alt="<?php echo esc_attr( $postCatgory[0]->name ); ?>">
															<?php
														}
														?>
													</span>
													<?php } ?> -->
													<?php if(!empty($post_price)){?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_price)){
																echo classiera_post_price_display($post_currency_tag, $post_price);
															}else{ 						 
																echo esc_attr( $post_price ); 
															}
															?>
														</span>
													</span>
													<?php }else{ ?>
													<span class="classiera-price-tag">
														<span class="price-text">
															<?php 
															if(is_numeric($post_old_price)){
																echo classiera_post_price_display($post_currency_tag, $post_old_price);
															}else{ 						 
																echo esc_attr( $post_old_price ); 
															}
															?>
														</span>
													</span>
													<?php } ?>
													<!-- <p class="description">
														<?php echo substr(get_the_excerpt(), 0,260); ?> 
													</p> -->
													<!-- <div class="post-tags">
														<span><i class="fas fa-tags"></i>
														<?php esc_html_e('Tags', 'classiera'); ?>&nbsp; :
														</span>
														<?php the_tags('','',''); ?>
													</div> -->
													<!--post-tags-->
												</figcaption>
											</figure>
										</div><!--classiera-box-div-->
									</div><!--col-lg-4-->
									<?php endwhile;	?>
								</div>
								<!-- End Expensive Ads -->
							</div>
						<?php } } ?>
						</div>
					</div><!--user-ads-->
					
					<!-- favorite ads -->
				</div><!--user-detail-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->
</section><!--user-pages-->
<!-- Company Section Start-->
<?php 
	global $redux_demo; 
	$classieraCompany = $redux_demo['partners-on'];
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
		function activetabs($id)
		{
			alert($id);
		}
		
		var switchStatus = 0;
        $("#togBtn").on('change', function() {
            if ($(this).is(':checked')) {
                switchStatus = 1;
                $('#email_monitor').val(1);
                $( "#target" ).submit();
                
            }
            else {
               switchStatus = 0;
               $('#email_monitor').val(0);
               $( "#target" ).submit();
            }
        });
        
        // $( "#togBtn" ).change(function() {
          
        // });
	});
	
</script>

<!-- Company Section End-->	
<?php get_footer(); ?>