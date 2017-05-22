<?php

return [
    'templatePath' => 'maki',
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
    'sectionTypes' => [
        'default' => [
            'template' => 'default',
            'fields' => [
                'title', 'cover', 'content', 'button',
            ],
        ],
    ],
];
