<?php

namespace App\Livewire\Admin\Lecturer;

use App\Models\Lecturer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $fileExcel;
    public $search = '';

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        if ($this->search) {
            $datas = Lecturer::query()
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nip', 'like', '%' . $this->search . '%');
                })
                ->orderBy('name')
                ->paginate(10);
        } else {
            $datas = Lecturer::orderBy('name')->paginate(10);
        }
        
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
