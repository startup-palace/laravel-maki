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

    public function getConfigAttribute() : array
    {
        return config('maki.fields')[$this->field];
    }

    public function renderData()
    {
        if ($this->type === 'object') {
            return $this->object;
        }

        return $this->data;
    }

    public function __toString() : string
    {
        return (string) $this->renderData();
    }
}
