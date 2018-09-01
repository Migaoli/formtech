<template>
    <base-field :field="field" :errors="errors">
        <input :id="field.key"
               class="form-input"
               :class="{'form-error': hasErrors}"
               type="text"
               :placeholder="field.name"
               v-model="value"/>
    </base-field>
</template>

<script>
    import BaseField from "./BaseField";
    import FormField from './FormField';

    const slugify = require('speakingurl');

    export default {
        name: 'slug-field',

        mixins: [FormField],

        components: {BaseField},

        computed: {
            value: {
                get() {
                    return this.internalValue;
                },

                set(value) {
                    const slug = slugify(value);
                    this.internalValue = slug;
                    this.formEvents.$emit('input', {key: this.field.key, value: slug});
                }
            },
        }

    }
</script>