<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleLecture extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'schedule_lectures';

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
