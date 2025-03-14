<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleLecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Validator;

class SchedulingController extends Controller
{

    public function index()
    {
        $results = DB::table(function ($query) {
            $query->select('id', 'user_id', 'periode_id', 'is_submit', 'updated_at', DB::raw('"Sempro" as jenis'))
                ->from('sempro')
                ->where('is_submit', true)
                ->unionAll(
                    DB::table('semhas')
                        ->select('id', 'sempro_id as user_id', 'periode_id', 'is_submit', 'updated_at', DB::raw('"Semhas" as jenis'))
                        ->where('is_submit', true)
                )
                ->unionAll(
                    DB::table('skripsi')
                        ->select('id', 'semhas_id as user_id', 'periode_id', 'is_submit', 'updated_at', DB::raw('"Skripsi" as jenis'))
                        ->where('is_submit', true)
                );
        }, 'combined')
            ->orderBy('updated_at', 'asc')
            ->get();


        // return data response
    }

    public function scheduling(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'in' => 'The selected :attribute is invalid.',
            'date' => 'The :attribute is not a valid date.',
            'date_format' => 'The :attribute does not match the format H:i.',
            'after' => 'The :attribute must be a date after start time.'
        ];

        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'exam_id' => 'required|integer',
            'exam_type' => 'required|in:in:Sempro,Semhas,Skripsi',
            'schedule_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'lecturer_id' => 'required|array',
            'lecturer_id.*' => 'required|exists:lecturers,id',
            'role' => 'required|array',
            'role.*' => 'required|in:Master,Examiner 1,Examiner 2,Examiner 3',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            // return validation error
        }

        if (Schedule::isScheduleConflict($request->location_id, $request->schedule_date, $request->start_time, $request->end_time, $request->exam_type)) {
            // return back()->withErrors(['schedule' => 'Jadwal bentrok dengan jadwal lain di lokasi yang sama untuk ' . class_basename($request->exam_type) . '!']);
        }

        $modelMap = [
            'Sempro' => 'App\Models\Sempro',
            'Semhas' => 'App\Models\Semhas',
            'Skripsi' => 'App\Models\Skripsi',
        ];

        $schedule = Schedule::create([
            'exam_id' => $request->exam_id,
            'exam_type' => $modelMap[$request->exam_type],
            'location_id' => $request->location_id,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        foreach ($request->lecturer_id as $key => $lecturerId) {
            ScheduleLecturer::create([
                'schedule_id' => $schedule->id,
                'lecturer_id' => $lecturerId,
                'role' => $request->role[$key],
                'description' => $request->description[$key] ?? null,
            ]);
        }

        // return success response
    }

    public function updateScheduling(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            // return not found response
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute is invalid.',
            'in' => 'The selected :attribute is invalid.',
            'date' => 'The :attribute is not a valid date.',
            'date_format' => 'The :attribute does not match the format H:i.',
            'after' => 'The :attribute must be a date after start time.'
        ];

        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'exam_id' => 'required|integer',
            'exam_type' => 'required|in:in:Sempro,Semhas,Skripsi',
            'schedule_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'lecturer_id' => 'required|array',
            'lecturer_id.*' => 'required|exists:lecturers,id',
            'role' => 'required|array',
            'role.*' => 'required|in:Master,Examiner 1,Examiner 2,Examiner 3',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            // return validation error
        }

        if (Schedule::isScheduleConflict($request->location_id, $request->schedule_date, $request->start_time, $request->end_time, $request->exam_type, $id)) {
            // return back()->withErrors(['schedule' => 'Jadwal bentrok dengan jadwal lain di lokasi yang sama untuk ' . class_basename($request->exam_type) . '!']);
        }

        $modelMap = [
            'Sempro' => 'App\Models\Sempro',
            'Semhas' => 'App\Models\Semhas',
            'Skripsi' => 'App\Models\Skripsi',
        ];

        $schedule->update([
            'exam_id' => $request->exam_id,
            'exam_type' => $modelMap[$request->exam_type],
            'location_id' => $request->location_id,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $schedule->lecturers()->delete();

        foreach ($request->lecturer_id as $key => $lecturerId) {
            ScheduleLecturer::create([
                'schedule_id' => $schedule->id,
                'lecturer_id' => $lecturerId,
                'role' => $request->role[$key],
                'description' => $request->description[$key] ?? null,
            ]);
        }

        // return success response
    }

    public function deleteScheduling($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            // return not found response
        }

        $schedule->delete();

        // return success response
    }
}
