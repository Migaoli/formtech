<template>
    <div class="fixed pin-b pin-r mr-4 mb-8">
        <div v-for="message in messagesReversed">
            <transition name="fade">
                <flash-message :show="message._show"
                               :message="message.message"
                               :level="message.level"
                ></flash-message>
            </transition>
        </div>
    </div>
</template>

<script>
    import FlashMessage from "./FlashMessage";

    export default {

        name: 'flash-message-container',

        components: {FlashMessage},

        data() {
            return {
                messages: [],
                idCounter: 1,
            }
        },

        computed: {
            messagesReversed() {
                return this.messages.slice().reverse();
            },
        },

        methods: {
            onFlash(event) {
                console.log(event);
                const id = this.idCounter++;
                const e = _.defaults(event, {
                    _id: id,
                    _show: true,
                    timeout: this.timeout,
                });

                this.messages.push(e);

                console.log(this.messages.length);

                setTimeout(() => {
                    this.messages.find(message => {
                        return message._id === id;
                    })._show = false;
                }, _.max([0, e.ttl]));

                setTimeout(() => {
                    let index = this.messages.map(message => message._id).indexOf(id);
                    this.messages.splice(index, 1);
                }, e.ttl + 500);
            },

            alertClass(level) {
                return 'alert-' + level;
            }
        },

        created() {
            this.$events.$on('flash:message', this.onFlash);
        },

        beforeDestroy() {
            this.$events.$off('flash:message', this.onFlash);
        }
    }
</script>