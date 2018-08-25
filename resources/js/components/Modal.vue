<template>
    <portal to="modals" v-if="show">
        <div class="fixed pin bg-smoke-lighter z-100 overflow-y-auto"
             v-show="show">
            <div class="flex justify-center my-8">
                <on-click-outside :do="close">
                    <slot class="bg-white rounded relative p-2">
                        <div class="absolute pin-t pin-r">
                            <button class="p-2"
                                    @click="close"
                                    type="button">
                                <icon icon="close" class="w-4 h-4 text-secondary"></icon>
                            </button>
                        </div>
                    </slot>
                </on-click-outside>
            </div>
        </div>
    </portal>
</template>

<script>
    import OnClickOutside from "./OnClickOutside";

    export default {
        name: 'modal',
        components: {OnClickOutside},
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
                    console.log(show);
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
                    e.stopPropagation();
                    this.close();
                }
            }
        },

        mounted: function () {
            if (this.closeOnEscape) {
                document.addEventListener("keydown", this.onEscapeDown);
            }
        },

        beforeDestroy() {
            if (this.closeOnEscape) {
                document.removeEventListener("keydown", this.onEscapeDown);
            }

            if (this.preventBackgroundScrolling) {
                document.body.style.removeProperty("overflow")
            }
        }
    }
</script>