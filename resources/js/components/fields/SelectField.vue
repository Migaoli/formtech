<template>
    <base-field :field="field" :errors="errors">
        <select :id="field.key"
                class="form-select"
                :class="{'form-error': hasErrors}"
                v-model="value"
        >
            <option v-for="(name, option) in field.options"
                    :key="option"
                    :value="option">
                {{ name }}
            </option>
        </select>
    </base-field>
</template>

<script>
    import BaseField from "./BaseField";
    import FormField from './FormField'

    export default {
        name: 'select-field',

        mixins: [FormField],

        components: {BaseField},

    }
</script>