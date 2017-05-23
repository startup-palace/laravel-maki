<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Section;

class FieldValuesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test the `fieldValues` relation
     */
    public function testRelation()
    {
        $section = $this->createSectionAndFieldValues();

        $this->assertEquals('A simple title', $section->fieldValues->first()->data);

        $this->assertTrue($section->exists);
    }
}
