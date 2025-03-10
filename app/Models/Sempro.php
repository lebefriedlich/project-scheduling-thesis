<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sempro extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'sempro';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function secondMentor()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function semhas()
    {
        return $this->hasOne(Semhas::class);
    }

    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'exam');
    }
}
