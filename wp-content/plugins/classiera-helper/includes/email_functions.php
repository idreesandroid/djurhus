<?php
/*==========================
 Classiera Email Filter
 1- Filter content type.
 2- Filter Name
 3- Filter Email
 ===========================*/
add_filter ("wp_mail_content_type", "classiera_mail_content_type");
function classiera_mail_content_type() {
	return "text/html";
}
add_filter('wp_mail_from_name', 'classiera_blog_name_from_name');
function classiera_blog_name_from_name($name = '') {
    return get_bloginfo('name');
}
add_filter ("wp_mail_from", "classiera_mail_from");
function classiera_mail_from() {
	$sendemail =  get_bloginfo('admin_email');
	return $sendemail;
}
/*==========================
 Email template which sent When Email is Published
 ===========================*/	
if(!function_exists('classiera_post_status_email')) { 
	add_action( 'transition_post_status', 'classiera_post_status_email', 10, 3 );
	function classiera_post_status_email( $new_status, $old_status, $post ){
		/*==========================
		Send Email When Ad will be Rejected
		===========================*/
		if ($new_status == 'rejected'){	
			$post_author_id = get_post_field( 'post_author', $post->ID );		
			$author = get_userdata($post_author_id);		
			$author_email = $author->user_email;
			$author_display = $author->user_login;
			$blog_title = get_bloginfo('name');
			global $redux_demo;
			if( class_exists( 'Redux' )) {   
			   $redux_demo = get_option( 'redux_demo' );
			}
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$classiera_reject_email = $redux_demo['classiera_reject_email'];
			$email_subject = esc_html__( 'Your ad has been rejected', 'classiera-helper' );
			$adminEmail =  get_bloginfo('admin_email');	
			ob_start();			
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hello', 'classiera-helper' ); ?>, <?php echo esc_attr($author_display); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Unfortunately, your listing, which was posted on', 'classiera-helper' ); ?> &nbsp;<?php echo get_bloginfo('name'); ?>&nbsp;<?php esc_html_e( 'has been rejected.', 'classiera-helper' ); ?>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'This may be do to the content in your listing that goes against our Terms of Service', 'classiera-helper' ); ?>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php echo get_bloginfo('name'); ?>&nbsp;<?php esc_html_e( 'reserve all rights to remove Ads if they are inappropriate or have content that is deemed inappropriate.', 'classiera-helper' ); ?>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Please feel free to try another ad but keep it clean next time.', 'classiera-helper' ); ?>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your dashboard to see post status. If you have any questions, opinions, praise, problems, comments or suggestions, please feel free to contact us at', 'classiera-helper' ); ?> <a href="mailto:<?php echo sanitize_email($adminEmail); ?>"><?php echo sanitize_email($adminEmail); ?></a> <?php esc_html_e('any time!', 'classiera-helper') ?></p>
			</div>
			<?php			
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
			$message = ob_get_contents();
			ob_end_clean();		
			
			if( function_exists('classiera_send_wp_mail')){
				if($classiera_reject_email == true){
					classiera_send_wp_mail($author_email, $email_subject, $message);
				}
			}
		}
		/*==========================
		Send Email When Ad will be posted for review
		===========================*/
		if ( $new_status === 'private' ) {
			$post = get_post($post->ID);
			$post_author_id = get_post_field( 'post_author', $post->ID );
			$author = get_userdata($post->post_author);
			global $redux_demo;
			if( class_exists( 'Redux' )) {   
			   $redux_demo = get_option( 'redux_demo' );
			}
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];						
			$classiera_private_email = $redux_demo['classiera_private_email'];						
			$email_subject = esc_html__( 'Please Approve Post', 'classiera-helper' );
			$adminEmail =  get_bloginfo('admin_email');	
			ob_start();
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hello Admin,', 'classiera-helper' ); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Hi', 'classiera-helper' ); ?>, <?php echo esc_html($author->display_name); ?>. <?php esc_html_e( 'have posted a new ads', 'classiera-helper' ); ?><strong>(<a href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a>)</strong> <?php esc_html_e( 'on', 'classiera-helper' ); ?> <?php echo get_bloginfo('name'); ?>
				</p>
				 <p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please approve or reject this post you’re your WordPress Dashboard.', 'classiera-helper' ); ?> </p>
			</div>
			<?php
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
			$message = ob_get_contents();
			ob_end_clean();
			
			if( function_exists('classiera_send_wp_mail')){
				if($classiera_private_email == true){
					classiera_send_wp_mail($adminEmail, $email_subject, $message);
				}
			}
		}
		/*==========================
		Send Email When Ad will be published
		===========================*/
		if($new_status === 'publish' && $old_status !== 'publish' && $post->post_type === 'post'){
			$post = get_post($post->ID);
			$post_author_id = get_post_field( 'post_author', $post->ID );
			$author = get_userdata($post->post_author);				
			global $redux_demo;
			if( class_exists( 'Redux' )) {   
			   $redux_demo = get_option( 'redux_demo' );
			}
			$adminEmail =  get_bloginfo('admin_email');
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$classiera_publish_email = $redux_demo['classiera_publish_email'];
			$email_subject = esc_html__( 'Your listing has been published!', 'classiera-helper' );
			$author_email = $author->user_email;
			ob_start();
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hi', 'classiera-helper' ); ?>, <?php echo esc_attr($author->display_name) ?>. <?php esc_html_e( 'Congratulations, your item has been listed.', 'classiera-helper' ); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'Just a note to let you know your Ad', 'classiera-helper' ); ?> 
					<strong>(<?php echo esc_html($post->post_title) ?>)</strong> <?php esc_html_e( 'has been successfully listed and is now live on the site', 'classiera-helper' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>
				</p>				
				<p>
					<span style="display: block;font-family: 'Lato', sans-serif; font-size: 16px; font-weight: bold; color: #232323; margin-bottom: 10px;"><?php esc_html_e( 'If you like to take a look', 'classiera-helper' ); ?> : </span>
					<a href="<?php echo get_permalink($post->ID) ?>" style="color: #0d7cb0; font-family: 'Lato', sans-serif; font-size: 14px; ">
						<?php esc_html_e( 'Click Here', 'classiera-helper' ); ?>
					</a>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your dashboard to see post status. If you have any questions, opinions, praise, problems, comments or suggestions, please feel free to contact us at', 'classiera-helper' ); ?> <a href="mailto:<?php echo sanitize_email($adminEmail); ?>"><?php echo sanitize_email($adminEmail); ?></a> <?php esc_html_e('any time!', 'classiera-helper') ?></p>
			</div>
			<?php
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');	
			$message = ob_get_contents();
			ob_end_clean();	
			if( function_exists('classiera_send_wp_mail')){
				if($classiera_publish_email == true){
					classiera_send_wp_mail($author_email, $email_subject, $message);
				}
			}
		} 
		/*==========================
		Send Email When Ad will be expired
		===========================*/
		if($new_status === 'trash' || $new_status === 'expired' && $old_status === 'publish' && $post->post_type === 'post'){
			$post_author_id = get_post_field( 'post_author', $post->ID );
			$author = get_userdata($post_author_id);	
			$author_email = $author->user_email;
			$author_display = $author->user_login;
			$blog_title = get_bloginfo('name');
			global $redux_demo;
			if( class_exists( 'Redux' )) {   
			   $redux_demo = get_option( 'redux_demo' );
			}
			$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
			$classiera_expire_email = $redux_demo['classiera_expire_email'];
			$email_subject = esc_html__( 'Your ad has been removed!', 'classiera-helper' );
			$adminEmail =  get_bloginfo('admin_email');
			ob_start();
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
			?>
			<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
				<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
				<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
				<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
					<?php esc_html_e( 'Hello', 'classiera-helper' ); ?>, <?php echo esc_attr($author_display); ?>
				</h3>
			</div>
			<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
					<?php esc_html_e( 'We are just letting you know your ad has been removed from the', 'classiera-helper' ); ?> &nbsp;<?php echo get_bloginfo('name'); ?>
				</p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Your post title', 'classiera-helper' ); ?> : <?php echo get_the_title($post->ID); ?> </p>
				<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your dashboard to see post status. If you have any questions, opinions, praise, problems, comments or suggestions, please feel free to contact us at', 'classiera-helper' ); ?> <a href="mailto:<?php echo sanitize_email($adminEmail); ?>"><?php echo sanitize_email($adminEmail); ?></a> </p>
			</div>
			<?php
			include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
			$message = ob_get_contents();			
			ob_end_clean();
			if( function_exists('classiera_send_wp_mail')){
				if($classiera_expire_email == true){
					classiera_send_wp_mail($author_email, $email_subject, $message);
				}
			}
		}
	}
}
/*==========================
 Email template New User Registration Function
 ===========================*/
