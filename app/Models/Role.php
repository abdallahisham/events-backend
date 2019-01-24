<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
