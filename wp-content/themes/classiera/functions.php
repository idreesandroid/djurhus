<?php
/**
 * Author: JoinWebs
 * URL: http://joinwebs.com
 *
 * Classiera functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 2.0
 */

/** Various clean up functions */
/*==========================
 Create Text Domain For the Themes' Translations
 ===========================*/
if(function_exists('load_theme_textdomain')){
	load_theme_textdomain( 'classiera', get_template_directory() . '/languages' );
}
/*==========================
 Requried some Files.
 ===========================*/
require get_template_directory() . '/assets/theme-support.php';
require get_template_directory() . '/assets/requried-plugins.php';
require get_template_directory() . '/assets/enque-styles-script.php';
require get_template_directory() . '/assets/reg-sidebar.php';
require get_template_directory() . '/inc/user_status.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/woo.php';
require get_template_directory() . '/inc/classiera-ajax.php';
require get_template_directory() . '/inc/classiera-search.php';
require_once('pagination.php');
/*==========================
 Load Customizer JS
===========================*/
if (!function_exists('classiera_customize_preview_js')) {
	function classiera_customize_preview_js(){
		wp_enqueue_script( 'classiera-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
	}
}
/*==========================
 Custom admin scripts
===========================*/
if (!function_exists('classiera_admin_scripts')) {
	function classiera_admin_scripts() {
		wp_enqueue_media();
	}
}
/*==========================
 Extra Fields for Pricing Plan in user Profile
===========================*/
if (!function_exists('classiera_save_extra_profile_fields')) {
	function classiera_save_extra_profile_fields( $user_id ) {
		update_user_meta( $user_id, 'price_plan' );
		add_user_meta( $user_id, 'price_plan_id' );
	}
}
/*==========================
 Insert attachments front end
===========================*/
if (!function_exists('classiera_insert_attachment')) {
	function classiera_insert_attachment($file_handler,$post_id,$setthumb='false') {

	  // check to make sure its a successful upload
	  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	  require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	  
	  $attach_id = media_handle_upload( $file_handler, $post_id );
	  
	  return $attach_id;
	}
}
/*==========================
 Classiera : Upload User Profile Image and return attachment ID
===========================*/
if (!function_exists('classiera_insert_userIMG')) {
	function classiera_insert_userIMG($file_handler){
		if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		$attach_id = media_handle_upload($file_handler, $post_id = null);	
	  return $attach_id;
	}
}
/*==========================
 Classiera : Get Profile URL from attachment ID
===========================*/
if (!function_exists('classiera_get_profile_img')) {
	function classiera_get_profile_img($attach_id){
		$profileURL = "";
		$sourceURL = wp_get_attachment_image_src($attach_id);
		if(!empty($sourceURL)){		
			$profileURL = $sourceURL[0];
		}		
		return $profileURL;
	}
}
/*==========================
 Classiera : Featured Post meta
 Show The Post On Slider Option
===========================*/
if (!function_exists('classiera_featured_post')) {
	function classiera_featured_post(){
		global $post;		
		echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';	
		// Get the location data if its already been entered
		$featured_post = get_post_meta($post->ID, 'featured_post', true);
		
		// Echo out the field
		echo '<span class="text overall" style="margin-right: 20px;">'.esc_html__( 'Check to have this as featured post:', 'classiera' ).'</span>';	
		$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";	
		echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';
	}
}
/*==========================
 Classiera : Save the Featured Metabox Data
===========================*/
if (!function_exists('classiera_save_post_meta')) {
	function classiera_save_post_meta($post_id, $post) {
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {
			return $post->ID;
		}
		
		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID )){
			return $post->ID;
		}
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		
		$events_meta['featured_post'] = $_POST['featured_post'];
		
		$chk = ( isset( $_POST['featured_post'] ) && $_POST['featured_post'] ) ? '1' : '2';
		update_post_meta( $post_id, 'featured_post', $chk );
		
		// Add values of $events_meta as custom fields
		foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
			if( $post->post_type == 'post' ) return; // Don't store custom data twice
			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}

	}
}
/*==========================
 Classiera : Google Fonts Function
 Returns the Google font stylesheet URL, if available.
 The use of Source Sans Pro and Bitter by default is localized. For languages
 that use characters not supported by the font, the font can be disabled
 @return string Font stylesheet or empty string if disabled.
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_fonts_url')) {
	function classiera_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		 * supported by Source Sans Pro, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'classiera' );

		/* Translators: If there are characters in your language that are not
		 * supported by Bitter, translate this to 'off'. Do not translate into your
		 * own language.
		 */
		$bitter = _x( 'on', 'Bitter font: on or off', 'classiera' );

		if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
			$font_families = array();

			if ( 'off' !== $source_sans_pro ){
				$font_families[] = 'Montserrat:400,700,400italic,700italic';
			}
			if ( 'off' !== $bitter ){
				$font_families[] = 'Lato:400,700';
			}
			$query_args = array(
				'family' => urlencode( implode( '%7C', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url = esc_url( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) ) ;
		}

		return $fonts_url;
	}
}
/*==========================
 Classiera : Function to display extra info on category admin
 @since classiera 1.0
===========================*/
// the option name
define('MY_CATEGORY_FIELDS', 'my_category_fields_option');
// your fields (the form)
if (!function_exists('classiera_my_category_fields')) {
	function classiera_my_category_fields($tag) {
		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);	
		$category_icon_code = '';
		$category_image = '';
		$category_icon_color = '';
		$your_image_url = '';
		$cat_pay_per_post = '';
		$days_to_expire = '';
		if(isset($tag->term_id)){
			$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';
			$category_image = isset( $tag_extra_fields[$tag->term_id]['category_image'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_image'] ) : '';
			$category_icon_color = isset( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) : '';
			$your_image_url = isset( $tag_extra_fields[$tag->term_id]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['your_image_url'] ) : '';
			$cat_pay_per_post = isset( $tag_extra_fields[$tag->term_id]['cat_pay_per_post'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['cat_pay_per_post'] ) : '';
			$days_to_expire = isset( $tag_extra_fields[$tag->term_id]['days_to_expire'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['days_to_expire'] ) : '';
		}
		?>

	<div class="form-field">	
		<table class="form-table">
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'Icon Code', 'classiera' ); ?></label>
				</th>
				<td>

					<input id="category_icon_code" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />
					<p class="description"><?php esc_html_e( 'Font Awesome code', 'classiera' ); ?>: <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a> Ex: fa fa-desktop</p>

				</td>
			</tr>
			<!--payperpost-->
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'Woo Commerce product ID', 'classiera' ); ?></label>
				</th>
				<td>
					<input id="cat_pay_per_post" class="wp_cat_desc" type="text" name="cat_pay_per_post" value="<?php echo esc_attr($cat_pay_per_post); ?>" />
					<p class="description wp_cat_desc"><?php esc_html_e( 'First create a WooCommerce product and set the price there. Here you just need to put the WooCommerce product ID.', 'classiera' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'How many days', 'classiera' ); ?></label>
				</th>
				<td>
					<input id="days_to_expire" class="wp_cat_desc" type="text" name="days_to_expire" value="<?php echo esc_attr($days_to_expire); ?>" />
					<p class="description wp_cat_desc"><?php esc_html_e( 'How many days ads will be shown in featured place? Put a number like 5 or 10 or 30 or 60 etc.', 'classiera' ); ?></p>
				</td>
			</tr>
			<!--payperpost-->
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'Category Image', 'classiera' ); ?>&nbsp;Size:370x200px:</label>
				</th>
				<td>
				<?php 

				if(!empty($category_image)) {

					echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
					echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
					echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
					echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

				} else {

					echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
					echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
					echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
					echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

				}

				?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'Icon Background Color', 'classiera' ); ?></label>
				</th>
				<td>

					<link rel="stylesheet" media="screen" type="text/css" href="<?php echo esc_url(get_template_directory_uri()) ?>/inc/color-picker/css/colorpicker.css" />
					<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()) ?>/inc/color-picker/js/colorpicker.js"></script>
					<script type="text/javascript">
					jQuery.noConflict();
					jQuery(document).ready(function(){
						jQuery('#colorpickerHolder').ColorPicker({color: '<?php echo esc_html($category_icon_color); ?>', flat: true, onChange: function (hsb, hex, rgb) { jQuery('#category_icon_color').val('#' + hex); }});
					});
					</script>

					<p id="colorpickerHolder"></p>

					<input id="category_icon_color" type="text" size="36" name="category_icon_color" value="<?php echo esc_html($category_icon_color); ?>" style="margin-top: 20px; max-width: 90px; visibility: hidden;" />

				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="category-page-slider"><?php esc_html_e( 'Map Pin', 'classiera' ); ?>&nbsp;Size:70x70px:</label>
				</th>
				<td>
				<?php 

				if(!empty($your_image_url)) {

					echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';
					echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';
					echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
					echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

				} else {

					echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';
					echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';
					echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
					echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

				}

				?>
				</td>
			</tr>
		</table>
	</div>

		<?php
	}
}
/*==========================
 Classiera : when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above.
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_update_my_category_fields')) {
	function classiera_update_my_category_fields($term_id) {
		if(isset($_POST['taxonomy'])){	
		  if($_POST['taxonomy'] == 'category'):
			$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
			$tag_extra_fields[$term_id]['your_image_url'] = strip_tags($_POST['your_image_url']);
			$tag_extra_fields[$term_id]['category_image'] = $_POST['category_image'];
			$tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];
			$tag_extra_fields[$term_id]['category_icon_color'] = $_POST['category_icon_color'];
			$tag_extra_fields[$term_id]['cat_pay_per_post'] = $_POST['cat_pay_per_post'];
			$tag_extra_fields[$term_id]['days_to_expire'] = $_POST['days_to_expire'];
			update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
		  endif;
		}
	}
}
/*==========================
 Classiera : when a category is removed
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_remove_my_category_fields')) {
	add_filter('deleted_term_taxonomy', 'classiera_remove_my_category_fields');
	function classiera_remove_my_category_fields($term_id) {
		if(isset($_POST['taxonomy'])){		
		  if($_POST['taxonomy'] == 'category'):
			$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
			unset($tag_extra_fields[$term_id]);
			update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
		  endif;
		} 
	}
}
/*==========================
 Classiera : Post views
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_set_post_views')) {
	function classiera_set_post_views($postID) {
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}
/*==========================
 Classiera : To keep the count accurate, lets get rid of prefetching
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_track_post_views')) {
	function classiera_track_post_views ($post_id) {
		if ( !is_single() ) { 
			return;
		}
		if ( empty ( $post_id) ) {
			global $post;
			$post_id = $post->ID;    
		}
		classiera_set_post_views($post_id);
	}
}
if (!function_exists('classiera_get_post_views')) {
	function classiera_get_post_views($postID){
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0";
		}
		return $count;
	}
}
/*==========================
 Classiera : Creates a nicely formatted and more specific title element text for output
	in head of document, based on current view.
	@param string $title Default title text for current view.
	@param string $sep Optional separator.
	@return string The filtered title.
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_wp_title')) {
	function classiera_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ){
			return $title;
		}
		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ){
			$title = "$title $sep $site_description";
		}	
		//print_r($paged);
		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ){
			$title = "$title $sep " . sprintf( __( 'Page %s', 'classiera' ), max( $paged, $page ) );
		}
		return $title;
	}
}
/*==========================
 Classiera : Displays navigation to next/previous set of posts when applicable.
 @return void
 @since classiera 1.0
===========================*/
if ( ! function_exists( 'classiera_paging_nav' ) ) :
function classiera_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ){
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'classiera' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link(wp_kses( __( '<span class="meta-nav">&larr;</span> Older posts', 'classiera' ), $allowed ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link(wp_kses( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'classiera' ), $allowed ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
/*==========================
 Classiera : Displays navigation to next/previous post when applicable.
 @return void
 @since classiera 1.0
===========================*/
if ( ! function_exists( 'classiera_post_nav' ) ) :
function classiera_post_nav() {
	global $post;
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ){
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'classiera' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'classiera' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'classiera' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
add_filter('wp_nav_menu_items', 'do_shortcode');
/*==========================
 Classiera : Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 Create your own classiera_entry_meta() to override in a child theme.
 @since classiera 1.0
===========================*/
if ( ! function_exists( 'classiera_entry_meta' ) ) :
function classiera_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ){
		echo '<span class="featured-post">' . esc_html_e( 'Sticky', 'classiera' ) . '</span>';
	}
	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() ){
		classiera_entry_date();
	}
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( esc_html_e( ',', 'classiera' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', esc_html_e( ',', 'classiera' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'classiera' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;
/*==========================
 Classiera : Prints HTML with date information for current post.
 Create your own classiera_entry_date() to override in a child theme.
 @param boolean $echo Whether to echo the date. Default true.
 @return string The HTML-formatted post date.
 @since classiera 1.0
 ===========================*/
if ( ! function_exists( 'classiera_entry_date' ) ) :
function classiera_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) ){
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'classiera' );
	}else{
		$format_prefix = '%2$s';
	}
	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'classiera' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo ){
		echo esc_html($date);
	}
	return $date;
}
endif;
/*==========================
 Classiera : Prints the attached image with a link to the next attached image.
 @return void
 @since classiera 1.0
 ===========================*/
