<?php
/**
 * Portfolio Meta Box Configuration Model.
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\Config
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\Config;

return array(
	/**
	 * Configure a unique ID for your meta box.
	 *
	 * This ID is used when running add_meta_box, for storing
	 * in the Config Store, for the view file, and save $_POST.
	 */
	'meta-box.portfolio' => array(
		/**
		 * Configuration parameters for adding the meta box.
		 * For more information on each of the parameters, see this
		 * article in Codex:
		 * @link https://developer.wordpress.org/reference/functions/add_meta_box/#parameters
		 */
		'add_meta_box'  => array(
			// 'id' is not needed as the meta box id/key is defined above
			// Title of the meta box
			'title'  => __( 'Portfolio', 'custom-meta-box-generator' ),
			// The screen or screens on which to show the box
			// such as a post type, link, comment, etc.
			'screen' => array( 'post' ),
		),
		/**
		 * Configure each custom field, specifying its meta_key, default
		 * value, delete_state, and sanitizing function.
		 */
		'custom_fields' => array(
			// specify this field's meta key.  It's used in the database.
			'client_name' => array(
				// True - means it's a single
				// False - means it's an array.
				'is_single'    => true,
				// Specify the custom field's default value.
				'default'      => '',
				// What is the state that signals to delete this meta key
				// from the database.
				'delete_state' => '',
				// callable sanitizer function such as
				// sanitize_text_field, sanitize_email, strip_tags, intval, etc.
				'sanitize'     => 'sanitize_text_field',
			),
			// specify this field's meta key.  It's used in the database.
			'client_url'  => array(
				// True - means it's a single
				// False - means it's an array.
				'is_single'    => true,
				// Specify the custom field's default value.
				'default'      => '',
				// What is the state that signals to delete this meta key
				// from the database.
				'delete_state' => '',
				// callable sanitizer function such as
				// sanitize_text_field, sanitize_email, strip_tags, intval, etc.
				'sanitize'     => 'sanitize_text_field',
			),
		),
		/**
		 * Configure the absolute path to your meta box's view file.
		 */
		'view'          => CUSTOM_META_BOX_DIR . 'src/views/portfolio.php',
	),
);
