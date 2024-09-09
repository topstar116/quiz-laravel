<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $content;
    public $user;
    public $email;

    public function __construct($content, $user, $email)
    {
        $this->content = $content;
        $this->user = $user;
        $this->email = $email;
    }

  
 public function build()
{
    return $this->subject('新着メール')
        ->view('emails.user_email')
        ->with([
            'content' => $this->content,
            'user' => $this->user,
            'eamil' => $this->email
        ]);
}

}
