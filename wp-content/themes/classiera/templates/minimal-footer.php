<?php 
	global $redux_demo;	
	$classieraCopyRight = $redux_demo['footer_copyright'];
	$classieraFacebook = $redux_demo['facebook-link'];
	$classieraTwitter = $redux_demo['twitter-link'];
	$classieraDribbble = $redux_demo['dribbble-link'];
	$classieraFlickr = $redux_demo['flickr-link'];
	$classieraGithub = $redux_demo['github-link'];
	$classieraPinterest = $redux_demo['pinterest-link'];	
	$classieraYouTube = $redux_demo['youtube-link'];
	$classieraGoogle = $redux_demo['google-plus-link'];
	$classieraLinkedin = $redux_demo['linkedin-link'];
	$classieraInstagram = $redux_demo['instagram-link'];
	$classieraVimeo = $redux_demo['vimeo-link'];
	$classieraVK = $redux_demo['vk-link'];
	$classieraOK = $redux_demo['odnoklassniki-link'];
?>
<footer class="minimal_footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php if(!empty($classieraFacebook)){?>
					<a href="<?php echo esc_url($classieraFacebook); ?>" class="minimla_social_icon">
						<i class="fab fa-facebook-f"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraTwitter)){?>
					<a href="<?php echo esc_url($classieraTwitter); ?>" class="minimla_social_icon">
						<i class="fab fa-twitter"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraGoogle)){?>
					<a href="<?php echo esc_url($classieraGoogle); ?>" class="minimla_social_icon">
						<i class="fab fa-google-plus-g"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraPinterest)){?>
					<a href="<?php echo esc_url($classieraPinterest); ?>" class="minimla_social_icon">
						<i class="fab fa-pinterest-p"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraInstagram)){?>
					<a href="<?php echo esc_url($classieraInstagram); ?>" class="minimla_social_icon">
						<i class="fab fa-instagram"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraVK)){?>
					<a href="<?php echo esc_url($classieraVK); ?>" class="minimla_social_icon">
						<i class="fab fa-vk"></i>
					</a>
				<?php } ?>
				<?php if(!empty($classieraOK)){?>
					<a href="<?php echo esc_url($classieraOK); ?>" class="minimla_social_icon">
						<i class="fab fa-odnoklassniki"></i>
					</a>
				<?php } ?>
				<?php classieraFooterNav(); ?>
			</div><!--col-lg-12-->
		</div><!--row-->
	</div><!--container-->
	<div class="minimal_footer_bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p><?php if(function_exists('classiera_escape')) { classiera_escape($classieraCopyRight); } ?></p>
				</div><!--col-lg-12-->
			</div><!--row-->
		</div><!--container-->
	</div><!--minimal_footer_bottom-->
</footer>