<template>
    <div class="relative w-full">
        <label class="form-label"
               :for="field.key">
            {{ field.name }}
        </label>
        <slot></slot>
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
        name: 'base-field',

        props: {
            field: {
                type: Object,
                required: true,
            },

            errors: {
                type: Array,
            }
        },

        computed: {
            hasErrors() {
                return this.errors && this.errors.length > 0;
            }
        }
    }
</script>