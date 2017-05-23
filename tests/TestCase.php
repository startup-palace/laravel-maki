<?php

namespace StartupPalace\Maki\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        \View::addLocation(__DIR__ . '/../resources/views');
        \View::addLocation(__DIR__ . '/resources/views');
    }

    protected function getPackageProviders($app)
    {
        return [
            \StartupPalace\Maki\ServiceProvider::class,
            \TwigBridge\ServiceProvider::class,
        ];
    }
}
