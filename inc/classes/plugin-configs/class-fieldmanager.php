<?php
/**
 * Config for field manager plugin.
 *
 * Prevent saving of empty meta values.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc\Plugin_Configs;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Fieldmanager
 */
class Fieldmanager {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup action filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		add_filter( 'update_post_metadata', [ $this, 'on_update_post_metadata' ], 10, 4 );
		add_filter( 'update_user_metadata', [ $this, 'on_update_user_metadata' ], 10, 4 );

	}

	/**
	 * To prevent to store empty meta values in post meta records.
	 *
	 * @param null|bool $check      Whether to allow updating metadata for the given type.
	 * @param int       $object_id  Object ID.
	 * @param string    $meta_key   Meta key.
	 * @param mixed     $meta_value Meta value. Must be serializable if non-scalar.
	 *
	 * @return null/bool
	 */
	public function on_update_post_metadata( $check, $object_id, $meta_key, $meta_value ) {

		// Add meta keys in this array to prevent empty meta save.
		$meta_keys_to_check = [];

		if ( empty( $meta_value ) && in_array( $meta_key, $meta_keys_to_check, true ) ) {

			delete_post_meta( $object_id, $meta_key );

			return false;
		}

		return $check;
	}

	/**
	 * To prevent to store empty meta values in user meta records.
	 *
	 * @param null|bool $check      Whether to allow updating metadata for the given type.
	 * @param int       $object_id  Object ID.
	 * @param string    $meta_key   Meta key.
	 * @param mixed     $meta_value Meta value. Must be serializable if non-scalar.
	 *
	 * @return null/bool
	 */
	public function on_update_user_metadata( $check, $object_id, $meta_key, $meta_value ) {

		// Add meta keys in this array to prevent empty meta save.
		$meta_keys_to_check = [];

		if ( empty( $meta_value ) && in_array( $meta_key, $meta_keys_to_check, true ) ) {

			delete_user_meta( $object_id, $meta_key );

			return false;
		}

		return $check;
	}

}
