<?php
/** @noinspection PhpMissingFieldTypeInspection */

namespace AlirezaH\LaravelDevTools\Entities;


/**
 * Class ErrorLog
 * @package AlirezaH\LaravelDevTools\Entities
 *
 * @property string $to
 * @property string $from
 * @property string $subject
 * @property string $content_type
 * @property string $body
 */
class MailCatcher extends Entity
{
    protected $fillable = [
        'to',
        'from',
        'subject',
        'content_type',
        'body'
    ];

    protected $casts = [
        'to' => 'array',
        'from' => 'array',
    ];
}
