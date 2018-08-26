<template>
    <component :is="component"
               :field="field"
               :all-errors="errors"
               :data="data"
               @input="input"
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

            data: {
                type: Object,
                required: true,
            },

            errors: {
                type: Object,
                required: true,
            },
        },

        computed: {
            component() {
                return this.field.type + '-field';
            }
        },

        methods: {
            input(e) {
                this.$emit('update', {
                    key: this.field.key,
                    value: e,
                });
            },
        }
    }
</script>