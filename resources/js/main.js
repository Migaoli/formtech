import Vue from 'vue';
import Router from 'vue-router';
import router from './router';
import store from './store';
import App from './App';
import Filters from './filters';
import CopyHelper from './util/CopyHelper';

Vue.use(Router);
Vue.use(Filters);
Vue.use(CopyHelper);


const app = new Vue({
    router,
    store,
    render: (h) => h(App)
});

app.$mount('app');

window.app = app;
