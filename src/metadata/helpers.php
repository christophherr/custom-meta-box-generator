<?php
/**
 * Metadata Module - Helper functions.
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\Metadata
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\Metadata;

use ChristophHerr\CustomMetaBoxGenerator\ConfigStore as config_store;

/**
 * Retrieve meta box keys from ConfigStore.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_meta_box_keys() {
	return (array) config_store\get_all_keys_starting_with( 'meta-box.' );
}

/**
 * Remove the prefix of the Store key to get the meta box id.
 *
 * @since 1.0.0
 *
 * @param string $store_key Key of the stored metabox.
 * @return string Meta box id.
 */
function get_meta_box_id( $store_key ) {
	return str_replace( 'meta-box.', '', $store_key );
}

/**
 * Get custom field values
 *
 * @since 1.0.0
 *
 * @param int    $post_id Post ID.
 * @param string $meta_box_key Key / ID of the meta box.
 * @param array  $config Configuration parameters.
 * @return array
 */
function get_custom_field_values( $post_id, $meta_box_key, array $config ) {
	$custom_fields = array();

	foreach ( $config['custom_fields'] as $meta_key => $custom_field_config ) {

		$custom_fields[ $meta_key ] = get_post_meta( $post_id, $meta_key, $custom_field_config['is_single'] );

		if ( ! $custom_fields[ $meta_key ] ) {
			$custom_fields[ $meta_key ] = $custom_field_config['default'];
		}
	};
	/**
	 * Filter the custom fields values before rendering the meta box.
	 *
	 * Allows for processing and filtering before the meta box is sent to the browser.
	 *
	 * @since 1.0.0
	 *
	 * @param array $custom_fields Array of custom fields values.
	 * @param string $meta_box_key Key / ID of the meta box.
	 * @param int $post_id Post ID.
	 */
	return (array) apply_filters( 'filter_meta_box_custom_fields',
		$custom_fields,
		$meta_box_key,
		$post_id
	);
}
