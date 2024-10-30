<?php
defined( 'ABSPATH' ) || die( 'Not allowed' );

class NytBestsellerListings {

	private static $options_name = 'nyt_bestseller_listings';

	public static function setApiKey( $v ) {
		$v = sanitize_text_field( $v );
		return update_option( self::$options_name . '_apiKey', $v );
	}
	public static function getApiKey() {
		return get_option( self::$options_name . '_apiKey', false );
	}

	public static function getDefaultList() {
		return 'hardcover-fiction';
	}

	public static function setCatalogLinkFormat( $v ) {
		if ( ! $v )
			return delete_option( self::$options_name . '_CatalogLinkFormat' );

		$v = sanitize_text_field( $v );
		return update_option( self::$options_name . '_CatalogLinkFormat', $v );
	}
	public static function getCatalogLinkFormat() {
		return get_option( self::$options_name . '_CatalogLinkFormat' );
	}
	public static function formatCatalogLink( $args = [] ) {
		$clink = self::getCatalogLinkFormat();
		if ( ! $clink )
			return false;
		if ( ! count( $args ) )
			return false;
		foreach ( $args as $field => $value ) {
			$clink = str_replace( '{' . $field . '}', $value, $clink );
		}
		return $clink;
	}

	public static function getApiBase() {
		return 'https://api.nytimes.com/svc/books/v3/lists/';
	}

	public static function getApiUrl( $endpoint, $params= [] ) {
		$endpoint = ltrim( $endpoint, '/' );
		$url = self::getApiBase();
		$url .= $endpoint;
		if ( count( $params ) )
			$url .= '?' . http_build_query( $params );
		return $url;
	}

	/**
	 * Get results from the NYT api
	 * @param  string  $endpoint   endpoint to hit on the api
	 * @param bool $use_cache  Whether to use cached results for this call, if any exist
	 * @param  array   $params     extra query params to send to the api
	 * @param  boolean $json_decode set to false to leave results as a json-encoded
	 *                             string
	 * @return mixed               object if $json_decode=true, otherwise a string
	 */
	public static function getResults( $endpoint, $use_cache=true, $params=[], $json_decode=true ) {
		$api_key = self::getApiKey();
		if ( ! $api_key )
			return false;
		$params = array_merge($params, [
			'api-key' => $api_key,
		]);
		$transient_name = "nyt_bestseller_lists_{$endpoint}_" . md5( serialize($params) );
		$stored_results = get_transient( $transient_name );
		
		if ( ! empty( $stored_results ) && $use_cache ) {
			$result_body = $stored_results;
		} else {
			$url = self::getApiUrl( $endpoint, $params );

			$results = wp_remote_get( $url );
			$result_body = wp_remote_retrieve_body( $results );

			if ( $result_body ) {
				set_transient( $transient_name, $result_body, DAY_IN_SECONDS );
			}
		}

		if ( $json_decode )
			$result_body = json_decode( $result_body );

		return $result_body;
	}


	/**
	 * get html for a dropdown/select list of the available lists
	 *
	 * @param string|null $selected_list  The list to be initially selected
	 * @param bool $use_cache  Whether to use the api-call cache (defaults true)
	 *
	 * @return string  The html for the dropdown/select list (or an empty string
	 *  if failure to fetch)
	 */
	public static function getListsDropdown( $selected_list = null, $use_cache = true ) {
		$results = self::getResults( 'names.json', $use_cache );

		if ( ! $results ) {
			return '';
		}

		if ( is_null( $selected_list ) )
			$selected_list = self::getDefaultList();
		$out = '<div class="nyt-bestseller-listings-changeListWrap">Change List
		<select class="js-nyt-bestseller-listings_changeList">';
		foreach ( $results->results as $list ) {
			$selected = ( $list->list_name_encoded == $selected_list )
				? ' selected '
				: '';
			$out .= "<option value='{$list->list_name_encoded}' {$selected}>{$list->list_name}</option>\n";
		}
		$out .= '</select>
		</div>';
		return $out;
	}

	/**
	 * Get the book list from NYT api
	 *
	 * @param  string  $list          the slug for the list
	 * @param  boolean $use_cache whether to use the api-call cache (default:true)
	 * @param  boolean $display_images should we display images (default:true)
	 * 
	 * @return string  The html for the list of bestsellers
	 */
	public static function getBookList( $list, $use_cache = true, $display_images=true ) {
		$endpoint = "current/{$list}.json";
		$results = self::getResults( $endpoint, $use_cache );

		if ( ! $results ) {
			return '<p style="color:red;"><b>Error getting list.</b></p>';
		}

		$out = '';

		foreach ( $results->results->books as $book ) {

			$links = self::getBookLinks( $book );

			$image_html = '';
			$block_class = array( 'nyt-bestseller-listings-book' );
			if ( $display_images ) {
				$image_html = '<div>
					<img class="nyt-bestseller-listings-img" src="' . $book->book_image . '" alt="Book Cover" />
				</div>';
				$block_class[] = '_with-image';
			}
			$block_class = esc_attr( implode( ' ', $block_class ) );

			$out .= '
			<div class="' . $block_class . '">
				<h3>#' . $book->rank . ': ' . ucwords( strtolower( $book->title ) ) . '</h3>
				<div>
					<p class="nyt-bestseller-listings-author">' . $book->author . '</p>
					<p class="nyt-bestseller-listings-description">' . $book->description . '</p>';

			if ( $links ) {
				$out .= '<ul class="nyt-bestseller-listings-links">';
				foreach ( $links as $name => $url ) {
					$out .= "<li><a href='{$url}'>{$name}</a></li>";
				}
				$out .= '</ul>';
			}

				$out .= '</div>
					' . $image_html . '				
			</div>';

		}
		return $out;
	}

	public static function getBookLinks( $book ) {
		$links = [];

		if ( $book->sunday_review_link )
			$links['New York Times Sunday Review'] = $book->sunday_review_link;
		if ( $book->book_review_link )
			$links['New York Times Book Review'] = $book->book_review_link;
		if ( $book->first_chapter_link )
			$links['First Chapter'] = $book->first_chapter_link;
		$catalog_link = self::formatCatalogLink([
			'isbn' => $book->primary_isbn13,
			'author' => $book->author,
			'title' => strtolower( $book->title ),
		]);
		if ( $catalog_link )
			$links['Library Catalog'] = $catalog_link;

		return $links;
	}
}
