<?php

namespace StartupPalace\Maki\Tests;

use StartupPalace\Maki\Section;

class SectionsTest extends TestCase
{
    /**
     * Tests section config
     */
    public function testConfig()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $this->assertArrayHasKey('title', $section->fields);
        $this->assertEquals('wysiwyg', $section->fields['content']['type']);
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
