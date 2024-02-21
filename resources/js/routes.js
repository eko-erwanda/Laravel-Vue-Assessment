import Wellcome from './pages/Welcome.vue';
import SalesOrderInformation from './pages/SalesOrderInformation.vue';
import Order from './pages/Order.vue';
import NotFound from './pages/NotFound.vue';

const routes = [
    { path: '/order', component: Order },
    { path: '/', component: SalesOrderInformation },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
];

export default routes;
