<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface FieldSubsetInterface
{
    /**
     * Describe the `fieldValues` relation
     * @return MorphMany
     */
    public function fieldValues() : MorphMany;

    /**
     * Describe the `section` relation
     * @return BelongsTo
     */
    public function section() : BelongsTo;

    /**
     * Get config for the current FieldSubset type
     * @return array
     */
    public function getConfig() : array;

    /**
     * Get subset's field values, keyed by type
     * @return Collection
     */
    public function getFieldsAttribute() : Collection;

}
