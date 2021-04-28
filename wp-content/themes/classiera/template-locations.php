<?php
/**
 * Template name: Locations
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */

get_header(); 

	global $redux_demo; 	
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$locationName = '';
	$locShownBy = 'post_location';
	$category_icon_code = "";
	$category_icon_color = "";
	$your_image_url = "";
	$category_icon ="";
	$caticoncolor="";
	$classieraItemClass = "item-grid";
	$classieraAdsView = "grid";
	$classiera_pagination = "pagination";
	$classieraSearchStyle = 1;
	$classieraCategoriesStyle = 1;
	if(isset($redux_demo)){
		$classieraSearchStyle = $redux_demo['classiera_search_style'];
		$classieraAdsView = $redux_demo['home-ads-view'];
		$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
		$classiera_pagination = $redux_demo['classiera_pagination'];
		$locShownBy = $redux_demo['location-shown-by'];
	}
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}	
	if(isset($_GET['location'])){
		$locationName = $_GET['location'];
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
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-9">
			<!--Google Section-->
			<?php 
			$homeAd1 = '';		
			global $redux_demo;
			$homeAdImg1 = $redux_demo['post_ad']['url']; 
			$homeAdImglink1 = $redux_demo['post_ad_url']; 
			$homeHTMLAds = $redux_demo['post_ad_code_html'];
			
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
			<!--Google Section-->
				<!-- style1 -->
				<?php if($classieraCategoriesStyle == 1){?>
				<section class="classiera-advertisement advertisement-v1">
					<div class="tab-divs section-light-bg">
						<div class="view-head">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
									&nbsp;
                                    </div><!--col-lg-6 col-sm-6 col-xs-6-->
                                    <div class="col-lg-6 col-sm-6 col-xs-6">
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),							
													),
												);
										$wp_query = new WP_Query($kulPost);
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
				<!-- End style1 -->
				<?php }elseif($classieraCategoriesStyle == 2){?>
				<!-- style2 -->
				<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										&nbsp;
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											global $redux_demo;
											$classiera_cat_child = $redux_demo['classiera_cat_child'];
											if($classiera_cat_child == 'child'){
												foreach ($category as $cat){
													$tag = $cat->cat_ID;
													$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
													if (isset($tag_extra_fields[$tag])) {
														$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
														$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
														$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
													}
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											$categoryLink = get_category_link($catID);
											$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style2 -->
				<?php }elseif($classieraCategoriesStyle == 3){?>
				<!--style3 -->
				<section class="classiera-advertisement advertisement-v3 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										&nbsp;
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}									
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											$categoryLink = get_category_link($catID);
											$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style3 -->
				<?php }elseif($classieraCategoriesStyle == 4){?>
				<!--style4-->
				<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8 col-xs-12">
										&nbsp;
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
										$classieraItemClass = "item-masonry";
										if($classieraAdsView == 'list'){
											$classieraItemClass = "item-list";
										}
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$temp = $wp_query;									
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											//print_r($category);
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style4 -->
				<?php }elseif($classieraCategoriesStyle == 5 || $classieraCategoriesStyle == 8 || $classieraCategoriesStyle == 9 || $classieraCategoriesStyle == 10){?>
				<!--style5 -->
				<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-7 col-xs-8">
										&nbsp;
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style5-->
				<?php }elseif($classieraCategoriesStyle == 6){?>
				<!-- style6-->
				<section class="classiera-advertisement advertisement-v6 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										&nbsp;
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}									
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style6-->
				<?php }elseif($classieraCategoriesStyle == 7){?>
				<!-- style-->
				<section class="classiera-advertisement advertisement-v6 advertisement-v7 section-pad border-bottom">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
									&nbsp;
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
										
										if ( !empty ( $args['paged'] ) && 0 == $paged ) {
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$temp = $wp_query;										
										$wp_query= null;
										$wp_query = new WP_Query();
										$kulPost = array(
												'post_type'  => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
													'meta_query' => array(
														array(
															'relation' => 'OR',
															array(
																'key'     => 'post_location',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'     => 'post_state',
																'value'   => $locationName,
																'compare'   => 'LIKE',
															),
															array(
																'key'=> 'post_city',
																'value'=> $locationName,
																'compare' => 'LIKE',
															),
														),
													),
												);
										$wp_query = new WP_Query($kulPost);
										while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;
											$category = get_the_category();
											$catID = $category[0]->cat_ID;
											if ($category[0]->category_parent == 0) {
												$tag = $category[0]->cat_ID;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}elseif($category[1]->category_parent == 0){
												$tag = $category[0]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}else{
												$tag = $category[1]->category_parent;
												$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
												if (isset($tag_extra_fields[$tag])) {
													$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
													$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
													$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
												}
											}
											if(!empty($category_icon_code)) {
												$category_icon = stripslashes($category_icon_code);
											}							
											$post_price = get_post_meta($post->ID, 'post_price', true);
											$post_phone = get_post_meta($post->ID, 'post_phone', true);
											$theTitle = get_the_title();
											$postCatgory = get_the_category( $post->ID );
											$categoryLink = get_category_link($catID);
											$classieraPostAuthor = $post->post_author;
											$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
											$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
											$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
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
				<!-- end style7-->
				<?php } ?>
			</div><!--col-md-8-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php get_sidebar('pages'); ?>
					</div>
				</aside>
			</div>
		</div><!--row-->
	</div><!--container-->
</section>
<?php get_footer(); ?>