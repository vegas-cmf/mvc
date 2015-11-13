<?php
return [
    'application' => [
        'modules' => [
            'Test'
        ],
        'autoload' => [
            'App\Initializer' => TESTS_ROOT_DIR . '/fixtures/app/initializers/',
            'App\Shared' => TESTS_ROOT_DIR . '/fixtures/app/shared/'
        ],
        'modulesDirectory' => TESTS_ROOT_DIR . '/fixtures/app/modules/',
        'sharedServices' => [
            'App\Shared\ViewCache'
        ],
        'initializers'=> [
            'App\Initializer\Volt',
            'App\Initializer\Phtml',
        ],
        'view' => [
            'cacheDir' => TESTS_ROOT_DIR . '/app/cache/view/',
            'viewsDir' => TESTS_ROOT_DIR . '/app/',
            'layout' => 'main',
            'layoutsDir' => 'layouts/',
            'engines' => [
                'volt' => [
                    'compiledPath' => TESTS_ROOT_DIR . '/fixtures/cache/view/compiled',
                    'compiledSeparator' => '_',
                    'compileAlways' => false
                ]
            ]
        ]
    ]
];