<?php

namespace AlirezaH\LaravelDevTools\Http\Controllers;

use AlirezaH\LaravelDevTools\Business\Cmds\ErrorLogCmd;
use AlirezaH\LaravelDevTools\Business\Qrys\ErrorLogQry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ErrorLogController extends Controller
{
    public function index(Request $request)
    {
        return view(
            'devtools::errors.index',
            (new ErrorLogQry())->getAllErrors($request->get('type', 'error'))
        );
    }

    public function preview(Request $request, $id)
    {
        $error = (new ErrorLogQry())->getError($id, $request->get('type', 'error'));
        abort_if($error === null || !$error->preview, 404);

        return new Response($error->preview);
    }

    public function remove(Request $request, $id)
    {
        (new ErrorLogCmd())->remove($id, $request->get('type', 'error'));

        return redirect()->back();
    }

    public function clear(Request $request)
    {
        (new ErrorLogCmd())->clear($request->get('type', 'error'));

        return redirect()->back();
    }

    public function clearOld(Request $request)
    {
        (new ErrorLogCmd())->clearOld($request->get('type', 'error'));

        return redirect()->back();
    }
}
