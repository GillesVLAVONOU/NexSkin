<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'NexSkin',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost/nexskin',
    'key' => $_ENV['APP_KEY'] ?? '',
    'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Africa/Lagos',
    'upload_max_size' => (int) ($_ENV['UPLOAD_MAX_SIZE'] ?? 5242880),
    'upload_allowed_types' => explode(',', $_ENV['UPLOAD_ALLOWED_TYPES'] ?? 'jpg,jpeg,png,webp'),
];
