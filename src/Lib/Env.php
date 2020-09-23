<?php


namespace AlirezaH\LaravelDevTools\Lib;


trait Env
{
    use Application;

    public function env(): string
    {
        return $this->app()->environment();
    }

    public function isLocal(): bool
    {
        return $this->isEnv(Enums::ENV_LOCAL);
    }

    public function isDemo(): bool
    {
        return $this->isEnv(Enums::ENV_DEMO);
    }

    public function isProduction(): bool
    {
        return $this->isEnv(Enums::ENV_PRODUCTION);
    }

    public function isEnv(string $env): bool
    {
        return $this->app()->environment($env);
    }
}
