<template>
    <div>
        <div class="mb-4 ">
            <router-link class="no-underline py-2 flex items-center text-tertiary hover:text-primary"
                         :to="{name: 'pages.view.content', params: {id: this.$route.params.id}}">
                <icon icon="arrow-thin-left" class="w-4 h-4 mr-2"></icon>
                Back to content
            </router-link>
        </div>

        <div class="card px-4 py-8">
            <div v-for="(field, i) in blockDefinition.fields" class="mb-8">
                <block-field :field="field"
                             :block="block"
                             @update="update"
                             :errors="errors"
                ></block-field>
            </div>

            <div class="flex justify-end">
                <button class="btn btn-tertiary btn-default mr-4"
                        type="button"
                        :disabled="creating"
                        @click="cancel">
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
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapState} from 'vuex';
    import Modal from "../../../../components/Modal";
    import BlockField from "./BlockField";
    import Icon from "../../../../components/Icon";

    export default {

        components: {Icon, Modal, BlockField},

        data() {
            return {
                creating: false,
                errors: {},
                block: null,
            }
        },

        computed: {
            ... mapState({
                blocks: state => state.blocks.blocks,
            }),

            pageId() {
                return this.$route.params.id;
            },

            blockDefinition() {
                return this.blocks[this.type];
            },

            container() {
                return this.$route.query.container;
            },

            type() {
                return this.$route.query.type;
            }
        },

        watch: {
            blockDefinition: function() {
                console.log('asd');
                this.block = this.init();
            },
        },

        created() {
            this.block = this.init();
        },

        methods: {
            init() {
                if (!this.blockDefinition) {
                    return {};
                }

                console.log('init');

                const block = {
                    name: this.type,
                    container: this.container,
                    page_id: this.pageId,
                };

                this.blockDefinition.fields
                    .forEach(field => {
                        _.set(block, field.key, field.default);
                    });

                return block;
            },

            create() {
                this.creating = true;
                console.log(this.block);
                axios.post(`api/pages/${this.pageId}/blocks`, this.block)
                    .then(response => {
                        this.creating = false;
                        this.$store.dispatch('page/fetch', {id: this.pageId});
                        this.$flash.success('Created block!');
                        this.$router.push({
                            name: 'pages.blocks.view',
                            params: {
                                id: this.pageId,
                                blockId: response.data.id,
                            },
                        });
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
            },

            cancel() {

            },
        },
    }
</script>