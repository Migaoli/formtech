<template>
    <div class="h-full">
        <router-view></router-view>
        <portal-target name="modals"></portal-target>
    </div>
</template>

<script>
    export default {
        name: 'app',

        data() {
            return {
                asd: 123
            }
        },

        created() {

        }
    }
</script>
