<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use StartupPalace\Maki\Link;
use StartupPalace\Maki\Tests\Models\Category;

class LinksTest extends TestCase
{
    use DatabaseMigrations;

    public function testUrlHrefIsCorrect()
    {
        $link = $this->newSimpleLink();

        $this->assertEquals('https://github.com', $link->href);
    }

    public function testObjectHrefIsCorrect()
    {
        $category = $this->newCategory();

        $link = new Link([
            'text' => 'The content of the link tag',
            'title' => 'The title attribute',
        ]);

        $link->setRelation('object', $category);

        $this->assertEquals('http://localhost/category/my-category', $link->href);
    }

    public function testLinkHtmlRendering()
    {
        $link = new Link([
            'text' => 'The content of the link tag',
            'title' => 'The title attribute',
            'url' => 'https://github.com',
        ]);

        $this->assertEquals(
            "<a href=\"{$link->href}\" class=\"\" title=\"{$link->title}\">{$link->text}</a>",
            $link->render()
        );

        $this->assertEquals(
            "<a href=\"{$link->href}\" class=\"btn btn-success\" title=\"{$link->title}\">{$link->text}</a>",
            $link->render(['class' => ['btn btn-success']])
        );
    }

    public function testCategoryLinkHtmlRendering()
    {
        $category = $this->newCategory();

        $link = new Link([
            'text' => 'The content of the link tag',
            'title' => 'The title attribute',
        ]);

        $link->setRelation('object', $category);

        $this->assertEquals(
            "<a href=\"{$link->href}\" class=\"\" title=\"{$link->title}\" target=\"_self\">{$link->text}</a>",
            $link->render()
        );
    }
}
