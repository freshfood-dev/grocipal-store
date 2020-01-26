<?php 
	 //load parent and child styles and scripts
	 add_action( 'wp_enqueue_scripts', 'child_groci_enqueue_styles' );
	 function child_groci_enqueue_styles() {
		 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
		 wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/assets/css/fonts.css' );
		 wp_enqueue_style( 'text', get_stylesheet_directory_uri() . '/assets/css/text.css' ); 
 	} 
 ?>