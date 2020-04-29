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
                    sections: {
                        ...config.sections,
                        404: {
                            id: '404',
                            priority: 10,
                            icon: 'fa-exclamation-triangle',
                            label: 'Not Found',
                            screens: {
                                index: {
                                    id: 'index',
                                    label: 'Not Found',
                                    hideSectionTitle: true
                                }
                            }
                        }
                    }
                }),
                getters: {
                    sections ({ sections }) {
                        return sections || {};
                    },
                    currentSection ({ sections }, getters, { route: { meta: { section } } }) {
                        return sections[section] || null;
                    },
                    screens (state, { currentSection: { screens = {} } }) {
                        return screens;
                    },
                    currentScreen (state, { screens = {} }, { route: { meta: { screen } } }) {
                        return screens[screen] || null;
                    }
                }
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
