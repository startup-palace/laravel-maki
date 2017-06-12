<?php

namespace StartupPalace\Maki\Traits;

use Illuminate\Support\Facades\DB;
use StartupPalace\Maki\Menu;
use StartupPalace\Maki\MenuItem;

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

    public function getMenusAttribute()
    {
        $childless = MenuItem::whereHas('link', function ($query) {
            return $query->where('object_type', $this->getMorphClass())
                ->where('object_id', $this->id);
        })->pluck('id')->toArray();

        $bindingsString = null;

        if (count($childless)) {
            $bindingsString = trim( str_repeat('?,', count($childless)), ',');
        }

        $query = <<<EOQ
WITH RECURSIVE tree(id, parent_id) AS (
        SELECT id, parent_id FROM maki_menu_items WHERE id IN ( $bindingsString )
    UNION ALL
        SELECT d.id, d.parent_id
        FROM maki_menu_items d, tree t
        WHERE d.id = t.parent_id
)
SELECT parent_id FROM tree
EOQ;

        $menus = DB::select($query, $childless);

        return Menu::findMany(array_column($menus, 'parent_id'));
    }
}
