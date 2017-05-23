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
        $section = $this->makeSectionAndFieldValues();

        $this->assertEquals('A section title', $section->fieldValues->first()->data);

        $section->save();

        $this->assertTrue($section->exists);
    }

    protected function makeSectionAndFieldValues()
    {
        $section = new Section([
            'type' => 'default',
        ]);

        $fieldValues = Collection::make([
            new FieldValue([
                'field' => 'title',
                'data' => 'A section title',
            ]),
            new FieldValue([
                'field' => 'content',
                'data' => <<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus dolorum esse rem vitae, quaerat asperiores
eos sint iure commodi, velit praesentium temporibus, amet, ut molestiae.</p>
EOT
                ,
            ]),
        ]);

        $section->setRelation('fieldValues', $fieldValues);

        return $section;
    }
}
