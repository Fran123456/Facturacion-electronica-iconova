<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Http\Controllers\PdfController;

class DteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreCliente;
    public $correoEmpresa;
    public $telefonoEmpresa;
     public $mailinfo;
    public $dte;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreCliente, $correoEmpresa, $telefonoEmpresa, $mailinfo)
    {
        $this->nombreCliente = $nombreCliente;
        $this->correoEmpresa = $correoEmpresa;
        $this->telefonoEmpresa = $telefonoEmpresa;
        $this->mailinfo = $mailinfo;
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


        $jsonContent = json_encode($this->mailinfo['dte'], JSON_PRETTY_PRINT);
        $tempPath = tempnam(sys_get_temp_dir(), 'dte_') . '.json';
        file_put_contents($tempPath, $jsonContent); // Guarda el JSON en el archivo temporal

        
        $pdfController = new PdfController();
        $pdf = $pdfController->generarPdf(
                $this->mailinfo['codigoGeneracion']
        );

        return $this->view('mail.mail')
                    ->with([
                        'nombreliente' =>  $this->nombreCliente,
                        'correoEmpresa' =>  $this->correoEmpresa,
                        'telefonoEmpresa' =>  $this->telefonoEmpresa,
                        'mailinfo'=> $this->mailinfo
                    ])
                    ->attach($tempPath, [
                        'as' => $this->mailinfo['dte']['identificacion']['numeroControl'].'.json',
                        'mime' => 'application/json',
                    ])
                    ->attachData($pdf->output(), $this->mailinfo['dte']['identificacion']['numeroControl'] . '.pdf', [
                            'mime' => 'application/pdf',
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
