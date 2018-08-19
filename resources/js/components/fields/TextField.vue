<template>
    <div class="relative w-full">
        <label class="form-label"
               :for="id">
            {{ label }}
        </label>
        <input :id="id"
               class="form-input"
               :class="{'form-error': hasErrors}"
               type="text"
               :disabled="disabled"
               :placeholder="placeholder"
               :value="value"
               @input="onInput"/>
        <ul v-if="hasErrors"
            class="mt-2 text-red-dark">
            <li v-for="(error, i) in errors">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'text-field',

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