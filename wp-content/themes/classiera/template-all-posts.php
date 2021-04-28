<?php
/**
 * Template name: All Ads
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */
 get_header(); ?>
 <?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	global $redux_demo;	
	$classiera_ads_typeOn = false;
	$classieraSearchStyle = 1;
	$classieraAdsView = 'grid';
	$classieraAllAdsCount = 12;
	$classieraCategoriesStyle = 1;
	$classiera_pagination = 'pagination';
	if(isset($redux_demo)){
		$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
		$classieraSearchStyle = $redux_demo['classiera_search_style'];	
		$classieraAdsView = $redux_demo['home-ads-view'];	
		$classieraAllAdsCount = $redux_demo['classiera_no_of_ads_all_page'];
		$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
		$classiera_pagination = $redux_demo['classiera_pagination'];
	}		
	$adsTypeShow = $redux_demo['classiera_ads_type_show'];
	$classieraShowSell = $adsTypeShow[1];
	$classieraShowBuy = $adsTypeShow[2];
	$classieraShowRent = $adsTypeShow[3];
	$classieraShowHire = $adsTypeShow[4];
	$classieraShowFound = $adsTypeShow[5];
	$classieraShowFree = $adsTypeShow[6];
	$classieraShowEvent = $adsTypeShow[7];
	$classieraShowServices = $adsTypeShow[8];
	$classieraFeaturedAdsCounter = $redux_demo['classiera_featured_ads_count'];
	$classiera_pagination = $redux_demo['classiera_pagination'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	if($classiera_ads_typeOn == 1){
		$adstypeQuery = array(
			'key' => 'classiera_ads_type',
			'value' => 'sold',
			'compare' => '!='
		);
	}else{
		$adstypeQuery = null;
	}
?>
<?php 
	//Search Styles//
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
<!--Content-->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
	    
		<div class="row">
		<section id="classieraDv" style="height: auto !important;">
					<div class="container">
						<div class="row">							
							<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
								
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <!-- Header ad -->
                                    <ins class="adsbygoogle"
                                    style="display:block"
                                    data-ad-client="ca-pub-2012679001192357"
                                    data-ad-format="auto"
                                    data-full-width-responsive="true"></ins>
                                    <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>

							</div>
						</div>
					</div>	
				</section>
			<div class="col-md-8 col-lg-9">
			    
				<!-- advertisement -->
				<?php if($classieraCategoriesStyle == 1){?>
				<section class="classiera-advertisement advertisement-v1">
					<div class="tab-divs section-light-bg">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-6 col-xs-6">
										<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
										?>
										<div class="total-post">
											<p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
													<?php echo esc_attr($classieraPublishPCount); ?> 
													<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
										</div><!--total-post-->
									</div><!--col-lg-6 col-sm-6 col-xs-6-->
									
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="filter_section">
							<div class="conatiner">	
								<div class="row">	
									<div class="col-xs-12 col-sm-6 col-lg-5">
										<form>
											<?php if($classiera_ads_typeOn == 1){?>
											<div class="inner-search-box-child">
												<label><strong><?php esc_html_e( 'Type of Ad', 'classiera' ); ?> : </strong></label>
												<div class="radio">
													<input id="type_all" type="radio" name="classiera_ads_type" value="All" checked>
													<label for="type_all"><?php esc_html_e( 'All', 'classiera' ); ?></label>
													<?php if($classieraShowSell == 1){ ?>
														<input id="sell" type="radio" name="classiera_ads_type" value="sell">
														<label for="sell"><?php esc_html_e( 'For Sale', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowBuy == 1){ ?>
														<input id="buy" type="radio" name="classiera_ads_type" value="buy">
														<label for="buy"><?php esc_html_e( 'Wanted', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowRent == 1){ ?>
														<input id="rent" type="radio" name="classiera_ads_type" value="rent">
														<label for="rent"><?php esc_html_e( 'For Rent', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowHire == 1){ ?>
														<input id="hire" type="radio" name="classiera_ads_type" value="hire">
														<label for="hire"><?php esc_html_e( 'For hire', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowFound == 1){ ?>
														<input id="lostfound" type="radio" name="classiera_ads_type" value="lostfound">
														<label for="lostfound"><?php esc_html_e( 'Lost & Found', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowFree == 1){ ?>
														<input id="typefree" type="radio" name="classiera_ads_type" value="free">
														<label for="typefree"><?php esc_html_e( 'Free', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowEvent == 1){ ?>
														<input id="event" type="radio" name="classiera_ads_type" value="event">
														<label for="event"><?php esc_html_e( 'Event', 'classiera' ); ?></label>
													<?php } ?>
													<?php if($classieraShowServices == 1){ ?>
														<input id="service" type="radio" name="classiera_ads_type" value="service">
														<label for="service"><?php esc_html_e( 'Professional service', 'classiera' ); ?></label>
													<?php } ?>
												</div>
											</div>
											<?php } ?>
										</form>
									</div>	
									<div class="col-xs-7 col-sm-6 col-lg-3">
										<div class="sort_section text-right">
											<label><strong><?php esc_html_e( 'Sort By', 'classiera' ); ?> : </strong></label>
											<select id="sort_by">
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
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container" id="all_ads">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$count == 0;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
										$count++;
										if(($count +1) % 6 === 0){ ?>
										   <section id="" style="height: auto !important; margin-bottom: 10px;">
                        					<div class="container">
                        						<div>							
                        							<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
                        								
                                                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                                            <!-- Header ad -->
                                                            <ins class="adsbygoogle"
                                                            style="display:block"
                                                            data-ad-client="ca-pub-2012679001192357"
                                                            data-ad-format="auto"
                                                            data-full-width-responsive="true"></ins>
                                                            <script>
                                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                                            </script>
                        
                        							</div>
                        						</div>
                        					</div>	
                        				</section>
										<?php }
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->
								<div class="container" id="all_type" style="display: none;">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->
								<!-- Buy Type Ads -->
								<div class="container" id="buy_type" style="display: none;">
									<div class="row">
										<!--FeaturedPosts-->
										<?php
											global $paged, $wp_query, $wp;
											$args = wp_parse_args($wp->matched_query);
											if ( !empty ( $args['paged'] ) && 0 == $paged ){
												$wp_query->set('paged', $args['paged']);
												$paged = $args['paged'];
											}
											$cat_id = get_cat_ID(single_cat_title('', false));
											$temp = $wp_query;
											$wp_query= null;
											$wp_query = new WP_Query();
											$arags = array(
												'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => $classieraAllAdsCount,
												'paged' => $paged,
												'meta_query' => array(
													array(
														'key' => 'classiera_ads_type',
														'value' => 'buy',
														'compare' => '=',
														),
													$adstypeQuery,
												),
											);
											$wp_query = new WP_Query($arags);
											while ($wp_query->have_posts()) : $wp_query->the_post();
												get_template_part( 'templates/classiera-loops/loop-lime');
											endwhile; ?>
									</div><!--row-->
										<?php
											if($classiera_pagination == 'pagination'){
												classiera_pagination();
											}
										?>
								</div><!--container-->
								<!-- Sell type Ads -->
								<div class="container" id="sell_type" style="display: none;">
									<div class="row">
										<!--FeaturedPosts-->
										<?php
											global $paged, $wp_query, $wp;
											$args = wp_parse_args($wp->matched_query);
											if ( !empty ( $args['paged'] ) && 0 == $paged ){
												$wp_query->set('paged', $args['paged']);
												$paged = $args['paged'];
											}
											$cat_id = get_cat_ID(single_cat_title('', false));
											$temp = $wp_query;
											$wp_query= null;
											$wp_query = new WP_Query();
											$arags = array(
												'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => $classieraAllAdsCount,
												'paged' => $paged,
												'meta_query' => array(
													array(
														'key' => 'classiera_ads_type',
														'value' => 'sell',
														'compare' => '=',
													),
													$adstypeQuery,
												),
											);
											$wp_query = new WP_Query($arags);
											while ($wp_query->have_posts()) : $wp_query->the_post();
												get_template_part( 'templates/classiera-loops/loop-lime');
											endwhile; ?>
									</div><!--row-->
										<?php
											if($classiera_pagination == 'pagination'){
												classiera_pagination();
											}
										?>
								</div><!--container-->
								<!-- lowered Price Ads -->
								<div class="container" id="lowered_price" style="display: none;">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => -1,
											'paged' => $paged,
											'meta_query' => array(
												array(
													'key' => 'post_price',
													'value' => '',
													'compare' => '!='
												),
												$adstypeQuery,
											), 
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-lowered-price');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->
								<!-- Oldest Ads -->
								<div class="container" id="oldest_price" style="display: none;">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'orderby' => 'ID',
											'order' => 'ASC',
											'meta_query' => array(
												$adstypeQuery,
											), 
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->

								<!-- Expensive Ads -->
								<div class="container" id="expensive_ads" style="display: none;">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => -1,
											'paged' => $paged,
											'meta_key' => 'post_old_price',
                                            'orderby'   => 'meta_value_num',
                                            'order' => 'DESC',
											'meta_query' => array(
												// array(
												// // 	'key' => 'post_price',
												// // 	'value' => 2000,
												// // 	'type' => 'numeric',
												// // 	'compare' => '>=',
												// 	'orderby' => 'meta_value_num',
            //                                         'order' => 'desc',
            //                                         'key' => 'post_price',
 											// 	),
 												$adstypeQuery,
											), 
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->

								<!-- Cheapest Ads -->
								<div class="container" id="cheapest_ads" style="display: none;">
                  <div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;
										$wp_query = new WP_Query();
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => -1,
											'paged' => $paged,
											'meta_key' => 'post_old_price',
                                            'orderby'   => 'meta_value_num',
                                            'order' => 'ASC',
											'meta_query' => array(
												// array(
												// 	'key' => 'post_price',
												// 	'value' => 500,
												// 	'type' => 'numeric',
												// 	'compare' => '<=',
 											// 	),
 												$adstypeQuery,
											), 
										);
										$wp_query = new WP_Query($arags);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile; ?>										
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}?>									
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- End advertisement Style 1-->
				<?php }elseif($classieraCategoriesStyle == 2){?>
				<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
											<div class="btn-group">
												<a id="grid" class="grid btn btn-primary radius btn-md <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
												<a id="list" class="list btn btn-primary btn-md radius <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>
											</div>
										</div>
									</div><!--col-lg-6 col-sm-4-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);										
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-strobe');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content section-gray-bg-->
					</div>
				</section>
				<!-- advertisement Style 2-->
				<?php }elseif($classieraCategoriesStyle == 3){?>
				<section class="classiera-advertisement advertisement-v3 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?>
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
											<div class="btn-group">
												<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
												<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>
											</div>
										</div>
									</div><!--col-lg-6 col-sm-4-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'posts_per_page' => $classieraAllAdsCount,
											'post_status' => 'publish',
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);										
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-coral');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content section-gray-bg-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 3-->
				<?php }elseif($classieraCategoriesStyle == 4){?>
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8 col-xs-12">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
										<div class="total-post">
											<p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?>
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
										</div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4 col-xs-12">
										<div class="view-as tab-button">
											<ul class="nav nav-tabs pull-right flip" role="tablist">
												<li><span><?php esc_html_e( 'View as', 'classiera' ); ?></span></li>
												<li role="presentation" class="<?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>">
													<a id="grid" class="masonry" href="#">
														<i class="zmdi zmdi-view-dashboard"></i>
														<span class="arrow-down"></span>
													</a>
												</li>
												<li role="presentation" class="<?php if($classieraAdsView == 'list'){ echo "active"; }?>">
													<a id="list" class="list" href="#">
														<i class="zmdi zmdi-view-list"></i>
														<span class="arrow-down"></span>
													</a>
												</li>
											</ul>
										</div><!--view-as tab-button-->
									</div><!--col-lg-6 col-sm-4 col-xs-12-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content section-gray-bg">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "masonry-content"; }?>">
										<?php									
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;						
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);									
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-canary');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 4-->
				<?php }elseif($classieraCategoriesStyle == 5 || $classieraCategoriesStyle == 8 || $classieraCategoriesStyle == 9 || $classieraCategoriesStyle == 10){?>
				<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-7 col-xs-8">
										<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?> 
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-5 col-xs-4">
										<div class="view-as text-right flip">
											<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
										</div><!--view-as tab-button-->
									</div><!--col-lg-6 col-sm-4 col-xs-12-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$cat_id = get_cat_ID(single_cat_title('', false));
										$temp = $wp_query;
										$wp_query= null;										
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);									
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-ivy');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 5-->
				<?php }elseif($classieraCategoriesStyle == 6){?>
				<section class="classiera-advertisement advertisement-v6 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?>
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
										</div><!--view-as tab-button-->
									</div><!--col-lg-6 col-sm-4 col-xs-12-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
									<?php 
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$arags = array(
											'post_type' => 'post',
											'posts_per_page' => $classieraAllAdsCount,
											'post_status' => 'publish',
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);										
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-iris');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 6-->
				<?php }elseif($classieraCategoriesStyle == 7){?>
				<section class="classiera-advertisement advertisement-v6 advertisement-v7 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									<?php 
										$classieraPostCount = wp_count_posts();
										$classieraPublishPCount = $classieraPostCount->publish;
									?>
                                        <div class="total-post">
                                            <p><?php esc_html_e( 'Total ads', 'classiera' ); ?>: 
												<span>
												<?php echo esc_attr($classieraPublishPCount); ?>
												<?php esc_html_e( 'ads posted', 'classiera' ); ?>
												</span>
											</p>
                                        </div><!--total-post-->
									</div><!--col-lg-6 col-sm-8-->
									<div class="col-lg-6 col-sm-4">
										<div class="view-as text-right flip">
											<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
										</div><!--view-as tab-button-->
									</div><!--col-lg-6 col-sm-4 col-xs-12-->
								</div><!--row-->
							</div><!--container-->
						</div><!--view-head-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php 
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$arags = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'posts_per_page' => $classieraAllAdsCount,
											'paged' => $paged,
											'meta_query' => array(
												$adstypeQuery,
											),
										);
										$wp_query = new WP_Query($arags);										
										while ($wp_query->have_posts()) : $wp_query->the_post();
											get_template_part( 'templates/classiera-loops/loop-allure');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
									if($classiera_pagination == 'infinite'){
										echo infinite($wp_query);
									}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div><!--tab-divs-->
				</section>
				<!-- advertisement Style 7-->
				<?php } ?>
			</div><!--col-md-8 col-lg-9-->
			<div class="col-md-4 col-lg-3 featured_sidebar">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<!--Content-->
