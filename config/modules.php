<?php

use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Commands;

return [
    'namespace' => 'Modules',
    'paths' => [
        'modules' => base_path('Modules'),
        'assets' => public_path('modules'),
        'migration' => base_path('Modules/*/database/migrations'),
        'generator' => [
            'config' => [
                'path' => 'config',
                'generate' => true,
            ],
            'command' => [
                'path' => 'app/Console',
                'generate' => true,
            ],
            'migration' => [
                'path' => 'database/migrations',
                'generate' => true,
            ],
            'seeder' => [
                'path' => 'database/seeders',
                'generate' => true,
            ],
            'factory' => [
                'path' => 'database/factories',
                'generate' => true,
            ],
            'model' => [
                'path' => 'app/Models',
                'generate' => true,
            ],
            'routes' => [
                'path' => 'routes',
                'generate' => true,
            ],
            'controller' => [
                'path' => 'app/Http/Controllers',
                'generate' => true,
            ],
            'provider' => [
                'path' => 'app/Providers',
                'generate' => true,
            ],
        ],
    ],
    'driver' => 'local',
    'activator' => 'file',
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
        ],
    ],
    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    'composer' => [
        'vendor' => 'nwidart',
        'author' => [
            'name' => 'Your Name',
            'email' => 'your.email@example.com',
        ],
    ],
];
