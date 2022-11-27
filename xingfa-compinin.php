<?php
/*
Plugin Name: Xingfa Companion Plugin
Plugin URI:
Description: Companion Plugin for Xingfa Theme
Version: 1.0
Author: Arif Islam
Author URI: https://arifislam.techviewing.com
License: GPLv2 or later
Text Domain: xingfa-companion
Domain Path: /languages/
*/

function xingfac_load_text_domain() {
	load_plugin_textdomain( 'xingfa-companion', false, dirname( __FILE__ ) . "/languages" );
}

add_action( 'plugins_loaded', 'xingfac_load_text_domain' );

function add_image_sizes() {
	add_image_size( '50x50', 50, 50, true );
	add_image_size('news', 400, 400, true);
}
add_action( 'init', 'add_image_sizes' );

include( plugin_dir_path( __FILE__ ) . 'post-types/certificate.php' );
include( plugin_dir_path( __FILE__ ) . 'post-types/projects.php' );
include( plugin_dir_path( __FILE__ ) . 'post-types/companyn.php' );
include( plugin_dir_path( __FILE__ ) . 'post-types/industryn.php' );
include( plugin_dir_path( __FILE__ ) . 'post-types/career.php' );
include( plugin_dir_path( __FILE__ ) . 'post-types/product.php' );

