<template>
    <svg class="fill-current"
         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <use :xlink:href="iconClass"></use>
    </svg>
</template>

<script>
    export default {
        name: "icon",

        props: {
            'icon': {
                required: true,
                type: String
            }
        },

        computed: {
            iconClass() {
                return '#zondicon-' + this.icon;
            }
        }
    }
</script>