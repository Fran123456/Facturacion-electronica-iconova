<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\ConsultasMHController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DteCCFController;
use App\Http\Controllers\DteCdController;
use App\Http\Controllers\DteClController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DteNotasController;
use App\Http\Controllers\DteCrController;
use App\Http\Controllers\DteDclController;
use App\Http\Controllers\DteFcController;
use App\Http\Controllers\DteFexController;
use App\Http\Controllers\DteFseController;
use App\Http\Controllers\DteNdController;
use App\Http\Controllers\DteNrController;
use App\Http\Controllers\InvalidarDteController;
use App\Http\Controllers\PruebasController;
use App\Http\Controllers\ReceptorController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContingenciaController;
use App\Http\Controllers\InfoController;



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

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('/utilidad')->group(function () {
        Route::get('/empresa', [InfoController::class, 'empresa']);
        Route::get('/forma-pago', [InfoController::class, 'formaPagoCatalogo']);
        Route::get('/actividad-economica-by-code', [InfoController::class, 'actividadEconomicaByCode']);

        
    });

});







Route::middleware('auth:sanctum')->group(function () {
    //! Endpoint de prueba
    Route::get('/prueba/empresa', [PruebasController::class, 'empresa']);
    Route::get('/prueba/usuario', [PruebasController::class, 'usuario']);
    
    //^ ENDPOINTS CONSULTAS DE DTE
    Route::prefix('/consultas/dte')->group(function () {
        Route::get('/listar', [ConsultasController::class, 'index']);
        Route::get('/listar/{id}', [ConsultasController::class, 'show']);
        Route::post('/reenviar', [ConsultasController::class, 'update']);
    });
    
    //^ ENDPOINTS DE SERVICIOS DE HACIENDA Y DE LA APLICACIÓN
    Route::prefix('services')->group(function () {
        Route::post('/mh/consulta', [ConsultasMHController::class, 'consultaDte']);
        Route::get('/mh/login', [ServicesController::class, 'loginMH']);
        Route::post('/firmado', [ServicesController::class, 'obtenerFirmaDTE']);
        Route::get('/encriptador', [ServicesController::class, 'encriptador']);
        Route::get('/desencriptador', [ServicesController::class, 'desencriptador']);
        // ^ Invalidación de dte
        Route::post('/mh/invalidar', [InvalidarDteController::class, 'invalidar']);
        
        //* ENDPOINTS COMPLETADOS
        Route::post('/mh/enviar/dte/unitario/ccf', [DteCCFController::class, 'enviarDteUnitarioCCF']);
        Route::post('/mh/enviar/dte/unitario/nc', [DteNotasController::class, 'enviarNotaCreditoUnitaria']);
        Route::post('/mh/enviar/dte/unitario/fex', [DteFexController::class, 'unitario']);
        Route::post('/mh/enviar/dte/unitario/fc', [DteFcController::class, 'unitario']);
        
        // ^ Testeando
        Route::post('/mh/enviar/dte/unitario/cr', [DteCrController::class, 'unitario']);
        Route::post('/mh/enviar/dte/unitario/fse', [DteFseController::class, 'unitario']);
        Route::post('/mh/enviar/dte/unitario/nd', [DteNdController::class, 'unitario']);
        Route::post('/mh/enviar/dte/unitario/cl', [DteClController::class, 'unitario']);

       
        Route::post('/mh/enviar/contingencia', [ ContingenciaController::class, 'sendContingencia']);
        
        // TODO: por completar
        Route::post('/mh/enviar/dte/unitario/cd', [DteCdController::class, 'unitario']); //! No es requerido hacerlo
        Route::post('/mh/enviar/dte/unitario/dcl', [DteDclController::class, 'unitario']);
        Route::post('/mh/enviar/dte/unitario/nr', [DteNrController::class, 'unitario']);
    });
});

//! ENDPOINTS DE PRUEBA
Route::get('/encriptador', [ServicesController::class, 'encriptador']);
Route::post('/signUp', [ApiController::class, 'signUp']);
Route::get('/users', [ApiController::class, 'users']);
Route::get('/token', [ApiController::class, 'pruebaToken']);
