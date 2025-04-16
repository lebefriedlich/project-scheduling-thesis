<?php

namespace App\Livewire\Admin\JadwalMengajarDosen;

use App\Models\TeachingSchedule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\TeachingScheduleFullImport;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $fileExcel;
    public $search = '';

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function importExcel()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new TeachingScheduleFullImport, $this->fileExcel->getRealPath());

            session()->flash('message', 'Data berhasil diimport');
            return redirect()->route('admin.jadwal-mengajar-dosen.index');
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage(),
            ]);
        }
    }


    public function render()
    {
        if ($this->search) {
            $datas = TeachingSchedule::query()
                ->where(function ($query) {
                    $query->where('day', 'like', '%' . $this->search . '%')
                        ->orWhere('start_time', 'like', '%' . $this->search . '%')
                        ->orWhere('end_time', 'like', '%' . $this->search . '%')
                        ->orWhere('course_name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('lecturer', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('room', 'like', '%' . $this->search . '%')
                        ->orWhere('class', 'like', '%' . $this->search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(50);

            $is_search = true;
        } else {
            $datas = TeachingSchedule::with('lecturer')
                ->orderBy('day', 'desc')
                ->paginate(50);

            $is_search = false;
        }

        return view('livewire.admin.jadwal-mengajar-dosen.index', [
            'datas' => $datas,
            'is_search' => $is_search,
        ])->layout('layouts.app', [
            'subTitle' => 'Jadwal Mengajar Dosen',
        ])->title('Jadwal Mengajar Dosen');
    }
}