if ( ! function_exists( 'classiera_the_attached_image' ) ) :
function classiera_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'classiera_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ){
			$next_attachment_url = get_attachment_link( $next_id );		
		// or get the URL of the first image attachment.
		}else{
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;
/*==========================
 Classiera : Returns the URL from the post.
 @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 the first link found in the post content.
 Falls back to the post permalink if no URL is found in the post.
 @return string The Link format URL.
 @since classiera 1.0
 ===========================*/
if (!function_exists('classiera_get_link_url')) {
	function classiera_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );
		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}
/*==========================
 Classiera : Extends the default WordPress body classes.
 Adds body classes to denote:
 1. Single or multiple authors.
 2. Active widgets in the sidebar to change the layout and spacing.
 3. When avatars are disabled in discussion settings.
 @param array $classes A list of existing body class values.
 @return array The filtered body class list.
 @since classiera 1.0
 ===========================*/
if (!function_exists('classiera_body_class')) {
	function classiera_body_class( $classes ) {
		if ( ! is_multi_author() ){
			$classes[] = 'single-author';
		}
		if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() ){
			$classes[] = 'sidebar';
		}
		if ( ! get_option( 'show_avatars' ) ){
			$classes[] = 'no-avatars';
		}
		return $classes;
	}
}
/*==========================
 Classiera : Adjusts content_width value for video post formats and attachment templates.
 @return void
 @since classiera 1.0
 ===========================*/
