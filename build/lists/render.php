<?php

$attributes['displayImages'] = ( isset( $attributes['displayImages'] ) && $attributes['displayImages'] == false )
	? '0' : '1';


add_filter( 'wp_kses_allowed_html', 'bslnyt_allowed_html_filter' );
echo wp_kses_post(
	NytBestsellerListings_mainDisplay( $attributes, $content )
);
remove_filter( 'wp_kses_allowed_html', 'bslnyt_allowed_html_filter' );
