<?php

namespace StartupPalace\Maki\Tests;

use Illuminate\Support\Collection;
use StartupPalace\Maki\FieldValue;
use StartupPalace\Maki\Section;

class FieldValuesTest extends TestCase
{
    /**
     * Test the `fieldValues` relation
     */
    public function testRelation()
    {
        $section = $this->createSectionAndFieldValues();

        $this->assertEquals('A section title', $section->fieldValues->first()->data);
    }

    protected function createSectionAndFieldValues()
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
