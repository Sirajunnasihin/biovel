<?php

namespace AKM\Biovel\Tests;

use AKM\Biovel\BiovelServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'AKM\\Biovel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // Atur konfigurasi untuk package
        config([
            'biovel.ip' => '192.168.1.201',
            'biovel.port' => 4370,
            'database.default' => 'testing',
            'database.connections.testing' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            BiovelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // Konfigurasi database untuk testing
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
