const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js');
mix.sourceMaps();

mix.postCss('resources/css/app.css', 'public/css/app.css', [
    require('postcss-import'),
    require('postcss-nested'),
    require('tailwindcss'),
    require('postcss-focus-visible'),
    require('autoprefixer'),
])

mix.options({
    processCssUrls: true,
    autoprefixer: { remove: false }
});


mix.browserSync(process.env.APP_URL)

mix.disableSuccessNotifications();

if (mix.inProduction()) {
    mix.version();
}

mix.override((webpackConfig) => {
    webpackConfig.resolve.modules = [
        "node_modules",
        // __dirname + "/vendor/spatie/laravel-medialibrary-pro/resources/js",
    ];
});
