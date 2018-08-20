<template>
    <router-view></router-view>
</template>

<script>

    export default {
        name: '',

        created() {
            this.$store.dispatch('blocks/fetch');
        }

    }
</script>