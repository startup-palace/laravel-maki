<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

interface SectionInterface
{
    /**
     * Describe the `sections` relation
     * @return HasMany
     */
    public function sections() : HasMany;

    /**
     * Describe the `parentSection` relation
     * @return BelongsTo
     */
    public function parentSection() : BelongsTo;

    /**
     * Describe the `pages` relation
     * @return BelongsToMany
     */
    public function pages() : BelongsToMany;

    /**
     * Describe the `fieldValues` relation
     * @return HasMany
     */
    public function fieldValues() : HasMany;

    /**
     * Render the HTML from the view
     * @return HtmlString
     */
    public function render() : string;

    /**
     * Lists the fields of the section
     * @return array
     */
    public function getFieldsAttribute() : Collection;

    /**
     * Get the template full name
     * @return string
     */
    public function getTemplateName() : string;

    /**
     * Convert the section to its string representation.
     * @return string
     */
    public function __toString() : string;
}
