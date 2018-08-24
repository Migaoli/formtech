<template>
    <div class="relative"
         @mouseenter="toolbarActive = true"
         @mouseleave="toolbarActive = false">
        <div class="absolute pin-t pin-x bg-smoke-dark"
             v-show="toolbarActive">
            <button class="appearance-none p-2 float-right"
                    type="button"
                    @click="remove">
                <svg class="w-4 h-4 fill-current text-red"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"/>
                </svg>
            </button>
        </div>
        <img :src="image.url">
    </div>
</template>

<script>
    export default {
        name: "image-upload-preview",

        props: {
            image: Object,
        },

        data() {
            return {
                toolbarActive: false
            }
        },

        methods: {
            remove() {
                this.$emit('remove', this.image.id)
            },
        }
    }
</script>