const mix = require('laravel-mix');

mix.js('Resources/assets/js/app.js', 'public/js')
   .sass('Resources/assets/sass/app.scss', 'public/css');