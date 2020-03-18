<?php
/**
 * To load all classes of third party plugin configuration.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;
use WP_Menu_Custom_Fields\Inc\Plugin_Configs\Fieldmanager;

/**
 * Class Plugin_Configs
 */
class Plugin_Configs {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load all plugin configs classes.
		Fieldmanager::get_instance();

	}

}
