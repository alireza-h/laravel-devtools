<?php
/** @noinspection PhpMissingFieldTypeInspection */

namespace AlirezaH\LaravelDevTools\Entities;


/**
 * Class ErrorLog
 * @package AlirezaH\LaravelDevTools\Entities
 *
 * @property string $key
 * @property string $type
 * @property string $message
 * @property int $count
 * @property string $preview
 */
class ErrorLog extends Entity
{
    protected $fillable = [
        'key',
        'type',
        'message',
        'count',
        'preview'
    ];
}
