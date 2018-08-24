<template>
    <modal :show="show" @close="close">
        <div class="w-3/4 bg-white border rounded">
            <div class="text-secondary p-4">
                Upload Images
            </div>
            <div class="p-4 border-b">
                <div class="border rounded bg-grey-lighter mb-4 relative">
                    <span class="absolute mx-auto p-4">Drop images here or click to browse</span>
                    <input class="appearance-none block py-8 px-4 h-full w-full cursor-pointer opacity-0"
                           type="file"
                           placeholder="Drop images here to begin or click to browse"
                           accept="image/*"
                           :multiple="allowMultiple"
                           @change="addImages">
                </div>
                <div class="flex flex-wrap">
                    <div class="w-1/4 p-2" v-for="image in previews">
                        <image-upload-preview :image="image"
                                              @remove="removeImage"/>
                    </div>
                </div>
            </div>


            <div class="flex justify-center py-4">
                <button class="btn btn-tertiary btn-default mr-2"
                        type="button"
                        :disabled="loading"
                        @click="close">
                    Cancel
                </button>
                <button class="btn btn-primary btn-blue"
                        type="button"
                        :disabled="loading"
                        @click="upload">
                    <span v-if="loading">Uploading ...</span>
                    <span v-else>Upload</span>
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
    import axios from 'axios'
    import ImageUploadPreview from "./ImageUploadPreview";
    import Modal from "../Modal";

    export default {
        name: 'image-upload',

        components: {Modal, ImageUploadPreview},

        props: {
            show: {
                type: Boolean,
                default: false,
            },

            allowMultiple: {
                type: Boolean,
                default: false,
            }
        },

        data() {
            return {
                loading: false,
                images: [],
                previews: [],
            }
        },

        methods: {
            addImages(event) {
                if (!this.allowMultiple && this.images.length > 0) {
                    this.images = [];
                    this.previews = [];
                }
                const files = event.target.files;

                for (let i = 0; i < files.length; i++) {
                    const _id = _.uniqueId();

                    this.previews.push({
                        id: _id,
                        url: URL.createObjectURL(files[i]),
                    });

                    this.images.push({
                        id: _id,
                        raw: files[i]
                    })
                }
            },

            removeImage(id) {
                const prewiewIndex = this.previews.findIndex(image => {
                    return image.id === id;
                });
                this.previews.splice(prewiewIndex, 1);

                const imageIndex = this.images.findIndex(image => {
                    return image.id === id;
                });
                this.previews.splice(imageIndex, 1);
            },

            upload() {
                this.loading = true;
                const data = new FormData();

                this.images.forEach(image => {
                    data.append('images[]', image.raw);
                });

                data.append('name', 'test');

                axios.post('api/images', data, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        console.log(response.data);
                        this.clear();
                        this.$emit('uploaded', response.data);
                        this.close();
                    })
                    .catch(({response}) => {
                        console.log(response);
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            clear() {
                this.previews = [];
                this.images = [];
            },

            close() {
                this.clear();
                this.$emit('close');
            }
        }
    }
</script>