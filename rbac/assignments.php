<?php

use app\models\User;

return [
    User::ROLE_SUPER => [
        'super',
    ],
    User::ROLE_WRITER => [
        'writer',
    ],
    User::ROLE_READER => [
        'reader',
    ],
];
