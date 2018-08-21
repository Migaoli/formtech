import Vue from 'vue';
import Vuex from 'vuex';
import page from './modules/PageStore';
import blocks from './modules/BlocksStore';
import themes from './modules/ThemeStore';

Vue.use(Vuex);

export default new Vuex.Store({
   modules: {
       page,
       blocks,
       themes,
   },
    strict: process.env.NODE_ENV !== 'production',
});