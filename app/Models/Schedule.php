<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'schedules';

    public function exam()
    {
        return $this->morphTo();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scheduleLectures()
    {
        return $this->hasMany(ScheduleLecture::class);
    }
}
