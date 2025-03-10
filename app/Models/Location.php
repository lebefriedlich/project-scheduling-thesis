<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'locations';

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
