var mixin = {
    data() {
        return {
            isOpen: false,
            highlightedIndex: 0,
            search: '',
        }
    },

    methods: {
        open() {
            if (this.isOpen) {
                return;
            }

            this.isOpen = true;
            this.triggerSearch();

            this.$nextTick(() => {
                this.$refs.search.focus();
                this.scrollToHighlighted();
            })
        },

        close() {
            if (!this.isOpen) {
                return;
            }

            this.isOpen = false;
            this.$refs.button.focus();
            this.search = '';
            this.highlightedIndex = 0;
        },

        onInput(e) {
            this.search = e.target.value;
            this.triggerSearch();
            this.highlightedIndex = 0;
        },

        triggerSearch() {
            this.$emit('search', this.search);
        },

        select(option) {
            this.$emit('input', option);
            this.close();
        },

        selectHighlighted() {
            let option = this.options[this.highlightedIndex];
            if (option) {
                this.select(option);
            }
        },

        scrollToHighlighted() {
            if (this.options.length === 0) {
                return;
            }

            this.$refs.options.children[this.highlightedIndex].scrollIntoView({
                block: "nearest"
            });
        },

        highlightIndex(index) {
            this.highlightedIndex = index;

            if (this.highlightedIndex < 0) {
                this.highlightedIndex = this.options.length - 1;
            }

            if (this.highlightedIndex >= this.options.length) {
                this.highlightedIndex = 0;
            }

            this.scrollToHighlighted();
        },

        highlightPrev() {
            this.highlightIndex(this.highlightedIndex - 1)
        },

        highlightNext() {
            this.highlightIndex(this.highlightedIndex + 1)

        }
    }
};

export default mixin;