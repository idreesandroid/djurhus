<?php 
	global $redux_demo;
	$primaryColor = $redux_demo['color-primary'];
	$category_icon_code = "";
	$category_icon_color = "";
	$classieraCatIcoIMG = "";
	$catIcon = "";
	global $post;
	$category = get_the_category();
	if(isset($category[0]->category_parent) && $category[0]->category_parent == 0){
		$tag = $category[0]->cat_ID;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			if(isset($tag_extra_fields[$tag]['category_icon_code'])){
				$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			}
			if(isset($tag_extra_fields[$tag]['category_icon_color'])){
				$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			}
			if(isset($tag_extra_fields[$tag]['your_image_url'])){
				$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
			}
		}
	}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
		$tag = $category[0]->category_parent;
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		if (isset($tag_extra_fields[$tag])) {
			if(isset($tag_extra_fields[$tag]['category_icon_code'])){
				$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
			}
			if(isset($tag_extra_fields[$tag]['category_icon_color'])){
				$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
			}
			if(isset($tag_extra_fields[$tag]['your_image_url'])){
				$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
			}
		}
	}else{
		if (isset($category[0]->category_parent)) {
			$tag = $category[0]->category_parent;
			$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
			if (isset($tag_extra_fields[$tag])) {
				if(isset($tag_extra_fields[$tag]['category_icon_code'])){
					$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
				}
				if(isset($tag_extra_fields[$tag]['category_icon_color'])){
					$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
				}
				if(isset($tag_extra_fields[$tag]['your_image_url'])){
					$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
				}
			}
		}
	}
	global $redux_demo;
	$classiera_cat_child = $redux_demo['classiera_cat_child'];
	if($classiera_cat_child == 'child'){
		foreach ($category as $cat){
			$tag = $cat->cat_ID;
			$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
			if (isset($tag_extra_fields[$tag])) {
				if(isset($tag_extra_fields[$tag]['category_icon_code'])){
					$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
				}
				if(isset($tag_extra_fields[$tag]['category_icon_color'])){
					$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
				}
				if(isset($tag_extra_fields[$tag]['your_image_url'])){
					$classieraCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
				}
			}
		}
	}
	if(!empty($category_icon_code)) {
		$category_icon = stripslashes($category_icon_code);
	}
	if(empty($category_icon_color)) {
		$category_icon_color = $primaryColor;
	}
	$post_price = get_post_meta($post->ID, 'post_price', true);
	$post_phone = get_post_meta($post->ID, 'post_phone', true);
	$theTitle = get_the_title();
	$postCatgory = get_the_category( $post->ID );
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
?>
<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo classiera_grid_classes(); ?>">
	<div class="classiera-box-div classiera-box-div-v7">
		<figure class="clearfix">
			<div class="premium-img">
			<?php 
				$classieraFeaturedPost = get_post_meta($post->ID, 'featured_post', true);
				if($classieraFeaturedPost == 1){
					?>
					<div class="featured">
						<p><?php esc_html_e( 'Featured', 'classiera' ); ?></p>
					</div>
					<?php
				}
				?>
				<?php if(!empty($classiera_ads_type)){?>
				<div class="caption-tags">
					<span class="buy-sale-tag btn btn-primary round btn-style-six active">
					<?php classiera_buy_sell($classiera_ads_type); ?>
					</span>
				</div>
				<?php } ?>
				<?php
				if( has_post_thumbnail()){
					$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
					$thumb_id = get_post_thumbnail_id($post->ID);
					?>
					<img class="img-responsive" src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php echo esc_html($theTitle); ?>">
					<?php
				}else{
					?>
					<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
					<?php
				}
			?>
			</div><!--premium-img-->
			<div class="detail text-center">
				<?php if(!empty($post_price)){?>
				<span class="price price btn btn-primary round btn-style-six active">
					<?php 
					if(is_numeric($post_price)){
						echo classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						echo esc_attr($post_price); 
					}
					?>
				</span>
				<?php } ?>
				<div class="box-icon">
					<a href="mailto:<?php echo sanitize_email($classieraAuthorEmail) ?>?subject">
						<i class="fas fa-envelope"></i>
					</a>
					<?php if(!empty($post_phone)){?>
					<a href="tel:<?php echo esc_html($post_phone); ?>"><i class="fas fa-phone"></i></a>
					<?php } ?>
				</div>
			</div><!--box-div-heading-->
			<figcaption>
				<div class="caption-tags">
					<?php if(!empty($post_price)){?>
					<span class="price btn btn-primary round btn-style-six active">
						<?php 
						if(is_numeric($post_price)){
							echo classiera_post_price_display($post_currency_tag, $post_price);
						}else{ 
							echo esc_attr($post_price); 
						}
						?>
					</span>
					<?php } ?>
					<?php if(!empty($classiera_ads_type)){?>
					<span class="buy-sale-tag btn btn-primary round btn-style-six active">
						<?php classiera_buy_sell($classiera_ads_type); ?>
					</span>
					<?php } ?>
				</div>
				<div class="content">
					<?php if(!empty($post_price)){?>
					<span class="price btn btn-primary round btn-style-six active visible-xs">
						<?php 
						if(is_numeric($post_price)){
							echo classiera_post_price_display($post_currency_tag, $post_price);
						}else{ 
							echo esc_attr($post_price); 
						}
						?>
					</span>
					<?php } ?>
					<h5>
						<a href="<?php the_permalink(); ?>"><?php echo esc_html($theTitle); ?></a>
					</h5>
					<div class="category">
						<span>
							<?php esc_html_e('Category', 'classiera'); ?> : 
							<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
								<?php echo classiera_get_category($post->ID); ?>
							</a>
						</span>
					</div>
					<div class="description">
						<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
					</div>
					<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?> <i class="fas fa-long-arrow-alt-<?php if(is_rtl()){echo "left";}else{echo "right";}?>"></i></a>
				</div><!--content-->
			</figcaption>
		</figure>
	</div><!--row-->
</div><!--col-lg-4-->