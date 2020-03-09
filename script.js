/**
 * Function to handle media upload button click.
 * 
 * @param {object} e Current Object.
 * @return {void}
 */
const navMenuSelectMediaHandler = ( e ) => {
    if ( 'undefined' === typeof jQuery ) {
        return;
    }

    ( function( $ ) {
        var id = $( e ).attr( 'data-id' );
        var image_frame = wp.media( {
            title: 'Select Media',
            multiple : false,
            library : {
                type : [ 'image', 'video' ],
            }
        } );
        
        image_frame.on( 'close', () => {
            var selection = image_frame.state().get( 'selection' );
            var mediaId = false;
            var mediaUrl = false;
            var mediaType = false;

            if ( ! selection.length ) {
                $( '#menu-item-media-id-' + id ).val( '' );
                $( '#menu-item-media-type-' + id ).val( '' );
                $( '#menu-item-selected-media-display-paragraph-' + id ).html( '' ).css( 'display', 'none' );

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

            $( '#menu-item-media-id-' + id ).val( mediaId );
            $( '#menu-item-media-type-' + id ).val( mediaType );
            var displayMedia = $( '#menu-item-selected-media-display-paragraph-' + id );
            if ( 'video' === mediaType ) {
                displayMedia.css( 'display', 'block' );
                displayMedia.html( '<video height="100" src="' + mediaUrl + '"></video>' );
            } else if ( 'image' === mediaType ) {
                displayMedia.css( 'display', 'block' );
                displayMedia.html( '<img height="100" src="' + mediaUrl + '">' );
            }
        } );

        image_frame.on( 'open', () => {
            var selection =  image_frame.state().get( 'selection' );
            var mediaId = $( '#menu-item-media-id-' + id ).val();
            if ( ! mediaId ) {
                return;
            }

            var attachment = wp.media.attachment( mediaId );
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
        } );

        image_frame.open();
    } )( jQuery );
}

/**
 * Code for tinymce editor.
 */
jQuery( document ).ready( () => {
    if ( 'undefined' !== typeof tinymce ) {
        tinymce.init( { 
            selector: 'textarea.menu-item-custom-html',
            setup: ( editor ) => {
                editor.on( 'change', () => {
                    tinymce.triggerSave();
                } )
            }
        } );
    }
} );
