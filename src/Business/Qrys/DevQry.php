<?php

namespace AlirezaH\LaravelDevTools\Business\Qrys;

class DevQry extends Qry
{
    private const TOOLS_TYPE_MODEL = 'model';

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function tools(array $data)
    {
        switch ($data['type']) {
            case self::TOOLS_TYPE_MODEL:
                $this->assert(class_exists($data['class']));
                $this->assert(!empty($data['id']));
                $model = !empty($data['with']) ? $data['class']::with($data['with'])->find(
                    $data['id']
                ) : $data['class']::find($data['id']);
                dd(
                    array_only($data, ['id', 'class', 'with']),
                    $model
                );
        }
    }
}
