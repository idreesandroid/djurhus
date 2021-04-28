<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */

get_header(); ?>
<?php 
// Retrieve the URL variables (using PHP).
	global $redux_demo, $wpdb;
	$catSearchID = "";
	$minPrice = "";
	$maxPrice = "";
	$search_state = "";
	$search_country = "";
	$search_city = "";
	$main_cat = "";
	$sub_cat = "";
	$price_range = "";
	$searchQueryCountry = "";
	$searchQueryState = "";
	$classieraAdsTypeSearch = "";
	$searchCondition = "";
	$searchQueryCustomFields = "";
	$emptyPost = 0;
	$featuredPosts = array();
	$searchQueryPrice = null;	
	$searchQueryCity = null;
	$searchQueryloc = null;
	$classiera_ads_typeOn = false;	
	$classieraGoogleMAP = false;	
	$classieraMAPDragging = false;
	$classieraMAPScroll = false;
	$classieraIconsStyle = 'icon';	
	$classieraAdsView = 'list';	
	$classiera_pagination = 'pagination';	
	$classieraMultiCurrency = 'single';	
	$postCurrency = '$';	
	$classieraSearchStyle = 1;
	$mapMaxPostCount = 100;
	$featuredMaxPostCount = 20;
	$classieraCategoriesStyle = 1;
	if(isset($redux_demo)){
		$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
		$classieraSearchStyle = $redux_demo['classiera_search_style'];	
		$classieraGoogleMAP = $redux_demo['classiera_map_on_search'];
		$classieraMAPPostType = $redux_demo['classiera_map_post_type'];	
		$mapMaxPostCount = $redux_demo['classiera_search_map_max_post'];	
		$featuredMaxPostCount = $redux_demo['classiera_search_max_post'];	
		$classieraMAPStyle = $redux_demo['map-style'];	
		$locShownBy = $redux_demo['location-shown-by'];		
		$classieraCurrencyTag = $redux_demo['classierapostcurrency'];
		$classieraIconsStyle = $redux_demo['classiera_cat_icon_img'];
		$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];	
		$classieraAdsView = $redux_demo['home-ads-view'];
		$classiera_pagination = $redux_demo['classiera_pagination'];
		$classieraTagDefault = $redux_demo['classiera_multi_currency_default'];
		$classieraMultiCurrency = $redux_demo['classiera_multi_currency'];
		$postCurrency = $redux_demo['classierapostcurrency'];
		$classieraMAPDragging = $redux_demo['classiera_map_dragging'];	
		$classieraMAPScroll = $redux_demo['classiera_map_scroll'];
	}	
	if($classiera_ads_typeOn == 1){
		$adstypeQuery = array(
			'key' => 'classiera_ads_type',
			'value' => 'sold',
			'compare' => '!='
		);
	}else{
		$adstypeQuery = null;
	}
	if($classieraMultiCurrency == 'multi'){
		$classieraPriceTagForSearch = classiera_Display_currency_sign($classieraTagDefault);
	}elseif(!empty($postCurrency) && $classieraMultiCurrency == 'single'){
		$classieraPriceTagForSearch = $postCurrency;
	}
	$classieraItemClass = "item-grid";
	if($classieraAdsView == 'list'){
		$classieraItemClass = "item-list";
	}	
	$keyword = $_GET['s'];
	if(isset($_GET['custom_fields'])){
		$custom_fields = $_GET['custom_fields'];
		$searchQueryCustomFields = classiera_CF_search_Query($custom_fields);
	}
	if(isset($_GET['sub_cat'])){
		$sub_cat = $_GET['sub_cat'];
	}
	if(isset($_GET['sub_sub_cat'])){
		$sub_sub_cat = $_GET['sub_sub_cat'];
	}
	if(isset($_GET['category_name'])){
		$main_cat = $_GET['category_name'];
	}	
	if(isset($_GET['search_min_price'])){
		$minPrice = $_GET['search_min_price'];
	}
	if(isset($_GET['search_max_price'])){
		$maxPrice = $_GET['search_max_price'];
		if(empty($minPrice)){
			$minPrice = '1';
		}
	}
	if(isset($_GET['price_range'])){
		$price_range = $_GET['price_range'];
	}	
	if(empty($maxPrice)){
		$string = $price_range;
	}else{
		$string = $minPrice.','.$maxPrice;
	}	
	$priceArray = explode(',', $string);
	if(isset($_GET['search_min_price']) || isset($_GET['price_range'])){
		if(isset($_GET['price_range']) && $_GET['price_range'] != ''){
			if(function_exists('classiera_Price_search_Query')){
				$searchQueryPrice = classiera_Price_search_Query($priceArray);
			}
		}
		if(isset($_GET['search_min_price']) || $_GET['search_max_price'] != ''){
			if(function_exists('classiera_Price_search_Query')){
				$searchQueryPrice = classiera_Price_search_Query($priceArray);
			}
		}
	}	
	if(isset($_GET['post_location'])){
		$country = $_GET['post_location'];
		if(function_exists('classiera_location_query')){
			$searchQueryloc = classiera_location_query($country);
		}				
	}	
	if(isset($_GET['post_state'])){
		$state = $_GET['post_state'];
		if(function_exists('classiera_location_query')){
			$searchQueryloc = classiera_location_query($state);
		}	
	}	
	if(isset($_GET['post_city'])){
		$city = $_GET['post_city'];
		if(function_exists('classiera_location_query')){
			$searchQueryloc = classiera_location_query($city);
		}		
	}
	if(isset($_GET['item-condition'])){
		$search_condition = $_GET['item-condition'];
		if(function_exists('classiera_Condition_search_Query')){
			$searchCondition = classiera_Condition_search_Query($search_condition);
		}		
	}
	if(isset($_GET['classiera_ads_type'])){
		$classieraAdsType = $_GET['classiera_ads_type'];
		if(function_exists('classiera_adstype_search_Query')){
			$classieraAdsTypeSearch = classiera_adstype_search_Query($classieraAdsType);
		}		
	}
	if(empty($sub_sub_cat) || $sub_sub_cat == '-1'){
		$category_name = $sub_cat;
	}else{
		$category_name = $sub_sub_cat;
	}
	if(empty($category_name) || $category_name == '-1'){
		$category_name = $main_cat;
	}		
	if(!empty($category_name)){
		if($category_name != "All" && $category_name != "-1") {
			$catSearchID = $category_name;				
		}else{
			$catSearchID = '';
		}
	}
	$iconPath = '';
	//Google MAP
	//Google MAP
	//Search Styles//
	if($classieraSearchStyle == 1){
		get_template_part( 'templates/searchbar/searchstyle1' );
	}elseif($classieraSearchStyle == 2){
		get_template_part( 'templates/searchbar/searchstyle2' );
	}elseif($classieraSearchStyle == 3){
		get_template_part( 'templates/searchbar/searchstyle3' );
	}elseif($classieraSearchStyle == 4){
		get_template_part( 'templates/searchbar/searchstyle4' );
	}elseif($classieraSearchStyle == 5){
		get_template_part( 'templates/searchbar/searchstyle5' );
	}elseif($classieraSearchStyle == 6){
		get_template_part( 'templates/searchbar/searchstyle6' );
	}elseif($classieraSearchStyle == 7){
		get_template_part( 'templates/searchbar/searchstyle7' );
	}

	$current_user = wp_get_current_user();
	$userID = $current_user->ID;
	
	if(isset($_POST['submit_save_search'])){
		$search_keyword = $_POST['search_keyword'];
		$search_state = $_POST['search_state'];
		$category_names = $_POST['category_namess'];
		if(empty($category_names) || $category_names == '-1'){
			$category_names = $main_cat;
		}

		$wpdb->insert('saved_search', array(
				'user_id' => $userID,
		    'saved_query' => $search_keyword,
		    'saved_state' => $search_state,
		    'category_name' => $category_names,
		)); 
		?>
		
		<script>
			window.location.href = "saved-search/";
		</script>
		
		
	<?php }

	$results = $wpdb->get_results( "SELECT * FROM saved_search where user_id=$userID and saved_query='$keyword'"); 
	if(!empty($results))                        
	{
		$query_user_id = $results[0]->user_id;
		$query_keyword = $results[0]->saved_query;
		$query_category_name = $results[0]->category_name;
	}


