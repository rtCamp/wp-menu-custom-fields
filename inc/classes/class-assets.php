<?php
/**
 * Assets class.
 *
 * @package wp-mega-menu
 */

namespace WP_Mega_menu\Inc;

use WP_Mega_menu\Inc\Traits\Singleton;

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
	public function enqueue_scripts() {
		wp_enqueue_style( 'wp-mega-menu-style', WP_MEGA_MENU_URL . '/assets/build/css/main.css', array(), time() );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-mega-menu-script', WP_MEGA_MENU_URL . '/assets/build/js/main.js', array( 'jquery' ), time(), true );
	}

	/**
	 * To enqueue scripts and styles. in admin.
	 *
	 * @param string $hook_suffix Admin page name.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		if ( 'nav-menus.php' === $hook_suffix ) {
			wp_enqueue_style( 'wp-mega-menu-admin-style', WP_MEGA_MENU_URL . '/assets/build/css/admin.css', array(), time() );
			wp_enqueue_style( 'dashicons' );

			wp_enqueue_editor();
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'wp-tinymce' );
			wp_enqueue_media();
			wp_enqueue_script( 'wp-mega-menu-admin-script', WP_MEGA_MENU_URL . '/assets/build/js/admin.js', array( 'jquery', 'wp-tinymce', 'media-editor', 'media-views' ), time(), true );

			wp_localize_script(
				'wp-mega-menu-admin-script',
				'wpMegaMenu',
				array(
					'selectMediaText' => esc_html__( 'Select Image', 'wp-mega-menu' ),
				)
			);
		}
	}

}
