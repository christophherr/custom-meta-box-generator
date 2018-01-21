<?php
/**
 * Custom Meta Box Config Store Internal Functionality (Private)
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\ConfigStore
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\ConfigStore;

/**
 * The Configuration Store
 *
 * @since 1.0.0
 *
 * @param string $store_key Key of the store.
 * @param array  $config_to_store Configuration of the store.
 * @return mixed
 * @throws \Exception If store key does not exist.
 */
function _the_store( $store_key = '', $config_to_store = array() ) {
	static $config_store = array();

	// Get the whole config store.
	if ( ! $store_key ) {
		return $config_store;
	}

	if ( $config_to_store ) {
		$config_store[ $store_key ] = $config_to_store;
		return true;
	}

	if ( ! array_key_exists( $store_key, $config_store ) ) {
		throw new \Exception(
			sprintf(
				// translators: The store key that was requested from the ConfigStore.
				__( 'Configuration for [%1$s] does not exist in the ConfigStore', 'custom-meta-box-generator' ),
				esc_html( $store_key )
			)
		);
	};
	return $config_store[ $store_key ];
}

/**
 * Load Configuration from file
 * Returns storage key and configuration parameters.
 *
 * @since 1.0.0
 *
 * @param string $path_to_file Ansolute Path to the configuration file.
 * @return array
 */
function _load_config_from_file( $path_to_file ) {
	$config = (array) require $path_to_file;

	return array(
		key( $config ),
		current( $config ),
	);
}

/**
 * Merge Config with defaults.
 *
 * @since 1.0.0
 *
 * @param array $config Specific configuration.
 * @param array $defaults Default configuration.
 * @return array Merged configuration.
 */
function _merge_with_defaults( array $config, array $defaults ) {
	return array_replace_recursive( $defaults, $config );
}

/**
 * Checks if a string starts with a character or substring.
 *
 * @since 1.0.0
 *
 * @param string $haystack  The string to be searched.
 * @param string $needle    The character or substring to
 *                          find at the start of the $haystack.
 * @param string $encoding  Default is UTF-8.
 *
 * @return bool
 */
function str_starts_with( $haystack, $needle, $encoding = 'UTF-8' ) {
	$needle_length = mb_strlen( $needle, $encoding );
	return ( mb_substr( $haystack, 0, $needle_length, $encoding ) === $needle );
}
