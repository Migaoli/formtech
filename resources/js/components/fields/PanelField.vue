<template>
    <div class="px-4 py-8 mb-8 border rounded shadow-md bg-white">
        <div class="text-secondary uppercase tracking-wide font-semibold mb-8" v-if="field.name">
            {{ field.name }}
        </div>
        <div class="">
            <generic-field v-for="f in field.children"
                           :field="f"
            ></generic-field>
        </div>
    </div>
</template>

<script>
    import FormField from './FormField';

    export default {
        name: 'panel-field',

        mixins: [FormField],

        methods: {
            fill(formData) {
                this.field.children.forEach(field => field.fill(formData));
            }
        }
    }
</script>