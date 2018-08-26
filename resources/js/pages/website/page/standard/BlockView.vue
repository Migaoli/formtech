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
                                @reset="reset"
                                @submit="save">

                    <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">

                        <div class="flex justify-end" v-if="isDirty">
                            <button class="btn btn-tertiary btn-default mr-4"
                                    type="button"
                                    :disabled="saving"
                                    v-on="resetActions">
                                Cancel
                            </button>
                            <button class="btn btn-primary btn-blue"
                                    type="submit"
                                    :disabled="saving"
                                    v-on="submitActions">
                                <span v-if="saving">Saving...</span>
                                <span v-else>Save</span>
                            </button>
                        </div>

                        <generic-field v-for="field in fields"
                                       :key="field.key"
                                       :field="field"
                        ></generic-field>

                    </div>
                </form-container>


            </div>
        </loading>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import axios from 'axios';
    import Icon from "../../../../components/Icon";
    import Loading from "../../../../components/Loading";
    import FormContainer from "../../../../components/fields/FormContainer";

    export default {
        name: '',
        components: {
            FormContainer, Loading, Icon
        },
        data() {
            return {
                saving: false,
                loading: false,
                block: null,
                errors: {},
            }
        },

        computed: {
            ...mapState({
                blocks: state => state.blocks.blocks,
            }),

            blockDefinition() {
                return this.blocks[this.block.name];
            }
        },

        methods: {
            fetchBlock() {
                this.loading = true;

                axios.get(`api/pages/${this.$route.params.id}/blocks/${this.$route.params.blockId}`)
                    .then(response => {
                        this.block = response.data;
                    })
                    .catch(({response}) => {

                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            reset() {
                this.errors = {};
            },

            save(formData) {
                this.saving = true;

                axios.put(`api/pages/${this.$route.params.id}/blocks/${this.$route.params.blockId}`, formData)
                    .then(response => {
                        this.$flash.success('Block saved!');
                        this.block = formData;
                        this.errors = {};
                    })
                    .catch(({response}) => {
                        this.$flash.error("Could not save block.");
                        this.errors = response.data.errors;
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