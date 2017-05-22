<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;

class FieldValue extends Model
{
    use Uuid;

    protected $fillable = [
        'section_id', 'field', 'data',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function object()
    {
        return $this->morphTo();
    }
}
