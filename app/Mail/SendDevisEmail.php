<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDevisEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $user, $parametre, $facture, $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $user, $parametre, $facture, $pdf)
    {
        $this->client = $client;
        $this->user = $user;
        $this->parametre = $parametre;
        $this->facture = $facture;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.devis-email')->with(['client' => $this->client, 'user'=>$this->user, 
        'parametre'=>$this->parametre, 'facture'=>$this->facture])
        ->attachFromStorage($this->pdf->path, $this->pdf->name, ['mime' => 'application/pdf']);
    }
}
