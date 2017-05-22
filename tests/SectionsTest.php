<?php

namespace StartupPalace\Maki\Tests;

use StartupPalace\Maki\Section;

class SectionsTest extends TestCase
{
    public function testConfig()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $this->assertArrayHasKey('title', $section->fields);
        $this->assertEquals('wysiwyg', $section->fields['content']['type']);
    }

    public function testSectionTemplate()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $this->assertEquals('default', $section->template);

        $this->assertEquals('maki.default', $section->getTemplateName());

        config(['maki.templatePath' => 'changedTemplatePath']);

        $this->assertEquals('changedTemplatePath.default', $section->getTemplateName());
    }
}
