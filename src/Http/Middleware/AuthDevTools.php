<?php

namespace AlirezaH\LaravelDevTools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthDevTools
{
    private const HEADER_WWW_AUTHENTICATE = ['WWW-Authenticate' => 'Basic realm="Dev"'];
    private const HEADER_PHP_AUTH_USER = 'PHP_AUTH_USER';
    private const HEADER_PHP_AUTH_PW = 'PHP_AUTH_PW';

    private $users;

    public function __construct()
    {
        $this->users = config('devtools.users');
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->authenticate($request)) {
            return new Response('Invalid credentials.', 401, self::HEADER_WWW_AUTHENTICATE);
        }

        return $next($request);
    }

    private function authenticate(Request $request): bool
    {
        return $this->getUserName($request) && $this->getPassword($request) && $this->check($request);
    }

    private function check(Request $request): bool
    {
        return !empty($this->users[$this->getUserName($request)])
            && password_verify($this->getPassword($request), $this->users[$this->getUserName($request)]);
    }

    private function getUserName(Request $request): ?string
    {
        return $request->header(self::HEADER_PHP_AUTH_USER) ?? null;
    }

    private function getPassword(Request $request): ?string
    {
        return $request->header(self::HEADER_PHP_AUTH_PW) ?? null;
    }
}
