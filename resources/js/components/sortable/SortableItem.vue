<script>
    export default {
        name: 'sortable-item',

        inject: ["sortableListItemClass"],

        mounted() {
            this.$el.classList.add(this.sortableListItemClass)
        },

        render() {
            return this.$slots.default[0];
        }
    }
</script>