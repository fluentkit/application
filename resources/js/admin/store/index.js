import Vue from 'vue';
import Vuex from 'vuex';

export default config => {
    Vue.use(Vuex);

    return new Vuex.Store({
        strict: process.env.NODE_ENV !== 'production',
        state: () => ({
            assetUrl: config.assetUrl,
        }),
        modules: {
            auth: {
                namespaced: true,
                state: () => ({
                    user: { ...config.user }
                }),
                getters: {
                    avatar ({ user: { avatar = null } }) {
                        return avatar;
                    }
                }
            },
            sections: {
                namespaced: true,
                state: () => ({
                    sections: { ...config.sections }
                })
            },
            userLinks: {
                namespaced: true,
                state: () => ({
                    userLinks: [ ...config.userLinks ]
                }),
                getters: {
                    links ({ userLinks }) {
                        return userLinks.map(({ type = 'link', text, name, params = {}, query = {} }) => {
                            return {
                                type,
                                text,
                                route: { name, params, query }
                            };
                        });
                    }
                }
            }
        }
    });
}
