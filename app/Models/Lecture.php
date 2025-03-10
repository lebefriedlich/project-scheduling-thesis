<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'lectures';

    public function sempros()
    {
        return $this->hasMany(Sempro::class, 'mentor_id');
    }

    public function secondSempros()
    {
        return $this->hasMany(Sempro::class, 'second_mentor_id');
    }

    public function scheduleLectures()
    {
        return $this->hasMany(ScheduleLecture::class);
    }
}
