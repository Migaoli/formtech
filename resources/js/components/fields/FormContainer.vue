<script>
    import Vue from "vue";
    import _ from 'lodash';

    export default {
        name: 'form-container',

        props: {
            fields: {
                required: true,
            },

            data: {
                required: true,
            },

            errors: {
                required: true,
            }
        },

        created() {
            this.formEvents.$on('input', this.onInput);
        },

        mounted() {
            this.fields.forEach(field => field.fill(this.formData));
        },

        data() {
            return {
                formData: this.$copyObject(this.data),
            }
        },

        provide() {
            this.formEvents = new Vue();
            return {
                formData: this.formData,
                formErrors: this.errors,
                formEvents: this.formEvents,
            }
        },

        watch: {
            data() {
                this.formData = this.$copyObject(this.data);
                this.fields.forEach(field => field.fill(this.formData));
            },
            errors() {
                this.formEvents.$emit('errors', this.errors);
            }
        },

        computed: {
            isDirty() {
                return !_.isEqual(this.data, this.formData);
            },
        },

        methods: {
            onInput(event) {
                _.set(this.formData, event.key, event.value);
            },

            reset() {
                this.formData = this.$copyObject(this.data);
                this.fields.forEach(field => field.fill(this.formData));
                this.$emit('reset');
            },

            submit() {
                this.$emit('submit', this.formData);
            }
        },

        render() {
            return this.$scopedSlots.default({
                formData: this.formData,
                fields: this.fields,
                errors: this.errors,
                isDirty: this.isDirty,
                submitActions: {
                    click: (e) => {
                        e.preventDefault();
                        this.submit()
                    },
                },
                resetActions: {
                    click: (e) => {
                        e.preventDefault();
                        this.reset();
                    },
                },
            })
        }
    }
</script>