if (!function_exists('classiera_content_width')) {
	function classiera_content_width() {
		global $content_width;

		if ( is_attachment() ){
			$content_width = 724;
		}elseif ( has_post_format( 'audio' ) ){
			$content_width = 484;
		}
	}
}
/*==========================
 Classiera : Add postMessage support for site title and description for the Customizer.
 @param WP_Customize_Manager $wp_customize Customizer object.
 @return void
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_customize_register')) {
	function classiera_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
/*==========================
 Classiera : Add Redux Framework
 @return void
 @since classiera 1.0
 ===========================*/
if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/inc/theme-options.php' ) ) {
	require_once( get_template_directory() . '/inc/theme-options.php' );
}
/*==========================
 Classiera : register categories custom fields page
 @since classiera 1.0
 ===========================*/
if (!function_exists('classiera_theme_settings_init')) {
	add_action( 'admin_init', 'classiera_theme_settings_init' );
	function classiera_theme_settings_init(){
	  register_setting( 'theme_settings', 'theme_settings' );
	  wp_enqueue_style("panel_style", get_template_directory_uri()."/css/categories-admin.css", false, "1.0", "all");
	  wp_enqueue_script("panel_script", get_template_directory_uri()."/js/classiera-admin.js", false, "1.0");
	}
}
/*==========================
 Classiera : add categories custom fields page to menu
 @since classiera 1.0
 ===========================*/ 
