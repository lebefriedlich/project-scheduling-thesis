<?php

namespace App\Livewire\Admin\Location;

use Livewire\Component;

class Store extends Component
{
    public $name, $description;

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

    public function render()
    {
        return view('livewire.admin.location.store')
            ->layout('layouts.app', [
                'subTitle' => 'Tambah Lokasi',
            ])->title('Admin - Tambah Lokasi');
    }

    public function submit()
    {
        $this->validate();

        try {
            \App\Models\Location::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Lokasi berhasil ditambahkan!');
            $this->reset();

            return $this->redirectRoute('admin.location.index');
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'message' => 'Gagal menambahkan lokasi: ' . $e->getMessage(),
                'type' => 'danger'
            ]);
            return;
        }
    }
}
