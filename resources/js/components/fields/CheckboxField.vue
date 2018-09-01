<template>
    <div class="relative w-full mb-8">
        <div class="form-checkbox"
             :class="{'form-error': hasErrors}">
            <input type="checkbox"
                   :id="field.key"
                   v-model="value">
            <label class="form-label"
                   :for="field.key">
                {{ field.name }}
            </label>
        </div>
        <ul v-if="hasErrors"
            class="mt-2 text-red-dark">
            <li v-for="(error, i) in errors">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    import BaseField from "./BaseField";
    import FormField from './FormField';

    export default {
        name: 'checkbox-field',

        mixins: [FormField],

        components: {BaseField},

    }
</script>