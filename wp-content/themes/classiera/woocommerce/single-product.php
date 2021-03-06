<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>


<?php


//for each category, show 5 posts
$cat_args=array(
  'orderby' => 'name',
  'order' => 'ASC',
  'taxonomy' => 'product_cat',
  'post_type' => 'product',
  'exclude' => '1',
  'number' => 5

   );
$categories=get_categories($cat_args);
?>
<div id="categoryMenuItems" class="classiera-navbar classiera-navbar-v6 menu_bg">
    <nav class="row">
        <div class="col-md-9 col-lg-9">
            <ul class="menu_cat_list">
                <?php
                foreach($categories as $category) { ?>
                    <li>
                        <a href="<?php echo get_category_link( $category->term_id ); ?> "> 
                            <?php echo $category->name; ?> 
                        </a>
                    </li>
                <?php  } ?>
            </ul>
        </div>
        <?php echo get_search_form(); ?>
    </nav>
</div>





<div class="inner-page-content single-post-page testSingleProClass">
	<div class="container">
		<div class="row">
		     <?php do_action( 'woocommerce_before_main_content' ); ?>
			<div class="col-md-8 col-lg-9">
				<article class="article-content">
					<h3><?php the_title(); ?></h3>
				</article>
				<div class="woocommerce">
					<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'single-product' ); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<div class="col-md-4 col-lg-3">
				<aside class="sidebar">
					<div class="row">
						<?php //do_action( 'woocommerce_sidebar' ); ?>
						<?php dynamic_sidebar('woocommerce'); ?>
					</div><!--row-->
				</aside><!--sidebar-->
			</div><!--col-md-4 col-lg-3-->
		</div>
		<?php do_action( 'woocommerce_after_main_content' ); ?>
	</div><!--container-->
</div>
<?php get_footer( 'shop' );