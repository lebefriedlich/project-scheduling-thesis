<?php

namespace App\Livewire\Admin\Lecturer;

use Livewire\Component;

class Store extends Component
{
    public $nip, $name;

    protected $rules = [
        'nip' => 'nullable|unique:lecturers,nip',
        'name' => 'required|string|max:255',
    ];

    protected $messages = [
        'nip.unique' => 'NIP sudah terdaftar',
        'name.required' => 'Nama tidak boleh kosong',
        'name.string' => 'Nama harus berupa string',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
    ];
    public function render()
    {
        return view('livewire.admin.lecturer.store')
        ->layout('layouts.app', [
            'subTitle' => 'Tambah Data Dosen',
        ])
        ->title('Admin - Tambah Data Dosen');
    }

    public function submit(){
        $this->validate();

        try {
            \App\Models\Lecturer::create([
                'nip' => $this->nip,
                'name' => $this->name,
            ]);

            session()->flash('success', 'Data Dosen berhasil ditambahkan!');
            $this->reset();

            return $this->redirectRoute('admin.lecturer.index');
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'message' => 'Gagal menambahkan lokasi: ' . $e->getMessage(),
                'type' => 'danger'
            ]);
            return;
        }
    }
}
