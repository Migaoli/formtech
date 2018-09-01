<template>
    <div>
        <form-container v-if="page"
                        :fields="page.fields"
                        :data="page"
                        :errors="errors"
                        @reset="reset"
                        @submit="save">

            <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">

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

                <generic-field v-for="field in fields"
                               :key="field.key"
                               :field="field"
                ></generic-field>


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
        </form-container>

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

    export default {
        name: 'page-settings',

        components: {GenericField, SelectField, TextField, SearchInput},

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
                return this.definitions[this.page.type];
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

                axios.put(`api/pages/${this.page.id}`, this.formData)
                    .then(response => {
                        this.page = this.$copyObject(formData);
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