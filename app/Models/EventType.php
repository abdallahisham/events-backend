<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EventType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventType extends Model
{
    //
}
