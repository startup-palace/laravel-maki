<?php

namespace StartupPalace\Maki\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use StartupPalace\Maki\Contracts\PageInterface;

class PageController extends Controller
{
    public function show(string $page) : View
    {
        $page = $this->findPageByRouteKey($page);

        $view = config('maki.templatePath') . '.page';

        return view($view, compact('page'));
    }

    protected function findPageByRouteKey(string $routeKey) : PageInterface
    {
        $builder = call_user_func([app()->make(PageInterface::class), 'newQuery']);

        return $builder->where($builder->getModel()->getRouteKeyName(), $routeKey)
            ->firstOrFail();
    }
}
