<?php get_header(); ?>
<style>
   .breadcrumb
   {
   background-color: rgba( 238,238,238,1 );
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
   .two-column-layout {
   display: flex;
   margin-bottom: 30px;
   }
   .two-column-layout > .right-col {
   flex: 1 1 auto;
   padding: 0 30px;
   padding-right: 0;
   overflow: hidden;
   }
   .two-column-layout > .left-col {
   flex: 0 0 265px;
   width: 265px;
   }
   .filter-sidebar {
   padding-bottom: 15px;
   }
   .filter-sidebar .sidebar-header span i{
   color: #fff;
   }
   .filter-sidebar {
   background: white;
   border-radius: 6px;
   overflow: hidden;
   border: 1px solid rgba(0, 0, 0, 0.14);
   height: 100%;
   }
   .filter-sidebar .sidebar-header {
   display: flex;
   align-items: center;
   padding: 16px;
   justify-content: space-between;
   background-color: #3f3f3f;
   color: white;
   }
   .filter-sidebar .sidebar-header {
   display: flex;
   align-items: center;
   padding: 16px;
   justify-content: space-between;
   background-color: #3f3f3f;
   color: white;
   }
   .filter-sidebar .sidebar-header span i {
   font-size: 16px;
   margin-right: 10px;
   }
   .filter-sidebar .sidebar-header a {
   color: white;
   font-size: 0.875rem;
   cursor: pointer;
   }
   .filter-sidebar .sidebar-box {
   border-bottom: 1px solid rgba(0, 0, 0, 0.14);
   font-size: 0.875rem;
   }
   .filter-sidebar .sidebar-box .sidebar-section-header {
   padding: 8px 18px;
   display: flex;
   align-items: center;
   justify-content: space-between;
   cursor: pointer;
   font-size: 16px;
   font-weight: 700;
   color: #2d2d2d;
   }
   .filter-sidebar .sidebar-box .sidebar-section-body {
   padding: 0px 18px;
   }
   .input-group.icon-group {
   position: relative;
   }
   .filter-sidebar .input-group {
   position: relative;
   display: flex;
   flex-wrap: wrap;
   align-items: stretch;
   width: 100%;
   }
   .filter-sidebar .sidebar-box .form-control {
   height: 37px;
   padding-top: 0px;
   padding-bottom: 0px;
   }
   .input-group-append {
   margin-left: -1px;
   }
   .filter-sidebar .input-group .shop-product-search.btn {
   height: 39px;
   }
   .filter-sidebar .pricing .slider.slider-horizontal {
   width: 100%;
   margin: 20px 0;
   }
   .filter-sidebar .pricing .price-info {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   }
   .filter-sidebar  .price-info > span {
   margin-right: 10px;
   }
   .filter-sidebar .price-info > input[type='text'] {
   max-width: 40px;
   padding: 6px 2px;
   text-align: center;
   border: 1px solid #dae2e6;
   color: #6d6d6d;
   font-size: 14px;
   margin-right: 6px;
   border-radius: 4px;
   }
   .filter-sidebar .price-info > span {
   margin-right: 10px;
   }
   .filter-sidebar .price-info .btn-price {
    background-color: #404040;
    color: #fff;
    padding: 6px 10px;
    font-size: 14px;
    text-transform: uppercase;
    border-radius: 3px;    
   }
   .filter-sidebar .slider {
   display: inline-block;
   vertical-align: middle;
   position: relative;
   }
   .filter-sidebar .pricing .slider-handle {
   background: #f84646;
   box-shadow: none;
   top: 1px;
   width: 11px;
   height: 11px;
   }
   .filter-sidebar .pricing .slider-selection {
   background: #f84646;
   box-shadow: none;
   }
   .filter-sidebar .pricing .slider .tooltip-arrow {
   display: none;
   opacity: 0;
   }
   .filter-sidebar .slider.slider-horizontal .slider-track {
   height: 3px;
   width: 100%;
   margin-top: -5px;
   top: 50%;
   left: 0;
   }
   .filter-sidebar .slider {
   position: relative;
   cursor: pointer;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: #fff;
   -webkit-transition: .4s;
   transition: .4s;
   }
   .filter-sidebar .pricing .price-info > input {
   max-width: 41px;
   padding: 6px 0px;
   text-align: center;
   border: 1px solid #dae2e6;
   color: #6d6d6d;
   font-size: 14px;
   margin-right: 6px;
   border-radius: 4px;
   } 
   .right-col .cards-list-header {
   background: white;
   border: 1px solid #dddddd;
   border-radius: 6px;
   padding: 10px 24px;
   margin-bottom: 12px;
   }
   .right-col .form-inline {
   display: flex;
   flex-flow: row wrap;
   align-items: center;
   }
   .right-col .cards-list-header .filter-row > .left-col {
   flex: 1;
   }
   .right-col .cards-list-header .filter-row > .left-col {
   margin-right: auto;
   }
   .right-col .cards-list-header .filter-row > .right-col {
   display: flex;
   align-items: center;
   }
   .right-col .cards-list-header .found-title {
   margin-bottom: 0px;
   margin-right: auto;
   }
   .right-col  .found-title {
   font-size: 1.75rem;
   color: #6d6d6d;
   }
   .right-col  .form-inline .form-group {
   display: flex;
   flex: 0 0 auto;
   flex-flow: row wrap;
   align-items: center;
   margin-bottom: 0;
   }
   .right-col  .form-group {
   margin-bottom: 1rem;
   }
   .right-col .control-with-label {
   display: flex;
   white-space: nowrap;
   align-items: center;
   }
   .cards-list-header .filter-row {
   display: flex;
   width: 100%;
   }
   .filter-row .form-group label {
   margin-bottom: 0px;
   }
   .form-inline label {
   display: flex;
   align-items: center;
   justify-content: center;
   margin-bottom: 0;
   }
   .filter-row .control-with-label label {
   margin-right: 15px;
   font-size: 0.875rem;
   color: #a3a3a3;
   }
   .filter-row .form-inline .form-control {
   display: inline-block;
   width: auto;
   vertical-align: middle;
   }
   .cards-list-header .form-control {
   height: 32px;
   padding-top: 0px;
   padding-bottom: 0px;
   }
   .filter-row select.form-control {
   background-image: url(https://www.agentpet.com/img/caret-down-black.svg);
   background-position: center right 15px;
   background-repeat: no-repeat;
   padding-right: 35px;
   }
   .cards-list-header .filter-row > .right-col .btn {
   line-height: 0;
   margin-right: 2px;
   margin-left: 10px;
   }
   .filter-row .btn:not(:disabled):not(.disabled) {
   cursor: pointer;
   }
   .cards-list-header .filter-row > .right-col .btn.active svg {
   fill: #f84646;
   }
   /* .listing-page-sections .views-box {
   display: none;
   } */
   .listing-page-sections .views-box.active {
   display: block;
   }
   .listing-page-sections .card {
   position: relative;
   display: flex;
   flex-direction: column;
   min-width: 0;
   word-wrap: break-word;
   background-color: #fff;
   background-clip: border-box;
   border: 1px solid rgba(0, 0, 0, 0.125);
   border-radius: 0.25rem;  
   margin-bottom: 26px;
   /* min-height: 332px */
   }
   .listing-page-sections .p-card-landscape .card-body {
   padding: 0.5rem 0.8rem;
   }
   .listing-page-sections .card-body {
   flex: 1 1 auto;
   padding: 1.25rem;
   }
   .filter-sidebar .shop-product-search.filter-intput{
   padding: 2px;
   border: 0 none;
   text-transform: uppercase;
   color: #232323;
   margin: 0px -27px;
   z-index: 99;
   }
   .listing-page-sections .small-padding-grid .e-card-small {
   padding-bottom: 33px;
   }
   .listing-page-sections .small-padding-grid .e-card-small {
   margin-bottom: 16px;
   height: calc(100% - 16px);
   padding-bottom: 82px;
   }
   .listing-page-sections .small-padding-grid .e-card-small .image-box {
   height: 160px;
   }
   .listing-page-sections .e-card-small .image-box {
   text-align: center;
   border-bottom: 1px solid #d8d8d8;
   height: 192px;
   display: flex;
   justify-content: center;
   position: relative;
   overflow: hidden;
   border-radius: 6px;
   }
   .listing-page-sections .image-box a,
   .listing-page-sections  .e-card-small .card-title a
   {
   color: #f84646;
   text-decoration: none;
   background-color: transparent;
   -webkit-text-decoration-skip: objects;
   }
   .listing-page-sections .e-card-small .image-box img {
   width: auto;
   max-width: 100%;
   max-height: 100%;
   width: 100%;
   }
   .listing-page-sections .card-img-top {
   object-fit: scale-down;
   border-top-left-radius: calc(0.25rem - 1px);
   border-top-right-radius: calc(0.25rem - 1px);
   }
   .listing-page-sections img {
   vertical-align: middle;
   border-style: none;
   }
   .listing-page-sections  .e-card-small .card-body {
   flex: 1 1 auto;
   padding: 1.25rem;
   }
   .listing-page-sections  .e-card-small .card-title a{
   color: #f84646;
   margin-bottom: 5px;
   font-size: 20px;
   font-weight: 700;
   }
   .listing-page-sections .e-card-small .card-text {
   margin-bottom: 0.25rem;
   }
   .listing-page-sections .e-card-small .card-text {
   font-size: 0.8125rem;
   color: #474747;
   }
   .e-card-small .price, .e-card-small .e-product-card.card .price-discount, .e-product-card.card .e-card-small .price-discount {
   color: #f84646;
   font-weight: 600;
   font-size: 1.125rem;
   text-align: center;
   }
   .listing-page-sections .e-card-small .buttons-box {
   bottom: 15px;
   left: 1.25rem;
   right: 1.25rem;
   }
   .listing-page-sections .form-inline {
   display: flex;
   flex-flow: row wrap;
   align-items: center;
   }
   .listing-page-sections .btn-call svg {
   margin-right: 12px;
   fill: white;
   }
   .listing-page-sections svg {
   overflow: hidden;
   vertical-align: middle;
   }
   .listing-page-sections .btn-callGreen {
   align-items: center;
   text-align: center;
   color: #fff;
   background-color: #06b728;
   border-color: #06b728;
   padding: 12px 0px;
   }
   input[type='range'] {
    height: 30px;
    overflow: hidden;
    cursor: pointer;
    outline: none;
    margin: 0px;
    padding-right: 15px;
   }
   input[type='range'],
   input[type='range']::-webkit-slider-runnable-track,
   input[type='range']::-webkit-slider-thumb {
   -webkit-appearance: none;
   background: none;
   }
   input[type='range']::-webkit-slider-runnable-track {
   width: 200px;
   height: 1px;
   background: #003D7C;
   }
   input[type='range']:nth-child(2)::-webkit-slider-runnable-track{
   background: none;
   }
   input[type='range']::-webkit-slider-thumb {
   position: relative;
   height: 15px;
   width: 15px;
   margin-top: -7px;
   background: #fff;
   border: 1px solid #003D7C;
   border-radius: 25px;
   z-index: 1;
   }
   input[type='range']:nth-child(1)::-webkit-slider-thumb{
   z-index: 2;
   }
   .rangeslider{
   position: relative;
   height: 60px;
   width: 210px;
   display: inline-block;
   margin-top: -5px;
   margin-left: 20px;
   }
   .rangeslider input{
   position: absolute;
   }
   .rangeslider{
   position: absolute;
   }
   .rangeslider span{
   position: absolute;
   margin-top: 30px;
   left: 0;
   }
   .rangeslider .right{
   position: relative;
   float: right;
   margin-right: -5px;
   }
   /* Proof of concept for Firefox */
   @-moz-document url-prefix() {
   .rangeslider::before{
   content:'';
   width:100%;
   height:2px;
   background: #003D7C;
   display:block;
   position: relative;
   top:16px;
   }
   input[type='range']:nth-child(1){
   position:absolute;
   top:35px !important;
   overflow:visible !important;
   height:0;
   }
   input[type='range']:nth-child(2){
   position:absolute;
   top:35px !important;
   overflow:visible !important;
   height:0;
   }
   input[type='range']::-moz-range-thumb {
   position: relative;
   height: 15px;
   width: 15px;
   margin-top: -7px;
   background: #fff;
   border: 1px solid #003D7C;
   border-radius: 25px;
   z-index: 1;
   }
   input[type='range']:nth-child(1)::-moz-range-thumb {
   transform: translateY(-20px);    
   }
   input[type='range']:nth-child(2)::-moz-range-thumb {
   transform: translateY(-20px);    
   }
}

.price-info{
  position: relative;
}
.price-info #rng1{
  position: absolute;
  padding-left: 17px;
}
.sidebar-box #min_price, .sidebar-box #max_price{
  width: 45px;
}
.sidebar-box .filterbtn {
  width: 64px;
}
.fromTxt {
  padding-left: 15px;
}

