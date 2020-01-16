let body = $( 'body' );
let _URL = window.URL || window.webkitURL;

body.on( 'click', '#upload-button', function ( e ) {
    let file =  $( '#upload-image' ).prop('files')[0];
    if (!file) {
        Notifier.flashMessage('Please chose image.', 'warning');
        return false;
    }

    if (!window.imageStatus) {
        Notifier.flashMessage('Image is not valid. Please pick another one.', 'warning');
        return false;
    }

    $.ajax({
        url: '/upload-image',
        type: 'POST',
        data: file,
        async: true,
        success: function (message) {
            Notifier.flashMessage(message, 'default');
        }
    });
} );

body.on( 'change', '#upload-image', function ( e ) {
    let file = $( e.target ).get(0).files[0];

    if (!file) {
        return false;
    }

    let imageWidth = undefined;
    let imageHeight = undefined;
    let image = new Image();
    let objectUrl = _URL.createObjectURL(file);

    image.onload = function () {
        imageWidth = this.width;
        imageHeight = this.height;
        _URL.revokeObjectURL(objectUrl);
    };

    window.imageStatus = Validator.validateImage(file, imageWidth, imageHeight);

    if (!window.imageStatus) {
        Notifier.flashMessage('Image is not valid. Please pick another one.', 'warning');
    }
} );

body.on( 'click', '.page', function ( e ) {
    let page = $( this ).attr('data-page');
    DataCollector.collectRequestData();
    let data = DataCollector.getRequestData();

    if ( $( this ).hasClass( 'arrow' ) ) {
        return false;
    }

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: page, currentPerPage: data.perPage, filters: data.filters },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );

body.on( 'click', '#prev-page', function ( e ) {
    DataCollector.collectRequestData();
    let data = DataCollector.getRequestData();
    let page = Number(data.page) - 1;

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: page, currentPerPage: data.perPage, filters: data.filters },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );

body.on( 'click', '#next-page', function ( e ) {
    DataCollector.collectRequestData();
    let data = DataCollector.getRequestData();
    let page = Number(data.page) + 1;

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: page, currentPerPage: data.perPage, filters: data.filters },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );

body.on( 'click', '#per-page-select', function ( e ) {
    DataCollector.collectRequestData();
} );

body.on( 'change', '#per-page-select', function ( e ) {
    let data = DataCollector.getRequestData();
    let newPerPage = $( e.target ).val();

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: data.page, currentPerPage: data.perPage, newPerPage: newPerPage, filters: data.filters },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );

body.on( 'click', '#apply-filter', function ( e ) {
    DataCollector.collectRequestData();
    let data = DataCollector.getRequestData();
    let filters = DataCollector.getFilters();

    if (filters.widthRange || filters.heightRange) {
        let status = Validator.validateResolutions(filters);

        if (!status) {
            return false;
        }
    }

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: data.page, currentPerPage: data.perPage, filters: filters },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );

body.on( 'click', '.preview-image', function ( e ) {
    let imageSrc = $( this ).attr( 'data-image' );
    let srcTag = '<img src="' + imageSrc + '"/><br>';
    let imageId = $( this ).attr( 'data-id' );
    $('#dialog-image').html(srcTag);
    $( '#dialog-image' ).css('display', 'flex');
    $( '#background' ).css('display', 'block');

    $.ajax( {
        url: '/update-image',
        type: 'POST',
        data: { imageId: imageId },
        async: true
    } );
} );

body.on( 'click', '#dialog-image', function ( e ) {
    $( '#dialog-image' ).css('display', 'none');
    $( '#background' ).css('display', 'none');
} );

body.on( 'click', '#dialog-message', function ( e ) {
    $( '#dialog-message' ).css('display', 'none');
} );

body.on( 'click', '#clear-filter', function ( e ) {
    DataCollector.collectRequestData();
    let data = DataCollector.getRequestData();
    $( '.filter-input' ).val('');

    $.ajax( {
        url: '/home',
        type: 'POST',
        data: { page: data.page, currentPerPage: data.perPage },
        async: true,
        success: function (response) {
            $( '#content-container' ).html(response);
        }
    } );
} );