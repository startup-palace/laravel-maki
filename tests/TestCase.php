<?php

namespace StartupPalace\Maki\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Section;

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

    /**
     * Create a default section and its fields
     * @return Section
     */
    protected function createSectionAndFieldValues()
    {
        $section = Section::create([
            'type' => 'default',
        ]);

        $fieldValues = [
            new FieldValue(['field' => 'title', 'data' => 'A simple title']),
            new FieldValue(['field' => 'text', 'data' => 'A simple text']),
            new FieldValue(['field' => 'content', 'data' => '<p>Some content</p>']),
        ];

        $section->fieldValues()->saveMany($fieldValues);

        return $section;
    }
}
