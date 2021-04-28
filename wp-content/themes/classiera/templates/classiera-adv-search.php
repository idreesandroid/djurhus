<?php 
	global $redux_demo;
	$classieraPriceRange = $redux_demo['classiera_pricerange_on_off'];
	$classieraPriceRangeStyle = $redux_demo['classiera_pricerange_style'];
	$postCurrency = $redux_demo['classierapostcurrency'];
	$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
	$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
	$classieraMaxPrice = $redux_demo['classiera_max_price_input'];
	$classieraLocationSearch = $redux_demo['classiera_search_location_on_off'];
	$classieraItemCondation = $redux_demo['adpost-condition'];
	$locationsStateOn = $redux_demo['location_states_on'];
	$classiera_ads_type = false;
	$classiera_locations_input = 'input';
	if(isset($redux_demo)){
		$classiera_ads_type = $redux_demo['classiera_ads_type'];
		$classiera_locations_input = $redux_demo['classiera_locations_input'];
	}		
	$locationsCityOn= $redux_demo['location_city_on'];
	if($classieraMultiCurrency == 'multi'){
		$classieraPriceTagForSearch = classiera_Display_currency_sign($classieraTagDefault);
	}elseif(!empty($postCurrency) && $classieraMultiCurrency == 'single'){
		$classieraPriceTagForSearch = $postCurrency;
	}
	$adsTypeShow = $redux_demo['classiera_ads_type_show'];
	$classieraShowSell = $adsTypeShow[1];
	$classieraShowBuy = $adsTypeShow[2];
	$classieraShowRent = $adsTypeShow[3];
	$classieraShowHire = $adsTypeShow[4];
	$classieraShowFound = $adsTypeShow[5];
	$classieraShowFree = $adsTypeShow[6];
	$classieraShowEvent = $adsTypeShow[7];
	$classieraShowServices = $adsTypeShow[8];
	
	
	$keyword = $_GET['s'];
	if(isset($_GET['post_state'])){
		$state_namee = $_GET['post_state'];
	}
	if($_GET['post_state'] == 1298){
		$_GET['post_state'] = 'Whole Sweden';
	}
	if(isset($_GET['category_name'])){
		$main_cat_name = $_GET['category_name'];
	}


