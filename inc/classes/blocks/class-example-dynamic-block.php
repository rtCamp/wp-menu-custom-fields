<?php
/**
 * Example dynamic block class.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Blocks;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Example_Dynamic_Block
 */
class Example_Dynamic_Block {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * Setup hooks.
	 */
	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'init', [ $this, 'register_block_type' ] );

	}

	/**
	 * Register scripts.
	 */
	public function register_block_type() {

		register_block_type(
			'wp-menu-custom-fields/example-dynamic-block',
			[
				'editor_script'   => 'wp-menu-custom-fields-blocks',
				'render_callback' => [ $this, 'render_block' ],
				'attributes'      => [
					'postId' => [
						'type'    => 'integer',
						'default' => 0,
					],
				],
			]
		);

	}

	/**
	 * Render block.
	 *
	 * @param array $attributes List of attributes passed in block.
	 *
	 * @return string HTML elements.
	 */
	public function render_block( $attributes = [] ) {

		$attributes = wp_parse_args( $attributes, [] );

		// Theme is supposed to have template available inside template-parts/block-templates/example-dynamic-block-template.php.
		return project_name_render_template(
			'template-parts/block-templates/example-dynamic-block',
			[
				'attributes' => $attributes,
			]
		);

	}
}
