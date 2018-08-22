import Vue from 'vue';

export const events = new Vue();

export default {
    install(Vue, options = {}) {

        Vue.prototype.$events = events;

        console.log(events);
    }
}