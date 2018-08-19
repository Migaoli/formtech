export default {
    install(Vue) {
        Vue.prototype.$copyObject = function (obj) {
            return JSON.parse(JSON.stringify(obj));
        }
    }
}