<template>
    <div class="relative w-full">
        <label class="form-label"
               :for="id">
            {{ label }}
        </label>
        <div class="grid">
            <div class="w-1/2">
                <textarea ref="editor"
                          :id="id"
                          class="form-input h-64"
                          :class="{'form-error': hasErrors}"
                          :disabled="disabled"
                          :placeholder="placeholder"
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

    export default {
        name: 'markdown-field',

        props: {
            value: {
                required: true,
            },
            id: {
                type: String,
            },
            label: {
                type: String,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            placeholder: {
                type: String
            },
            errors: {
                type: Array,
            }
        },

        data() {
            return {}
        },

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
            hasErrors() {
                return this.errors && this.errors.length > 0;
            },

            preview() {
                return this.converter.makeHtml(this.value);
            }
        }
    }
</script>