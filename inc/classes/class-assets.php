<?php
/**
 * Assets class.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class Assets
 */
class Assets {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Action
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

	}

	/**
	 * To enqueue scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {}

	/**
	 * To enqueue scripts and styles. in admin.
	 *
	 * @param string $hook_suffix Admin page name.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		if ( 'nav-menus.php' === $hook_suffix ) {
			wp_enqueue_style( 'wp-menu-custom-fields-style', WP_MENU_CUSTOM_FIELDS_URL . '/assets/build/css/main.css', array(), time() );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'wp-tinymce' );
			wp_enqueue_media();
			wp_enqueue_script( 'wp-menu-custom-fields-script', WP_MENU_CUSTOM_FIELDS_URL . '/assets/build/js/main.js', array( 'jquery', 'wp-tinymce', 'media-editor', 'media-views' ), time(), true );

			wp_localize_script(
				'wp-menu-custom-fields-script',
				'wpMenuCustomFields',
				array(
					'selectMediaText' => esc_html__( 'Select Image', 'wp-menu-custom-fields' ),
				)
			);
		}
	}

}
