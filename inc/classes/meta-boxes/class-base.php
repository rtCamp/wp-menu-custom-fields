<?php
/**
 * Base class for register meta box.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Meta_Boxes;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Base
 */
abstract class Base {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * To register action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Action
		 */
		add_action( 'fm_post', [ $this, 'register_meta_box' ] );

	}

	/**
	 * To register meta box.
	 *
	 * @param string $post_type Current post type.
	 *
	 * @throws \FM_Developer_Exception Field manager developer exception.
	 *
	 * @return void
	 */
	public function register_meta_box( $post_type ) {

		if ( empty( static::SLUG ) ) {
			return;
		}

		$post_types = $this->get_post_type();
		$post_types = ( ! empty( $post_types ) && is_array( $post_types ) ) ? $post_types : [];

		$meta_box_fields = $this->get_fields( $post_type );
		$meta_box_fields = ( ! empty( $meta_box_fields ) && is_array( $meta_box_fields ) ) ? $meta_box_fields : [];

		if ( empty( $post_types ) || ! is_array( $post_types ) || empty( $meta_box_fields ) || ! is_array( $meta_box_fields ) ) {
			return;
		}

		$context  = ( ! empty( $this->context ) ) ? $this->context : '';
		$priority = ( ! empty( $this->priority ) ) ? $this->priority : '';

		$field_manager = new \Fieldmanager_Group(
			[
				'name'           => static::SLUG,
				'serialize_data' => false,
				'add_to_prefix'  => false,
				'children'       => $meta_box_fields,
			]
		);

		$field_manager->add_meta_box( static::LABEL, $post_types, $context, $priority );

	}

	/**
	 * To get list of meta box fields.
	 *
	 * @param string $post_type Current post type.
	 *
	 * @return array List of field for meta box.
	 */
	public function get_fields( $post_type = '' ) {
		return [];
	}

	/**
	 * To get list of post types for that current meta box is allowed.
	 *
	 * @return array List of post types.
	 */
	public function get_post_type() {
		return [];
	}

}
