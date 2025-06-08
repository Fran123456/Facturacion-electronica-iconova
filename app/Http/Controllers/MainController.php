<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 
use Livewire\Component;

class MainController extends Controller
{
    //class EjemploController extends Controller
    public function index() 
    {
        // Devolvemos la vista
        /*
        return view('Main', [
            'titulo_nuevo' => 'Título desde controlador', 
            'html_controlador' => '<p>Este es el HTML</p>'
        ]);
        */

        return view('Main', [
            'titulo_nuevo' => '-- GENERADOR PDF --', 
            'html_controlador' => '<H1></H1>'
        ]);
    }



    


}

