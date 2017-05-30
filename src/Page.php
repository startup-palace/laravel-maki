<?php

namespace StartupPalace\Maki;

use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;

class Page extends Model
{
    use Uuid;

    protected $fillable = [];

    public function sections()
    {
        return $this->belongsToMany(config('maki.sectionClass'));
    }
}
