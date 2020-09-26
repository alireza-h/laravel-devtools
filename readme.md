# LaravelDevTools

## Installation

```bash
$ composer require alireza-h/laravel-devtools
```


### Migration

Migrate tables

```bash
$ php artisan migare
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

```
public function report(Throwable $exception)
{
    (new ErrorLogCmd())->log($exception);

    parent::report($exception);
}
```


### Dev tools panel
Navigate to http://localhost:8000/dev-tools

Create your own password (http://localhost:8000/dev-tools/password), add it to `devtools.php` config file: 

```
'users' => [
    // 'username' => password_hash('password', PASSWORD_DEFAULT)
    'your_username' => 'your_hashed_password',
],
```

and use this credentials for devtools panel
