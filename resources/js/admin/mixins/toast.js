import Vue from 'vue';
import Toasted from 'vue-toasted';

Vue.use(Toasted, {
    keepOnHover: true,
    iconPack: 'fontawesome',
    theme: 'fluentkit',
    position: 'bottom-right',
    duration: 5000
});

export default {
    methods: {
        _mergeToastOptions (options, defaults = {}) {
            options = {
                close: true,
                action: [],
                ...defaults,
                ...options
            };
            if (options.close) {
                options.action.push({
                    text: 'close',
                    onClick: (e, toast) => toast.goAway(0)
                });
            }

            return options;
        },
        $toast (message, options = {}) {
            options = this._mergeToastOptions(options);
            return this.$toasted.show(message, options);
        },
        $info (message, options = {}) {
            options = this._mergeToastOptions(options, { icon: 'info' });
            return this.$toasted.info(message, options);
        },
        $success (message, options = {}) {
            options = this._mergeToastOptions(options, { icon: 'check' });
            return this.$toasted.success(message, options);
        },
        // Errors are special in that they work just like other toasts, but additionally accept an error object,
        // and can construct the error toast directly from it.
        $error (message, options = {}) {
            if (message instanceof Error) {
                const error = message;
                message = error.message;
                if (error.response) {
                    const { data: { message: responseMessage } } = error.response;
                    if (responseMessage) {
                        message = message + ': ' + responseMessage;
                    }
                }
            }
            options = this._mergeToastOptions(options, { icon: 'exclamation', duration: null });
            return this.$toasted.error(message, options);
        }
    }
}
