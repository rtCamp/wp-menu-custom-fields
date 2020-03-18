/**
 * Main scripts, loaded on all pages.
 *
 * @package wp-menu-custom-fields
 */

/**
 * Internal dependencies
 */
import '../scss/main.scss';

window.$ = window.$ || jQuery;

/**
 * Single nav menu Item.
 *
 * @type {Object}
 */
class NavMenuItem {
	/**
	 * Initialize.
	 *
	 * @param {Element} menuLi Menu item li with class 'menu-item
	 * @param {int|string} menuId  Menu id.
	 *
	 * @return {void}
	 */
	constructor( menuLi, menuId ) {
		this.menuLi = menuLi;
		this.menuId = menuId;
		this.mediaModal = {};

		if ( ! menuLi.length ) {
			return;
		}

		this.openMediaModal = this.openMediaModal.bind( this );
		this.destroy = this.destroy.bind( this );
		this.handleMediaModalOpen = this.handleMediaModalOpen.bind( this );
		this.handleMediaModalClose = this.handleMediaModalClose.bind( this );
		this.initTinyMce = this.initTinyMce.bind( this );

		this.mediaUploaderButton = this.menuLi.find( '#custom-field-select-image-' + this.menuId );
		this.deleteButton = this.menuLi.find( '#delete-' + this.menuId );

		this.mediaUploaderButton.on( 'click', this.openMediaModal );
		this.deleteButton.on( 'click', this.destroy );

		this.initTinyMce();
	}

	/**
	 * Remove all event listeners, destroy tinyMCE.
	 *
	 * @return {void}
	 */
	destroy() {
		this.mediaUploaderButton.off( 'click', this.openMediaModal );
		this.mediaModal = null;

		if ( 'undefined' !== typeof tinymce ) {
			const selector = '#menu-item-custom-html-' + this.menuId;
			tinymce.remove( selector );
		}
	}

	initTinyMce() {
		if ( 'undefined' !== typeof tinymce ) {
			const selector = '#menu-item-custom-html-' + this.menuId;

			tinymce.init( {
				selector: selector,
				setup: ( editor ) => {
					editor.on( 'change', () => {
						tinymce.triggerSave();
					} );
				},
			} );
		}
	}

	/**
	 * Open media library modal.
	 *
	 * @return {void}
	 */
	openMediaModal() {
		const config = {
			title: wpMenuCustomFields.selectMediaText,
			multiple: false,
			library: {
				type: ['image'],
			},
		};

		this.mediaModal = wp.media( config );
		this.mediaModal.on( 'open', this.handleMediaModalOpen );
		this.mediaModal.on( 'close', this.handleMediaModalClose );
		this.mediaModal.open();
	}

	/**
	 * Handle media modal open.
	 *
	 * @return {void}
	 */
	handleMediaModalOpen() {
		const mediaId = jQuery( '#menu-item-media-id-' + this.menuId ).val();
		if ( ! mediaId ) {
			return;
		}

		const attachment = wp.media.attachment( mediaId );
		if ( attachment ) {
			attachment.fetch();
			this.mediaModal.state().get( 'selection' ).add( attachment ? [ attachment ] : [] );
		}
	}

	/**
	 * Handle media modal close.
	 *
	 * @return {void}
	 */
	handleMediaModalClose() {
		const selection = this.mediaModal.state().get( 'selection' );
		let mediaId = false;
		let mediaUrl = false;
		let mediaType = false;

		if ( ! selection.length ) {
			jQuery( '#menu-item-media-id-' + this.menuId ).val( '' );
			jQuery( '#menu-item-media-type-' + this.menuId ).val( '' );
			jQuery( '#menu-item-selected-media-display-paragraph-' + this.menuId ).html( '' ).css( 'display', 'none' );

			return;
		}

		selection.each( ( attachment ) => {
			mediaId = attachment['id'];
			if ( attachment['attributes'] ) {
				mediaUrl = attachment['attributes']['url'];
				mediaType = attachment['attributes']['type'];
			}
		} );

		if ( ! mediaId || ! mediaUrl ) {
			return;
		}

		if ( 'image' === mediaType ) {
			jQuery( '#menu-item-media-id-' + this.menuId ).val( mediaId );
			jQuery( '#menu-item-media-type-' + this.menuId ).val( mediaType );
			jQuery( '#menu-item-selected-media-display-paragraph-' + this.menuId ).html( '<img height="100" src="' + mediaUrl + '">' ).css( 'display', 'block' );
		}
	}
}

/**
 * Nav Menus.
 *
 * @type {Object}
 */
const NavMenu = {
	/**
	 * Initialized nav menu ids.
	 *
	 * @type {object}
	 */
	initializedNavMenuIds: {},

	/**
	 * Initialize.
	 *
	 * @return {void}
	 */
	init() {
		this.menuContainer = jQuery( '#menu-to-edit' );
		this.menuContainer.on( 'click', '.item-edit', ( e ) => {
			const menuId = this.getMenuId( jQuery( e.target ) );

			if ( 'undefined' === typeof this.initializedNavMenuIds[ menuId ] ) {
				const menuLi = jQuery( `#menu-item-${ menuId }` );
				new NavMenuItem( menuLi, menuId );

				this.initializedNavMenuIds[ menuId ] = true;
			}
		});
	},

	/**
	 * Get menu id.
	 *
	 * @param {Element} element Element.
	 *
	 * @return {string}
	 */
	getMenuId( element ) {
		if ( ! element ||  ! element.prop( 'id' ).length ) {
			return '';
		}

		return element.prop( 'id' ).replace( /[^\d.]/g, '' );
	},
};

NavMenu.init();
