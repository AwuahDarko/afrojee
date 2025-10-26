<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class WelcomeNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $unsubscribeUrl;

    public function __construct($email)
    {
        $this->email = $email;
        $this->unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['email' => $this->email]);
    }
    public function build()
    {
        $unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['email' => $this->email]);

        return $this->subject('Welcome to Afrojee Store Newsletter!')
            ->view('emails.welcome-newsletter')
            ->with([
                'unsubscribeUrl' => $unsubscribeUrl,
            ]);
    }
}