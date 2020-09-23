<?php

use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return [
    'route_prefix' => 'dev-tools',

    'users' => [
        // 'username' => password_hash('password', PASSWORD_DEFAULT)
        // 'devtools' => '$2y$10$QgJ7zPEJU.Sk81gDb1FrFe4algD1kHdvLo0xQpNwt6zWpv2EpU4pK',
    ],

    'custom_menu' => [
        'horizon' => [
            'title' => 'Monitor',
            'url' => '/dev-tools/horizon',
            'active' => false,
        ],
    ],

    'redirect_to_after_login_as' => '/',

    'error_logger' => [
        'enabled' => true,
        'engine' => 'db', // db | redis,
        'preview' => env('DEVTOOLS_ERROR_LOGGER_PREVIEW', 'ignition'), // whoops | ignition,
        'error_count_to_notify' => [10, 100, 1000, 10000],
        'clear_older_than' => 3600 * 72,
        'types' => [
            'warning' => [
                'logToSlack' => false,
                'exceptions' => [
                    ClientException::class,
                    LaravelValidationException::class,
                    MaintenanceModeException::class,
                    TokenMismatchException::class,
                    HttpException::class,
                    MethodNotAllowedHttpException::class,
                    AuthenticationException::class,
                ]
            ],
            'notFound' => [
                'logToSlack' => false,
                'exceptions' => [
                    ModelNotFoundException::class,
                    NotFoundHttpException::class,
                ]
            ]
        ]
    ],

    'cache_tags' => [
        'home:page:menu',
    ],

    'mail_catcher' => [
        'enabled' => true,
        'envs' => [
            'local',
            'demo',
        ],
    ],
];
