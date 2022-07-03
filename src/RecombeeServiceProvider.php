<?php

namespace Baron\Recombee;

use Baron\Recombee\Commands\RecombeeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Recombee\RecommApi\Client;

class RecombeeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-recombee')
            ->hasConfigFile()
            ->hasCommand(RecombeeCommand::class);
        
        $this->app->singleton(Client::class, function ($app) {
            $config = $app['config']->get('recombee');

            return new Client($config['database'], $config['secret']);
        });
    }
}
