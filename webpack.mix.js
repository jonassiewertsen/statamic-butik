let mix = require('laravel-mix');
require('laravel-mix-purgecss');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js/statamic-butik.js')
    .postCss('resources/css/statamic-butik.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'),
        require('postcss-preset-env')({stage: 0})
    ]);

if (mix.inProduction()) {
    mix.purgeCss({
        content: [
            "resources/views/**/*.html"
        ]
    });
}