function classiera_add_settings_page() { 
 add_theme_page('Categories Custom Fields', 'Categories Custom Fields', 'manage_options', 'settings', 'classiera_theme_settings_page'); 
}
add_action( 'admin_menu', 'classiera_add_settings_page' );
/*==========================
 Classiera : Theme Panel Output
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_theme_settings_page')) {
	function classiera_theme_settings_page() {
	  global $themename,$theme_options;
		$i = 0;
		$message = ''; 
		if(isset($_REQUEST['action'])){
			if ( 'savecat' == $_REQUEST['action'] ) {	
				
				$thisCatId = $_POST['this_cat_id'];
				$args = array(
					'orderby' => 'name',
					'order' => 'ASC',
					'include' => $thisCatId,
					'hide_empty' => false
				);
				$categories = get_categories($args);
				foreach($categories as $category) {
					$user_id = $category->term_id;
					$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
					$tag_extra_fields[$user_id]['category_custom_fields'] = $_POST['wpcrown_category_custom_field_option_'.$user_id];
					$tag_extra_fields[$user_id]['category_custom_fields_type'] = $_POST['wpcrown_category_custom_field_type_'.$user_id];			
					update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
				}
				$message='saved';
			}
		}
		 ?>

		<div class="wrap">
		  <div id="icon-options-general"></div>
		  <h2><?php esc_html_e('Categories Custom Fields', 'classiera') ?></h2>
		  <?php
			if ( $message == 'saved' ) echo '<div class="custom_fields_update settings-error" id="setting-error-settings_updated"> 
			<p>'.esc_html__('Custom Fields saved', 'classiera').'</strong></p></div>';
		  ?>
		</div>

		<form method="post">
			<div class="wrap">
				<h3><?php esc_html_e('Select category:', 'classiera') ?></h3>
				<select id="select-author" class="classiera_customfields_cats">
					<?php 
					$cat_args = array ( 'parent' => 0, 'hide_empty' => false, 'orderby' => 'name','order' => 'ASC' ) ;
					$parentcategories = get_categories($cat_args ) ;
					$no_of_categories = count ( $parentcategories ) ;
						
					if ( $no_of_categories > 0 ) {
						echo '<option value="All" selected disabled>'.esc_html__('Select Category', 'classiera')."</option>";
						foreach ( $parentcategories as $parentcategory ) {
						   
							echo '<option value=' . $parentcategory->term_id . '>' . $parentcategory->name . '</option>';
								$parent_id = $parentcategory ->term_id;
								$subcategories = get_categories(array ( 'child_of' => $parent_id, 'hide_empty' => false ) ) ;
				 
							foreach ( $subcategories as $subcategory ) { 
				 
								$args = array (
									'post-type'=> 'questions',
									'orderby'=> 'name',
									'order'=> 'ASC',
									'post_per_page'=> -1,
									'nopaging'=> 'true',
									'taxonomy_name'=> $subcategory->name
								); 
								 
								echo '<option value=' . $subcategory->term_id . '> - ' . $subcategory->name . '</option>';
							
							} 
						}
					} 
					?>
				</select>
				<p>NOTE: <br/><br/> Text fields will be displayed as input type=text,<br/> Checkbox will be shown as features and input type=checkbox,<br/> Dropdown will be displayed as < select >, <br/><br/>Add options for dropdown with comma separation like  option1,option2,option3</p>
			</div><!--wrap-->

		<div class="wrap" id="classiera_admin_custom_fields"></div>
			<input type="hidden" name="action" value="savecat" />
		</form>

	  <?php
	}
}
/*==========================
 Classiera : Small Title function
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_the_titlesmall')) {
	function classiera_the_titlesmall($before = '', $after = '', $echo = true, $length = false){ 
		$title = get_the_title();
		if ( $length && is_numeric($length) ) {
			$title = substr( $title, 0, $length );
		}
		if ( strlen($title)> 0 ) {
			$title = apply_filters('classiera_the_titlesmall', $before . $title . $after, $before, $after);
			if ( $echo ){
				echo esc_html($title);
			}else{
				return $title;
			}
		}
	}
}
/*==========================
 Classiera : Add ThickBox
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_add_scripts')) {
	add_action('template_redirect', 'classiera_add_scripts'); 
	function classiera_add_scripts() {
		if (is_singular()) {
		  add_thickbox(); 
		}
	}
}
/*==========================
 Classiera : Register tag cloud filter callback
 Limit number of tags inside widget
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_tag_widget_limit')) {
	add_filter('widget_tag_cloud_args', 'classiera_tag_widget_limit'); 
	function classiera_tag_widget_limit($args){
		global $redux_demo;
		$tagsnumber= $redux_demo['tags_limit']; 
		//Check if taxonomy option inside widget is set to tags
		if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
		  $args['number'] = $tagsnumber; //Limit number of tags
		}	 
		return $args;
	}
}
/*==========================
 Classiera : Get Attachment ID from SRC
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_get_attachment_id_from_src')) {
	function classiera_get_attachment_id_from_src($image_src) {
		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var($query);
		return $id;
	}
}
/*==========================
 Classiera : Get Avatar URL
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_get_avatar_url')) {
	function classiera_get_avatar_url($author_id, $size){
		$get_avatar = get_avatar_url( $author_id, $size );
		if($get_avatar){
			return ( $get_avatar );
		}		
	}
}
/*==========================
 Classiera : All Normal User to upload file
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_allow_users_uploads')) {
	function classiera_allow_users_uploads(){
		$contributor = get_role('contributor');
		if($contributor){
			$contributor->add_cap('upload_files');
			$contributor->add_cap('delete_published_posts');
		}	
		$subscriber = get_role('subscriber');
		if($subscriber){
			$subscriber->add_cap('upload_files');
			$subscriber->add_cap('delete_published_posts');
		}
	}
	add_action('admin_init', 'classiera_allow_users_uploads');
}
if (!function_exists('classiera_allow_contributor_uploads')) {
	if ( current_user_can('subscriber') || current_user_can('contributor') && !current_user_can('upload_files') ) {
		add_action('admin_init', 'classiera_allow_contributor_uploads');
	}
	function classiera_allow_contributor_uploads() {	
		$contributor = get_role('contributor');
		if($contributor){
			$contributor->add_cap('upload_files');
			$contributor->add_cap('delete_published_posts');
		}	
		$subscriber = get_role('subscriber');
		if($subscriber){
			$subscriber->add_cap('upload_files');
			$subscriber->add_cap('delete_published_posts');
		}	
	}
}
/*==========================
 Classiera : classiera_devplus_attachments_wpquery_where
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_devplus_attachments_wpquery_where')) {
	add_filter( 'posts_where', 'classiera_devplus_attachments_wpquery_where' );
	function classiera_devplus_attachments_wpquery_where( $where ){
		global $current_user;
		if ( !current_user_can( 'administrator' ) ) {
			if( is_user_logged_in() ){
				// we spreken over een ingelogde user
				if( isset( $_POST['action'] ) ){
					// library query
					if( $_POST['action'] == 'query-attachments' ){
						$where .= ' AND post_author='.$current_user->data->ID;
					}
				}
			}
		}
		return $where;
	}
}
/*==========================
 Classiera : Set Ads Expiry Schedule
 On an early action hook, check if the hook is scheduled - if not, schedule it.
 On the scheduled action hook, run a function.
 @since classiera 1.0
===========================*/
add_action( 'wp', 'classiera_ad_expiry_schedule' );
function classiera_ad_expiry_schedule() {
	if ( ! wp_next_scheduled( 'classiera_ad_expiry_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'classiera_ad_expiry_event');
	}
}
if (!function_exists('classiera_ad_expiry')) {
	add_action( 'classiera_ad_expiry_event', 'classiera_ad_expiry' );
	function classiera_ad_expiry() {
		global $wpdb;
		global $redux_demo;
		$classieraExpiry = $redux_demo['ad_expiry'];
		$featuredAdsExpiry = $redux_demo['classiera_featured_expiry'];
		if($classieraExpiry != 'lifetime'){
			$daystogo = '';
			if (!empty($redux_demo['ad_expiry'])){
				$daystogo = $redux_demo['ad_expiry'];
				$adStaus = $redux_demo['classiera_regularad_expire_status'];
				$sql =
				"UPDATE {$wpdb->posts}
				SET post_status = '{$adStaus}'
				WHERE (post_type = 'post' AND post_status = 'publish') 
				AND ID not in (select post_id from {$wpdb->postmeta} where meta_key='featured_post' and meta_value='1' )
				AND DATEDIFF(NOW(), post_date) > %d";
				$wpdb->query($wpdb->prepare( $sql, $daystogo ));
			}
		}
		if($featuredAdsExpiry == 1){
			$todayDate = strtotime(date('m/d/Y h:i:s'));
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'featured_post',
						'value' => '1',
						'compare' => '='
					),
					array(
					   'key' => 'post_price_plan_expiration_date',
					   'value' => $todayDate,
					   'compare' => '<'
					),				
				)       
			);
			$featuredPosts = get_posts($args);
			if ( $featuredPosts ) {
				foreach ( $featuredPosts as $post ){
					setup_postdata( $post );
					$featured_post = get_post_meta($post->ID, 'featured_post', true);
					$activationdate = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
					$expireDate = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
					if(!empty($activationdate) && $featured_post == '1'){
						if(($todayDate > $expireDate) && $expireDate != '0') {
							update_post_meta($post->ID, 'featured_post', '2' );
							$user_ID = $post->post_author;
							$authorName = get_the_author_meta('display_name', $user_ID );
							if(empty($authorName)){
								$authorName = get_the_author_meta('user_nicename', $user_ID );
							}
							if(empty($authorName)){
								$authorName = get_the_author_meta('user_login', $user_ID );
							}
							$authorEmail = get_the_author_meta('user_email', $user_ID);
							$postTitle = get_the_title($post->ID);
							$postID = $post->ID;
							classiera_featured_ads_expire($authorName, $authorEmail, $postTitle, $postID);
						}
					}
				}
				wp_reset_postdata();
			}
		}
	}
}
/*==========================
 Classiera : Create Pricing Plans SQL Table When Active Theme
 Create Inbox SQL table When Active Theme
 Assign auto Plan to admin user 1 When active theme
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_admin_featuredPlan')) {
	add_action( 'after_setup_theme', 'classiera_admin_featuredPlan' );
	function classiera_admin_featuredPlan() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$tablename = $wpdb->prefix . 'classiera_plans';	
		$adminPlanSql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_plans(
			id int(11) NOT NULL AUTO_INCREMENT,
			product_id TEXT ,
			plan_id TEXT ,
			user_id TEXT NOT NULL ,
			plan_name TEXT NOT NULL ,
			price FLOAT UNSIGNED NOT NULL ,
			ads TEXT ,
			regular_ads TEXT ,
			days TEXT NOT NULL ,
			date TEXT NOT NULL ,
			status TEXT NOT NULL ,
			used TEXT NOT NULL ,
			regular_used TEXT NOT NULL ,
			created INT( 4 ) UNSIGNED NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;");
		
		$wpdb->query($adminPlanSql);	
		$price_plan_information = array(
			'id' =>'',
			'product_id' => '',
			'plan_id' => '',
			'user_id' => '1',
			'plan_name' => 'Unlimited Ads',
			'price' => '',
			'ads' => 'unlimited',
			'regular_ads' => 'unlimited',
			'days' => 'unlimited',
			'status' => "complete",
			'used' => "0",
			'regular_used' => "0",
			'created' => time()
		);	
		$insert_format = array('%d', '%d', '%d', '%d', '%s','%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
		$adminID = 1;	
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}classiera_plans WHERE user_id =%d", $adminID));
		if (empty($results )){
			$wpdb->insert($tablename, $price_plan_information, $insert_format);
		}
		/*Classiera Inbox table*/
		$classieraInbox = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_inbox(
			id int(11) NOT NULL AUTO_INCREMENT,
			offer_post_id BIGINT NOT NULL  ,
			offer_post_price BIGINT NOT NULL  ,
			post_author_id BIGINT NOT NULL  ,
			offer_author_id BIGINT NOT NULL ,
			offer_price BIGINT NOT NULL ,	
			offer_comment TEXT ,		
			date TEXT NOT NULL ,
			INDEX (offer_post_id, post_author_id, offer_author_id),
			PRIMARY KEY (id)
		) $charset_collate;");	
		$classieraInboxMeta = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_inbox_meta(
			id int(11) NOT NULL AUTO_INCREMENT,
			main_comment_id BIGINT NOT NULL  ,		
			post_author_id BIGINT NOT NULL  ,
			offer_author_id BIGINT NOT NULL ,
			comment_reply TEXT ,		
			reply_check TEXT ,		
			date TEXT NOT NULL ,
			INDEX(main_comment_id, post_author_id, offer_author_id),
			PRIMARY KEY (id)
		) $charset_collate;");	
		$classieraReadMSG = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classiera_inbox_read(
			id int(11) NOT NULL AUTO_INCREMENT,
			message_id BIGINT NOT NULL  ,		
			recipient_id BIGINT ,		
			message_status TEXT ,
			INDEX(message_id, recipient_id),
			PRIMARY KEY (id, recipient_id)
		) $charset_collate;");
		$wpdb->query($classieraInbox);	
		$wpdb->query($classieraInboxMeta);
		$wpdb->query($classieraReadMSG);	
		
	}
}
/*==========================
 Classiera : Infinite Pagination
 @since classiera 1.0
 ===========================*/
