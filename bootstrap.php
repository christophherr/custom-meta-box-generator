<?php
/**
 * Custom Meta Box Generator Plugin
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator
 * @author      christophherr
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Custom Meta Box Generator
 * Plugin URI:  https://github.com/christophherr/custom-meta-box-generator
 * Description: Plugin to generate reusable Custom Meta Boxes.
 * Version:     1.0.0
 * Author:      christophherr
 * Author URI:  https://www.christophherr.com
 * Text Domain: custom-meta-box-generator-generator
 * License:     GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace ChristophHerr\CustomMetaBoxGenerator;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'CUSTOM_META_BOX_URL', $plugin_url );
	define( 'CUSTOM_META_BOX_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	init_constants();
	require __DIR__ . '/src/config-store/module.php';
	require __DIR__ . '/src/metadata/module.php';
	require __DIR__ . '/src/output.php';

	// Load configuration files into the module.
	\ChristophHerr\CustomMetaBoxGenerator\Metadata\autoload_configurations( array(
		__DIR__ . '/config/subtitle.php',
		__DIR__ . '/config/portfolio.php',
	) );
}
launch();

