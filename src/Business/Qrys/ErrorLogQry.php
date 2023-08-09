<?php

namespace AlirezaH\LaravelDevTools\Business\Qrys;

use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogger;
use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogItem;
use DateTime;
use Illuminate\Support\Carbon;

class ErrorLogQry extends Qry
{
    private ErrorLogger $errorLogger;

    public function __construct()
    {
        $this->errorLogger = $this->app(ErrorLogger::class);
    }

    public function getAllErrors(string $type = 'error'): array
    {
        $errors = [];
        $allErrors = $this->errorLogger->getAllErrors($type);
        /** @var ErrorLogItem $errorLogItem */
        foreach ($allErrors as $errorLogItem) {
            $errors[$errorLogItem->key] = [
                'error' => substr($errorLogItem->message ?? '', 0, 150),
                'count' => $errorLogItem->count,
                'timestamp' => $errorLogItem->timestamp,
                'time' => Carbon::createFromTimestamp($errorLogItem->timestamp)
                        ->locale('en')
                        ->diffForHumans(['short' => true, 'parts' => 3]) .
                    PHP_EOL . (new DateTime())->setTimestamp($errorLogItem->timestamp)->format('Y-m-d H:i:s'),
                'previewUrl' => route('devtools.errors.preview', ['id' => $errorLogItem->key, 'type' => $type]),
                'removeUrl' => route('devtools.errors.remove', ['id' => $errorLogItem->key, 'type' => $type]),
            ];
        }

        uasort(
            $errors,
            static function ($a, $b) {
                return $a['timestamp'] < $b['timestamp'];
            }
        );

        return [
            'errorLogs' => $errors,
            'urls' => [
                'clear' => route('devtools.errors.clear', ['type' => $type]),
                'clearOld' => route('devtools.errors.clear.old', ['type' => $type]),
            ]
        ];
    }

    public function getError(string $id, string $type = 'error'): ?ErrorLogItem
    {
        return $this->errorLogger->getError($id, $type);
    }
}
