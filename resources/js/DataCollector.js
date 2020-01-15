let DataCollector = new class {
    /**
     * @private
     * @type {{
     *     page: string,
     *     perPage: string
     *     filters: Object
     * }}
     */
    data;

    /**
     * DataCollector constructor.
     */
    constructor() {
        this.collectRequestData();
    }

    /**
     * @public
     */
    collectRequestData() {
        this.data = {};
        this.data.page = this.getPage();
        this.data.perPage = this.getPerPage();
        this.data.filters = this.getFilters();
    }

    /**
     * @public
     * @return {Object}
     */
    getRequestData() {
        return this.data;
    }

    /**
     * @public
     * @return {string}
     */
    getPage() {
        return $( '.page.current' ).attr('data-page');
    }

    /**
     * @public
     * @return {string}
     */
    getPerPage() {
        return  $( '#per-page-select option:selected').val();
    }

    /**
     * @public
     * @return {Object}
     */
    getFilters() {
        let filters = {};

        $( '.filter-input.operator' ).each( function ( i, elem ) {
            let name = $(this).attr('data-name');
            let value = $(this).val();
            let operator = $(this).siblings('.filter-operator').children('option:selected').val();
            if (value) {
                filters[name] = {
                    name: name,
                    value: value,
                    operator: operator
                }
            }
        } );

        let minWidth = '';
        let maxWidth = '';
        let minHeight = '';
        let maxHeight = '';

        $( '.filter-input.range' ).each( function ( i, elem ) {
            let value = $(elem).val().split('x');
            let width = value[0];
            let height = value[1];
            if ("minResolution" === $(elem).attr('data-name')) {
                minWidth = width;
                minHeight = height;
            } else if ("maxResolution" === $(elem).attr('data-name')) {
                maxWidth = width;
                maxHeight = height;
            }
        } );

        if (minWidth || maxWidth) {
            filters.widthRange = {
                minWidth: {
                    name: 'width',
                    value: minWidth
                },
                maxWidth: {
                    name: 'width',
                    value: maxWidth
                }
            };
        }

        if (minHeight || maxHeight) {
            filters.heightRange = {
                minHeight: {
                    name: 'height',
                    value: minHeight
                },
                maxHeight: {
                    name: 'height',
                    value: maxHeight
                }
            };
        }

        return filters;
    }
};