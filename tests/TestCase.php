<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as BaseTestCase;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Section;
use StartupPalace\Maki\Tests\Models\Category;

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

        $this->addViewLocations();

        $this->addRoutes();
    }


    protected function addViewLocations()
    {
        View::addLocation(__DIR__ . '/../resources/views');
        View::addLocation(__DIR__ . '/resources/views');
    }

    protected function addRoutes()
    {
        Route::bind('category', function ($categorySlug) {
            return Category::where('slug', $categorySlug)
                ->firstOrFail();
        });

        Route::get('category/{category}', [
            'as' => 'category.show',
            'uses' => function ($category) {
                return response()->json(compact('category'));
            }
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \StartupPalace\Maki\ServiceProvider::class,
            \TwigBridge\ServiceProvider::class,
        ];
    }

    protected function createSection() : Section
    {
        $section = Section::create([
            'type' => 'default',
        ]);

        return $section;
    }

    /**
     * Create a default section and its fields
     * @return Section
     */
    protected function createSectionAndFieldValues() : Section
    {
        $section = $this->createSection();

        $fieldValues = [
            new FieldValue(['field' => 'title', 'data' => 'A simple title']),
            new FieldValue(['field' => 'text', 'data' => 'A simple text']),
            new FieldValue(['field' => 'content', 'data' => '<p>Some content</p>']),
        ];

        $section->fieldValues()->saveMany($fieldValues);

        return $section;
    }

    public function newCategory() : Category
    {
        $category = new Category([
            'name' => 'My category',
            'slug' => 'my-category',
        ]);

        return $category;
    }
}
