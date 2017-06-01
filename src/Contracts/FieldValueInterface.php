<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface FieldValueInterface
{
    /**
     * Describe the `owner` relation
     * @return MorphTo
     */
    public function owner() : MorphTo;

    /**
     * Describe the `object` relation
     * @return MorphTo
     */
    public function object() : MorphTo;

    /**
     * Get the config for this type of field
     * @return array
     */
    public function getConfigAttribute() : array;

    /**
     * Get field value data, depending on the type of the field
     * @return mixed
     */
    public function getDataAttribute();

    /**
     * Convert the section to its string representation.
     * @return string
     */
    public function __toString() : string;
}
