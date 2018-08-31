import _ from 'lodash';

export default {
    props: {
        field: {
            type: Object,
            required: true,
        },
    },

    inject: ['formEvents'],

    mounted() {
        this.field.fill = this.fill;
        this.formEvents.$on('value:' + this.field.key, (value) => this.value = value);


        this.formEvents.$on('errors', this._onErrors);
    },

    beforeDestroy() {
        this.formEvents.$off('value:' + this.field.key);
        this.formEvents.$off('errors', this._onErrors);
    },

    data() {
        return {
            internalValue: null,
            errors: [],
        }
    },

    computed: {
        value: {
            get() {
                return this.internalValue;
            },

            set(value) {
                this.internalValue = value;
                this.formEvents.$emit('input', {key: this.field.key, value});
            }
        },

        hasErrors() {
            return this.errors && this.errors.length > 0;
        },
    },

    methods: {
        fill(formData) {
            this.value = _.get(formData, this.field.key, this.field.default);
        },

        _onErrors(errors) {
            this.errors = errors[this.field.key];
        }
    }
}