?>
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php get_template_part( 'templates/classiera-adv-search' );?>
			</div><!--col-lg-3 col-md-4-->
			<!--EndSidebar-->
			<!--ContentArea-->
			<div class="col-lg-9 col-md-8">
				<?php if($classieraCategoriesStyle == 1){?>
					<section class="classiera-advertisement advertisement-v1">
						<div class="tab-divs section-light-bg">
							<!--ViewHead-->
							<div class="view-head">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;								
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryloc,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
										<div class="col-lg-5 col-sm-5 col-xs-8">
											<div class="total-post">
												<p> <?php echo esc_attr($count); ?>
												<?php esc_html_e( 'ads found', 'classiera') ?> : 
												<span>
													<?php esc_html_e( 'related to your search', 'classiera') ?>
												</span>
											</p>
										</div>
									</div>
									<div class="col-lg-2 col-sm-2 col-xs-4">
										<div class="total-post">
											<p> 
											<span id="view_map" style="cursor: pointer">
												<i class="fas fa-map-marker-alt"></i> <?php esc_html_e( 'View on map', 'classiera') ?>
											</span>
											</p>
										</div>
									</div>
									<div class="col-lg-2 col-sm-2 col-xs-12">
										<form method="post">
											<?php if ( is_user_logged_in() ) { ?>
											<div class="total-post">
												<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $_GET['s']; ?>">
												<input type="hidden" id="search_state" name="search_state" value="<?php echo $_GET['post_state']; ?>">
												<input type="hidden" id="category_namess" name="category_namess" value="<?php if(isset($_GET['category_name'])){ echo $_GET['category_name']; }?>">
												<?php if(!empty($results)) { if($query_user_id == $userID && $query_keyword == $_GET['s']){ ?>
													<button type="button" class="btn btn-primary sharp btn-sm btn-style-one" disabled><i class="fas fa-heart" style="color: #d32323;"></i> Save Search</button>
												<?php }}else{ ?>
													<button type="submit" name="submit_save_search" id="save_search" class="btn btn-primary sharp btn-sm btn-style-one"><i class="fas fa-heart"></i> Save Search</button>
												<?php } ?>
											</div>
											<?php } ?>
										</form>
									</div>
									<div class="col-lg-3 col-sm-3 col-xs-3 hidden-xs">
										<div class="view-as text-right flip">
											<span><?php esc_html_e( 'View as', 'classiera') ?>:</span>
											<a id="grid" class="grid btn btn-sm sharp outline <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list btn btn-sm sharp outline <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-bars"></i></a>
										</div>
									</div>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
								</div>
							</div>
						</div>
						<!--ViewHead-->
						<div class="tab-content">
							<?php	if($classieraGoogleMAP == true){
							?>
							<section id="classiera_map" style="display: none;margin-bottom: 20px;">
								<div id="log" style="display:none;"></div>
								<input id="latitude" type="hidden" value="">
								<input id="longitude" type="hidden" value="">
								<!--Search on MAP-->
								<div class="classiera_map_search">
							        <div class="classiera_map_search_btn"><i class="fas fa-caret-right"></i></div>
							        <form method="get">
							            <div class="classiera_map_input-group">
							                <input id="classiera_map_address" type="text" placeholder="<?php esc_attr_e('Search ads by your Location', 'classiera'); ?>">
							            </div>    
							        </form>
							    </div>	
								<!--Search on MAP-->
								<div id="classiera_main_map" style="width:100%; height:600px;">
									<script type="text/javascript">			
										jQuery(document).ready(function(){
											var addressPoints = [
												<?php 
												global $paged, $wp_query, $wp;										
												$args = wp_parse_args($wp->matched_query);
												$temp = $wp_query;
												if($classieraMAPPostType == 'featured'){
													$args = array(
														'post_type' => 'post',
														'post_status' => 'publish',
														's'   => $keyword,
														'posts_per_page' => $mapMaxPostCount,	
														'category_name' => $catSearchID,
														'meta_query' => array(
															'relation' => 'AND',
															$searchQueryPrice,
															$searchQueryloc,
															$searchCondition,
															$classieraAdsTypeSearch,
															$searchQueryCustomFields,
															$adstypeQuery,
															array(
																'key' => 'featured_post',
																'value' => '1',
																'compare' => '=='
															)
														),
													);
												}else{
													$args = array(
														'post_type' => 'post',
														'post_status' => 'publish',
														's'   => $keyword,
														'posts_per_page' => $mapMaxPostCount,	
														'category_name' => $catSearchID,
														'meta_query' => array(
															'relation' => 'AND',
															$searchQueryPrice,
															$searchQueryloc,
															$searchCondition,
															$classieraAdsTypeSearch,
															$searchQueryCustomFields,
															$adstypeQuery,
														),
													);
												}					
												$wp_query= null;
												$wp_query = new WP_Query($args);
												while ($wp_query->have_posts()) : $wp_query->the_post();
													$category = get_the_category();						
													$catID = $category[0]->cat_ID;						
													if ($category[0]->category_parent == 0){							
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
													if(!empty($category_icon_code)){
														$category_icon = stripslashes($category_icon_code);
													}						
													$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
													$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
													$post_price = get_post_meta($post->ID, 'post_price', true);
													$post_phone = get_post_meta($post->ID, 'post_phone', true);
													$theTitle = get_the_title();
													$postCatgory = get_the_category( $post->ID );
													$postCurCat = $postCatgory[0]->name;
													$categoryLink = get_category_link($catID);
													$classieraPostAuthor = $post->post_author;
													$classieraAuthorEmail = get_the_author_meta('user_email', $classieraPostAuthor);
													$classiera_ads_type = get_post_meta($post->ID, 'classiera_ads_type', true);
													$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
													if(is_numeric($post_price)){
														$classieraPostPrice =  classiera_post_price_display($post_currency_tag, $post_price);
													}else{ 
														$classieraPostPrice =  $post_price; 
													}
													if( has_post_thumbnail()){
														$classieraIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'classiera-370');
														$classieraIMGURL = $classieraIMG[0];
													}else{
														$classieraIMGURL = get_template_directory_uri() . '/images/nothumb.png';
													}
													if(empty($classieraCatIcoIMG)){
														$iconPath = get_template_directory_uri() .'/images/icon-services.png';
													}else{
														$iconPath = $classieraCatIcoIMG;
													}
													
													
												if(!empty($post_latitude) && !empty($post_longitude)){
												$content = '<a class="classiera_map_div" href="'.get_the_permalink().'"><img class="classiera_map_div__img" src="'.$classieraIMGURL.'" alt="images"><div class="classiera_map_div__body"><p class="classiera_map_div__price">'.__( "Price", 'classiera').' : <span>'.$classieraPostPrice.'</span></p><h5 class="classiera_map_div__heading">'.get_the_title().'</h5><p class="classiera_map_div__cat">'.__( "Category", 'classiera').' : '.esc_attr($postCurCat).'</p></div></a>';
												?>
												
												[<?php echo esc_attr($post_latitude); ?>, <?php echo esc_attr($post_longitude); ?>, '<?php echo sprintf($content); ?>', "<?php echo esc_url($iconPath); ?>"],
												
												<?php 
												}
												endwhile;
												wp_reset_query();
												?>
											];
											var mapopts;
											if(window.matchMedia("(max-width: 1024px)").matches){
												var mapopts =  {
													dragging:false,
													tap:false,
												};					
											};
											var map = L.map('classiera_main_map', mapopts).setView([0,0],1);
											var roadMutant = L.gridLayer.googleMutant({
											<?php if($classieraMAPStyle){?>styles: <?php echo wp_kses_post($classieraMAPStyle); ?>,<?php }?>
												maxZoom: 20,
												type:'roadmap'
											}).addTo(map);
											var markers = L.markerClusterGroup({
												spiderfyOnMaxZoom: true,
												showCoverageOnHover: true,
												zoomToBoundsOnClick: true,
												maxClusterRadius: 10
											});
											markers.on('clusterclick', function(e) {
												map.setView(e.latlng, 13);				
											});			
											var markerArray = [];
											for (var i = 0; i < addressPoints.length; i++){
												var a = addressPoints[i];
												var newicon = new L.Icon({iconUrl: a[3],
													iconSize: [36, 51], // size of the icon
													iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
													popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
												});
												var title = a[2];
												var marker = L.marker(new L.LatLng(a[0], a[1]));
												marker.setIcon(newicon);
												marker.bindPopup(title, {minWidth:"400"});
												marker.title = title;
												//marker.on('click', function(e) {
													//map.setView(e.latlng, 13);
													
												//});				
												markers.addLayer(marker);
												markerArray.push(marker);
												if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
													var group = L.featureGroup(markerArray); //add markers array to featureGroup
													map.fitBounds(group.getBounds());   
												}
											}
											var circle;
											map.addLayer(markers);
											<?php 
											if($classieraMAPDragging == false){
												?>
												map.dragging.disable();					
												<?php
											}
											?>
											<?php 
											if($classieraMAPScroll == false){
												?>
												map.scrollWheelZoom.disable();
												<?php
											}
											?>
											function getLocation(){
												if(navigator.geolocation){
													navigator.geolocation.getCurrentPosition(showPosition);
												}else{
													x.innerHTML = "Geolocation is not supported by this browser.";
												}
											}
											function showPosition(position){					
												jQuery('#latitude').val(position.coords.latitude);
												jQuery('#longitude').val(position.coords.longitude);
												var latitude = jQuery('#latitude').val();
												var longitude = jQuery('#longitude').val();
												map.setView([latitude,longitude],13);
												circle = new L.circle([latitude, longitude], {radius: 2500}).addTo(map);
											}
											jQuery('#getLocation').on('click', function(e){
												e.preventDefault();
												getLocation();
											});
											//Search on MAP//
											var geocoder;
											function initialize(){
												geocoder = new google.maps.Geocoder();     
											}				
											jQuery("#classiera_map_address").autocomplete({
												  //This bit uses the geocoder to fetch address values					  
												source: function(request, response){
													geocoder = new google.maps.Geocoder();
													geocoder.geocode( {'address': request.term }, function(results, status) {
														response(jQuery.map(results, function(item) {
															return {
															  label:  item.formatted_address,
															  value: item.formatted_address,
															  latitude: item.geometry.location.lat(),
															  longitude: item.geometry.location.lng()
															}
														}));
													})
												},
												  //This bit is executed upon selection of an address
												select: function(event, ui) {
													jQuery("#latitude").val(ui.item.latitude);
													jQuery("#longitude").val(ui.item.longitude);
													var latitude = jQuery('#latitude').val();
													var longitude = jQuery('#longitude').val();
													map.setView([latitude,longitude],10);						
												}
											});
											//Search on MAP//
										});
									</script>
								</div>
							</section>
							<?php } ?>
							<div role="tabpanel" class="tab-pane fade in active" id="all">
								<div class="container">
									<div class="row">
										<?php
										global $paged, $wp_query, $wp;										
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => $featuredMaxPostCount,	
											'paged' => $paged,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryloc,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
												array(
													'key' => 'featured_post',
													'value' => '1',
													'compare' => '=='
												),
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$emptyPost++;
											$featuredPosts[] = $post->ID;
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile;
										wp_reset_query();
										wp_reset_postdata();
										?>
										<!--RegularAds-->
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}
										$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;										
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryloc,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
											),
										);										
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$emptyPost++;
											get_template_part( 'templates/classiera-loops/loop-lime');
										endwhile;
										?>
										<!--RegularAds-->
										<?php if(empty($emptyPost) || $emptyPost == 0){ ?>
											<div class="col-lg-12 col-md-12 col-sm-12 text-center">
												<h5><?php esc_html_e( 'No results found for the selected search criteria.', 'classiera' ); ?></h5>
											</div>
										<?php } ?>
									</div><!--row-->
									<?php
									if ( function_exists('classiera_pagination') ){
										classiera_pagination();
									}									  
									?>
								</div><!--container-->
								<?php
								if($classiera_pagination == 'infinite'){
									echo infinite($wp_query);
								}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content-->
					</div>
				</section>
				<!-- end advertisement style 1-->
			<?php }elseif($classieraCategoriesStyle == 2){?>
				<section class="classiera-advertisement advertisement-v2 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<div class="total-post">
											<?php 
											global $paged, $wp_query, $wp;								
											$args = wp_parse_args($wp->matched_query);
											$temp = $wp_query;
											$args = array(
												'post_type' => 'post',
												'post_status' => 'publish',
												's'   => $keyword,
												'posts_per_page' => -1,
												'category_name' => $catSearchID,
												'meta_query' => array(
													'relation' => 'AND',
													$searchQueryPrice,
													$searchQueryloc,
													$classieraAdsTypeSearch,
													$searchCondition,
													$searchQueryCustomFields,
													$adstypeQuery,
												),
											);
											$wp_query= null;
											$wp_query = new WP_Query($args);
											$count = $wp_query->post_count;
											?>
											<p> <?php echo esc_attr($count); ?>
											<?php esc_html_e( 'ads found', 'classiera') ?> : 
											<span>
												<?php esc_html_e( 'related to your search', 'classiera') ?>
											</span>
										</p>
										<?php wp_reset_query(); ?>
										<?php wp_reset_postdata(); ?>
									</div>
								</div><!--col-lg-6 col-sm-8-->
								<div class="col-lg-6 col-sm-4">
									<div class="view-as text-right flip">
										<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
										<div class="btn-group">
											<a id="grid" class="grid btn btn-primary radius btn-md <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list btn btn-primary btn-md radius <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>
										</div>
									</div>
								</div><!--col-lg-6 col-sm-4-->
							</div><!--row-->
						</div><!--container-->
					</div><!--view-head-->
					<div class="tab-content section-gray-bg">
						<div role="tabpanel" class="tab-pane fade in active" id="all">
							<div class="container">
								<div class="row">
									<?php
									global $paged, $wp_query, $wp;										
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ){
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
									$temp = $wp_query;										
									$args = array(
										'post_type' => 'post',
										'post_status' => 'publish',
										's'   => $keyword,
										'posts_per_page' => $featuredMaxPostCount,	
										'paged' => $paged,					
										'category_name' => $catSearchID,
										'meta_query' => array(
											'relation' => 'AND',
											$searchQueryPrice,
											$searchQueryloc,
											$searchCondition,
											$classieraAdsTypeSearch,
											$searchQueryCustomFields,
											$adstypeQuery,
											array(
												'key' => 'featured_post',
												'value' => '1',
												'compare' => '=='
											),
										),
									);										
									$wp_query= null;
									$wp_query = new WP_Query($args);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
										$featuredPosts[] = $post->ID;
										get_template_part( 'templates/classiera-loops/loop-strobe');
									endwhile;
										//wp_reset_query();
										//wp_reset_postdata(); ?>
										<?php
										global $paged, $wp_query, $wp;
										$args = wp_parse_args($wp->matched_query);
										if ( !empty ( $args['paged'] ) && 0 == $paged ){
											$wp_query->set('paged', $args['paged']);
											$paged = $args['paged'];
										}										
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										//$wp_query= null;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'paged' => $paged,
											'post__not_in' => $featuredPosts,
											's'   => $keyword,
											'posts_per_page' => 10,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryloc,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
											),
										);										
										$wp_query= null;										
										$wp_query = new WP_Query($args);
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$emptyPost++;
											get_template_part( 'templates/classiera-loops/loop-strobe');
										endwhile; ?>
									</div><!--row-->
									<?php
									if($classiera_pagination == 'pagination'){
										classiera_pagination();
									}
									?>
								</div><!--container-->
								<?php
								if($classiera_pagination == 'infinite'){
									echo infinite($wp_query);
								}
								?>
								<?php wp_reset_query(); ?>
							</div><!--tabpanel-->
						</div><!--tab-content section-gray-bg-->
					</div>
				</section>
				<!-- end advertisement style 2-->
			<?php }elseif($classieraCategoriesStyle == 3){?>
				<section class="classiera-advertisement advertisement-v3 section-pad-top-100">
					<div class="tab-divs">
						<div class="view-head">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-sm-8">
										<div class="total-post">
											<?php 
											global $paged, $wp_query, $wp;								
											$args = wp_parse_args($wp->matched_query);
											$temp = $wp_query;
											$args = array(
												'post_type' => 'post',
												'post_status' => 'publish',
												's'   => $keyword,
												'posts_per_page' => -1,
												'category_name' => $catSearchID,
												'meta_query' => array(
													'relation' => 'AND',
													$searchQueryPrice,
													$searchQueryloc,
													$searchCondition,
													$classieraAdsTypeSearch,
													$searchQueryCustomFields,
													$adstypeQuery,
												),
											);
											$wp_query= null;
											$wp_query = new WP_Query($args);
											$count = $wp_query->post_count;
											?>
											<p> <?php echo esc_attr($count); ?>
											<?php esc_html_e( 'ads found', 'classiera') ?> : 
											<span>
												<?php esc_html_e( 'related to your search', 'classiera') ?>
											</span>
										</p>
										<?php wp_reset_query(); ?>
										<?php wp_reset_postdata(); ?>
									</div>
								</div><!--col-lg-6 col-sm-8-->
								<div class="col-lg-6 col-sm-4">
									<div class="view-as text-right flip">
										<span><?php esc_html_e( 'View as', 'classiera' ); ?>:</span>
										<div class="btn-group">
											<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
											<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>
										</div>
									</div>
								</div><!--col-lg-6 col-sm-4-->
							</div><!--row-->
						</div><!--container-->
					</div><!--view-head-->
					<div class="tab-content section-gray-bg">
						<div role="tabpanel" class="tab-pane fade in active" id="all">
							<div class="container">
								<div class="row">
									<?php
									global $paged, $wp_query, $wp;										
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ){
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
									$temp = $wp_query;										
									$args = array(
										'post_type' => 'post',
										'post_status' => 'publish',
										's'   => $keyword,
										'posts_per_page' => $featuredMaxPostCount,	
										'paged' => $paged,											
										'category_name' => $catSearchID,
										'meta_query' => array(
											'relation' => 'AND',
											$searchQueryPrice,
											$searchQueryloc,
											$searchCondition,
											$classieraAdsTypeSearch,
											$searchQueryCustomFields,
											$adstypeQuery,
											array(
												'key' => 'featured_post',
												'value' => '1',
												'compare' => '=='
											),	
										),
									);										
									$wp_query= null;
									$wp_query = new WP_Query($args);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
										$featuredPosts[] = $post->ID;
										get_template_part( 'templates/classiera-loops/loop-coral');
									endwhile;
									wp_reset_query();
									wp_reset_postdata(); ?>
									<?php
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ){
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}										
									$args = wp_parse_args($wp->matched_query);
									$temp = $wp_query;										
									$args = array(
										'post_type' => 'post',
										'post_status' => 'publish',
										'paged' => $paged,
										'post__not_in' => $featuredPosts,
										's'   => $keyword,
										'posts_per_page' => 10,
										'category_name' => $catSearchID,
										'meta_query' => array(
											'relation' => 'AND',
											$searchQueryPrice,
											$searchQueryloc,
											$classieraAdsTypeSearch,
											$searchCondition,
											$searchQueryCustomFields,
											$adstypeQuery,
										),
									);
									$wp_query= null;										
									$wp_query = new WP_Query($args);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										$emptyPost++;
										get_template_part( 'templates/classiera-loops/loop-coral');
									endwhile; ?>
								</div><!--row-->
								<?php
								if($classiera_pagination == 'pagination'){
									classiera_pagination();
								}
								?>
							</div><!--container-->
							<?php
							if($classiera_pagination == 'infinite'){
								echo infinite($wp_query);
							}
							?>
							<?php wp_reset_query(); ?>
						</div><!--tabpanel-->
					</div><!--tab-content section-gray-bg-->
				</div><!--tab-divs-->
			</section>
			<!-- end advertisement style 3-->
		<?php }elseif($classieraCategoriesStyle == 4){?>
			<section class="classiera-advertisement advertisement-v4 section-pad-top-100">
				<div class="tab-divs">
					<div class="view-head">
						<div class="container">
							<div class="row">
								<div class="col-lg-6 col-sm-8 col-xs-12">
									<div class="total-post">
										<?php 
										global $paged, $wp_query, $wp;								
										$args = wp_parse_args($wp->matched_query);
										$temp = $wp_query;
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											's'   => $keyword,
											'posts_per_page' => -1,
											'category_name' => $catSearchID,
											'meta_query' => array(
												'relation' => 'AND',
												$searchQueryPrice,
												$searchQueryloc,
												$searchCondition,
												$classieraAdsTypeSearch,
												$searchQueryCustomFields,
												$adstypeQuery,
											),
										);
										$wp_query= null;
										$wp_query = new WP_Query($args);
										$count = $wp_query->post_count;
										?>
										<p> <?php echo esc_attr($count); ?>
										<?php esc_html_e( 'ads found', 'classiera') ?> : 
										<span>
											<?php esc_html_e( 'related to your search', 'classiera') ?>
										</span>
									</p>
									<?php wp_reset_query(); ?>
									<?php wp_reset_postdata(); ?>
								</div>
							</div><!--col-lg-6 col-sm-8-->
							<div class="col-lg-6 col-sm-4 col-xs-12">
								<div class="view-as tab-button">
									<ul class="nav nav-tabs pull-right flip" role="tablist">
										<li><span><?php esc_html_e( 'View as', 'classiera' ); ?></span></li>
										<li role="presentation" class="<?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>">
											<a id="grid" class="masonry" href="#">
												<i class="zmdi zmdi-view-dashboard"></i>
												<span class="arrow-down"></span>
											</a>
										</li>
										<li role="presentation" class="<?php if($classieraAdsView == 'list'){ echo "active"; }?>">
											<a id="list" class="list" href="#">
												<i class="zmdi zmdi-view-list"></i>
												<span class="arrow-down"></span>
											</a>
										</li>
									</ul>
								</div><!--view-as tab-button-->
							</div><!--col-lg-6 col-sm-4 col-xs-12-->
						</div><!--row-->
					</div><!--container-->
				</div><!--view-head-->
				<div class="tab-content section-gray-bg">
					<div role="tabpanel" class="tab-pane fade in active" id="all">
						<div class="container">
							<div class="row <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "masonry-content"; }?>">
								<?php
								global $paged, $wp_query, $wp;										
								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}
								$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
								$temp = $wp_query;										
								$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									's'   => $keyword,
									'posts_per_page' => $featuredMaxPostCount,	
									'paged' => $paged,											
									'category_name' => $catSearchID,
									'meta_query' => array(
										'relation' => 'AND',
										$searchQueryPrice,
										$searchQueryloc,
										$classieraAdsTypeSearch,
										$searchCondition,
										$searchQueryCustomFields,
										$adstypeQuery,
										array(
											'key' => 'featured_post',
											'value' => '1',
											'compare' => '=='
										),
									),
								);										
								$wp_query= null;
								$wp_query = new WP_Query($args);
								while ($wp_query->have_posts()) : $wp_query->the_post();
									$emptyPost++;
									$featuredPosts[] = $post->ID;
									get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile;
								wp_reset_query();
								wp_reset_postdata(); ?>
								<?php
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}										
								$args = wp_parse_args($wp->matched_query);
								$temp = $wp_query;										
								$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'paged' => $paged,
									'post__not_in' => $featuredPosts,
									's'   => $keyword,
									'posts_per_page' => 10,
									'category_name' => $catSearchID,
									'meta_query' => array(
										'relation' => 'AND',
										$searchQueryPrice,
										$searchQueryloc,
										$searchCondition,
										$classieraAdsTypeSearch,
										$searchQueryCustomFields,
										$adstypeQuery,
									),
								);
								$wp_query= null;										
								$wp_query = new WP_Query($args);
								while ($wp_query->have_posts()) : $wp_query->the_post();
									$emptyPost++;
									get_template_part( 'templates/classiera-loops/loop-canary');
								endwhile; ?>
							</div><!--row-->
							<?php
							if($classiera_pagination == 'pagination'){
								classiera_pagination();
							}
							?>
						</div><!--container-->
						<?php
						if($classiera_pagination == 'infinite'){
							echo infinite($wp_query);
						}
						?>
						<?php wp_reset_query(); ?>
					</div><!--tabpanel-->
				</div><!--tab-content-->
			</div><!--tab-divs-->
		</section>
		<!-- end advertisement style 4-->
	<?php }elseif($classieraCategoriesStyle == 5 || $classieraCategoriesStyle == 8 || $classieraCategoriesStyle == 9 || $classieraCategoriesStyle == 10){?>
		<section class="classiera-advertisement advertisement-v5 section-pad-80 border-bottom">
			<div class="tab-divs">
				<div class="view-head">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-sm-7 col-xs-8">
								<div class="total-post">
									<?php 
									global $paged, $wp_query, $wp;								
									$args = wp_parse_args($wp->matched_query);
									$temp = $wp_query;
									$args = array(
										'post_type' => 'post',
										'post_status' => 'publish',
										's'   => $keyword,
										'posts_per_page' => -1,
										'category_name' => $catSearchID,
										'meta_query' => array(
											'relation' => 'AND',
											$searchQueryPrice,
											$searchQueryloc,
											$searchCondition,
											$classieraAdsTypeSearch,
											$searchQueryCustomFields,
											$adstypeQuery,
										),
									);
									$wp_query= null;
									$wp_query = new WP_Query($args);
									$count = $wp_query->post_count;
									?>
									<p> <?php echo esc_attr($count); ?>
									<?php esc_html_e( 'ads found', 'classiera') ?> : 
									<span>
										<?php esc_html_e( 'related to your search', 'classiera') ?>
									</span>
								</p>
								<?php wp_reset_query(); ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div><!--col-lg-6 col-sm-8-->
						<div class="col-lg-6 col-sm-5 col-xs-4">
							<div class="view-as text-right flip">
								<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
								<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
							</div><!--view-as tab-button-->
						</div><!--col-lg-6 col-sm-4 col-xs-12-->
					</div><!--row-->
				</div><!--container-->
			</div><!--view-head-->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="all">
					<div class="container">
						<div class="row">
							<?php
							global $paged, $wp_query, $wp;										
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ){
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}
							$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
							$temp = $wp_query;										
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								's'   => $keyword,
								'posts_per_page' => $featuredMaxPostCount,	
								'paged' => $paged,				
								'category_name' => $catSearchID,
								'meta_query' => array(
									'relation' => 'AND',
									$searchQueryPrice,
									$searchQueryloc,
									$searchCondition,
									$classieraAdsTypeSearch,
									$searchQueryCustomFields,
									$adstypeQuery,
									array(
										'key' => 'featured_post',
										'value' => '1',
										'compare' => '=='
									),											
								),
							);										
							$wp_query= null;
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$emptyPost++;
								$featuredPosts[] = $post->ID;
								get_template_part( 'templates/classiera-loops/loop-ivy');
							endwhile;
							wp_reset_query();
							wp_reset_postdata(); ?>
							<?php
							global $paged, $wp_query, $wp;
							$args = wp_parse_args($wp->matched_query);
							if ( !empty ( $args['paged'] ) && 0 == $paged ){
								$wp_query->set('paged', $args['paged']);
								$paged = $args['paged'];
							}										
							$args = wp_parse_args($wp->matched_query);
							$temp = $wp_query;										
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'paged' => $paged,
								'post__not_in' => $featuredPosts,
								's'   => $keyword,
								'posts_per_page' => 10,
								'category_name' => $catSearchID,
								'meta_query' => array(
									'relation' => 'AND',
									$searchQueryPrice,
									$searchQueryloc,
									$searchCondition,
									$classieraAdsTypeSearch,
									$searchQueryCustomFields,
									$adstypeQuery,
								),
							);
							$wp_query= null;										
							$wp_query = new WP_Query($args);
							while ($wp_query->have_posts()) : $wp_query->the_post();
								$emptyPost++;
								get_template_part( 'templates/classiera-loops/loop-ivy');
							endwhile; ?>
						</div><!--row-->
						<?php
						if($classiera_pagination == 'pagination'){
							classiera_pagination();
						}
						?>
					</div><!--container-->
					<?php
					if($classiera_pagination == 'infinite'){
						echo infinite($wp_query);
					}
					?>
					<?php wp_reset_query(); ?>
				</div><!--tabpanel-->
			</div><!--tab-content-->
		</div><!--tab-divs-->
	</section>
	<!-- end advertisement style 5-->
