import NProgress from 'nprogress';

NProgress.configure({ parent: '#screen-container' });

export const progress = NProgress;

export default {
    methods: {
        $progress () {
            return progress;
        }
    }
}
