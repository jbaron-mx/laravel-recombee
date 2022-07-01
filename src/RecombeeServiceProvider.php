<?php

namespace Baron\Recombee;

use Baron\Recombee\Commands\RecombeeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
