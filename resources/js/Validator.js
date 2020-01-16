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
        if (!filters.hasOwnProperty('widthRange') || !filters.hasOwnProperty('heightRange')) {
            Notifier.flashMessage('Please set resolution properly.', 'warning');
            return false;
        }

        let minWidth = filters.widthRange.hasOwnProperty('minWidth') ? filters.widthRange.minWidth.value : null;
        let minHeight = filters.heightRange.hasOwnProperty('minHeight') ? filters.heightRange.minHeight.value : null;
        let maxWidth = filters.widthRange.hasOwnProperty('maxWidth') ? filters.widthRange.maxWidth.value : null;
        let maxHeight = filters.heightRange.hasOwnProperty('maxHeight') ? filters.heightRange.maxHeight.value : null;

        if (!minWidth || !minHeight) {
            Notifier.flashMessage('Please set min resolution properly.', 'warning');
            return false;
        }

        if (!maxWidth || !maxHeight) {
            Notifier.flashMessage('Please set max resolution properly.', 'warning');
            return false;
        }

        if (!Number(minWidth) || !Number(minHeight) || !Number(maxWidth) || !Number(maxHeight)) {
            Notifier.flashMessage('Resolution must be the set of numbers (e.g. 1280x720)', 'warning');
            return false;
        }

        return true;
    }
};