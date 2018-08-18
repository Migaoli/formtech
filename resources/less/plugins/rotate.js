const _ = require('lodash');

module.exports = function (options) {
    return function ({addUtilities, e}) {
        const angles = {
            '90': '90deg',
            '180': '180deg',
            '270': '270deg',
        };

        const rotateUtilities = _.map(angles, (value, key) => {
            return {
                [`.${e(`rotate-${key}`)}`]: {
                    transform: `rotate(${value})`
                }
            }
        });

        addUtilities(rotateUtilities);
    }
};