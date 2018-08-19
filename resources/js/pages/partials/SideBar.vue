<template>
    <div class="border-r relative px-8 py-6">
        <div class="flex flex-col whitespace-no-wrap">
            <div v-for="group in navigation"
                 class="mb-8 w-full">
                <span class="block py-2 uppercase tracking-wide text-secondary thin text-sm">{{ group.name }}</span>
                <router-link v-for="item in group.items"
                             :key="item.name"
                             :to="{name: item.route}"
                             :active-class="activeClass"
                             class="flex py-2 no-underline text-secondary hover:text-brand">
                    <icon :icon="item.icon" class="w-4 h-4 mr-2"></icon>
                    {{ item.name }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import Icon from "../../components/Icon";

    export default {
        name: 'side-bar',
        components: {Icon},
        data() {
            return {
                navigation: [
                    {
                        name: 'Quick links',
                        items: [
                            {
                                name: 'Home',
                                route: 'home',
                                icon: 'home'
                            }
                        ]
                    }, {
                        name: 'Website',
                        items: [
                            {
                                name: 'Pages',
                                route: 'pages',
                                icon: 'document'
                            }
                        ]
                    }
                ]
            }
        },

        methods: {
            isActive(route) {
                return this.$route.name === route;
            },

            iconActiveClass(route) {
                return this.isActive(route) ? 'text-brand' : 'text-tertiary';
            }
        },

        computed: {
            activeClass() {
                return 'text-brand';
            }
        }
    }
</script>