<?php

namespace AlirezaH\LaravelDevTools\Http\Controllers;

use AlirezaH\LaravelDevTools\Business\Cmds\CacheCmd;
use AlirezaH\LaravelDevTools\Business\Qrys\CachesQry;
use App\Mail\CatchMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CacheController extends Controller
{
    public function index()
    {
        return view(
            'devtools::cache.index',
            ['tagGroups' => (new CachesQry())->getCacheTags()]
        );
    }

    public function flush(Request $request)
    {
        if (!empty($request->post('tag'))) {
            (new CacheCmd())->flushTag($request->post('tag'));
        } elseif (!empty($request->post('custom_tag'))) {
            (new CacheCmd())->flushTag($request->post('custom_tag'));
        } elseif (!empty($request->post('custom_key'))) {
            (new CacheCmd())->flushKey($request->post('custom_key'));
        }

        return redirect()->back();
    }
}
