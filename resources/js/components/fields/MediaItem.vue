<template>
    <div class="border shadow-md bg-white flex justify-center items-center" style="width: 200px; height: 200px;">
        <img :src="url" @load="loaded" v-show="!loading"/>
        <icon v-if="loading" icon="photo" class="w-32 h-32 text-tertiary opacity-50"></icon>
    </div>
</template>

<script>
    import Icon from "../Icon";

    export default {
        name: 'media-item',
        components: {Icon},
        props: {
            mediaReference: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                loading: true,
            }
        },

        computed: {
            url() {
                return `/api/images?id=${this.mediaReference.media.id}&thumb`;
            }
        },

        methods: {
            loaded() {
                this.loading = false;
            }
        }
    }
</script>