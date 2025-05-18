<?php

use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
return view('welcome');
   return view('main');
});


/* llamado vista desde el controlador */
Route::get('/Menu', [MainController::class, 'index']);

Route::get('/pdfdte', [App\Http\Controllers\pdfDTEController::class, 'document']);

//Route::get('/pdfdte2', [App\Http\Controllers\pdfDTE2Controller::class, 'document']);

Route::get('/pdf/{CodigoGeneracion}', [App\Http\Controllers\PdfDTEController::class, 'document']);


Route::prefix('/utilidad')->group(function () {

   Route::get('/pdf', [InfoController::class, 'pdf']);
   
});
