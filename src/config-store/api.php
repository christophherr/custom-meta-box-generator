<?php
/**
 * Custom Meta Box Public API to interact with the Config Store
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\ConfigStore
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\ConfigStore;

/**
 * Get a specific configuration from the store.
 *
 *@since 1.0.0
 *
 * @param string $store_key Key of the store.
 * @return mixed
 */
function get_config( $store_key ) {
	return _the_store( $store_key );
}

/**
 * Get a specific Configuration Parameter from the store.
 *
 * @since 1.0.0
 *
 * @param string $store_key Key of the store.
 * @param string $parameter_key Key of the parameter.
 * @return mixed
 * @throws \Exception Thrown if $parameter_key does not exist.
 */
function get_config_parameter( $store_key, $parameter_key ) {
	$config = get_config( $store_key );
	if ( ! array_key_exists( $parameter_key, $config ) ) {
		throw new \Exception(
			sprintf(
				// translators: The parameter key that was requested from the Config.
				__( 'The configuration parameter [%1$s] does not exist in the ConfigStore of [%2$s]', 'custom-meta-box-generator' ),
				esc_html( $parameter_key ),
				esc_html( $store_key )
			)
		);
	};
	return $config[ $parameter_key ];
}

/**
 * Load the configuration into the store from the
 * absolute path to the configuration file.
 *
 * @since 1.0.0
 *
 * @param string $path_to_file Ansolute Path to the configuration file.
 * @param array  $defaults (optional) Array of default parameters.
 */
function load_config_from_file_system( $path_to_file, array $defaults = array() ) {
	list( $store_key, $config ) = _load_config_from_file( $path_to_file );

	// Merge with any defaults.
	if ( $defaults ) {
		$config = _merge_with_defaults( $config, $defaults );
	}

	_the_store( $store_key, $config );

	return $store_key;
}

/**
 * Load the Configuration into the store.
 *
 * @since 1.0.0
 *
 * @param string $store_key Unique store key.
 * @param mixed  $config Runtime configuration parameter(s).
 */
function load_config( $store_key, $config ) {
	_the_store( $store_key, $config );
}

/**
 * Get all the keys out of the ConfigStore.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_all_keys() {
	$config_store = _the_store();
	return array_keys( $config_store );
}

/**
 * Get all keys that are starting with the passed in string.
 *
 * @since 1.0.0
 *
 * @param string $starts_with String identifying the key we want.
 * @return array
 */
function get_all_keys_starting_with( $starts_with ) {
	return array_filter( get_all_keys(), function( $key ) use ( $starts_with ) {
		return str_starts_with( $key, $starts_with );
	});
}
