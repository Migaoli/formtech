<script>
    import _ from 'lodash';
    import Popper from 'popper.js';

    export default {
        name: 'dropdown-menu',

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
            const activator = this.createActivator(h);
            const container = this.createContainer(h);

            this.$nextTick(() => {
                this.setupPopper();
            });

            return h('div', {}, [activator, container])
        },

        beforeDestroy() {
            if (this.popper) {
                this.popper.destroy();
            }
        },

        methods: {
            setupPopper() {
                if (!this.show) {
                    return;
                }
                if (this.popper === undefined) {
                    this.popper = new Popper(this.$refs.activator, this.$refs.dropdown, {
                        placement: "bottom"
                    })
                } else {
                    this.popper.scheduleUpdate()
                }
            },

            createActivator(h) {
                const activator = Object.assign({}, this.$slots.activator[0]);


                if (!activator) {
                    return null;
                }
                const data = {
                    ref: 'activator',
                    on: {}
                };

                if (this.openOnHover) {
                    data.on['mouseenter'] = this.mouseEnterHandler;
                    data.on['mouseleave'] = this.mouseLeaveHandler;
                } else {
                    data.on['click'] = this.activatorClickHandler;
                }

                return h(activator.tag, _.merge(data, activator.data), activator.children || activator.text);
            },

            createContainer(h) {
                const original = this.$slots.default.find(node => node.tag);

                const data = {
                    ref: 'dropdown',
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
                    data.style['display'] = 'none';
                }

                if (this.openOnHover) {
                    data.on['mouseenter'] = this.mouseEnterHandler;
                    data.on['mouseleave'] = this.mouseLeaveHandler;
                }

                if (this.closeOnClick) {
                    data.on['click'] = () => {
                        this.show = false
                    };
                }

                return h(original.tag, _.merge(data, original.data), original.children || original.text);
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