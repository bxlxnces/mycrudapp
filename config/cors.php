    <?php

    return [
        'paths' => ['api/*'],
        'allowed_methods' => ['*'],  // Разрешаем все методы (GET, POST, PUT, DELETE и т.д.)
        'allowed_origins' => ['http://localhost:3000'],  // Разрешаем запросы только с этого источника
        'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => false,
    ];
