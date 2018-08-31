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
    import FormField from './FormField';

    export default {
        name: 'icon-field',

        mixins: [FormField],


    }
</script>