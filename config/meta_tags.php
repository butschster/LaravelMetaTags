<?php

use Butschster\Head\MetaTags\Viewport;

return [
    'title' => [
        'default' => env('APP_NAME'),
        'separator' => '-',
        'max_length' => 255,
    ],
    'description' => [
        'default' => null,
        'max_length' => 255,
    ],
    'keywords' => [
        'default' => null,
        'max_length' => 255
    ],
    'charset' => 'utf-8',
    'robots' => null,
    'viewport' => Viewport::RESPONSIVE,
    'csrf_token' => true,
];