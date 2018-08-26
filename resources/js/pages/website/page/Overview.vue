<template>
    <div class="card px-2">
        <div class="border-b mb-4 flex justify-between items-center">
            <div class="uppercase tracking-wide px-2 py-4">Pages</div>
            <button class="text-tertiary hover:text-blue"
                    type="button"
                    @click="create">
                <icon icon="document-add" class="w-4 h-4"></icon>
            </button>
        </div>
        <loading :loading="loading">
            <sortable-container container-selector=".page-tree-container">
                <page-tree :pages="pages"></page-tree>
            </sortable-container>
        </loading>
    </div>
</template>

<script>
    import axios from "axios";
    import Icon from "../../../components/Icon";
    import Loading from "../../../components/Loading";
    import PageTree from "./PageTree";
    import SortableContainer from "../../../components/sortable/SortableContainer";

    export default {
        name: '',

        components: {SortableContainer, PageTree, Loading, Icon},

        data() {
            return {
                loading: false,
                pages: [],
            }
        },

        computed: {},

        methods: {
            fetchPages() {
                this.loading = true;

                axios.get('api/pages?tree')
                    .then(response => {
                        this.pages = response.data;
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            create() {

            }
        },

        created() {
            this.fetchPages();
        }
    }
</script>