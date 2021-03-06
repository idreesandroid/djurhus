<?php
function theme_enqueue_styles() {
	
	if(is_rtl()){
		wp_enqueue_style( 'child-rtl', get_stylesheet_directory_uri() . '/rtl.css' );
	}
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
	wp_enqueue_script('classiera-child', get_stylesheet_directory_uri() . '/classiera-child.js', 'jquery', '', true);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );