let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/main.js', 'public/js/app.js')
    .less('resources/less/app.less', 'public/css')
    .options({
        postCss: [
            tailwindcss('resources/less/tailwind.js')
        ]
    });

mix.browserSync('192.168.10.10');

mix.disableNotifications();

if (mix.inProduction()) {
    mix.version();
}