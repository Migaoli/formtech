import {events} from './../events'


export default {
    info(message, ttl) {
        this.flash(message, 'info', ttl);
    },

    success(message, ttl) {
        this.flash(message, 'success', ttl);
    },

    warning(message, ttl) {
        this.flash(message, 'warning', ttl);
    },

    error(message, ttl) {
        this.flash(message, 'error', ttl);
    },

    flash(message, level, ttl = 5000) {
        console.log('flash');
        console.log(events);
        events.$emit('flash:message', {message, level, ttl})
    },
}

