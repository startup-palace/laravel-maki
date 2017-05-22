<?php

return [
    // Path to Maki's templates (from `resources/views`)
    'templatePath' => 'maki',
    // Describe the field types use in your application
    'fields' => [
        'content' => [
            'type' => 'wysiwyg',
        ],
        'title' => [
            'type' => 'input:text',
        ],
        'cover' => [
            'type' => 'input:file:image',
        ],
        'text' => [
            'type' => 'textarea',
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
                'title', 'cover', 'content', 'button',
            ],
        ],
    ],
];
