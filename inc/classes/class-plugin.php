<?php
/**
 * Plugin manifest class.
 *
 * @package wp-mega-menu
 */

namespace WP_Mega_menu\Inc;

use \WP_Mega_menu\Inc\Traits\Singleton;

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
