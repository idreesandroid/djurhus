<?php 
	global $redux_demo;
	$classieraLocationName = 'post_location';
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraLocationType = $redux_demo['classiera_search_location_type'];
	$classiera_remove_ajax = $redux_demo['classiera_remove_ajax'];
	$locShownBy = $redux_demo['location-shown-by'];
	if($locShownBy == 'post_location'){
		$classieraLocationName = 'post_location';
	}elseif($locShownBy == 'post_state'){
		$classieraLocationName = 'post_state';
	}elseif($locShownBy == 'post_city'){
		$classieraLocationName = 'post_city';
	}
	
	$keyword = $_GET['s'];
	if(isset($_GET['post_state'])){
		$state_namee = $_GET['post_state'];
	}
	if($_GET['post_state'] == 1298){
		$_GET['post_state'] = 'Whole Sweden';
	}
	
?>
<section class="search-section search-section-v6">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form data-toggle="validator" role="form" class="search-form search-form-v2 form-inline" action="<?php echo esc_url(home_url()); ?>" method="get">
					<div class="form-v6-bg">
						<div class="form-group clearfix">
							<div class="inner-addon left-addon right-addon">
								<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-sort-amount-desc"></i>
								<i class="form-icon form-icon-size-small fas fa-sort"></i>
								<select class="form-control form-control-lg" data-placeholder="<?php esc_attr_e('Select Category..', 'classiera'); ?>" name="category_name" id="ajaxSelectCat">
									<option value="" selected><?php esc_html_e('All Categories', 'classiera'); ?></option>
									<?php 
									$args = array(
										'hierarchical' => '0',
										'hide_empty' => '0'
									);
									$categories = get_categories($args);
									foreach ($categories as $cat) {
										if($cat->category_parent == 0){
											$catID = $cat->cat_ID;
											?>
										<option value="<?php echo esc_attr($cat->slug); ?>">
											<?php echo esc_html($cat->cat_name); ?>
										</option>	
											<?php
											$args2 = array(
												'hide_empty' => '0',
												'parent' => $catID
											);
											$categories = get_categories($args2);
											foreach($categories as $cat){
												?>
											<option value="<?php echo esc_attr($cat->slug); ?>">- 
												<?php echo esc_html($cat->cat_name); ?>
											</option>	
												<?php
											}
										}
									}
									?>
								</select>
							</div>
						</div><!--form-group-->
						<div class="form-group classieraAjaxInput">
							<div class="input-group inner-addon left-addon">
								<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-border-color"></i>
								<input type="text" <?php if($classiera_remove_ajax == 1){ ?>id="classieraSearchAJax" <?php } ?> value="<?php if($keyword != ''){ echo $keyword; } ?>" name="s" class="form-control form-control-lg" placeholder="<?php esc_attr_e( 'Enter title or keyword...', 'classiera' ); ?>" data-error="<?php esc_attr_e( 'Please Type some words..!', 'classiera' ); ?>">
								<div class="help-block with-errors"></div>
								<span class="classieraSearchLoader"><img src="<?php echo esc_url(get_template_directory_uri()).'/images/loader.gif' ?>" alt="classiera loader"></span>
								<div class="classieraAjaxResult"></div>
							</div>
						</div><!--form-group-->
						<!--Locations-->
						<?php if($classieraLocationSearch == 1){?>
						<div class="form-group">
							<div class="input-group inner-addon left-addon">
								<i class="form-icon form-icon-size-small left-form-icon zmdi zmdi-pin-drop"></i>
								<?php if($classieraLocationType == 'input'):?>
								<input type="text" id="getCity" name="<?php echo esc_attr($classieraLocationName); ?>" class="form-control form-control-lg" placeholder="<?php esc_attr_e('Please type your location', 'classiera'); ?>">
								<a id="getLocation" href="#" class="form-icon form-icon-size-small" title="<?php esc_attr_e('Click here to get your own location', 'classiera'); ?>">
									<i class="fas fa-crosshairs"></i>
								</a>
								<?php elseif($classieraLocationType == 'dropdown'):?>
								<!--Locations dropdown-->	
									<?php get_template_part( 'templates/classiera-locations-dropdown' );?>
									<!--Locations dropdown-->
								<?php endif; ?>
							</div>
						</div>
						<?php } ?>
						<!--Locations-->
						<input type="hidden" class="classiera_nonce" value="<?php echo wp_create_nonce( 'classiera_nonce' ); ?>">
						<div class="form-group">
							<button type="submit" name="search" value="<?php esc_attr_e( 'Find ads', 'classiera' ); ?>"><?php esc_html_e( 'Find ads', 'classiera' ); ?></button>
						</div><!--form-group-->
					</div><!--form-v6-bg-->
				</form>
			</div><!--col-md-12-->
		</div><!--row-->
	</div><!--container-->
</section><!--search-section-->