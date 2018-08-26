<template>
   <base-field :field="field" :errors="errors">
       <input :id="field.key"
              class="form-input"
              :class="{'form-error': hasErrors}"
              type="text"
              :placeholder="field.name"
              :value="value"
              @input="onInput"/>
   </base-field>
</template>

<script>
    import BaseField from "./BaseField";
    import FormField from './FormField';

    export default {
        name: 'text-field',

        mixins: [FormField],

        components: {BaseField},

    }
</script>