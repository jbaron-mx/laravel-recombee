<?php

namespace Baron\Recombee;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Baron\Recombee\Commands\RecombeeCommand;

class RecombeeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-recombee')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-recombee_table')
            ->hasCommand(RecombeeCommand::class);
    }
}
