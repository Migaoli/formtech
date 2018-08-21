<template>
    <div class="flex-1 w-0" >
        <div class="min-h-64 bg-white border shadow-md rounded column-container py-8 px-4 overflow-x-hidden" :id="id">
            <block-container v-for="block in blocks"
                             :key="block.id"
                             :block="block"
            ></block-container>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import BlockContainer from "./BlockContainer";

    export default {
        name: 'column-container',
        components: {BlockContainer},
        props: ['id'],

        computed: {
            ...mapState({
                page: state => state.page.page,
            }),

            blocks() {
                return this.page.blocks.filter(block => block.container === this.id);
            }
        }
    }
</script>