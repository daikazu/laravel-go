const mix = require('laravel-mix');

mix.browserSync('localhost');

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

mix.js('resources/js/app.js', 'public/js');
mix.sourceMaps();

mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require("tailwindcss"),
    require('autoprefixer'),
]);

mix.options({
    processCssUrls: true,
    autoprefixer: { remove: false }
});
