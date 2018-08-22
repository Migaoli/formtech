<template>
    <base-field :id="id" :label="label" :errors="errors">
        <input ref="input"
               :id="id"
               class="hidden"
               :class="{'form-error': hasErrors}"
               :disabled="disabled"
               :placeholder="placeholder"
        />
        <trix-editor ref="trix" :input="id" :placeholder="placeholder"></trix-editor>
    </base-field>
</template>

<script>

    import BaseField from "./BaseField";

    export default {
        name: 'trix-field',
        components: {BaseField},
        props: {
            value: {
                required: true,
            },
            id: {
                type: String,
            },
            label: {
                type: String,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            placeholder: {
                type: String
            },
            errors: {
                type: Array,
            }
        },

        mounted() {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });
            /*this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });*/
        },

        methods: {
            onInput(event) {
                this.$emit('input', event.target.value);
            }
        },

        computed: {
            hasErrors() {
                return this.errors && this.errors.length > 0;
            }
        }
    }
</script>