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
        <layout-container :layout-name="page.layout"
                          v-model="blocks"
        ></layout-container>
    </div>
</template>

<script>
    import _ from 'lodash';
    import axios from 'axios';
    import {mapState} from 'vuex';
    import LayoutContainer from "./layout/LayoutContainer";

    export default {
        name: '',

        components: {LayoutContainer},

        data() {
            return {
                saving: false,
                blocks: [],
                showCreateBlockDialog: false,
                blockDefinition: null,
                container: '',
            }
        },

        watch: {
            '$store.state.page.page.blocks': function () {
                this.$nextTick(() => {
                    this.reset();
                });
            },
        },

        computed: {
            ...mapState({
                page: state => state.page.page,
                blockDefinitions: state => state.blocks.blocks,
            }),

            isDirty() {
                return !_.isEqual(this.page.blocks, this.blocks);
            }
        },

        methods: {
            reset() {
                this.blocks = this.$copyObject(this.page.blocks);
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
            this.reset();
        }
    }
</script>