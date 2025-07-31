<?php

namespace App\Help;

use App\Help\Help;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\ServicesController;

class FirmadorElectronico
{
    public static function firmador($token)
    {

        $usuario = Auth::user();
        if ($usuario->empresa_id == null)
            return response()->json(["error" => "El usuario no posee empresa"], Response::HTTP_NOT_FOUND);

        $empresa  =  Empresa::find($usuario->empresa_id);
        if ($empresa == null)
            return response()->json(["error" => "La empresa no existe"], Response::HTTP_NOT_FOUND);

        if ($empresa->estado == false)
            return response()->json(["error" => "La empresa existe pero se encuentra desactivada"], Response::HTTP_NOT_FOUND);

        $nit = Crypt::decryptString($empresa->nit);
        $passwordPrivate = Crypt::decryptString($empresa->private_key);
        $jsonDTE = $token;

        if ($jsonDTE == null)
            return response()->json(["error" => "Enviar un DTE valido por favor."], Response::HTTP_NOT_FOUND);

              //if($nit == "06142806161048"){
                //  $passwordPrivate  = $passwordPrivate. "#";
                // }
        $jsonDocumento = [
            "nit" => $nit,
            "activo" => true,
            "passwordPri" => $passwordPrivate,
            "dteJson" => $jsonDTE
        ];
       
        
        
        $url = Help::urlFirmador() . "firmardocumento/";
        $response = Http::post($url, $jsonDocumento);
        
        $responseData = $response->json();

   
        $statusCode = $response->status();
        $value = $responseData['body'];

        if (isset($value['mensaje'])) {
            return ["msg" => "No se pudo firmar el DTE solicitado", "error" => $value['mensaje'], "status" => Response::HTTP_BAD_REQUEST];
        }

        return ["msg" => $value, "error" => "", "status" => $statusCode];
    }

    public static function firmadorNew($request)
    {
        $request['firmanteAutomatico']=true;
        $contro = new ServicesController();
        $dteFirmado = $contro->obtenerFirmaDTE($request);
        return $dteFirmado;
    }
}
