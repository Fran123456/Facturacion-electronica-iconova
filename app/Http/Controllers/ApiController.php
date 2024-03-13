<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $data = json_decode($request->getContent());

        try {
            // Validate required parameters
            $this->validateLogin($request);

            // Find user and validate password
            $user = User::where('email', $data->email)->first();

            if ( !$user || !Hash::check($data->password, $user->password) ) {
                throw new AuthenticationException('Invalid login credentials');
            }

            // Generate a secure random token
            $token = $user->createToken('example');

            $response["status"] = 200;
            $response["msg"] = $token->plainTextToken;

        } catch (AuthenticationException $e) {

            $response["msg"] = "Invalid login credentials. Please try again.";
            report($e);

        } catch (Exception $e) {

            $response["msg"] = "An unexpected error occurred. Verified if the credencials are filled. Please try again later.";
            report($e);

        }

        return response()->json($response);
    }

    private function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }
}
