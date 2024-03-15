<?php

namespace App\Http\Controllers;

use App\Models\APIEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ServicesController extends Controller
{
    private $urlFirmado;

    public function __construct()
    {
        $this->urlFirmado = env("FIRMADOR_URL_BASE");
    }

    public function obtenerFirmaDTE(Request $request)
    {

        $empresa = APIEmpresa::where("id_usuario", '1')->where("estado", true)->first();


        if (!$empresa)
            return response()->json([
                "msg" => "Empresa no encontrada para el usuario logueado"
            ], 400);

        $nit = Crypt::decryptString($empresa->nit);
        $passwordPrivate = Crypt::decryptString($empresa->private_key);
        $jsonDTE = json_decode($request->getContent(), true);

        $jsonDocumento = [
            "nit" => $nit,
            "activo" => true,
            "passwordPri" => $passwordPrivate,
            "dteJson" => $jsonDTE["dteJson"]
        ];

        // $body = json_encode($jsonDocumento);

        $url = $this->urlFirmado . "firmardocumento/";

        $response = Http::post($url, $jsonDocumento);


        $responseData = $response->json(); // Obtener los datos de la respuesta en formato JSON
        $statusCode = $response->status(); // Obtener el código de estado de la respuesta


        return response()->json($responseData, $statusCode);
    }

    public function loginMH(Request $request)
    {

        $empresa = APIEmpresa::where("id_usuario", '1')->where("estado", true)->first();

        if (!$empresa)
            return response()->json([
                "msg" => "Empresa no encontrada para el usuario logueado"
            ], 400);

        if (env("APP_DEBUG") == true)
            $url = env("URL_MH_DTES_TEST");
        else
            $url = env("URL_MH_DTES");

        $nit = Crypt::decryptString($empresa->nit);
        $pwd = Crypt::decryptString($empresa->credenciales_api);

        $jsonRequest = [
            "user" => $nit,
            "pwd" => $pwd,
        ];

        $requestResponse = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'ApiLaravel/1.0',
        ])->asForm()->post($url . "seguridad/auth", $jsonRequest);

        $responseData = $requestResponse->json();
        $statusCode = $requestResponse->status();


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

    // ENDPOINTS DE PRUEBA
    public function desencriptador(Request $request)
    {
        // $texto = $request->input("valor");
        $texto = $request->query("valor");

        if (!$texto)
            return response()->json([
                "msm" => "El valor es requerido en la petición",
            ], 400);

        $encrypted = Crypt::decryptString($texto);

        return response()->json([
            "texto" => $encrypted,
        ], 200);
    }
}