if(!function_exists('classieraUserNotification')) {  
	function classieraUserNotification($email, $password, $username){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];			
		$welComeUser = esc_html__( 'Welcome to ', 'classiera-helper' ).$blog_title;	
		$email_subject = $welComeUser." ".$username."!";
		
		ob_start();	
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($welComeUser); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'A very special welcome to you', 'classiera-helper' ); ?>, <?php echo esc_attr($username) ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
				<?php esc_html_e( 'Our site is growing fast and we are stoked you have joined up to start Buying & Selling on', 'classiera-helper' ); ?> <?php echo esc_html($blog_title); ?>
			</h3>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'A few important details for you to keep safe..!', 'classiera-helper' ); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Your username is', 'classiera-helper' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($username); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Your password is', 'classiera-helper' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($password) ?>
				</span>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'We hope you enjoy your stay at', 'classiera-helper' ); ?> <a href="<?php echo esc_url($blog_url); ?>"><?php echo esc_html($blog_title); ?></a>. <?php esc_html_e( 'Please visit your dashboard to see post status. If you have any questions, opinions, praise, problems, comments or suggestions, please feel free to contact us at', 'classiera-helper' ); ?> 
			 <strong><?php echo sanitize_email($adminEmail); ?> </strong><?php esc_html_e( 'any time!', 'classiera-helper' ); ?>
			</p>
		</div>
		<?php		
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');		
		$message = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($email, $email_subject, $message);
		}
	}
}
/*==========================
 Email to Admin On New User Registration
 ===========================*/
