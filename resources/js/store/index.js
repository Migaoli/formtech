import Vue from 'vue';
import Vuex from 'vuex';
import page from './modules/PageStore';
import blocks from './modules/BlocksStore';

Vue.use(Vuex);

export default new Vuex.Store({
   modules: {
       page,
       blocks,
   },
    strict: process.env.NODE_ENV !== 'production',
});