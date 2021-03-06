<template>
    <div>
        <page-view-header></page-view-header>
        <loading :loading="loading">
            <div v-if="block">
                <form-container :fields="blockDefinition.fields"
                                :data="block"
                                :errors="errors"
                                @reset="reset"
                                @submit="save">

                    <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">

                        <div class="flex justify-between items-center">
                            <router-link class="no-underline flex items-center text-tertiary hover:text-primary mb-8"
                                         :to="{name: 'pages.view.content', params: {id: $route.params.id}}">
                                <icon icon="arrow-thin-left" class="w-4 h-4 mr-2"></icon>
                                Back to content
                            </router-link>
                        </div>


                        <generic-field v-for="field in fields"
                                       :key="field.key"
                                       :field="field"
                        ></generic-field>

                        <form-toolbar :is-dirty="isDirty"
                                      :saving="saving"
                                      :submit-actions="submitActions"
                                      :reset-actions="resetActions"
                        ></form-toolbar>

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
    import FormToolbar from "../../../../components/fields/FormToolbar";
    import PageViewHeader from "../PageViewHeader";

    export default {
        name: '',
        components: {
            PageViewHeader,
            FormToolbar,
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