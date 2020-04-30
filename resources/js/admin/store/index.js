import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import url from '../../utils/url';

export default config => {
    Vue.use(Vuex);

    return new Vuex.Store({
        strict: process.env.NODE_ENV !== 'production',
        state: () => ({
            assetUrl: config.assetUrl,
        }),
        getters: {
            requestQuery ({ route: { params = {}, query = {} } }) {
                const parts = [
                    ...Object.keys(params)
                        .filter(param => params[param])
                        .map(param => `${param}=${params[param]}`),
                    ...Object.keys(query)
                        .filter(q => query[q])
                        .map(q => `${q}=${query[q]}`)
                ];

                if (!parts.length) return '';

                return `?${parts.join('?')}`;
            }
        },
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
                            hidden: true,
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
            screen: {
                namespaced: true,
                state: () => ({}),
                getters: {
                    currentScreen (state, getters, rootState, rootGetters) {
                        return rootGetters['sections/currentScreen'];
                    },
                    currentScreenUrl: (state, getters, rootState, rootGetters) => (append = '', includeQuery = true) => {
                        let path = url`/admin/${rootGetters['sections/currentSection'].id}/${getters.currentScreen.id}`;
                        if (append !== '') {
                            path = path + url`/${append}`;
                        }
                        if (includeQuery) {
                            path = path + rootGetters.requestQuery;
                        }

                        return path;
                    }
                },
                actions: {
                    async loadScreenData ({ getters, dispatch }, key) {
                        if (Array.isArray(key)) {
                            return await Promise.all(key.map(k => dispatch('loadScreenData', k)));
                        }

                        const { data } = await axios.get(getters.currentScreenUrl(key));

                        if (key === 'attributes' && Array.isArray(data[key])) {
                            return {};
                        }

                        return data[key];
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
