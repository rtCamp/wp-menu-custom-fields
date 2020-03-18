<?php
/**
 * Abstract class to register post type.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Post_Types;

use \WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Base class to register post types.
 */
abstract class Base {

	use Singleton;

	/**
	 * Construct method.
	 */
	final protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * To register action/filters.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Actions
		 */
		add_action( 'init', [ $this, 'register_post_type' ] );

	}

	/**
	 * To register post type.
	 *
	 * @return void
	 */
	final public function register_post_type() {

		if ( empty( static::SLUG ) ) {
			return;
		}

		$args = $this->get_args();
		$args = ( ! empty( $args ) && is_array( $args ) ) ? $args : [];

		$labels = $this->get_labels();
		$labels = ( ! empty( $labels ) && is_array( $labels ) ) ? $labels : [];

		if ( ! empty( $labels ) && is_array( $labels ) ) {
			$args['labels'] = $labels;
		}

		register_post_type( static::SLUG, $args );

	}

	/**
	 * To get argument to register custom post type.
	 *
	 * To override arguments, defined this method in child class and override args.
	 *
	 * @return array
	 */
	public function get_args() {

		return [
			'show_in_rest'  => true,
			'public'        => true,
			'has_archive'   => true,
			'menu_position' => 6,
			'supports'      => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
		];

	}

	/**
	 * To get slug of post type.
	 *
	 * @return string Slug of post type.
	 */
	public function get_slug() {
		return ( ! empty( static::SLUG ) ) ? static::SLUG : '';
	}

	/**
	 * To get list of labels for custom post type.
	 * Must be in child class.
	 *
	 * @return array
	 */
	abstract public function get_labels();

}
