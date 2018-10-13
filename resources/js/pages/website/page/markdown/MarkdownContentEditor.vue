<template>
    <form-container :data="page" :fields="contentField" :errors="[]">

        <div slot-scope="{ formData, fields }">

            <generic-field v-for="field in fields"
                           :key="field.key"
                           :field="field"
            ></generic-field>

        </div>
    </form-container>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                page: state => state.page.page,
            }),

            contentField() {
                return [{
                    'type': 'markdown',
                    'name': '',
                    'key': 'data.content'
                }]
            }
        },
        methods: {
            reset() {
            },


            save() {

            },
        },
    }
</script>