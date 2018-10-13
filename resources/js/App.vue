<template>
    <div class="h-full bg-grey-lighter">
        <router-view></router-view>
        <portal-target name="modals"></portal-target>
        <flash-message-container></flash-message-container>
    </div>
</template>

<script>
    import FlashMessageContainer from "./plugins/flash/FlashMessageContainer";

    export default {
        name: 'app',

        components: {FlashMessageContainer},
    }
</script>
