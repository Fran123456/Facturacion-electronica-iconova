<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Config;
use App\Help\Help;

class ServicesController extends Controller
{
    private $urlFirmado;

    public function __construct()
    {
        $this->urlFirmado = Help::urlFirmador();

        $this->middleware('auth:sanctum');
    }

    public function fallback()
    {
        return response()->json([
            'message' => 'No estás autenticado.'
        ], 401);
    }

    public function obtenerFirmaDTE(Request $request)
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
        $jsonDTE = json_decode($request->getContent(), true);

        if ($jsonDTE == null)
            return response()->json(["error" => "Enviar un DTE valido por favor."], Response::HTTP_NOT_FOUND);

 
        $jsonDocumento = [
            "nit" => $nit,
            "activo" => true,
            "passwordPri" => $passwordPrivate,
            "dteJson" => $jsonDTE["dteJson"]??$jsonDTE
        ];

        // $body = json_encode($jsonDocumento);
        $url = $this->urlFirmado . "firmardocumento/";
        $response = Http::post($url, $jsonDocumento);
        $responseData = $response->json(); // Obtener los datos de la respuesta en formato JSON
        $statusCode = $response->status(); // Obtener el código de estado de la respuesta


      
        if(isset($request['firmanteAutomatico']))
        {
            return array("msg"=>$responseData['body'] , "status"=>$statusCode );
        }

        return response()->json($responseData, $statusCode);
    }

    public function loginMH(Request $request)
    {

        $usuario = Auth::user();
        $empresa  =  Empresa::find($usuario->empresa_id);

        if ($usuario->empresa_id == null)
            return response()->json(["error" => "El usuario no posee empresa"], Response::HTTP_NOT_FOUND);

        $empresa  =  Empresa::find($usuario->empresa_id);
        if ($empresa == null)
            return response()->json(["error" => "La empresa no existe"], Response::HTTP_NOT_FOUND);

        if ($empresa->estado == false)
            return response()->json(["error" => "La empresa existe pero se encuentra desactivada"], Response::HTTP_NOT_FOUND);

        $url = Help::mhUrl();
        $nit = Crypt::decryptString($empresa->nit);
        $pwd = Crypt::decryptString($empresa->credenciales_api);

      
     

        

        $jsonRequest = [
            "user" => $nit,
            "pwd" => $pwd ,
        ];

        $requestResponse = Http::timeout(160)
            ->connectTimeout(10)->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'ApiLaravel/1.0',
            "Accept" => "application/json"

        ])->asForm()->post($url . "seguridad/auth", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();
     
        $empresa->token_mh = $responseData['body']['token'];
        $empresa->save();
        return response()->json($responseData, $statusCode);
    }

    public function encriptador(Request $request)
    {
        $texto = $request->query("valor");

        if (!$texto)
            return response()->json([
                "msm" => "El valor es requerido en la petición",
            ], 400);

        $encrypted = Crypt::encryptString($texto);

        return response()->json([
            "texto" => $encrypted,
        ], 200);
    }

    //! ENDPOINTS DE PRUEBA
    public function desencriptador(Request $request)
    {
        $texto = $request->query("valor");

        $nit = Crypt::decryptString($empresa->nit);
        

        if (!$texto)
            return response()->json([
                "msm" => "El valor es requerido en la petición",
            ], 400);

        $encrypted = Crypt::decryptString(urldecode($texto));
        if($nit == "06142806161048"){
            $encrypted = $encrypted."#";
        }

        return response()->json([
            "texto" => $encrypted,
        ], 200);
    }
}
