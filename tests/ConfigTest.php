<?php

namespace StartupPalace\Maki\Tests;

class ConfigTest extends TestCase
{
    /**
     * Test that package configuration is loaded
     */
    public function testConfigIsLoaded()
    {
        $this->assertEquals('maki', config('maki.templatePath'));
        $this->assertArrayHasKey('default', config('maki.sectionTypes'));
    }
}
