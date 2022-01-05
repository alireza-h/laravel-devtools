# LaravelDevTools

![devtools preview](https://github.com/alireza-h/laravel-devtools/blob/master/devtools-preview.png)

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

### Migration

Migrate tables

```bash
$ php artisan migrate
```

### Publish

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

### Error logger

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

### Dev tools panel

Navigate to http://localhost:8000/dev-tools

Create your own password (http://localhost:8000/dev-tools/password), add it to `devtools.php` config file:

```php
'users' => [
    'your_username' => 'your_hashed_password',
],
```

and use this credentials for devtools panel
