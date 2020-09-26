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
