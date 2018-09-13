<template>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <span class="inline-block py-2 px-4 rounded-full bg-brand text-primary-inverse mr-2">{{page.title}}</span>
            <span class="text-secondary mr-1">{{page.slug}}</span>
        </div>
        <div class="text-tertiary text-sm">
            <span class="mr-2">Last updated: {{ page.update_at | from-now }}</span>
            <span>Created: {{ page.created_at | from-now }}</span>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import DeletePageButton from "./DeletePageButton";
    import Icon from "../../../components/Icon";

    export default {
        name: 'page-view-header',

        components: {Icon, DeletePageButton},

        computed: {
            ... mapState({
                page: state => state.page.page,
            }),
        },
    }
</script>