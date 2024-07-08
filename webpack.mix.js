const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/register.scss', 'public/css')
    .sass('resources/sass/user.scss', 'public/css');
