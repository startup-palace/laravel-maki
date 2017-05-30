<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as BaseTestCase;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Link;
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

        $link = $this->createSimpleLink();

        $fieldValues = [
            new FieldValue(['field' => 'title', 'data' => 'A simple title']),
            new FieldValue(['field' => 'text', 'data' => 'A simple text']),
            new FieldValue(['field' => 'content', 'data' => '<p>Some content</p>']),
            new FieldValue(['field' => 'button', 'object_id' => $link->id, 'object_type' => Link::class]),
        ];

        $section->fieldValues()->saveMany($fieldValues);

        return $section;
    }

    protected function newCategory() : Category
    {
        $category = new Category([
            'name' => 'My category',
            'slug' => 'my-category',
        ]);

        return $category;
    }

    protected function newSimpleLink()
    {
        return new Link([
            'text' => 'The content of the link tag',
            'title' => 'The title attribute',
            'url' => 'https://github.com',
        ]);
    }

    protected function createSimpleLink()
    {
        $link = $this->newSimpleLink();
        $link->save();

        return $link;
    }
}
