<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'periodes';

    public function sempros()
    {
        return $this->hasMany(Sempro::class);
    }

    public function semhas()
    {
        return $this->hasMany(Semhas::class);
    }

    public function skripsis()
    {
        return $this->hasMany(Skripsi::class);
    }
}
