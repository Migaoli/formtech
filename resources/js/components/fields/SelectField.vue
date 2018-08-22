<template>
    <base-field :id="id" :label="label" :errors="errors">
        <select :id="id"
                class="form-select"
                :class="{'form-error': hasErrors}"
                :disabled="disabled"
                :value="value"
                @input="onInput">
            <option v-for="(name, option) in options"
                    :key="option"
                    :value="option">
                {{ name }}
            </option>
        </select>
    </base-field>
</template>

<script>
    import BaseField from "./BaseField";

    export default {
        name: 'select-field',
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
            options: {
                type: Object,
                required: true,
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