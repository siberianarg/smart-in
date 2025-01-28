const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sourceMaps(false)
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.webpackConfig({
    plugins: [
        new (require('webpack')).DefinePlugin({
            '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': JSON.stringify(false),
        }),
    ],
});