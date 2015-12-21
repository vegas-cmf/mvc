<?php
return [
    'application' => [
        'modules' => [
            'Test'
        ],
        'autoload' => [
            'App\Initializer' => TESTS_ROOT_DIR . '/fixtures/app/initializers',
            'App\Shared' => TESTS_ROOT_DIR . '/fixtures/app/shared',
            'App\View' => TESTS_ROOT_DIR . '/fixtures/app/view'
        ],
        'modulesDirectory' => APP_ROOT . '/app/modules',
        'sharedServices' => [
            'App\Shared\ViewCache'
        ],
        'initializers'=> [
            'App\Initializer\Volt',
            'App\Initializer\Phtml',
            'App\Initializer\Twig'
        ],
        'view' => [
            'cacheDir' => TESTS_ROOT_DIR . '/fixtures/cache/view/',
            'viewsDir' => TESTS_ROOT_DIR . '/fixtures/app',
            'layout' => 'main',
            'layoutsDir' => 'layouts/',
            'engines' => [
                'volt' => [
                    'compiledPath' => TESTS_ROOT_DIR . '/fixtures/cache/view/compiled/',
                    'compiledSeparator' => '_',
                    'compileAlways' => false
                ]
            ]
        ]
    ]
];
