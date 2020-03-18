<?php
/**
 * Example meta box.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Meta_Boxes;

use WP_Menu_Custom_Fields\Inc\Post_Types\Post_Type_Example;
use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Metabox_Example_2
 */
class Metabox_Example_2 {

	use Singleton;

	/**
	 * Meta box slug.
	 *
	 * @var string Meta box slug.
	 */
	const SLUG = 'metabox-example-2';

	/**
	 * Meta box label.
	 *
	 * @var string Meta box label.
	 */
	const LABEL = 'Metabox Example 2';

	/**
	 * Context of meta box.
	 *
	 * @var string Context of meta box.
	 */
	protected $context = 'normal';

	/**
	 * Priority of meta box.
	 *
	 * @var string Priority of meta box.
	 */
	protected $priority = 'default';

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup actions/filters.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Action
		 */
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

	}

	/**
	 * To add meta box.
	 *
	 * @return void
	 */
	public function add_meta_boxes() {

		add_meta_box(
			static::SLUG,
			static::LABEL,
			[ $this, 'render_meta_box' ],
			$this->get_post_type(),
			$this->context,
			$this->priority
		);

	}

	/**
	 * List of post type in which meta box is allowed.
	 *
	 * @return array List of post type.
	 */
	public function get_post_type() {

		return [
			Post_Type_Example::SLUG,
		];

	}

	/**
	 * To render meta box.
	 *
	 * @return void
	 */
	public function render_meta_box() {

		$template = sprintf( '%s/templates/metabox-example.php', untrailingslashit( WP_MENU_CUSTOM_FIELDS_PATH ) );
		require_once $template;
	}

}
