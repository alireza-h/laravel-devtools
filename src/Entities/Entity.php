<?php
/** @noinspection PhpDynamicAsStaticMethodCallInspection */

namespace AlirezaH\LaravelDevTools\Entities;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 *
 * @mixin Builder
 * @mixin Model
 *
 */
class Entity extends Model
{

}
