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
		 * Add custom fields on menu item edit screen.
		 *
		 * @param int    $id Current menu item ID.
		 * @param object $item Current menu object.
		 * @param int    $depth Current menu children depth.
		 * @param array  $args Current menu Arguments.
		 * @return void
		 */
		public function wp_nav_menu_item_custom_fields( $id, $item, $depth, $args ) {
			$custom_field = get_post_meta( $id, 'menu-item-custom-field', true );
			if ( empty( $custom_field ) ) {
				$custom_field = '';
			}

			$shortcode = get_post_meta( $id, 'menu-item-shortcode', true );
			if ( empty( $shortcode ) ) {
				$shortcode = '';
			}

			$shortcode_caption = get_post_meta( $id, 'menu-item-shortcode-caption', true );
			if ( empty( $shortcode_caption ) ) {
				$shortcode_caption = '';
			}

			$media_url = '';
			$media_id  = get_post_meta( $id, 'menu-item-media-id', true );
			if ( empty( $media_id ) ) {
				$media_id = '';
			} else {
				$media_url = wp_get_attachment_url( $media_id );
			}

			$media_type    = '';
			$media_caption = '';
			if ( empty( $media_url ) ) {
				$media_id = '';
			} else {
				$media_type = get_post_meta( $id, 'menu-item-media-type', true );
				if ( empty( $media_type ) ) {
					$media_type = '';
				}

				$media_caption = get_post_meta( $id, 'menu-item-media-caption', true );
				if ( empty( $media_caption ) ) {
					$media_caption = '';
				}
			}

			$media_style = '';
			if ( empty( $media_url ) || empty( $media_type ) ) {
				$media_style = 'display: none;';
			}

			$shortcode_style = '';
			if ( empty( $shortcode ) ) {
				$shortcode_style = 'display: none;';
			}

			wp_nonce_field( 'menu-item-custom-fields-' . $id, 'menu-item-custom-fields-' . $id );

			?>
			<p class="description description-wide">
				<label for="menu-item-custom-field-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Custom Text', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-custom-field-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-custom-field-<?php echo esc_attr( $id ); ?>" name="menu-item-custom-field[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $custom_field ); ?>">
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-media-id-<?php echo esc_attr( $id ); ?>">
					<button onclick="navMenuSelectMediaHandler( this )" type="button" data-id="<?php echo esc_attr( $id ); ?>" class="custom-field-select-image"><?php esc_html_e( 'Select Media', 'wp-menu-custom-fields' ); ?></button>
					<input type="hidden" value="<?php echo esc_attr( $media_id ); ?>" id="menu-item-media-id-<?php echo esc_attr( $id ); ?>" name="menu-item-media-id[<?php echo esc_attr( $id ); ?>]">
					<input type="hidden" value="<?php echo esc_attr( $media_type ); ?>" id="menu-item-media-type-<?php echo esc_attr( $id ); ?>" name="menu-item-media-type[<?php echo esc_attr( $id ); ?>]">
				</label>
			</p>
			<p id="menu-item-selected-media-display-paragraph-<?php echo esc_attr( $id ); ?>" class="description description-wide" style="<?php echo esc_attr( $media_style ); ?>">
				<?php
				if ( ! empty( $media_url ) && ! empty( $media_type ) ) {
					if ( 'video' === $media_type ) {
						echo '<video src="' . esc_url( $media_url ) . '" height="100"></video>';
					} elseif ( 'image' === $media_type ) {
						echo '<img src="' . esc_url( $media_url ) . '" height="100">';
					}
				}
				?>
			</p>
			<p class="description description-wide">
				<label for="menu-item-media-caption-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Media Caption', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-media-caption-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-media-caption-<?php echo esc_attr( $id ); ?>" name="menu-item-media-caption[<?php echo esc_attr( $id ); ?>]"><?php echo esc_attr( $media_caption ); ?></textarea>
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-shortcode-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Shortcode', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-shortcode-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-shortcode-<?php echo esc_attr( $id ); ?>" name="menu-item-shortcode[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $shortcode ); ?>">
				</label>
			</p>
			<p class="description description-wide">
				<label for="menu-item-shortcode-caption-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Shortcode Caption', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-shortcode-caption-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-shortcode-caption-<?php echo esc_attr( $id ); ?>" name="menu-item-shortcode-caption[<?php echo esc_attr( $id ); ?>]"><?php echo esc_attr( $shortcode_caption ); ?></textarea>
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

			$key = 'menu-item-custom-field';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['custom-field'] = $field;
			} else {
				delete_post_meta( $item_id, $key );
			}

			$key = 'menu-item-media-id';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['media-id'] = $field;
				$media_url        = wp_get_attachment_url( $field );
				if ( ! empty( $media_url ) ) {
					$data['media-url'] = $media_url;
				}
			} else {
				delete_post_meta( $item_id, $key );
			}

			$key = 'menu-item-media-type';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['media-type'] = $field;
			} else {
				delete_post_meta( $item_id, $key );
			}

			$key = 'menu-item-media-caption';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['media-caption'] = $field;
			} else {
				delete_post_meta( $item_id, $key );
			}

			$key = 'menu-item-shortcode';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['shortcode'] = $field;
			} else {
				delete_post_meta( $item_id, $key );
			}

			$key = 'menu-item-shortcode-caption';
			if ( isset( $_POST[ $key ][ $item_id ] ) ) {
				$field = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
				update_post_meta( $item_id, $key, $field );

				$data['shortcode-caption'] = $field;
			} else {
				delete_post_meta( $item_id, $key );
			}

			$this->set_menu_item_data( $item_id, $data );
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
				$data          = $this->get_menu_item_data( $item->ID );
				$data_modified = false;

				if ( empty( $data ) ) {
					$data = array();

					$custom_field = get_post_meta( $item->ID, 'menu-item-custom-field', true );
					if ( ! empty( $custom_field ) ) {
						$data['custom-field'] = $custom_field;
						$data_modified        = true;
					}

					$shortcode = get_post_meta( $item->ID, 'menu-item-shortcode', true );
					if ( ! empty( $shortcode ) ) {
						$data['shortcode'] = $shortcode;
						$data_modified     = true;

						$shortcode_caption = get_post_meta( $item->ID, 'menu-item-shortcode-caption', true );
						if ( ! empty( $shortcode_caption ) ) {
							$data['shortcode-caption'] = $shortcode_caption;
						}
					}

					$media_id = get_post_meta( $item->ID, 'menu-item-media-id', true );
					if ( ! empty( $media_id ) ) {
						$media_url = wp_get_attachment_url( $media_id );
						if ( ! empty( $media_url ) ) {
							$data['media-id']  = $media_id;
							$data['media-url'] = $media_url;
							$data_modified     = true;

							$media_type = get_post_meta( $item->ID, 'menu-item-media-type', true );
							if ( ! empty( $media_type ) ) {
								$data['media-type'] = $media_type;
							}
						}
					}
				}

				if ( ! empty( $data ) ) {
					$nav_menu_custom_fields[ $item->ID ] = $data;

					if ( $data_modified ) {
						$this->set_menu_item_data( $item->ID, $data );
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
					$html .= '<div class="nav-media type-video"><video src="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-url'] ) . '" style="height: 50px;"></video>';

					if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) ) {
						$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['media-caption'] ) . '</span>';
					}

					$html .= '</div>';

				} elseif ( 'image' === $nav_menu_custom_fields[ $item->ID ]['media-type'] ) {
					$html .= '<div class="nav-media type-image"><img src="' . esc_url( $nav_menu_custom_fields[ $item->ID ]['media-url'] ) . '" style="height: 50px;">';

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

			if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['custom-field'] ) ) {
				$html .= '<span>' . esc_html( $nav_menu_custom_fields[ $item->ID ]['custom-field'] ) . '</span>';
			}

			return $html;
		}

		/**
		 * Function to get transient data.
		 *
		 * @param int $item_id Menu item ID.
		 * @return array|boolean Transient data or false.
		 */
		private function get_menu_item_data( $item_id ) {
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
		private function set_menu_item_data( $item_id, $data ) {
			$key = 'menu-item-' . $item_id . '-custom-data';
			set_transient( $key, $data, DAY_IN_SECONDS );
		}

	}
}

new WP_Menu_Custom_Fields();
