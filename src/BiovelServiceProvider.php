<?php

declare(strict_types=1);

namespace AKM\Biovel;

use AKM\Biovel\Commands\BiovelSyncCommand;
use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BiovelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('biovel')
            ->hasConfigFile()
            ->hasCommand(BiovelSyncCommand::class);
    }

    public function packageRegistered(): void
    {
        // Register singleton untuk kelas Biovel
        $this->app->singleton('biovel', function (Application $app) {
            return new Biovel(
                $app['config']->get('biovel.ip'),
                $app['config']->get('biovel.port')
            );
        });

        $this->app->alias('biovel', Biovel::class);
    }
}
