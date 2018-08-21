<template>
    <layout-container :layout-name="page.layout"></layout-container>
</template>

<script>
    import {mapState} from 'vuex';
    import LayoutContainer from "./layout/LayoutContainer";

    export default {
        name: '',

        components: {LayoutContainer},

        computed: {
            ...mapState({
                page: state => state.page.page,
            }),
        },
    }
</script>