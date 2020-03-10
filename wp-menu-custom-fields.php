<?php
/**
 * Plugin Name: WP Menu Custom Fields
 * Author: rtCamp
 * Text Domain: wp-menu-custom-fields
 *
 * @package wp-menu-custom-fields
 */

if ( ! class_exists( 'WP_Menu_Custom_Fields' ) ) {

	/**
	 * Class WP_Menu_Custom_Fields
	 */
	class WP_Menu_Custom_Fields {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'wp_nav_menu_item_custom_fields' ), 10, 4 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'wp_update_nav_menu_item', array( $this, 'wp_update_nav_menu_item' ), 10, 2 );

			add_filter( 'wp_nav_menu_objects', array( $this, 'wp_nav_menu_objects' ), 10, 2 );
			add_filter( 'walker_nav_menu_start_el', array( $this, 'walker_nav_menu_start_el' ), 10, 4 );
		}

		/**
		 * Returns meta keys which needs to be stored/fetched.
		 *
		 * @return array Meta keys.
		 */
		private function get_meta_keys() {
			$meta_keys = array(
				'custom-text',
				'shortcode',
				'shortcode-caption',
				'media-id',
				'media-type',
				'media-link',
				'media-caption',
				'custom-html',
			);

			return $meta_keys;
		}

		/**
		 * Get menu item meta data.
		 *
		 * @param int $menu_item_id Menu item ID.
		 * @return array Meta data.
		 */
		private function get_nav_menu_meta_data( $menu_item_id ) {
			$data = array();

			$meta_keys = $this->get_meta_keys();

			foreach ( $meta_keys as $meta_key ) {
				$meta_value = get_post_meta( $menu_item_id, 'menu-item-' . $meta_key, true );

				if ( ! empty( $meta_value ) ) {
					$data[ $meta_key ] = $meta_value;

					if ( 'media-id' === $meta_key ) {
						$media_url = wp_get_attachment_url( $meta_value );

						if ( ! empty( $media_url ) ) {
							$data['media-url'] = $media_url;
						}
					}
				}
			}

			return $data;
		}

		/**
		 * Add custom fields on menu item edit screen.
		 *
		 * @param int    $id Current menu item ID.
		 * @param object $item Current menu object.
		 * @param int    $depth Current menu children depth.
		 * @param array  $args Current menu Arguments.
		 * @return void
		 */
		public function wp_nav_menu_item_custom_fields( $id, $item, $depth, $args ) {
			$data = $this->get_nav_menu_meta_data( $id );

			$media_style = '';
			if ( empty( $data['media-url'] ) || empty( $data['media-type'] ) ) {
				$media_style = 'display: none;';
			}

			wp_nonce_field( 'menu-item-custom-fields-' . $id, 'menu-item-custom-fields-' . $id );

			?>
			<p class="description description-wide">
				<label for="menu-item-custom-text-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Custom Text', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-custom-text-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-custom-text-<?php echo esc_attr( $id ); ?>" name="menu-item-custom-text[<?php echo esc_attr( $id ); ?>]"><?php echo ( ! empty( $data['custom-text'] ) ? esc_html( $data['custom-text'] ) : '' ); ?></textarea>
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-media-id-<?php echo esc_attr( $id ); ?>">

					<button onclick="navMenuSelectMediaHandler( this )" type="button" data-id="<?php echo esc_attr( $id ); ?>" class="custom-field-select-image"><?php esc_html_e( 'Select Media', 'wp-menu-custom-fields' ); ?></button>

					<input type="hidden" value="<?php echo ( ! empty( $data['media-id'] ) ? esc_attr( $data['media-id'] ) : '' ); ?>" id="menu-item-media-id-<?php echo esc_attr( $id ); ?>" name="menu-item-media-id[<?php echo esc_attr( $id ); ?>]">

					<input type="hidden" value="<?php echo ( ! empty( $data['media-type'] ) ? esc_attr( $data['media-type'] ) : '' ); ?>" id="menu-item-media-type-<?php echo esc_attr( $id ); ?>" name="menu-item-media-type[<?php echo esc_attr( $id ); ?>]">

				</label>
			</p>
			<p id="menu-item-selected-media-display-paragraph-<?php echo esc_attr( $id ); ?>" class="description description-wide" style="<?php echo esc_attr( $media_style ); ?>">
				<?php
				if ( ! empty( $data['media-url'] ) && ! empty( $data['media-type'] ) ) {
					if ( 'video' === $data['media-url'] ) {
						echo '<video src="' . esc_url( $data['media-url'] ) . '" height="100"></video>';
					} elseif ( 'image' === $data['media-type'] ) {
						echo '<img src="' . esc_url( $data['media-url'] ) . '" height="100">';
					}
				}
				?>
			</p>
			<p class="description description-wide">
				<label for="menu-item-media-link-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Media Link', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-media-link-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-media-link" name="menu-item-media-link[<?php echo esc_attr( $id ); ?>]" value="<?php echo ( ! empty( $data['media-link'] ) ? esc_url( $data['media-link'] ) : '' ); ?>">
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-media-caption-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Media Caption', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-media-caption-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-media-caption" name="menu-item-media-caption[<?php echo esc_attr( $id ); ?>]"><?php echo ( ! empty( $data['media-caption'] ) ? esc_html( $data['media-caption'] ) : '' ); ?></textarea>
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-shortcode-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Shortcode', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-shortcode-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-shortcode" name="menu-item-shortcode[<?php echo esc_attr( $id ); ?>]" value="<?php echo ( ! empty( $data['shortcode'] ) ? esc_attr( $data['shortcode'] ) : '' ); ?>">
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-custom-html-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Custom HTML', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-custom-html-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-custom-html" name="menu-item-custom-html[<?php echo esc_attr( $id ); ?>]"><?php echo ( ! empty( $data['custom-html'] ) ? wp_kses_post( $data['custom-html'] ) : '' ); ?></textarea>
				</label>
			</p>
			<?php
		}

		/**
		 * Add scripts on admin side.
		 *
		 * @param string $hook_suffix Current admin page.
		 * @return void
		 */
		public function admin_enqueue_scripts( $hook_suffix ) {
			if ( 'nav-menus.php' === $hook_suffix ) {
				wp_enqueue_script( 'jquery' );
				wp_enqueue_media();
				wp_enqueue_script( 'custom-fields-script', plugin_dir_url( __FILE__ ) . '/script.js', array( 'jquery' ), time(), true );
				wp_enqueue_script( 'tinyMCE-script', 'https://cdn.tiny.cloud/1/yg3c898omtym8cl4iczkjjcyq9l7oizcuhwfv8krczct33ns/tinymce/5/tinymce.min.js', array(), time(), true );
			}
		}

		/**
		 * Function called when menu item edit form is submitted.
		 *
		 * @param int $menu_id Menu ID.
		 * @param int $item_id Item ID.
		 * @return void
		 */
		public function wp_update_nav_menu_item( $menu_id, $item_id ) {
			$nonce = filter_input( INPUT_POST, 'menu-item-custom-fields-' . $item_id, FILTER_SANITIZE_STRING );
			if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'menu-item-custom-fields-' . $item_id ) ) {
				return;
			}

			$data = array();

			$meta_keys = $this->get_meta_keys();

			foreach ( $meta_keys as $meta_key ) {

				if ( isset( $_POST[ 'menu-item-' . $meta_key ][ $item_id ] ) ) {

					if ( 'custom-html' === $meta_key ) {
						$meta_value = wp_kses_post( wp_unslash( $_POST[ 'menu-item-' . $meta_key ][ $item_id ] ) );
					} else {
						$meta_value = sanitize_text_field( wp_unslash( $_POST[ 'menu-item-' . $meta_key ][ $item_id ] ) );
					}
					update_post_meta( $item_id, 'menu-item-' . $meta_key, $meta_value );

					$data[ $meta_key ] = $meta_value;

					if ( 'media-id' === $meta_key ) {
						$media_url = wp_get_attachment_url( $meta_value );

						if ( ! empty( $media_url ) ) {
							$data['media-url'] = $media_url;
						}
					}
				} else {
					delete_post_meta( $item_id, 'menu-item-' . $meta_key );
				}
			}

			$this->cache_nav_menu_meta_data( $item_id, $data );
		}

		/**
		 * Function to filter nav menu objects.
		 *
		 * @param array $sorted_items Menu items after being sorted.
		 * @param array $args Menu arguments.
		 * @return array Sorted menu items.
		 */
		public function wp_nav_menu_objects( $sorted_items, $args ) {
			global $nav_menu_custom_fields;
			if ( empty( $nav_menu_custom_fields ) || ! is_array( $nav_menu_custom_fields ) ) {
				$nav_menu_custom_fields = array();
			}

			foreach ( $sorted_items as $item ) {
				$data          = $this->get_nav_menu_cached_meta_data( $item->ID );
				$data_modified = false;

				if ( empty( $data ) ) {
					$data          = $this->get_nav_menu_meta_data( $item->ID );
					$data_modified = true;
				}

				if ( ! empty( $data ) ) {
					$nav_menu_custom_fields[ $item->ID ] = $data;

					if ( $data_modified ) {
						$this->cache_nav_menu_meta_data( $item->ID, $data );
					}
				}
			}

			return $sorted_items;
		}

		/**
		 * Function to filter HTML of a nav menu item.
		 *
		 * @param string $html HTML of nav menu item.
		 * @param object $item Menu item object.
		 * @param int    $depth Menu item's children depth.
		 * @param array  $args Menu item's arguments.
		 * @return string HTML of nav menu item.
		 */
		public function walker_nav_menu_start_el( $html, $item, $depth, $args ) {
			global $nav_menu_custom_fields;
			if ( empty( $nav_menu_custom_fields ) || ! is_array( $nav_menu_custom_fields ) ) {
				return $html;
			}

			if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-url'] ) && ! empty( $nav_menu_custom_fields[ $item->ID ]['media-type'] ) ) {
				if ( 'video' === $nav_menu_custom_fields[ $item->ID ]['media-type'] ) {
					$html .= '<div class="nav-media type-video">';

					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) ) {
						$html .= '<a href="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) . '">';
					}
					$html .= '<video src="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-url'] ) . '" style="height: 50px;"></video>';
					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) ) {
						$html .= '</a>';
					}

					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) ) {
						$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) . '</span>';
					}

					$html .= '</div>';

				} elseif ( 'image' === $nav_menu_custom_fields[ $item->ID ]['media-type'] ) {
					$html .= '<div class="nav-media type-image">';

					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) ) {
						$html .= '<a href="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) . '">';
					}
					$html .= '<img src="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-url'] ) . '" style="height: 50px;">';
					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-link'] ) ) {
						$html .= '</a>';
					}

					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) ) {
						$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) . '</span>';
					}

					$html .= '</div>';
				}
			}

			if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['shortcode'] ) ) {
				$html .= '<div class="nav-shortcode">' . do_shortcode( $nav_menu_custom_fields[ $item->ID ]['shortcode'] );

				if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['shortcode-caption'] ) ) {
					$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['shortcode-caption'] ) . '</span>';
				}

				$html .= '</div>';
			}

			if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['custom-html'] ) ) {
				$html .= '<div class="nav-custom-html">' . wp_kses_post( $nav_menu_custom_fields[ $item->ID ]['custom-html'] ) . '</div>';
			}

			if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['custom-text'] ) ) {
				$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['custom-text'] ) . '</span>';
			}

			return $html;
		}

		/**
		 * Function to get transient data.
		 *
		 * @param int $item_id Menu item ID.
		 * @return array|boolean Transient data or false.
		 */
		private function get_nav_menu_cached_meta_data( $item_id ) {
			$key  = 'menu-item-' . $item_id . '-custom-data';
			$data = get_transient( $key );
			if ( ! empty( $data ) ) {
				return $data;
			}

			return false;
		}

		/**
		 * Function to set transient data.
		 *
		 * @param int   $item_id Menu item ID.
		 * @param array $data Data to be stored in transient.
		 * @return void
		 */
		private function cache_nav_menu_meta_data( $item_id, $data ) {
			$key = 'menu-item-' . $item_id . '-custom-data';
			set_transient( $key, $data, DAY_IN_SECONDS );
		}

	}
}

new WP_Menu_Custom_Fields();
