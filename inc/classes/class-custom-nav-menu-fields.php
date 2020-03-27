<?php
/**
 * Custom Nav Menu Fields class definition.
 *
 * @package wp-menu-custom-fields
 */

namespace WP_Menu_Custom_Fields\Inc;

use WP_Menu_Custom_Fields\Inc\Traits\Singleton;

/**
 * Class WP_Menu_Custom_Fields
 * Adds custom fields on nav menu edit screen and stores it, shows custom fields on frontend.
 * Enqueues necessary scripts on admin side.
 */
class Custom_Nav_Menu_Fields {

	use Singleton;

	/**
	 * Holds features and it's required fields.
	 *
	 * @var array
	 */
	private $feature_keys = array(
		'shortcode' => array(
			'shortcode',
			'shortcode-caption',
		),
		'image'     => array(
			'media-id',
			'media-type',
			'media-link',
			'media-caption',
		),
		'html'      => array(
			'custom-html',
		),
	);

	/**
	 * Holds meta key.
	 *
	 * @var string
	 */
	private $meta_key = 'rt-wp-menu-custom-fields';

	/**
	 * Construct method.
	 */
	protected function __construct() {
		if ( 'locations' === sanitize_text_field( filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING ) ) ) {
			return;
		}

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
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'wp_nav_menu_item_custom_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'wp_update_nav_menu_item' ), 10, 2 );

