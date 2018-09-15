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
            <sortable-container container-selector=".page-tree-container"
                                @stop="movePage">
                <page-tree :pages="tree"></page-tree>
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

            tree() {
                return this.buildTree(this.pages, null);
            }
        },

        methods: {
            buildTree(pages, parentId = null) {
                const branch = {};

                pages.filter(page => page.parent_id === parentId)
                    .forEach(page => {
                        page.children = this.buildTree(pages, page.id);
                        branch[page.id] = page;
                    });

                return branch;
            },

            fetchPages() {
                this.loading = true;

                axios.get('api/pages')
                    .then(response => {
                        this.pages = response.data.data;
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
            },

            movePage(e) {
                const newParentId = e.newContainer.id ? Number(e.newContainer.id) : null;
                const oldParentId = e.oldContainer.id ? Number(e.oldContainer.id) : null;
                const index = e.newIndex;
                const pageId = Number(e.data.dragEvent.source.id);

                const page = this.findPage(pageId);

                this.pages.filter(p => p.parent_id === newParentId)
                    .filter(p => p.order >= index)
                    .forEach(p => p.order++);

                page.parent_id = newParentId === 0 ? null : newParentId;
                page.order = index;

                const newTree = this.pages
                    .map(p => {
                        return {
                            id: p.id,
                            parent_id: p.parent_id,
                            order: p.order,
                        };
                    });

                axios.put('api/pages', newTree);
            },

            findPage(id) {
                return this.pages.find(page => page.id === id);
            }
        },

        created() {
            this.fetchPages();
        }
    }
</script>