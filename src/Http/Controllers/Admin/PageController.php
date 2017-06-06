<?php

namespace StartupPalace\Maki\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use StartupPalace\Maki\Http\Requests\Page\StoreRequest;
use StartupPalace\Maki\Http\Requests\Page\UpdateRequest;
use StartupPalace\Maki\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::paginate();

        return response()->json($pages);
    }

    public function show(Page $page)
    {
        $page->load('sections.fieldValues.object', 'sections.fieldSubsets.fieldValues.object');

        return response()->json($page);
    }

    public function store(StoreRequest $request)
    {
        $page = Page::create($request->all());

        return response()->json($page);
    }

    public function update(Page $page, UpdateRequest $request)
    {
        $page->update($request->all());

        return response()->json($page);
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json($page);
    }
}
