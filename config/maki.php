<?php

return [
    // Class you want to use to represent sections
    'sectionClass' => \StartupPalace\Maki\Section::class,
    // Class you want to use to represent field values
    'fieldValueClass' => \StartupPalace\Maki\FieldValue::class,
    // Class you want to use to represent a page
    'pageClass' => \StartupPalace\Maki\Page::class,
    // Path to Maki's templates (from `resources/views`)
    'templatePath' => 'maki',
    // Describe the field types use in your application
    'fields' => [
        'title' => [
            'type' => 'input:text',
        ],
        'text' => [
            'type' => 'textarea',
        ],
        'content' => [
            'type' => 'wysiwyg',
        ],
        'button' => [
            'type' => 'link',
        ],
    ],
    // Describe the different section types used in your application
    'sectionTypes' => [
        'default' => [
            'template' => 'default',
            'fields' => [
                'title', 'text', 'content', 'button',
            ],
        ],
    ],
];
