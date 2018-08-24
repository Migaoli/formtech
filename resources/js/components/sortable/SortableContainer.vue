<script>
    import {Sortable} from '@shopify/draggable';


    export default {
        name: 'sortable-container',

        props: {
            containerSelector: {
                default: null,
            },
            itemClass: {
                default: "sortable-list-item"
            },
            handleClass: {
                default: "sortable-list-handle"
            }
        },

        mounted() {
            const container = this.containerSelector ? document.querySelectorAll(this.containerSelector) : this.$el;

            new Sortable(container, {
                draggable: `.${this.itemClass}`,
                handle: `.${this.handleClass}`,
                mirror: {
                    constrainDimensions: true
                }
            }).on("sortable:stop", (event) => {
                this.$emit('stop', event);
            }).on("sortable:start", (event) => {
                this.$emit('start', event);
            })
        },

        provide() {
            return {
                sortableListItemClass: this.itemClass,
                sortableListHandleClass: this.handleClass
            }
        },

        render() {
            return this.$slots.default[0];
        }
    }
</script>