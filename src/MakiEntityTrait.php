<?php

namespace StartupPalace\Maki;

trait MakiEntityTrait
{
    public function getEntityUrlAttribute()
    {
        return route($this->getShowRouteName(), $this->getEntityRouteParameters());
    }

    public function __toString() : string
    {
        return $this->getEntityUrlAttribute();
    }
}
