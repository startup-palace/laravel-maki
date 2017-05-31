<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface PageInterface
{
    /**
     * Describe the `sections` relationship
     * @return BelongsToMany
     */
    public function sections() : BelongsToMany;

    /**
     * Render the page
     * @return string
     */
    public function render() : string;

    /**
     * Convert the page to its string representation.
     * @return string
     */
    public function __toString() : string;
}