if (!function_exists('infinite')){
	function infinite($query) {
		global $redux_demo;
		$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		$classieraBtnStyle = $redux_demo['classiera_cat_style'];
		if($classieraBtnStyle == 1){
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}elseif($classieraBtnStyle == 2){
			$classierabtnClass = 'btn btn-primary round btn-md btn-style-two';
		}elseif($classieraBtnStyle == 3){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-three';
		}elseif($classieraBtnStyle == 4){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-four';
		}elseif($classieraBtnStyle == 5 || $classieraBtnStyle == 8 || $classieraBtnStyle == 9){
			$classierabtnClass = 'btn btn-primary outline btn-md btn-style-five';
		}elseif($classieraBtnStyle == 6){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}elseif($classieraBtnStyle == 7){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}else{
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}
		
		$pages = intval($query->max_num_pages);
		$paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
		if (empty($pages)) {
			$pages = 1;
		}
		if (1 != $pages) {
			echo '<p class="jw-pagination jw-infinite-scroll simple-pagination" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
			echo '<a class="'.$classierabtnClass.' no-more" href="#"><i class="fas fa-sync-alt"></i>' . esc_html_e('No more posts', 'classiera') . '</a>';
			echo '<a class="'.$classierabtnClass.' loading" href="#"><i class="fas fa-sync-alt"></i>' . esc_html_e('Loading posts ...', 'classiera') . '</a>';
			echo '<a class="'.$classierabtnClass.' next" href="' . get_pagenum_link($paged + 1) . '"><i class="fas fa-sync-alt"></i>' . esc_html_e('Load More ', 'classiera') . '</a>';
			echo '</p>';
			?>
			<div class="jw-pagination jw-infinite-scroll" data-has-next="<?php if($paged === $pages){ echo 'false'; }else{ echo 'true'; } ?>">
				<div class="clearfix">					
				</div>				
				<div class="more-btn-main">
					<div class="view-more-separator"></div>
						<div class="view-more-btn">
						<div class="more-btn-inner text-center">
							<a class="next <?php echo esc_attr($classierabtnClass); ?>" href="<?php echo get_pagenum_link($paged + 1);?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fas fa-sync-alt"></i>
								<?php } ?>
								<?php esc_html_e( 'Load more', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fas fa-sync-alt"></i></span>
								<?php } ?>
							</a>
							<a class="loading <?php echo esc_attr($classierabtnClass); ?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fas fa-sync-alt"></i>
								<?php } ?>
								<?php esc_html_e( 'Loading posts ...', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fas fa-sync-alt"></i></span>
								<?php } ?>
							</a>
							<a class="no-more <?php echo esc_attr($classierabtnClass); ?>">
								<?php if($classieraBtnStyle == 1){?>
								<i class="icon-left fas fa-sync-alt"></i>
								<?php } ?>
								<?php esc_html_e( 'No more posts', 'classiera' ); ?>
								<?php if($classieraBtnStyle == 2){?>
								<span><i class="fas fa-sync-alt"></i></span>
								<?php } ?>
							</a>
						</div>
					</div>				
				</div>		
			</div>
			<?php 
		}
	}

}
/*==========================
 Classiera : set excerpt length for blog posts
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_blog_excerpt_length')){ 
	function classiera_blog_excerpt_length($length) {
		global $post;
		if ($post->post_type == 'blog'){
			return 150;
		}
		else {
			return $length;
		}
	}
	add_filter('excerpt_length', 'classiera_blog_excerpt_length', 1000);	
}
/*==========================
 Classiera : Start Classiera Favourite Function
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_authors_tbl_create')) {
	function classiera_authors_tbl_create() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$sqfollowers = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_followers(
			id int(11) NOT NULL AUTO_INCREMENT,
			author_id int(11) NOT NULL,		
			follower_id int(11) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;");
		$sqlfavorite = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_favorite(
			id int(11) NOT NULL AUTO_INCREMENT,
			author_id int(11) NOT NULL,		
			post_id int(11) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;");
		$wpdb->query($sqfollowers);
		$wpdb->query($sqlfavorite);
	}
	add_action( 'init', 'classiera_authors_tbl_create', 1 );
}
if (!function_exists('classiera_authors_insert')) {
	function classiera_authors_insert($author_id, $follower_id) {
		global $wpdb;
		$classieraTable = $wpdb->prefix.'author_followers';
		$wpdb->insert($classieraTable, array('author_id' => $author_id, 'follower_id' => $follower_id), array('%d', '%d'));
	}
}
if (!function_exists('classiera_authors_unfollow')) {
	function classiera_authors_unfollow($author_id, $follower_id) {
		global $wpdb;
		$classieraTable = $wpdb->prefix.'author_followers';
		$wpdb->delete($classieraTable, array('author_id' => $author_id, 'follower_id' => $follower_id), array('%d', '%d'));
	}
}
if (!function_exists('classiera_authors_follower_check')) {
	function classiera_authors_follower_check($author_id, $follower_id) {
		global $wpdb;
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id ={$follower_id} AND author_id = %d", $author_id));
		if(empty($results)){
			?>
			<form method="post" class="classiera_follow_user">
				<input type="hidden" name="author_id" value="<?php echo esc_attr($author_id); ?>"/>
				<input type="hidden" name="follower_id" value="<?php echo esc_attr($follower_id); ?>"/>
				<input type="submit" name="follower" value="<?php esc_attr_e( 'Follow', 'classiera' ); ?>" />
			</form>
			<div class="clearfix"></div>
			<?php
		}else{
			?>
			<form method="post" class="classiera_follow_user">
				<input type="hidden" name="author_id" value="<?php echo esc_attr($author_id); ?>"/>
				<input type="hidden" name="follower_id" value="<?php echo esc_attr($follower_id); ?>"/>
				<input type="submit" name="unfollow" value="<?php esc_attr_e( 'Unfollow', 'classiera' ); ?>" />
			</form>
			<div class="clearfix"></div>
			<?php
		}
	}
}
if (!function_exists('classiera_authors_all_follower')) {
	function classiera_authors_all_follower($author_id){
		global $wpdb;
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id =%d", $author_id));
		$results2 = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id =%d", $author_id));
		
		$followcounter = count($results);
		$followingcounter = count($results2);
		?>
		<div class="clearfix"></div>
		<div class="followers clearfix">
		<?php
		echo '<h1>Followers &nbsp;'.$followcounter.'</h1>';
		if(!empty($results)){
			$avatar = $results['0']->follower_id;
			echo '<div class="follower-avatar">';
			echo get_avatar($avatar, 70);
			echo '</div>';
		}
		?>
		</div>
		<div class="following">
		<?php
		echo '<h1>Following &nbsp;'.$followingcounter.'</h1>';
		if(!empty($results2)){
			$avatar = $results2['0']->author_id;
			echo '<div class="follower-avatar">';
			echo get_avatar($avatar, 70);
			echo '</div>';
		}
		?>
		</div>
		<?php
	}
}
if (!function_exists('classiera_favorite_insert')) {
	function classiera_favorite_insert($author_id, $post_id) {
		global $wpdb;
		$classieraTable = $wpdb->prefix.'author_favorite';
		$wpdb->insert($classieraTable, array('author_id' => $author_id, 'post_id' => $post_id), array('%d', '%d'));
	}
}
if (!function_exists('classiera_authors_unfavorite')) {
	function classiera_authors_unfavorite($author_id, $post_id) {   
		global $wpdb;	
		$classieraTable = $wpdb->prefix.'author_favorite';
		$wpdb->delete($classieraTable, array('author_id' => $author_id, 'post_id' => $post_id), array('%d', '%d'));
	}
}
if (!function_exists('classiera_authors_favorite_check')) {
	function classiera_authors_favorite_check($author_id, $post_id) {
		global $wpdb;
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = {$post_id} AND author_id = %d", $author_id));
		if(empty($results)){
			?>
			<form method="post" class="fav-form clearfix">
				<input type="hidden" name="author_id" value="<?php echo esc_attr($author_id); ?>"/>
				<input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>"/>
				<button type="submit" value="favorite" name="favorite" class="watch-later text-uppercase btn-block">
					<i class="fas fa-heart"></i><?php esc_html_e( 'Save Ad', 'classiera' ); ?>
				</button>
			</form>
			<?php
		}else{			
			$all_fav_permalink = classiera_get_template_url('template-favorite.php');		
			echo '<a class="fav" href="'.esc_url($all_fav_permalink).'"><i class="far fa-heart unfavorite-i"></i> <span>'.esc_html__( 'Browse Favourites', 'classiera' ).'</span></a>';
		}
	}
}
if (!function_exists('classiera_authors_favorite_remove')) {
	function classiera_authors_favorite_remove($author_id, $post_id) {
		global $wpdb;
		$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = {$post_id} AND author_id = %d", $author_id));
		if(!empty($results)){
			$iconClass = 'icon-left';
			if(is_rtl()){
				$iconClass = 'icon-right';
			}
			?>
			<form method="post" class="unfavorite">
				<input type="hidden" name="author_id" value="<?php echo esc_attr($author_id); ?>"/>
				<input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>"/>
				<div class="unfavorite">
					<button type="submit" name="unfavorite" class="btn btn-primary sharp btn-style-one btn-sm"><i class="<?php echo esc_attr($iconClass); ?> far fa-heart"></i><?php esc_html_e( 'Unfavourite', 'classiera' ); ?></button>
				</div>
			</form>
			<?php
		}
	}
}
if (!function_exists('classiera_authors_all_favorite')) {
	function classiera_authors_all_favorite($author_id) {
		global $wpdb;
		$prepared_statement = $wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE  author_id = %d", $author_id);
		$postids = $wpdb->get_col($prepared_statement);	
		foreach ($postids as $v2){
			$postids[] = $v2;
		}
		return $postids;
	}
}
/*==========================
 Classiera : WooCommerece Rating Function
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_get_star_rating')) {
	add_action('woocommerce_after_shop_loop_item', 'classiera_get_star_rating' );
	function classiera_get_star_rating(){
		global $woocommerce, $product;
		$average = $product->get_average_rating();	
		echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.esc_html_e( 'out of 5', 'classiera' ).'</span></div>';
	}
}
/*==========================
 Classiera : Change the breadcrumb separator
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_wcc_breadcrumb')) {
	add_filter( 'woocommerce_breadcrumb_defaults', 'classiera_wcc_breadcrumb' );
	function classiera_wcc_breadcrumb( $defaults ) {
		$defaults['home'] = esc_html__('Home','classiera');
		$defaults['delimiter'] = '&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;';
		return $defaults;
	}
}
/*==========================
 Classiera : WooCommerece great deal Function
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_custom_sale_flash')) {
	add_filter('woocommerce_sale_flash', 'classiera_custom_sale_flash', 10, 3);
	function classiera_custom_sale_flash($text, $myPost) {
		return '<span class="great"> '.esc_html__('Great Deal','classiera').' </span>';   
	}
}
/*==========================
 Classiera : Display Global ajax URL
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_ajaxURL')) {
	add_action('wp_head','classiera_ajaxURL');
	function classiera_ajaxURL() { 
		$current_user = wp_get_current_user();
		$user_ID = $current_user->ID;
	?>
		<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var classieraCurrentUserID = '<?php echo esc_attr($user_ID); ?>';
		</script>
	<?php 
	}
}
/*==========================
 Classiera : WordPress Users Role translation
 @since classiera 1.0
===========================*/
if (!function_exists('classieraRoleTrns')) {
	function classieraRoleTrns($classieraRole){
		if($classieraRole == 'administrator'){
			$classieraUserRole =  esc_html__( 'Administrator', 'classiera' );
		}elseif($classieraRole == 'contributor'){
			$classieraUserRole =  esc_html__( 'Contributor', 'classiera' );
		}elseif($classieraRole == 'subscriber'){
			$classieraUserRole =  esc_html__( 'Subscriber', 'classiera' );
		}elseif($classieraRole == 'author'){
			$classieraUserRole =  esc_html__( 'Author', 'classiera' );
		}elseif($classieraRole == 'editor'){
			$classieraUserRole =  esc_html__( 'Editor', 'classiera' );
		}else{
			$classieraUserRole =  esc_html__( 'User', 'classiera' );
		}
		echo esc_html($classieraUserRole);
	}
}
/*==========================
 Classiera : WordPress Post Status translation
 @since classiera 1.0
 ===========================*/
