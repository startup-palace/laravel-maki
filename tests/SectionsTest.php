<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
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
}