.page-numbers {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 2px 0 0;
    border: 1px solid #eee;
    line-height: 1;
    text-decoration: none;
    border-radius: 2px;
    font-weight: 600;
}
.page-numbers.current,
a.page-numbers:hover {
    background: #f9f9f9;
}

/* Text meant only for screen readers. */

a {
  -webkit-transition: all 0.3s ease;
  transition: all 0.3s ease;
}

/* pagination */
.pagination a {
  margin: 1rem .6rem;
}
.pagination a.page-numbers {
  color: #f84646;
}
.pagination a.page-numbers:hover {
  color: #f84646;
}
.pagination .page-numbers.current,
.pagination .page-numbers.dots {
  color: #e0e0e0;
}
.pagination a.next,
.pagination a.prev {
  display: inline-block;
  padding: .2rem .8rem;
  background-color: #f84646;
  color: #fff;
  -webkit-border-radius: 2px;
  border-radius: 2px;
}
.pagination a.next:hover,
.pagination a.prev:hover {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  color: #fff;
}
   .categories-filter-section .row {
       margin: 0px -8px;
       display: flex;
       flex-wrap: wrap;
   }
   .categories-filter-section label {
       display: block;
       cursor: pointer;
       margin-bottom: 0.5rem;
   }
   .categories-filter-section .categoies-banner-card {
       min-height: 118px;
       -webkit-filter: grayscale(100%);
       filter: grayscale(100%);
       transition: all 0.2s ease 0s;
   }

   .categories-filter-section .categoies-banner-card .category-icon {
       max-height: 85%;
       margin-right: 10px;
       margin-bottom: 5px;
   }
   .categories-filter-section .categoies-banner-card.small .category-icon {
       max-width: 60%;
       max-height: 53%;
   }

   .categories-filter-section .categoies-banner-card .category-icon {
       position: absolute;
       right: 0;
       bottom: 0;
       max-width: 42%;
       max-height: 90%;
   }
   .categories-filter-section .categoies-banner-card .card-img-overlay {
       padding-top: 35px;
   }
   .categories-filter-section .categoies-banner-card .card-img-overlay {
       display: flex;
       align-items: center;
   }

   .categories-filter-section .card-img-overlay {
       position: absolute;
       top: 0;
       right: 0;
       bottom: 0;
       left: 0;
       padding: 1.25rem;
   }
   .categories-filter-section .categoies-banner-card .cio-inner {
       overflow: hidden;
   }
   .categories-filter-section .categoies-banner-card .card-title {
       font-size: 1.5rem;
       color: white;
   }

   .categoies-banner-card .card-title {
       opacity: 0.9;
       font-size: 2.5rem;
       text-transform: uppercase;
       margin-bottom: 0px;
       font-weight: 600;
       white-space: nowrap;
       overflow: hidden;
       text-overflow: ellipsis;
   }
  .categoies-banner-card .card-text {
       font-size: 0.875rem;
       white-space: nowrap;
       overflow: hidden;
       text-overflow: ellipsis;
       margin-bottom: 10px;
   }

   .categoies-banner-card.small .card-text {
       margin-bottom: 15px;
   }
   .categoies-banner-card .card-text {
       font-size: 1.125rem;
   }
   .categories-filter-section .categoies-banner-card:hover {
       box-shadow: 0px 4px 12px 0px rgb(0 0 0 / 31%);
       -webkit-filter: grayscale(0%);
       filter: grayscale(0%);
   }

   .categories-filter-section [class^="col-"] {
       padding: 0px 8px;
       margin-bottom: 4px;
   }

   .categories-filter-section .col-6.bigboxes {
       flex: 0 0 50%;
       max-width: 50%;
   }
   .bg-catGreen {
       background-color: #2ed064 !important;
   }
   .bg-bags {
       background-color: #e8bc5d !important;
   }
   .bg-pet-cage {
       background-color: #fa8b8b !important;
   }
   .bg-medicine {
       background-color: #30b1ad !important;
   }
   .bg-catBlue {
       background-color: #2c98d0 !important;
   }
   .bg-catPurple {
       background-color: #8c33d8 !important;
   }
