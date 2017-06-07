<?php

namespace StartupPalace\Maki;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\MakiEntityInterface;
use StartupPalace\Maki\Contracts\PageInterface;
use StartupPalace\Maki\Contracts\SectionInterface;
use StartupPalace\Maki\Traits\MakiEntityTrait;

class Page extends Model implements PageInterface, MakiEntityInterface
{
    use Uuid, MakiEntityTrait;

    protected $table = 'maki_pages';

    protected $fillable = [
        'published_at', 'title', 'slug', 'unique_id',
    ];

    protected $dates = ['published_at'];

    protected $context = [];

    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    public function sections() : BelongsToMany
    {
        return $this->belongsToMany(app()->make(SectionInterface::class), 'maki_page_section');
    }

    public function render() : string
    {
        $this->load('sections.fieldValues.object', 'sections.fieldSubsets.fieldValues.object');

        return $this->sections->reduce(function ($carry, $section) {
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
        array_set($this->context, 'previous', $section);

        return $this->context;
    }

    public function applyContextUpdate($callback)
    {
        $this->context = $callback($this->context);
    }

    public function getContext() : array
    {
        return $this->context;
    }

    public function getEntityRouteParameters() : array
    {
        return [$this->slug];
    }

    public function getShowRouteName() : string
    {
        return 'page.show';
    }

    public static function getEntityName() : string
    {
        return 'page';
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
