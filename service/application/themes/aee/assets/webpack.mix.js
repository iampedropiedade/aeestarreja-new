let mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        jquery: 'jQuery',
        bootstrap: true,
    },
});
mix.options({
    fileLoaderDirs:  {
        fonts: '../app/fonts'
    }
});

mix.define({
    __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false
});

mix.setPublicPath('../app');
mix.copyDirectory('images', '../app/images');
// mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', '../app/fonts')
mix.sass('stylesheets/main.scss', '../app/stylesheets/main.css')
mix.js('javascript/main.js', '../app/javascript/main.js').vue()