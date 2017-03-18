const { mix } = require('laravel-mix');
var webpack = require('webpack');
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

mix.copy('node_modules/materialize-css/fonts/roboto/Roboto-Bold.woff', 'public/fonts/roboto/Roboto-Bold.woff')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Bold.woff2', 'public/fonts/roboto/Roboto-Bold.woff2')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Light.woff', 'public/fonts/roboto/Roboto-Light.woff')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Light.woff2', 'public/fonts/roboto/Roboto-Light.woff2')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Regular.woff', 'public/fonts/roboto/Roboto-Regular.woff')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Regular.woff2', 'public/fonts/roboto/Roboto-Regular.woff2')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Medium.woff', 'public/fonts/roboto/Roboto-Medium.woff')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Medium.woff2', 'public/fonts/roboto/Roboto-Medium.woff2')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Thin.woff', 'public/fonts/roboto/Roboto-Thin.woff')
    .copy('node_modules/materialize-css/fonts/roboto/Roboto-Thin.woff2', 'public/fonts/roboto/Roboto-Thin.woff2');


mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
    
mix.scripts(['resources/assets/js/global.js'], 'public/js/global.js')

mix.sass('resources/assets/sass/public.scss', 'public/css');

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                  'NODE_ENV': JSON.stringify('production')
            }
        }),
    ]
});

if (mix.config.inProduction) {
    mix.version();
    mix.disableNotifications();
}

