<?php

namespace AlirezaH\LaravelDevTools\Lib\Monolog;

use AlirezaH\LaravelDevTools\Business\Cmds\ErrorLogCmd;
use Monolog\Handler\AbstractProcessingHandler;
use Exception;
use Throwable;

class MonologHandler extends AbstractProcessingHandler
{
    protected function write(\Monolog\LogRecord $record): void
    {
        (new ErrorLogCmd())->log(
            $this->getThrowable($record) ?? new Exception($record->message)
        );
    }

    private function getThrowable(\Monolog\LogRecord $record): ?Throwable
    {
        return !empty($record->context['exception']) && $record->context['exception'] instanceof Throwable ?
            $record->context['exception'] : null;
    }
}
