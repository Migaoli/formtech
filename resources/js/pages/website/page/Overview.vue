<template>
    <div class="card px-2">
        <div class="border-b mb-4 flex justify-between items-center">
            <div class="uppercase tracking-wide px-2 py-4">Pages</div>
            <dropdown-menu>
                <button slot="activator"
                        class="text-tertiary hover:text-blue"
                        type="button">
                    <icon icon="document-add" class="w-4 h-4"></icon>
                </button>
                <div class="bg-white shadow-md border rounded z-100 -mt-2">
                    <div class="py-2 px-4 font-bold border-b">Create a new page</div>
                    <ul class="list-reset">
                        <li v-for="definition in pageTypes"
                            class="py-2 px-4 text-secondary hover:text-brand cursor-pointer"
                            @click="create(definition.name)">
                            {{ definition.name }}
                        </li>
                    </ul>
                </div>
            </dropdown-menu>
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
    import {mapState} from 'vuex';
    import Icon from "../../../components/Icon";
    import Loading from "../../../components/Loading";
    import PageTree from "./PageTree";
    import SortableContainer from "../../../components/sortable/SortableContainer";
    import DropdownMenu from "../../../components/Dropdown";

    export default {
        name: '',

        components: {DropdownMenu, SortableContainer, PageTree, Loading, Icon},

        data() {
            return {
                loading: false,
                pages: [],
            }
        },

        computed: {
            ...mapState({
                pageTypes: state => state.page.types,
            }),
        },

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

            create(type) {
                this.$router.push({
                    name: 'pages.create',
                    query: {
                        type,
                    },
                });
            }
        },

        created() {
            this.fetchPages();
        }
    }
</script>