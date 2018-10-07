<template>
    <ul class="list-reset page-tree-container py-2" :data-parent="parent">
        <sortable-item v-for="page in sortedPages" :key="page.id">
            <li class="" :data-id="page.id">
                <div class="flex items-center justify-between">
                    <page-tree-item :page="page"/>
                    <sortable-handle>
                        <svg class="w-8 h-8 fill-current text-tertiary hover:text-primary cursor-move" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M14 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zM8 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                        </svg>
                    </sortable-handle>
                </div>
                <page-tree :pages="page.children"
                           :parent="page.id"
                           class="pl-10"
                ></page-tree>
            </li>
        </sortable-item>
    </ul>
</template>

<script>
    import _ from 'lodash';
    import SortableItem from "../../../components/sortable/SortableItem";
    import SortableHandle from "../../../components/sortable/SortableHandle";
    import PageTreeItem from "./PageTreeItem";

    export default {
        name: 'page-tree',

        components: {PageTreeItem, SortableHandle, SortableItem},

        props: ['pages', 'parent'],

        computed: {
            sortedPages() {
                return _.sortBy(this.pages, 'order');
            }
        }
    }
</script>
