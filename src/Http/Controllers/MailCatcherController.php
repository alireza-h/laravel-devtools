<?php

namespace AlirezaH\LaravelDevTools\Http\Controllers;

use AlirezaH\LaravelDevTools\Business\Cmds\MailCatcherCmd;
use AlirezaH\LaravelDevTools\Business\Qrys\MailCatcherQry;
use Illuminate\Http\Response;

class MailCatcherController extends Controller
{
    public function index()
    {
        return view(
            'devtools::mails.index',
            (new MailCatcherQry())->getMails()
        );
    }

    public function preview($id)
    {
        return new Response(
            (new MailCatcherQry())->getMail($id)->body
        );
    }

    public function remove($id)
    {
        (new MailCatcherCmd())->remove($id);

        return redirect()->back();
    }

    public function clear()
    {
        (new MailCatcherCmd())->clear();

        return redirect()->back();
    }
}
