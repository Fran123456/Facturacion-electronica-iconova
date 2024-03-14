<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function users(Request $request)
    {

        $users = User::query();

        $users =
            $users->when($request->has('active'), function ($query) use ($request) {
                $query->where('active', $request->active);
            })->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->active . '%');
            });

        $users = $users->get();


        return response()->json($users);
    }

    public function login(Request $request)
    {
        $response = ["status" => 403, "msg" => ""];

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {

            // Find user and validate password
            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new AuthenticationException('Invalid login credentials');
            }

            // Generar el token sin la cadena de texto
            $token = $user->createToken('access_token');

            $additionalClaims = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            $CredentialToken = Crypt::encryptString(json_encode($additionalClaims));

            $response["status"] = 200;
            $response["msg"] = "Login successful";
            $response["access_token"] = $token->plainTextToken;
            $response["token_type"] = 'Bearer';
            $response["credentials_token"] = $CredentialToken;

        } catch (AuthenticationException $e) {

            $response["msg"] = "Invalid login credentials. Please try again.";
            report($e);

        } catch (Exception $e) {

            $response["msg"] = "An unexpected error occurred. Please try again later.";
            report($e);

        }

        return response()->json($response, $response["status"]);
    }

// ENDPOINTS DE PRUEBA
    public function signUp(Request $request)
    {

        $data = json_decode($request->getContent());

        $encryptedPassword = Hash::make($data->password);

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $encryptedPassword,
            'created_at' => now(),
            'create_at' => now(),

        ]);

        $user->save();

        return response()->json([
            "status" => 200,
            "msg" => "En teoria, correcto"
        ]);
    }

    public function pruebaToken(Request $request)
    {
        // Obtener el token de la solicitud
        $token = $request->bearerToken();

        // Validar el contenido del token
        if (
            $token == null
        ) {
            $response = "El token no contiene la información deseada.";
        } else {
            $response = "El token contiene la información deseada.";
        }


        $tokenPayload = json_decode(Crypt::decryptString($token), true);

        // Acceder a las reclamaciones personalizadas
        if (!$tokenPayload['id'] || $tokenPayload['name'] || $tokenPayload['email']) {
            $response = "El token de credenciales no contiene la información deseada.";
            return response()->json($response, 200);
        }


        return response()->json($response, 200);
    }
}
