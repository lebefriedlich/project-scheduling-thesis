<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingSchedule extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'teaching_schedules';

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
