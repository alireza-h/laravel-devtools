<?php


namespace AlirezaH\LaravelDevTools\Lib;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait Helpers
{
    /**
     * @param  bool  $assertion
     * @param  array  $messages
     * @param  string|null  $redirectTo
     * @throws null
     */
    protected function assert(
        bool $assertion,
        array $messages = [],
        string $redirectTo = null
    ) {
        if (!$assertion) {
            throw ValidationException::withMessages($messages)
                ->redirectTo($redirectTo);
        }
    }

    protected function assert404(bool $assertion, string $message = '', array $headers = [])
    {
        if (!$assertion) {
            abort(404, $message, $headers);
        }
    }

    protected function assert403(bool $assertion, string $message = '', array $headers = [])
    {
        if (!$assertion) {
            abort(403, $message, $headers);
        }
    }

    protected function validate404(array $data, array $rules)
    {
        if (Validator::make($data, $rules)->fails()) {
            abort(404);
        }
    }

    protected function validateWithRules(array $data, array $rules)
    {
        Validator::make($data, $rules)->validate();
    }
}