if (!function_exists('classieraPStatusTrns')) {
	function classieraPStatusTrns($classieraPstatus){
		if($classieraPstatus == 'publish'){
			$pStatus =  esc_html__( 'Publish', 'classiera' );
		}elseif($classieraPstatus == 'pending'){
			$pStatus =  esc_html__( 'Pending', 'classiera' );
		}elseif($classieraPstatus == 'draft'){
			$pStatus =  esc_html__( 'Draft', 'classiera' );
		}elseif($classieraPstatus == 'auto-draft'){
			$pStatus =  esc_html__( 'Auto draft', 'classiera' );
		}elseif($classieraPstatus == 'future'){
			$pStatus =  esc_html__( 'Future', 'classiera' );
		}elseif($classieraPstatus == 'private'){
			$pStatus =  esc_html__( 'Private', 'classiera' );
		}elseif($classieraPstatus == 'inherit'){
			$pStatus =  esc_html__( 'Inherit', 'classiera' );
		}elseif($classieraPstatus == 'trash'){
			$pStatus =  esc_html__( 'Trash', 'classiera' );
		}elseif($classieraPstatus == 'rejected'){
			$pStatus =  esc_html__( 'Rejected', 'classiera' );
		}elseif($classieraPstatus == 'expired'){
			$pStatus =  esc_html__( 'Expired', 'classiera' );
		}else{
			$pStatus =  esc_html__( 'None', 'classiera' );
		}
		echo esc_html($pStatus);
	}
}
/*==========================
 Classiera : Classiera Ads Type Function
 @since classiera 1.0
 ===========================*/
