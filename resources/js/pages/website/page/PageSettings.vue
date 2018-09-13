<template>
    <div>
        <page-view-header></page-view-header>
        <page-view-toolbar></page-view-toolbar>
        <form-container v-if="page"
                        :fields="pageDefinition.fields"
                        :data="page"
                        :errors="errors"
                        @reset="reset"
                        @submit="save">

            <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">
                <generic-field v-for="field in fields"
                               :key="field.key"
                               :field="field"
                ></generic-field>


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

            </div>
        </form-container>

        <hr class="block border-b my-10">

        <div class="px-4 py-8 mb-8 border rounded shadow-md bg-white">
            <div class="flex">
                <div class="mr-4">
                    <span>Delete this page</span>
                    <p>This operation cannot be reverted!</p>
                </div>
                <div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    import {mapState} from 'vuex';
    import SearchInput from "../../../components/input/SearchInput";
    import TextField from "../../../components/fields/TextField";
    import SelectField from "../../../components/fields/SelectField";
    import GenericField from "../../../components/fields/GenericField";
    import PageViewHeader from "./PageViewHeader";
    import PageViewToolbar from "./PageViewToolbar";

    export default {
        name: 'page-settings',

        components: {PageViewToolbar, PageViewHeader, GenericField, SelectField, TextField, SearchInput},

        data() {
            return {
                saving: false,
                page: null,
                errors: {},
                options: {
                    normal: 'Normal',
                    landing_page: 'Landing page',
                }
            }
        },

        computed: {
            ...mapState({
                original: state => state.page.page,
                definitions: state => state.page.types,
            }),

            pageDefinition() {
                return _.find(this.definitions, d => d.type === this.page.type);
            },

            isDirty() {
                return !_.isEqual(this.page, this.original);
            },
        },

        methods: {
            reset() {
                this.page = this.$copyObject(this.original);
                this.errors = {};
            },

            save(formData) {
                this.saving = true;

                console.log(formData);

                axios.put(`api/pages/${this.page.id}`, formData)
                    .then(response => {
                        this.page = formData;
                        this.$store.commit('page/page', this.$copyObject(formData));
                        this.errors = {};
                    })
                    .catch(({response}) => {
                        this.errors = response.data.errors;
                    })
                    .finally(() => {
                        this.saving = false;
                    });
            }
        },

        watch: {
            '$store.state.page.page': 'reset',
        },

        created() {
            this.reset();
        }


    }
</script>