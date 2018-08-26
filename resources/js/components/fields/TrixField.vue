<template>
    <base-field :field="field" :errors="errors">
        <input ref="input"
               :id="field.key"
               class="hidden"
               :class="{'form-error': hasErrors}"
               :placeholder="field.name"
        />
        <trix-editor ref="trix" :input="field.key" :placeholder="field.name"></trix-editor>
    </base-field>
</template>

<script>

    import BaseField from "./BaseField";
    import FormField from './FormField';

    export default {
        name: 'trix-field',

        mixins: [FormField],

        components: {BaseField},


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
    }
</script>