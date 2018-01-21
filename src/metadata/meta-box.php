<?php
/**
 * Custom Meta Box
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\Metadata
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\Metadata;

use WP_Post;
use ChristophHerr\CustomMetaBoxGenerator\ConfigStore as config_store;

add_action( 'admin_menu', __NAMESPACE__ . '\register_meta_boxes' );
/**
 * Register the meta box.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_meta_boxes() {
	foreach ( get_meta_box_keys() as $store_key ) {
		$config = config_store\get_config_parameter(
			$store_key,
			'add_meta_box'
		);

		add_meta_box(
			get_meta_box_id( $store_key ),
			$config['title'],
			__NAMESPACE__ . '\render_meta_box',
			$config['screen'],
			$config['context'],
			$config['priority'],
			$config['callback_args']
		);
	}
}
/**
 * Render the meta box
 *
 * @since 1.0.0
 *
 * @param WP_Post $post Instance of the post for this meta box.
 * @param array   $meta_box_args Array of meta box arguments.
 *
 * @return void
 */
function render_meta_box( WP_Post $post, array $meta_box_args ) {
	$meta_box_key = $meta_box_args['id'];
	$config       = config_store\get_config( 'meta-box.' . $meta_box_key );
	// Secure with a nonce.
	wp_nonce_field( $meta_box_key . '_nonce_action', $meta_box_key . '_nonce_name' );

	// Get the metadata.
	$custom_fields = get_custom_field_values( $post->ID, $meta_box_key, $config );

	// Load the view file.
	include $config['view'];
}

add_action( 'save_post', __NAMESPACE__ . '\save_meta_boxes' );
/**
 * Save the custom meta box.
 *
 * @since 1.0.0
 *
 * @param integer $post_id Post ID.
 * @return void
 */
function save_meta_boxes( $post_id ) {
	foreach ( get_meta_box_keys() as $store_key ) {
		$meta_box_key = get_meta_box_id( $store_key );

		if ( ! can_meta_box_be_saved( $meta_box_key ) ) {
			continue;
		}

		$config = config_store\get_config_parameter(
			$store_key,
			'custom_fields'
		);

		save_custom_fields( $config, $meta_box_key, $post_id );
	}
}


/**
 * Check if the current meta box can be saved.
 *
 * @since 1.0.0
 *
 * @param string $meta_box_key ID of the meta box.
 * @return boolean
 */
function can_meta_box_be_saved( $meta_box_key ) {
	// If this is not the right meta box, then bail out.
	if ( ! array_key_exists( $meta_box_key, $_POST ) ) {
		return false;
	}

	if (
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		( defined( 'DOING_AJAX' ) && DOING_AJAX ) ||
		( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return false;
	}

	// Security check.
	return wp_verify_nonce(
		$_POST[ $meta_box_key . '_nonce_name' ],
		$meta_box_key . '_nonce_action'
	);
}

/**
 * Save custom fields for a specific meta box.
 *
 * @since 1.0.0
 *
 * @param array  $config Custom fields configuration parameters.
 * @param string $meta_box_key ID / Key of the meta box.
 * @param int    $post_id Post ID.
 * @return void
 */
function save_custom_fields( $config, $meta_box_key, $post_id ) {
	$config = remap_custom_fields_config_for_saving( $config );

	// Merge with defaults.
	$metadata = wp_parse_args(
		$_POST[ $meta_box_key ],
		$config['default']
	);
	foreach ( $metadata as $meta_key => $value ) {
		if ( $config['delete_state'][ $meta_key ] === $value ) {
			delete_post_meta( $post_id, $meta_key );
			continue;
		}

		$sanitizing_function_to_use = $config['sanitize'][ $meta_key ];
		$value                      = $sanitizing_function_to_use( $value );

		update_post_meta( $post_id, $meta_key, $value );
	}
}

/**
 * Remap the custom fields for the save function.
 *
 * @since 1.0.0
 *
 * @param array $config Custom field configuration.
 * @return array
 */
function remap_custom_fields_config_for_saving( array $config ) {
	$remapped_config = array(
		'is_single'    => array(),
		'default'      => array(),
		'delete_state' => array(),
		'sanitize'     => array(),
	);

	foreach ( $config as $meta_key => $custom_field_config ) {
		foreach ( $custom_field_config as $parameter => $value ) {
			$remapped_config[ $parameter ][ $meta_key ] = $value;
		}
	}

	return $remapped_config;
}
