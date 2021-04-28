<?php 
	global $redux_demo;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraAdsView = $redux_demo['home-ads-view'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraItemClass = "item-masonry";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}elseif($classieraAdsView == 'medium'){
		$classieraItemClass = "item-masonry";
	}
	$category_icon_code = "";
	$category_icon_color = "";
	$classieraCatIcoIMG = "";
	$catIcon = "";
	$catID = "";
	$category = get_the_category();
	if(isset($category[0]->cat_ID)){
		$catID = $category[0]->cat_ID;
	}	
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
	$categoryLink = get_category_link($catID);
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
?>
<div class="item item-grid <?php echo esc_attr($classieraItemClass); ?>">
	<div class="classiera-box-div classiera-box-div-v4">
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
				?>
				<div class="premium-img-inner">	
				<a href="<?php the_permalink(); ?>">
				<?php
				if( has_post_thumbnail()){
					$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
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
					<span class="hover-posts">
					</span>
					<?php if(!empty($classiera_ads_type)){?>
					<span class="classiera-buy-sel">
						<?php classiera_buy_sell($classiera_ads_type); ?>
					</span>
					<?php } ?>
					<div class="category">
						<span style="background:<?php echo esc_html($category_icon_color); ?>;">
						<?php 
						if($classieraIconsStyle == 'icon'){
							?>
							<i class="<?php echo esc_html($category_icon_code);?>"></i>
							<?php
						}elseif($classieraIconsStyle == 'img'){
							?>
							<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
							<?php
						}
						?>
						</span>
						<a href="<?php echo esc_url( classiera_get_category_link($post->ID) ); ?>">
							<?php echo classiera_get_category($post->ID); ?>
						</a>
					</div><!--category-->
					</a>
				</div><!--premium-img-inner-->
			</div><!--premium-img-->
			<div class="detail text-center">
				<?php if(!empty($post_price)){?>
				<span class="amount">
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
					<a href="mailto:<?php echo sanitize_email($classieraAuthorEmail); ?>?subject">
						<i class="fas fa-envelope"></i>
					</a>
					<?php if(!empty($post_phone)){?>
					<a href="tel:<?php echo esc_html($post_phone); ?>"><i class="fas fa-phone"></i></a>
					<?php } ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md btn-style-four"><?php esc_html_e('View Ad', 'classiera'); ?></a>
			</div><!--detail text-center-->
			<figcaption>
				<h5><a href="<?php the_permalink(); ?>"><?php echo esc_html($theTitle); ?></a></h5>
				<div class="category">
					<span style="background:<?php echo esc_html($category_icon_color); ?>;">
					<?php 
						if($classieraIconsStyle == 'icon'){
							?>
							<i class="<?php echo esc_html($category_icon_code);?>"></i>
							<?php
						}elseif($classieraIconsStyle == 'img'){
							?>
							<img src="<?php echo esc_url($classieraCatIcoIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
							<?php
						}
					?>
					</span>
					<a href="<?php echo esc_url($categoryLink); ?>"><?php echo esc_html($postCatgory[0]->name); ?></a>
				</div>
				<?php if(!empty($post_price)){?>
				<div class="price">
					<span class="amount">
						<?php 
						if(is_numeric($post_price)){
							echo classiera_post_price_display($post_currency_tag, $post_price);
						}else{ 
							echo esc_attr($post_price); 
						}
						?>
					</span>
				</div>
				<?php } ?>
				<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
			</figcaption>
		</figure>
	</div><!--row-->
</div><!--item item-grid item-masonry-->