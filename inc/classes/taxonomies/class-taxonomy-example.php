<?php
/**
 * To register custom taxonomy.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Taxonomies;

/**
 * Class Taxonomy_Example
 */
class Taxonomy_Example extends Base {

	/**
	 * Slug of taxonomy.
	 *
	 * @var string
	 */
	const SLUG = 'taxonomy-slug';

	/**
	 * Labels for taxonomy.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'                       => _x( 'Taxonomy_Example', 'taxonomy general name', 'wp-menu-custom-fields' ),
			'singular_name'              => _x( 'Taxonomy_Example', 'taxonomy singular name', 'wp-menu-custom-fields' ),
			'search_items'               => __( 'Search Taxonomy_Example', 'wp-menu-custom-fields' ),
			'popular_items'              => __( 'Popular Taxonomy_Example', 'wp-menu-custom-fields' ),
			'all_items'                  => __( 'All Taxonomy_Example', 'wp-menu-custom-fields' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Taxonomy_Example', 'wp-menu-custom-fields' ),
			'update_item'                => __( 'Update Taxonomy_Example', 'wp-menu-custom-fields' ),
			'add_new_item'               => __( 'Add New Taxonomy_Example', 'wp-menu-custom-fields' ),
			'new_item_name'              => __( 'New Taxonomy_Example Name', 'wp-menu-custom-fields' ),
			'separate_items_with_commas' => __( 'Separate Taxonomy_Example with commas', 'wp-menu-custom-fields' ),
			'add_or_remove_items'        => __( 'Add or remove Taxonomy_Example', 'wp-menu-custom-fields' ),
			'choose_from_most_used'      => __( 'Choose from the most used Taxonomy_Example', 'wp-menu-custom-fields' ),
			'not_found'                  => __( 'No Taxonomy_Example found.', 'wp-menu-custom-fields' ),
			'menu_name'                  => __( 'Taxonomy_Example', 'wp-menu-custom-fields' ),
		];

	}

	/**
	 * List of post types for taxonomy.
	 *
	 * @return array
	 */
	public function get_post_types() {

		return [
			'post',
		];

	}

}
