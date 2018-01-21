<?php
/**
 * Config Store Module - Bootstrap file.
 *
 * @package     ChristophHerr\CustomMetaBoxGenerator\ConfigStore
 * @since       1.0.0
 * @author      christophherr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

namespace ChristophHerr\CustomMetaBoxGenerator\ConfigStore;

/**
 * Autoload the module
 *
 * @since 1.0.0
 *
 * @return void
 */
function autoload() {
	include __DIR__ . '/internals.php';
	include __DIR__ . '/api.php';
}

autoload();
