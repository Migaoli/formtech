<template>
   <base-field :id="id" :label="label" :errors="errors">
       <input :id="id"
              class="form-input"
              :class="{'form-error': hasErrors}"
              type="text"
              :disabled="disabled"
              :placeholder="placeholder"
              :value="value"
              @input="onInput"/>
   </base-field>
</template>

<script>
    import BaseField from "./BaseField";

    export default {
        name: 'text-field',
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