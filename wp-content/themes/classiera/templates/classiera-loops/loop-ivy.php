<?php 
	global $redux_demo;
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];	
	$locShownBy = $redux_demo['location-shown-by'];
	$primaryColor = $redux_demo['color-primary'];	
	$category_icon_code = "";
	$category_icon_color = "";
	$classieraCatIcoIMG = "";
	$catIcon = "";
	global $post;
	$category = get_the_category();
	$catID = $category[0]->cat_ID;
	if ($category[0]->category_parent == 0) {
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
	$post_old_price = get_post_meta($post->ID, 'post_old_price', true);
	$post_phone = get_post_meta($post->ID, 'post_phone', true);
	$theTitle = get_the_title();
	$theDate = get_the_date();
	$theTime = get_the_time();
	$postCatgory = get_the_category( $post->ID );
	$categoryLink = get_category_link($catID);
	$classieraPostAuthor = $post->post_author;
	$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
	$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
	$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
	$attachments = get_children(array('post_parent' => $post->ID,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order ID'
		)
	);
	//print_r($attachments);
?>
<div class="col-lg-4 col-md-4 col-sm-6 match-height item <?php echo classiera_grid_classes(); ?>">
	<div class="classiera-box-div classiera-box-div-v5">
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
				<?php
				if( has_post_thumbnail()){
					$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
					//$imageurl = wp_get_attachment_image_src( get_the_post_thumbnail( $post_id, array( 370, 250) ););
					$thumb_id = get_post_thumbnail_id($post->ID);
					?>
					<img class="img-responsive" src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php echo esc_html($theTitle); ?>">
					<?php
				}elseif(!empty($attachments)){
					$imagecount = 1;
					foreach($attachments as $att_id => $attachment){
						$full_img_url = wp_get_attachment_url($attachment->ID);
						if($imagecount == 1){
						?>
						<img class="img-responsive" src="<?php echo esc_url($full_img_url); ?>" alt="<?php echo esc_html($theTitle); ?>">
						<?php
						}
						$imagecount++;
					}
				}else{
					?>
					<img class="img-responsive" src="<?php echo esc_url(get_template_directory_uri()) . '/images/nothumb.png' ?>" alt="No Thumb"/>
					<?php
				}
			?>
				<span class="hover-posts">											
					<a href="<?php the_permalink(); ?>"><?php esc_html_e('View Ad', 'classiera'); ?></a>
				</span>
				<?php if(!empty($post_price)){?>
					<span class="price">
						<?php esc_html_e('Price', 'classiera'); ?> : 
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
				<span class="classiera-buy-sel">
				<?php classiera_buy_sell($classiera_ads_type); ?>
				</span>
				<?php } ?>
			</div><!--premium-img-->
			<div class="detail text-center">
				<?php if(!empty($post_price)){?>
				<span class="price">
					<?php esc_html_e('Price', 'classiera'); ?> : 
					<?php 
					if(is_numeric($post_price)){
						echo classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						echo esc_attr($post_price); 
					}
					?>
				</span>
				<?php }else{ ?>
				<span class="price">
					<?php esc_html_e('Price', 'classiera'); ?> : 
					<?php 
					if(is_numeric($post_old_price)){
						echo classiera_post_price_display($post_currency_tag, $post_old_price);
					}else{ 
						echo esc_attr($post_old_price); 
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
				<a href="<?php the_permalink(); ?>" class="btn btn-primary outline btn-style-five"><?php esc_html_e('View Ad', 'classiera'); ?></a>
			</div><!--detail text-center-->
			<figcaption>
				<?php if(!empty($post_price)){?>
				<span class="price visible-xs">
				<?php esc_html_e('Price', 'classiera'); ?> :
					<?php 
					if(is_numeric($post_price)){
						echo classiera_post_price_display($post_currency_tag, $post_price);
					}else{ 
						echo esc_attr($post_price); 
					}
					?>
				</span>
				<?php }else{ ?>
				<span class="price visible-xs">
				<?php esc_html_e('Price', 'classiera'); ?> :
					<?php 
					if(is_numeric($post_old_price)){
						echo classiera_post_price_display($post_currency_tag, $post_old_price);
					}else{ 
						echo esc_attr($post_old_price); 
					}
					?>
				</span>
				<?php } ?>
				<h5><a href="<?php the_permalink(); ?>"><?php echo esc_html($theTitle); ?></a></h5>
				<div class="category">
					<span>
					<!-- <?php esc_html_e('Category', 'classiera'); ?> : --> 
					<?php classiera_Display_cat_level($post->ID);?>,
					</span>
					<?php $classieraLOC = get_post_meta( $post->ID, $locShownBy, true );?>
					<span class="location_list"><!-- <?php esc_html_e('Location', 'classiera'); ?> : --> 
						<a href="#"><?php echo esc_attr($classieraLOC); ?></a>
					</span>
					<?php 
					$origin = new DateTime();
					$target = new DateTime($theDate);
					$interval = $origin->diff($target);
					$date_diff = $interval->format('%R%a');
					?>
					<span class="classiera-time">
						<?php 
							if($date_diff == 0){
								echo "Today "; echo $theTime;
							}elseif($date_diff == -1){
								echo "Yesterday "; echo $theTime;
							}else{
								echo $theDate.' ';
								echo $theTime;
							}
						?>	
					</span>
				</div>
				<p class="description"><?php echo substr(get_the_excerpt(), 0,260); ?></p>
			</figcaption>
		</figure>
	</div><!--row-->
</div><!--col-lg-4-->