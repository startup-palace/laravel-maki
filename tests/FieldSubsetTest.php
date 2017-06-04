<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use StartupPalace\Maki\FieldSubset;

class FieldSubsetTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tests if configuration is correctly defined
     */
    public function testConfig()
    {
        $fieldSubset = $this->newFieldSubset();

        $this->assertEquals([
            'limit' => 2,
            'fields' => ['title', 'text'],
        ], $fieldSubset->getConfig());
    }

    /**
     * Tests if the `section` relation reacts nominally
     */
    public function testSectionRelation()
    {
        $fieldSubset = $this->createFieldSubset();

        $this->assertEquals('default', $fieldSubset->section->type);
    }

    /**
     * Tests the `fieldValue` relationship
     */
    public function testFieldValuesRelation()
    {
        $fieldSubset = $this->createFieldSubset();

        $this->assertEquals(0, $fieldSubset->fieldValues()->count());

        $fieldSubset = $this->addFieldValuesToSubset($fieldSubset);

        $this->assertEquals(2, $fieldSubset->fieldValues()->count());
    }

    /**
     * Create a FieldSubset in database
     * @return FieldSubset
     */
    protected function createFieldSubset()
    {
        $fieldSubset = $this->newFieldSubset();
        $fieldSubset->save();

        return $fieldSubset;
    }

    /**
     * Create a new FieldSubset instance
     * @return FieldSubset
     */
    protected function newFieldSubset()
    {
        $section = $this->createSectionAndFieldValues();

        return new FieldSubset([
            'type' => 'card',
            'section_id' => $section->id,
        ]);
    }

    protected function addFieldValuesToSubset(FieldSubset $fieldSubset) : FieldSubset
    {
        $fieldSubset->fieldValues()->createMany([
            [
                'field' => 'title',
                'data' => 'My card',
            ],
            [
                'field' => 'text',
                'data' => 'The text of my card',
            ]
        ]);

        return $fieldSubset;
    }
}
