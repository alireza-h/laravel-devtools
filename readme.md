# LaravelDevTools


### Features
- Error Logger
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

Add `(new ErrorLogCmd())->log($exception)` to `\App\Exceptions\Handler::report`

```php
public function report(Throwable $exception)
{
    (new ErrorLogCmd())->log($exception);

    parent::report($exception);
}
```

Add `(new ErrorLogCmd())->log($exception)` to `\App\Providers\EventServiceProvider::boot`

```php
Queue::failing(function (JobFailed $event) {
    (new ErrorLogCmd())->log($event->exception);
});
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
