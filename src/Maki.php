<?php

namespace StartupPalace\Maki;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use StartupPalace\Maki\Contracts\FieldSubsetInterface;
use StartupPalace\Maki\Contracts\FieldValueInterface;
use StartupPalace\Maki\Contracts\PageInterface;
use StartupPalace\Maki\Contracts\SectionInterface;
use StartupPalace\Maki\FieldSubset;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Page;
use StartupPalace\Maki\Section;

class Maki
{
    public static function routes($options = [])
    {
        $defaultOptions = [
            'namespace' => '\StartupPalace\Maki\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) {
            $router->get('{page}', [
                'uses' => 'PageController@show',
                'as' => 'page.show',
            ]);
        });
    }

    public static function adminRoutes($options = [])
    {
        $defaultOptions = [
            'namespace' => '\StartupPalace\Maki\Http\Controllers\Admin',
            'as' => 'admin.',
            'prefix' => 'admin',
            'middleware' => ['web'],
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) {
            $router->resource('page', 'PageController', [
                'only' => ['index', 'store', 'show', 'update', 'destroy'],
            ]);
        });
    }

    public static function containerBindings()
    {
        app()->bind(SectionInterface::class, Section::class);
        app()->bind(FieldValueInterface::class, FieldValue::class);
        app()->bind(PageInterface::class, Page::class);
        app()->bind(FieldSubsetInterface::class, FieldSubset::class);
    }
}
