<template>
    <base-field :field="field" :errors="errors">
        <div class="flex items-center">
            <material-color-picker v-model="value" class="mr-4"></material-color-picker>
            <slider-color-picker v-model="value"></slider-color-picker>
        </div>
    </base-field>
</template>

<script>
    import FormField from './FormField';
    import {Material, Slider} from 'vue-color';

    export default {
        name: 'color-field',

        mixins: [FormField],

        components: {
            'material-color-picker': Material,
            'slider-color-picker': Slider,
        },

        data() {
            return {
                color: '#194d33'
            }
        }


    }
</script>