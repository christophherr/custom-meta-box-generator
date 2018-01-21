<?php
/**
 * Metadata Module - Bootstrap file.
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
 * Autoload configuration files.
 *
 * @since 1.0.0
 *
 * @param array $config_files Array of configuration files.
 * @return void
 */
function autoload_configurations( array $config_files ) {
	$defaults = (array) require __DIR__ . '/defaults/meta-box-config.php';
	$defaults = current( $defaults );

	foreach ( $config_files as $config_file ) {
		$store_key = config_store\load_config_from_file_system( $config_file, $defaults );

		init_custom_fields_configuration( $store_key );
	}
}

/**
 * Initializing the custom fields configurations.
 * Remove the default configuration from the config passed intot he meta box generator.
 *
 * @since 1.0.0
 *
 * @param string $store_key Key / ID of the stored configuration.
 * @return void
 */
function init_custom_fields_configuration( $store_key ) {
	$config         = config_store\get_config( $store_key );
	$default_config = array_shift( $config['custom_fields'] );

	foreach ( $config['custom_fields'] as $meta_key => $custom_field_config ) {
		$config['custom_fields'][ $meta_key ] = array_merge( $default_config, $custom_field_config );
	}
	config_store\load_config( $store_key, $config );
}


/**
 * Autoload the module.
 *
 * @since 1.0.0
 *
 * @return void
 */
function autoload() {
	include __DIR__ . '/helpers.php';
	include __DIR__ . '/meta-box.php';
}

autoload();
