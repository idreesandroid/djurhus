<?php 
global $redux_demo;
$classieraLogo = $redux_demo['logo']['url'];
$classieraMinimalTxt = $redux_demo['classiera_minimal_header_text'];
?>
<section class="minimal_page_heading">
	<div class="minimal_page_logo text-center">
		<a href="<?php echo esc_url(home_url()); ?>" class="minimal_page_logo text-center">
			<?php if(empty($classieraLogo)){?>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>">
			<?php }else{ ?>
				<img src="<?php echo esc_url($classieraLogo); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php } ?>
		</a>
	</div>
	<h4 class="minimal_page_title text-center">
		<?php if(function_exists('classiera_escape')) { classiera_escape($classieraMinimalTxt); } ?>
	</h4>
</section>