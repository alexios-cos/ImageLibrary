let Notifier = new class {
    /**
     * @private
     * @type {Object}
     */
    types;

    /**
     * Notifier constructor.
     */
    constructor() {
        this.types = {
            default: '#4682b4',
            warning: '#b22222',
        };
    }

    /**
     * @public
     * @param {string} text
     * @param {string} type
     */
    flashMessage(text, type) {
        let message = $('#dialog-message');
        message.html( '<span>' + text + '</span>' );
        message.css('background-color', this.types[type]);
        message.css('border-color', this.types[type]);
        message.css('display', 'flex');
    }
};