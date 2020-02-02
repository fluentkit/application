import axios from 'axios';

export default {
    computed: {
        requestQuery () {
            const params = [];
            for (const param in this.$route.params) {
                if (this.$route.params.hasOwnProperty(param) && this.$route.params[param] !== undefined) {
                    params.push(`${param}=${this.$route.params[param]}`)
                }
            }
            for (const param in this.$route.query) {
                if (this.$route.query.hasOwnProperty(param) && this.$route.query[param] !== undefined) {
                    params.push(`${param}=${this.$route.query[param]}`)
                }
            }

            if (!params.length) {
                return '';
            }

            return `?${params.join('&')}`;
        }
    },
    methods: {
        $request () {
            return axios;
        },
        $isValidationError (error) {
            const { response: { status = 500, data: { message = null, errors = null } } } = error;
            return status && status === 422 && message && errors;
        }
    }
}
