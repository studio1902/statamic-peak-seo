<?php

return [
    'social_image' => [
        'node_binary' => env('SOCIAL_IMAGE_NODE_BINARY'),
        'npm_binary' => env('SOCIAL_IMAGE_NPM_BINARY'),
        'queue_name' => env('SOCIAL_IMAGE_QUEUE_NAME', 'default')
    ],
];
