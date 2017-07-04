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
            "<a href=\"{$link->href}\" class=\"\" title=\"{$link->title}\" target=\"_blank\">{$link->text}</a>",
            $link->render()
        );

        $this->assertEquals(<<<EOT
<a href="{$link->href}" class="btn btn-success" title="The title attribute" target="_blank">The content of the link tag</a>
EOT
            ,
            $link->render(['class' => ['btn btn-success']])
        );

        $link->url = '//github.com';
        $this->assertEquals(<<<EOT
<a href="//github.com" class="btn btn-success" title="The title attribute" target="_blank">The content of the link tag</a>
EOT
            ,
            $link->render(['class' => ['btn btn-success']])
        );

        $link->url = '/a-page';
        $this->assertEquals(<<<EOT
<a href="/a-page" class="btn btn-success" title="The title attribute" target="_self">The content of the link tag</a>
EOT
            ,
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
