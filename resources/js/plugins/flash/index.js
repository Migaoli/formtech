import flash from './flash'

export default {
    install(Vue, options = {}) {

        Vue.prototype.$flash = flash;
    }
}