		/**
		 * Filter
		 */
		add_filter( 'wp_nav_menu_objects', array( $this, 'wp_nav_menu_objects' ), 10, 2 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'walker_nav_menu_start_el' ), 10, 4 );

	}

	/**
	 * Get menu item meta data.
	 *
	 * @param int     $menu_item_id Menu item ID.
	 * @param boolean $from_cache Whether to fetch from cache.
	 *
	 * @return array Meta data.
	 */
	private function get_nav_menu_meta_data( $menu_item_id, $from_cache = true ) {
		$data = array();
		if ( $from_cache ) {
			$data = $this->get_nav_menu_cached_meta_data( $menu_item_id );

			if ( false !== $data ) {
				return $data;
			}
		}

		$data = get_post_meta( $menu_item_id, $this->meta_key, true );
		if ( ! empty( $data['image']['media-id'] ) ) {
			$media_url = wp_get_attachment_url( $data['image']['media-id'] );
			if ( ! empty( $media_url ) ) {
				$data['image']['media-url'] = $media_url;
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
	 *
	 * @return void
	 */
	public function wp_nav_menu_item_custom_fields( $id, $item, $depth, $args ) {
		$data = $this->get_nav_menu_meta_data( $id, false );

		$features         = array(
			'image'     => __( 'Image', 'wp-menu-custom-fields' ),
			'shortcode' => __( 'Shortcode', 'wp-menu-custom-fields' ),
			'html'      => __( 'Custom HTML', 'wp-menu-custom-fields' ),
		);
		$selected_feature = 'image';

		if ( ! empty( $data['selected-feature'] ) && ! empty( $features[ $data['selected-feature'] ] ) ) {
			$selected_feature = $data['selected-feature'];
		}

		wp_nonce_field( $this->meta_key . '-' . $id, $this->meta_key . '-' . $id );

		?>
		<p class="description description-wide">
			<label for="menu-item-custom-text-<?php echo esc_attr( $id ); ?>">
				<?php esc_html_e( 'Custom Text', 'wp-menu-custom-fields' ); ?><br>
				<textarea id="menu-item-custom-text-<?php echo esc_attr( $id ); ?>" class="widefat menu-item-custom-text-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $this->meta_key ); ?>-custom-text[<?php echo esc_attr( $id ); ?>]"><?php echo ( ! empty( $data['custom-text'] ) ? esc_html( $data['custom-text'] ) : '' ); ?></textarea>
			</label>
		</p>

		<p class="description description-wide feature-list-label-p">
			<label for="menu-item-select-feature-list-<?php echo esc_attr( $id ); ?>">
			<?php esc_html_e( 'Select Feature', 'wp-menu-custom-fields' ); ?>
			</label>
		</p>
		<div class="menu-item-select-feature-list-wrapper description description-wide" id="menu-item-select-feature-list-wrapper-<?php echo esc_attr( $id ); ?>">
			<ul id="menu-item-select-feature-list-<?php echo esc_attr( $id ); ?>" class="menu-item-select-feature-list">
				<?php
				foreach ( $features as $feature => $label ) {
					?>
					<li class="menu-item-select-feature-div-list-item">
						<label for="menu-item-selected-feature-radio-<?php echo esc_attr( $feature ); ?>-<?php echo esc_attr( $id ); ?>">
							<input <?php checked( $feature, $selected_feature ); ?> type="radio" id="menu-item-selected-feature-radio-<?php echo esc_attr( $feature ); ?>-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $this->meta_key ); ?>-selected-feature[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $feature ); ?>">
							<?php echo esc_html( $label ); ?>
						</label>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php

		foreach ( $features as $feature => $label ) {
			$is_hidden = true;
			if ( $selected_feature === $feature ) {
				$is_hidden = false;
			}

			$this->get_html( $feature, $id, $data, $is_hidden );
		}
	}

	/**
	 * Print HTML of a feature.
	 *
	 * @param string  $feature Selected feature.
	 * @param int     $id Menu item ID.
	 * @param array   $data Menu item meta data.
	 * @param boolean $is_hidden Whether to add menu-item-hidden class or not.
	 *
	 * @return void
	 */
	private function get_html( $feature, $id, $data, $is_hidden = false ) {
		if ( isset( $data[ $feature ] ) ) {
			$data = $data[ $feature ];
		}

		if ( 'image' === $feature ) {
			?>
			<p class="description description-wide menu-item-media-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<label for="menu-item-media-id-<?php echo esc_attr( $id ); ?>">

					<button type="button" class="custom-field-select-image" id="custom-field-select-image-<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Select Image', 'wp-menu-custom-fields' ); ?></button>

					<input type="hidden" value="<?php echo ( isset( $data['media-id'] ) ? esc_attr( $data['media-id'] ) : '' ); ?>" id="menu-item-media-id-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $this->meta_key ); ?>-media-id[<?php echo esc_attr( $id ); ?>]">

					<input type="hidden" value="<?php echo ( isset( $data['media-type'] ) ? esc_attr( $data['media-type'] ) : '' ); ?>" id="menu-item-media-type-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $this->meta_key ); ?>-media-type[<?php echo esc_attr( $id ); ?>]">

				</label>
			</p>
			<p id="menu-item-selected-media-display-paragraph-<?php echo esc_attr( $id ); ?>" class="description description-wide menu-item-media-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<?php
				if ( isset( $data['media-url'] ) && isset( $data['media-type'] ) ) {
					if ( 'image' === $data['media-type'] ) {
						echo '<img src="' . esc_url( $data['media-url'] ) . '" height="100">';
					}
				}
				?>
			</p>
			<p class="description description-wide menu-item-media-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<label for="menu-item-media-link-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Image Link', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-media-link-<?php echo esc_attr( $id ); ?>" class="widefat" name="<?php echo esc_attr( $this->meta_key ); ?>-media-link[<?php echo esc_attr( $id ); ?>]" value="<?php echo ( isset( $data['media-link'] ) ? esc_url( $data['media-link'] ) : '' ); ?>">
				</label>
			</p>
			<p class="description description-wide menu-item-media-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<label for="menu-item-media-caption-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Image Caption', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-media-caption-<?php echo esc_attr( $id ); ?>" class="widefat" name="<?php echo esc_attr( $this->meta_key ); ?>-media-caption[<?php echo esc_attr( $id ); ?>]"><?php echo ( isset( $data['media-caption'] ) ? esc_html( $data['media-caption'] ) : '' ); ?></textarea>
				</label>
			</p>
			<?php
		} elseif ( 'shortcode' === $feature ) {
			?>
			<p class="description description-wide menu-item-shortcode-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<label for="menu-item-shortcode-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Shortcode', 'wp-menu-custom-fields' ); ?><br>
					<input type="text" id="menu-item-shortcode-<?php echo esc_attr( $id ); ?>" class="widefat" name="<?php echo esc_attr( $this->meta_key ); ?>-shortcode[<?php echo esc_attr( $id ); ?>]" value="<?php echo ( isset( $data['shortcode'] ) ? esc_attr( $data['shortcode'] ) : '' ); ?>">
				</label>
			</p>
			<p class="description description-wide menu-item-shortcode-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
				<label for="menu-item-shortcode-caption-<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Shortcode Caption', 'wp-menu-custom-fields' ); ?><br>
					<textarea id="menu-item-shortcode-caption-<?php echo esc_attr( $id ); ?>" class="widefat" name="<?php echo esc_attr( $this->meta_key ); ?>-shortcode-caption[<?php echo esc_attr( $id ); ?>]"><?php echo ( isset( $data['shortcode-caption'] ) ? esc_html( $data['shortcode-caption'] ) : '' ); ?></textarea>
				</label>
			</p>
			<?php
		} elseif ( 'html' === $feature ) {
			$editor_content = ( isset( $data['custom-html'] ) ? $data['custom-html'] : '' );
			$settings       = array( 
				'textarea_name' => esc_attr( $this->meta_key ) . '-custom-html[' . esc_attr( $id ) . ']',
				'media_buttons' => false,
				'editor_height' => '240',
				'tinymce'       => array(
					'toolbar1' => 'bold,italic,bullist,numlist,link',
				),
			);
			?>
			<div class="description description-wide menu-item-html-p-<?php echo esc_attr( $id ); ?> <?php echo ( $is_hidden ? 'menu-item-hidden' : '' ); ?>">
			<?php
			wp_editor( $editor_content, 'menu-item-custom-html-' . esc_attr( $id ), $settings );
			echo '</div>';
		}
	}

	/**
	 * Function called when menu item edit form is submitted.
	 *
	 * @param int $menu_id Menu ID.
	 * @param int $item_id Item ID.
	 *
	 * @return void
	 */
	public function wp_update_nav_menu_item( $menu_id, $item_id ) {
		$nonce = filter_input( INPUT_POST, $this->meta_key . '-' . $item_id, FILTER_SANITIZE_STRING );
		if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, $this->meta_key . '-' . $item_id ) ) {
			return;
		}

		$keys = array(
			'custom-text',
			'selected-feature',
		);

		$data = array();
		foreach ( $keys as $key ) {
			if ( isset( $_POST[ $this->meta_key . '-' . $key ][ $item_id ] ) ) {
				$data[ $key ] = sanitize_text_field( wp_unslash( $_POST[ $this->meta_key . '-' . $key ][ $item_id ] ) );
			}
		}

		if ( ! empty( $data['selected-feature'] ) && ! empty( $this->feature_keys[ $data['selected-feature'] ] ) ) {
			$selected_feature = $data['selected-feature'];

			foreach ( $this->feature_keys[ $selected_feature ] as $feature_field ) {
				$key = $this->meta_key . '-' . $feature_field;

				if ( isset( $_POST[ $key ][ $item_id ] ) ) {
					if ( ! isset( $data[ $selected_feature ] ) ) {
						$data[ $selected_feature ] = array();
					}

					if ( 'custom-html' === $feature_field ) {
						$data[ $selected_feature ][ $feature_field ] = wp_kses_post( wp_unslash( $_POST[ $key ][ $item_id ] ) );
					} else {
						$data[ $selected_feature ][ $feature_field ] = sanitize_text_field( wp_unslash( $_POST[ $key ][ $item_id ] ) );
					}
				}
			}
		}

		if ( ! empty( $data['image']['media-id'] ) ) {
			$media_url = wp_get_attachment_url( $data['image']['media-id'] );
			if ( ! empty( $media_url ) ) {
				$data['image']['media-url'] = $media_url;
			}
		}

		update_post_meta( $item_id, $this->meta_key, $data );
		$this->cache_nav_menu_meta_data( $item_id, $data );
	}

	/**
	 * Function to filter nav menu objects.
	 *
	 * @param array $sorted_items Menu items after being sorted.
	 * @param array $args Menu arguments.
	 *
	 * @return array Sorted menu items.
	 */
	public function wp_nav_menu_objects( $sorted_items, $args ) {
		global $nav_menu_custom_fields;
		if ( empty( $nav_menu_custom_fields ) || ! is_array( $nav_menu_custom_fields ) ) {
			$nav_menu_custom_fields = array();
		}

		foreach ( $sorted_items as $item ) {
			$data = $this->get_nav_menu_meta_data( $item->ID );

			if ( ! empty( $data ) ) {
				$nav_menu_custom_fields[ $item->ID ] = $data;
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
	 *
	 * @return string HTML of nav menu item.
	 */
	public function walker_nav_menu_start_el( $html, $item, $depth, $args ) {
		global $nav_menu_custom_fields;
		if ( empty( $nav_menu_custom_fields ) || ! is_array( $nav_menu_custom_fields ) ) {
			return $html;
		}

		$div_set = false;

		if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['selected-feature'] ) ) {
			$selected_feature = $nav_menu_custom_fields[ $item->ID ]['selected-feature'];
			$data             = $nav_menu_custom_fields[ $item->ID ][ $selected_feature ];

			if ( 'image' === $selected_feature && ! empty( $data['media-url'] ) ) {
				if ( ! $div_set ) {
					$html   .= '<div class="' . esc_attr( $this->meta_key ) . '-wrapper">';
					$div_set = true;
				}

				$html .= '<div class="' . esc_attr( $this->meta_key ) . '-image-wrapper">';

				if ( ! empty( $data['media-link'] ) ) {
					$html .= '<a href="' . esc_url( $data['media-link'] ) . '">';
				}
				$html .= '<img class="' . esc_attr( $this->meta_key ) . '-image" src="' . esc_url( $data['media-url'] ) . '">';
				if ( ! empty( $data['media-link'] ) ) {
					$html .= '</a>';
				}

				if ( ! empty( $data['media-caption'] ) ) {
					$html .= '<span class="' . esc_attr( $this->meta_key ) . '-image-caption">' . esc_html( $data['media-caption'] ) . '</span>';
				}

				$html .= '</div>';
			} elseif ( 'shortcode' === $selected_feature && isset( $data['shortcode'] ) ) {
				if ( ! $div_set ) {
					$html   .= '<div class="' . esc_attr( $this->meta_key ) . '-wrapper">';
					$div_set = true;
				}

				$html .= '<div class="' . esc_attr( $this->meta_key ) . '-shortcode-wrapper">';
				$html .= '<div class="' . esc_attr( $this->meta_key ) . '-shortcode">' . do_shortcode( $data['shortcode'] ) . '</div>';

				if ( isset( $data['shortcode-caption'] ) ) {
					$html .= '<span class="' . esc_attr( $this->meta_key ) . '-shortcode-caption">' . esc_html( $data['shortcode-caption'] ) . '</span>';
				}

				$html .= '</div>';
			} elseif ( 'html' === $selected_feature && isset( $data['custom-html'] ) ) {
				if ( ! $div_set ) {
					$html   .= '<div class="' . esc_attr( $this->meta_key ) . '-wrapper">';
					$div_set = true;
				}

				$html .= '<div class="' . esc_attr( $this->meta_key ) . '-custom-html">' . wp_kses_post( $data['custom-html'] ) . '</div>';
			}
		}

		if ( ! empty( $nav_menu_custom_fields[ $item->ID ]['custom-text'] ) ) {
			if ( ! $div_set ) {
				$html   .= '<div class="' . esc_attr( $this->meta_key ) . '-wrapper">';
				$div_set = true;
			}

			$html .= '<span class="' . esc_attr( $this->meta_key ) . '-custom-text">' . esc_html( $nav_menu_custom_fields[ $item->ID ]['custom-text'] ) . '</span>';
		}

		if ( $div_set ) {
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Function to get transient data.
	 *
	 * @param int $item_id Menu item ID.
	 *
	 * @return array|boolean Transient data or false.
	 */
	private function get_nav_menu_cached_meta_data( $item_id ) {
		$data = get_transient( $this->meta_key . '-' . $item_id );
		if ( false !== $data ) {
			return $data;
		}

		return false;
	}

	/**
	 * Function to set transient data.
	 *
	 * @param int   $item_id Menu item ID.
	 * @param array $data Data to be stored in transient.
	 *
	 * @return void
	 */
	private function cache_nav_menu_meta_data( $item_id, $data ) {
		set_transient( $this->meta_key . '-' . $item_id, $data, DAY_IN_SECONDS );
	}

}
