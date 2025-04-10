<?php

namespace App\Livewire\Admin\JadwalMengajarDosen;

use App\Models\TeachingSchedule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\TeachingScheduleFullImport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithFileUploads;

    public $fileExcel;

    public function importExcel()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new TeachingScheduleFullImport, $this->fileExcel->getRealPath());

            $this->dispatch('flashMessage', [
                'type' => 'success',
                'message' => 'Data berhasil diimport',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage(),
            ]);
        }

        $this->reset('fileExcel');
        $this->dispatch('closeModal');
    }


    public function render()
    {
        $datas = TeachingSchedule::with('lecturer')
            ->orderBy('day', 'desc')
            ->get();

        return view('livewire.admin.jadwal-mengajar-dosen.index', [
            'datas' => $datas,
        ])->layout('layouts.app', [
            'subTitle' => 'Jadwal Mengajar Dosen',
        ])->title('Jadwal Mengajar Dosen');
    }
}
