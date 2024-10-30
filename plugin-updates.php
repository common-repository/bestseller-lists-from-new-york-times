<?php
defined( 'ABSPATH' ) || die( 'Not allowed' );

$bslnyt_stored_version = get_option( 'bestseller-lists-nyt-plugin-version', 0 );



// bail if we're at the newest version
if ( ! version_compare( BSLNYT_PLUGIN_VERSION, $bslnyt_stored_version, '>' ) )
	return;


/**
 * Updates for various plugin versions.
 */

// Fixes bad option names < 1.3.0
if ( version_compare( '1.3.0', $bslnyt_stored_version, '>' ) ) {

	$api_key = get_option( '{self::}_apiKey', false );
	NytBestsellerListings::setApiKey( $api_key );
	delete_option( '{self::}_apiKey' );

	// $defaultList = get_option( "{self::}_defaultList", 'hardcover-fiction');
	// NytBestsellerListings::setDefaultList( $defaultList );
	delete_option( '{self::}_defaultList' );

	$cat_link_format = get_option( '{self::}_CatalogLinkFormat' );
	if ( $cat_link_format ) {
		NytBestsellerListings::setCatalogLinkFormat( $cat_link_format );
		delete_option( '{self::}_CatalogLinkFormat' );
	}
}

// remove global default list
if ( version_compare( '2.1.0', $bslnyt_stored_version, '>' ) ) {
	delete_option( 'nyt_bestseller_listings_defaultList' );
}



/* After running any needed updates, store the latest plugin version so we're
 * all up to date again.
 */
update_option( 'bestseller-lists-nyt-plugin-version', BSLNYT_PLUGIN_VERSION );
