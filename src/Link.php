<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'text', 'title', 'object_id', 'object_type', 'url',
    ];

    protected $appends = ['href'];

    public function object()
    {
        return $this->morphTo();
    }

    public function getHrefAttribute()
    {
        if ($this->url) {
            return $this->url;
        }

        return $this->object->entityUrl;
    }

    public function render(array $options = array())
    {
        $class = '';

        if (array_key_exists('class', $options)) {
            $class = is_string($options['class']) ? $options : implode(' ', $options['class']);
        }

        return "<a href=\"{$this->href}\" class=\"{$class}\" title=\"{$this->title}\">{$this->text}</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
