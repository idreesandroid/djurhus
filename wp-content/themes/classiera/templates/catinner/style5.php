<?php 
global $redux_demo;
$classiera_ads_typeOn = false;
$categoryAdsCount = 12;
if(isset($redux_demo)){
	$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
	$categoryAdsCount = $redux_demo['classiera_cat_ads_count'];
}
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
<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
	<div class="tab-divs">
		<div class="view-head">
			<div class="container">
				<div class="row">
					<?php if(classiera_Cat_Ads_Count() > 0 ){ ?>
					<div class="col-lg-8 col-sm-8 col-xs-8">
                        <div class="tab-button">
                            <ul class="nav nav-tabs" role="tablist">								
                                <li role="presentation" class="active">
									<a href="#all" aria-controls="all" role="tab" data-toggle="tab">
										<?php esc_html_e( 'All Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                                <li role="presentation">                                    
									<a href="#random" aria-controls="random" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Random Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                                <li role="presentation">                                   
									<a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">
										<?php esc_html_e( 'Popular Ads', 'classiera' ); ?>
										<span class="arrow-down"></span>
									</a>
                                </li>
                            </ul><!--nav nav-tabs-->
                        </div><!--tab-button-->
                    </div><!--col-lg-6 col-sm-8-->
					<div class="col-lg-4 col-sm-4 col-xs-4">
						<div class="view-as text-right flip">
							<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
							<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
                        </div><!--view-as tab-button-->
					</div><!--col-lg-6 col-sm-4 col-xs-12-->
					<?php }else{ ?>
					<div class="col-lg-12">
						<h5><?php esc_html_e( 'Sorry, no result found.', 'classiera' ); ?></h5>
					</div>
					<?php } ?>
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
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
							get_template_part( 'templates/classiera-loops/loop-ivy');
						endwhile;
						wp_reset_postdata();
						wp_reset_query(); ?>
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
			</div><!--tabpanel all-->
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
						$wp_query = new WP_Query( $args );
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-ivy');
						endwhile;
						wp_reset_query(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel random-->
			<div role="tabpanel" class="tab-pane fade" id="popular">
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
							'orderby' => 'title',
							'meta_query' => array(
								$adstypeQuery,
							),
						);
						$temp = $wp_query;
						$wp_query= null;
						$wp_query = new WP_Query($args);						
						while ($wp_query->have_posts()) : $wp_query->the_post();
							get_template_part( 'templates/classiera-loops/loop-ivy');
						endwhile;
						wp_reset_query(); ?>
					</div><!--row-->
				</div><!--container-->
			</div><!--tabpanel popular-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>