<template>
    <div class="flex justify-between items-center w-full page-tree-item" :data-id="page.id">
        <icon :icon="icon" class="w-4 h-4 text-tertiary"></icon>
        <router-link :to="{name: 'pages.view', params: {id: page.id}}"
                     class="no-underline w-full group">
            <span class="p-2 inline-block font-semibold text-primary group-hover:text-brand">{{ page.title }}</span>
        </router-link>
        <div class="px-8 flex items-center">
            <div class="w-4 h-4 mr-4 flex justify-center items-center">
                <div v-if="hasChanged"
                     :class="modifiedColor"
                     class="w-2 h-2 rounded-full"
                     v-tooltip="'Page has been modified.'"
                ></div>
            </div>
            <div class="w-4 h-4 mr-4">
                <icon icon="menu"
                      class="w-4 h-4 text-tertiary"
                      v-tooltip="'Page is shown in menu.'"
                ></icon>
            </div>
            <div class="w-4 h-4">
                <icon icon="view-hide"
                      class="w-4 h-4 text-tertiary"
                      v-tooltip="'Page is hidden.'"
                ></icon>
            </div>
        </div>
    </div>
</template>
<script>
    import Icon from '../../../components/Icon';

    export default {
        name: 'page-tree-item',

        components: {Icon},

        props: {
            page: {}
        },

        computed: {
            hasChanged() {
                return this.page.live_version !== this.page.updated_at;
            },

            modifiedColor() {
                return this.page.live_version ? 'bg-blue-dark' : 'bg-green-dark';
            },

            icon() {
                if (this.page.type === 'App\\Pages\\StandardPage') {
                    return 'document';
                }

                if (this.page.type === 'App\\Pages\\MenuSeparator') {
                    return 'folder-outline'
                }

                if (this.page.type === 'App\\Pages\\ErrorPage') {
                    return 'exclamation-outline'
                }

                return '';
            }
        }
    }
</script>