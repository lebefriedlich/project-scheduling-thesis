<?php

namespace App\Livewire\Admin\Lecturer;

use App\Models\Lecturer;
use Livewire\Component;

class Edit extends Component
{
    public $id, $nip, $name;

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

    public function mount($id)
    {
        $lecturer = Lecturer::find($id);

        $this->id = $id;
        $this->nip = $lecturer->nip;
        $this->name = $lecturer->name;
    }

    public function render()
    {
        return view('livewire.admin.lecturer.edit')
            ->layout('layouts.app', [
                'subTitle' => 'Edit Data Dosen',
            ])->title('Admin - Edit Data Dosen');
    }

    public function submit()
    {
        $this->validate();

        try {
            Lecturer::where('id', $this->id)->update([
                'nip' => $this->nip,
                'name' => $this->name,
            ]);

            session()->flash('success', 'Data Dosen berhasil diperbarui!');
            $this->reset();

            return $this->redirectRoute('admin.lecturer.index');
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'message' => 'Gagal memperbarui data dosen: ' . $e->getMessage(),
                'type' => 'danger'
            ]);
            return;
        }
    }
}
