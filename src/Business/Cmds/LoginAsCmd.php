<?php

namespace AlirezaH\LaravelDevTools\Business\Cmds;

use Illuminate\Support\Facades\Auth;

class LoginAsCmd extends Cmd
{
    public function loginAs(int $id)
    {
        $this->logout();

        $this->guard()->loginUsingId($id);
    }

    private function logout()
    {
        $this->guard()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    private function guard()
    {
        return Auth::guard();
    }
}
