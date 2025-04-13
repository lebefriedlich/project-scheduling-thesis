<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;

class Edit extends Component
{
    public $id, $name, $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'name.required' => 'Nama lokasi harus diisi.',
        'name.string' => 'Nama lokasi harus berupa string.',
        'name.max' => 'Nama lokasi tidak boleh lebih dari :max karakter.',
        'description.string' => 'Deskripsi harus berupa string.',
        'description.max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
    ];

    public function mount($id)
    {
        $location = \App\Models\Location::find($id);

        $this->id = $id;
        $this->name = $location->name;
        $this->description = $location->description;
    }

    public function render()
    {
        return view('livewire.admin.location.edit')
            ->layout('layouts.app', [
                'subTitle' => 'Edit Lokasi',
            ])->title('Admin - Edit Lokasi');
    }

    public function submit()
    {
        $this->validate();

        try {
            Location::where('id', $this->id)->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Lokasi berhasil diperbarui!');
            $this->reset();

            return $this->redirectRoute('admin.location.index');
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'message' => 'Gagal memperbarui lokasi: ' . $e->getMessage(),
                'type' => 'danger'
            ]);
            return;
        }
    }
}
