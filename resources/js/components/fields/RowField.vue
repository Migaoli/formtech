<template>
    <div class="flex -mx-3 flex-1">
        <generic-field v-for="f in field.children"
                       :field="f"
                       class="px-3"
        ></generic-field>
    </div>
</template>

<script>
    import FormField from './FormField';

    export default {
        name: 'row-field',

        mixins: [FormField],

        methods: {
            fill(formData) {
                this.field.children.forEach(field => field.fill(formData));
            }
        }
    }
</script>