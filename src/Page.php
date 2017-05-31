<?php

namespace StartupPalace\Maki;

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
        return view(
            config('maki.templatePath') . '.page',
            ['page' => $this]
        );
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
