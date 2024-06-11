<?php

return [
    'postList' => [
        'type' => 2,
    ],
    'readPost' => [
        'type' => 2,
    ],
    'createPost' => [
        'type' => 2,
    ],
    'updatePost' => [
        'type' => 2,
    ],
    'deletePost' => [
        'type' => 2,
    ],
    'reader' => [
        'type' => 1,
        'children' => [
            'readPost',
            'postList',
        ],
    ],
    'writer' => [
        'type' => 1,
        'children' => [
            'createPost',
            'updatePost',
            'reader',
        ],
    ],
    'super' => [
        'type' => 1,
        'children' => [
            'deletePost',
            'writer',
        ],
    ],
];
