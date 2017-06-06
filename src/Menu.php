<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function menuItems() : HasMany
    {
        return $this->hasMany(MenuItemInterface::class);
    }
}
