<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\FieldValueInterface;
use StartupPalace\Maki\Contracts\SectionInterface;

/**
 * FieldValue model
 * Table : maki_field_values
 */
class FieldValue extends Model implements FieldValueInterface
{
    use Uuid;

    protected $table = 'maki_field_values';

    protected $fillable = [
        'field', 'data', 'object_id', 'object_type',
    ];

    protected $with = ['object'];

    /**
     * Describe the `owner` relation
     * @return MorphTo
     */
    public function owner() : MorphTo
    {
        return $this->morphTo();
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

    public function getDataAttribute()
    {
        if ($this->isObject()) {
            return $this->object;
        }

        return $this->attributes['data'];
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
     * Determine if a field is link-based
     * @return boolean
     */
    protected function isLink() : bool
    {
        return $this->config['type'] == 'link';
    }

    /**
     * Convert the section to its string representation.
     * @return string
     */
    public function __toString() : string
    {
        if ($this->isLink()) {
            return $this->object->render();
        }

        if ($this->isObject()) {
            return $this->object->entityUrl;
        }

        return $this->data;
    }
}
