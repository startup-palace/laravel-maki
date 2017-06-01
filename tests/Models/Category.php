<?php

namespace StartupPalace\Maki\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\MakiEntityInterface;
use StartupPalace\Maki\Traits\MakiEntityTrait;

class Category extends Model implements MakiEntityInterface
{
    use Uuid, MakiEntityTrait;

    protected $fillable = [
        'name', 'slug',
    ];

    public function getShowRouteName() : string
    {
        return 'category.show';
    }

    public function getEntityRouteParameters() : array
    {
        return [$this->slug];
    }

    public static function getEntityName() : string
    {
        return 'category';
    }
}
