<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\HtmlString;
use StartupPalace\Maki\Contracts\PageInterface;

interface MenuInterface
{
    /**
     * Describe the `menuItems` relation
     * @return MorphMany
     */
    public function menuItems() : MorphMany;

    /**
     * Render the menu
     * @param  PageInterface|null $page
     * @return HtmlString
     */
    public function render(PageInterface $page = null) : HtmlString;

    /**
     * Get the config for the current menu type
     * @param  string $key Config key you want to get
     * @return array | string
     */
    public function getConfig($key = null);

    /**
     * Get the template name for the menu
     * @return string
     */
    public function getTemplateName() : string;
}
