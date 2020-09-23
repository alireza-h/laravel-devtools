<?php


namespace AlirezaH\LaravelDevTools\Lib\Schema;


abstract class Schema
{
    public function getSchema(): array
    {
        $tables = [];
        foreach ($this->tables() as $table) {
            $tables[$table]['definition'] = $this->fields($table);
            $tables[$table]['indexes'] = $this->indexes($table);
        }

        return $tables;
    }

    abstract protected function tables(): array;

    abstract protected function fields(string $table): array;

    abstract protected function indexes(string $table): array;
}
