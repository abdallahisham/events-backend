<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Event
 *
 * @property int $id
 * @property string $name
 * @property int $event_type_id
 * @property float $position_latitude
 * @property float $position_longitude
 * @property string $image
 * @property string $description
 * @property int $is_free
 * @property float|null $price
 * @property int $max_tickets_count
 * @property int $has_sponsors
 * @property int $user_id
 * @property int $nothing
 * @property string $address
 * @property string $venue
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string $start_time
 * @property string $start_time_format
 * @property string $end_time
 * @property string $end_time_format
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed|User $user
 * @property mixed $image_url
 * @property mixed $duration
 * @property mixed $going
 * @property mixed $liked_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereHasSponsors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereMaxTicketsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event wherePositionLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event wherePositionLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'start_date', 'end_date',
    ];

    protected $appends = [
        'image_url', 'duration', 'start_time_format', 'end_time_format'
    ];

    protected static function boot()
    {
        parent::boot();
        /*static::addGlobalScope(function ($query) {
            $todayDateString = Carbon::now()->format('Y-m-d');
            $query->where('end_date', '>=' , $todayDateString);
        });*/
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function going()
    {
        return $this->belongsToMany(User::class, 'booking', 'user_id', 'event_id');
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'event_user', 'user_id', 'event_id');
    }

    // Accessors and mutators
    public function getImageUrlAttribute()
    {
        $baseUrl = env('APP_URL');
        return "{$baseUrl}/storage/{$this->user_id}/{$this->image}";
    }

    public function getDurationAttribute()
    {
        return $this->start_date->diff($this->end_date)->days + 1;
    }

    public function getStartTimeFormatAttribute()
    {
        [$hour, $minute] = explode(':', $this->start_time);
        return Carbon::createFromTime($hour, $minute, 0)->format('h:i A');
    }

    public function getEndTimeFormatAttribute()
    {
        [$hour, $minute] = explode(':', $this->end_time);
        return Carbon::createFromTime($hour, $minute, 0)->format('h:i A');
    }
}
