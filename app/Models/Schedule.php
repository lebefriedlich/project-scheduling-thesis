<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scheduleLecturers()
    {
        return $this->hasMany(ScheduleLecturer::class);
    }

    public static function isLocationConflict($location_id, $schedule_date, $start_time, $end_time)
    {
        return self::where('location_id', $location_id)
            ->where('schedule_date', $schedule_date)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })
            ->exists();
    }

    public static function isLecturerConflict($lecturer_ids, $schedule_date, $start_time, $end_time)
    {
        if (!empty($lecturer_ids)) {
            // Ubah schedule_date ke nama hari dalam bahasa Indonesia
            $day = Carbon::parse($schedule_date)->translatedFormat('l');

            return \App\Models\TeachingSchedule::whereIn('lecturer_id', $lecturer_ids)
                ->where('day', $day)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($query) use ($start_time, $end_time) {
                            $query->where('start_time', '<=', $start_time)
                                ->where('end_time', '>=', $end_time);
                        });
                })
                ->exists();
        }

        return false;
    }
}
