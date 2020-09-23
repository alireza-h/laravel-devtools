<?php


namespace AlirezaH\LaravelDevTools\Lib\Schema;


use Illuminate\Support\Facades\DB;

class SqliteSchema extends Schema
{
    protected function tables(): array
    {
        $tables = DB::select("SELECT * FROM sqlite_master WHERE type='table'");
        $tables = array_map(function ($table) {
            return property_exists($table, 'name') ? $table->name : null;
        }, $tables);

        return array_filter($tables);
    }

    protected function fields(string $table): array
    {
        $fields = [];
        foreach (DB::select("PRAGMA table_info({$table})") as $fieldAttributes) {
            $fieldAttributes = get_object_vars($fieldAttributes);
            $fields[$fieldAttributes['name']] = $fieldAttributes;
        }

        return $fields;
    }

    protected function indexes(string $table): array
    {
        $indexes = [];
        foreach (DB::select("PRAGMA index_list({$table})") as $index) {
            $index = get_object_vars($index);
            $indexes[] = $index;
        }

        return $indexes;
    }
}
