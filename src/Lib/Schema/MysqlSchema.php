<?php


namespace AlirezaH\LaravelDevTools\Lib\Schema;


use Illuminate\Support\Facades\DB;

class MysqlSchema extends Schema
{
    protected function tables(): array
    {
        return array_map(function ($table) {
            return reset($table);
        }, DB::select('SHOW TABLES'));
    }

    protected function fields(string $table): array
    {
        $fields = [];
        foreach (DB::select("DESCRIBE $table") as $fieldAttributes) {
            $fieldAttributes = get_object_vars($fieldAttributes);
            $fields[$fieldAttributes['Field']] = $fieldAttributes;
        }

        return $fields;
    }

    protected function indexes(string $table): array
    {
        $indexes = [];
        foreach (DB::select("SHOW INDEX FROM $table") as $index) {
            $index = get_object_vars($index);
            $indexes[] = $index;
        }

        return $indexes;
    }
}
