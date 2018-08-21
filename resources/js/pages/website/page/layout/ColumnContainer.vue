<template>
    <div class="flex-1 w-0">
        <div class="min-h-64 bg-white border shadow-md rounded column-container py-8 px-4 overflow-x-hidden" :id="id">
            <sortable-item v-for="block in blocksInContainer"
                           :key="block.id">
                <block-container :block="block"></block-container>
            </sortable-item>
        </div>
    </div>
</template>

<script>
    import BlockContainer from "./BlockContainer";
    import SortableItem from "../../../../components/sortable/SortableItem";

    export default {
        name: 'column-container',

        components: {SortableItem, BlockContainer},

        props: ['id', 'blocks'],

        computed: {

            blocksInContainer() {
                return this.blocks.filter(block => block.container === this.id)
                    .sort((a, b) => a.position - b.position);
            }
        }
    }
</script>