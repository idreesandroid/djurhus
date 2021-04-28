<?php
global $redux_demo;
$classiera_ads_typeOn = false;
$categoryAdsCount = 12;
if(isset($redux_demo)){
	$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
	$categoryAdsCount = $redux_demo['classiera_cat_ads_count'];
}
$classiera_ads_type = false;
$classiera_locations_input = 'input';
if(isset($redux_demo)){
	$classiera_ads_type = $redux_demo['classiera_ads_type'];
	$classiera_locations_input = $redux_demo['classiera_locations_input'];
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
<section class="classiera-advertisement advertisement-v1">
	<div class="tab-button">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#all" aria-controls="all" role="tab" data-toggle="tab"><?php esc_html_e( 'All Ads', 'classiera' ); ?></a>
                        </li>
                        <li role="presentation">
                            <a href="#random" aria-controls="random" role="tab" data-toggle="tab"><?php esc_html_e( 'Random Ads', 'classiera' ); ?></a>
                        </li>
                        <li role="presentation">
                            <a href="#popular" aria-controls="popular" role="tab" data-toggle="tab"><?php esc_html_e( 'Popular Ads', 'classiera' ); ?></a>
                        </li>
                    </ul><!--nav nav-tabs-->
                </div><!--col-md-12-->
            </div><!--row-->
        </div><!--container-->
    </div><!--tab-button-->
	<div class="tab-divs section-light-bg">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-6">
						<div class="total-post">
							<p><?php esc_html_e( 'Total Ads', 'classiera' ); ?>: <span><?php echo classiera_Cat_Ads_Count(); ?>&nbsp;<?php esc_html_e( 'ads found', 'classiera' ); ?></span></p>
						</div><!--total-post-->
					</div><!--col-lg-6-->
					<!--col-lg-6-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="filter_section">
			<div class="conatiner">	
				<div class="row">	
					<div class="col-xs-12 col-sm-6 col-lg-6">
						<form>
							<?php if($classiera_ads_type == 1){?>
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
										<label for="buy"><?php esc_html_e( 'Want to Buy', 'classiera' ); ?></label>
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
					<div class="col-lg-3 col-sm-6 col-xs-5">
						<div class="view-as text-right flip">
							<span><?php esc_html_e( 'View As', 'classiera' ); ?>:</span>
							<a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#">
								<i class="fas fa-th"></i>
							</a>
							<a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#">
								<i class="fas fa-bars"></i>
							</a>
						</div><!--view-as-->
					</div>
				</div>
			</div>	
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container" id="all_ads">
					<div class="row">
						<!--FeaturedPosts-->
						<!-- <?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								//get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							//wp_reset_postdata();
							//wp_reset_query();
						?> -->
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$count = 0;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $categoryAdsCount,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_query' => array(
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
							$count++;
								if(($count +1) % 7 === 0){ ?>
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
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<div class="container" id="all_type" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							wp_reset_postdata();
							wp_reset_query();
						?>
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $categoryAdsCount,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_query' => array(
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<!-- Lowered Price -->
				<div class="container" id="lowered_price" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<!-- <?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								//get_template_part( 'templates/classiera-loops/loop-lowered-price');
							endwhile;
							//wp_reset_postdata();
							//wp_reset_query();
						?> -->
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_query' => array(
									array(
										'key' => 'post_price',
										'value' => '',
										'compare' => '!='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lowered-price');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<!-- Oldest Ads -->
				<div class="container" id="oldest_price" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $classieraFeaturedAdsCounter,
								'paged' => $paged,								
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							wp_reset_postdata();
							wp_reset_query();
						?>
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $categoryAdsCount,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<!-- Cheapest Ads -->
				<div class="container" id="cheapest_ads" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<!-- <?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,								
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								//get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							wp_reset_postdata();
							wp_reset_query();
						?> -->
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_key' => 'post_old_price',
                                'orderby'   => 'meta_value_num',
                                'order' => 'ASC',
								'meta_query' => array(
								// 	array(
								// 		'key' => 'post_price',
								// 		'value' => 50,
								// 		'type' => 'numeric',
								// 		'compare' => '<=',
								// 		),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<!-- Expensive Ads -->
				<div class="container" id="expensive_ads" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<!-- <?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$featuredPosts = array();
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,								
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$featuredPosts[] = $post->ID;
								//get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile;
							wp_reset_postdata();
							wp_reset_query();
						?> -->
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'meta_key' => 'post_old_price',
                                'orderby'   => 'meta_value_num',
                                'order' => 'DESC',
								'meta_query' => array(
								// 	array(
								// 		'key' => 'post_price',
								// 		'value' => 2000,
								// 		'type' => 'numeric',
								// 		'compare' => '>=',
								// 		),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
					</div><!--row-->
						<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
						?>
				</div><!--container-->
				<!-- Buy Type Ads -->
				<div class="container" id="buy_type" style="display: none;">
					<div class="row">
						<!--FeaturedPosts-->
						<?php 
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'classiera_ads_type',
										'value' => 'buy',
										'compare' => '=',
										),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
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
							if ( !empty ( $args['paged'] ) && 0 == $paged ) {
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}							
							$cat_id = get_queried_object_id();
							$temp = $wp_query;
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								'cat' => $cat_id,
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'classiera_ads_type',
										'value' => 'sell',
										'compare' => '=',
										),
									$adstypeQuery,
								),
							);
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								get_template_part( 'templates/classiera-loops/loop-lime');
							endwhile; 
							wp_reset_postdata();
							wp_reset_query();
						?>
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
			<div role="tabpanel" class="tab-pane fade" id="random">
				<div class="container">
					<div class="row">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$cat_id = get_queried_object_id();
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => $categoryAdsCount,
							'paged' => $paged,							
							'cat' => $cat_id,
							'meta_key' => 'wpb_post_views_count',
							'orderby' => 'meta_value_num',
							'order' => 'DESC',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_postdata();
						wp_reset_query(); 
					?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel random-->
			<div role="tabpanel" class="tab-pane fade" id="popular">
				<div class="container" id="all_ads">
					<div class="row">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => $categoryAdsCount,
							'paged' => $paged,
							'cat' => $cat_id,
							'meta_key' => 'wpb_post_views_count',							
							'orderby' => 'meta_value_num',
							'order' => 'DESC',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_query();
						wp_reset_postdata();
						?>
					</div><!--row-->
				</div><!--container-->
				<!-- Oldest Ads -->
				<div class="container" id="oldest_price" style="display: none;">
					<div class="row">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => $categoryAdsCount,
							'paged' => $paged,
							'cat' => $cat_id,							
							'orderby' => 'title',
							'orderby' => 'ID',
							'order' => 'ASC',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lime');
						endwhile;
						wp_reset_query();
						wp_reset_postdata();
						?>
					</div><!--row-->
				</div><!--container-->
				<!-- Lowered Price Ads -->
				<div class="container" id="lowered_price" style="display: none;">
					<div class="row">
						<?php 
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$cat_id = get_queried_object_id();
						$temp = $wp_query;
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'paged' => $paged,
							'cat' => $cat_id,							
							'orderby' => 'title',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-lowered-price');
						endwhile;
						wp_reset_query();
						wp_reset_postdata();
						?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>