Messager = new class {
    /**
     * @public
     * @param {string} message
     */
    showFlash ( message ) {
        let flash = $( '#flash' );
        $( '#content' ).prepend( '<div id="flash" class="popup"></div>' );
        flash.html(message);
        flash.addClass( 'visible' );
        flash.slideDown( 'slow' );
        flash.click( function () { $( '#flash' ).toggle( 'highlight' ) } );
    }
};