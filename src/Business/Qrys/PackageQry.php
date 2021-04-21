<?php
/** @noinspection PhpDynamicAsStaticMethodCallInspection */


namespace AlirezaH\LaravelDevTools\Business\Qrys;

use Illuminate\Support\Facades\File;

class PackageQry extends Qry
{
    public function getPackages(): array
    {
        return [
            'packages' => $this->getComposerLockPackages(),
        ];
    }

    private function getComposerLockPackages(): array
    {
        return File::exists(base_path('composer.lock'))
            ? json_decode(File::get(base_path('composer.lock')), true)['packages'] ?? [] : [];
    }
}
