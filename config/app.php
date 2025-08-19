<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'Alaz',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => $_ENV['APP_DEBUG'] ?? false,
    'base_path' => $_ENV['BASE_PATH'] ?? dirname(__DIR__),
];
