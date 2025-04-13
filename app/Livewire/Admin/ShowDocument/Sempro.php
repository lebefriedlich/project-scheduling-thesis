<?php

namespace App\Livewire\Admin\ShowDocument;

use App\Models\Sempro as ModelsSempro;
use Livewire\Component;

class Sempro extends Component
{
    public $id;
    public function mount($id){
        $this->id = $id;
    }
    public function render()
    {
        $datas = ModelsSempro::find($this->id);
        dd($datas);

        return view('livewire.admin.show-document.sempro', compact('datas'))
            ->layout('layouts.app', [
                'subTitle' => 'Sempro',
            ])->title('Sempro');
    }
}
