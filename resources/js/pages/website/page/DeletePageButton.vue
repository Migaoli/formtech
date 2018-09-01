<template>
    <div>
        <div @click="show = true">
            <slot></slot>
        </div>
        <modal :show="show" @close="close">
            <div class="flex flex-col justify-center items-center p-8 bg-white border rounded">
                <div class="">
                    <div class="font-bold mb-2">Delete page</div>
                    <p class="">This action cannot be reverted.</p>
                    <div class="my-4">
                        <div class="form-checkbox mb-4">
                            <input type="checkbox"
                                   id="delete-sub-pages"
                                   :disabled="loading"
                                   v-model="deleteSubPages">
                            <label class="text-secondary ml-2"
                                   for="delete-sub-pages">
                                delete sub pages
                            </label>
                        </div>
                    </div>

                    <p></p>
                </div>
                <div>
                    <button class="btn btn-tertiary btn-default mr-4"
                            type="button"
                            @click="close"
                            :disabled="loading">
                        Cancel
                    </button>

                    <button class="btn btn-primary btn-red"
                            type="button"
                            :disabled="loading"
                            @click="deletePage">
                        <span v-if="loading">
                            Deleting...
                        </span>
                        <span v-else>
                            Delete
                        </span>
                    </button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import Modal from "../../../components/Modal";

    export default {
        name: 'delete-page-button',

        components: {Modal},

        props: {
            page: {
                type: Object,
            }
        },

        data() {
            return {
                loading: false,
                show: true,
                deleteSubPages: false,
            }
        },

        watch: {
            show(newValue, oldValue) {
                if (newValue && !oldValue) {
                    this.$nextTick(() => {
                        this.$refs.cancelButton.focus();
                    });
                }
            }
        },

        computed: {
        },

        methods: {
            close() {
                this.show = false;
            },

            deletePage() {
                this.loading = true;

                axios.delete(`api/pages/${this.page.id}`)
                    .then(response => {

                    })
                    .catch(({response}) => {

                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>