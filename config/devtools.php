<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
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
        'error_count_to_notify' => [10, 100, 1000, 10000],
        'clear_older_than' => 3600 * 72, // in seconds
        'types' => [
            'warning' => [
                'log_to_slack' => false,
                'exceptions' => [
                    MaintenanceModeException::class,
                    MethodNotAllowedHttpException::class,
                ]
            ],
            'not_found' => [
                'log_to_slack' => false,
                'exceptions' => [
                    NotFoundHttpException::class,
                ]
            ]
        ],
        'dont_log' => [ // don't log list of these exception types
            AuthenticationException::class,
            AuthorizationException::class,
            HttpException::class,
            HttpResponseException::class,
            ModelNotFoundException::class,
            SuspiciousOperationException::class,
            TokenMismatchException::class,
            ValidationException::class,
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
            //'testing',
            //'production',
        ],
    ],
];
