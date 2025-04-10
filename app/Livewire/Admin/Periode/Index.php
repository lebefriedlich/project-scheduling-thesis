<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $datas = Periode::all();

        return view('livewire.admin.periode.index', [
            'datas' => $datas,
        ])->layout('layouts.app', [
            'subTitle' => 'List Periode',
        ])->title('Admin - List Periode');
    }

    public function deletePeriode($id)
    {
        $periode = Periode::find($id);
        if ($periode) {
            $periode->delete();
            $this->dispatch('flashMessage', [
                'message' => 'Artikel berhasil dihapus!',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('flashMessage', [
                'message' => 'Artikel tidak ditemukan!',
                'type' => 'danger'
            ]);
            return;
        }
    }
}
