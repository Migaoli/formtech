import _ from 'lodash';

export default {
    props: {
        field: {
            type: Object,
            required: true,
        },
    },

    inject: ['formData', 'formErrors'],

    computed: {
        value: {
            get() {
                return _.get(this.formData, this.field.key, null);
            },

            set(value) {
                console.log('update');
                _.set(this.formData, this.field.key, value);
                //this.$set(this.formData, this.field.key, value);
            }
        },

        hasErrors() {
            const errors = this.errors;
            return errors && errors.length > 0;
        },

        errors() {
            return this.formErrors[this.field.key];
        },
    },
}