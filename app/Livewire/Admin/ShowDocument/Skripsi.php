<?php

namespace App\Livewire\Admin\ShowDocument;

use App\Mail\ScheduleRejectionNotification;
use App\Models\Skripsi as ModelsSkripsi;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Skripsi extends Component
{
    public $id, $rejectionReason;
    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $datas = ModelsSkripsi::find($this->id);

        return view('livewire.admin.show-document.skripsi', compact('datas'))
            ->layout('layouts.app', [
                'subTitle' => 'Skripsi',
            ])->title('Skripsi');
    }

    public function reject()
    {
        $skripsi = ModelsSkripsi::with(['semhas.sempro.user', 'periode'])->find($this->id);
        $quota = $skripsi->periode->quota;

        $skripsi->periode->update([
            'quota' => $quota + 1,
        ]);

        $skripsi->update([
            'is_submit' => false
        ]);

        $data = [
            'user_name' => $skripsi->semhas->sempro->user->name,
            'exam_type' => 'Sidang Skripsi',
            'rejection_reason' => $this->rejectionReason,
        ];

        Mail::to($skripsi->semhas->sempro->user->email)->send(new ScheduleRejectionNotification($data, 'Penolakan Jadwal Ujian'));

        $this->dispatch('closeModal');
        session()->flash('success', 'Pengajuan berhasil ditolak dan email telah dikirim.');
        return $this->redirect(route('admin.index'));
    }
}
