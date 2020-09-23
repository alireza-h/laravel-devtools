<?php

namespace AlirezaH\LaravelDevTools;

use AlirezaH\LaravelDevTools\Http\Middleware\AuthDevTools;
use AlirezaH\LaravelDevTools\Lib\ErrorLogger\DBErrorLogger;
use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogger;
use AlirezaH\LaravelDevTools\Lib\ErrorLogger\RedisErrorLogger;
use AlirezaH\LaravelDevTools\Lib\Schema\MysqlSchema;
use AlirezaH\LaravelDevTools\Lib\Schema\Schema;
use AlirezaH\LaravelDevTools\Lib\Schema\SqliteSchema;
use AlirezaH\LaravelDevTools\Listeners\MailCatcherListener;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class DevToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'devtools');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'devtools');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->registerDevtoolsAuthMiddleware();
        $this->listenMailCatcher();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/devtools.php', 'devtools');

        // Register the service the package provides.
        $this->app->singleton(
            DevTools::class,
            function ($app) {
                return new DevTools();
            }
        );

        $this->app->bind(Schema::class, function ($app) {
            switch (config('database.default')) {
                case 'mysql':
                    return new MysqlSchema();
                    break;

                case 'sqlite':
                    return new SqliteSchema();
                    break;
            }
        });

        $this->app->bind(ErrorLogger::class, function ($app) {
            switch (config('devtools.error_logger.engine')) {
                case 'db':
                    return new DBErrorLogger();
                    break;

                case 'redis':
                    return new RedisErrorLogger();
                    break;
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['devtools'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes(
            [
                __DIR__.'/../config/devtools.php' => config_path('devtools.php'),
            ],
            'devtools.config'
        );

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/devtools'),
        ], 'devtools.views');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/devtools'),
        ], 'devtools.assets');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/devtools'),
        ], 'devtools.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }

    private function registerDevtoolsAuthMiddleware()
    {
        /** @var Router $router */
        $router = $this->app['router'];
        $router->aliasMiddleware('devtools.auth', AuthDevTools::class);
    }

    private function listenMailCatcher()
    {
        if (!config('devtools.mail_catcher.enabled')) {
            return;
        }

        Event::listen(
            MessageSending::class,
            MailCatcherListener::class
        );
    }
}
