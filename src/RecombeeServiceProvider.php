<?php

namespace Baron\Recombee;

use Baron\Recombee\Commands\RecombeeCommand;
use Recombee\RecommApi\Client;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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

            return new Client($config['database'], $config['token'], [
                'region' => $config['region'],
            ]);
        });
    }
}
