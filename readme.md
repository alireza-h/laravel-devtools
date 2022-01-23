# LaravelDevTools

![devtools preview](https://github.com/alireza-h/laravel-devtools/blob/master/devtools-preview.png)

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Dev Tools Panel](#dev-tools-panel)

### Features

- Error Logger (with whoops or ignition preview)
- Commands panel
- DB Schema panel, MySql or SQLite
- Cache panel, flush cache tags and cache keys
- Mail catcher
- Impersonate; Login as another user
- Installed packages list

### Installation

```bash
$ composer require alireza-h/laravel-devtools
```

- [Migration](#migration)
- [Publish](#publish)
- [Custom Log Channel](#custom-log-channel)

#### Migration

Migrate tables

```bash
$ php artisan migrate
```

#### Publish

Publish configs

```bash
$ php artisan vendor:publish --tag="devtools.config"
```

Publish assets

```bash
$ php artisan vendor:publish --tag="devtools.assets"
```

Publish views to customize

```bash
$ php artisan vendor:publish --tag="devtools.views"
```

#### Custom Log Channel

Add devtools custom log channel to `logging.php` config file and use it

```php
'devtools' => [
    'driver' => 'custom',
    'via' => \AlirezaH\LaravelDevTools\Lib\Monolog\MonologLogger::class,
]

...

'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'devtools'],
        'ignore_exceptions' => false,
    ],
    
    ...
]
```

### Configuration

- `route_prefix` devtools panel base url
- `users` list of devtools panel credentials; username as key and password as value
- `custom_menu` custom menu items for devtools panel
- [Error Logger](#error-logger)
- [Mail Catcher](#mail-catcher)

#### Error Logger

```php
'error_logger' => [
    'enabled' => true,
    'engine' => 'db', // db | redis,
    'preview' => env('DEVTOOLS_ERROR_LOGGER_PREVIEW', 'ignition'), // whoops | ignition,
    'error_count_to_notify' => [10, 100, 1000, 10000],
    'clear_older_than' => 3600 * 72,
    'types' => [
        'warning' => [
            'log_to_slack' => false,
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
        'not_found' => [
            'log_to_slack' => false,
            'exceptions' => [
                ModelNotFoundException::class,
                NotFoundHttpException::class,
            ]
        ],
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
```

- `enabled` enable or disable devtools error logger
- `engine` store logs in `redis` or in `db`
- `preview` preview errors and stack trace by `whoops` or `ignition`
- `error_count_to_notify` error count boundaries to notify error in slack
- `clear_older_than` clear error logs older than this value (in seconds) 
- `types` categorize error logs and define each type exceptions
  - `log_to_slack` enable or disable log to slack; you need to configure logging slack channel (`LOG_SLACK_WEBHOOK_URL` in `logging.php` config file)
  - `exceptions` list of exception classes
- `dont_log` don't log list of defined exception types


#### Mail Catcher

```php
'mail_catcher' => [
    'enabled' => true,
    'envs' => [
        'local',
        'demo',
        //'testing',
        //'production',
    ],
],
```

- `enabled` enable or disable mail catcher
- `envs` application environments to catch mails

### Dev Tools Panel

Navigate to http://localhost:8000/dev-tools

Create your own password (http://localhost:8000/dev-tools/password), add it to `devtools.php` config file:

```php
'users' => [
    'your_username' => 'your_hashed_password',
],
```

and use this credential for devtools panel
