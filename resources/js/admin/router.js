import Vue from 'vue';
import Router from 'vue-router';

import screenMixin from './mixins/screen';
import progressMixin from './mixins/progress';

// Base screen components
import HtmlScreen from './screens/html';
import FormScreen from './screens/form';

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
                        return {
                            path: `/${id}/${screen.id}`,
                            component: {
                                mixins: [screenMixin],
                                render (createElement) {
                                    return createElement(this.$screen.component);
                                }
                            },
                            name: `${id}.${screen.id}`,
                            meta: {
                                section,
                                screen,
                                user
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
                template: `<div>Hacky 404 until we built it out</div>`,
                async mounted () {
                    await this.$nextTick();
                    this.$progress().done();
                }
            },
            meta: {
                section: {
                    id: '404',
                    priority: 10,
                    icon: 'fa-home',
                    label: 'Not Found'
                },
                screen: {
                    label: 'Not Found'
                },
                user
            }
        }
    ]
};

export default config => {
    Vue.use(Router);

    // Register base screen components
    Vue.component(HtmlScreen.name, HtmlScreen);
    Vue.component(FormScreen.name, FormScreen);

    return new Router({
        routes: createRoutes(config),
        mode: 'history',
        base: '/admin/'
    });
};
