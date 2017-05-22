<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\FieldValue;

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
        return $this->hasMany(FieldValue::class);
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
     * Get fields informations depending on the section type
     * @return array
     */
    public function getFieldsAttribute() : array
    {
        return array_reduce(
            $this->getTypeConfig()['fields'],
            function ($acc, $field) {
                $acc[$field] = config('maki.fields.' . $field);

                return $acc;
            },
            []
        );
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
