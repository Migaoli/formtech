<template>
    <div :id="block.id" class="block-container overflow-hidden"
         @mouseenter="showToolbar = true"
         @mouseleave="showToolbar = false">
        <div class="shadow flex justify-between w-full bg-grey-darkest">
            <div class="flex items-center">
                <button class="py-3 px-3 text-tertiary hover:text-primary-inverse"
                        type="button"
                        @click="edit">
                    <icon icon="edit-pencil" class="w-4 h-4 fill-current"></icon>
                </button>
                <button class="py-3 px-3 mr-2 text-tertiary hover:text-primary-inverse"
                        type="button"
                        @click="showConfirmDelete = true">
                    <icon icon="trash" class="w-4 h-4 fill-current"></icon>
                    <confirm-dialog :show="showConfirmDelete"
                                    :confirm-text="confirmDeleteText"
                                    :lock="deleting"
                                    action-type="danger"
                                    @close="showConfirmDelete = false"
                                    @confirm="remove">
                        Are you sure you want the delete this block?
                    </confirm-dialog>
                </button>

                <span class="text-tertiary-inverse">{{ block.name }}</span>
            </div>
            <div class="flex items-center">
                <sortable-handle>
                    <svg class="w-6 h-6 fill-current text-tertiary hover:text-primary-inverse cursor-move"
                         xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M14 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zM8 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                    </svg>
                </sortable-handle>
            </div>
        </div>
        <div class="p-4 block-preview-container min-h-64">
            <iframe v-once
                    ref="preview"
                    :src="previewUrl"
                    class="w-full block-preview"
                    scrolling="no"
                    @load="resizePreview"
            ></iframe>
        </div>
    </div>
</template>

<script>
    import Icon from "../../../../components/Icon";
    import SortableHandle from "../../../../components/sortable/SortableHandle";
    import ConfirmDialog from "../../../../components/confirm/ConfirmDialog";

    export default {
        name: 'block-container',

        components: {ConfirmDialog, SortableHandle, Icon},

        props: ['block'],

        data() {
            return {
                deleting: false,
                showToolbar: false,
                showConfirmDelete: false,
                previewUrl: `api/pages/${this.block.page_id}/blocks/${this.block.id}/preview`,
                showPreview: true,
            }
        },

        computed: {
            confirmDeleteText() {
                return this.deleting ? 'Deleting...' : 'Delete';
            },
        },

        methods: {
            edit() {
                this.$router.push({
                    name: 'pages.blocks.view',
                    params: {id: this.$route.params.id, blockId: this.block.id}
                });
            },

            remove() {
                this.deleting = true;

                this.$store.dispatch('page/deleteBlock', {id: this.block.id})
                    .then(() => {

                    })
                    .catch(() => {

                    })
                    .finally(() => {
                        this.deleting = false;
                        this.showConfirmDelete = false;
                    })
            },

            resizePreview() {
                const preview = this.$refs.preview;
                preview.height = preview.contentWindow.document.body.scrollHeight + "px"
            },
        },
    }
</script>
