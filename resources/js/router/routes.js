import TestPage from '../pages/Test';
import Index from '../pages/Index';
import Dashboard from '../pages/Dashboard';
import PageIndex from '../pages/website/page/Index';
import PageOverview from '../pages/website/page/Overview';
import PageCreate from '../pages/website/page/PageCreate';
import PageView from '../pages/website/page/View';
import PageSettings from '../pages/website/page/PageSettings';
import PageContent from '../pages/website/page/PageContent';
import BlockView from '../pages/website/page/standard/BlockView';
import BlockCreate from '../pages/website/page/standard/BlockCreate';

const routes = [
    {
        path: '/',
        component: Index,
        redirect: 'dashboard',
        meta: {auth: true},
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
            }, {
                path: 'pages',
                component: PageIndex,
                children: [
                    {
                        path: '',
                        name: 'pages',
                        component: PageOverview,
                    }, {
                        path: 'new',
                        name: 'pages.create',
                        component: PageCreate,
                    }, {
                        path: ':id',
                        name: 'pages.view',
                        component: PageView,
                        children: [
                            {
                                path: '',
                                name: 'pages.view',
                                redirect: 'content',
                            }, {
                                path: 'settings',
                                name: 'pages.view.settings',
                                component: PageSettings,
                            }, {
                                path: 'content',
                                name: 'pages.view.content',
                                component: PageContent,
                            }, {
                                path: 'content/new',
                                name: 'pages.blocks.create',
                                component: BlockCreate,
                            }, {
                                path: 'content/:blockId',
                                name: 'pages.blocks.view',
                                component: BlockView,
                            }
                        ]
                    }
                ]
            }
        ]
    }, {
        path: '/test',
        name: 'test',
        component: TestPage,
    } /*{
        path: '/login',
        name: 'login',
        component: Login
    }*/

];

export default routes;