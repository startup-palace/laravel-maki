<?php

namespace StartupPalace\Maki;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\PageInterface;
use StartupPalace\Maki\Contracts\SectionInterface;

class Page extends Model implements PageInterface
{
    use Uuid;

    protected $fillable = [
        'published_at', 'title', 'slug',
    ];

    protected $dates = ['published_at'];

    protected $context = [];

    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    public function sections() : BelongsToMany
    {
        return $this->belongsToMany(app()->make(SectionInterface::class));
    }

    public function render() : string
    {
        return $this->sections->reduce(function ($carry, $section) {
            $this->refreshContext($section);

            return $carry . "\n" . $section->render($this);
        }, '');
    }

    public function renderView() : View
    {
        return view(
            config('maki.templatePath') . '.page',
            ['page' => $this]
        );
    }

    public function refreshContext(SectionInterface &$section) : array
    {
        $this->context = [
            'previous' => array_get($this->context, 'current', null),
            'current' => $section,
        ];

        return $this->context;
    }

    public function getContext() : array
    {
        return $this->context;
    }

    /**
     * Convert the page to its string representation.
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
