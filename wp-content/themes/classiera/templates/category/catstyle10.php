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
<section class="minimal_page_category classiera-category-new-v2">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 center-auto">
				<div class="classiera-category-content">
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
					<a href="<?php echo esc_url($categoryLink); ?>" class="classiera-category-new-v2-box">
						<span class="classiera-category-new-v2-box-img">
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
						</span>
						<h5 class="classiera-category-new-v2-box-title">
							<?php echo esc_html(get_cat_name( $catName )); ?>
						</h5>
					</a>
					<?php } ?>
				</div><!--classiera-category-content-->
			</div><!--col-lg-12-->
		</div><!--row-->
	</div><!--container-->
</section><!-- /.category new -->