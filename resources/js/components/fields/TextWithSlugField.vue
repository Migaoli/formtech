<template>
    <base-field :field="field" :errors="errors">
        <input :id="field.key"
               class="form-input"
               :class="{'form-error': hasErrors}"
               type="text"
               :placeholder="field.name"
               :value="value"
               @input="onInput"/>
    </base-field>
</template>

<script>
    import BaseField from "./BaseField";
    import FormField from './FormField';

    export default {
        name: 'text-with-slug-field',

        mixins: [FormField],

        components: {BaseField},

        computed: {

        },

        methods: {
            onInput(e) {
                this.value = e.target.value;
                this.formEvents.$emit('value:' + this.field.slugField, e.target.value);
            }
        }

    }
</script>