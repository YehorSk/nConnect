<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $message;

    /**
     * @return void
     */
    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = "Name: " . $this->name . "\n";
        $content .= "Email: " . $this->email . "\n\n";
        $content .= "Message:\n" . $this->message;

        return $this->subject('New Email from ' . $this->name)
            ->from($this->email, $this->name)
            ->text('emails.send_email_vue')
            ->with([
                'content' => $content,
            ]);
    }
}
