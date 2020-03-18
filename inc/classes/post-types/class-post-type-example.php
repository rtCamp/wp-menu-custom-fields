<?php
/**
 * Register Example post type.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Post_Types;

/**
 * Class Post_Type_Example
 */
class Post_Type_Example extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'post-type-slug';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'Post Type Label';

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return [
			'name'               => _x( 'Post_Type_Label', 'post type general name', 'wp-menu-custom-fields' ),
			'singular_name'      => _x( 'Post_Type_Label', 'post type singular name', 'wp-menu-custom-fields' ),
			'menu_name'          => _x( 'Post_Type_Label', 'admin menu', 'wp-menu-custom-fields' ),
			'name_admin_bar'     => _x( 'Post_Type_Label', 'add new on admin bar', 'wp-menu-custom-fields' ),
			'add_new'            => _x( 'Add New', 'post', 'wp-menu-custom-fields' ),
			'add_new_item'       => __( 'Add New Post_Type_Label', 'wp-menu-custom-fields' ),
			'new_item'           => __( 'New Post_Type_Label', 'wp-menu-custom-fields' ),
			'edit_item'          => __( 'Edit Post_Type_Label', 'wp-menu-custom-fields' ),
			'view_item'          => __( 'View Post_Type_Label', 'wp-menu-custom-fields' ),
			'all_items'          => __( 'All Post_Type_Label', 'wp-menu-custom-fields' ),
			'search_items'       => __( 'Search Post_Type_Label', 'wp-menu-custom-fields' ),
			'parent_item_colon'  => __( 'Parent Post_Type_Label:', 'wp-menu-custom-fields' ),
			'not_found'          => __( 'No Post_Type_Label found.', 'wp-menu-custom-fields' ),
			'not_found_in_trash' => __( 'No Post_Type_Label found in Trash.', 'wp-menu-custom-fields' ),
		];

	}

}
