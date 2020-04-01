<?php
/**
 * Plugin manifest class.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use \WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Plugin
 */
class Plugin {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load plugin classes.
		Assets::get_instance();
		Custom_Nav_Menu_Fields::get_instance();

	}

}
