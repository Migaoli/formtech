<template>
    <div class="h-full flex flex-col">
        <top-bar></top-bar>
        <div class="flex flex-1">
            <side-bar></side-bar>
            <div class="px-8 py-6 w-full relative overflow-y-auto">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import TopBar from "./partials/TopBar";
    import SideBar from "./partials/SideBar";

    export default {
        name: '',

        components: {SideBar, TopBar},

        created() {
            this.$store.dispatch('themes/fetch');
            this.$store.dispatch('page/fetchTypes');
        }
    }
</script>