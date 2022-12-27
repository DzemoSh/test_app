export default{
    mode: 'history',
    routes: [
        {
            path: '/',
            component: () => import('./components/Home.vue'),
        },
        {
            path: '/about',
            component: () => import('./components/Home.vue'),
        }
    ]
}