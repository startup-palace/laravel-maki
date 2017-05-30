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

        $this->runContentTestsOnRenderedTemplate((string) $section);

        $viewHtml = View::make('index', ['sections' => [$section]])->render();

        $this->runContentTestsOnRenderedTemplate($viewHtml);
    }

    protected function runContentTestsOnRenderedTemplate($html)
    {
        $this->assertContains('A simple title', $html);
        $this->assertContains('A simple text', $html);
        $this->assertContains('<p>Some content</p>', $html);

        $this->assertContains('https://github.com', $html);
        $this->assertContains('class="test"', $html);
        $this->assertContains('The title attribute', $html);
    }
}
