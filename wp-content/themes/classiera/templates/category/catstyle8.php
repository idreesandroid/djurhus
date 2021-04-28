<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";	
	$classieraCatIconCode = '';
	$classieraCatIcoIMG = '';
	$classieraCatIconClr = '';
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = classiera_get_template_url('template-all-categories.php');
	$cat_counter = $redux_demo['home-cat-counter'];
	$primaryColor = $redux_demo['color-primary'];
	$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
	$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
?>
<section class="section-pad classiera-category-new">
	<?php if(!empty($classieraCatSECTitle)){ ?>
	<div class="section-heading-v1">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 center-block">
					<h3 class="text-uppercase"><?php echo esc_html($classieraCatSECTitle); ?></h3>
					<?php if(!empty($classieraCatSECDESC)){ ?>
					<p><?php echo esc_html($classieraCatSECDESC); ?></p>
					<?php } ?>
				</div>
			</div><!--row-->
		</div><!--container-->
	</div><!--section-heading-v1-->
	<?php } ?>
	<div class="container" style="overflow: hidden;">
		<div class="owl-carousel" data-car-length="6" data-items="7" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-auto-height="false" data-right="<?php if(is_rtl()){echo "true";}else{ echo "false";}?>" data-responsive-small="2" data-autoplay-hover="true" data-responsive-medium="4" data-responsive-xlarge="7" data-margin="10" data-rewind="false" data-slideby="1">
			<?php 
			$categories = get_terms('category', array(
					'hide_empty' => 0,
					'parent' => 0,
					'number' => $cat_counter,
					'order'=> 'ASC'
				)	
			);
			$current = -1;
			foreach ($categories as $category) {
				$tag = $category->term_id;
				$classieraCatFields = get_option(MY_CATEGORY_FIELDS);				
				if (isset($classieraCatFields[$tag])){					
					if(isset($classieraCatFields[$tag]['category_icon_code'])){
						$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
					}
					if(isset($classieraCatFields[$tag]['your_image_url'])){
						$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
					}
					if(isset($classieraCatFields[$tag]['category_icon_color'])){
						$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
					}
					if(isset($classieraCatFields[$tag]['category_image'])){
						$categoryIMG = $classieraCatFields[$tag]['category_image'];
					}
				}
				$catCount = $category->count;
				$catName = $category->term_id;
				$mainID = $catName;
				if(empty($classieraCatIconClr)){
					$iconColor = $primaryColor;
				}else{
					$iconColor = $classieraCatIconClr;
				}
				if(empty($categoryIMG)){
					$classieracatIMG = get_template_directory_uri().'/images/category.png';
				}else{
					$classieracatIMG = $categoryIMG;
				}	
				$current++;
				$allPosts = 0;
				$categoryLink = get_category_link( $category->term_id );
				$categories = get_categories('child_of='.$catName);
				foreach ($categories as $category) {
					$allPosts += $category->category_count;
				}
				$classieraTotalPosts = $allPosts + $catCount;
				$category_icon = stripslashes($classieraCatIconCode);
				?>
				<div class="item">
					<a class="category-box-v8" href="<?php echo esc_url($categoryLink); ?>">
						<div class="category-box-v8-img">
							<?php 
							if($classieraIconsStyle == 'icon'){
								?>
								<i class="<?php echo esc_html($category_icon); ?>"></i>
								<?php
							}elseif($classieraIconsStyle == 'img'){
								?>
								<img src="<?php echo esc_url($classieracatIMG); ?>" alt="<?php echo esc_html(get_cat_name( $catName )); ?>">
								<?php
							}
							?>
						</div>
						<h4><?php echo esc_html(get_cat_name( $catName )); ?></h4>
						<?php if($classieraPostCount == 1){?>
							<p>
							<?php echo esc_attr($catCount);?>&nbsp;
							<?php esc_html_e( 'Ads posted', 'classiera' ); ?>
							</p>
						<?php }?>
					</a>
				</div><!--item-->
			<?php } ?>
		</div>
	</div><!--container-->
	<div class="navText">				
		<a class="prev">
			<?php if(is_rtl()){?>
			<i class="icon-right fa fa-caret-square-o-right"></i>
			<?php }else{ ?>
			<i class="icon-left fa fa-caret-square-o-left"></i>
			<?php } ?>
		</a>
		<a class="next">
			<?php if(is_rtl()){?>
			<i class="icon-left fa fa-caret-square-o-left"></i>
			<?php }else{ ?>
			<i class="icon-right fa fa-caret-square-o-right"></i>
			<?php } ?>			
		</a>
	</div><!--navText-->
</section>