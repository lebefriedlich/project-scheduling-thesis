<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleLecturer extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'schedule_lecturers';

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
