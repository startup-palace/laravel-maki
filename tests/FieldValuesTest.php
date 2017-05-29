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

        $this->assertTrue($section->exists);
    }

    public function testBasicData()
    {
        $section = $this->createSectionAndFieldValues();

        $this->assertEquals('A simple title', $section->fieldValues->first()->data);
    }

    public function testComplexData()
    {
        $section = $this->createSection();

        $category = $this->newCategory();

        $fieldValue = new FieldValue([
            'field' => 'title',
            'section_id' => $section->id,
        ]);

        $fieldValue->setRelation('object', $category);

        $this->assertEquals($category, $fieldValue->object);

        $this->assertEquals('http://localhost/category/my-category', (string) $fieldValue);
    }
}
