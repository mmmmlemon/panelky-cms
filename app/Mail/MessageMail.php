<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messageEmail, $pickedProject, $messageText)
    {
        $this->messageEmail = $messageEmail;
        $this->pickedProject = $pickedProject;
        $this->messageText = $messageText;
        $this->date = Carbon::today()->format("d.m.Y");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_email = "contact@mistermisteroo.ru";
        $subject = "Заказ: ".$this->pickedProject.", от: ".$this->messageEmail;
        return $this->from($from_email)->subject($subject)->view('emails.feedback')->with([
            'messageText' => $this->messageText,
            'pickedProject' => $this->pickedProject,
            'messageEmail' => $this->messageEmail,
            'date' => $this->date,
        ]);
    }
}
