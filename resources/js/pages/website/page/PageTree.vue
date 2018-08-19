<template>
    <ul class="list-reset page-tree-container pb-2">
        <sortable-item v-for="page in pages" :key="page.id">
            <li class="">
                <div class="flex items-center justify-between">
                    <router-link :to="{name: 'pages.view', params: {id: page.id}}"
                                 class="no-underline w-full group">
                        <span class="p-2 inline-block font-semibold text-primary group-hover:text-brand">{{ page.title }}</span>
                        <span class="text-secondary text-sm">({{ page.slug }})</span>
                    </router-link>
                    <sortable-handle>
                        <svg class="w-6 h-6 fill-current text-tertiary hover:text-primary cursor-move" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M14 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zM8 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                        </svg>
                    </sortable-handle>
                </div>
                <page-tree :pages="page.children"
                           class="pl-10"
                ></page-tree>
            </li>
        </sortable-item>
    </ul>
</template>

<script>
    import Icon from "../../../components/Icon";
    import SortableList from "../../../components/sortable/SortableList";
    import SortableItem from "../../../components/sortable/SortableItem";
    import SortableHandle from "../../../components/sortable/SortableHandle";

    export default {
        name: 'page-tree',

        components: {SortableHandle, SortableItem, SortableList, Icon},

        props: ['pages'],
    }
</script>