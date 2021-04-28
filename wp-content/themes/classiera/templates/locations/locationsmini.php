<?php 
	global $redux_demo;
	$locationTitle = $redux_demo['locations-sec-title'];
	$locationDesc = $redux_demo['locations-desc'];
	$locShownBy = $redux_demo['location-shown-by'];
	$homeLocCounter = $redux_demo['home-location-counter'];
	$locationCounter = $redux_demo['classiera_loc_post_counter'];
	/*==========================
	Get Locations Template URL
	===========================*/
	$locationTemplatePermalink = classiera_get_template_url('template-locations.php');
	global $wp_rewrite;
	if ($wp_rewrite->permalink_structure == ''){
	//we are using ?page_id
		$locationURL = $locationTemplatePermalink."&location=";
	}else{
	//we are using permalinks
		$locationURL = $locationTemplatePermalink."?location=";
	}
	$args_location = array( 'posts_per_page' => -1 );
	$lastposts = get_posts( $args_location );
	$all_post_location = array();
	foreach( $lastposts as $post ) {
		$all_post_location[] = get_post_meta( $post->ID, $locShownBy, true );
	}
	$directors = array_unique($all_post_location);
?>
<section class="minimal_location">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 center-auto">
				<?php if(!empty($locationTitle)){ ?>
				<div class="minimal_section_heading">
					<h3><?php echo esc_html($locationTitle); ?></h3>
					<?php if(!empty($locationDesc)){ ?>
					<p><?php echo esc_html($locationDesc); ?></p>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="minimal_location_content">
				<?php 
				$count = 0;
				foreach ($directors as $director) {
					if(!empty($director) && $count <= $homeLocCounter){
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(								
								array(
									'key' => $locShownBy,
									'value' => $director,
									'type' => 'LIKE'
								),
							),
						);
						$myQuery = new WP_Query($args);
						$countposts = $myQuery->found_posts;
				?>
					<a href="<?php echo esc_url($locationURL); ?><?php echo esc_attr($director); ?>">
						<h5><?php echo esc_attr($director); ?></h5>
						<span>
							<?php echo esc_attr($countposts); ?>&nbsp;
							<?php esc_html_e( 'Ads posted', 'classiera' ); ?>
						</span>
					</a>
				<?php 
					}
				}
				?>
				</div><!--minimal_location_content-->
			</div><!--col-lg-8-->
		</div><!--row-->
	</div><!--container-->
</section><!--minimal_location-->