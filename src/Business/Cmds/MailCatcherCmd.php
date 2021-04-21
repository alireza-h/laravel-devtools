<?php
/** @noinspection PhpDynamicAsStaticMethodCallInspection */
/** @noinspection PhpUnhandledExceptionInspection */


namespace AlirezaH\LaravelDevTools\Business\Cmds;


use AlirezaH\LaravelDevTools\Entities\MailCatcher;

class MailCatcherCmd extends Cmd
{
    public function remove(int $id)
    {
        MailCatcher::findOrFail($id)->delete();
    }

    public function clear()
    {
        MailCatcher::truncate();
    }
}