if(!function_exists('classieraNewUserNotifiy')) { 
	function classieraNewUserNotifiy($email, $username){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];		
		$email_subject = "New user has been registered on ".$blog_title;
		
		ob_start();	
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;">
				<?php esc_html_e( 'New user has been registered!', 'classiera-helper' ); ?>
			</h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello Admin, new user has been registered on', 'classiera-helper' ); ?>, <?php echo esc_html($blog_title) ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Hello, a new user has registered on', 'classiera-helper' ); ?>,&nbsp;<?php echo esc_html($blog_title) ?>. <?php esc_html_e( 'By using this email', 'classiera-helper' ); ?>&nbsp;<?php echo sanitize_email($email); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Their username is:', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($username); ?>
				</span>
			</p>
		</div>	
		<?php
		
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		
		$message = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($adminEmail, $email_subject, $message);
		}
	}
}
/*==========================
	Email to Post Author
 ===========================*/
if(!function_exists('contactToAuthor')) { 
	function contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classieraPostTitle, $classieraPostURL) {	

		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];		
		$email_subject = $subject;
		
		ob_start();	
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_attr($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_attr($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_attr($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'You have received an email from', 'classiera-helper' ); ?>, <?php echo esc_attr($name); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; font-weight: normal; text-transform: capitalize;">
				<?php esc_html_e( 'Your have received this email from', 'classiera-helper' ); ?>
			</h3>
			<p><?php echo esc_html($comments); ?></p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Name', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_attr($name);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Sender Email', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo sanitize_email($email);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post Title', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
				<?php echo esc_html($classieraPostTitle);?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;"><?php esc_html_e( 'Your Post URL', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;"><?php echo esc_url($classieraPostURL);?></span>
			</p>
		</div>	
		<?php		
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		
		$message = ob_get_contents();
		ob_end_clean();
		
		if (function_exists('classiera_send_mail_with_headers')) {
			classiera_send_mail_with_headers($emailTo, $email_subject, $message, $headers);
		}
	}
}
/*==========================
	Reset Password email
 ===========================*/	
if(!function_exists('classiera_reset_password')) {  
	function classiera_reset_password($new_password, $userName, $userEmail ){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$emailTo = $userEmail;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'Password Reset', 'classiera-helper' );
		
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_attr($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Keep your password safe..!', 'classiera-helper' ); ?>, <?php echo esc_attr($name); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Your username is', 'classiera-helper' ); ?> :
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($userName); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Your new password is', 'classiera-helper' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_attr($new_password); ?>
				</span>
			</p>
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();	
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($emailTo, $email_subject, $message);
		}
	}	
}
/*==========================
	Send OFF to Author Email
 ===========================*/
