<?php
defined( 'ABSPATH' ) || die( 'Not allowed' );


if ( isset( $_POST['nyt-bestseller-listings-settings'] ) ) :

	if ( ! wp_verify_nonce( $_POST['_nyt-bestseller-listings-settings-nonce'], 'save-nyt-bestseller-settings' ) ) {
		echo '<div class="error updated"><p>Could not save. Perhaps the form timed out?</p></div>';
	} else {
		NytBestsellerListings::setApiKey( sanitize_text_field( $_POST['nyt_bestseller_listings_apiKey'] ) );

		NytBestsellerListings::setCatalogLinkFormat( sanitize_text_field( $_POST['nyt_bestseller_listings_CatalogLinkFormat'] ) );
	}

endif;

$api_key = NytBestsellerListings::getApiKey();
$catalog_link_format = NytBestsellerListings::getCatalogLinkFormat();
?>
<style>
	label.block {
		font-weight: bold;
		display: block;
		margin:  .9em 0 .1em;
	}
	input.wide {
		min-width:  50em;
		max-width:  95%;
	}
	p.help {
		margin:  0;
		padding: 0;
		color: gray;
		font-size: .9em;
	}
</style>
<h1>New York Times Bestseller Listings &mdash; Settings</h1>
<form method="post" action="">
	<?php wp_nonce_field( 'save-nyt-bestseller-settings', '_nyt-bestseller-listings-settings-nonce' ); ?>

	<label class="block">API Key</label>
	<p class="help">You can get one of these <a href="https://developer.nytimes.com/signup">here.</a></p>
	<input type="text" class="wide" name="nyt_bestseller_listings_apiKey" value="<?php echo esc_attr( $api_key ); ?>">


	<label class="block">Catalog Links</label>
	<p class="help">You can add links to your library catalog to each book. Enter the catalog url below, using various placeholders to insert book variables. For example, settings this to <b>http://example.com/?serial={isbn}</b> would insert the book's isbn after the <b>serial=</b> in the resulting url. Leave this blank to hide links to a catalog.</p>
	<input type="text" class="wide" value="<?php echo esc_attr( $catalog_link_format ); ?>" name="nyt_bestseller_listings_CatalogLinkFormat">
	<p class="help">Placeholders: <b>{isbn}</b>, <b>{title}</b>, <b>{author}</b></p>

	<?php submit_button( 'Save', 'primary', 'nyt-bestseller-listings-settings' ); ?>

</form>
