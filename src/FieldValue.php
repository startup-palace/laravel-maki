<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kblais\Uuid\Uuid;

/**
 * FieldValue model
 * Table : field_values
 */
class FieldValue extends Model
{
    use Uuid;

    protected $fillable = [
        'section_id', 'field', 'data',
    ];

    protected $with = ['object'];

    /**
     * Describe the `section` relation
     * @return BelongsToMany
     */
    public function section() : BelongsToMany
    {
        return $this->belongsTo(config('maki.sectionClass'));
    }

    /**
     * Describe the `object` relation
     * @return MorphTo
     */
    public function object() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the config for this type of field
     * @return array
     */
    public function getConfigAttribute() : array
    {
        return config('maki.fields')[$this->field];
    }

    /**
     * Return data depending on the field type
     * @return Object | string
     */
    public function renderData()
    {
        if ($this->isObject()) {
            return $this->object;
        }

        return $this->data;
    }

    /**
     * Determine if a field value is object-based
     * @return boolean
     */
    protected function isObject() : bool
    {
        return $this->object !== null;
    }

    /**
     * Convert the section to its string representation.
     * @return string
     */
    public function __toString() : string
    {
        if ($this->isObject()) {
            return $this->object->entityUrl;
        }

        return $this->renderData();
    }
}
