<?php
/**
 * To load all classes that register meta box.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use WP_Menu_Custom_Fields\Inc\Meta_Boxes\Metabox_Example_2;
use WP_Menu_Custom_Fields\Inc\Traits\Singleton;
use WP_Menu_Custom_Fields\Inc\Meta_Boxes\Metabox_Example;

/**
 * Class Meta_Boxes
 */
class Meta_Boxes {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load all meta boxes classes.
		Metabox_Example::get_instance();
		Metabox_Example_2::get_instance();

	}

}
