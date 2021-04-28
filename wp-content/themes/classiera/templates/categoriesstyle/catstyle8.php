<?php 
	global $redux_demo;
	$category_icon_code = "";
	$category_icon_color = "";
	$catIcon = "";
	$classieraCatSECTitle = $redux_demo['cat-sec-title'];
	$classieraCatSECDESC = $redux_demo['cat-sec-desc'];
	$allCatURL = classiera_get_template_url('template-all-categories.php');	
	$cat_counter = $redux_demo['classiera_no_of_cats_all_page'];
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
	<div class="container">
		<div class="row">
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
				//print_r($classieraCatFields);
				if (isset($classieraCatFields[$tag])){
					$classieraCatIconCode = $classieraCatFields[$tag]['category_icon_code'];
					$classieraCatIcoIMG = $classieraCatFields[$tag]['your_image_url'];
					$classieraCatIconClr = $classieraCatFields[$tag]['category_icon_color'];
					$categoryIMG = $classieraCatFields[$tag]['category_image'];
				}
				$cat = $category->count;
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
					$allPosts = $category->category_count;
				}
				$classieraTotalPosts = $allPosts + $cat;
				$category_icon = stripslashes($classieraCatIconCode);
				?>
				<div class="col-lg-2 col-sm-3 col-md-2">
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
							<?php echo esc_attr($classieraTotalPosts);?>&nbsp;
							<?php esc_html_e( 'Ads posted', 'classiera' ); ?>
							</p>
						<?php }?>
					</a>
				</div>
				<?php } ?>
		</div><!--row-->
	</div><!--container-->
</section>