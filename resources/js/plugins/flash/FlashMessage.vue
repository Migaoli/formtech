<template>
    <div v-show="show"
         class="flash-message"
         :class="alertClass">
        {{ message }}
    </div>
</template>

<script>
    export default {
        name: 'flash-message',

        props: {
            message: {
                type: String,
                required: true,
            },

            level: {
                type: String,
                required: true,
                validator: function (value) {
                    return ['info', 'success', 'warning', 'error'].indexOf(value) !== -1
                }
            },

            show: {
                type: Boolean,
                required: true
            }
        },

        computed: {
            alertClass() {
                return 'flash-message-' + this.level;
            }
        }
    }
</script>