if(!function_exists('classiera_send_offer_to_author')) {  
	function classiera_send_offer_to_author($offer_price, $offer_comment, $offer_post_id, $post_author_id, $offer_author_id, $offer_post_price){
		global $post;
		$classieraPT = get_the_title($offer_post_id);		
		/*== Offer Author data ==*/
		$offerAuthor = get_the_author_meta('display_name', $offer_author_id );
		if(empty($offerAuthor)){
			$offerAuthor = get_the_author_meta('user_nicename', $offer_author_id );
		}
		if(empty($offerAuthor)){
			$offerAuthor = get_the_author_meta('user_login', $offer_author_id );
		}
		/*== Post Author data ==*/		
		$postAuthor = get_the_author_meta('display_name', $post_author_id );
		if(empty($postAuthor)){
			$postAuthor = get_the_author_meta('user_nicename', $post_author_id );
		}
		if(empty($postAuthor)){
			$postAuthor = get_the_author_meta('user_login', $post_author_id );
		}
		$authorEmail = get_the_author_meta('user_email', $post_author_id);		
		/*== Post Author data ==*/
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;
		$emailTo = $userEmail;
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'New bid offer received!', 'classiera-helper' );
		
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Congratulations, you have received a new offer for your ad', 'classiera-helper' ); ?>:
			</h3>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php echo esc_html($classieraPT); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;"><?php esc_html_e( 'Your Price was', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 16px; color: #0d7cb0;">
				<?php echo esc_attr($offer_post_price); ?></span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;"><?php esc_html_e( 'Offered Price is currently', 'classiera-helper' ); ?> : </span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 16px; color: #0d7cb0;">
				<?php echo esc_attr($offer_price); ?></span>
			</p>		
			<p style="font-family: 'Ubuntu', sans-serif; font-size: 18px; color: #232323;">
				<?php esc_html_e( 'Log in to your account to reply to the user.', 'classiera-helper' ); ?><br/>
				<?php esc_html_e( 'We will leave you to negotiate the deal between you both.', 'classiera-helper' ); ?>
			</p>
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();
		
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($authorEmail, $email_subject, $message);
		}
	}
}	
/*==========================
	Report Ad to Admin
 ===========================*/
if(!function_exists('classiera_reportAdtoAdmin')) { 
	function classiera_reportAdtoAdmin($message, $classieraPostTitle, $classieraPostURL){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  get_bloginfo('admin_email');
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = esc_html__( 'Report ad notification!', 'classiera-helper' );
		
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
			<h3 style="font-family: 'Ubuntu', sans-serif; font-size:24px; text-align: center; text-transform: uppercase;">
				<?php esc_html_e( 'Hello Admin, DMCA/Copyright', 'classiera-helper' ); ?>
			</h3>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Hi, someone has reported an ad which had been posted on your website.', 'classiera-helper' ); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Ad title is', 'classiera-helper' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_html($classieraPostTitle); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Post Link', 'classiera-helper' ); ?> : 
				</span>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php echo esc_url($classieraPostURL); ?>
				</span>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php echo esc_html($message); ?>
			</p>
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($adminEmail, $email_subject, $emilbody);
		}
	}	
}
/*==========================
	Contact us Page email
 ===========================*/
