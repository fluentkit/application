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
            return error.response && error.response.status && error.response.status === 422 && error.response.data && error.response.data.message && error.response.data.errors;
        }
    }
}
