<template>
    <div class="grid mb-8" :id="block.id">
        <template v-for="child in block.children">
            <column-container v-if="child.type === 'column'" :id="child.id"
            ></column-container>
        </template>
    </div>
</template>

<script>
    import ColumnContainer from "./ColumnContainer";

    export default {
        name: 'row-container',
        components: {ColumnContainer},
        props: ['block']
    }
</script>