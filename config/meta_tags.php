<?php

use Butschster\Head\MetaTags\Viewport;

return [
    'meta' => [
        'title' => env('APP_NAME'),
        'description' => '',
        'separator' => ' - ',
        'keywords' => [],
        'robots' => null,
        'viewport' => Viewport::RESPONSIVE,
        'csrf_token' => true
    ],
];