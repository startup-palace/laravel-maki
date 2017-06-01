<?php

namespace StartupPalace\Maki;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\FieldValueInterface;
use StartupPalace\Maki\Contracts\PageInterface;
use StartupPalace\Maki\Contracts\SectionInterface;

/**
 * Section model
 * Table : maki_sections
 */
class Section extends Model implements SectionInterface, Htmlable
{
    use Uuid;

    protected $table = 'maki_sections';

    protected $fillable = [
        'type', 'parent_id',
    ];

    /**
     * Describe the `sections` relation
     * @return HasMany
     */
    public function sections() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Describe the `parentSection` relation
     * @return BelongsTo
     */
    public function parentSection() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Describe the `pages` relation
     * @return BelongsToMany
     */
    public function pages() : BelongsToMany
    {
        return $this->belongsToMany(PageInterface::class, 'maki_page_section');
    }

    /**
     * Describe the `fieldValues` relation
     * @return HasMany
     */
    public function fieldValues() : HasMany
    {
        return $this->hasMany(app()->make(FieldValueInterface::class));
    }

    /**
     * Get the section config depending on its type
     * @return array
     */
    protected function getTypeConfig() : array
    {
        return array_get(config('maki.sectionTypes'), $this->type);
    }

    /**
     * Render the HTML from the view
     * @return HtmlString
     */
    public function render(PageInterface $page = null) : string
    {
        $view = $this->getTemplateName();

        return new HtmlString(
            View::make($view, [
                'fields' => $this->fields,
                'type' => $this->type,
                'context' => $page ? $page->getContext() : [],
            ])->render()
        );
    }

    /**
     * Lists the fields of the section
     * @return array
     */
    public function getFieldsAttribute() : Collection
    {
        $existingFields = $this->fieldValues->keyBy('field');

        return collect($this->getTypeConfig()['fields'])
            ->map(function ($field) use ($existingFields) {
                if ($existingFields->has($field)) {
                    return $existingFields->get($field);
                }

                $fieldValueClass = app()->make(FieldValueInterface::class);

                return new $fieldValueClass(compact('field'));
            })
            ->keyBy('field');
    }

    /**
     * Get the template full name
     * @return string
     */
    public function getTemplateName() : string
    {
        return config('maki.templatePath') . '.sections.' . $this->getTypeConfig()['template'];
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml() : string
    {
        return $this->render();
    }

    /**
     * Convert the section to its string representation.
     * @return string
     */
    public function __toString() : string
    {
        return $this->toHtml();
    }
}