<?php }elseif($classieraCategoriesStyle == 6){?>
	<section class="classiera-advertisement advertisement-v6 section-pad border-bottom">
		<div class="tab-divs">
			<div class="view-head">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-sm-8">
							<div class="total-post">
								<?php 
								global $paged, $wp_query, $wp;								
								$args = wp_parse_args($wp->matched_query);
								$temp = $wp_query;
								$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									's'   => $keyword,
									'posts_per_page' => -1,
									'category_name' => $catSearchID,
									'meta_query' => array(
										'relation' => 'AND',
										$searchQueryPrice,
										$searchQueryloc,
										$searchCondition,
										$classieraAdsTypeSearch,
										$searchQueryCustomFields,
										$adstypeQuery,
									),
								);
								$wp_query= null;
								$wp_query = new WP_Query($args);
								$count = $wp_query->post_count;
								?>
								<p> <?php echo esc_attr($count); ?>
								<?php esc_html_e( 'ads found', 'classiera') ?> : 
								<span>
									<?php esc_html_e( 'related to your search', 'classiera') ?>
								</span>
							</p>
							<?php wp_reset_query(); ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div><!--col-lg-6 col-sm-8-->
					<div class="col-lg-6 col-sm-4">
						<div class="view-as text-right flip">
							<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
							<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
						</div><!--view-as tab-button-->
					</div><!--col-lg-6 col-sm-4 col-xs-12-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
						<?php
						global $paged, $wp_query, $wp;										
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
						$temp = $wp_query;										
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							's'   => $keyword,
							'posts_per_page' => $featuredMaxPostCount,	
							'paged' => $paged,				
							'category_name' => $catSearchID,
							'meta_query' => array(
								'relation' => 'AND',
								$searchQueryPrice,
								$searchQueryloc,
								$searchCondition,
								$classieraAdsTypeSearch,
								$searchQueryCustomFields,
								$adstypeQuery,
								array(
									'key' => 'featured_post',
									'value' => '1',
									'compare' => '=='
								),											
							),
						);										
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$emptyPost++;
							$featuredPosts[] = $post->ID;
							get_template_part( 'templates/classiera-loops/loop-iris');
						endwhile;
						wp_reset_query();
						wp_reset_postdata(); ?>
						<?php
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}										
						$args = wp_parse_args($wp->matched_query);
						$temp = $wp_query;										
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'paged' => $paged,
							'post__not_in' => $featuredPosts,
							's'   => $keyword,
							'posts_per_page' => 10,
							'category_name' => $catSearchID,
							'meta_query' => array(
								'relation' => 'AND',
								$searchQueryPrice,
								$searchQueryloc,
								$searchCondition,
								$classieraAdsTypeSearch,
								$searchQueryCustomFields,
								$adstypeQuery,
							),
						);
						$wp_query= null;										
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$emptyPost++;
							get_template_part( 'templates/classiera-loops/loop-iris');
						endwhile; ?>
					</div><!--row-->
					<?php
					if($classiera_pagination == 'pagination'){
						classiera_pagination();
					}
					?>
				</div><!--container-->
				<?php
				if($classiera_pagination == 'infinite'){
					echo infinite($wp_query);
				}
				?>
				<?php wp_reset_query(); ?>
			</div><!--tabpanel-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>
