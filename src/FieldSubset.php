<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\FieldSubsetInterface;
use StartupPalace\Maki\Contracts\FieldValueInterface;
use StartupPalace\Maki\Contracts\SectionInterface;

class FieldSubset extends Model implements FieldSubsetInterface
{
    use Uuid;

    protected $table = 'maki_field_subsets';

    protected $fillable = ['section_id', 'type'];

    /**
     * Describe the `fieldValues` relation
     * @return MorphMany
     */
    public function fieldValues() : MorphMany
    {
        return $this->morphMany(app()->make(FieldValueInterface::class), 'owner');
    }

    /**
     * Describe the `section` relation
     * @return BelongsTo
     */
    public function section() : BelongsTo
    {
        return $this->belongsTo(app()->make(SectionInterface::class));
    }

    /**
     * Get config for the current FieldSubset type
     * @return array
     */
    public function getConfig() : array
    {
        return $this->section->getConfig('fieldSubsets.' . $this->type);
    }

    /**
     * Get subset's field values, keyed by type
     * @return Collection
     */
    public function getFieldsAttribute() : Collection
    {
        return $this->fieldValues()
            ->get()
            ->keyBy('field');
    }
}
