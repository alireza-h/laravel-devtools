<?php


namespace AlirezaH\LaravelDevTools\Http\Controllers;


use AlirezaH\LaravelDevTools\Qrys\PackageQry;

class PackageController extends Controller
{
    public function index()
    {
        return view(
            'devtools::package.index',
            (new PackageQry())->getPackages()
        );
    }
}
