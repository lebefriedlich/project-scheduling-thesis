<?php

namespace App\Livewire\Admin\Lecturer;

use App\Models\Lecturer;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $datas = Lecturer::all();
        
        return view('livewire.admin.lecturer.index', [
            'datas' => $datas,
        ])->layout('layouts.app', [
            'subTitle' => 'List Data Dosen',
        ])->title('Admin - List Data Dosen');
    }

    public function deleteLecturer($id){
        $lecturer = Lecturer::find($id);
        if ($lecturer) {
            $lecturer->delete();
            $this->dispatch('flashMessage', [
                'type' => 'success',
                'message' => 'Data Dosen berhasil dihapus',
            ]);
        } else {
            $this->dispatch('flashMessage', [
                'type' => 'error',
                'message' => 'Data Dosen tidak ditemukan',
            ]);
        }
    }
}
