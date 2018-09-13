<template>
    <loading :loading="pageLoading">
        <router-view></router-view>
    </loading>
</template>

<script>
    import {mapState} from 'vuex';
    import Loading from "../../../components/Loading";
    import Icon from "../../../components/Icon";
    import DeletePageButton from "./DeletePageButton";

    export default {
        name: 'page-view',

        components: {DeletePageButton, Icon, Loading},

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