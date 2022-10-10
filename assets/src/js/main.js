/**
 * Main scripts, loaded on all pages.
 *
 * @package WP-Menu-Custom-Fields
 */

import '../sass/main.scss';

window.$ = window.$ || jQuery;

$( document ).ready( () => {
	let wrappers = $( '.sub-menu .rt-wp-menu-custom-fields-wrapper' );
	wrappers.closest( '.sub-menu' ).css( 'min-width', '400px' );
	wrappers.find( '.rt-wp-menu-custom-fields-shortcode' ).closest( '.sub-menu' ).css( 'min-width', '600px' );

	let submenuCustomField = wrappers.find( '.rt-wp-menu-custom-fields-shortcode, .rt-wp-menu-custom-fields-image-wrapper' ).closest( '.sub-menu' );

	// Change submenu width for non-mobile devices.
	if ( 768 <= $( window ).width() ) {
		submenuCustomField.each( ( index, value ) => {
			value.style.minWidth = ( 600 - ( index * 14.5 ) ) + 'px';
		} );
	}

	// Set different width for mobile-sized devices.
	if ( 768 > $( window ).width() ) {
		wrappers.closest( '.sub-menu' ).css( 'min-width', '300px' );
		wrappers.find( '.rt-wp-menu-custom-fields-shortcode' ).closest( '.sub-menu' ).css( 'min-width', '400px' );
		$( 'ul:not(.sub-menu) > li.menu-item-has-children > ul.sub-menu' ).has( '.rt-wp-menu-custom-fields-shortcode' ).css( 'min-width', '350px' );
	}

	let li = wrappers.closest( 'li.menu-item' );
	li.addClass( 'rt-custom-menu-field-item' );
	let a = li.find( '> a' ).addClass( 'rt-custom-menu-field-item-link' );
	wrappers.css( { paddingTop: a.css( 'padding-top' ), paddingRight: a.css( 'padding-left' ) } );

	$( window ).load( () => {
		if ( 768 <= $( window ).width() ) {
			let mejsContainer = $( '.sub-menu .rt-wp-menu-custom-fields-shortcode .wp-video-shortcode.mejs-video' );

			mejsContainer.css( { minWidth: '100%', minHeight: '12em' } );
			mejsContainer.find( 'video.wp-video-shortcode' ).css( { minWidth: '100%', minHeight: '100%' } );
		}
	} );
} );
