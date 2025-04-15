<?php

namespace App\Livewire\Admin;

use App\Models\Semhas;
use App\Models\Sempro;
use App\Models\Skripsi;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $sempro =  Sempro::with([
            'schedules' => function ($query) {
                $query->orderBy('schedule_date')
                    ->orderBy('start_time')
                    ->orderBy('end_time');
            },
            'schedules.scheduleLecturers.lecturer',
            'user',
            'schedules.location'
        ])
            ->where('is_submit', true)
            ->whereHas('schedules.scheduleLecturers.lecturer')
            ->get();

        $semhas = Semhas::with([
            'schedules' => function ($query) {
                $query->orderBy('schedule_date')
                    ->orderBy('start_time')
                    ->orderBy('end_time');
            },
            'schedules.scheduleLecturers.lecturer',
            'sempro.user',
            'schedules.location'
        ])
            ->whereHas('sempro', function ($query) {
                $query->where('is_submit', true);
            })
            ->with(['schedules.scheduleLecturers.lecturer', 'sempro.user'])
            ->where('is_submit', true)
            ->whereHas('schedules.scheduleLecturers.lecturer')
            ->get();

        $skripsi = Skripsi::with([
            'schedules' => function ($query) {
                $query->orderBy('schedule_date')
                    ->orderBy('start_time')
                    ->orderBy('end_time');
            },
            'schedules.scheduleLecturers.lecturer',
            'semhas.sempro.user',
            'schedules.location'
        ])
            ->whereHas('semhas.sempro', function ($query) {
                $query->where('is_submit', true);
            })
            ->where('is_submit', true)
            ->whereHas('schedules.scheduleLecturers.lecturer')
            ->get();

        return view('livewire.admin.index', [
            'sempro' => $sempro,
            'semhas' => $semhas,
            'skripsi' => $skripsi,
        ])->layout('layouts.app', [
            'subTitle' => 'Dashboard',
        ])->title('Admin - Dashboard');
    }
}
