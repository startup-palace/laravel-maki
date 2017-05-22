<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\FieldValue;

class Section extends Model
{
    use Uuid;

    protected $fillable = [
        'type', 'parent_id',
    ];

    public function sections()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parentSection()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function fieldValues()
    {
        return $this->hasMany(FieldValue::class);
    }

    protected function getTypeConfig()
    {
        return array_get(config('maki.sectionTypes'), $this->type);
    }

    public function getTemplateAttribute()
    {
        return $this->getTypeConfig()['template'];
    }

    public function getFieldsAttribute()
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

    public function getTemplateName()
    {
        return config('maki.templatePath') . '.' . $this->template;
    }
}
