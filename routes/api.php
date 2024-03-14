<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ServicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('services')->group(function () {
        Route::post('/firmado', [ServicesController::class, 'obtenerFirmaDTE']);
    });
});

Route::post('/login', [ApiController::class, 'login']);


// ENDPOINTS DE PRUEBA
Route::post('/signUp', [ApiController::class, 'signUp']);
Route::get('/users', [ApiController::class, 'users']);
Route::get('/token', [ApiController::class, 'pruebaToken']);

