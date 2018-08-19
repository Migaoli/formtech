<template>
    <on-click-outside :do="close">
        <div class="relative" :class="{'is-active': isOpen}">
            <button class="form-select text-left"
                    :class="{'cursor-default': disabled}"
                    type="button"
                    ref="button"
                    :disabled="disabled"
                    @click.prevent="open">

                <slot v-if="value !== null" name="selected" :selected="value">
                    {{ value }}
                </slot>
                <span v-else class="text-tertiary">
                        {{ placeholder }}
                </span>
            </button>
            <div v-show="isOpen"
                 class="absolute pin-x z-100">
                <div class="border rounded shadow mt-1 bg-white p-3">
                    <input class="block w-full py-3 px-3 bg-grey-lightest border rounded mb-2"
                           type="text"
                           ref="search"
                           :value="search"
                           @input="onInput"
                           @keydown.esc="close"
                           @keydown.up="highlightPrev"
                           @keydown.down="highlightNext"
                           @keydown.enter.prevent="selectHighlighted"
                           @keydown.tab.prevent>

                    <ul v-if="options.length > 0"
                        class="list-reset max-h-xs overflow-y-auto"
                        ref="options">
                        <li v-for="(option, i) in options" :key="i"
                            class="py-3 px-4 rounded hover:bg-grey-lighter"
                            :class="{'bg-blue-lighter': i === highlightedIndex}"
                            @click="select(option)"
                        >
                            <slot name="option"
                                  :option="option"
                                  :isHighlighted="highlightedIndex === i">
                                {{ option }}
                            </slot>
                        </li>
                    </ul>
                    <div v-else class="py-2 text-secondary">
                        No results found for "{{ search }}"
                    </div>
                </div>
            </div>
        </div>
    </on-click-outside>
</template>

<script>
    import OnClickOutside from "../OnClickOutside";

    import SearchInputMixin from './SearchInputMixin';

    export default {
        name: 'search-input',

        components: {OnClickOutside},

        mixins: [SearchInputMixin],

        props: {
            value: {
                required: true,
            },

            options: {
                type: Array,
                required: true,
            },

            disabled: {
                type: Boolean,
                default: false,
            },

            placeholder: {
                type: String,
                default: ''
            },
        },
    }
</script>