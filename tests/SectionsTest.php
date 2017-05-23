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

    public function testSectionRendering()
    {
        $section = Section::create([
            'type' => 'default',
        ]);

        $fieldValues = [
            new FieldValue(['field' => 'title', 'data' => 'A simple title']),
            new FieldValue(['field' => 'text', 'data' => 'A simple text']),
            new FieldValue(['field' => 'content', 'data' => '<p>Some content</p>']),
        ];

        $section->fieldValues()->saveMany($fieldValues);

        $this->assertContains('A simple title', (string) $section->render());
        $this->assertContains('A simple text', (string) $section->render());
        $this->assertContains('<p>Some content</p>', (string) $section->render());
    }
}
