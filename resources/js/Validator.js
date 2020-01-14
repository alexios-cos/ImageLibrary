let url = window.URL || window.webkitURL;

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

    constructor() {
        this.maxSize = 5242880;
        this.extensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
        this.maxWidth = 1920;
        this.maxHeight = 1080;
    }

    /**
     * @public
     * @param {Object} file
     */
    validate(file) {
        let isValid = true;

        let imageWidth, imageHeight;
        let image = new Image();
        image.src = url.createObjectURL(file);

        image.onload = function () {
            imageWidth = this.width;
            imageHeight = this.height;
        };

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
};