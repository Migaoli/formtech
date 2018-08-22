<template>
    <modal :show="show" @close="close">
        <div class="flex flex-col justify-center items-center p-8 bg-white border rounded">
            <div class="mb-8">
                <slot></slot>
            </div>
            <div>
                <button class="btn btn-tertiary btn-default"
                        type="button"
                        @click="close"
                        ref="cancelButton"
                        :disabled="lock">
                    {{ cancelText }}
                </button>

                <button class="btn btn-primary"
                        :class="confirmButtonClasses"
                        type="button"
                        @click="confirm"
                        :disabled="lock">
                    {{ confirmText }}
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from "../Modal";

    export default {
        name: 'confirm-dialog',

        components: {Modal},

        props: {
            show: {
                type: Boolean,
                required: true,
            },

            actionType: {
                type: String,
                default: 'info',
                validator: function (value) {
                    return ['info', 'warning', 'danger'].indexOf(value) !== -1
                }
            },

            cancelText: {
                type: String,
                default: 'Cancel'
            },

            confirmText: {
                type: String,
                default: 'Confirm'
            },

            lock: {
                type: Boolean,
                default: false,
            }
        },

        watch: {
            show(newValue, oldValue) {
                if (newValue && !oldValue) {
                    this.$nextTick(() => {
                        this.$refs.cancelButton.focus();
                    });
                }
            }
        },

        computed: {
            confirmButtonClasses() {
                if (this.actionType === 'info') {
                    return 'btn-blue'
                }

                if (this.actionType === 'warning') {
                    return 'btn-orange';
                }

                if (this.actionType === 'danger') {
                    return 'btn-red';
                }
            }
        },

        methods: {
            close() {
                if (this.lock) {
                    return;
                }

                this.$emit('close');
            },

            confirm() {
                this.$emit('confirm');
            }
        }
    }
</script>