if (!function_exists('classiera_buy_sell')) {
	function classiera_buy_sell($text){	
		$string = str_replace(' ', '', $text);
		if($string == 'buy'){
			$returnVal = esc_html__( 'Wanted', 'classiera' );
		}elseif($string == 'sell'){
			$returnVal = esc_html__( 'For Sale', 'classiera' );
		}elseif($string == 'sold'){
			$returnVal = esc_html__( 'Sold', 'classiera' );
		}elseif($string == 'rent'){
			$returnVal = esc_html__( 'For Rent', 'classiera' );
		}elseif($string == 'hire'){
			$returnVal = esc_html__( 'For Hire', 'classiera' );
		}elseif($string == 'lostfound'){
			$returnVal = esc_html__( 'Lost & Found', 'classiera' );
		}elseif($string == 'free'){
			$returnVal = esc_html__( 'Free', 'classiera' );
		}elseif($string == 'event'){
			$returnVal = esc_html__( 'Event', 'classiera' );
		}elseif($string == 'service'){
			$returnVal = esc_html__( 'PRO SERVICES', 'classiera' );
		}elseif($string == 'exchange'){
			$returnVal = esc_html__( 'Exchange', 'classiera' );	
		}else{
			$returnVal = '';
		}
		echo esc_html($returnVal);
		
	}
}

