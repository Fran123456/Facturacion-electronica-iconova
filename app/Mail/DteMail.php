<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreCliente;
    public $correoEmpresa;
    public $telefonoEmpresa;
    public $dte;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreCliente, $correoEmpresa, $telefonoEmpresa, $dte)
    {
        $this->nombreCliente = $nombreCliente;
        $this->correoEmpresa = $correoEmpresa;
        $this->telefonoEmpresa = $telefonoEmpresa;
        $this->dte = $dte;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Facturación Electrónica',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.mail',
        );
    }


    public function build()
    {
        return $this->view('mail.mail')
                    ->with([
                        'nombreliente' =>  $this->nombreCliente,
                        'correoEmpresa' =>  $this->correoEmpresa,
                        'telefonoEmpresa' =>  $this->telefonoEmpresa,
                        'dte'=> $this->dte
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
