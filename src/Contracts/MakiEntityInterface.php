<?php

namespace StartupPalace\Maki\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface MakiEntityInterface
{
    public function getEntityRouteParameters() : array;

    public function getShowRouteName() : string;

    public static function getEntityName() : string;

    public function getEntityUrlAttribute() : string;
}
