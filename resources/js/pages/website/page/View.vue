<template>
    <loading :loading="pageLoading">
        <template v-if="page">
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
            <div class="flex mb-8 border-b-2">
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
        </template>
        <router-view></router-view>
    </loading>
</template>

<script>
    import {mapState} from 'vuex';
    import Loading from "../../../components/Loading";

    export default {
        name: 'page-view',
        components: {Loading},
        data() {
            return {
            }
        },

        computed: {
            ... mapState({
                page: state => state.page.page,
                pageLoading: state => state.page.loading,
            }),
        },

        methods: {
            fetchPage() {
                this.$store.dispatch('page/fetch', {id: this.$route.params.id});
            }
        },

        watch: {
            '$route.params.id': 'fetchPage'
        },

        created() {
            this.fetchPage();
        },

        beforeDestroy() {
            this.$store.commit('page/clear');
        }
    }
</script>