?>
<!--SearchForm-->
<form method="get" action="<?php echo esc_url(home_url()); ?>">
	<div class="search-form border">
		<div class="search-form-main-heading">
			<a href="#innerSearch" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="innerSearch">
				<i class="fas fa-sync-alt"></i>
				<?php esc_html_e( 'Advanced Search', 'classiera' ); ?>
			</a>
		</div><!--search-form-main-heading-->
		<div id="innerSearch" class="collapse in classiera__inner">
			<!--Price Range-->
			<?php if($classieraPriceRange == 1){?>
			<div class="inner-search-box">
				<h5 class="inner-search-heading">
					<span class="currency__symbol">
					<?php 
					if (!empty($postCurrency) && $classieraMultiCurrency == 'single'){
						echo esc_attr($postCurrency);
						$currencySign = $postCurrency;
					}elseif($classieraMultiCurrency == 'multi'){
						echo classiera_Display_currency_sign($classieraTagDefault);
						$currencySign = classiera_Display_currency_sign($classieraTagDefault);
					}else{
						echo "&dollar;";
						$currencySign = "&dollar;";
					}
					?>	
					</span>
				<?php esc_html_e( 'Price Range', 'classiera' ); ?>
				</h5>
				<?php if($classieraPriceRangeStyle == 'slider'){?>
					<?php 
					$startPrice = $classieraMaxPrice*10/100; 
					$secondPrice = $startPrice+$startPrice; 
					$thirdPrice = $startPrice+$secondPrice; 
					$fourthPrice = $startPrice+$thirdPrice; 
					$fivePrice = $startPrice+$fourthPrice; 
					$sixPrice = $startPrice+$fivePrice; 
					$sevenPrice = $startPrice+$sixPrice; 
					$eightPrice = $startPrice+$sevenPrice; 
					$ninePrice = $startPrice+$eightPrice; 
					$tenPrice = $startPrice+$ninePrice;
					?>
					<div class="radio">
						<!--PriceFirst-->
						<input id="price-range-1" type="radio" value="<?php echo "0,".$startPrice; ?>" name="price_range">
						<label for="price-range-1">
							0&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($startPrice); ?>
						</label>
						<!--PriceSecond-->
						<input id="price-range-2" type="radio" value="<?php echo esc_attr($startPrice).','.esc_attr($secondPrice); ?>" name="price_range">
						<label for="price-range-2">
							<?php echo esc_attr($startPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($secondPrice); ?>
						</label>
						<!--PriceThird-->
						<input id="price-range-3" type="radio" value="<?php echo esc_attr($secondPrice).','.esc_attr($thirdPrice); ?>" name="price_range">
						<label for="price-range-3">
							<?php echo esc_attr($secondPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($thirdPrice); ?>
						</label>
						<!--PriceFourth-->
						<input id="price-range-4" type="radio" value="<?php echo esc_attr($thirdPrice).','.esc_attr($fourthPrice); ?>" name="price_range">
						<label for="price-range-4">
							<?php echo esc_attr($thirdPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($fourthPrice); ?>
						</label>
						<!--PriceFive-->
						<input id="price-range-5" type="radio" value="<?php echo esc_attr($fourthPrice).','.esc_attr($fivePrice); ?>" name="price_range">
						<label for="price-range-5">
							<?php echo esc_attr($fourthPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($fivePrice); ?>
						</label>
						<!--PriceSix-->
						<input id="price-range-6" type="radio" value="<?php echo esc_attr($fivePrice).','.esc_attr($sixPrice); ?>" name="price_range">
						<label for="price-range-6">
							<?php echo esc_attr($fivePrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($sixPrice); ?>
						</label>
						<!--PriceSeven-->
						<input id="price-range-7" type="radio" value="<?php echo esc_attr($sixPrice).','.esc_attr($sevenPrice); ?>" name="price_range">
						<label for="price-range-7">
							<?php echo esc_attr($sixPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($sevenPrice); ?>
						</label>
						<!--PriceEight-->
						<input id="price-range-8" type="radio" value="<?php echo esc_attr($sevenPrice).','.esc_attr($eightPrice); ?>" name="price_range">
						<label for="price-range-8">
							<?php echo esc_attr($sevenPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($eightPrice); ?>
						</label>
						<!--PriceNine-->
						<input id="price-range-9" type="radio" value="<?php echo esc_attr($eightPrice).','.esc_attr($ninePrice); ?>" name="price_range">
						<label for="price-range-9">
							<?php echo esc_attr($eightPrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($ninePrice); ?>
						</label>
						<!--Max Price-->
						 <input id="price-range-10" type="radio" value="<?php echo esc_attr($ninePrice).','.esc_attr($classieraMaxPrice); ?>" name="price_range">
						<label for="price-range-10">
							<?php echo esc_attr($ninePrice+1); ?>&nbsp;&ndash;&nbsp;
							<?php echo esc_attr($classieraMaxPrice); ?>
						</label>
					</div><!--radio-->
					<div class="classiera_price_slider">
						<p>
						  <label for="amount"><?php esc_html_e( 'Price range', 'classiera' ); ?>:</label>
						  <input data-cursign="<?php echo sprintf($currencySign); ?>" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
						</p>					 
						<div id="slider-range"></div>
						<input type="hidden" id="classieraMaxPrice" value="<?php echo esc_attr($classieraMaxPrice); ?>">
						<input type="hidden" id="range-first-val" name="search_min_price" value="">
						<input type="hidden" id="range-second-val" name="search_max_price" value="">
					</div>					
					
				<?php }else{?>
					<!--Price Range input-->
					<div class="inner-addon right-addon">
						<input type="text" name="search_min_price" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Min price', 'classiera' ); ?>">
					</div>
					<div class="inner-addon right-addon">
						<input type="text" name="search_max_price" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Max price', 'classiera' ); ?>">
					</div>
					<!--Price Range input-->
				<?php } ?>
			</div>
			<?php } ?>
			<!--Price Range-->
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="fas fa-tag"></i>
				<?php esc_html_e( 'Keywords', 'classiera' ); ?>
				</h5>
				<div class="inner-addon right-addon">
					<i class="right-addon form-icon fas fa-search"></i>
					<input type="search" value="<?php if($keyword != ''){ echo $keyword; } ?>" name="s" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter Keyword', 'classiera' ); ?>">
				</div>
			</div><!--Keywords-->
			<!--Locations-->
			<?php if($classieraLocationSearch == 1){?>
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="fas fa-map-marker-alt"></i>
				<?php esc_html_e( 'Location', 'classiera' ); ?>
				</h5>
				<!--SelectCountry-->
				<?php
				$args = array(
					'post_type' => 'countries',
					'posts_per_page'   => -1,
					'orderby'          => 'title',
					'order'            => 'ASC',
					'post_status'      => 'publish',
					'suppress_filters' => false 
				);
				$country = get_posts($args);
				if(!empty($country)){
				?>
				<div class="inner-addon right-addon hidden">
					<i class="right-addon form-icon fas fa-sort"></i>
					<select name="post_location" class="form-control form-control-sm" id="post_location">
						<option value="-1" selected disabled>
							<?php esc_html_e('Select Country', 'classiera'); ?>
						</option>
						<?php foreach( $country as $singleCountry ){?>
						<option value="<?php echo esc_attr($singleCountry->ID); ?>">
							<?php echo esc_html($singleCountry->post_title); ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<?php } ?>
				 <?php wp_reset_postdata(); ?>
				<!--SelectCountry-->
				<!--Select State-->
				<?php 
				$args = array(
					'post_type' => 'states',
					'posts_per_page'   => -1,
					'orderby'          => 'title',
					'order'            => 'ASC',
					'post_status'      => 'publish',
					'suppress_filters' => false 
				);
				$state_posts = get_posts($args);
				$statesList = "";
				if(!empty($state_posts)){		
					foreach( $state_posts as $state_post ){
						$state = $state_post->ID;					
						$statesList .= get_post_meta($state, "classiera-all-states", true).",";				
					}
				}	
				$singleState = explode(",", $statesList);
				 	if($locationsStateOn == 1){?>
					<?php if($classiera_locations_input == 'input'){ ?>
					<div class="inner-addon right-addon">
						<i class="right-addon form-icon fas fa-globe"></i>
						<input type="text" name="post_state" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your state name.', 'classiera' ); ?>">
					</div>
					<?php }else{ ?>
					<div class="inner-addon right-addon post_sub_loc">
						<i class="right-addon form-icon fas fa-sort"></i>
						<select name="post_state" class="form-control form-control-sm" id="post_state">
							 <option value="<?php if($_GET['post_state'] != '' && $_GET['post_state'] != 'Whole Sweden'){ echo $_GET['post_state'];}elseif($_GET['post_state'] == 'Whole Sweden'){ echo "1298";} ?>" <?php if($_GET['post_state'] != ''){ echo "selected";} ?>><?php echo esc_attr($_GET['post_state']); ?></option> 
							 	<?php if($_GET['post_state'] != 'Whole Sweden'){ ?>
							 	<option value="1298"><?php esc_html_e('Whole Sweden', 'classiera'); ?></option>
								<?php } ?>
							<?php if(!empty($singleState)){
								foreach( $singleState as $state_post ){
									if(!empty($state_post)){
										$state_ops .= '<option value="'.$state_post.'">'.$state_post."</option>";
									}
								}
							} ?>
							<?php echo $state_ops; ?>
						</select>
					</div>
					<?php } ?>
				<?php } ?>
				<!--Select State-->
				<!--Select City-->
				<?php if($locationsCityOn == 1){?>
					<?php if($classiera_locations_input == 'input'){ ?>
						<div class="inner-addon right-addon">
							<i class="right-addon form-icon fas fa-globe"></i>
							<input type="text" name="post_city" class="form-control form-control-sm" placeholder="<?php esc_attr_e( 'Enter your city name.', 'classiera' ); ?>">
						</div>
					<?php }else{ ?>
					<div class="inner-addon right-addon post_sub_loc">
						<i class="right-addon form-icon fas fa-sort"></i>
						<select name="post_city" class="form-control form-control-sm" id="post_city">
							<option value=""><?php esc_html_e('Select Muncipality', 'classiera'); ?></option>
						</select>
					</div>
					<?php } ?>
				<?php } ?>
				<!--Select City-->
			</div>
			<?php } ?>
			<!--Locations-->
			<!--Categories-->
			<div class="inner-search-box">
				<h5 class="inner-search-heading"><i class="far fa-folder-open"></i>
				<?php esc_html_e( 'Categories', 'classiera' ); ?>
				</h5>
				<!--SelectCategory-->
				<div class="inner-addon right-addon">
					<i class="right-addon form-icon fas fa-sort"></i>
					<select name="category_name" class="form-control form-control-sm" id="main_cat">
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
								<option value="<?php echo esc_attr($cat->slug); ?>" <?php if($_GET['category_name'] == $cat->slug){ echo "selected"; }?>>
									<?php echo esc_html($cat->cat_name); ?>
								</option>
							<?php	}
							}
            				// 		$args = array(												
            				// 		'show_option_none' => esc_html__( 'Select category', 'classiera' ),
            				// 		'show_count' => 0,
            				// 		'orderby' => 'name',											  
            				// 		'selected' => -1,
            				// 		'depth' => 1,
            				// 		'hierarchical' => 1,						  
            				// 		'hide_if_empty'  => false,
            				// 		'hide_empty' => 0,
            				// 		'name' => 'category_name',
            				// 		'parent' => 0,
            				// 		'value_field' => 'slug',
            				// 		'id' => 'main_cat',
            				// 		'class' => 'form-control form-control-sm',
            				// 		'disabled' => '',
            				// 	);
            				// 	wp_dropdown_categories($args);
						?>
						
					</select>
					
				</div>
				<!--Select Sub Category-->
				<div class="inner-addon right-addon classiera_adv_subcat">
					<i class="right-addon form-icon fas fa-sort"></i>
					<select name="sub_cat" class="form-control form-control-sm" id="sub_cat" disabled="disabled">
					</select>
				</div>
				<!--Third Level Category-->
				<div class="inner-addon right-addon classiera_adv_subsubcat">
					<i class="right-addon form-icon fas fa-sort"></i>
					<select name="sub_sub_cat" class="form-control form-control-sm" id="sub_sub_cat" disabled="disabled">
					</select>
				</div>
				<!--Third Level Category-->
				<!--CustomFields-->
				<div class="classiera_adv_cf_fields"></div>
				<!--CustomFields-->				
				<!--Item Condition-->
				<?php if($classieraItemCondation == 1){ ?>
				<div class="inner-search-box-child">
					<p><?php esc_html_e( 'Select Condition', 'classiera' ); ?></p>
					<div class="radio">
						<input id="use-all" type="radio" name="item-condition" value="All" checked>
						<label for="use-all"><?php esc_html_e( 'All', 'classiera' ); ?></label>
						<input id="new" type="radio" name="item-condition" value="<?php esc_attr_e('New', 'classiera') ?>">
						<label for="new"><?php esc_html_e( 'New', 'classiera' ); ?></label>
						<input id="used" type="radio" name="item-condition" value="<?php esc_attr_e('Used', 'classiera') ?>">
						<label for="used"><?php esc_html_e( 'Used', 'classiera' ); ?></label>
					</div>
				</div>
				<?php } ?>
				<!--Item Condition-->
				<!--Select Ads Type-->
				<?php if($classiera_ads_type == 1){?>
				<div class="inner-search-box-child">
					<p><?php esc_html_e( 'Type of Ad', 'classiera' ); ?></p>
					<div class="radio">
						<input id="type_all" type="radio" name="classiera_ads_type" value="All" checked>
						<label for="type_all"><?php esc_html_e( 'All', 'classiera' ); ?></label>
						<?php if($classieraShowSell == 1){ ?>
							<input id="sell" type="radio" name="classiera_ads_type" value="sell">
							<label for="sell"><?php esc_html_e( 'For Sale', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowBuy == 1){ ?>
							<input id="buy" type="radio" name="classiera_ads_type" value="buy">
							<label for="buy"><?php esc_html_e( 'Wanted', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowRent == 1){ ?>
							<input id="rent" type="radio" name="classiera_ads_type" value="rent">
							<label for="rent"><?php esc_html_e( 'For Rent', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowHire == 1){ ?>
							<input id="hire" type="radio" name="classiera_ads_type" value="hire">
							<label for="hire"><?php esc_html_e( 'For hire', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowFound == 1){ ?>
							<input id="lostfound" type="radio" name="classiera_ads_type" value="lostfound">
							<label for="lostfound"><?php esc_html_e( 'Lost & Found', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowFree == 1){ ?>
							<input id="typefree" type="radio" name="classiera_ads_type" value="free">
							<label for="typefree"><?php esc_html_e( 'Free', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowEvent == 1){ ?>
							<input id="event" type="radio" name="classiera_ads_type" value="event">
							<label for="event"><?php esc_html_e( 'Event', 'classiera' ); ?></label>
						<?php } ?>
						<?php if($classieraShowServices == 1){ ?>
							<input id="service" type="radio" name="classiera_ads_type" value="service">
							<label for="service"><?php esc_html_e( 'Professional service', 'classiera' ); ?></label>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<!--Select Ads Type-->
			</div><!--inner-search-box-->
			<button type="submit" name="search" class="btn btn-primary sharp btn-sm btn-style-one btn-block" value="<?php esc_attr_e( 'Search', 'classiera') ?>"><?php esc_html_e( 'Search', 'classiera') ?></button>
		</div><!--innerSearch-->
	</div><!--search-form-->
</form>
<!--SearchForm-->