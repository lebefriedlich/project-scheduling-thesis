<?php

namespace App\Livewire\Admin\AccSchedule;

use App\Mail\ScheduleNotification;
use App\Models\Lecturer;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\ScheduleLecturer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{
    public $exam_id, $exam_type, $exam;
    public $location, $schedule_date, $start_time, $end_time, $description;
    public $examiner_chairman, $examiner_1, $examiner_2, $examiner_3;
    public $startScheduleDate, $endScheduleDate;
    public $lecturers = [];

    public $rules = [
        'location' => 'required|exists:locations,id',
        'schedule_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'description' => 'nullable|string|max:255',
        'examiner_chairman' => 'required|exists:lecturers,id',
        'examiner_1' => 'required|exists:lecturers,id',
        'examiner_2' => 'required|exists:lecturers,id',
        'examiner_3' => 'nullable|exists:lecturers,id',
    ];

    public $messages = [
        'location.required' => 'Lokasi tidak boleh kosong',
        'location.exists' => 'Lokasi tidak valid',
        'schedule_date.required' => 'Tanggal tidak boleh kosong',
        'schedule_date.date' => 'Format tanggal tidak valid',
        'start_time.required' => 'Jam mulai tidak boleh kosong',
        'start_time.date_format' => 'Format jam mulai tidak valid',
        'end_time.required' => 'Jam selesai tidak boleh kosong',
        'end_time.date_format' => 'Format jam selesai tidak valid',
        'end_time.after' => 'Jam selesai harus setelah jam mulai',
        'description.string' => 'Deskripsi harus berupa string',
        'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter',
        'examiner_chairman.required' => 'Ketua penguji tidak boleh kosong',
        'examiner_chairman.exists' => 'Ketua penguji tidak valid',
        'examiner_1.required' => 'Penguji 1 tidak boleh kosong',
        'examiner_1.exists' => 'Penguji 1 tidak valid',
        'examiner_2.required' => 'Penguji 2 tidak boleh kosong',
        'examiner_2.exists' => 'Penguji 2 tidak valid',
        'examiner_3.nullable' => 'Penguji 3 boleh kosong',
        'examiner_3.exists' => 'Penguji 3 tidak valid',
    ];

    public function mount($exam_id, $exam_type)
    {
        $this->exam_id = $exam_id;
        $this->exam = $exam_type;
        $this->lecturers = Lecturer::select('id', 'name')->get();

        $modelMap = [
            'Sempro' => \App\Models\Sempro::class,
            'Semhas' => \App\Models\Semhas::class,
            'Skripsi' => \App\Models\Skripsi::class,
        ];

        $this->exam_type = $modelMap[$exam_type];

        if ($this->exam_type == \App\Models\Sempro::class) {
            $sempro = \App\Models\Sempro::with('periode')->find($exam_id);
            if ($sempro) {
                $this->examiner_2 = $sempro->mentor_id;
                $this->examiner_3 = $sempro->second_mentor_id;
                $this->startScheduleDate = $sempro->periode->start_schedule;
                $this->endScheduleDate = $sempro->periode->end_schedule;
            }
        } elseif ($this->exam_type == \App\Models\Semhas::class) {
            $semhas = \App\Models\Semhas::with(['periode', 'sempro.schedules.scheduleLecturers'])->find($exam_id);
            if ($semhas) {
                $this->examiner_2 = $semhas->sempro->mentor_id;
                $this->examiner_3 = $semhas->sempro->second_mentor_id;
                $this->startScheduleDate = $semhas->periode->start_schedule;
                $this->endScheduleDate = $semhas->periode->end_schedule;

                $semproSchedule = $semhas->sempro->schedules;
                $firstSchedule = $semproSchedule->first();
                if ($firstSchedule) {
                    $scheduleLecturers = $firstSchedule->scheduleLecturers;
                    $this->examiner_chairman = $scheduleLecturers->firstWhere('role', 'Master')?->lecturer_id;
                    $this->examiner_1 = $scheduleLecturers->firstWhere('role', 'Examiner 1')?->lecturer_id;
                }
            }
        } elseif ($this->exam_type == \App\Models\Skripsi::class) {
            $skripsi = \App\Models\Skripsi::with('semhas.sempro', 'periode')->find($exam_id);
            if ($skripsi) {
                $this->examiner_2 = $skripsi->semhas->sempro->mentor_id;
                $this->examiner_3 = $skripsi->semhas->sempro->second_mentor_id;
                $this->startScheduleDate = $skripsi->periode->start_schedule;
                $this->endScheduleDate = $skripsi->periode->end_schedule;
            }
        }
    }

    public function render()
    {
        $locations = Location::all();

        return view('livewire.admin.acc-schedule.index', [
            'locations' => $locations
        ])
            ->layout('layouts.app', [
                'subTitle' => 'Acc Schedule ' . $this->exam,
            ])->title('Acc Schedule ' . $this->exam);
    }

    public function submit()
    {
        $this->validate();

        $lecturer_ids = [$this->examiner_chairman, $this->examiner_1, $this->examiner_2, $this->examiner_3];

        // Memeriksa apakah ada konflik lokasi
        if (Schedule::isLocationConflict($this->location, $this->schedule_date, $this->start_time, $this->end_time)) {
            $this->dispatch('flashMessage', [
                'type' => 'error',
                'message' => 'Lokasi sudah digunakan pada waktu tersebut.',
            ]);
            return;
        }

        // Memeriksa apakah ada konflik dengan jadwal dosen
        if (Schedule::isLecturerConflict($lecturer_ids, $this->schedule_date, $this->start_time, $this->end_time)) {
            $this->dispatch('flashMessage', [
                'type' => 'error',
                'message' => 'Dosen memiliki jadwal yang bertabrakan.',
            ]);
            return;
        }

        // Menyimpan data jadwal
        $schedule = Schedule::create([
            'exam_id' => $this->exam_id,
            'exam_type' => $this->exam_type,
            'location_id' => $this->location,
            'schedule_date' => $this->schedule_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        // Menyimpan data dosen yang terlibat sebagai penguji
        $examiner_roles = [
            'examiner_chairman' => 'Master',
            'examiner_1' => 'Examiner 1',
            'examiner_2' => 'Examiner 2',
            'examiner_3' => 'Examiner 3'
        ];

        foreach ($examiner_roles as $examiner_field => $role) {
            if ($this->$examiner_field) {
                $scheduleLecturer = ScheduleLecturer::create([
                    'schedule_id' => $schedule->id,
                    'lecturer_id' => $this->$examiner_field,
                    'role' => $role,
                ]);
            }
        }

        // Mengambil nama dosen dari ScheduleLecturer yang terhubung
        $master = ScheduleLecturer::where('schedule_id', $schedule->id)->where('role', 'Master')->first();
        $examiner_1 = ScheduleLecturer::where('schedule_id', $schedule->id)->where('role', 'Examiner 1')->first();
        $examiner_2 = ScheduleLecturer::where('schedule_id', $schedule->id)->where('role', 'Examiner 2')->first();
        $examiner_3 = ScheduleLecturer::where('schedule_id', $schedule->id)->where('role', 'Examiner 3')->first();

        // Ambil nama dosen
        $master_name = $master ? $master->lecturer->name : null;
        $examiner_1_name = $examiner_1 ? $examiner_1->lecturer->name : null;
        $examiner_2_name = $examiner_2 ? $examiner_2->lecturer->name : null;
        $examiner_3_name = $examiner_3 ? $examiner_3->lecturer->name : null;

        // Kirim email notifikasi jika ada user terkait
        $this->sendScheduleNotification($schedule, $master_name, $examiner_1_name, $examiner_2_name, $examiner_3_name);

        session()->flash('success', 'Jadwal berhasil disimpan.');
        $this->reset([
            'location',
            'schedule_date',
            'start_time',
            'end_time',
            'description',
            'examiner_chairman',
            'examiner_1',
            'examiner_2',
            'examiner_3',
        ]);

        return redirect()->route('admin.index');
    }

    protected function sendScheduleNotification($schedule, $master_name, $examiner_1_name, $examiner_2_name, $examiner_3_name)
    {
        $user = null;

        // Tentukan user berdasarkan exam_type
        if ($this->exam_type == \App\Models\Sempro::class) {
            $sempro = \App\Models\Sempro::with('user')->find($this->exam_id);
            $user = $sempro ? $sempro->user : null;
        } elseif ($this->exam_type == \App\Models\Semhas::class) {
            $semhas = \App\Models\Semhas::with('sempro.user')->find($this->exam_id);
            $user = $semhas ? $semhas->sempro->user : null;
        } elseif ($this->exam_type == \App\Models\Skripsi::class) {
            $skripsi = \App\Models\Skripsi::with('semhas.sempro.user')->find($this->exam_id);
            $user = $skripsi ? $skripsi->semhas->sempro->user : null;
        }

        if ($user) {
            $examTypeMap = [
                'Sempro' => 'Seminar Proposal',
                'Semhas' => 'Seminar Hasil',
                'Skripsi' => 'Sidang Skripsi',
            ];

            $subject = "[INFO] Jadwal " . $examTypeMap[$this->exam] . " - " . $user->name;
            $data = [
                'user_name' => $user->name,
                'exam_type' => $examTypeMap[$this->exam],
                'schedule_date' => Carbon::parse($this->schedule_date)->locale('id')->isoFormat('D MMMM YYYY'),
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'location' => $schedule->location->name,
                'master_lecturer' => $master_name,
                'examiner_1_lecturer' => $examiner_1_name,
                'examiner_2_lecturer' => $examiner_2_name,
                'examiner_3_lecturer' => $examiner_3_name,
            ];

            Mail::to($user->email)->send(new ScheduleNotification($data, $subject));
        }
    }
}
