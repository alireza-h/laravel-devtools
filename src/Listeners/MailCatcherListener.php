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
        if ($this->isProduction()) {
            return true;
        }

        if (in_array($this->env(), config('devtools.mail_catcher.envs'))) {
            $this->catch($message);

            return false;
        }

        return true;
    }

    private function catch(MessageSending $message)
    {
        MailCatcher::create(
            [
                'to' => $message->message->getTo(),
                'from' => $message->message->getFrom(),
                'subject' => $message->message->getSubject(),
                'content_type' => $message->message->getBodyContentType(),
                'body' => $message->message->getBody(),
                // 'queue' => $message->data['queue'],
                // 'delay' => $message->data['delay'],
            ]
        );
    }
}
