<?php

return [
    'social_image' => [
        'chrome_path' => env('SOCIAL_IMAGE_CHROME_PATH'),
        'format' => env('SOCIAL_IMAGE_FORMAT', 'png'),
        'jpg-quality' => env('SOCIAL_IMAGE_JPG_QUALITY', 100),
        'node_binary' => env('SOCIAL_IMAGE_NODE_BINARY'),
        'npm_binary' => env('SOCIAL_IMAGE_NPM_BINARY'),
        'queue_name' => env('SOCIAL_IMAGE_QUEUE_NAME', 'default'),
        'resolution' => env('SOCIAL_IMAGE_RESOLUTION', '1200x630'),
        'selector' => env('SOCIAL_IMAGE_SELECTOR_ID', 'og'),
    ],
];
