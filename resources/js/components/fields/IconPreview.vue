<template>
    <div class="flex items-center">
        <svg class="text-secondary w-6 h-6 mr-4"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <use :xlink:href="link"></use>
        </svg>
        {{ name }}
    </div>
</template>

<script>
    export default {
        name: 'icon-preview',

        props: {
            icon: {
                type: String,
                required: true,
            },
        },

        computed: {
            link() {
                return `/icons.svg#${this.icon}`;
            },

            name() {
                return this.icon.replace('zondicon-', '');
            }
        }
    }
</script>