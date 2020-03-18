<?php
/**
 * To load all classes that register taxonomy.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use \WP_Menu_Custom_Fields\Inc\Traits\Singleton;
use \WP_Menu_Custom_Fields\Inc\Taxonomies\Taxonomy_Example;

/**
 * Class Taxonomies
 */
class Taxonomies {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load all taxonomies classes.
		Taxonomy_Example::get_instance();

	}

}
