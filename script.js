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
 * Initiate tinymce editor.
 * 
 * @param {string|boolean} selector Editor selector.
 * @return {void}
 */
const initTinyMce = ( selector = false ) => {
    if ( 'undefined' !== typeof tinymce ) {

        if ( ! selector || selector.length === 0 ) {
            selector = 'textarea.menu-item-custom-html';
        }

        tinymce.init( { 
            selector: selector,
            setup: ( editor ) => {
                editor.on( 'change', () => {
                    tinymce.triggerSave();
                } );
            }
        } );
    }
};

/**
 * We keep track of initiated editors, so we don't initiate them again.
 */
var initiatedEditors = {};

if ( 'undefined' !== typeof jQuery ) {

    /**
     * We dynamically initiate editors on .item-edit click event.
     * This is being done because menu items are added in DOM runtime.
     */
    jQuery( 'div#post-body' ).on( 'click', '.item-edit', ( e ) => {

        if ( 'undefined' === typeof e.target ) {
            return;
        }

        var elem = jQuery( e.target );
        if ( 0 === elem.length ) {
            return;
        }

        elem = elem.prop( 'id' );
        if ( 0 === elem.length ) {
            return;
        }

        elem = elem.split( '-' );
        if ( elem.length > 1 ) {
            elem = elem[1];

            if ( 'undefined' !== typeof initiatedEditors[ elem ] ) {
                return;
            }

            initiatedEditors[ elem ] = 1;
            initTinyMce( 'textarea#menu-item-custom-html-' + elem );
        }
    } );
}
