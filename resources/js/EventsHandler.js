$( 'body' ).on( 'click', '#upload-button', function (e) {
    $.ajax({
        url: '/upload-image',
        type: 'POST',
        data: $( '#uploadImage' ).prop('files')[0],
        async: true,
        success: function (message) {
            Messager.showFlash(message);
        }
    });
} );

$( 'body' ).on( 'change', '#upload-image', function (e) {
    let file = $( e.target ).get(0).files[0];
    return Validator.validate(file);
} );