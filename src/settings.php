<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        //database connection for eloquent
                'db' => [
                       'driver' => 'sqlite',
                       'host' => 'localhost',
                       'database' => __DIR__ . '/../src/blog.db',
                       'charset' => 'utf8',
                       'collation' => 'utf8_unicode_ci',
               ]
            ],

    ];
