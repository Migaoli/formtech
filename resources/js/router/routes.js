const routes = [
    {
        path: '/',
        component: Index,
        redirect: 'home',
        meta: {auth: true},
        children: []
    }, {
        path: '/login',
        name: 'login',
        component: Login
    },

];

export default routes;