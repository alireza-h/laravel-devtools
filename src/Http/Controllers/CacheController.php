<?php


namespace AlirezaH\LaravelDevTools\Http\Controllers;


use AlirezaH\LaravelDevTools\Cmds\CacheCmd;
use AlirezaH\LaravelDevTools\Qrys\CachesQry;
use Illuminate\Http\Request;

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
