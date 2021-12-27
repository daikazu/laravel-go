<p align="center">
    <img src="https://repository-images.githubusercontent.com/330531629/87ef0400-590c-11eb-8bae-9f0713476087" alt="Envault banner" style="width: 100%; max-width: 800px;" />
</p>

<p align="center">
    <a href="https://packagist.org/packages/daikazu/laravel-go">
        <img src="https://img.shields.io/packagist/dt/daikazu/laravel-go?style=flat-square" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/daikazu/laravel-go">
        <img src="https://img.shields.io/packagist/v/daikazu/laravel-go?style=flat-square" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/daikazu/laravel-go">
        <img src="https://img.shields.io/packagist/l/daikazu/laravel-go?style=flat-square" alt="License">
    </a>
</p>

# Laravel Go =>

## Introduction

If you are like me and find yourself repeating the same steps everytime when starting to build a new site with Laravel,
then look no further. Get up and GO with this light yet highly opinionated package for developing websites using the
TALL stack. It helps you set up some view folder organization and a few sensible packages to get you started. Not to
mention a sweet page build artisan command.

The idea behind this package is to install, use, and then remove 

So what are you waiting for, get GOing!

Feel free to give input and suggestions to our [discussion board](https://github.com/daikazu/laravel-go/discussions).

Want to contribute? Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require daikazu/laravel-go --dev
```

## Usage

### One Time Install

Create a `go-packages.json` file in you project root folder and copy and paste the following starter packages.

Add any additional packages you would like to install in your setup.

```json
{
    "composer_packages": {
        "artesaos/seotools": "^0.20.2",
        "daikazu/laravel-glider": "^1.0.0",
        "illuminatech/url-trailing-slash": "*",
        "livewire/livewire": "^2.8",
        "spatie/laravel-google-fonts": "^1.0.0",
        "spatie/laravel-backup": "^7.7",
        "spatie/laravel-sitemap": "^6.0",
        "spatie/schema-org": "^3.8"
    },
    "npm_packages": {
        "@alpinejs/collapse": "^3.7.1",
        "@alpinejs/intersect": "^3.7.1",
        "@alpinejs/persist": "^3.7.1",
        "@alpinejs/trap": "^3.7.1",
        "@tailwindcss/aspect-ratio": "^0.4.0",
        "@tailwindcss/forms": "^0.4.0",
        "@tailwindcss/typography": "^0.5.0",
        "alpinejs": "^3.7.1",
        "autoprefixer": "^10.4.0",
        "axios": "^0.24.0",
        "browser-sync": "^2.27.7",
        "browser-sync-webpack-plugin": "^2.3.0",
        "cross-env": "^7.0.3",
        "focus-visible": "^5.2.0",
        "laravel-mix": "^6.0.39",
        "postcss": "^8.4.5",
        "postcss-focus-visible": "^6.0.2",
        "postcss-import": "^14.0.2",
        "postcss-nested": "^5.0.6",
        "resolve-url-loader": "^4.0.0",
        "tailwindcss": "^3.0.7",
        "tailwindcss-debug-screens": "^2.2.1"
    }
}

```







install the initial scaffolding by running the following `artisan` command.

``` bash
$ php artisan go:install
```

***NOTE*** this command should only be run once. A repeated run will overwrite any modified files.

this will prompt you for a site name and scaffold out the following files.

```bash
.
├── app
│   ├── Console
│   │   ├── Commands
│   │   │   └── GenerateSitemap.php
│   │   └── Kernel.php
│   └── View
│       └── Components
│           └── MetaData.php
├── config
│   ├── backup.php
│   ├── feed.php
│   ├── filesystems.php
│   ├── seotools.php
│   ├── sitemap.php
│   └── website.php
├── resources
│   ├── css
│   │   └── app.css
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views
│       └── web
│           ├── layout
│           │   ├── footer.blade.php
│           │   ├── head
│           │   │   ├── favicon.blade.php
│           │   │   ├── fonts.blade.php
│           │   │   ├── meta-data.blade.php
│           │   │   ├── scripts.blade.php
│           │   │   ├── styles.blade.php
│           │   │   └── tracking.blade.php
│           │   ├── head.blade.php
│           │   └── header.blade.php
│           ├── layout.blade.php
│           └── sections
│               └── static
│                   └── home.blade.php
├── routes
│   └── web.php
├── .gitignore
├── tailwind.config.js
└── webpack.mix.js
```

Install composer dependencies

``` bash
$ composer update
```

Install node dependencies and build your assets

``` bash
$ npm install && npm run dev
```

Don't forget to change configs and add environment variable as needed. 


### Static Page Creation Tool

Quickly create a static page using the following command. Creates `blade.php` file and adds entry into your routes files.

```bash
$ php artisan go:make-static my-page mycustomname
```
This will create a `my-page.blade.php` in the `resources/views/web/sections/static/` folder

An entry is added to your `web.php` routes file.
```php
Route::view('my-page', 'web.sections.static.my-page')->name('my-page');
```
#### Options

| Option        | Required | Description      |
|---------------|----------| -----------------|
| path          | true     | URL              |
| name          | false    | View name        |
| --title=      | false    | Meta Title       |
| --description | false    | Meta Description |

by appending a `/` or `/index` at the end of your path you tell the command to make and `index.blade.php` file in the appropriate folder.

Example:
```bash
$ php artisan go:make-static post/comments/
/resources/views/web/sections/static/post/comments.index.blade.php
```

Created file: `/resources/views/web/sections/static/post/comments.index.blade.php`

```php
Route::view('post/comments/', 'web.sections.static.post.comments.index')->name('post.comments.index');
```

## Default Packages

### Composer

#### Installed

- [artesaos/seotools](https://github.com/artesaos/seotools)
- [illuminatech/url-trailing-slash](https://github.com/illuminatech/url-trailing-slash)
- [livewire/livewire](https://github.com/livewire/livewire)
- [predis/predis](https://github.com/predis/predis)
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup)
- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
- [spatie/schema-org](https://github.com/spatie/schema-org)
- [symfony/yaml](https://symfony.com/components/Yaml)

#### Recommended

- [blade-ui-kit/blade-heroicons](https://github.com/blade-ui-kit/blade-heroicons)
- [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons)
- [blade-ui-kit/blade-ui-kit](https://blade-ui-kit.com)
- [diglactic/laravel-breadcrumbs](https://github.com/diglactic/laravel-breadcrumbs)
- [laravel/breeze](https://github.com/laravel/breeze)
- [laravel/jetstream](https://github.com/laravel/jetstream)
- [lukeraymonddowning/honey](https://github.com/lukeraymonddowning/honey)
- [propaganistas/laravel-phone](https://github.com/Propaganistas/Laravel-Phone)
- [protonemedia/laravel-analytics-event-tracking](https://github.com/protonemedia/laravel-analytics-event-tracking)
- [spatie/laravel-cookie-consent](https://github.com/spatie/laravel-cookie-consent)
- [spatie/laravel-feed](https://github.com/spatie/laravel-feed)
- [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary)
- [spatie/laravel-missing-page-redirector](https://github.com/spatie/laravel-missing-page-redirector)
- [spatie/laravel-newsletter](https://github.com/spatie/laravel-newsletter)

### NPM

- [@tailwindcss/forms](https://github.com/tailwindlabs/tailwindcss-forms)
- [@tailwindcss/typography](https://github.com/tailwindlabs/tailwindcss-typography)
- [alpinejs](https://github.com/alpinejs/alpine)
- [autoprefixer](https://github.com/postcss/autoprefixer)
- [axios](https://github.com/axios/axios)
- [browser-sync-webpack-plugin](github.com/Va1/browser-sync-webpack-plugin)
- [browser-sync](https://github.com/BrowserSync/browser-sync)
- [color](github.com/Qix-/color)
- [cross-env]()
- [laravel-mix](github.com/JeffreyWay/laravel-mix)
- [lodash](https://lodash.com)
- [postcss-import]()
- [postcss]()
- [resolve-url-loader]()
- [sass-loader]()
- [sass]()
- [tailwindcss-filters](https://github.com/benface/tailwindcss-filters)
- [tailwindcss](https://tailwindcss.com)

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Mike Wall](https://github.com/daikazu)
- [All Contributors][link-contributors]

## License

Laravel Go is open-sourced software licensed under the [MIT license](LICENSE.md).

[ico-version]: https://img.shields.io/packagist/v/daikazu/laravel-go.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/daikazu/laravel-go.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/daikazu/laravel-go/master.svg?style=flat-square

[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/daikazu/laravel-go

[link-downloads]: https://packagist.org/packages/daikazu/laravel-go

[link-travis]: https://travis-ci.org/daikazu/laravel-go

[link-styleci]: https://styleci.io/repos/12345678

[link-author]: https://github.com/daikazu

[link-contributors]: ../../contributors
