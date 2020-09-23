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
    Route::get('/', [DevController::class, 'index'])->name('dev.index')->withoutMiddleware('auth.dev');

    Route::get('/phpinfo', [DevController::class, 'phpinfo'])->name('dev.phpinfo');

    Route::get('/tools', [DevController::class, 'tools'])->name('dev.tools');
    Route::post('/tools', [DevController::class, 'postTools'])->name('dev.tools.post');
    Route::post('/tools/login-as', [DevController::class, 'loginAs'])->name('dev.tools.post.login-as');

    Route::get('/password', [DevController::class, 'password'])->name('dev.password')->withoutMiddleware('auth.dev');
    Route::post('/password', [DevController::class, 'hash'])->name('dev.hash')->withoutMiddleware('auth.dev');

    Route::get('/errors', [ErrorLogController::class, 'index'])->name('dev.errors');
    Route::get('/errors/preview/{id}', [ErrorLogController::class, 'preview'])->name('dev.errors.preview');
    Route::get('/errors/remove/{id}', [ErrorLogController::class, 'remove'])->name('dev.errors.remove');
    Route::get('/errors/clear', [ErrorLogController::class, 'clear'])->name('dev.errors.clear');
    Route::get('/errors/clear/old', [ErrorLogController::class, 'clearOld'])->name('dev.errors.clear.old');


    Route::get('/commands', [CommandController::class, 'index'])->name('dev.commands');
    Route::get('/commands/run', [CommandController::class, 'run'])->name('dev.commands.run');

    Route::get('/schema/tables/', [SchemaController::class, 'tables'])->name('dev.schema.tables');

    Route::get('/cache', [CacheController::class, 'index'])->name('dev.cache.index');
    Route::post('/cache/flush', [CacheController::class, 'flush'])->name('dev.cache.flush');

    Route::get('/mails', [MailCatcherController::class, 'index'])->name('dev.mails.index');
    Route::get('/mails/preview/{id}', [MailCatcherController::class, 'preview'])->name('dev.mails.preview');
    Route::get('/mails/remove/{id}', [MailCatcherController::class, 'remove'])->name('dev.mails.remove');
    Route::post('/mails/clear', [MailCatcherController::class, 'clear'])->name('dev.mails.clear');
});
