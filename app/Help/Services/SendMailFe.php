<?php

namespace App\Help\Services;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\Anexo;
use App\Help\FirmadorElectronico;
use App\Help\Generator;
use App\help\Help;
use App\Mail\DteMail;
use App\Models\InvalidacionDte;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendMailFe
{
    public static function sending($id,$nombreCliente, $correoEmpresa,$telefono, $nombreEmpresa, $mailInfo, $identificacion){
        $dteActual = RegistroDTE::find($id);
        
        if($dteActual->sello != null){
            try{
              Mail::to("francisco.navas.iconova@gmail.com")
            ->send((new DteMail($nombreCliente, $correoEmpresa, $telefono, $mailInfo))
            ->from($correoEmpresa, $nombreEmpresa));
            }catch(Exception $e){
                Anexo::emailError( $identificacion['codigoGeneracion'], $identificacion['numeroControl'], (string) $e);

            }
        }
    }

}