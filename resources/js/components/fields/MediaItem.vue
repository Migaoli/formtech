<template>
    <div class="border shadow-md bg-white flex justify-center items-center relative"
         style="width: 200px; height: 200px;"
         @mouseenter="showToolbar = true"
         @mouseleave="showToolbar = false"
    >
        <div class="absolute pin-t pin-x shadow flex justify-between items-center w-full bg-smoke"
             v-show="showToolbar">

            <button class="appearance-none py-3 px-3 mr-2 text-tertiary-inverse hover:text-primary-inverse"
                    type="button"
                    @click="remove">
                <icon icon="trash" class="w-4 h-4 fill-current"></icon>
            </button>

            <sortable-handle>
                <svg class="w-6 h-6 fill-current text-tertiary-inverse hover:text-primary-inverse cursor-move"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M14 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zM8 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                </svg>
            </sortable-handle>
        </div>
        <img :src="url" @load="loaded" v-show="!loading"/>
        <icon v-if="loading" icon="photo" class="w-32 h-32 text-tertiary opacity-50"></icon>
    </div>
</template>

<script>
    import Icon from "../Icon";
    import SortableHandle from "../sortable/SortableHandle";

    export default {
        name: 'media-item',
        components: {SortableHandle, Icon},
        props: {
            mediaReference: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                loading: true,
                showToolbar: false,
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
            },

            remove() {
                this.$emit('remove');
            }
        }
    }
</script>