<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semhas extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'semhas';

    public function sempro()
    {
        return $this->belongsTo(Sempro::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class);
    }

    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'exam');
    }
}
