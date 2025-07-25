<?php

namespace App\Help\Services;

use App\Help\DteCodeValidator;
use App\Help\DTEHelper\Anexo;
use App\Help\FirmadorElectronico;
use App\Help\Generator;
use App\Help\Help;
use App\Mail\DteMail;
use App\Models\InvalidacionDte;
use App\Models\LogDTE;
use App\Models\RegistroDTE;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendMailFe
{
    public static function sending($id, $empresa , $mailInfo, $identificacion, $receptor){

        $correoEmpresa = Crypt::decryptString($empresa->correo_electronico);
        $telefono = Crypt::decryptString($empresa->telefono);
        $nombreEmpresa = Crypt::decryptString($empresa->nombre);
        $dteActual = RegistroDTE::find($id);
        $nombreCliente = $receptor['nombre'];
        
        if($dteActual->sello != null){
            try{
              Mail::to("apopsasv2021@gmail.com")
            ->send((new DteMail($nombreCliente, $correoEmpresa, $telefono, $mailInfo))
            ->from($correoEmpresa, $nombreEmpresa));
            }catch(Exception $e){
                Anexo::emailError( $identificacion['codigoGeneracion'], $identificacion['numeroControl'], (string) $e);

            }
        }
    }

}