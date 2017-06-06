<?php

namespace StartupPalace\Maki\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use StartupPalace\Maki\Contracts\PageInterface;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $pageClass = app(PageInterface::class);

        return [
            'title' => ['required'],
            'slug' => [
                'required',
                'string',
                Rule::unique(
                    with(new $pageClass)->getTable(),
                    'slug'
                )
            ],
            'published_at' => ['date'],
            'unique_id' => [
                Rule::unique(
                    with(new $pageClass)->getTable(),
                    'unique_id'
                )
            ],
        ];
    }
}
