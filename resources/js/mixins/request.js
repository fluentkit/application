import axios from 'axios';

export default {
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
