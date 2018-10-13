<template>
    <div>
        <form-container v-if="pageDefinition"
                        :fields="pageDefinition.fields"
                        :data="page"
                        :errors="errors"
                        @reset="cancel"
                        @submit="create">

            <div slot-scope="{formData, fields, errors, isDirty, submitActions, resetActions}">

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

    export default {
        name: '',

        data() {
            return {
                creating: false,
                page: null,
                errors: {},
            };
        },

        computed: {
            ... mapState({
                definitions: state => state.page.types,
            }),

            pageDefinition() {
                return this.definitions[this.type];
            },

            type() {
                return this.$route.query.type;
            }
        },

        watch: {
            blockDefinition: function () {
                this.page = this.init();
            },
        },

        created() {
            this.page = this.init();
        },

        methods: {
            init() {
                return {
                    type: this.type,
                };
            },

            create(formData) {
                this.creating = true;

                console.log(formData);

                axios.post('api/pages', formData)
                    .then(response => {
                        this.creating = false;
                        this.$store.commit('page/page', response.data);
                        this.$flash.success('Created Page!');
                        this.$router.push({
                            name: 'pages.view',
                            params: {
                                id: response.data.id,
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

            cancel() {
                this.$router.push({name: 'pages'});
            }
        }
    }
</script>