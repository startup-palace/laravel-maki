<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\View;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Section;
use StartupPalace\Maki\Tests\Models\Category;

class SectionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tests section config
     */
    public function testConfig()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $this->assertTrue($section->fields->contains(new FieldValue(['field' => 'title'])));
        $this->assertEquals(
            'wysiwyg',
            $section->fields['content']
                ->config['type']
        );
    }

    /**
     * Tests view path for Maki templates
     */
    public function testSectionTemplate()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $this->assertEquals('maki.default', $section->getTemplateName());

        config(['maki.templatePath' => 'changedTemplatePath']);

        $this->assertEquals('changedTemplatePath.default', $section->getTemplateName());
    }

    /**
     * Tests sections HTML rendering
     */
    public function testSectionRendering()
    {
        $section = $this->createSectionAndFieldValues();

        $this->assertContains('A simple title', (string) $section->render());
        $this->assertContains('A simple text', (string) $section->render());
        $this->assertContains('<p>Some content</p>', (string) $section->render());

        $viewHtml = View::make('index', ['sections' => [$section]])->render();

        $this->assertContains('<title>Maki - Test page</title>', $viewHtml);
        $this->assertContains('A simple title', $viewHtml);
        $this->assertContains('A simple text', $viewHtml);
        $this->assertContains('<p>Some content</p>', $viewHtml);
    }
}
