import Vue from 'vue';
import Router from 'vue-router';
import router from './router';
import store from './store';
import App from './App';
import Filters from './filters';
import CopyHelper from './util/CopyHelper';
import PortalVue from 'portal-vue';
import clickOutside from './directives/click-outside';

import Events from './plugins/events';
import Flash from './plugins/flash';

import Fields from './components/fields';

Vue.use(Router);
Vue.use(Filters);
Vue.use(CopyHelper);
Vue.use(PortalVue);

Vue.use(Events);
Vue.use(Flash);
Vue.use(Fields);

Vue.directive(clickOutside.name, clickOutside);

Vue.config.ignoredElements = ['trix-editor'];


const app = new Vue({
    router,
    store,
    render: (h) => h(App)
});

app.$mount('app');

window.app = app;
