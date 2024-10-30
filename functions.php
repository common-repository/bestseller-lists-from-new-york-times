<?php
defined( 'ABSPATH' ) || die( 'Not allowed' );


function NytBestsellerListings_mainDisplay ( $atts, $content ) {
	wp_enqueue_script( 'nyt-bestseller-listings' );
	wp_enqueue_style( 'nyt-bestseller-listings' );

	if ( isset( $atts['initialList'] ) )
		$atts['initial-list'] = $atts['initialList'];

	$atts = shortcode_atts([
		'initial-list' => NytBestsellerListings::getDefaultList(),
		'displayImages' => '1',
	], $atts, 'nyt_bestseller_listings' );

	if ( isset( $_GET['nytlist'] ) )
		$atts['initial-list'] = sanitize_text_field( $_GET['nytlist'] );

	if ( $atts['displayImages'] === '1' ) {
		$display_images = true;
		$display_images_js = 'true';
	} else {
		$display_images = false;
		$display_images_js = 'false';
	}

	$js = '
		bslnyt = window.bslnyt || {};
		bslnyt.displayImages = ' . esc_js( $display_images_js ) . ';
	';

	wp_add_inline_script( 'nyt-bestseller-listings', $js, 'before' );

	$dropdown = NytBestsellerListings::getListsDropdown( $atts['initial-list'] );

	if ( ! empty( $dropdown ) ) :
		$out = $dropdown
			. '<div class="nyt-bestseller-listings-booklist">'
			. NytBestsellerListings::getBookList( $atts['initial-list'], true, $display_images )
			. '</div>'
			. $dropdown;
	else :
		$out = '<p style="color:red;">Error getting book lists.</p>';
	endif;

	return $out;
}


/**
 * Intended to be used with wp_kses_allowed_html filter to add select and option
 * to the allowed html for post version of wp_kses.
 *
 * @param array $allowed_html
 *
 * @return array
 */
function bslnyt_allowed_html_filter ( $allowed_html ) {
	$allowed_html = array_merge(
		$allowed_html,
		array(
			'select' => [
				'class' => true,
			],
			'option' => [
				'value' => true,
				'selected' => true,
			],
		)
	);
	return $allowed_html;
}
