/**
 * Main scripts, loaded on all pages.
 *
 * @package wp-menu-custom-fields
 */

/**
 * Internal dependencies
 */
import '../sass/admin.scss';

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

		this.destroy = this.destroy.bind( this );
		this.handleRadioImage = this.handleRadioImage.bind( this );
		this.handleRadioShortcode = this.handleRadioShortcode.bind( this );
		this.handleRadioHtml = this.handleRadioHtml.bind( this );
		this.openMediaModal = this.openMediaModal.bind( this );
		this.handleMediaModalOpen = this.handleMediaModalOpen.bind( this );
		this.handleMediaModalClose = this.handleMediaModalClose.bind( this );
		this.setMediaUploader = this.setMediaUploader.bind( this );

		this.radioImage = $( '#menu-item-selected-feature-radio-image-' + this.menuId );
		this.radioShortcode = $( '#menu-item-selected-feature-radio-shortcode-' + this.menuId );
		this.radioHtml = $( '#menu-item-selected-feature-radio-html-' + this.menuId );
		this.deleteButton = this.menuLi.find( '#delete-' + this.menuId );

		this.radioImage.on( 'click', this.handleRadioImage );
		this.radioShortcode.on( 'click', this.handleRadioShortcode );
		this.radioHtml.on( 'click', this.handleRadioHtml );
		this.deleteButton.on( 'click', this.destroy );

		if ( this.radioImage.prop( 'checked' ) ) {
			this.setMediaUploader();
		}

		this.imageP = this.menuLi.find( '.menu-item-media-p-' + this.menuId );
		this.shortcodeP = this.menuLi.find( '.menu-item-shortcode-p-' + this.menuId );
		this.htmlP = this.menuLi.find( '.menu-item-html-p-' + this.menuId );

		this.initTinyMce();
	}

	/**
	 * Set media uploader button and it's event.
	 *
	 * @return {void}
	 */
	setMediaUploader() {
		if ( ! this.mediaUploaderButton ) {
			this.mediaUploaderButton = $( '#custom-field-select-image-' + this.menuId );
			this.mediaUploaderButton.on( 'click', this.openMediaModal );
		}
	}

	/**
	 * Handle image radio button click event.
	 *
	 * @return {void}
	 */
	handleRadioImage() {
		this.setMediaUploader();

		this.imageP.removeClass( 'menu-item-hidden' );
		this.shortcodeP.addClass( 'menu-item-hidden' );
		this.htmlP.addClass( 'menu-item-hidden' );
	}

	/**
	 * Handle shortcode radio button click event.
	 *
	 * @return {void}
	 */
	handleRadioShortcode() {
		this.imageP.addClass( 'menu-item-hidden' );
		this.shortcodeP.removeClass( 'menu-item-hidden' );
		this.htmlP.addClass( 'menu-item-hidden' );
	}

	/**
	 * Handle html radio button click event.
	 *
	 * @return {void}
	 */
	handleRadioHtml() {

		this.imageP.addClass( 'menu-item-hidden' );
		this.shortcodeP.addClass( 'menu-item-hidden' );
		this.htmlP.removeClass( 'menu-item-hidden' );
	}

	/**
	 * Remove all event listeners, destroy tinyMCE.
	 *
	 * @return {void}
	 */
	destroy() {
		if ( this.mediaUploaderButton ) {
			this.mediaUploaderButton.off( 'click', this.openMediaModal );
			this.mediaModal = null;
		}

		if ( 'undefined' !== typeof tinyMCE && tinyMCE ) {
			tinyMCE.remove( '#menu-item-custom-html-' + this.menuId );
		}

		this.radioImage.off( 'click', this.handleRadioImage );
		this.radioShortcode.off( 'click', this.handleRadioShortcode );
		this.radioHtml.off( 'click', this.handleRadioHtml );
	}

	/**
	 * Initiate tinymce editor.
	 *
	 * @return {void}
	 */
	initTinyMce() {
		if ( 'undefined' !== typeof tinyMCE ) {
			const selector = 'menu-item-custom-html-' + this.menuId;
			let currentEditor = tinyMCE.editors[ selector ];
			if ( ! currentEditor ) {
				wp.editor.initialize( selector );
				currentEditor = tinyMCE.editors[ selector ];
			}
			currentEditor.on( 'change', () => {
				tinyMCE.triggerSave();
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
				type: [ 'image' ]
			}
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
		const mediaId = $( '#menu-item-media-id-' + this.menuId ).val();
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
			$( '#menu-item-media-id-' + this.menuId ).val( '' );
			$( '#menu-item-media-type-' + this.menuId ).val( '' );
			$( '#menu-item-selected-media-display-paragraph-' + this.menuId ).html( '' );

			return;
		}

		selection.each( ( attachment ) => {
			mediaId = attachment.id;
			if ( attachment.attributes ) {
				mediaUrl = attachment.attributes.url;
				mediaType = attachment.attributes.type;
			}
		} );

		if ( ! mediaId || ! mediaUrl ) {
			return;
		}

		if ( 'image' === mediaType ) {
			$( '#menu-item-media-id-' + this.menuId ).val( mediaId );
			$( '#menu-item-media-type-' + this.menuId ).val( mediaType );

			const img = $( '<img>', {
				height: '100',
				src: mediaUrl
			} );
			$( '#menu-item-selected-media-display-paragraph-' + this.menuId ).html( img );
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
		this.menuContainer = $( '#menu-to-edit' );
		this.menuContainer.on( 'click', '.item-edit', ( e ) => {
			const menuId = this.getMenuId( $( e.target ) );

			if ( 'undefined' === typeof this.initializedNavMenuIds[ menuId ] ) {
				const menuLi = $( `#menu-item-${ menuId }` );
				new NavMenuItem( menuLi, menuId );

				this.initializedNavMenuIds[ menuId ] = true;
			}
		} );
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
	}
};

/**
 * To avoid breaking icons when wp_editor is removed.
 */
$( document ).ready( () => {
	NavMenu.init();
	const dashicons = $( '#dashicons-css' ).clone();
	$( 'body' ).append( dashicons );
} );
