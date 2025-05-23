<?php

namespace App\Livewire\Admin\ShowDocument;

use App\Mail\ScheduleRejectionNotification;
use App\Models\Sempro as ModelsSempro;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Sempro extends Component
{
    public $id, $rejectionReason;
    public function mount($id){
        $this->id = $id;
    }
    public function render()
    {
        $datas = ModelsSempro::find($this->id);

        return view('livewire.admin.show-document.sempro', compact('datas'))
            ->layout('layouts.app', [
                'subTitle' => 'Sempro',
            ])->title('Sempro');
    }

    public function reject()
    {
        $sempro = ModelsSempro::with(['user', 'periode'])->find($this->id);
        $quota = $sempro->periode->quota;

        $sempro->periode->update([
            'quota' => $quota + 1,
        ]);

        $sempro->update([
            'is_submit' => false
        ]);

        $data = [
            'user_name' => $sempro->user->name,
            'exam_type' => 'Seminar Proposal',
            'rejection_reason' => $this->rejectionReason,
        ];
        
        Mail::to($sempro->user->email)->send(new ScheduleRejectionNotification($data, 'Penolakan Jadwal Ujian'));
        
        $this->dispatch('closeModal');
        session()->flash('success', 'Pengajuan berhasil ditolak dan email telah dikirim.');
        return $this->redirect(route('admin.index'));
    }
}
