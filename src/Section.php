<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Kblais\Uuid\Uuid;

/**
 * Section model
 * Table : sections
 */
class Section extends Model
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
     * Lists the fields of the section
     * @return array
     */
    public function getFieldsAttribute() : Collection
    {
        $existingFields = $this->fieldValues->keyBy('field');

        return collect($this->getTypeConfig()['fields'])
            ->map(function ($field) use ($existingFields) {
                if (array_key_exists($field, $existingFields)) {
                    return $existingFields[$field];
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
}
