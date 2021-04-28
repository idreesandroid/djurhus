<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

get_header(); 
?>
<?php
global $redux_demo, $allowed_html, $cat_id;  
$caticoncolor="";
$category_icon_code ="";
$category_icon ="";
$category_icon_color="";
$classieraMAPStyle="";
$classieraSearchStyle = 1;
$classieraCategoriesStyle = 1;
$classieraPostCount = false;
$classieraAdvSearchCats = false;
$classiera_categories_desc = false;
$classiera_map_on_category = false;
$classiera_ads_typeOn = false;
$classieraMAPDragging = false;
$classieraMAPScroll = false;
if(isset($redux_demo)){
	$classieraSearchStyle = $redux_demo['classiera_search_style'];
	$classieraPremiumStyle = $redux_demo['classiera_premium_style'];
	$classieraPartnersStyle = $redux_demo['classiera_partners_style'];
	$classieraCategoriesStyle = $redux_demo['classiera_cat_style'];
	$classieraPostCount = $redux_demo['classiera_cat_post_counter'];
	$classieraAdvSearchCats = $redux_demo['classiera_adv_search_on_cats'];
	$classiera_categories_desc = $redux_demo['classiera_categories_desc'];
	$classiera_map_on_category = $redux_demo['classiera_map_on_category'];
	$classieraMAPStyle = $redux_demo['map-style'];
	$classieraMAPPostType = $redux_demo['classiera_map_post_type'];	
	$classiera_ads_typeOn = $redux_demo['classiera_ads_type'];
	$classieraMAPDragging = $redux_demo['classiera_map_dragging'];	
	$classieraMAPScroll = $redux_demo['classiera_map_scroll'];
	
}	
$cat_id = get_queried_object_id();
$this_category = get_category($cat_id);	
$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
if ($cat_parent_ID == 0) {
	$tag = $cat_id;
}else{
	$tag = $cat_parent_ID;
}
$category = get_category($tag);
$count = $category->category_count;
$catName = get_cat_name( $tag );
function classiera_Cat_Ads_Count(){		
		$cat_id = get_queried_object_id();
		$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
		if ($cat_parent_ID == 0) {
			$tag = $cat_id;
		}else{
			$tag = $cat_parent_ID;
		}
		$q = new WP_Query( array(
			'nopaging' => true,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $tag,
					'include_children' => true,
				),
			),
			'fields' => 'ids',
		) );
	$count = $q->post_count;
	return $count; 
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
function classiera_single_catid(){	
	$cat_id = get_queried_object_id();
	return $cat_id;
}
	/*== Google MAP ==*/
	if($classiera_map_on_category == true){
		?>
		<section id="classiera_map">
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
									'posts_per_page' => -1,				
									'cat' => $cat_id,
									'meta_query' => array(
										'relation' => 'AND',					
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
									'posts_per_page' => -1,			
									'cat' => $cat_id,
									'meta_query' => array(
										'relation' => 'AND',				
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
							maxZoom: 13,
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
			</div><!--classiera_main_map-->
		</section><!--classiera_map-->
		<?php
	}
	/*== Google MAP ==*/
 
	/*== Search Styles ==*/
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
	
?>
<!-- page content -->
<section class="inner-page-content border-bottom top-pad-50">
	<div class="container">
		<div class="row">
		    <!--Google Section-->
			<?php 
			$homeAd1 = '';		
			global $redux_demo;
			$homeAdImg1 = $redux_demo['post_ad']['url']; 
			$homeAdImglink1 = $redux_demo['post_ad_url']; 
			$homeHTMLAds = $redux_demo['post_ad_code_html'];				
			if(!empty($homeHTMLAds) || !empty($homeAdImg1)){
			?>
			<section id="classieraDv">
				<div class="container">
					<div class="row">							
						<div class="col-lg-12 col-md-12 col-sm-12 center-block text-center">
							<?php
							if(!empty($homeHTMLAds)){
								if(function_exists('classiera_escape')) {
									classiera_escape($homeHTMLAds);
								}
							}else{
								echo '<a href="'.esc_url($homeAdImglink1).'" target="_blank"><img class="img-responsive" alt="image" src="'.esc_url($homeAdImg1).'" /></a>';
							}
							?>
						</div>
					</div>
				</div>	
			</section>
			<?php } ?>
			<!--Google Section-->
			<div class="col-md-8 col-lg-9">
				<!--category description section-->				
				<?php if($classiera_categories_desc == 1){?>
				<section id="classiera_cat_description">
					<div class="container">
						<div class="row">							
							<div class="col-lg-12 col-md-12 col-sm-12 center-block">
								<?php echo category_description($cat_id); ?>
							</div>
						</div>
					</div>
				</section>
				<?php } ?>
				<!--category description section-->
				
				<!-- advertisement -->
				<?php 
					if($classieraCategoriesStyle == 1){
						get_template_part( 'templates/catinner/style1' );
					}elseif($classieraCategoriesStyle == 2){
						get_template_part( 'templates/catinner/style2' );
					}elseif($classieraCategoriesStyle == 3){
						get_template_part( 'templates/catinner/style3' );
					}elseif($classieraCategoriesStyle == 4){
						get_template_part( 'templates/catinner/style4' );
					}elseif($classieraCategoriesStyle == 5){
						get_template_part( 'templates/catinner/style5' );
					}elseif($classieraCategoriesStyle == 6){
						get_template_part( 'templates/catinner/style6' );
					}elseif($classieraCategoriesStyle == 7){
						get_template_part( 'templates/catinner/style7' );
					}elseif($classieraCategoriesStyle == 8){
						get_template_part( 'templates/catinner/style5' );
					}elseif($classieraCategoriesStyle == 9){
						get_template_part( 'templates/catinner/style5' );
					}elseif($classieraCategoriesStyle == 10){
						get_template_part( 'templates/catinner/style5' );
					}
				?>
				<!-- advertisement -->
			</div><!--col-md-8-->
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<!--subcategory-->
						<?php 
						$cat_term_ID = $this_category->term_id;
						$cat_child = get_term_children( $cat_term_ID, 'category' );
						if (!empty($cat_child)) {
							$args = array(
								'type' => 'post',								
								'parent' => $cat_id,
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => 0,
								'depth' => 1,
								'hierarchical' => 1,
								'taxonomy' => 'category',
								'pad_counts' => true 
							);
							$category = get_categories($args);
							if($category[0]->category_parent == 0){
									$tag = $category[0]->cat_ID;
									$category_icon_code = "";
									$category_icon_color = "";
									$your_image_url = "";
									$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
									if (isset($tag_extra_fields[$tag])) {
										if(isset($tag_extra_fields[$tag]['category_icon_code'])){
											$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
										}
										if(isset($tag_extra_fields[$tag]['category_icon_color'])){
											$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
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
									}
								}
								$category_icon = stripslashes($category_icon_code);
						?>
						<div class="col-lg-12 col-md-12 col-sm-6 match-height">
							<div class="widget-box">
								<div class="widget-title">
									<h4>
										<i class="<?php echo esc_html($category_icon); ?>" style="color:<?php echo esc_html($category_icon_color); ?>;"></i>
										<?php echo esc_html($catName); ?>
									</h4>
								</div>
								<div class="widget-content">
									<ul class="category">
									<?php
										foreach($category as $category) { 
									?>
										<li>
                                            <a href="<?php echo esc_url(get_category_link( $category->term_id ));?>">
                                                <i class="fas fa-angle-right"></i>
                                                <?php echo esc_html($category->name); ?>
                                                <span class="pull-right flip">
												<?php if($classieraPostCount == 1){?>
													(<?php echo esc_attr($category->count); ?>)
												<?php }else{ ?>
													&nbsp;
												<?php } ?>
												</span>
                                            </a>
                                        </li>
									<?php } ?>
									</ul>
								</div>
							</div>
						</div>
						<?php } ?>
						<!--subcategory-->
						<?php if($classieraAdvSearchCats == 1){?>
							<div class="col-lg-12 col-md-12 col-sm-6 match-height">
								<div class="widget-box">
								<?php get_template_part( 'templates/classiera-adv-search' );?>
								</div>
							</div>
						<?php } ?>
						<?php get_sidebar('pages'); ?>
					</div><!--row-->
				</aside>
			</div><!--col-lg-4-->
		</div><!--row-->
	</div><!--container-->
</section>	
<!-- page content -->
<script>
	jQuery(document).ready(function($){
		$('#sort_by').change(function(){
			var selectedValue = $(this). children("option:selected"). val();
			if(selectedValue == 'lowered'){
				$('#lowered_price').show();
				$('#all_ads').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
      	$('#oldest_price').hide();
				$('#cheapest_ads').hide();
				$('#expensive_ads').hide();
			}else if(selectedValue == 'oldest'){
				$('#oldest_price').show();
				$('#all_ads').hide();
				$('#lowered_price').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else if(selectedValue == 'cheapest'){
				$('#lowered_price').hide();
				$('#all_ads').hide();
				$('#oldest_price').hide();
				$('#cheapest_ads').show();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else if(selectedValue == 'expensive'){
				$('#lowered_price').hide();
				$('#all_ads').hide();
				$('#oldest_price').hide();
				$('#cheapest_ads').hide();
				$('#expensive_ads').show();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}else{
				$('#lowered_price').hide();
				$('#all_ads').show();
				$('#oldest_price').hide();
				$('#cheapest_ads').hide();
				$('#expensive_ads').hide();
				$('#buy_type').hide();
				$('#all_type').hide();
				$('#sell_type').hide();
			}
		});

		$("input[name='classiera_ads_type']").click(function(){
      var radioValue = $("input[name='classiera_ads_type']:checked").val();
     
      if(radioValue == 'buy'){
        $('#buy_type').show();
        $('#lowered_price').hide();
        $('#all_ads').hide();
        $('#oldest_price').hide();
        $('#cheapest_ads').hide();
        $('#expensive_ads').hide();
        $('#sell_type').hide();
        $('#all_type').hide();
      }else if(radioValue == 'sell'){
      	$('#lowered_price').hide();
      	$('#all_ads').hide();
      	$('#oldest_price').hide();
      	$('#cheapest_ads').hide();
      	$('#expensive_ads').hide();
      	$('#buy_type').hide();
      	$('#sell_type').show();
      	$('#all_type').hide();
      }else{
      	$('#all_ads').hide();
      	$('#lowered_price').hide();
      	$('#all_ads').hide();
      	$('#oldest_price').hide();
      	$('#cheapest_ads').hide();
      	$('#expensive_ads').hide();
      	$('#buy_type').hide();
      	$('#sell_type').hide();
      	$('#all_type').show();
      }
    });

	});
</script>
<?php get_footer(); ?>