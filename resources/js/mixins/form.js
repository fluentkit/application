import Vue from 'vue';
import request from './request';

export default {
    data () {
        return {
            form: new Vue({
                mixins: [request],
                data () {
                    return {
                        formErrors: {},
                        message: null,
                        processing: false
                    }
                },
                computed: {
                    errors () {
                        return this;
                    }
                },
                methods: {
                    setErrors (errors) {
                        this.formErrors = errors;
                    },
                    clear (field) {
                        if (field) {
                            const errors = { ...this.formErrors };
                            delete errors[field];
                            this.setErrors(errors);
                            return;
                        }

                        if (this.$toasted) this.$toasted.clear();
                        this.formErrors = {};
                    },
                    all () {
                        return this.formErrors;
                    },
                    any () {
                        return !!Object.keys(this.formErrors).length;
                    },
                    has (field) {
                        return this.formErrors[field] && this.formErrors[field].length;
                    },
                    get (field) {
                        return this.formErrors[field] || [];
                    },
                    first (field) {
                        return this.get(field)[0] || null;
                    },
                    async post (url, data, ...args) {
                        return this.submitForm('post', url, data, ...args);
                    },
                    async put (url, data, ...args) {
                        return this.submitForm('put', url, data, ...args);
                    },
                    async patch (url, data, ...args) {
                        return this.submitForm('patch', url, data, ...args);
                    },
                    async delete (url, data, ...args) {
                        return this.submitForm('delete', url, data, ...args);
                    },
                    async submitForm (method, url, data, ...args) {
                        try {
                            this.clear();
                            this.processing = true;
                            this.message = null;
                            const response = await this.$request()[method](url, data, ...args);
                            this.processing = false;
                            return response;
                        } catch (e) {
                            this.processing = false;
                            if (this.$isValidationError(e)) {
                                const { response: { status = 500, data: { message = null, errors = {} } } } = e;
                                this.setErrors(errors);
                                this.message = message;
                            }
                            throw e;
                        }
                    }
                }
            })
        }
    },
    computed: {
        $form () {
            return this.form;
        }
    }
}