<script>
	jQuery(document).ready(function($){
		$('#sort_by').change(function(){
			var selectedValue = $(this). children("option:selected"). val();
			if(selectedValue == 'lowered'){
				$('#lowered_price').show();
				$('#all_ads').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else if(selectedValue == 'oldest'){
				$('#oldest_price').show();
				$('#all_ads').hide();
				$('#lowered_price').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else if(selectedValue == 'expensive'){
				$('#lowered_price').hide();
				$('#all_ads').hide();
				$('#oldest_price').hide();
				$('#expensive_ads').show();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else if(selectedValue == 'cheapest'){
				$('#lowered_price').hide();
				$('#all_ads').hide();
				$('#oldest_price').hide();
				$('#expensive_ads').hide();
				$('#cheapest_ads').show();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else{
				$('#lowered_price').hide();
				$('#all_ads').show();
				$('#oldest_price').hide();
				$('#expensive_ads').hide();
				$('#cheapest_ads').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}
		});

		$("input[name='classiera_ads_type']").click(function(){
      var radioValue = $("input[name='classiera_ads_type']:checked").val();
      
      if(radioValue == 'buy'){
        $('#buy_type').show();
        $('#lowered_price').hide();
        $('#all_type').hide();
        $('#oldest_price').hide();
        $('#cheapest_ads').hide();
        $('#expensive_ads').hide();
        $('#sell_type').hide();
      }else if(radioValue == 'sell'){
      	$('#sell_type').show();
      	$('#lowered_price').hide();
      	$('#all_type').hide();
      	$('#all_ads').hide();
      	$('#oldest_price').hide();
      	$('#cheapest_ads').hide();
      	$('#expensive_ads').hide();
      	$('#buy_type').hide();
      	
      }else{
      	$('#all_type').show();
      	$('#lowered_price').hide();
      	$('#all_ads').hide();
      	$('#oldest_price').hide();
      	$('#cheapest_ads').hide();
      	$('#expensive_ads').hide();
      	$('#buy_type').hide();
      	$('#sell_type').hide();
      }
    });

	});
</script>
<?php get_footer(); ?>