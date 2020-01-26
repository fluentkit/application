import NProgress from 'nprogress';

NProgress.configure({ parent: '#progress-container' });

export const progress = NProgress;

export default {
    methods: {
        $progress () {
            return progress;
        }
    }
}
