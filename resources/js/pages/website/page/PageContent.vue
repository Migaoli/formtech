<template>
    <div>
        <page-view-header></page-view-header>
        <page-view-toolbar></page-view-toolbar>
        <component :is="contentEditorComponent"></component>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import PageViewHeader from "./PageViewHeader";
    import PageViewToolbar from "./PageViewToolbar";
    import BlockContentEditor from './standard/BlockContentEditor';
    import MarkdownContentEditor from './markdown/MarkdownContentEditor';
    import NoContentEditor from './NoContentEditor';

    export default {
        name: '',

        components: {PageViewToolbar, PageViewHeader},

        computed: {
            ...mapState({
                page: state => state.page.page,
            }),

            contentEditorComponent() {
                switch (this.page.type) {
                    case 'App\\Pages\\StandardPage':
                        return BlockContentEditor;
                    case 'App\\Pages\\MarkdownPage':
                        return MarkdownContentEditor;
                }

                return NoContentEditor;

            },
        },


    }
</script>