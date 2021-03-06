<?php

return [
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
            'fieldSubsets' => [
                'card' => [
                    'limit' => 2,
                    'fields' => ['title', 'text'],
                ],
            ],
        ],
    ],
    'menus' => [
        'aside' => [
            'template' => 'menus.aside',
        ],
    ],
];
