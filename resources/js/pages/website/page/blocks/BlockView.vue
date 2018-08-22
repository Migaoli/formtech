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
            <div class="card px-4 py-8" v-if="block">
                <div v-for="(field, i) in blocks.text_block.fields" class="mb-8">
                    <text-field v-if="field.type === 'text'"
                                :label="field.name"
                                v-model="block.data[field.key]"
                    ></text-field>
                    <select-field v-if="field.type === 'select'"
                                  :label="field.name"
                                  v-model="block.data[field.key]"
                                  :options="field.options"
                    ></select-field>
                    <markdown-field v-if="field.type === 'markdown'"
                                    :label="field.name"
                                    v-model="block.data[field.key]"
                    ></markdown-field>
                </div>

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

    export default {
        name: '',
        components: {Loading, Icon, MarkdownField, TrixField, SelectField, TextField},
        data() {
            return {
                saving: false,
                loading: false,
                block: null,
                original: null,
                text: 'test',
            }
        },

        computed: {
            ...mapState({
                blocks: state => state.blocks.blocks,
            }),

            isDirty() {
                return !_.isEqual(this.block, this.original);
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
            },

            save() {
                this.saving = true;

                axios.put(`api/pages/${this.$route.params.id}/blocks/${this.$route.params.blockId}`, this.block)
                    .then(response => {
                        this.original = this.$copyObject(this.block);
                    })
                    .catch(({response}) => {

                    })
                    .finally(() => {
                        this.saving = false;
                    });
            },
        },

        created() {
            this.fetchBlock();
        }
    }
</script>