<script>
    import {Sortable} from '@shopify/draggable';


    export default {
        name: 'sortable-list',

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
            let blocked = false;

            const container = this.containerSelector ? document.querySelectorAll(this.containerSelector) : this.$el;

            new Sortable(container, {
                draggable: `.${this.itemClass}`,
                handle: `.${this.handleClass}`,
                mirror: {
                    constrainDimensions: true
                }
            }).on("sortable:stop", (event) => {
                console.log(event);
                this.$emit('stop', event);
            }).on("sortable:start", (event) => {
                console.log(event);
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