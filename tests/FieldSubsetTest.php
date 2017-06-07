<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use StartupPalace\Maki\FieldSubset;
use StartupPalace\Maki\Section;

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

        $this->assertTrue($fieldSubset->fields->has('title'));
        $this->assertTrue($fieldSubset->fields->has('text'));
    }

    public function testRendering()
    {
        config([
            'maki.sectionTypes.fieldSubsetTest' => [
                'template' => 'field-subset-test',
                'fieldSubsets' => [
                    'card' => [
                        'limit' => 2,
                        'fields' => ['title', 'text'],
                    ],
                ],
            ],
        ]);

        $section = Section::create([
            'type' => 'fieldSubsetTest',
        ]);

        $fieldSubset = $this->addFieldValuesToSubset(FieldSubset::create([
            'type' => 'card',
            'section_id' => $section->id,
        ]));

        $this->assertContains('<h2>My card</h2>', (string) $section->render());
        $this->assertContains('<p>The text of my card</p>', (string) $section->render());
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
