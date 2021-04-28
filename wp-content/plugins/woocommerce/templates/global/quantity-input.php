<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
	?>
	<div class="quantity-box-main">
	<div class="quantity quantity-box input-group">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<span class="input-group-btn" id="decrementQuentity">
			<button type="button" class="quantity-left-minus btn btn-number" data-type="minus" data-field="quantity">
                    <span class="fas fa-minus"></span>
            </button>
		</span>
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
			size="4"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>" />
		<span class="input-group-btn" id="incrementQuentity">
			<button type="button" class="quantity-right-plus btn btn-number" data-type="plus" data-field="quantity">
                <span class="fas fa-plus"></span>
            </button>
		</span>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	</div>
	<?php
}
?>
<script>
jQuery(document).ready(function($){
   jQuery(function ($) { 
      $('#decrementQuentity').on('click', function(){
      	var curentQuentity = $(this).siblings('input').val();
      	if(parseInt(curentQuentity) > 1){
      		$(this).siblings('input').val(parseInt(curentQuentity) - 1);
      	}
      	
      });

      $('#incrementQuentity').on('click', function(){
      	var curentQuentity = $(this).siblings('input').val();      	
      	if(parseInt(curentQuentity) >= 1){
      		$(this).siblings('input').val(parseInt(curentQuentity) + 1);
      	}
      });
   	});
});
</script>

<style type="text/css">
#incrementQuentity {
    padding: 5px 16px 0px 0px;
}
#decrementQuentity {
    padding: 5px 16px 0px 0px;
}
#incrementQuentity, #decrementQuentity {
    width: 10px;	    
    color: #fff;
    font-size: 27px;
}
#decrementQuentity .quantity-left-minus {
	border-radius: 5px 0px 0px 5px;
}
#incrementQuentity .quantity-right-plus {
	border-radius: 0px 5px 5px 0px;
}

.quantity-box-main .quantity-box {
    margin-bottom: 0px;
}

.quantity-box-main .quantity-box {
    margin-right: 30px;
    margin-bottom: 15px;
}
.quantity-box-main .input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
    border-radius: 20px;
}

.quantity-box-main .quantity-box {
    max-width: 83px;
    flex-wrap: nowrap;
}
.quantity-box-main .quantity-box.input-group .btn {
    border-radius: 0px;
    height: 37px;
    background-color: #f7f7f7;
    border: 1px solid #dae2e6;
    font-size: 10px;
    padding: 6px;
}
.quantity-box-main .quantity-box.input-group .form-control {
    background-color: #f7f7f7 !important;
    border-left: none;
    border-right: none;
    padding: 0px;
    text-align: center;
    height: 32px;
    font-size: 0.875rem !important;
}

.quantity-box-main .input-group.quantity-box input.qty.text {   
    border: 1px solid #ced4da;    
}

.woocommerce div.product form.cart div.quantity {    
    margin: 0 22px 0 0;
}


</style>