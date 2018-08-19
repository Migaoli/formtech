<template>
    <div>
        <label class="form-label"
               :for="id">
            {{ label }}
        </label>
        <select :id="id"
                class="form-select"
                :disabled="disabled"
                :value="value"
                @input="onInput">
            <option v-for="(name, option) in options"
                    :key="option"
                    :value="option">
                {{ name }}
            </option>
        </select>
    </div>
</template>

<script>
    export default {
        name: 'select-field',

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
            }
        },

        methods: {
            onInput(event) {
                this.$emit('input', event.target.value);
            }
        }

    }
</script>