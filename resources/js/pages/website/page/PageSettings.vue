<template>
    <div>
        <div class="card py-8 px-4">
            <div class="grid mb-8">
                <div class="w-1/2">
                    <text-field label="Title"
                                id="page.title"
                                v-model="page.title"
                                :errors="errors.title"
                    ></text-field>
                </div>
                <div class="w-1/2">
                    <text-field label="Slug"
                                id="page.slug"
                                v-model="page.slug"
                                :errors="errors.slug"
                    ></text-field>
                </div>
            </div>
            <div class="grid mb-8">
                <div class="w-1/2">
                    <select-field label="Layout"
                                  id="page.layout"
                                  :options="options"
                                  v-model="page.layout"
                    ></select-field>
                </div>
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
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    import {mapState} from 'vuex';
    import SearchInput from "../../../components/input/SearchInput";
    import TextField from "../../../components/fields/TextField";
    import SelectField from "../../../components/fields/SelectField";

    export default {
        name: 'page-settings',

        components: {SelectField, TextField, SearchInput},

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
            }),

            isDirty() {
                return !_.isEqual(this.page, this.original);
            },
        },

        methods: {
            reset() {
                this.page = this.$copyObject(this.original);
            },

            save() {
                this.saving = true;

                axios.put(`api/pages/${this.page.id}`, this.page)
                    .then(response => {
                        this.$store.commit('page/page', this.$copyObject(this.page));
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