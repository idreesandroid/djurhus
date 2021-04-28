<?php 
global $redux_demo;
$calloutbg = $redux_demo['callout-bg']['url'];
$calloutbgV2 = $redux_demo['callout-bg-version2']['url'];
$calloutTitle = $redux_demo['callout_title'];
$calloutTitlesecond = $redux_demo['callout_title_second'];
$calloutDesc = $redux_demo['callout_desc'];
$calloutBtnTxt = $redux_demo['callout_btn_text'];
$calloutBtnURL = $redux_demo['callout_btn_url'];
$featuredAdsPage = classiera_get_template_url('template-pricing-plans.php');
$calloutBtnIcon = $redux_demo['callout_btn_icon_code'];
$calloutBtnIconTwo = $redux_demo['callout_btn_icon_code_two'];
$calloutBtnTxtTwo = $redux_demo['callout_btn_text_two'];
$calloutBtnURLTwo = $redux_demo['callout_btn_url_two'];
$classieraParallax = $redux_demo['classiera_parallax'];
?>
<section class="members-v1 <?php if($classieraParallax == 1){ echo 'parallax__400'; }?>" style="background-image:url(<?php echo esc_url($calloutbg); ?>)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 hidden-xs hidden-sm">
                <div class="mobile-img text-center">
                    <img src="<?php echo esc_url($calloutbgV2); ?>">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="members-text text-left flip">
                    <h2 class="callout_title">
						<?php if(function_exists('classiera_escape')) { classiera_escape($calloutTitle); } ?>
					</h2>
                    <h2 class="callout_title_second">
						<?php if(function_exists('classiera_escape')) { classiera_escape($calloutTitlesecond); } ?>
					</h2>
                    <p><?php if(function_exists('classiera_escape')) { classiera_escape($calloutDesc); } ?></p>
                    <a href="<?php echo esc_url($calloutBtnURL); ?>" class="btn btn-primary round btn-style-two btn-md active">
						<span><i class="<?php if(function_exists('classiera_escape')) { classiera_escape($calloutBtnIcon); } ?>"></i></span>
						<?php echo esc_html($calloutBtnTxt); ?>
					</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.Memebers -->