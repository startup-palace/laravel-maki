<?php

namespace StartupPalace\Maki\Traits;

trait MakiEntityTrait
{
    public function getEntityUrlAttribute() : string
    {
        return route($this->getShowRouteName(), $this->getEntityRouteParameters());
    }

    public function __toString() : string
    {
        return $this->getEntityUrlAttribute();
    }
}
