<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $datas = Location::all();
        
        return view('livewire.admin.location.index', [
            'datas' => $datas,
        ])->layout('layouts.app', [
            'subTitle' => 'List Lokasi'
        ])->title('Admin - List Lokasi');
    }

    public function deleteLocation($id){
        $location = Location::find($id);

        if ($location) {
            $location->delete();
            $this->dispatch('flashMessage', [
                'message' => 'Lokasi berhasil dihapus.',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('flashMessage', [
                'message' => 'Lokasi tidak ditemukan.',
                'type' => 'danger'
            ]);
        }
    }
}
