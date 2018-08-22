<template>
    <div class="relative w-full">
        <label class="form-label"
               :for="id">
            {{ label }}
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
            id: {
                type: String,
            },
            label: {
                type: String,
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