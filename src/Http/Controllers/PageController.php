<?php

namespace StartupPalace\Maki\Http\Controllers;

use Illuminate\Routing\Controller;
use StartupPalace\Maki\Contracts\PageInterface;

class PageController extends Controller
{
    public function show($page)
    {
        $builder = call_user_func([app()->make(PageInterface::class), 'newQuery']);

        $page = $builder->where($builder->getModel()->getRouteKeyName(), $page)
            ->firstOrFail();

        $view = config('maki.templatePath') . '.page';

        return view($view, compact('page'));
    }
}
