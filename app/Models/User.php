<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasVersion4Uuids as HasUuids; 
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuids;

    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'users';

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

    public function sempros()
    {
        return $this->hasMany(Sempro::class);
    }
}
