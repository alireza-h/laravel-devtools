<?php


namespace AlirezaH\LaravelDevTools\Business\Qrys;

use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogger;
use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogItem;
use AlirezaH\LaravelDevTools\Lib\TimeAgo;
use DateTime;

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
                'time' => $this->getTimeAgo($errorLogItem->timestamp),
                'previewUrl' => route('devtools.errors.preview', ['id' => $errorLogItem->key, 'type' => $type]),
                'removeUrl' => route('devtools.errors.remove', ['id' => $errorLogItem->key, 'type' => $type]),
            ];
        };

        uasort(
            $errors,
            function ($a, $b) {
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

    public function getError(string $id, string $type = 'error')
    {
        return $this->errorLogger->getError($id, $type);
    }

    private function getTimeAgo(string $timestamp): string
    {
        return (new TimeAgo())->getTimeAgoString(
            (new DateTime())->setTimestamp($timestamp),
            2
        );
    }
}
