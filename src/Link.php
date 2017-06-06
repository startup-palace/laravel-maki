<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kblais\Uuid\Uuid;
use StartupPalace\Maki\Contracts\LinkInterface;

class Link extends Model implements LinkInterface
{
    use Uuid;

    protected $table = 'maki_links';

    protected $fillable = [
        'text', 'title', 'object_id', 'object_type', 'url',
    ];

    protected $appends = ['href'];

    /**
     * Describe the `object` relation
     * @return MorphTo
     */
    public function object() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the link destination
     * @return string
     */
    public function getHrefAttribute() : string
    {
        if ($this->url) {
            return $this->url;
        }

        return $this->object->entityUrl;
    }

    /**
     * Render the HTML code for the link
     * @param  array  $options Options for the link
     * @return string
     */
    public function render(array $options = array()) : string
    {
        $class = '';

        if (array_key_exists('class', $options)) {
            $class = is_string($options['class']) ? $options : implode(' ', $options['class']);
        }

        return sprintf('<a href="%s" class="%s" title="%s">%s</a>', $this->href, $class, $this->title, $this->text);
    }

    /**
     * String representation of the link
     * @return string
     */
    public function __toString() : string
    {
        return $this->href;
    }
}
