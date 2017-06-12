<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\MenuInterface;
use StartupPalace\Maki\Contracts\MenuItemInterface;
use StartupPalace\Maki\Contracts\PageInterface;

class Menu extends Model implements MenuInterface
{
    use Uuid;

    protected $table = 'maki_menus';

    protected $fillable = [
        'title', 'slug', 'description', 'type',
    ];

    /**
     * Describe the `menuItems` relation
     * @return MorphMany
     */
    public function menuItems() : MorphMany
    {
        return $this->morphMany(app(MenuItemInterface::class), 'parent');
    }

    /**
     * Render the menu
     * @param  PageInterface|null $page
     * @return HtmlString
     */
    public function render(PageInterface $page = null) : HtmlString
    {
        return new HtmlString(
            View::make($this->getTemplateName(), [
                'menu' => $this,
                'page' => $page,
            ])->render()
        );
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

    /**
     * Get the template name for the menu
     * @return string
     */
    public function getTemplateName() : string
    {
        return config('maki.templatePath') . '.' . $this->getConfig('template');
    }

    public function __toString()
    {
        return (string) $this->render();
    }
}