if(!function_exists('classiera_contact_us_page')) {  
	function classiera_contact_us_page($name, $email, $submitMobile, $emailTo, $subject, $comments){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  $emailTo;
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$headers = 'From <'.$adminEmail.'>' . "\r\n" . 'Reply-To: ' . $email;
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$email_subject = $subject;
		
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;"><?php echo esc_html($email_subject); ?></h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php echo esc_html($comments); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Sender Name', 'classiera-helper' ); ?> : <?php echo esc_attr($name); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'Sender Email', 'classiera-helper' ); ?> : <?php echo sanitize_email($email); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'Sender Phone', 'classiera-helper' ); ?> : <?php echo esc_attr($submitMobile); ?>
				</span>
			</p>		
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if (function_exists('classiera_send_mail_with_headers')) {
			classiera_send_mail_with_headers($adminEmail, $email_subject, $emilbody, $headers);
		}
	}
}
/*==========================
Featured Ads Expiry Email
===========================*/
if(!function_exists('classiera_featured_ads_expire')) { 
	function classiera_featured_ads_expire($authorName, $authorEmail, $postTitle, $postID){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  get_bloginfo('admin_email');
		$email_subject = esc_html__( 'Your listing has now expired', 'classiera-helper' );
		$headers = 'From <'.$adminEmail.'>' . "\r\n" . 'Reply-To: ' . $authorEmail;
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		$classiera_expire_email = $redux_demo['classiera_expire_email'];
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;">
				<?php esc_html_e( 'Hello ', 'classiera-helper' ); ?>&nbsp;<?php echo esc_attr($authorName);?>&nbsp;
				<?php esc_html_e( 'Your featured ad has expired!', 'classiera-helper' ); ?>
			</h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Your featured ad has been removed from the featured listing. Now it is only shown in the regular listing section.', 'classiera-helper' ); ?>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #232323;">
					<?php esc_html_e( 'Post Title', 'classiera-helper' ); ?> : 
					<?php echo get_the_title($postID); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'For more info you contact us at', 'classiera-helper' ); ?> : <?php echo sanitize_email($adminEmail); ?>
				</span>
			</p>
			<p>
				<span style="font-family: 'Ubuntu', sans-serif; font-size: 14px; color: #0d7cb0;">
					<?php esc_html_e( 'Or visit your profile page from', 'classiera-helper' ); ?> : 
					<?php echo esc_url($blog_url); ?>
				</span>
			</p>		
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if (function_exists('classiera_send_mail_with_headers')) {
			if($classiera_expire_email == true){
				classiera_send_mail_with_headers($authorEmail, $email_subject, $emilbody, $headers);
			}
		}
	}
}
/*==========================
Featured Ads Expiry Email
===========================*/
if(!function_exists('classiera_bump_ads_notification')) {
	function classiera_bump_ads_notification($postID){
		$blog_title = get_bloginfo('name');
		$blog_url = esc_url( home_url() ) ;	
		$adminEmail =  get_bloginfo('admin_email');
		$email_subject = esc_html__( 'Your ad have bumped up successfully', 'classiera-helper' );
		global $redux_demo;
		if( class_exists( 'Redux' )) {   
		   $redux_demo = get_option( 'redux_demo' );
		}
		$postAuthorID = get_post_field( 'post_author', $postID );		
		$authorName = get_the_author_meta('user_login', $postAuthorID );
		$authorEmail = get_the_author_meta('user_email', $postAuthorID );
		$classieraEmailIMG = $redux_demo['classiera_email_header_img']['url'];
		ob_start();
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-header.php');
		?>
		<div class="classiera-email-welcome" style="padding: 50px 0; background: url('<?php echo esc_url($classieraEmailIMG); ?>'); background-size: cover; background-image:url('<?php echo esc_url($classieraEmailIMG); ?>'); background-repeat:repeat-x;">
			<h4 style="font-size:18px; color: #232323; text-align: center; font-family: 'Ubuntu', sans-serif; font-weight: normal; text-transform: uppercase;">
				<?php esc_html_e( 'Hello ', 'classiera-helper' ); ?>&nbsp;<?php echo esc_attr($authorName);?>
			</h4>
			<span class="email-seprator" style="width:100px; height: 2px; background: #b6d91a; margin: 0 auto; display: block;"></span>
		</div>
		<div class="classiera-email-content" style="padding: 50px 0; width:600px; margin:0 auto;">
			<p style="font-size: 18px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e( 'Your ad has been successfully bumped up on', 'classiera-helper' ); ?>&nbsp;<?php echo esc_html($blog_title) ?>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;">
				<?php esc_html_e('To view your ad on the site now', 'classiera-helper'); ?>&nbsp;
				<a href="<?php echo get_permalink($postID); ?>"><?php esc_html_e( 'Click here ', 'classiera-helper' ); ?></a>
			</p>
			<p style="font-size: 16px; font-family: 'Lato', sans-serif; color: #6c6c6c;"><?php esc_html_e( 'Please visit your dashboard to see post status. If you have any questions, opinions, praise, problems, comments or suggestions, please feel free to contact us at', 'classiera-helper' ); ?> <a href="mailto:<?php echo sanitize_email($adminEmail); ?>"><?php echo sanitize_email($adminEmail); ?></a> <?php esc_html_e('any time!', 'classiera-helper') ?></p>
		</div>
		<?php
		include(WPCH_PLUGIN_INCLUDES_DIR. 'email-footer.php');
		$emilbody = ob_get_contents();
		ob_end_clean();
		if( function_exists('classiera_send_wp_mail')){
			classiera_send_wp_mail($authorEmail, $email_subject, $emilbody);
		}
	}
}