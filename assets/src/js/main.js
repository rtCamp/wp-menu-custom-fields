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

	let li = wrappers.closest( 'li.menu-item' );
	li.css( { display: 'grid', gridTemplateColumns: '23% 75%', columnGap: '2%', paddingBottom: '0.5em' } );
	let a = li.find( '> a' ).css( { width: 'auto', wordBreak: 'break-all', paddingRight: '0.5em' } );
	wrappers.css( { paddingTop: a.css( 'padding-top' ), paddingRight: a.css( 'padding-left' ) } );
} );