/*==========================
 Classiera : Check if category has children
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_cat_has_child')) {
	function classiera_cat_has_child($mainID){
		global $wpdb;
		$term = $mainID;
		$children_check = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE parent =%d", $term));
		if($children_check){
			return true;
		}else{
			return false;
		}
	}
}
/*==========================
 Classiera : Display Categories level
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_Display_cat_level')) {
	function classiera_Display_cat_level($classieraPostID){
		$categories = get_the_category($classieraPostID);	
		if(!empty($categories)){		
			$output = "";
			$mainCat = "";
			$childCat = '';	
			$putspace = '';	
			$count = 0;
			foreach ($categories as $category){
				if(!$category->parent){
					if($count >= 1){
						$putspace = '&nbsp;/&nbsp;';
					}				
					$mainCat = $category->term_id;
					$output .= ''.$putspace.'<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
					$count++;
				}
			}		
			if(!empty($mainCat)){
				foreach ($categories as $category) {
					if( $category->parent == $mainCat){
						$childCat = $category->term_id;
						$output .= ' / <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
					}
				}
			}		
			if(!empty($childCat)){
				foreach ($categories as $category) {
					if( $category->parent == $childCat){
						$output .= ' / <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
					}
				}
			}
			if(empty($output)){
				foreach ($categories as $category){
					$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'classiera'), $category->name ) ) . '" >' . $category->name.'</a>';
				}
			}		
			echo trim( $output, "," );
		}
	}
}
/*==========================
 Classiera : Get Categories On Edit Ads Page
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_get_cats_on_edit')) {
	function classiera_get_cats_on_edit($classieraCatID){
		$classieraparentid = '';
		$catID1 = '';
		$catID2 = '';
		$catID3 = '';	
		$catName1 = '';	
		$catName2 = '';	
		$catName3 = '';	
		$post_main_cat = '';	
		$post_child_cat = '';	
		$post_inner_cat = '';	
		$category = get_category($classieraCatID);
		$classieraparentid = $category->category_parent;
		if($classieraparentid == 0){
			$catID1 = $category->term_id;
			$catName1 = $category->slug;
			$post_main_cat = $category->term_id;
		}else{
			$catID1 = $category->term_id;
			$catName1 = $category->slug;
			$post_child_cat = $category->term_id;
			$post_inner_cat = $category->term_id;
			
			$category2 = get_category($classieraparentid);
			$classieraparentid2 = $category2->category_parent;
			if($classieraparentid2 == 0){
				$catID2 = $category2->term_id;
				$catName2 = $category2->slug;
				$post_main_cat = $category2->term_id;
				$post_inner_cat = '';
			}else{
				$catID2 = $category2->term_id;
				$catName2 = $category2->slug;
				$post_child_cat = $category2->term_id;
				
				$category3 = get_category($classieraparentid2);
				$catID3 = $category3->term_id;
				$catName3 = $category3->slug;
				$post_main_cat = $category3->term_id;
			}
		}	
		$returnArray = array(
			'post_main_cat' => $post_main_cat,
			'post_child_cat' => $post_child_cat,
			'post_inner_cat' => $post_inner_cat,
		);
		return $returnArray;	
	}
}
/*==========================
 Classiera : Get Template URL with template name.
 Mostly Used for WPML
===========================*/
if (!function_exists('classiera_get_template_url')) {
	function classiera_get_template_url($templatename){
		$url = '';
		$archive_page = get_pages(
			array(
				'meta_key' => '_wp_page_template',
				'meta_value' => $templatename,
				'suppress_filters' => false,
			)
		);
		if($archive_page){
			$pageID = $archive_page[0]->ID;
			$url = get_permalink($pageID);
		}else{
			$url = home_url();
		}		
		return $url;
	}
}
/*==========================
 Classiera : Get MAX Offer value
===========================*/
if (!function_exists('classiera_max_offer_price')) {
	function classiera_max_offer_price($postID){
		global $wpdb;
		$classieraMaxOfferSQL = $wpdb->get_results($wpdb->prepare("SELECT MAX(`offer_price`) FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id =%d", $postID));
		$classieraMaxOfferSQL = $classieraMaxOfferSQL[0];
		if($classieraMaxOfferSQL){
			foreach($classieraMaxOfferSQL as $key => $values){
				$classieraMaxOffer = $values;
			}
		}
		return $classieraMaxOffer;
	}
}
/*==========================
 Classiera : Get MIN Offer value
===========================*/
if (!function_exists('classiera_min_offer_price')) {
	function classiera_min_offer_price($postID){
		global $wpdb;
		$classieraMINOfferSQL = $wpdb->get_results($wpdb->prepare("SELECT MIN(`offer_price`) FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id =%d", $postID));
		$classieraMINOfferSQL = $classieraMINOfferSQL[0];
		if($classieraMINOfferSQL){
			foreach($classieraMINOfferSQL as $key => $values){
				$classieraMinOffer = $values;
			}
		}
		return $classieraMinOffer;
	}
}
/*==========================
 Classiera : Display Verified Icon
===========================*/
if (!function_exists('classiera_author_verified')) {
	function classiera_author_verified($authorID){
		$authorVerified = get_the_author_meta('author_verified', $authorID);
		if($authorVerified == 'verified'){
			$html = '<span class="small classiera_verified">'.esc_html__('Verified', 'classiera').'</span><i class="far fa-check-circle classiera_verified" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Verified', 'classiera').'"></i>';
		}else{
			$html = '<span class="small text-danger classiera_verified">'.esc_html__('Not verified', 'classiera').'</span><i class="far fa-times-circle text-danger classiera_verified" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Not verified', 'classiera').'"></i>';
		}
		if($html){
			return $html;
		}
	}
}
/*==========================
 Count Total BID for a single User
===========================*/
if (!function_exists('classiera_total_user_bids')) {
	function classiera_total_user_bids($userID){
		global $wpdb;		
		$countBids = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox WHERE post_author_id = $userID" );
		return $countBids; 
	}
}
/*==========================
 Count Total BID on a Post Function
===========================*/
if (!function_exists('classiera_bid_count')) {
	function classiera_bid_count($postID){
		global $post, $wpdb;		
		$countBids = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox WHERE offer_post_id = $postID" );
		return $countBids; 
	}
}
/*==========================
 Delete BID Comment Function
===========================*/
if (!function_exists('classiera_delete_comment')) {
	function classiera_delete_comment($commentID){
		global $wpdb;		
		$runquery = ("DELETE FROM {$wpdb->prefix}classiera_inbox WHERE id = $commentID");
		$wpdb->query($runquery);
		$deleteRead = ("DELETE FROM {$wpdb->prefix}classiera_inbox_read WHERE message_id = $commentID");
		$wpdb->query($deleteRead);
	}
}
/*==========================
 Current User have Unread Message
===========================*/
if (!function_exists('classiera_unread_message_by_user')) {
	function classiera_unread_message_by_user($userID){
		global $wpdb;
		$readMessageQuery = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox_read WHERE recipient_id = $userID" );
		return $readMessageQuery;
	}
}
if (!function_exists('classiera_unread_message_comment')) {
	function classiera_unread_message_comment($commentID){
		global $wpdb;
		$readMessageQuery = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}classiera_inbox_read WHERE message_id = $commentID" );
		return $readMessageQuery;
	}
}
/*==========================
 Show Post ID in WordPress Admin
===========================*/
if (!function_exists('classiera_add_id_column')) {
	add_filter( 'manage_posts_columns', 'classiera_add_id_column', 5 );
	function classiera_add_id_column( $columns ) {
	   $columns['classiera_ad_id'] = 'ID';
	   return $columns;
	}
}
if (!function_exists('classiera_id_column_content')) {
	add_action( 'manage_posts_custom_column', 'classiera_id_column_content', 5, 2 );
	function classiera_id_column_content( $column, $id ) {
	  if( 'classiera_ad_id' == $column ) {
		echo esc_attr($id);
	  }
	}
}
/*==========================
 Classiera Button Styles
===========================*/
if (!function_exists('classiera_btn_styles')) { 
	function classiera_btn_styles(){
		global $redux_demo;
		$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		$classieraBtnStyle = $redux_demo['classiera_cat_style'];
		if($classieraBtnStyle == 1){
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}elseif($classieraBtnStyle == 2){
			$classierabtnClass = 'btn btn-primary round btn-md btn-style-two';
		}elseif($classieraBtnStyle == 3){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-three';
		}elseif($classieraBtnStyle == 4){
			$classierabtnClass = 'btn btn-primary radius btn-md btn-style-four';
		}elseif($classieraBtnStyle == 5){
			$classierabtnClass = 'btn btn-primary outline btn-md btn-style-five';
		}elseif($classieraBtnStyle == 6){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}elseif($classieraBtnStyle == 7){
			$classierabtnClass = 'btn btn-primary round outline btn-style-six';
		}else{
			$classierabtnClass = 'btn btn-primary sharp btn-sm btn-style-one';
		}
		return $classierabtnClass;
	}
}
/*==========================
 Google (reCAPTCHA) plugin
===========================*/
if (!function_exists('classiera_Google_reCaptcha')) {
	function classiera_Google_reCaptcha( $forms ){
		$forms['classiera_login_form'] = array( 
			"form_name" => esc_html__( 'Classiera Login Form', 'classiera' ),
		);
		$forms['classiera_register_form'] = array( 
			"form_name" => esc_html__( 'Classiera Register Form', 'classiera' ),
		);	
		return $forms;
	}
	add_filter( 'gglcptch_add_custom_form', 'classiera_Google_reCaptcha' );
}
/*==========================
 Classiera Mark as Sold function
===========================*/
if(!function_exists('classiera_post_mark_as_sold')) { 
	function classiera_post_mark_as_sold($soldId){
		global $post;
		update_post_meta($soldId, 'classiera_ads_type', 'sold');
	} 
}
/*==========================
 Classiera Mark as UN Sold function
===========================*/
if(!function_exists('classiera_post_mark_as_unsold')) {  
	function classiera_post_mark_as_unsold($un_sold_id){
		global $post;
		update_post_meta($un_sold_id, 'classiera_ads_type', 'sell');
	}
} 
/*==========================
 Classiera: Grid List Loop Classes
===========================*/
if(!function_exists('classiera_grid_classes')) {
	function classiera_grid_classes(){
		global $redux_demo;
		$classieraAdsView = $redux_demo['home-ads-view'];
		$classieraItemClass = "item-grid";
		if(is_front_page() || is_page_template('template-homepage-v1.php') || is_page_template('template-homepage-v2.php') || is_page_template('template-homepage-v3.php') || is_page_template('template-homepage-v4.php') || is_page_template('template-homepage-v5.php') || is_page_template('template-homepage-v6.php') || is_page_template('template-homepage-v7.php') || is_page_template('template-landing.php')){
			$classieraAdsView = $redux_demo['home-ads-view'];
			if($classieraAdsView == 'grid'){
				$classieraItemClass = "item-grid";
			}elseif($classieraAdsView == 'list'){
				$classieraItemClass = "item-list";
			}elseif($classieraAdsView == 'medium'){
				$classieraItemClass = "item-grid-medium";
			}
		}else{
			if($classieraAdsView == 'grid'){
				$classieraItemClass = "item-grid";
			}elseif($classieraAdsView == 'list'){
				$classieraItemClass = "item-list";
			}elseif($classieraAdsView == 'medium'){
				$classieraItemClass = "item-grid";
			}
		}
		return $classieraItemClass;
	}
}
/*==========================
 Classiera : Classiera Ads Type Function
 @since classiera 1.0
===========================*/
if (!function_exists('classiera_ad_condition')) {
	function classiera_ad_condition($text){	
		$string = str_replace(' ', '', $text);
		if($string == 'used'){
			$returnVal = esc_html__( 'Used', 'classiera' );
		}elseif($string == 'new'){
			$returnVal = esc_html__( 'Brand New', 'classiera' );
		}else{
			$returnVal = '';
		}
		return $returnVal;
		
	}
}
/*==========================
 Classiera : Get Inner Level categories
 @since classiera 4.0.4
===========================*/
if (!function_exists('classiera_get_category')) {
	function classiera_get_category($postID){
		$categoryName = '';
		$categories = get_the_category( $postID );
		foreach($categories as $category){
			$categoryName = $category->name;
		}
		return $categoryName;
	}
}
if (!function_exists('classiera_get_category_link')) {
	function classiera_get_category_link($postID){
		$categoryID = '';
		$categoryLink = '';
		$categories = get_the_category( $postID );
		foreach($categories as $category){
			$categoryID = $category->cat_ID;
		}
		if(!empty($categoryID)){
			$categoryLink = get_category_link($categoryID);
		}
		return $categoryLink;
	}
}
if (!function_exists('classiera_excerpt_more')){
	function classiera_excerpt_more($more){
		return '';
	}
	add_filter( 'excerpt_more', 'classiera_excerpt_more' );
}
add_filter('jpeg_quality', function($arg){return 40;});





// Remove additional information tab
add_filter( 'woocommerce_product_tabs', 'remove_additional_information_tab', 100, 1 );
function remove_additional_information_tab( $tabs ) {
    unset($tabs['additional_information']);

    return $tabs;
}

// Add "additional information" after add to cart
add_action( 'woocommerce_single_product_summary', 'additional_info_under_add_to_cart', 35 );
function additional_info_under_add_to_cart() {
    global $product;

    if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
        wc_display_product_attributes( $product );
    }
}
