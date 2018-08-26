<template>
    <div class="card px-4 py-8 mb-8">
        <div class="text-secondary uppercase tracking-wide font-semibold mb-8">
            {{ field.name }}
        </div>
        <div class="">
            <generic-field v-for="f in field.children"
                           :field="f"
                           :data="data"
                           :errors="allErrors"
                           class="mb-8"
                           @update="update"
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
            update(event) {
                console.log(event);
                this.$emit('update', event);
            }
        },

        computed: {
        }
    }
</script>