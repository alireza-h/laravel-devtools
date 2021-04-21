<?php


namespace AlirezaH\LaravelDevTools\Business\Qrys;


use AlirezaH\LaravelDevTools\Lib\Schema\Schema;

class SchemaQry extends Qry
{
    private Schema $schema;

    public function __construct()
    {
        $this->schema = $this->app(Schema::class);
    }

    public function getSchema()
    {
        return  $this->schema->getSchema();
    }
}
