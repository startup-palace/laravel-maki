<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use StartupPalace\Maki\Contracts\MenuItemInterface;
use StartupPalace\Maki\Link;
use StartupPalace\Maki\Menu;
use StartupPalace\Maki\MenuItem;

class MenusTest extends TestCase
{
    use DatabaseMigrations;

    public function testMenuConfig()
    {
        $menu = $this->newMenu();

        $this->assertEquals(['template' => 'menus.aside'], $menu->getConfig());
        $this->assertEquals('menus.aside', $menu->getConfig('template'));
        $this->assertEquals('maki.menus.aside', $menu->getTemplateName());
    }

    public function testMenuMenuItemRelation()
    {
        list($menu) = $this->createMenuWithMenuItem();

        $this->assertNotEmpty($menu->menuItems);
    }

    public function testMenuItemParentRelation()
    {
        list($menu, $menuItem) = $this->createMenuWithMenuItem();

        $link = Link::create([
            'text' => 'Another link',
            'title' => 'Another link',
            'url' => 'https://github.com/startup-palace',
        ]);

        $childMenuItem = new MenuItem([
            'title' => 'My child item',
            'link_id' => $link->id,
        ]);
        $childMenuItem->parent()->associate($menuItem);
        $childMenuItem->save();

        $this->assertNotEmpty($menu->menuItems->first()->menuItems);
    }

    public function testRendering()
    {
        list($menu, $menuItem) = $this->createMenuWithMenuItem();

        $this->assertContains('<a href="https://github.com">My item</a>', (string) $menu->render());

        $link = Link::create([
            'text' => 'A link',
            'title' => 'A link',
            'url' => 'https://github.com/startup-palace',
        ]);

        $subItem = $this->newMenuItem($link, 'Github');
        $subItem->parent()->associate($menuItem);
        $subItem->save();

        $menu->refresh();

        $this->assertContains('<a href="https://github.com/startup-palace">My item</a>', (string) $menu->render());
    }

    protected function createMenuWithMenuItem() : array
    {
        $menu = $this->createMenu();

        $link = Link::create([
            'text' => 'A link',
            'title' => 'A link',
            'url' => 'https://github.com',
        ]);

        $menuItem = $this->newMenuItem($link, 'My item');
        $menuItem->parent()->associate($menu);
        $menuItem->save();

        return [$menu, $menuItem, $link];
    }

    protected function createMenu() : Menu
    {
        $menu = $this->newMenu();
        $menu->save();

        return $menu;
    }

    protected function newMenu() : Menu
    {
        return new Menu([
            'title' => 'My menu',
            'slug' => 'my-menu',
            'description' => 'The description of my menu',
            'type' => 'aside',
        ]);
    }

    protected function newMenuItem(Link $link, $title, MenuItem $parent = null) : MenuItem
    {
        return new MenuItem([
            'title' => 'My item',
            'link_id' => $link->id,
        ]);
    }
}
