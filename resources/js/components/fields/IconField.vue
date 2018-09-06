<template>
    <base-field :field="field" :errors="errors">

        <div class="flex items-center mb-4">
            <svg v-if="value"
                 class="text-secondary w-6 h-6 mr-4"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <use :xlink:href="link"></use>
            </svg>

            <search-input class="flex-1"
                          :options="icons"
                          v-model="value"
                          :placeholder="field.name"
                          @search="filterIcons">
                <div slot="option" slot-scope="{ option }">
                    <icon-preview :icon="option"></icon-preview>
                </div>
            </search-input>
        </div>

    </base-field>
</template>

<script>
    import FormField from './FormField';
    import SearchInput from "../input/SearchInput";
    import IconPreview from "./IconPreview";
    import {Slider} from 'vue-color';


    export default {
        name: 'icon-field',

        components: {
            IconPreview,
            SearchInput,
            'slider-color-picker': Slider,
        },

        mixins: [FormField],

        data() {
            return {
                icons: this.field.icons || [],
            }
        },

        computed: {
            link() {
                return `/icons.svg#${this.value}`;
            },
        },

        methods: {
            filterIcons(query) {
                this.icons = this.field.icons.filter(icon => icon.includes(query));
            },
        }


    }
</script>