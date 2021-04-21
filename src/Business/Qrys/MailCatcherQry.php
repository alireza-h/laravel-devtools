<?php
/** @noinspection PhpDynamicAsStaticMethodCallInspection */


namespace AlirezaH\LaravelDevTools\Business\Qrys;

use AlirezaH\LaravelDevTools\Entities\MailCatcher;

class MailCatcherQry extends Qry
{
    private const PER_PAGE = 20;

    public function getMails(): array
    {
        $mails = MailCatcher::orderBy('id', 'desc')
            ->paginate(self::PER_PAGE);

        return [
            'mails' => $mails,
            'urls' => [
                'clear' => route('devtools.mails.clear'),
            ]
        ];
    }

    public function getMail(int $id)
    {
        return MailCatcher::findOrFail($id);
    }
}
