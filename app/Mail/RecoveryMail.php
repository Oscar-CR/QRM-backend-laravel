<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryMail extends Mailable
{
    use Queueable, SerializesModels;
    public $rfc,$password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rfc,$password)
    {
        $this->rfc = $rfc;
        $this->password = $password;
    }

   
    public function build()
    {
        return $this->view('mail.recovery',['rfc'=>$this->rfc, 'password'=>$this->password]);
    } 
}
