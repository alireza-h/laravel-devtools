<?php

/** @noinspection PhpDynamicAsStaticMethodCallInspection */

namespace AlirezaH\LaravelDevTools\Listeners;

use AlirezaH\LaravelDevTools\Entities\MailCatcher;
use AlirezaH\LaravelDevTools\Lib\Env;
use Illuminate\Mail\Events\MessageSending;

class MailCatcherListener
{
    use Env;

    public function handle(MessageSending $message)
    {
        if (in_array($this->env(), config('devtools.mail_catcher.envs'))) {
            $this->catch($message);
        }

        return $this->isProduction();
    }

    private function catch(MessageSending $message)
    {
        MailCatcher::create(
            [
                'to' => $message->message->getTo(),
                'from' => $message->message->getFrom(),
                'subject' => $message->message->getSubject(),
                'content_type' => $message->message->getBody()->getMediaSubtype(),
                'body' => $message->message->getBody()->getBody(),
                // 'queue' => $message->data['queue'],
                // 'delay' => $message->data['delay'],
            ]
        );
    }
}
