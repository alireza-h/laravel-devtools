<?php


namespace AlirezaH\LaravelDevTools\Http\Controllers;


use AlirezaH\LaravelDevTools\Cmds\LoginAsCmd;
use AlirezaH\LaravelDevTools\Qrys\DevQry;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
        return view('devtools::index');
    }

    public function phpinfo()
    {
        echo phpinfo();
    }

    public function tools()
    {
        return view('devtools::tools.index');
    }

    public function postTools(Request $request)
    {
        return view('devtools::tools.result', [
            'result' => (new DevQry())->tools($request->post())
        ]);
    }

    public function loginAs(Request $request)
    {
        (new LoginAsCmd())->loginAs($request->post('id'));

        return redirect()->to(config('devtools.redirect_to_after_login_as', '/'));
    }

    public function password(Request $request)
    {
        return view('devtools::password.password', [
            'hash' => $request->get('password') ? (new DevQry())->hashPassword($request->get('password')) : null
        ]);
    }

    public function hash(Request $request)
    {
        return view('devtools::password.hash', [
            'hash' => (new DevQry())->hashPassword($request->post('password'))
        ]);
    }
}
