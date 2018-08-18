const _ = require('lodash');

const defaultConfig = {
    colors: {
        default: 'grey',
        blue: 'blue',
        red: 'red',
    },
};

module.exports = function (options) {
    return function ({addUtilities, addComponents, e, prefix, config}) {


        const buttons = {
            '.btn': {
                'padding': `${config('padding.2')} ${config('padding.4')}`,
                'border-radius': config('borderRadius.default'),
                'cursor': 'pointer',
            },
            '.btn-primary': {
                'border-width': config('borderWidths.default'),
                'color': config('colors.white'),
            },
            '.btn-secondary': {
                'border-width': config('borderWidths.default'),
            },
            '.btn-tertiary': {
                'border-bottom-width': config('borderWidths.default'),
                'border-color': 'transparent',
            }
        };

        const buttonVariants = _.map(defaultConfig.colors, (color, className) => {
            return {
                [`.btn-${className}`]: {
                    '&.btn-primary': {
                        'border-color': config(`colors.${color}`),
                        'background-color': config(`colors.${color}`),
                        '&:hover': {
                            'border-color': 'transparent',
                            'background-color': config(`colors.${color}-dark`),
                        },
                        '&.active': {
                            'border-color': 'transparent',
                            'background-color': config(`colors.${color}-dark`),
                        },
                    },
                    '&.btn-secondary': {
                        'border-color': config(`colors.${color}`),
                        'color': config(`colors.${color}-dark`),
                        '&:hover': {
                            'color': config('colors.white'),
                            'background-color': config(`colors.${color}`),
                        },
                        '&.active': {
                            'color': config('colors.white'),
                            'background-color': config(`colors.${color}`),
                        }
                    },
                    '&.btn-tertiary': {
                        // .text-blue-dark .border-b .border-transparent;
                        'color': config(`colors.${color}-dark`),
                        '&:hover': {
                            'border-color': config(`colors.${color}`),
                        },
                        '&.active': {
                            'border-color': config(`colors.${color}`),
                        }
                    }
                }
            }
        });

        addComponents([buttons, ...buttonVariants]);


    }
};