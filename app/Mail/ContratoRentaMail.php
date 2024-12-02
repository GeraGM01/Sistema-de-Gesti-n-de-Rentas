<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContratoRentaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $pdf)
    {
        $this->data = $data;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.contrato')
            ->subject('Detalles del Contrato de Renta')
            ->attachData($this->pdf->output(), 'contrato.pdf', [
                'mime' => 'application/pdf',
            ])
            ->with('data', $this->data);
    }
}
