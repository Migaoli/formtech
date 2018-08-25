<template>
    <modal :show="show"
           @close="close">
        <div class="card px-4 py-8 w-1/2">
            <template v-if="show">
                <div v-for="(field, i) in blockDefinition.fields" class="mb-8">
                    <block-field :field="field"
                                 :block="block"
                                 @update="update"
                                 :errors="errors"
                    ></block-field>
                </div>
            </template>

            <div class="flex justify-end">
                <button class="btn btn-tertiary btn-default mr-4"
                        type="button"
                        :disabled="creating"
                        @click="close">
                    Cancel
                </button>
                <button class="btn btn-primary btn-blue"
                        type="submit"
                        :disabled="creating"
                        @click.prevent="create">
                    <span v-if="creating">Creating...</span>
                    <span v-else>Create</span>
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
    import axios from 'axios';
    import Modal from "../../../../components/Modal";
    import BlockField from "../../../../components/fields/BlockField";

    export default {
        name: 'create-block-dialog',

        components: {Modal, BlockField},

        props: {
            show: {
                type: Boolean,
                required: true,
            },

            container: {
                type: String,
                required: true,
            },

            blockDefinition: {
                type: Object,
            },

            pageId: {
                type: Number,
                required: true,
            }
        },

        data() {
            return {
                creating: false,
                errors: {},
                block: this.init(),
            }
        },

        watch: {
            blockDefinition() {
                this.block = this.init();
            },
        },

        methods: {
            init() {
                if (!this.blockDefinition) {
                    return {};
                }

                const block = {};

                this.blockDefinition.fields
                    .forEach(field => {
                        _.set(block, field.key, field.default);
                    });

                return block;
            },

            close() {
                if (this.creating) {
                    return;
                }

                this.errors = {};
                this.$emit('close');
            },

            create() {
                this.creating = true;

                const payload = {
                    name: this.blockDefinition.name,
                    container: this.container,
                    data: this.block.data,
                };

                axios.post(`api/pages/${this.pageId}/blocks`, payload)
                    .then(response => {
                        this.creating = false;
                        this.$store.dispatch('page/fetch', {id: this.pageId});
                        this.$flash.success('Created block!');
                        this.close();
                    })
                    .catch(({response}) => {
                        this.$flash.error('Could not create block!');
                        this.errors = response.data.errors;
                    })
                    .finally(() => {
                        this.creating = false;
                    })
            },

            update({key, value}) {
                if (_.has(this.block, key)) {
                    console.log('update');
                    _.set(this.block, key, value);
                } else {
                    console.log('create');
                    this.$set(this.block, key, value);
                }
            }
        },
    }
</script>