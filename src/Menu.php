<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\MenuInterface;
use StartupPalace\Maki\Contracts\MenuItemInterface;

class Menu extends Model implements MenuInterface
{
    use Uuid;

    protected $table = 'maki_menus';

    protected $fillable = [
        'title', 'description', 'type',
    ];

    public function menuItems() : MorphMany
    {
        return $this->morphMany(app(MenuItemInterface::class), 'parent');
    }
}
