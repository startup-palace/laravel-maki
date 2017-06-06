<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface LinkInterface
{
    /**
     * Describe the `object` relation
     * @return MorphTo
     */
    public function object() : MorphTo;

    /**
     * Get the link destination
     * @return string
     */
    public function getHrefAttribute() : string;

    /**
     * Render the HTML code for the link
     * @param  array  $options Options for the link
     * @return string
     */
    public function render() : string;

    /**
     * String representation of the link
     * @return string
     */
    public function __toString() : string;

}
