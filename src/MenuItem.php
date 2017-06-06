<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\LinkInterface;
use StartupPalace\Maki\Contracts\MenuInterface;
use StartupPalace\Maki\Contracts\MenuItemInterface;

class MenuItem extends Model implements MenuItemInterface
{
    use Uuid;

    protected $table = 'maki_menu_items';

    protected $fillable = [
        'title', 'menu_id', 'parent_id', 'link_id',
    ];

    public function menu() : BelongsTo
    {
        return $this->belongsTo(MenuInterface::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(MenuItemInterface::class);
    }

    public function menuItems() : HasMany
    {
        return $this->hasMany(MenuItemInterface::class, 'parent_id');
    }

    public function link() : BelongsTo
    {
        return $this->belongsTo(LinkInterface::class);
    }
}
