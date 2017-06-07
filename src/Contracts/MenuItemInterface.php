<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface MenuItemInterface
{
    /**
     * Describe the `parent` relation
     * @return MorphTo
     */
    public function parent() : MorphTo;

    /**
     * Describe the `menuItems` relation
     * @return MorphMany
     */
    public function menuItems() : MorphMany;

    /**
     * Describe the `link` relation
     * @return BelongsTo
     */
    public function link() : BelongsTo;
}
