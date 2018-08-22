<template>
    <div>
        <sortable-list container-selector=".column-container"
                       @stop="moveBlock">
            <div>
                <div v-for="(row, i) in layout.grid"
                     class="grid mb-8">
                    <column-container v-for="column in row"
                                      :id="column"
                                      :blocks="blocks"
                                      @create="(e) => $emit('create', e)"
                    ></column-container>
                </div>
            </div>
        </sortable-list>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import BlockContainer from "./BlockContainer";
    import ColumnContainer from "./ColumnContainer";
    import SortableList from "../../../../components/sortable/SortableList";

    export default {
        name: 'layout-container',

        components: {SortableList, ColumnContainer, BlockContainer},

        model: {
            prop: 'blocks',
            event: 'update',
        },

        props: ['layoutName', 'blocks'],

        computed: {
            ... mapState({
                layout(state) {
                    return state.themes.theme.layouts[this.layoutName];
                },
            }),
        },

        methods: {
            moveBlock(e) {
                const oldContainer = e.oldContainer.id;
                const newContainer = e.newContainer.id;
                const oldIndex = e.oldIndex;
                const newIndex = e.newIndex;
                const blockId = Number(e.data.dragEvent.source.id);

                console.log({
                    oldContainer,
                    newContainer,
                    oldIndex,
                    newIndex,
                    blockId
                });


                const part1 = this.blocks.filter(block => block.container !== newContainer);
                const part2 = this.blocks.filter(block => block.container === newContainer);

                part2.filter(block => block.position >= newIndex)
                    .forEach(block => block.position++);

                const block = this.blocks.find(block => block.id === blockId);
                block.container = newContainer;
                block.position = newIndex;

                this.$emit('update', [...part1, ...part2]);
            }
        }
    }
</script>