<?php
/**
 * Plugin Name: WP Mega Menu
 * Description: Adds custom fields on nav menu edit screen and shows it on site menu.
 * Plugin URI:  https://rtcamp.com
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0
 * Text Domain: wp-mega-menu
 *
 * @package wp-mega-menu
 */

define( 'WP_MEGA_MENU_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WP_MEGA_MENU_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once WP_MEGA_MENU_PATH . '/inc/helpers/autoloader.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function wp_mega_menu_plugin_loader() {
	\WP_Mega_menu\Inc\Plugin::get_instance();
}

wp_mega_menu_plugin_loader();
