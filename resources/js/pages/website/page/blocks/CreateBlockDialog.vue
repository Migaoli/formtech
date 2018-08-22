<template>
    <modal :show="show"
           @close="close">
        <div class="card px-4 py-8 w-1/2">
            <template v-if="show">
                <div v-for="(field, i) in blockDefinition.fields" class="mb-8">
                    <text-field v-if="field.type === 'text'"
                                :label="field.name"
                                :errors="errors[`data.${field.key}`]"
                                v-model="block.data[field.key]"
                    ></text-field>
                    <select-field v-if="field.type === 'select'"
                                  :label="field.name"
                                  :errors="errors[`data.${field.key}`]"
                                  v-model="block.data[field.key]"
                                  :options="field.options"
                    ></select-field>
                    <markdown-field v-if="field.type === 'markdown'"
                                    :label="field.name"
                                    :errors="errors[`data.${field.key}`]"
                                    v-model="block.data[field.key]"
                    ></markdown-field>
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
    import TextField from "../../../../components/fields/TextField";
    import SelectField from "../../../../components/fields/SelectField";
    import MarkdownField from "../../../../components/fields/MarkdownField";

    export default {
        name: 'create-block-dialog',

        components: {MarkdownField, SelectField, TextField, Modal},

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
                required: true,
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
                block: {
                    data: {},
                }
            }
        },

        methods: {
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
                        this.close();
                    })
                    .catch(({response}) => {
                        this.errors = response.data.errors;
                    })
                    .finally(() => {
                        this.creating = false;
                    })
            },
        },
    }
</script>