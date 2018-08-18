<template>
    <div>
        <div v-if="loading"
             class="flex flex-col justify-center items-center h-full py-4">
            <div class="spinner border-4 inline-block w-16 h-16"></div>
            <div class="font-thin pt-4">
                Loading
            </div>
        </div>
        <slot v-else></slot>

    </div>
</template>

<script>
    export default {
        name: 'loading',

        props: {
            loading: {
                type: Boolean,
                required: true,
            }
        }
    }
</script>