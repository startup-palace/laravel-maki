<?php

namespace StartupPalace\Maki;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Kblais\Uuid\Uuid;

/**
 * Section model
 * Table : sections
 */
class Section extends Model implements Htmlable
{
    use Uuid;

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
     * Describe the `fieldValues` relation
     * @return HasMany
     */
    public function fieldValues() : HasMany
    {
        return $this->hasMany(config('maki.fieldValueClass'));
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
    public function render() : string
    {
        $view = $this->getTemplateName();

        return new HtmlString(
            View::make($view, [
                'section' => $this,
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

                $fieldValueClass = config('maki.fieldValueClass');

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
        return config('maki.templatePath') . '.' . $this->getTypeConfig()['template'];
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml() : string
    {
        return (string) $this->render();
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
