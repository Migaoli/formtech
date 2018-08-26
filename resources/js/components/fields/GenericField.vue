<template>
    <component :is="component"
               :field="field"
    ></component>
</template>

<script>
    import TextField from "./TextField";
    import SelectField from "./SelectField";
    import MarkdownField from "./MarkdownField";
    import MediaField from "./MediaField";

    export default {
        name: 'generic-field',

        components: {MediaField, MarkdownField, SelectField, TextField},

        props: {
            field: {
                type: Object,
                required: true,
            },
        },

        computed: {
            component() {
                return this.field.type + '-field';
            }
        },
    }
</script>