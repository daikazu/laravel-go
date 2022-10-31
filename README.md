<p align="center">
    <img src="https://repository-images.githubusercontent.com/330531629/87ef0400-590c-11eb-8bae-9f0713476087" alt="Envault banner" style="width: 100%; max-width: 800px;" />
</p>





[![Latest Version on Packagist](https://img.shields.io/packagist/v/daikazu/laravel-go.svg?style=flat-square)](https://packagist.org/packages/daikazu/laravel-go)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/daikazu/laravel-go/run-tests?label=tests)](https://github.com/daikazu/laravel-go/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/daikazu/laravel-go/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/daikazu/laravel-go/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/daikazu/laravel-go.svg?style=flat-square)](https://packagist.org/packages/daikazu/laravel-go)



# Laravel Go =>

### Introduction

If you are like me and find yourself repeating the same steps everytime when starting to build a new site with Laravel,
then look no further. Get up and GO with this light yet highly opinionated package for developing websites using the
TALL stack. It helps you set up some view folder organization and a few sensible packages to get you started. Not to
mention a sweet page build artisan command.

The idea behind this package is to install, use, and then remove.

So what are you waiting for, get GOing!

Feel free to give input and suggestions to our [discussion board](https://github.com/daikazu/laravel-go/discussions).


## Installation

You can install the package via composer:

```bash
composer require daikazu/laravel-go --dev
```

## Usage


### One Time Install

Create a `go-packages.json` file in you project root folder or use the following artisan command to create it for you.

``` bash
php artisan go:init
```

THe created file will look as follows:
```json
{
    "composer_packages": {
        "require": {},
        "require-dev": {}
    },
    "npm_packages": {
        "dependencies": {},
        "devDependencies": {}
    }
}
```
Add any additional packages you would like to install in your setup or copy and paste the following starter packages.

>Additionally, you can add the `-d` or the `--default` flags when running the `go:init` command to add the following automatically.

```json
{
    "composer_packages": {
        "require": {
            "artesaos/seotools": "^0.22.1",
            "daikazu/laravel-glider": "^2.0.1",
            "illuminatech/url-trailing-slash": "*",
            "livewire/livewire": "^2.10.6",
            "spatie/laravel-google-fonts": "^1.2",
            "spatie/laravel-backup": "^8.0",
            "spatie/laravel-sitemap": "^6.2",
            "spatie/schema-org": "^3.11"
        }
    },
    "npm_packages": {
        "dependencies": {},
        "devDependencies": {
            "@alpinejs/collapse": "^3.10.3",
            "@alpinejs/focus": "^3.10.3",
            "@alpinejs/intersect": "^3.10.3",
            "@alpinejs/persist": "^3.10.3",
            "@defstudio/vite-livewire-plugin": "^0.2.4",
            "@prettier/plugin-php": "^0.18.9",
            "@shufo/prettier-plugin-blade": "^1.4.22",
            "@tailwindcss/aspect-ratio": "^0.4.0",
            "@tailwindcss/forms": "^0.5.2",
            "@tailwindcss/typography": "^0.5.4",
            "alpinejs": "^3.10.3",
            "autoprefixer": "^10.4.8",
            "axios": "^0.27.2",
            "laravel-vite-plugin": "^0.5.2",
            "lodash": "^4.17.21",
            "postcss": "^8.4.14",
            "prettier": "^2.7.1",
            "prettier-plugin-tailwindcss": "^0.1.13",
            "tailwindcss": "^3.1.7",
            "tailwindcss-debug-screens": "^2.2.1",
            "vite": "^3.0.4"
        }
    }
}

```

install the initial scaffolding by running the following `artisan` command.

``` bash
php artisan go:install
```

> Additionally, you can add the `-d` or the `--default` flags the `go:install` command, and it will auto initialize with the default packages


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
├── .prettierrc
├── postcss.config.js
├── tailwind.config.js
└── vite.config.js
```

Install composer dependencies

``` bash
composer update
```

Install node dependencies and build your assets

``` bash
npm install && npm run dev
```

> We recommend using [pnpm](https://pnpm.io) instead of the default `npm`.


Don't forget to change configs and add environment variable as needed.

### Static Page Creation Tool

Quickly create a static page using the following command. Creates `blade.php` file and adds entry into your routes files.

```bash
php artisan go:make-static my-page mycustomname
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
php artisan go:make-static post/comments/
/resources/views/web/sections/static/post/comments.index.blade.php
```

Created file: `/resources/views/web/sections/static/post/comments.index.blade.php`

```php
Route::view('post/comments/', 'web.sections.static.post.comments.index')->name('post.comments.index');
```

### Website Duplication Tool

Crawl and Duplicate an existing website to the Laravel-Go way of things. Currently, a work in progress but is mostly feature complete.
this will crawl and scrape the website creating routes, views, and assets. 
use the optional `--fileter=` flag to filter out any unwanted URIs.

```bash
php artisan go:duplicate https://example.test --filter=/blog,/image
````
This will copy the main header and footer from the website and create a `header.blade.php` and `footer.blade.php` file in the `resources/views/web/layout/` folder 
and remove the `<header>` and `<footer>` from any page that has them. All other page content will be copied into its own `blade.php` file in the `resources/views/web/sections/static/` folder and placed between the `main` section directives.

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
- [lodash](https://lodash.com)
- [postcss]()
- [tailwindcss-filters](https://github.com/benface/tailwindcss-filters)
- [tailwindcss](https://tailwindcss.com)


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mike Wall](https://github.com/daikazu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
