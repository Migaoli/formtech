let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');


mix.less('less/app.less', '../../../public/css/formtech.css')
    .options({
        postCss: [
            tailwindcss('less/tailwind.js')
        ]
    });

mix.copy('icons.svg', '../../../public/icons.svg');

mix.copy('static', '../../../public/static');