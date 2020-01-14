let mix = require('laravel-mix');
require('laravel-mix-purgecss');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js/statamic-butik.js')
    .postCss('resources/css/statamic-butik.css', 'public/css', [
        tailwindcss('tailwind.config.js')
    ]);

// TODO: Add purge css for production
// if (mix.inProduction()) {
//     mix.purgeCss();
// }