</style>
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
      <li class="breadcrumb-item active" aria-current="page">Search</li>
   </ol>
</nav>
<div class="two-column-layout">
   <div class="left-col">
      <form class="filter-sidebar" action="" method="POST">
         <div class="sidebar-header">
            <span><i class="fa fa-filter"></i>Filter Products</span>
            <a id="clear-petstore-filters" style="cursor: pointer">Clear All</a>
         </div>
         <div class="sidebar-body">
            <div class="sidebar-box">
               <div class="sidebar-section-header">
                  <span>Search by keyword</span>
                  <i class="fa fa-angle-down"></i>
               </div>
               <div class="sidebar-section-body">
                  <div class="form-group input-group icon-group">
                     <input type="text" class="form-control filter-intput" placeholder="<?php echo ($_POST['search_term']) ? $_POST['search_term'] : 'Product Name'; ?>" name="search_term">
                     <div class="input-group-append">
                        <button type="button" class="btn btn-link shop-product-search filter-intput" onclick="filterPets(this);">
                        <i class="fa fa-search"></i>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="sidebar-box">
               <div class="sidebar-section-header">
                  <span>Product For</span>
                  <i class="fa fa-angle-down"></i>
               </div>
               <?php
                  $terms = get_terms( 'product_tag' );
                  $term_array = array();
                  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                      foreach ( $terms as $term ) {
                          $term_array[] = $term->name;
                      }
                  }
                  
                  ?>
               <div class="sidebar-section-body">
                  <div class="form-group">
                     <select class="form-control filter-intput" name="type">
                        <option value="">Select Product Tag</option>
                        <?php foreach($term_array as $item){ ?>
                        <option <?php echo ($item == $_POST['type']) ? 'selected' : ''; ?> value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php } ?>                       
                     </select>
                  </div>
               </div>
            </div>
            <div class="sidebar-box">
               <div class="sidebar-section-header">
                  <span>Category</span>
                  <i class="fa fa-angle-down"></i>
               </div>
               <?php
                  //for each category, show 5 posts
                  $cat_args=array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'taxonomy' => 'product_cat',
                    'post_type' => 'product',
                    'exclude'             => '1'
                  
                     );
                  $categories=get_categories($cat_args);
                  ?>
               <div class="sidebar-section-body">
                  <div class="form-group">
                     <select class="form-control filter-intput" name="category">
                        <option value="">Select Category</option>
                        <?php
                           foreach($categories as $category) { ?>
                        <!--<option value="<?php //echo get_category_link( $category->term_id ); ?>"><?php //echo $category->name; ?> </option>-->
                        <option value="<?php echo $category->slug; ?>" <?php echo ($_POST['category'] == $category->name) ? 'selected' : ''; ?>><?php echo $category->name; ?> </option>
                        <?php  } ?>
                        <option value="Pet Accessories">Pet Accessories</option>
                     </select>
                  </div>
               </div>
            </div>
            <!-- <div class="sidebar-box">
              <div class="sidebar-section-header">
                  <span>Price (KR)</span>
                  <i class="fa fa-angle-down"></i>
              </div>
              <div class="rangeslider">
                  <input class="min" name="range_1" type="range" min="1" max="100" value="10" />
                  <input class="max" name="range_1" type="range" min="1" max="100" value="90" />
                   <span class="range_min light left">10.000 €</span>
                   <span class="range_max light right">90.000 €</span>
              </div>
              <div class="sidebar-section-body">
              </div>
            </div> -->
            <div class="sidebar-box">
               <div class="sidebar-section-header">
                  <span>Price (KR)</span>
                  <i class="fa fa-angle-down"></i>
               </div>
               <div class="price-info">
                  
                      
                  <input id="rng1" class="min" name="range_1" type="range" min="1" max="1000" value="<?php echo ($_POST['min_price']) ? $_POST['min_price'] : '0'; ?>" />
                  <input class="max" name="range_1" type="range" min="1" max="999" value="<?php echo ($_POST['max_price']) ? $_POST['max_price'] : '999'; ?>"/>
                  <span class="fromTxt">from</span>
                  <input type="text" id="min_price" placeholder="0" name="min_price" value="<?php echo ($_POST['min_price']) ? $_POST['min_price'] : ''; ?>">
                  <span class="toTxt">to</span>
                  <input type="text" id="max_price" placeholder="1000.00" name="max_price" value="<?php echo ($_POST['max_price']) ? $_POST['max_price'] : ''; ?>">
                  <button type="submit" class="btn-price filterbtn filter-intput" >Filter</button>
                    
                </div>
               <!-- <div class="sidebar-section-body">
                  <div class="pricing widget-item">
                     <div class="slider slider-horizontal" id="">
                        <div class="slider-track">
                           <div class="slider-track-low" style="left: 0px; width: 0%;"></div>
                           <div class="slider-selection" style="left: 0%; width: 100%;"></div>
                           <div class="slider-track-high" style="right: 0px; width: 0%;"></div>
                        </div>
                        <div class="tooltip tooltip-min top" role="presentation" style="left: 0%; display: none;">
                           <div class="tooltip-arrow"></div>
                           <div class="tooltip-inner">undefined - undefined</div>
                        </div>
                        <div class="tooltip tooltip-max top" role="presentation" style="left: 100%; display: none;">
                           <div class="tooltip-arrow"></div>
                           <div class="tooltip-inner">undefined - undefined</div>
                        </div>
                        <div class="slider-handle min-slider-handle round" role="slider" aria-valuemin="0" aria-valuemax="21000" aria-valuenow="0" aria-valuetext="undefined - undefined" tabindex="0" style="left: 0%;"></div>
                        <div class="slider-handle max-slider-handle round" role="slider" aria-valuemin="0" aria-valuemax="21000" aria-valuenow="21000" aria-valuetext="undefined - undefined" tabindex="0" style="left: 100%;">
                          
                        </div>
                     </div>
                     <input id="price-range-slider" type="text" class="span2" value="0,21000" data-slider-min="0" data-slider-max="21000.00" data-slider-step="1" data-slider-value="[0,21000.00]" style="display: none;" data-value="0,21000">
                     <div class="price-info">
                        <span>from</span>
                        <input type="text" id="min_price" placeholder="0" name="min_price">
                        <span>to</span>
                        <input type="text" id="max_price" placeholder="21000.00" name="max_price">
                        <button type="submit" class="btn-price filterbtn filter-intput" >Filter</button>
                     </div>
                  </div>
               </div> -->
            </div>
         </div>
      </form>
   </div>
   <div class="right-col">

      <?php //echo the_search_query(); ?>
      <div class="cards-list-header">
         <div class="clearfix"></div>
         <form action="#" class="form-inline">
            <div class="filter-row">
               <div class="left-col">
                  <h1 class="found-title">Pet Food Brands</h1>
               </div>
               <div class="right-col">
                  <div class="form-group control-with-label">
                     <label>Sort By:</label>
                     <select class="form-control filter-intput" name="order_by" id="order_by">
                        <option value="desc" selected="&quot;selected&quot;">Date: Recent First</option>
                        <option value="asc">Date: Oldest First</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <button class="btn btn-link filter-intput " name="style" value="list" type="button" data-view="list-view">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13.25" height="13" viewBox="0 0 13.25 13">
                           <path class="cls-1" d="M1307,304h13.25v3.25H1307V304Zm0,4.875h13.25v3.25H1307v-3.25Zm0,4.875h13.25V317H1307v-3.25Z" transform="translate(-1307 -304)"></path>
                        </svg>
                     </button>
                     <button class="btn btn-link filter-intput active" name="style" value="grid" type="button" data-view="grid-view">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.25" height="13" viewBox="0 0 16.25 13">
                           <path data-name="Forma 1 copy 12" class="cls-1" d="M1345,334v-3.249h4.25V334H1345Zm0-8.124h4.25v3.249H1345v-3.249Zm0-4.875h4.25v3.249H1345V321Zm-6,9.75h4.25V334H1339v-3.249Zm0-4.875h4.25v3.249H1339v-3.249Zm0-4.875h4.25v3.249H1339V321Zm-6,9.75h4.25V334H1333v-3.249Zm0-4.875h4.25v3.249H1333v-3.249Zm0-4.875h4.25v3.249H1333V321Z" transform="translate(-1333 -321)"></path>
                        </svg>
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
      
      <section class="categories-filter-section">
              <div class="row">
                  <div class="col-6 col-lg-3">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" name="type" value="Dog">
                          <div class="card bg-dark text-white categoies-banner-card bg-catGreen small"> <img src="https://www.agentpet.com/img/dog-sitting.png" alt="Dog" class="category-icon">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">Dog</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
                  <div class="col-6 col-lg-3">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" name="type" value="Cat">
                          <div class="card bg-dark text-white categoies-banner-card bg-bags small"> <img src="https://www.agentpet.com/img/cat-sitting.png" alt="Cat" class="category-icon">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">Cat</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
                  <div class="col-6 col-lg-3">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" name="type" value="Bird">
                          <div class="card bg-dark text-white categoies-banner-card bg-pet-cage small"> <img src="https://www.agentpet.com/img/bird-flying.png" alt="Bird" class="category-icon">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">Bird</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
                  <div class="col-6 col-lg-3">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" checked="&quot;checked&quot;" name="type" value="Fish">
                          <div class="card bg-dark text-white categoies-banner-card bg-medicine small"> <img src="https://www.agentpet.com/img/fish-small.png" alt="Fish" class="category-icon">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">Fish</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
                  <div class="col-6 bigboxes">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" name="type" value="">
                          <div class="card bg-dark text-white categoies-banner-card bg-catBlue medium">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">All</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow" class="arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
                  <div class="col-6 bigboxes">
                      <label class="cat-filter-checkbox">
                          <input type="checkbox" class="filter-intput" name="type" value="Other">
                          <div class="card bg-dark text-white categoies-banner-card bg-catPurple medium">
                              <div class="card-img-overlay">
                                  <div class="cio-inner">
                                      <h5 class="card-title">Other</h5>
                                      <p class="card-text"></p> <img src="https://www.agentpet.com/img/arrow-icon.svg" alt="Arrow" class="arrow"> </div>
                              </div>
                          </div>
                      </label>
                  </div>
              </div>
          </section>


      <div class="listing-page-sections">
          
         <?php $search_term = get_search_query(); ?>
         <section class="categories-filter-section">
            <div class="row">
               <?php              
                  if(isset($_POST) && count($_POST) != ''){
                    $temp = [];
                    $arg = array(
                          'post_type' => 'product',                         
                          'post_status' => 'publish',
                          'orderby'  => 'date',
                          'posts_per_page' => 10
                      );
                      if(isset($_POST['search_term']) &&  $_POST['search_term'] != ''){
                        $temp['s'] = $_POST['search_term'];
                      }
                  
                      if(isset($_POST['category']) &&  $_POST['category'] != ''){
                        $temp['product_cat'] = $_POST['category'];
                      }
                  
                  
                      if(isset($_POST['type']) &&  $_POST['type'] != ''){
                        $temp['product_tag'] = $_POST['type'];
                      }                    
                  
                      if(isset($_POST['min_price']) &&  $_POST['min_price'] != '' && $_POST['max_price'] &&  $_POST['max_price']){
                        $min = $_POST['min_price'];
                        $max = $_POST['max_price'];
                        $temp['meta_query'][0] = ['relation' => 'AND'];
                        $temp['meta_query'][1] = ['key' => '_price',
                                                  'value' => array($min, $max),
                                                  'compare' => 'BETWEEN',
                                                  'type' => 'NUMERIC'];
                      }

                      $args = array_merge($arg,$temp);                   
                  
                  }else{
                    $args = array(
                          'post_type' => 'product',
                           's' => $search_term,
                          'post_status' => 'publish',
                          'orderby'  => 'date',
                          'posts_per_page' => 10
                      );
                  }
                   //echo "</br>";
                    //print_r($args);
                    //echo "</br>";
                       //$products = wc_get_products( $args );
                       $loop = new WP_Query( $args );
                       $count = $loop->found_posts;
                       if($count > 0){
                  while ( $loop->have_posts() ) : $loop->the_post();
                          global $product;
                          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
                  
                  
                  ?>
               <div class="col-sm-6 col-md-3">
                  <div class="card e-card-small">
                     <div class="image-box">
                        <a href="<?= get_permalink() ?>">
                        <img class="card-img-top" src="<?php  echo $image[0]; ?>" alt="Drontal Tablet for Cats (1 Tablet)">
                        </a>
                     </div>
                     <div class="card-body">
                        <h5 class="card-title"><a href="<?= get_permalink() ?>"><?= substr(get_the_title(),0, 15) . "..."; ?></a></h5>
                        <?php
                           $product_id = $loop->post->ID;
                           $product_instance = wc_get_product($product_id);
                           
                           $product_full_description = $product_instance->get_description();
                           //$product_short_description = $product_instance->get_short_description();
                           
                           ?>
                        <p class="card-text"><?= substr($product_full_description,0, 30) . "..."; ?>   </p>
                        <p class="price">
                           <?php $price = get_post_meta( get_the_ID(), '_price', true ); ?>
                           <?php echo wc_price( $price ); ?>
                        </p>
                        <!-- <div class="buttons-box">
                           <form action="https://www.agentpet.com/cart" class="form-inline add-to-cart-form" method="post">
                              <input type="hidden" name="_token" value="qNd9GBbWvH8lINkx09ZTqLQiQbtCP6tEUhwEtylb">
                              <input type="hidden" name="quantity" value="1">
                              <input type="hidden" name="product" value="744">
                              <button type="submit" class="btn btn-callGreen btn-call mr-auto btn-block d-flex justify-content-center">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19">
                                    <path id="Forma_1" data-name="Forma 1" class="cls-1" d="M1300.92,189.947v4.46a3.6,3.6,0,0,1-3.6,3.593h-9.64a3.6,3.6,0,0,1-3.6-3.593v-4.46a2.729,2.729,0,0,1,.66-5.38h2.08c0.49-.909,1.31-2.441,1.96-3.647,1.03-1.654,1.14-1.921,2.22-1.921h4a3.575,3.575,0,0,1,1.78,1.937c0.56,1.156,1.3,2.669,1.77,3.631h1.71A2.729,2.729,0,0,1,1300.92,189.947Zm-5.13-8.827a1.9,1.9,0,0,0-1.82-1.121h-1.91a2.3,2.3,0,0,0-2.2,1.024c-0.53.991-1.33,2.485-1.9,3.544h9.5C1296.97,183.546,1296.3,182.183,1295.79,181.12Zm4.47,4.884h-2.09l-0.01,0v0h-13.42a1.294,1.294,0,1,0,0,2.587h0.07a0.688,0.688,0,0,1,.52.233,0.762,0.762,0,0,1,.19.548v5.035a2.16,2.16,0,0,0,2.16,2.155h9.64a2.16,2.16,0,0,0,2.16-2.155v-5.035a0.782,0.782,0,0,1,.19-0.548,0.688,0.688,0,0,1,.52-0.233h0.07A1.294,1.294,0,1,0,1300.26,186Zm-3.72,8.482a0.718,0.718,0,0,1-.72-0.719v-3.1a0.72,0.72,0,0,1,1.44,0v3.1A0.718,0.718,0,0,1,1296.54,194.486Zm-4.04,0a0.718,0.718,0,0,1-.72-0.719v-3.1a0.72,0.72,0,0,1,1.44,0v3.1A0.718,0.718,0,0,1,1292.5,194.486Zm-4.04,0a0.718,0.718,0,0,1-.72-0.719v-3.1a0.72,0.72,0,0,1,1.44,0v3.1A0.718,0.718,0,0,1,1288.46,194.486Z" transform="translate(-1282 -179)"></path>
                                 </svg>
                                 Add to Cart
                              </button>
                           </form>
                        </div> -->
                     </div>
                  </div>
               </div>
               <?php endwhile;  ?>
               <?php //the_posts_pagination(); ?>
            </div>
         </section>
         <?php } else { ?>
          </div>
         </section>
          <div class="mb-3 cards-list-small views-box " id="list-view">
            <div class="card p-card-landscape e-card-landscape">
               <div class="card-body">
                  No Product Found
               </div>
            </div>
         </div>
         <!--
         <div class="cards-list-small views-box active" id="grid-view">
            <div class="card p-card-landscape e-card-landscape">
               <div class="card-body">
                  No Product Found
               </div>
            </div>
         </div> -->
         <?php } ?>
      </div>
      <div class="pagination">
         <?php 
            echo paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $loop->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<i class="fa fa-angle-left"></i> %1$s', __( '', 'text-domain' ) ),
                'next_text'    => sprintf( '%1$s <i class="fa fa-angle-right"></i>', __( '', 'text-domain' ) ),
                'add_args'     => false,
                'add_fragment' => '',
            ) );
            
            wp_reset_query($loop->post->ID);
            ?>
      </div>
   </div>
