<template>
    <div>
        <sortable-container container-selector=".column-container"
                            @stop="moveBlock"
                            @start="start"
                            @mirror:created="mirrorCreated">
            <div>
                <div v-for="(row, i) in layout.grid"
                     class="grid mb-8">
                    <column-container v-for="column in row"
                                      :key="column"
                                      :id="column"
                                      :blocks="blocks"
                    ></column-container>
                </div>
            </div>
        </sortable-container>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import BlockContainer from "./BlockContainer";
    import ColumnContainer from "./ColumnContainer";
    import SortableContainer from "../../../../components/sortable/SortableContainer";

    export default {
        name: 'layout-container',

        components: {SortableContainer, ColumnContainer, BlockContainer},

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
            mirrorCreated({mirror}) {
                mirror.removeChild(mirror.querySelector('.block-preview-container'));

                console.log({mirror});
            },

            start(e) {
                const dragEvent = e.data.dragEvent;
                this.previewNode = dragEvent.originalSource.querySelector('.block-preview-container');
                dragEvent.originalSource.removeChild(this.previewNode);
                dragEvent.source.removeChild(dragEvent.source.querySelector('.block-preview-container'));
            },

            moveBlock(e) {
                e.data.dragEvent.originalSource.appendChild(this.previewNode);
                console.log(e);
                const oldContainer = e.oldContainer.id;
                const newContainer = e.newContainer.id;
                const oldIndex = e.oldIndex;
                const newIndex = e.newIndex;
                const blockId = Number(e.data.dragEvent.source.id);

                const part1 = this.blocks.filter(block => block.container !== newContainer);
                const part2 = this.blocks.filter(block => block.container === newContainer);

                part2.filter(block => block.order >= newIndex)
                    .forEach(block => block.order++);

                const block = this.blocks.find(block => block.id === blockId);
                block.container = newContainer;
                block.order = newIndex;

                this.$emit('update', [...part1, ...part2]);
            }
        }
    }
</script>