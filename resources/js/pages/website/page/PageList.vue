<template>
    <div class="card px-2">
        <div class="border-b p-2 flex justify-between items-center">
            <span class="uppercase tracking-wide text-secondary">Pages</span>
            <button class="px-2 py-1 text-tertiary hover:text-blue"
                    type="button">
                <icon icon="document-add" class="w-4 h-4"></icon>
            </button>
        </div>
        <loading :loading="loading">
            <ul class="list-reset">
                <li v-for="page in pages"
                    :key="page.id"
                    class="">
                    <router-link :to="{name: 'pages.view', params: {id: page.id}}"
                                 class="no-underline block p-2 text-secondary hover:text-brand-dark">
                        {{ page.title }}
                    </router-link>
                </li>
            </ul>
        </loading>
    </div>
</template>

<script>
    import axios from 'axios';
    import Icon from "../../../components/Icon";
    import Loading from "../../../components/Loading";

    export default {
        name: 'page-list',

        components: {Loading, Icon},

        data() {
            return {
                loading: false,
                pages: [],
            }
        },

        methods: {
            fetchPages() {
                this.loading = true;

                axios.get('api/pages')
                    .then(response => {
                        this.pages = response.data;
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        },

        created() {
            this.fetchPages();
        }
    }
</script>