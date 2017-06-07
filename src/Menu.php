<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\MenuInterface;
use StartupPalace\Maki\Contracts\MenuItemInterface;
use StartupPalace\Maki\Contracts\PageInterface;

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

    /**
     * Get the config for the current menu type
     * @param  string $key Config key you want to get
     * @return array | string
     */
    public function getConfig($key = null)
    {
        $config = config("maki.menus.{$this->type}");

        if ($key) {
            return array_get($config, $key);
        }

        return $config;
    }

    public function getTemplateName()
    {
        return config('maki.templatePath') . '.' . $this->getConfig('template');
    }
}
