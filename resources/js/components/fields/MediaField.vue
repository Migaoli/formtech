<template>
    <base-field :id="id" :label="label" :errors="errors">
        <div class="bg-grey-lighter border rounded p-3 mb-4">

            <sortable-list :value="value"
                           @input="(e) => $emit('input', e)">
                <div class="grid">
                    <sortable-item v-for="(media, i) in value" :key="media">
                        <div>
                            <sortable-handle>
                                <media-item :id="media"></media-item>
                            </sortable-handle>
                        </div>
                    </sortable-item>
                </div>
            </sortable-list>

        </div>

        <div>
            <button class="btn btn-secondary btn-blue"
                    type="button"
                    @click="showImageUploadDialog = true"
            >
                Add images
            </button>
            <image-upload :show="showImageUploadDialog"
                          :allow-multiple="true"
                          @close="showImageUploadDialog = false"
                          @uploaded="addImages"
                          class="w-1/2 bg-white border rounded"
            ></image-upload>
        </div>

    </base-field>
</template>

<script>
    import BaseField from "./BaseField";
    import MediaItem from "./MediaItem";
    import Modal from "../Modal";
    import ImageUpload from "../file-upload/ImageUpload";
    import SortableItem from "../sortable/SortableItem";
    import SortableHandle from "../sortable/SortableHandle";
    import SortableList from "../sortable/SortableList";

    export default {
        name: 'media-field',

        components: {SortableList, SortableHandle, SortableItem, ImageUpload, Modal, MediaItem, BaseField},

        props: {
            value: {
                type: Array,
                required: true,
            },
            id: {
                type: String,
            },
            label: {
                type: String,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            placeholder: {
                type: String
            },
            errors: {
                type: Array,
            }
        },

        data() {
            return {
                showImageUploadDialog: false,
            }
        },

        methods: {
            addImages(images) {
                console.log(images);
                this.$emit('input', [...this.value, ...images.map(img => img.id)]);
            }
        },

        computed: {
            hasErrors() {
                return this.errors && this.errors.length > 0;
            }
        }
    }
</script>