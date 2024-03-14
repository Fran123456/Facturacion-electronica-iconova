<?php

namespace App\Http\Controllers;

use App\Models\APIEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class servicesController extends Controller
{
    private $urlFirmado;

    public function __construct()
    {
        $this->urlFirmado = env("FIRMADOR_URL_BASE");
    }

    public function obtenerFirmaDTE(Request $request)
    {

        // $empresa = APIEmpresa::where("id_usuario", $request->id_user)->where("estado", true)->first();
        $empresa = APIEmpresa::where("id_usuario", '1')->where("estado", true)->first();

        if ( !$empresa )
            return response()->json([
                "msg" => "Something went wrong"
            ], 500);

        $jsonDTE = json_decode($request->getContent(), true);

        $jsonDocumento = [
            "nit" => env("NIT_FIRMADO"),
            "activo" => true,
            "passwordPri" => $empresa->private_key,
            "dteJson" => $jsonDTE["dteJson"]
        ];

        // $body = json_encode($jsonDocumento);

        $url = $this->urlFirmado . "firmardocumento/";

        $response = Http::post($url, $jsonDocumento);


        $responseData = $response->json(); // Obtener los datos de la respuesta en formato JSON
        $statusCode = $response->status(); // Obtener el código de estado de la respuesta


        return response()->json($responseData, $statusCode);
    }
}
