<?php 
/* 
 * used to display blog posts items in archives and listings 
 *
 * need to be called within the loop
 */
 ?>	
<?php 
global $redux_demo;
$classieraComments = $redux_demo['classiera_sing_post_comments'];
?>
<article class="blog article-content">
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p>
		<span><i class="fas fa-user"></i><?php the_author(); ?></span>
		<?php $dateFormat = get_option( 'date_format' );?>
		<span class="classiera_pdate"><i class="far fa-clock"></i><?php echo get_the_date($dateFormat, $post->ID); ?></span>
		<?php if($classieraComments == true){ ?>
		<span><i class="fas fa-comments"></i><?php echo comments_number(); ?></span>
		<?php } ?>
	</p>
	<?php if ( has_post_thumbnail() ){?>
	<div class="blog-img">
		<?php 
		$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		?>
		<img class="thumbnail" src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php the_title(); ?>">
	</div>
	<?php } ?>
	<?php the_excerpt(); ?>
	<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md sharp btn-style-one">
		<i class="icon-left fas fa-arrow-circle-right"></i><?php esc_html_e( 'Read More', 'classiera' ); ?>
	</a>
</article>