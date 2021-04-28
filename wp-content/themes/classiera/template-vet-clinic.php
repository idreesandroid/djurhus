<?php
/**
 * Template name: Vet Clinic
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

// if ( !is_user_logged_in() ) { 	
// 	$login = classiera_get_template_url('template-login.php');
// 	if(empty($login)){
// 		$login = classiera_get_template_url('template-login-v2.php');
// 	}
// 	wp_redirect( $login ); exit;
// }
global $redux_demo; 
$edit = classiera_get_template_url('template-edit-profile.php');
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = sanitize_text_field($_GET['delete_id']);
	$deletePostAuthorId = get_post_field( 'post_author', $deleteUrl);
	$current_user = wp_get_current_user();
	$current_userID = $current_user->ID;
	if($current_userID == $deletePostAuthorId){
		wp_delete_post($deleteUrl);
	}
}
if(isset($_POST['unfavorite'])){
	$author_id = sanitize_text_field($_POST['author_id']);
	$post_id = sanitize_text_field($_POST['post_id']);
	echo classiera_authors_unfavorite($author_id, $post_id);	
}
if(isset($_GET['sold_id'])){
	$sold_post_id = sanitize_text_field($_GET['sold_id']);
	echo classiera_post_mark_as_sold($sold_post_id);
}
if(isset($_GET['un_sold_id'])){
	$un_sold_id = sanitize_text_field($_GET['un_sold_id']);
	echo classiera_post_mark_as_unsold($un_sold_id);
}
if(isset($_GET['restore_id'])){
	$restore_id = sanitize_text_field($_GET['restore_id']);
	global $post;
	$time = current_time('mysql');
	$args = array(
		'ID' => $restore_id,
		'post_date' => $time,
		'post_date_gmt' => get_gmt_from_date( $time ),
		'post_status' => 'publish',
	);
	wp_update_post($args);
}
global $current_user, $user_id;
$current_user = wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID;
get_header(); 
?>
<?php 
$args = array(  
    'post_type' => 'blog',
    'post_status' => 'publish',
    'orderby' => 'id', 
    'order' => 'ASC', 
    'posts_per_page'=>-1,
);

$blogs = new WP_Query( $args ); 

?>
<!-- user pages -->
<section class="user-pages section-gray-bg">
	<div class="container">
    <div class="row">
			<div class="col-lg-12 col-md-12 user-content-height">
				<div class="user-detail-section section-bg-white">
					<!-- my ads -->
					<h2 class="vet_title">S B = samling och behandling, L = lagring, D = distribution, Se = seminering</h2>
					<div class="row">
					<?php echo do_shortcode('[wpsl]'); ?>
						
					</div><!--user-ads user-my-ads-->
					<!-- my ads -->
				</div><!--user-detail-section-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!-- container-->
</section>
<!-- user pages -->
<?php get_footer(); ?>