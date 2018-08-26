<template>
    <div class="relative w-full">
        <label class="form-label"
               :for="field.key">
            {{ field.name }}
        </label>
        <div class="grid">
            <div class="w-1/2">
                <textarea ref="editor"
                          :id="field.key"
                          class="form-input h-64"
                          :class="{'form-error': hasErrors}"
                          :placeholder="field.name"
                          :value="value"
                          @input="onInput"
                          @keydown.tab.prevent="onTab"
                ></textarea>
            </div>
            <div ref="preview" class="w-1/2" v-html="preview">
            </div>
        </div>
        <ul v-if="hasErrors"
            class="mt-2 text-red-dark">
            <li v-for="(error, i) in errors">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    import Showdown from 'showdown';
    import FormField from './FormField';

    export default {
        name: 'markdown-field',

        mixins: [FormField],

        created() {
            this.converter = new Showdown.Converter();
        },

        methods: {
            onInput(event) {
                this.$emit('input', event.target.value);
                //const text = this.$refs.editor.value;
                //this.$refs.editor.innerHTML = this.converter.makeHtml(text);
            },

            onTab(e) {
                this.$emit('input', event.target.value + '    ');
            }
        },

        computed: {
            preview() {
                return this.converter.makeHtml(this.value);
            }
        }
    }
</script>