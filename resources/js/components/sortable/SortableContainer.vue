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

            this.sortable = new Sortable(container, {
                draggable: `.${this.itemClass}`,
                handle: `.${this.handleClass}`,
                mirror: {
                    constrainDimensions: true
                }
            })
                .on("sortable:stop", e => this.$emit('stop', e))
                .on("sortable:start", e => this.$emit('start', e))
                .on('mirror:created', e => this.$emit('mirror:created', e))
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