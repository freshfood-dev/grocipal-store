<?php
    /*
    Plugin Name: Klb Shortcode
    Plugin URI: http://themeforest.net/user/klbtheme/portfolio
    Description: Plugin for displaying theme shortcodes.
    Author: KlbTheme
    Version: 1.2
    Author URI: http://themeforest.net/user/klbtheme/portfolio
    */
	
	
	require_once('inc/klb-shortcode.php');
	require_once('inc/style.php');	
	require_once('inc/aq_resizer.php');	
	require_once('inc/post_view.php');	

	
	if ( ! function_exists( 'klbshortcode' ) ) {
		function klbshortcode() {
		}
	}