<template>
    <div class="flex-1 w-0">
        <div class="flex justify-between">
            <span class="text-secondary p-2">Container-ID: {{ id }}</span>

            <dropdown-menu class="">
                <button slot="activator"
                        class="appearance-none p-2 text-tertiary hover:text-primary"
                        type="button">
                    <icon icon="add-outline" class="w-4 h-4"></icon>
                </button>
                <div class="bg-white shadow-md border rounded z-100 -mt-2">
                    <div class="py-2 px-4 font-bold border-b">Create a new block</div>
                    <ul class="list-reset">
                        <li v-for="definition in blockDefinitions"
                            class="py-2 px-4 text-secondary hover:text-brand cursor-pointer"
                            @click="create(definition.name)">
                            {{ definition.name }}
                        </li>
                    </ul>
                </div>
            </dropdown-menu>
        </div>
        <div class="min-h-64 bg-white border shadow-md rounded column-container py-8 px-4 overflow-x-hidden" :id="id">
            <sortable-item v-for="block in blocksInContainer"
                           :key="block.id">
                <block-container :block="block"></block-container>
            </sortable-item>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import BlockContainer from "./BlockContainer";
    import SortableItem from "../../../../components/sortable/SortableItem";
    import Icon from "../../../../components/Icon";
    import DropdownMenu from "../../../../components/Dropdown";

    export default {
        name: 'column-container',

        components: {DropdownMenu, Icon, SortableItem, BlockContainer},

        props: ['id', 'blocks'],

        computed: {
            ...mapState({
                blockDefinitions: state => state.blocks.blocks,
            }),

            blocksInContainer() {
                return this.blocks.filter(block => block.container === this.id)
                    .sort((a, b) => a.order - b.order);
            }
        },

        methods: {
            create(blockName) {
                this.$router.push({
                    name: 'pages.blocks.create',
                    params: {
                        id: this.$route.params.id
                    },
                    query: {
                        type: blockName,
                        container: this.id
                    }
                })
            }
        }
    }
</script>