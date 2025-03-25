<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ScheduleNotification;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\ScheduleLecturer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            'date_format' => 'The :attribute does not match the format H:i.',
            'after' => 'The :attribute must be a date after start time.'
        ];

        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'exam_id' => 'required|integer',
            'exam_type' => 'required|in:Sempro,Semhas,Skripsi',
            'schedule_date' => 'required|date_format:d F Y',
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

        DB::beginTransaction();
        try {
            $modelMap = [
                'Sempro' => \App\Models\Sempro::class,
                'Semhas' => \App\Models\Semhas::class,
                'Skripsi' => \App\Models\Skripsi::class,
            ];

            $periode = \App\Models\Periode::where('type', strtolower($request->exam_type))
                ->where('start_schedule', '<=', $request->schedule_date)
                ->where('end_schedule', '>=', $request->schedule_date)
                ->first();

            if (!$periode) {
                // return back()->withErrors(['error' => 'Tanggal yang anda masukkan tidak sesuai dengan periode ' . $request->exam_type . '!']);
            }

            $schedule = Schedule::create([
                'exam_id' => $request->exam_id,
                'exam_type' => $modelMap[$request->exam_type],
                'location_id' => $request->location_id,
                'schedule_date' => $request->schedule_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            $lecturers = Lecturer::whereIn('id', $request->lecturer_id)->pluck('name', 'id');

            $masterLecturer = $examiner1Lecturer = $examiner2Lecturer = $examiner3Lecturer = null;

            foreach ($request->lecturer_id as $key => $lecturerId) {
                $scheduleLecturer = ScheduleLecturer::create([
                    'schedule_id' => $schedule->id,
                    'lecturer_id' => $lecturerId,
                    'role' => $request->role[$key],
                    'description' => $request->description[$key] ?? null,
                ]);

                $lecturerName = $lecturers[$lecturerId] ?? null;

                match ($scheduleLecturer->role) {
                    'Master' => $masterLecturer = $lecturerName,
                    'Examiner 1' => $examiner1Lecturer = $lecturerName,
                    'Examiner 2' => $examiner2Lecturer = $lecturerName,
                    'Examiner 3' => $examiner3Lecturer = $lecturerName,
                };
            }

            $examModel = $modelMap[$request->exam_type]::find($request->exam_id);

            $user = $examModel ? $examModel->user : null;

            if ($user) {
                $examTypeMap = [
                    'Sempro' => 'Seminar Proposal',
                    'Semhas' => 'Seminar Hasil',
                    'Skripsi' => 'Sidang Skripsi',
                ];

                $subject = "[INFO] Jadwal " . $examTypeMap[$request->exam_type] . " - " . $user->name;
                $data = [
                    'user_name' => $user->name,
                    'exam_type' => $examTypeMap[$request->exam_type],
                    'schedule_date' => $request->schedule_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'location' => $schedule->location->name,
                    'master_lecturer' => $masterLecturer,
                    'examiner_1_lecturer' => $examiner1Lecturer,
                    'examiner_2_lecturer' => $examiner2Lecturer,
                    'examiner_3_lecturer' => $examiner3Lecturer,
                ];

                Mail::to($user->email)->send(new ScheduleNotification($data, $subject));
            }

            if ($periode && $periode->quota > 0) {
                $periode->decrement('quota');
            }

            DB::commit();

            // return success response
        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data jadwal!']);
        }
    }
}
