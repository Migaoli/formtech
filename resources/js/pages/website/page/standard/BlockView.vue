<template>
    <div>
        <div class="mb-4 ">
            <router-link class="no-underline py-2 flex items-center text-tertiary hover:text-primary"
                         :to="{name: 'pages.view.content', params: {id: this.$route.params.id}}">
                <icon icon="arrow-thin-left" class="w-4 h-4 mr-2"></icon>
                Back to content
            </router-link>
        </div>
        <loading :loading="loading">
            <div v-if="block">
                <form-container :fields="blockDefinition.fields"
                                :data="block"
                                :errors="errors"
                ></form-container>

                <div class="flex justify-end" v-if="isDirty">
                    <button class="btn btn-tertiary btn-default mr-4"
                            type="button"
                            :disabled="saving"
                            @click="reset">
                        Cancel
                    </button>
                    <button class="btn btn-primary btn-blue"
                            type="submit"
                            :disabled="saving"
                            @click.prevent="save">
                        <span v-if="saving">Saving...</span>
                        <span v-else>Save</span>
                    </button>
                </div>
            </div>
        </loading>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import axios from 'axios';
    import _ from 'lodash';
    import TextField from "../../../../components/fields/TextField";
    import SelectField from "../../../../components/fields/SelectField";
    import TrixField from "../../../../components/fields/TrixField";
    import MarkdownField from "../../../../components/fields/MarkdownField";
    import Icon from "../../../../components/Icon";
    import Loading from "../../../../components/Loading";
    import MediaField from "../../../../components/fields/MediaField";
    import BlockField from "../../../../components/fields/GenericField";
    import FormContainer from "../../../../components/fields/FormContainer";

    export default {
        name: '',
        components: {
            FormContainer,
            BlockField, MediaField, Loading, Icon, MarkdownField, TrixField, SelectField, TextField
        },
        data() {
            return {
                saving: false,
                loading: false,
                block: null,
                original: null,
                errors: {},
                text: 'test',
            }
        },

        computed: {
            ...mapState({
                blocks: state => state.blocks.blocks,
            }),

            isDirty() {
                console.log('check dirty');
                return !_.isEqual(this.block, this.original);
            },

            blockDefinition() {
                return this.blocks[this.block.name];
            }
        },

        methods: {
            fetchBlock() {
                this.loading = true;

                axios.get(`api/pages/${this.$route.params.id}/blocks/${this.$route.params.blockId}`)
                    .then(response => {
                        this.original = response.data;
                        this.block = this.$copyObject(this.original);
                    })
                    .catch(({response}) => {

                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            reset() {
                this.block = this.$copyObject(this.original);
                this.errors = {};
            },

            save() {
                this.saving = true;

                axios.put(`api/pages/${this.$route.params.id}/blocks/${this.$route.params.blockId}`, this.block)
                    .then(response => {
                        this.$flash.success('Block saved!');
                        this.errors = {};
                        this.original = this.$copyObject(this.block);
                    })
                    .catch(({response}) => {
                        this.$flash.error("Could not save block.");
                        this.errors = response.data.errors;
                    })
                    .finally(() => {
                        this.saving = false;
                    });
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

        created() {
            this.fetchBlock();
        }
    }
</script>