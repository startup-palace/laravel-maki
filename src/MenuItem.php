<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\LinkInterface;
use StartupPalace\Maki\Contracts\MenuInterface;
use StartupPalace\Maki\Contracts\MenuItemInterface;

class MenuItem extends Model implements MenuItemInterface
{
    use Uuid;

    protected $table = 'maki_menu_items';

    protected $fillable = [
        'title', 'parent_id', 'link_id',
    ];

    /**
     * Describe the `parent` relation
     * @return MorphTo
     */
    public function parent() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Describe the `menuItems` relation
     * @return MorphMany
     */
    public function menuItems() : MorphMany
    {
        return $this->morphMany(app(MenuItemInterface::class), 'parent');
    }

    /**
     * Describe the `link` relation
     * @return BelongsTo
     */
    public function link() : BelongsTo
    {
        return $this->belongsTo(app(LinkInterface::class));
    }

    /**
     * Get the menu item's title, depending on its type (link or sub-menu)
     * @return string
     */
    public function getTitleAttribute() : string
    {
        if (empty($this->attributes['title']) && $this->link) {
            return $this->link->text;
        }

        return $this->attributes['title'];
    }
}
