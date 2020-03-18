<?php
/**
 * Registers assets for all blocks, and additional global functionality for gutenberg blocks.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;
use WP_Menu_Custom_Fields\Inc\Blocks\Example_Dynamic_Block;

/**
 * Class Blocks
 */
class Blocks {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

		Example_Dynamic_Block::get_instance();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		wp_register_script(
			'wp-menu-custom-fields-blocks',
			WP_MENU_CUSTOM_FIELDS_URL . '/assets/build/js/blocks.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
			filemtime( WP_MENU_CUSTOM_FIELDS_PATH . '/assets/build/js/blocks.js' ),
			true
		);

		wp_enqueue_script( 'wp-menu-custom-fields-blocks' );
	}
}