<!-- end advertisement style 6-->
<?php }elseif($classieraCategoriesStyle == 7){?>
	<section class="classiera-advertisement advertisement-v6 advertisement-v7 section-pad border-bottom">
		<div class="tab-divs">
			<div class="view-head">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-sm-8">
							<div class="total-post">
								<?php 
								global $paged, $wp_query, $wp;								
								$args = wp_parse_args($wp->matched_query);
								$temp = $wp_query;
								$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									's'   => $keyword,
									'posts_per_page' => -1,
									'category_name' => $catSearchID,
									'meta_query' => array(
										'relation' => 'AND',
										$searchQueryPrice,
										$searchQueryloc,
										$searchCondition,
										$classieraAdsTypeSearch,
										$searchQueryCustomFields,
										$adstypeQuery,
									),
								);
								$wp_query= null;
								$wp_query = new WP_Query($args);
								$count = $wp_query->post_count;
								?>
								<p> <?php echo esc_attr($count); ?>
								<?php esc_html_e( 'ads found', 'classiera') ?> : 
								<span>
									<?php esc_html_e( 'related to your search', 'classiera') ?>
								</span>
							</p>
							<?php wp_reset_query(); ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div><!--col-lg-6 col-sm-8-->
					<div class="col-lg-6 col-sm-4">
						<div class="view-as text-right flip">
							<a id="grid" class="grid <?php if($classieraAdsView == 'grid' || $classieraAdsView == 'medium'){ echo "active"; }?>" href="#"><i class="fas fa-th"></i></a>
							<a id="list" class="list <?php if($classieraAdsView == 'list'){ echo "active"; }?>" href="#"><i class="fas fa-th-list"></i></a>							
						</div><!--view-as tab-button-->
					</div><!--col-lg-6 col-sm-4 col-xs-12-->
				</div><!--row-->
			</div><!--container-->
		</div><!--view-head-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="all">
				<div class="container">
					<div class="row">
						<?php
						global $paged, $wp_query, $wp;										
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
						$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
						$temp = $wp_query;										
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							's'   => $keyword,
							'posts_per_page' => $featuredMaxPostCount,	
							'paged' => $paged,			
							'category_name' => $catSearchID,
							'meta_query' => array(
								'relation' => 'AND',
								$searchQueryPrice,
								$searchQueryloc,
								$searchCondition,
								$classieraAdsTypeSearch,
								$searchQueryCustomFields,
								$adstypeQuery,
								array(
									'key' => 'featured_post',
									'value' => '1',
									'compare' => '=='
								),											
							),
						);										
						$wp_query= null;
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$emptyPost++;
							$featuredPosts[] = $post->ID;
							get_template_part( 'templates/classiera-loops/loop-allure');
						endwhile;
						wp_reset_query();
						wp_reset_postdata(); ?>
						<?php
						global $paged, $wp_query, $wp;
						$args = wp_parse_args($wp->matched_query);
						if ( !empty ( $args['paged'] ) && 0 == $paged ){
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}										
						$args = wp_parse_args($wp->matched_query);
						$temp = $wp_query;										
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'paged' => $paged,
							'post__not_in' => $featuredPosts,
							's'   => $keyword,
							'posts_per_page' => 10,
							'category_name' => $catSearchID,
							'meta_query' => array(
								'relation' => 'AND',
								$searchQueryPrice,
								$searchQueryloc,
								$searchCondition,
								$classieraAdsTypeSearch,
								$searchQueryCustomFields,
								$adstypeQuery,
							),
						);
						$wp_query= null;										
						$wp_query = new WP_Query($args);
						while ($wp_query->have_posts()) : $wp_query->the_post();
							$emptyPost++;
							get_template_part( 'templates/classiera-loops/loop-allure');
						endwhile; ?>
					</div><!--row-->
					<?php
					if($classiera_pagination == 'pagination'){
						classiera_pagination();
					}
					?>
				</div><!--container-->
				<?php
				if($classiera_pagination == 'infinite'){
					echo infinite($wp_query);
				}
				?>
				<?php wp_reset_query(); ?>
			</div><!--tabpanel-->
		</div><!--tab-content-->
	</div><!--tab-divs-->
</section>
<!-- end advertisement style 7-->
<?php } ?>
</div>
<!--ContentArea-->
</div><!--row-->
</div><!--container-->	
</section>
<script>
	jQuery(document).ready(function($){
		$('#view_map').click(function(){
			$('#classiera_map').toggle();
		});


		// $('#save_search').click(function(){
		// 	var search_keyword = $('#search_keyword').val();
		// 	var search_state = $('#search_state').val();
		// 	alert(search_state);
		// 	jQuery.ajax({
	 //      url: "save-search.php",
	 //      type: 'POST',
	 //      data: {search_keyword:search_keyword, search_state:search_state},
	 //      xhrFields: {withCredentials: true},
	 //      success: function(response) {
	 //        console.log(response);
	 //      }

		// 	});

			
		// });


 
	});
</script>
<?php get_footer(); ?>