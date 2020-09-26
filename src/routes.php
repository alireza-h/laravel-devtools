<?php

/*
|--------------------------------------------------------------------------
| Dev Routes
|--------------------------------------------------------------------------
|
*/


use AlirezaH\LaravelDevTools\Http\Controllers\MailCatcherController;
use Illuminate\Support\Facades\Route;
use AlirezaH\LaravelDevTools\Http\Controllers\DevController;
use AlirezaH\LaravelDevTools\Http\Controllers\ErrorLogController;
use AlirezaH\LaravelDevTools\Http\Controllers\CommandController;
use AlirezaH\LaravelDevTools\Http\Controllers\SchemaController;
use AlirezaH\LaravelDevTools\Http\Controllers\CacheController;

Route::group(['prefix' => config('devtools.route_prefix', 'devtools'), 'middleware' => ['web', 'devtools.auth']], function (\Illuminate\Routing\Router $router) {
    Route::get('/', [DevController::class, 'index'])->name('devtools.index')->withoutMiddleware('devtools.auth');

    Route::get('/phpinfo', [DevController::class, 'phpinfo'])->name('devtools.phpinfo');

    Route::get('/tools', [DevController::class, 'tools'])->name('devtools.tools');
    Route::post('/tools', [DevController::class, 'postTools'])->name('devtools.tools.post');
    Route::post('/tools/login-as', [DevController::class, 'loginAs'])->name('devtools.tools.post.login-as');

    Route::get('/password', [DevController::class, 'password'])->name('devtools.password')->withoutMiddleware('devtools.auth');
    Route::post('/password', [DevController::class, 'hash'])->name('devtools.hash')->withoutMiddleware('devtools.auth');

    Route::get('/errors', [ErrorLogController::class, 'index'])->name('devtools.errors');
    Route::get('/errors/preview/{id}', [ErrorLogController::class, 'preview'])->name('devtools.errors.preview');
    Route::get('/errors/remove/{id}', [ErrorLogController::class, 'remove'])->name('devtools.errors.remove');
    Route::get('/errors/clear', [ErrorLogController::class, 'clear'])->name('devtools.errors.clear');
    Route::get('/errors/clear/old', [ErrorLogController::class, 'clearOld'])->name('devtools.errors.clear.old');


    Route::get('/commands', [CommandController::class, 'index'])->name('devtools.commands');
    Route::get('/commands/run', [CommandController::class, 'run'])->name('devtools.commands.run');

    Route::get('/schema/tables/', [SchemaController::class, 'tables'])->name('devtools.schema.tables');

    Route::get('/cache', [CacheController::class, 'index'])->name('devtools.cache.index');
    Route::post('/cache/flush', [CacheController::class, 'flush'])->name('devtools.cache.flush');

    Route::get('/mails', [MailCatcherController::class, 'index'])->name('devtools.mails.index');
    Route::get('/mails/preview/{id}', [MailCatcherController::class, 'preview'])->name('devtools.mails.preview');
    Route::get('/mails/remove/{id}', [MailCatcherController::class, 'remove'])->name('devtools.mails.remove');
    Route::get('/mails/clear', [MailCatcherController::class, 'clear'])->name('devtools.mails.clear');
});
