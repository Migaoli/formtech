<template>
    <base-field :field="field" :errors="errors">
        <div class="bg-grey-lighter border rounded p-3 mb-4">

            <sortable-list :value="value"
                           @input="(e) => value = e">
                <div class="grid">
                    <sortable-item v-for="(mediaReference, i) in value" :key="mediaReference.id">
                        <div>
                            <media-item :media-reference="mediaReference"
                                        @remove="remove(i)"
                            ></media-item>
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
    import _ from 'lodash'
    import BaseField from "./BaseField";
    import FormField from './FormField';
    import MediaItem from "./MediaItem";
    import Modal from "../Modal";
    import ImageUpload from "../file-upload/ImageUpload";
    import SortableItem from "../sortable/SortableItem";
    import SortableHandle from "../sortable/SortableHandle";
    import SortableList from "../sortable/SortableList";

    export default {
        name: 'media-field',

        mixins: [FormField],

        components: {SortableList, SortableHandle, SortableItem, ImageUpload, Modal, MediaItem, BaseField},

        data() {
            return {
                showImageUploadDialog: false,
            }
        },

        methods: {
            addImages(images) {
                console.log(images);
                this.value = [
                    ...this.value,
                    ...images.map(media => {
                        return {
                            id: _.uniqueId(),
                            media
                        }
                    })];
            },

            remove(index) {
                console.log(index);
                this.value = [
                    ...this.value.slice(0, index),
                    ...this.value.slice(index + 1, this.value.length)
                ];
            }
        },
    }
</script>