</div>
</div>
<?php get_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
jQuery(document).ready(function($){
 jQuery(function ($) {
   function addSeparator(nStr) {
     nStr += '';
     var x = nStr.split('.');
     var x1 = x[0];
     var x2 = x.length > 1 ? '.' + x[1] : '';
     var rgx = /(\d+)(\d{3})/;
     while (rgx.test(x1)) {
         x1 = x1.replace(rgx, '$1' + '.' + '$2');
     }
     return x1 + x2;
   }

   function rangeInputRangeChangeEventHandler(e){
         var rangeGroup = $(this).attr('name'),
             minBtn = $(this).parent().children('.min'),
             maxBtn = $(this).parent().children('.max'),
             range_min = $(this).parent().children('#min_price'),
             range_max = $(this).parent().children('#max_price'),
             minVal = parseInt($(minBtn).val()),
             maxVal = parseInt($(maxBtn).val()),
             origin = $(this).context.className;

         if(origin === 'min' && minVal > maxVal-5){
             $(minBtn).val(maxVal-5);
         }
         var minVal = parseInt($(minBtn).val());
         $(range_min).val(addSeparator(minVal*1000));


         if(origin === 'max' && maxVal-5 < minVal){
             $(maxBtn).val(5+ minVal);
         }
         var maxVal = parseInt($(maxBtn).val());
         $(range_max).val(addSeparator(maxVal.toFixed(2)*1000));
     }

 $('.price-info input[type="range"]').on( 'input', rangeInputRangeChangeEventHandler);

   $("#slider").slider({
       min: 0,
       max: 100,
       step: 1,
       values: [10, 90],
       slide: function(event, ui) {
           for (var i = 0; i < ui.values.length; ++i) {
               $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
           }
       }
   });

   $("input.sliderValue").change(function() {
       var $this = $(this);
       $("#slider").slider("values", $this.data("index"), $this.val());
   });      

 });
});
</script>