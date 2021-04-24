<?php

namespace AlirezaH\LaravelDevTools\Lib\Monolog;


use AlirezaH\LaravelDevTools\Business\Cmds\ErrorLogCmd;
use App\Events\Logs\LogMonologEvent;
use Exception;
use Monolog\Handler\AbstractProcessingHandler;
use Throwable;

class MonologHandler extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        (new ErrorLogCmd())->log(
            $this->getThrowable($record) ?? new Exception($record['message'])
        );
    }

    private function getThrowable(array $record): ?Throwable
    {
        return !empty($record['context']['exception']) && $record['context']['exception'] instanceof Throwable ?
            $record['context']['exception'] : null;
    }
}
