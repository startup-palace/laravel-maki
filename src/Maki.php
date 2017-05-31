<?php

namespace StartupPalace\Maki;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

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
}
