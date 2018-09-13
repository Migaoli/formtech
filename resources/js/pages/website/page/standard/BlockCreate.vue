<template>
    <div>
        <page-view-header></page-view-header>
        <form-container :fields="blockDefinition.fields"
                        :data="block"
                        :errors="errors"
                        @reset="cancel"
                        @submit="create">

            <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">

                <div class="flex justify-between items-center mb-8">
                    <router-link class="no-underline py-2 flex items-center text-tertiary hover:text-primary"
                                 :to="{name: 'pages.view.content', params: {id: $route.params.id}}">
                        <icon icon="arrow-thin-left" class="w-4 h-4 mr-2"></icon>
                        Back to content
                    </router-link>

                    <div class="flex justify-end">
                        <button class="btn btn-tertiary btn-default mr-4"
                                type="button"
                                :disabled="creating"
                                v-on="resetActions">
                            Cancel
                        </button>
                        <button class="btn btn-primary btn-blue"
                                type="submit"
                                :disabled="creating"
                                v-on="submitActions">
                            <span v-if="creating">Creating...</span>
                            <span v-else>Create</span>
                        </button>
                    </div>
                </div>

                <generic-field v-for="field in fields"
                               :key="field.key"
                               :field="field"
                ></generic-field>


                <div class="flex justify-end mb-8">
                    <button class="btn btn-tertiary btn-default mr-4"
                            type="button"
                            :disabled="creating"
                            v-on="resetActions">
                        Cancel
                    </button>
                    <button class="btn btn-primary btn-blue"
                            type="submit"
                            :disabled="creating"
                            v-on="submitActions">
                        <span v-if="creating">Creating...</span>
                        <span v-else>Create</span>
                    </button>
                </div>

            </div>
        </form-container>
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapState} from 'vuex';
    import Modal from "../../../../components/Modal";
    import BlockField from "../../../../components/fields/GenericField";
    import Icon from "../../../../components/Icon";
    import PageViewHeader from "../PageViewHeader";

    export default {

        components: {PageViewHeader, Icon, Modal, BlockField},

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
            blockDefinition: function () {
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

                return {
                    name: this.type,
                    container: this.container,
                    page_id: this.pageId,
                };
            },

            create(formData) {
                this.creating = true;

                axios.post(`api/pages/${this.pageId}/blocks`, formData)
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