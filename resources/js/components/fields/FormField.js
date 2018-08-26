import _ from 'lodash';

export default {
    props: {
        field: {
            type: Object,
            required: true,
        },

        data: {
            type: Object,
            required: true,
        },

        allErrors: {
            type: Object,
            required: true,
        },
    },

    computed: {
        value() {
            return _.get(this.data, this.field.key, null);
        },

        hasErrors() {
            const errors = this.errors;
            return errors && errors.length > 0;
        },

        errors() {
            return this.allErrors[this.field.key];
        },
    },

    methods: {
        onInput(e) {
            this.$emit('input', e.target.value);
        }
    }
}