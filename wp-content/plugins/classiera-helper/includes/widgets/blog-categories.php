<?php
class TWBlogcategoryWidget extends WP_Widget {
    public function __construct() {	
        $widget_ops = array('classname' => 'TWBlogcategoryWidget', 'description' => 'Blog Categories.');
		parent::__construct( 'TWBlogcategoryWidget', esc_html__( 'Blog Categories', 'classiera-helper' ), $widget_ops );
    }
    function widget($args, $instance) {
        global $post;
		extract($instance);
		$title = apply_filters('widget_title', $instance['title']);
		?>
		<div class="col-lg-12 col-md-12 col-sm-6 match-height">
			<div class="widget-box">
				<?php 
				if (isset($before_widget)) { 
					echo wp_kses_post($before_widget);
				}
				if ($title != ''){
					echo wp_kses_post($args['before_title']); ?> <i class="far fa-folder-open"></i> <?php
					echo wp_kses_post($title) . $args['after_title']; 
				}
				?>
				<div class="widget-content">
					<ul class="category">
						<?php 
						$args = array(
							'parent' => 0,
							'orderby' => 'name',
							'order' => 'ASC',
							'pad_counts' => true,
							'hide_empty' => false,
						);
						$categories = get_terms('blog_category',$args);
						foreach ($categories as $category) {
							$tag = $category->term_id;
							?>
							<li>
								<a href="<?php echo esc_url(get_category_link( $category->term_id ))?>" title="View posts in <?php echo esc_html($category->name)?>">
									<?php echo esc_html($category->name) ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div><!--widget-content-->
				<?php 
				if (isset($after_widget)) { 
					echo wp_kses_post($after_widget);
				}
				?>
		    </div><!--widget-box-->
		</div><!--col-lg-12-->
		<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;      
        $instance['title'] = strip_tags($new_instance['title']);       
        return $instance;
    }
    function form($instance) {
	extract($instance);
	$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Blog categories', 'classiera-helper' );
       ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php _e("Title:", "classiera-helper");?>
			</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"  />
        </p>
        <?php
    }
}
function TWBlogcategoryWidget() {
    register_widget( 'TWBlogcategoryWidget' );
}
add_action( 'widgets_init', 'TWBlogcategoryWidget' );