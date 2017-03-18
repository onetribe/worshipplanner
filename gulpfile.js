const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Bold.woff', 'public/fonts/roboto/Roboto-Bold.woff')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Bold.woff2', 'public/fonts/roboto/Roboto-Bold.woff2')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Light.woff', 'public/fonts/roboto/Roboto-Light.woff')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Light.woff2', 'public/fonts/roboto/Roboto-Light.woff2')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Regular.woff', 'public/fonts/roboto/Roboto-Regular.woff')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Regular.woff2', 'public/fonts/roboto/Roboto-Regular.woff2')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Medium.woff', 'public/fonts/roboto/Roboto-Medium.woff')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Medium.woff2', 'public/fonts/roboto/Roboto-Medium.woff2')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Thin.woff', 'public/fonts/roboto/Roboto-Thin.woff')
       .copy('node_modules/materialize-css/fonts/roboto/Roboto-Thin.woff2', 'public/fonts/roboto/Roboto-Thin.woff2')
       .webpack('app.js');

      mix.sass('public.scss');
});
