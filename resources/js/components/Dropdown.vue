<script>
    export default {
        name: 'dropdown',

        props: {
            openOnClick: {
                type: Boolean,
                default: true,
            },
            closeOnClick: {
                type: Boolean,
                default: true
            },
            openOnHover: Boolean
        },

        data() {
            return {
                show: false,
            }
        },

        render(h) {
            const activator = this.createActivator();
            const container = this.createContainer();

            return h('div', {}, [activator, container])
        },


        methods: {
            createActivator() {
                if (!this.$slots.activator) {
                    return null;
                }

                const options = {
                    ref: 'activator',
                    on: {}
                };

                if (this.openOnHover) {
                    options.on['mouseenter'] = this.mouseEnterHandler;
                    options.on['mouseleave'] = this.mouseLeaveHandler;
                } else {
                    options.on['click'] = this.activatorClickHandler;
                }

                return this.$createElement('div', options, this.$slots.activator);
            },

            createContainer() {
                const options = {
                    style: {},
                    directives: [
                        {
                            name: 'click-outside',
                            value: () => (this.show = false),
                            args: {
                                closeConditional: () => {
                                    return this.show;
                                }
                            }
                        }
                    ],
                    on: {}
                };

                if (!this.show) {
                    options.style['display'] = 'none';
                }

                if (this.openOnHover) {
                    options.on['mouseenter'] = this.mouseEnterHandler;
                    options.on['mouseleave'] = this.mouseLeaveHandler;
                }

                if (this.closeOnClick) {
                    options.on['click'] = () => {
                        this.show = false
                    };
                }

                return this.$createElement('div', options, this.$slots.default);
            },


            mouseEnterHandler() {
                this.show = true;
            },

            mouseLeaveHandler() {
                this.show = false;
            },

            activatorClickHandler() {
                this.show = !this.show;
            }
        }
    }
</script>