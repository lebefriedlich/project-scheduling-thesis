<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleRejectionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subjectEmail;

    public function __construct($data, $subjectEmail)
    {
        $this->data = $data;
        $this->subjectEmail = $subjectEmail;
    }

    public function build()
    {
        return $this->subject($this->subjectEmail)
                    ->view('emails.schedule-rejected')
                    ->with([
                        'data' => $this->data,
                    ]);
    }
}
