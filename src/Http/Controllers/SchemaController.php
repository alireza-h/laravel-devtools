<?php


namespace AlirezaH\LaravelDevTools\Http\Controllers;


use AlirezaH\LaravelDevTools\Business\Qrys\SchemaQry;

class SchemaController extends Controller
{
    public function tables()
    {
        return view('devtools::schema.tables', [
            'schema' => (new SchemaQry())->getSchema()
        ]);
    }
}
