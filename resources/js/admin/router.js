import Vue from 'vue';
import Router from 'vue-router';

import progressMixin from './mixins/progress';

// Base screen components
import HtmlScreen from './screens/html';
import FormScreen from './screens/form';
import ModelIndexScreen from './screens/model-index';

const createRoutes = ({ sections, user }) => {
    const routes = Object.keys(sections)
        .map(id => sections[id])
        .map(section => {
            const { id, screens } = section;

            return [
                // Always have a root path for each section which redirects to the first screen within
                {
                    path: `/${id}`,
                    redirect: {
                        name: `${id}.${screens[Object.keys(screens)[0]].id}`
                    },
                    name: id
                },
                // Generate routes for each screen
                ...Object.keys(screens)
                    .map(_id => screens[_id])
                    .map(screen => {
                        if (screen.type === 'redirect') {
                            return {
                                path: `/${id}/${screen.id}`,
                                redirect: {
                                    name: screen.route
                                },
                                name: `${id}.${screen.id}`
                            }
                        }

                        const path = [`/${id}/${screen.id}`, ...screen.routeParams].join('/');

                        return {
                            path,
                            component: {
                                functional: true,
                                render (createElement, { props }) {
                                    return createElement(
                                        screen.component,
                                        {
                                            props,
                                            key: `${props.section}.${props.screen}.${JSON.stringify(props.params)}`
                                        }
                                    );
                                }
                            },
                            name: `${id}.${screen.id}`,
                            meta: {
                                section: section.id,
                                screen: screen.id
                            },
                            props: ({ params, meta: { section, screen } }) => {
                                return {
                                    ...params,
                                    params,
                                    section,
                                    screen
                                }
                            }
                        }
                    })
            ];
        })
        // Flatten the array of arrays
        .flat();

    return [
        // Prepend the index route which redirects to the first section
        {
            path: '/',
            redirect: {
                name: `${routes[0].name}`
            },
            name: 'home'
        },
        ...routes,
        // Add a logout route to make it easy to trigger from within the admin class links
        {
            path: '/logout',
            name: 'logout',
            component: {
                template: `<div></div>`
            },
            beforeEnter () {
                window.location.href = '/logout';
            }
        },
        {
            path: '*',
            name: '404',
            component: {
                mixins: [progressMixin],
                template: `<fk-admin-background>
                    <h1>Oops, looks like that page doesn't exist.</h1>
                    <p>Please choose a link from the menu.</p>
                </fk-admin-background>`,
                async mounted () {
                    await this.$nextTick();
                    this.$progress().done();
                }
            },
            meta: {
                section: '404',
                screen: 'index'
            }
        }
    ]
};

export default config => {
    Vue.use(Router);

    // Register base screen components
    Vue.component(HtmlScreen.name, HtmlScreen);
    Vue.component(FormScreen.name, FormScreen);
    Vue.component(ModelIndexScreen.name, ModelIndexScreen);

    return new Router({
        routes: createRoutes(config),
        mode: 'history',
        base: '/admin/'
    });
};
