<?php
/**
 * The template for displaying all pages.
 * Template Name: checkout page
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 1.0
 */

get_header();
 ?>

<?php 

	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true); 
	$page_custom_title = get_post_meta($current_page_id, 'page_custom_title', true);

	global $redux_demo;
	$caticoncolor="";
	$category_icon_code ="";
	$category_icon="";
	$category_icon_color="";
	$classieraSearchStyle = 1;
	$classieraCompany = false;
	$classiera_page_search = true;
	$classieraComments = true;
	if(isset($redux_demo)){
		$classieraSearchStyle = $redux_demo['classiera_search_style'];
		$classieraPartnersStyle = $redux_demo['classiera_partners_style'];		
		$classieraCompany = $redux_demo['partners-on'];
		$classieraComments = $redux_demo['classiera_sing_post_comments'];
		$classiera_page_search = $redux_demo['classiera_page_search'];
	}		
?>

<?php 
if($page_slider == "LayerSlider") {
	get_template_part( 'templates/slider/sliderv1' );
}
?>
<?php 
	//Search Styles//
if($classiera_page_search == true){
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
}
?>
<!--PageContent-->
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
<style type="text/css">
	   .breadcrumb
   {
   background-color: rgba( 238,238,238,1 );
   padding: 7px 0px;
   }
   .breadcrumb .breadcrumb-item + .breadcrumb-item:before
   {
   content: "";
   width: 10px;
   height: 10px;
   background-image: url(https://www.agentpet.com/img/angle-right-small.svg);
   background-position: 13px 5px;
   background-repeat: no-repeat;
   padding-right: 24px;
   margin-left: -6px;
   }
   .steps-wizard .steps > ul .number {
    display: none;
}
.steps-wizard .steps > ul .current-info {
    display: none;
}
.steps-wizard .steps > ul li.current a {
    color: white;
}
.steps-wizard .steps > ul li a {
    color: #474747;
    width: 100%;
    height: 84px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.steps-wizard .steps > ul li.current {
    background: #f84646;
}
.steps-wizard .steps > ul li {
    padding: 0px 15px;
    text-align: center;
    background-color: #eae8e8;
    color: #474747;
    flex: 1 1 auto;
    text-align: center;
    position: relative;
}
.steps-wizard .steps > ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
    font-size: 1.625rem;
    font-weight: 600;
    display: flex;
}
.steps-wizard .steps {
    margin-bottom: 52px;
}
.steps-wizard {
    margin-bottom: 50px;
}
.steps-wizard .steps > ul li.current:before {
    border-left-color: #f84646;
}

.steps-wizard .steps > ul li:before {
    content: "";
    display: block;
    width: 0;
    height: 0;
    border-top: 42px solid transparent;
    border-bottom: 42px solid transparent;
    border-left: 44px solid #eae8e8;
    position: absolute;
    left: 100%;
    top: 0;
    bottom: 0;
    z-index: 2;
}

.steps-wizard .steps > ul li.current:after {
    border-left-color: #f9f9f9;
}

.steps-wizard .steps > ul li:after {
    content: "";
    display: block;
    width: 0;
    height: 0;
    border-top: 52px solid transparent;
    border-bottom: 52px solid transparent;
    border-left: 54px solid #f9f9f9;
    position: absolute;
    left: 100%;
    margin-left: 0px;
    top: -10px;
    bottom: 0;
    z-index: 1;
}
</style>
<div class="container-fluid">
<div id="categoryMenuItems" class="classiera-navbar classiera-navbar-v6 menu_bg">
   <nav class="row">
      <div class="col-md-9 col-lg-9 category-menu">
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
</div>
<div class="container">
<div class="classiera-navbar classiera-navbar-v6">
	<nav aria-label="breadcrumb">
	   <ol class="breadcrumb">
	      <li class="breadcrumb-item">
	         <a href="<?php echo esc_url(home_url( '/' )); ?>" title="Home">
	         <img src="https://www.agentpet.com/img/home-icon.svg" alt="Home">
	         </a>
	      </li>
	       <li class="breadcrumb-item">
	         <a href="<?php echo esc_url(home_url( '/shop1' )); ?>">
	         Shop
	         </a>
	      </li> 
	      <li class="breadcrumb-item active" aria-current="page">Check Out</li>
	   </ol>
	</nav>
</div>
	<div id="cart_steps" class="steps-wizard">
	   <div class="steps clearfix">
	      <ul role="tablist">
	         <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
	            <a id="cart_steps-t-0" href="#cart_steps-h-0" aria-controls="cart_steps-p-0">
	            <span class="current-info audible">current step: </span>
	            <span class="number">1.</span> Shopping Cart</a>
	         </li>
	         <li role="tab" class="disabled" aria-disabled="true">
	            <a id="cart_steps-t-1" href="#cart_steps-h-1" aria-controls="cart_steps-p-1">
	            <span class="number">2.</span> Checkout
	            </a>
	         </li>
	         <li role="tab" class="disabled last" aria-disabled="true">
	            <a id="cart_steps-t-2" href="#cart_steps-h-2" aria-controls="cart_steps-p-2">
	            <span class="number">3.</span> Order Completed</a>
	         </li>
	      </ul>
	      <img style="margin-top: 5px;" src="https://www.agentpet.com/img/banners/banner.png" width="100%" height="100%">      
	   </div>
	</div>
</div>
<section class="inner-page-content border-bottom">
	<div class="container">
		<!-- breadcrumb -->
		<?php //classiera_breadcrumbs();?>		
		<!-- breadcrumb -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<article class="article-content">
					<!-- <h3><?php //the_title(); ?></h3> -->
					<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
					<?php //endwhile; //endif; ?>
				</article>
				<!--comments-->
				<?php
					$defaults = array(
						'before'           => '<p>' . __( 'Pages:' , 'classiera'),
						'after'            => '</p>',
						'link_before'      => '',
						'link_after'       => '',
						'next_or_number'   => 'number',
						'separator'        => ' ',
						'nextpagelink'     => __( 'Next page', 'classiera'),
						'previouspagelink' => __( 'Previous page', 'classiera'),
						'pagelink'         => '%',
						'echo'             => 1
					);
					wp_link_pages( $defaults );
				?>
				<!--comments-->
					<?php if($classieraComments == 1){?>
					<?php if ( comments_open()) { ?>
					<div class="border-section border comments">
						<h4 class="border-section-heading text-uppercase"><?php esc_html_e( 'Comments', 'classiera' ); ?></h4>
						<?php 
						$file ='';
						$separate_comments ='';
						comments_template( $file, $separate_comments );
						?>
					</div>
					<?php } ?>
					<?php } ?>
					<!--comments-->
				<div class="hidden">
					<?php comment_form(); ?>
				</div>
				<!--comments-->
			</div><!--col-md-8 col-lg-9-->
			
		</div><!--row-->
	</div>
</section>
<!--PageContent-->
<!-- Company Section Start-->
<?php	
	if($classieraCompany == 1){
		if($classieraPartnersStyle == 1){
			get_template_part('templates/members/memberv1');
		}elseif($classieraPartnersStyle == 2){
			get_template_part('templates/members/memberv2');
		}elseif($classieraPartnersStyle == 3){
			get_template_part('templates/members/memberv3');
		}elseif($classieraPartnersStyle == 4){
			get_template_part('templates/members/memberv4');
		}elseif($classieraPartnersStyle == 5){
			get_template_part('templates/members/memberv5');
		}elseif($classieraPartnersStyle == 6){
			get_template_part('templates/members/memberv6');
		}
	}
?>
<!-- Company Section End-->	
<?php get_footer(); ?>