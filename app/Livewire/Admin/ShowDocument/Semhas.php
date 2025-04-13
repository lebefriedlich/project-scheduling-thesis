<?php

namespace App\Livewire\Admin\ShowDocument;

use App\Mail\ScheduleRejectionNotification;
use App\Models\Semhas as ModelsSemhas;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Semhas extends Component
{
    public $id, $rejectionReason;
    public function mount($id){
        $this->id = $id;
    }

    public function render()
    {
        $datas = ModelsSemhas::find($this->id);

        return view('livewire.admin.show-document.semhas', compact('datas'))
            ->layout('layouts.app', [
                'subTitle' => 'Semhas',
            ])->title('Semhas');
    }

    public function reject()
    {
        $semhas = ModelsSemhas::with(['sempro.user', 'periode'])->find($this->id);
        $quota = $semhas->periode->quota;

        $semhas->periode->update([
            'quota' => $quota + 1,
        ]);

        $semhas->update([
            'is_submit' => false
        ]);

        $data = [
            'user_name' => $semhas->sempro->user->name,
            'exam_type' => 'Seminar Hasil',
            'rejection_reason' => $this->rejectionReason,
        ];
        
        Mail::to($semhas->sempro->user->email)->send(new ScheduleRejectionNotification($data, 'Penolakan Jadwal Ujian'));
        
        $this->dispatch('closeModal');
        session()->flash('success', 'Pengajuan berhasil ditolak dan email telah dikirim.');
        return $this->redirect(route('admin.index'));
    }
}
