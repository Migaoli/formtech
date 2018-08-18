<template>
    <portal to="modals" v-if="show">
        <div class="fixed pin bg-smoke-lighter z-100 overflow-y-auto"
             v-show="show"
             @click="close">
            <div class="flex justify-center my-8">
                <slot class="w-1/2 bg-white rounded relative p-2" @click.stop>
                    <div class="absolute pin-t pin-r">
                        <button class="p-2"
                                @click="close"
                                type="button">
                            <icon icon="close"
                                  class="w-4 h-4 text-secondary"></icon>
                        </button>
                    </div>
                </slot>
            </div>
        </div>
    </portal>
</template>

<script>
    export default {
        name: 'modal',
        model: {
            prop: 'show',
            event: 'update'
        },

        props: {
            show: {
                type: Boolean,
                required: true
            },
            transition: {
                type: String,
                default: 'fade'
            },
            closeOnEscape: {
                type: Boolean,
                default: true,
            },
            preventBackgroundScrolling: {
                type: Boolean,
                default: true,
            },
        },

        watch: {
            show: {
                immediate: true,
                handler(show) {
                    if (show) {
                        this.preventBackgroundScrolling &&
                        document.body.style.setProperty("overflow", "hidden")
                    } else {
                        this.preventBackgroundScrolling &&
                        document.body.style.removeProperty("overflow")
                    }
                }
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },

            onEscapeDown(e) {

                if (this.show && e.keyCode === 27) {
                    this.close();
                }
            }
        },

        mounted: function () {
            if (this.closeOnEscape) {
                document.addEventListener("keydown", this.onEscapeDown);
            }
        },

        destroyed() {
            if (this.closeOnEscape) {
                document.removeEventListener("keydown", this.onEscapeDown);
            }
        }
    }
</script>