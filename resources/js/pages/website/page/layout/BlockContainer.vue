<template>
    <div class="block-container relative mb-8 shadow border overflow-x-hidden bg-grey-lightest"
         @mouseenter="showToolbar = true"
         @mouseleave="showToolbar = false">
        <div class="shadow flex justify-between w-full bg-grey-darkest">
            <div class="flex items-center">
                <button class="py-3 px-3 mr-2 text-tertiary-inverse hover:text-primary-inverse"
                        type="button">
                    <icon icon="edit-pencil" class="w-4 h-4 fill-current"></icon>
                </button>
                <button class="py-3 px-3 mr-2 text-tertiary-inverse hover:text-primary-inverse"
                        type="button">
                    <icon icon="view-show" class="w-4 h-4 fill-current"></icon>
                </button>
                <button class="py-3 px-3 mr-2 text-tertiary-inverse hover:text-primary-inverse"
                        type="button">
                    <icon icon="trash" class="w-4 h-4 fill-current"></icon>
                </button>
            </div>
            <div class="flex items-center">
                <svg class="w-6 h-6 fill-current text-tertiary-inverse hover:text-primary-inverse cursor-move"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M14 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zM8 4h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm6 6h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1zm-6 0h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                </svg>
            </div>
        </div>
        <div>
            <pre>{{ block }}</pre>
        </div>
    </div>
</template>

<script>
    import Icon from "../../../../components/Icon";

    export default {
        name: 'block-container',

        components: {Icon},

        props: ['block'],

        data() {
            return {
                showToolbar: false,
            }
        }
    }
</script>