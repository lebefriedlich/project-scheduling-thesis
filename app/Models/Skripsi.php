<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'skripsi';

    public function semhas()
    {
        return $this->belongsTo(Semhas::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'exam');
    }
}
