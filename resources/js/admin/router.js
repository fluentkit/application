import Router from 'vue-router';

const createRoutes = ({ sections }) => {
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
                    name: id,
                    meta: {
                        section
                    }
                },
                // Generate routes for each screen
                ...Object.keys(screens)
                    .map(_id => screens[_id])
                    .map(screen => {
                        return {
                            path: `/${id}/${screen.id}`,
                            component: {
                                template: `<component :is="'fk-admin-screen-'+$route.meta.screen.type" />`
                            },
                            name: `${id}.${screen.id}`,
                            meta: {
                                section,
                                screen
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
            name: 'index'
        },
        ...routes
    ]
};

export default config => {
    return new Router({
        routes: createRoutes(config),
        mode: 'history',
        base: '/admin/'
    });
};
