<template>
    <div>
        <text-field v-if="field.type === 'text'"
                    :label="field.name"
                    :errors="errors[field.key]"
                    :value="data"
                    @input="input"
        ></text-field>
        <select-field v-if="field.type === 'select'"
                      :label="field.name"
                      :errors="errors[field.key]"
                      :value="data"
                      @input="input"
                      :options="field.options"
        ></select-field>
        <markdown-field v-if="field.type === 'markdown'"
                        :label="field.name"
                        :errors="errors[field.key]"
                        :value="data"
                        @input="input"
        ></markdown-field>
        <media-field v-if="field.type === 'media'"
                     :label="field.name"
                     :errors="errors[field.key]"
                     :value="data"
                     @input="input"
        ></media-field>
    </div>
</template>

<script>
    import _ from 'lodash';
    import TextField from "./TextField";
    import SelectField from "./SelectField";
    import MarkdownField from "./MarkdownField";
    import MediaField from "./MediaField";

    export default {
        name: 'block-field',

        components: {MediaField, MarkdownField, SelectField, TextField},

        props: {
            field: {
                type: Object,
                required: true,
            },

            block: {
                type: Object,
                required: true,
            },

            errors: {
                type: Object,
                required: true,
            },
        },

        computed: {
            data() {
                return _.get(this.block, this.field.key, null);
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