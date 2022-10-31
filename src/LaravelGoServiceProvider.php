<?php

namespace Daikazu\LaravelGo;

use Daikazu\LaravelGo\Commands\DuplicateWebsiteCommand;
use Daikazu\LaravelGo\Commands\InitCommand;
use Daikazu\LaravelGo\Commands\InstallCommand;
use Daikazu\LaravelGo\Commands\StaticPageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelGoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-go')
//            ->hasConfigFile()
//            ->hasViews()
//            ->hasMigration('create_laravel-go_table')
            ->hasCommands([
                InitCommand::class,
                InstallCommand::class,
                StaticPageCommand::class,
                DuplicateWebsiteCommand::class,
            ]);
    }
}
