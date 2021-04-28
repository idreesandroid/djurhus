<?php
/**
 * The template for displaying search form
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */
?>
<!-- search -->	
<!--<div class="widget-content">
	<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url( '/' )); ?>">
		<div class="input-group custom-wp-search">
			<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Enter keyword', 'classiera' ); ?>">
			<span class="input-group-btn">
				<button class="btn btn-wp-search" type="submit">
					<i class="fas fa-search"></i>
				</button>
			</span>
		</div>
	</form>
</div>-->
<div class="col-md-3 col-lg-3">
    <div class="search-box ml-auto header_search_box">
         <form role="search" id="searchform" action="<?php echo esc_url(home_url( '/' )); ?>" method="get">
            <div class="input-group">
                <input type="text" class="form-control filter-intput" placeholder="Search Product Name" name="s" id="search_term" value="<?php the_search_query(); ?>">                
                <div class="input-group-append">
                    <button class="btn btn-outline-white shop-product-search filter-intput" type="submit">
                    	<i class="fas fa-search"></i>
                    </button>
               	</div>
            </div>
        </form>
    </div>
</div> 

