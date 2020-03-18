<?php
/**
 * To load all classes that register widget.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use \WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Widgets
 */
class Widgets {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		// Load all widgets classes.
	}

}
