<template>
    <div class="flex mb-8 border-b-2 justify-between items-end">
        <div class="flex">
            <router-link
                    class="block py-2 px-6 -mb-2px border-b-2 border-transparent hover:border-brand text-primary font-thin no-underline"
                    :active-class="'border-brand'"
                    :to="{name: 'pages.view.content', params: {id: $route.params.id}}">
                Content
            </router-link>
            <router-link
                    class="block py-2 px-6 -mb-2px border-b-2 border-transparent hover:border-brand text-primary font-thin no-underline"
                    :active-class="'border-brand'"
                    :to="{name: 'pages.view.settings', params: {id: $route.params.id}}">
                Settings
            </router-link>
        </div>
        <div class="flex">
            <button class="p-3 text-tertiary hover:text-primary mr-2"
                    type="button"
                    @click="">
                <icon icon="view-show" class="w-4 h-4"></icon>
            </button>
            <delete-page-button :page="page">
                <button class="p-3 text-tertiary hover:text-primary"
                        type="button">
                    <icon icon="trash" class="w-4 h-4"></icon>
                </button>
            </delete-page-button>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import Icon from "../../../components/Icon";
    import DeletePageButton from "./DeletePageButton";

    export default {
        name: 'page-view-toolbar',

        components: {DeletePageButton, Icon},

        computed: {
            ... mapState({
                page: state => state.page.page,
            }),
        },
    }
</script>