import TestPage from '../pages/Test';
import Index from '../pages/Index';
import PageIndex from '../pages/website/page/Index';
import PageOverview from '../pages/website/page/Overview';
import PageView from '../pages/website/page/View';
import PageSettings from '../pages/website/page/PageSettings';
import PageContent from '../pages/website/page/PageContent';
import BlockView from '../pages/website/page/blocks/BlockView';

const routes = [
    {
        path: '/',
        component: Index,
        /*redirect: 'home',*/
        meta: {auth: true},
        children: [
            {
                path: 'pages',
                component: PageIndex,
                children: [
                    {
                        path: '',
                        name: 'pages',
                        component: PageOverview,
                    }, {
                        path: ':id',
                        component: PageView,
                        children: [
                            {
                                path: '',
                                name: 'pages.view',
                                redirect: 'settings',
                            }, {
                                path: 'settings',
                                name: 'pages.view.settings',
                                component: PageSettings,
                            }, {
                                path: 'content',
                                name: 'pages.view.content',
                                component: PageContent,
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