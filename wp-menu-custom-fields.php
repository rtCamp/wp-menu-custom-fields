<?php
/**
 * Plugin Name: WP Menu Custom Fields
 * Description: Adds custom fields on menu items under Appearance -> Menus and shows it on front-end.
 * Plugin URI:  https://wordpress.org/plugins/wp-menu-custom-fields/
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0.2
 * Text Domain: wp-menu-custom-fields
 *
 * @package wp-menu-custom-fields
 */

define( 'WP_MENU_CUSTOM_FIELDS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WP_MENU_CUSTOM_FIELDS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once WP_MENU_CUSTOM_FIELDS_PATH . '/inc/helpers/autoloader.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function wp_menu_custom_fields_plugin_loader() {
	\WP_Menu_Custom_Fields\Inc\Plugin::get_instance();
}

wp_menu_custom_fields_plugin_loader();
