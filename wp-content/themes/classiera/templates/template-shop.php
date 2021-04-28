<?php
/**
 * Template Name: Template-shop
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>


<style>


@media(max-width:767px){
.slick-wrapper {
    width: 100%;
    padding: 0 15px;
    float: left;
    margin: 15px 0;
    }
}
#shopPageProductsCarousel {
    position: relative;
}
#shopPageProductsCarousel .wpcs_product_carousel_slider {
    position: unset;
}
</style>


<body>

<?php


//for each category, show 5 posts
$cat_args=array(
  'orderby' => 'name',
  'order' => 'ASC',
  'taxonomy' => 'product_cat',
  'post_type' => 'product',
  'exclude' => '1',
  'number' => 5,
  'parent' => 0

   );
$categories=get_categories($cat_args);
?>
<div id="categoryMenuItems" class="classiera-navbar classiera-navbar-v6 menu_bg">
    <div class="container">
    <nav class="row">
        <div class="col-md-9 col-lg-9 category-menu">
            <ul class="menu_cat_list">
                <?php
                foreach($categories as $category) { ?>
                    <li>
                        <a href="<?php echo get_category_link( $category->term_id ); ?> "> 
                            <?php echo $category->name; ?> 
                        </a>
                       <!-- <div class="mega-dropdown-menu menu-style-small">
                            <div class="right-box">
                                <ul class="list-unstyled links-list">
                                    <li>
                                        <a href="https://www.agentpet.com/fish-food">Fish Food</a>
                                    </li>
                                    <li>
                                        <a href="https://www.agentpet.com/fish-accessories">Fish Accessories</a>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                <?php  } ?>
            </ul>
        </div>
        <?php echo get_search_form(); ?>
    </nav>
</div>
</div>
<?php the_content(); ?>

<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-food">
                    <P>Featured Pet Food</P>
                </div>
                <div class="slick-wrapper">
                    <div id="slick1">

                    <?php  
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'category' => array( 'hoodies' ),
                        'orderby'  => 'date',
                    );
                    $product = wc_get_product( $args );
                    // $products = wc_get_products( $args );
                    // print_r($products);
                    $loop = new WP_Query( $args );
                    // print_r($loop);
                    while ( $loop->have_posts() ) : $loop->the_post();
                        global $product;
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
                        ?>

                        <div class="slide-item toltipclass">
                            
                              <span class="mytoltiptext"><?= the_title(); ?></span>
                            <a href="<?= get_permalink() ?>">
                                <div class="slider-image">
                                    <img src="<?php  echo $image[0]; ?>" alt="">
                                </div>
                            </a>
                            
                            <div class="content">
                                <p class="name"><?= the_title(); ?></p>
                                <?php $price = get_post_meta( get_the_ID(), '_price', true ); ?>
                                <p class="price-tag" ><?php echo wc_price( $price ); ?></p>
                            </div>                            
                        </div>

                    <?php endwhile; wp_reset_query($loop->post->ID); ?>

                    </div>
                    <div class="feature-pet-slider-controls">
                       <a href="javascript:void(0)" class="feature-pet-slick-prev-first slick-arrow" style="display: block;"></a>
                       <a href="javascript:void(0)" class="feature-pet-slick-next-first slick-arrow" style="display: block;"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-feature">
                </div>        
                <div class="slick-wrapper">
                    <div id="slick2">
                        <div class="slide-item">
                            <div class="bg1">
                            <img src="https://djurhus.se/wp-content/uploads/2021/01/shop-poster1-01.png" alt="">
                                <a class="bg-setting" href="#"></a>
                            </div>
                        </div>
                        <div class="slide-item">
                            <div class="bg2">
                            <img src="https://djurhus.se/wp-content/uploads/2021/01/shop-poster-2-01-1.png" alt="">
                                <a class="bg-setting"  href="#"></a>
                            </div>
                        </div>
                        <div class="slide-item">
                            <div class="bg3">
                            <img src="https://djurhus.se/wp-content/uploads/2021/01/shop-poster3-01-1.png" alt="">
                                <a class="bg-setting"  href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="feature-pet-slider-controls">
                       <a href="javascript:void(0)" class="feature-pet-slick-prev-img slick-arrow" style="display: block;"></a>
                       <a href="javascript:void(0)" class="feature-pet-slick-next-img slick-arrow" style="display: block;"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-food">
                    <P>Featured Pet Asseccories</P>
                </div>    
                <div class="slick-wrapper">
                    <div id="slick3">
                    <?php  
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'category' => array( 'hoodies' ),
                        'orderby'  => 'date',
                    );
                    $product = wc_get_product( $args );
                    // $products = wc_get_products( $args );
                    // print_r($products);
                    $loop = new WP_Query( $args );
                    // print_r($loop);
                    while ( $loop->have_posts() ) : $loop->the_post();
                        global $product;
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
                        ?>

                        <div class="slide-item toltipclass">
                           
                              <span class="mytoltiptext"><?= the_title(); ?></span>
                            
                            <a href="<?= get_permalink() ?>">
                                <div class="slider-image">
                                    <img src="<?php  echo $image[0]; ?>" alt="">
                                </div>
                            </a>
                            
                            <div class="content">
                                <p class="name"><?= the_title(); ?></p>
                                <?php $price = get_post_meta( get_the_ID(), '_price', true ); ?>
                                <p class="price-tag" ><?php echo wc_price( $price ); ?></p>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_query($loop->post->ID); ?>

                    </div>
                    <div class="feature-pet-slider-controls">
                       <a href="javascript:void(0)" class="feature-pet-slick-prev-second slick-arrow" style="display: block;"></a>
                       <a href="javascript:void(0)" class="feature-pet-slick-next-second slick-arrow" style="display: block;"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-wrapper">
<div class="product-show" id="shopPageProductsCarousel">
    <div class="container">
        <div class="row">
            <?php echo do_shortcode("[wpcs id=4700]"); ?>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">   

$('#slick1').slick({
        rows: 2,        
        arrows: true,
        infinite: true,
        autoplay: true,
        speed: 100,
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: true,
        nextArrow: ".feature-pet-slick-next-first",
        prevArrow: ".feature-pet-slick-prev-first",
                
});


$('#slick2').slick({
        rows: 1,
        dots: true,
        arrows: true,
        infinite: true,
        autoplay: true,
        speed: 100,
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: ".feature-pet-slick-next-img",
        prevArrow: ".feature-pet-slick-prev-img",
});
$('#slick3').slick({
        rows: 2,
        dots: true,
        arrows: true,
        infinite: true,
        autoplay: true,
        speed: 100,
        slidesToShow: 2,
        slidesToScroll: 2,
        nextArrow: ".feature-pet-slick-next-second",
        prevArrow: ".feature-pet-slick-prev-second",
});

 $(document).ready( function () {
      
 (function($){

$("#petFoodCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

$("#seaFoodCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

$("#birdFoodCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

$("#petAccessoriesCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

$("#dogFoodCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

$("#catFoodCategoryBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
 return false;
});
  
})(jQuery);
  });


</script>


</body>

<?php get_footer(); ?>


