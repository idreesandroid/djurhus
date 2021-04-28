<?php 
	global $redux_demo;
	$classieraBlogSecTitle = $redux_demo['classiera_blog_section_title'];
	$classieraBlogSecDesc = $redux_demo['classiera_blog_section_desc'];
	$classieraBlogSecCount = $redux_demo['classiera_blog_section_count'];
	$classieraBlogSecPOrder = $redux_demo['classiera_blog_section_post_order'];
	$classieraBlogPOrder = $redux_demo['classiera_blog_post_order'];
?>
<section class="blog-post-section section-pad news_section">
	<!-- section heading with icon -->
	<?php if(!empty($classieraBlogSecTitle)){ ?>
	<div class="section-heading-v6">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 center-block">
					<h3 class="text-uppercase blog_section_title">Latest News</h3>
					<?php if(!empty($classieraBlogSecDesc)){ ?>
					<!-- <p><?php echo esc_html($classieraBlogSecDesc); ?></p> -->
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!-- section heading with icon -->
	<?php } ?>
	<div class="container">
		<div class="row">
			<?php
				$classieraClass = 'col-lg-6';
				$args = array (
					'post_type' => array('blog','blog_posts'),
					'post_status' => 'publish',
					'posts_per_page' => 2,
					'tag_ID' => 98,
					'order' => $classieraBlogPOrder,
					'orderby' => $classieraBlogSecPOrder,
				);
				$blogSecQuery = new WP_Query($args);
			?>
			<?php if ( $blogSecQuery->have_posts() ): $current = 1;?>
			<?php while ( $blogSecQuery->have_posts() ) : $blogSecQuery->the_post(); ?>
			<?php
				$user_ID = $post->post_author;
				$classieradateFormat = get_option( 'date_format' );
				if($current == 1 || $current == 2){
					$classieraClass = 'col-lg-6';
				}
				// elseif($current == 3 || $current == 4 || $current == 5){
				// 	$classieraClass = 'col-lg-4';
				// }
				if($current == 2){
					$current = 0;
				}
			?>
			<div class="<?php echo esc_attr($classieraClass);?> col-md-4">
				<div class="blog-post blog-post-v2 blog-post-v3 match-height">
					<div class="blog-post-img-sec">
						<div class="blog-img">
							<?php
								if( has_post_thumbnail()){
									echo get_the_post_thumbnail();
									}
							?>
							<span class="hover-posts">
								<a href="<?php the_permalink(); ?>" class="btn btn-primary radius btn-md active">
									<?php esc_html_e( 'View Post', 'classiera' ); ?>
								</a>
							</span>
						</div>
					</div>
					<div class="blog-post-content">
						<h4 class="blog_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<p>
							<?php echo substr(get_the_excerpt(), 0,150); ?>
							<!-- <span>
								<i class="fas fa-user"></i>
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
							</span>
							<span class="classiera_pdate"><i class="far fa-clock"></i><?php echo get_the_date($classieradateFormat, $post->ID); ?></span>
							<span><i class="fas fa-comments"></i>
								<?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'classiera' ), number_format_i18n( get_comments_number() ) );?>
							</span> -->
						</p>
					</div>
				</div>
			</div>
			<?php $current++; ?>
			<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php
		$blogPermalink = classiera_get_template_url('template-blog.php');
	?>
	<!-- <div class="view-all text-center">
		<a href="<?php echo esc_url($blogPermalink); ?>" class="btn btn-primary round outline btn-style-six"><?php esc_html_e( 'View All Posts', 'classiera' ); ?></a>
	</div> -->
</section><!-- /.blog post -->

<!-- <section class="locations locations-v6 section-pad"> -->
	<!-- section heading with icon -->
<!-- 	<?php if(!empty($classieraBlogSecTitle)){ ?>
	<div class="section-heading-v6">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 center-block">
					<h3 class="text-capitalize"><?php echo esc_html($classieraBlogSecTitle); ?></h3>
					<?php if(!empty($classieraBlogSecDesc)){ ?>
					<p><?php echo esc_html($classieraBlogSecDesc); ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div> -->
	<!-- section heading with icon -->
	<!-- <?php } ?>
	<div class="location-content-v6">
		<div class="container">
			<div class="row">
				<?php
					$classieraClass = 'col-lg-6';
					$args = array (
						'post_type' => array('blog','blog_posts'),
						'post_status' => 'publish',
						'posts_per_page' => $classieraBlogSecCount,
						'order' => $classieraBlogPOrder,
						'orderby' => $classieraBlogSecPOrder,
					);
					$blogSecQuery = new WP_Query($args);
				?>
				<?php if ( $blogSecQuery->have_posts() ):  $current = 1;?>
					
				<?php while ( $blogSecQuery->have_posts() ) : $blogSecQuery->the_post(); ?>
				<?php
					$user_ID = $post->post_author;
					$classieradateFormat = get_option( 'date_format' );
					if($current == 1 || $current == 2){
						$classieraClass = 'col-lg-6';
					}elseif($current == 3 || $current == 4 || $current == 5){
						$classieraClass = 'col-lg-4';
					}
					if($current == 5){
						$current = 0;
					}
				?>
				<div class="<?php echo esc_attr($classieraClass);?> col-sm-6">
					<figure class="location">
						<?php
							if( has_post_thumbnail()){
								echo get_the_post_thumbnail();
								}
						?>
						<figcaption>
							<div class="location-caption">
								<span><i class="fas fa-map-marker-alt"></i></span>
							</div>
							<div class="location-caption">
								<h4>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h4>
								<p><?php echo substr(get_the_excerpt(), 0,150); ?></p>
							</div>
						</figcaption>
					</figure>
				</div>
				<?php $current++; ?>
				<?php endwhile; ?>
				<?php endif; ?>
				<?php //wp_reset_query(); ?>
				<?php //wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
	<?php
		$blogPermalink = classiera_get_template_url('template-blog.php');
	?> -->
	<!-- <div class="view-all text-center">
		<a href="<?php echo esc_url($blogPermalink); ?>" class="btn btn-primary round outline btn-style-six"><?php esc_html_e( 'View All Posts', 'classiera' ); ?></a>
	</div> -->
<!-- </section> -->
<!-- /.blog post -->


