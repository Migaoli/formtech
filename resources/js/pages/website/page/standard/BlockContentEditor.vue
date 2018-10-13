<template>
    <div>
        <div class="flex justify-end mb-8" v-if="isDirty">
            <button class="btn btn-tertiary btn-default mr-4"
                    type="button"
                    :disabled="saving"
                    @click="reset">
                Cancel
            </button>
            <button class="btn btn-primary btn-blue"
                    type="submit"
                    :disabled="saving"
                    @click.prevent="saveOrder">
                <span v-if="saving">Saving...</span>
                <span v-else>Save</span>
            </button>
        </div>

        <layout-container :layout-name="page.data.layout"
                          v-model="blocks"
        ></layout-container>
    </div>

</template>

<script>
    import {mapState} from 'vuex';
    import axios from 'axios';
    import LayoutContainer from "./LayoutContainer";


    export default {
        name: 'block-content-editor',

        components: {LayoutContainer},

        data() {
            return {
                saving: false,
                original: [],
                blocks: [],
                showCreateBlockDialog: false,
                blockDefinition: null,
                container: '',
            }
        },

        watch: {
            '$route.params.id': function () {
                this.fetchContent();
            },
        },

        computed: {
            ...mapState({
                page: state => state.page.page,
                blockDefinitions: state => state.blocks.blocks,
            }),

            isDirty() {
                return !_.isEqual(this.original, this.blocks);
            }
        },
        methods: {
            reset() {
                //this.blocks = this.$copyObject(this.original);
            },

            fetchContent() {
                axios.get(`api/pages/${this.$route.params.id}/blocks`)
                    .then(response => {
                        this.original = response.data;
                        this.blocks= this.$copyObject(this.original);
                    });
            },

            saveOrder() {
                const payload = this.blocks.map(block => {
                    return {
                        'id': block.id,
                        'container': block.container,
                        'order': block.order,
                    }
                });

                axios.put(`api/pages/${this.page.id}/blocks`, payload)
                    .then(response => {
                        this.$store.dispatch('page/fetch', {id: this.page.id});
                    })
                    .catch(({response}) => {

                    })
                    .finally(() => {

                    })
            },
        },

        created() {
            this.fetchContent();
        }
    }
</script>