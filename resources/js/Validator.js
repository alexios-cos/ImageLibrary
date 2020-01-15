Validator = new class {
    /**
     * @private
     * @type {number}
     */
    maxSize;

    /**
     * @private
     * @type {Array}
     */
    extensions;

    /**
     * @private
     * @type {number}
     */
    maxWidth;

    /**
     * @private
     * @type {number}
     */
    maxHeight;

    /**
     * Validator constructor.
     */
    constructor() {
        this.maxSize = 5242880;
        this.extensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
        this.maxWidth = 1920;
        this.maxHeight = 1080;
    }

    /**
     * @public
     * @param {Object} file
     * @param {number} imageWidth
     * @param {number} imageHeight
     * @return {boolean}
     */
    validateImage(file, imageWidth, imageHeight) {
        let isValid = true;

        if (imageWidth > this.maxWidth || imageHeight > this.maxHeight) {
            isValid = false;
        }

        if (file.size > this.maxSize) {
            isValid = false;
        }

        let fileExtension = file.name.split('.')[1];

        if (!this.extensions.includes(fileExtension)) {
            isValid = false;
        }

        return isValid;
    }

    /**
     * @public
     * @param {Object} filters
     * @return boolean
     */
    validateResolutions(filters) {
        let minWidth = filters.widthRange.minWidth.value;
        let minHeight = filters.heightRange.minHeight.value;
        let maxWidth = filters.widthRange.maxWidth.value;
        let maxHeight = filters.heightRange.maxHeight.value;

        if ( minWidth && minHeight ) {
            if (!maxWidth || !maxHeight) {
                Notifier.flashMessage('Please set max resolution.', 'warning');
                return false;
            }
        } else {
            Notifier.flashMessage('Please set min resolution properly.', 'warning');
            return false;
        }

        if ( maxWidth && maxHeight ) {
            if (!minWidth || !minHeight) {
                Notifier.flashMessage('Please set min resolution.', 'warning');
                return false;
            }
        } else {
            Notifier.flashMessage('Please set max resolution properly.', 'warning');
            return false;
        }

        return true;
    }
};