<?php


namespace AlirezaH\LaravelDevTools\Http\Controllers;


use AlirezaH\LaravelDevTools\Business\Qrys\CommandQry;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        return view('devtools::command.index', [
            'commands' => (new CommandQry())->getCommands()
        ]);
    }

    public function run(Request $request)
    {
        return view('devtools::command.run', [
            'result' => (new CommandQry())->run($request->get('command'))
        ]);
    }
}
