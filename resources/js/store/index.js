import Vue from 'vue';
import Vuex from 'vuex';
import page from './modules/PageStore';

Vue.use(Vuex);

export default new Vuex.Store({
   modules: {
       page
   },
    strict: process.env.NODE_ENV !== 'production',
});