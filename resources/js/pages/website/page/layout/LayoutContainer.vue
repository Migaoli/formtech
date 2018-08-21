<template>
    <div>
        <div v-for="(row, i) in layout.grid"
             class="grid mb-8">
           <column-container v-for="column in row" :id="column"
           ></column-container>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import RowContainer from "./RowContainer";
    import BlockContainer from "./BlockContainer";
    import ColumnContainer from "./ColumnContainer";

    export default {
        name: 'layout-container',

        components: {ColumnContainer, BlockContainer, RowContainer},

        props: ['layoutName'],

        computed: {
            ... mapState({
                layout(state) {
                    return state.themes.theme.layouts[this.layoutName];
                },
            }),
        },
    }
</script>