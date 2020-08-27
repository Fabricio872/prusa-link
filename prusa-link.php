<?php
/**
 * Plugin Name: Prusa link
 * Plugin URI: http://www.mywebsite.com/my-first-plugin
 * Description: Widget for caching and showing data from web
 * Version: 0.0.1
 * Author: Fabricio Jakubec
 * Author URI: https://github.com/Fabricio872
 */

require __DIR__ . '/vendor/autoload.php';

add_action( 'init', 'register_shortcodes' );

function register_shortcodes() {
	add_shortcode( 'pp-link', 'main' );
}

function main( $atts = array(), $content = null ) {
	$main = new \App\Main( $atts[0] );

	return $main;
}
