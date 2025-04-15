<?php

namespace App\Livewire\Admin\Submission;

use App\Models\Semhas;
use App\Models\Sempro;
use App\Models\Skripsi;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $sempro =  Sempro::with(['user', 'periode', 'mentor', 'secondMentor'])
            ->where('is_submit', true)
            ->doesntHave('schedules')
            ->get();
        $semhas = Semhas::with(['sempro.user', 'sempro.mentor', 'sempro.secondMentor', 'periode'])
            ->where('is_submit', true)
            ->doesntHave('schedules')
            ->get();
        $skripsi = Skripsi::with([
            'semhas.sempro.user',
            'semhas.sempro.mentor',
            'semhas.sempro.secondMentor',
            'periode'
        ])->where('is_submit', true)
            ->doesntHave('schedules')
            ->get();


        return view('livewire.admin.submission.index', [
            'sempro' => $sempro,
            'semhas' => $semhas,
            'skripsi' => $skripsi,
        ])->layout('layouts.app', [
            'subTitle' => 'List Pengajuan',
        ])->title('Admin - List Pengajuan');
    }
}
