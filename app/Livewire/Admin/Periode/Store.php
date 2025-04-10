<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Component;

class Store extends Component
{
    public $name, $description, $type, $end_registration, $start_schedule, $end_schedule, $quota;
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:sempro,semhas,skripsi',
        'end_registration' => 'required|date',
        'start_schedule' => 'required|date',
        'end_schedule' => 'required|date|after_or_equal:start_schedule',
        'quota' => 'required|integer|min:1',
    ];

    protected $messages = [
        'name.required' => 'Kolom Nama wajib diisi.',
        'name.string' => 'Kolom Nama harus berupa teks.',
        'name.max' => 'Kolom Nama tidak boleh lebih dari 255 karakter.',
        'description.required' => 'Kolom Deskripsi wajib diisi.',
        'description.string' => 'Kolom Deskripsi harus berupa teks.',
        'type.required' => 'Kolom Tipe wajib diisi.',
        'type.in' => 'Kolom Tipe harus berupa sempro, semhas, atau skripsi.',
        'end_registration.required' => 'Kolom Akhir Pendaftaran wajib diisi.',
        'end_registration.date' => 'Kolom Akhir Pendaftaran harus berupa tanggal.',
        'start_schedule.required' => 'Kolom Awal Pelakasanaan wajib diisi.',
        'start_schedule.date' => 'Kolom Awal Pelakasanaan harus berupa tanggal.',
        'end_schedule.required' => 'Kolom Akhir Pelaksanaan wajib diisi.',
        'end_schedule.date' => 'Kolom Akhir Pelaksanaan harus berupa tanggal.',
        'end_schedule.after_or_equal' => 'Kolom Akhir Pelaksanaan harus setelah atau sama dengan Awal Pelaksanaan.',
        'quota.required' => 'Kolom Kuota wajib diisi.',
        'quota.integer' => 'Kolom Kuota harus berupa angka.',
        'quota.min' => 'Kolom Kuota harus lebih dari 0.',
    ];
    public function render()
    {
        return view('livewire.admin.periode.store')
            ->layout('layouts.app', [
                'subTitle' => 'Input Periode',
            ])
            ->title('Admin - Input Periode');
    }

    public function submit()
    {
        $this->validate();

        try {
            Periode::create([
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'end_registration' => $this->end_registration,
                'start_schedule' => $this->start_schedule,
                'end_schedule' => $this->end_schedule,
                'quota' => $this->quota,
            ]);

            session()->flash('success', 'Periode berhasil ditambahkan');
            $this->reset();

            return $this->redirect(route('admin.periode.index'));
        } catch (\Exception $e) {
            $this->dispatch('flashMessage', [
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage(),
                'type' => 'danger',
            ]);
            return;
        }
    }
}
