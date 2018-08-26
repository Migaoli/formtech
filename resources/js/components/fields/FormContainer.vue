<template>
    <div>
        <generic-field v-for="field in fields"
                       :key="field.key"
                       :field="field"
        ></generic-field>

        <button class="btn btn-primary btn-red"
                @click="print">
            print
        </button>
    </div>
</template>

<script>
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

        data() {
            return {
                formData: this.$copyObject(this.data),
            }
        },

        provide() {
            return {
                formData: this.formData,
                formErrors: this.errors,
            }
        },

        methods: {
            print() {
                console.log(this.formData);
            }
        }
    }
</script>