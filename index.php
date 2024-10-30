<?php
/*
Plugin Name: Bestseller Lists from the New York Times
Plugin URI:  https://jakeparis.com/wordpress-plugins/
Description: Integrate bestseller lists from the New York Times into your own site with a user-friendly interface.
Version:     2.4.0
Requires PHP: 7.4
Requires at least: 5.4
Tested up to: 6.5.2
Author:      Jake Paris
Author URI:  https://jakeparis.com/
License:     GPL-3.0
License URI: https://opensource.org/licenses/GPL-3.0
*/
defined( 'ABSPATH' ) || die( 'Not allowed' );

define( 'BSLNYT_PLUGIN_VERSION', '2.4.0' );
define( 'BSLNYT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BSLNYT_PLUGIN_URL', plugins_url( '/', __FILE__ ) );


require_once BSLNYT_PLUGIN_PATH . 'class-nytbestsellerlistings.php';
require_once BSLNYT_PLUGIN_PATH . 'functions.php';

require_once BSLNYT_PLUGIN_PATH . 'plugin-updates.php';

add_action('wp_enqueue_scripts', function () {
	wp_register_script( 'nyt-bestseller-listings',
		BSLNYT_PLUGIN_URL . 'build/ui/public.js',
		array(
			'jquery',
		),
		BSLNYT_PLUGIN_VERSION
	);
	wp_register_style( 'nyt-bestseller-listings',
		BSLNYT_PLUGIN_URL . 'build/ui/public.css',
		array(),
		BSLNYT_PLUGIN_VERSION
	);

	if ( ! empty( $_SERVER['HTTPS'] ) ) {
		$js_args = array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ) );
	} else {
		$js_args = array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ) );
	}
	wp_localize_script( 'nyt-bestseller-listings', 'nyt_bestseller_listings_settings', $js_args );
});


add_action('init', function () {
	add_shortcode( 'nyt-bestseller-listings', function ( $atts, $content ) {
		return wp_kses_post( NytBestsellerListings_mainDisplay( $atts, $content ) );
	});

	register_block_type( BSLNYT_PLUGIN_PATH . 'build/lists/block.json' );
});


add_action('admin_menu', function () {
	add_options_page( 'NYT Bestseller Lists', 'NYT Bestseller Lists', 'activate_plugins', 'nyt-bestseller-lists', 'nytBestSellerListings_adminPage' );
});

function nytBestSellerListings_adminPage() {
	require_once BSLNYT_PLUGIN_PATH . 'admin-page.php';
}


add_action( 'wp_ajax_nyt_bestseller_listings_getList', 'nytBestSellerListings_ajax_getList' );
add_action( 'wp_ajax_nopriv_nyt_bestseller_listings_getList', 'nytBestSellerListings_ajax_getList' );
function nytBestSellerListings_ajax_getList() {
	$list = sanitize_text_field( $_GET['listName'] );

	$display_images = ( isset( $_GET['displayImages'] ) )
		? (bool) $_GET['displayImages']
		: true;

	$html = NytBestsellerListings::getBookList( $list, true, $display_images );
	echo wp_kses_post( $html );
	exit;
}

add_action( 'wp_ajax_nyt_bestseller_listings_getAllLists', 'nytBestSellerListings_ajax_getAllLists' );
add_action( 'wp_ajax_nopriv_nyt_bestseller_listings_getAllLists', 'nytBestSellerListings_ajax_getAllLists' );
function nytBestSellerListings_ajax_getAllLists () {
	$all_lists = NytBestsellerListings::getResults( 'names.json' );
	$all_lists_configured = [];
	if ( ! empty( $all_lists ) ) {
		foreach ( $all_lists->results as $list ) {
			$all_lists_configured[] = [
				'label' => $list->display_name,
				'value' => $list->list_name_encoded,
			];
		}
	}
	wp_send_json_success( $all_lists_configured );
}

register_deactivation_hook(__FILE__, function () {
	delete_option( 'nyt_bestseller_listings_apiKey' );
	delete_option( 'nyt_bestseller_listings_defaultList' );
});
