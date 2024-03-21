<?php

namespace App\Http\Controllers;

use App\help\Generator as HelpGenerator;
use Generator;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function numControl(){
        $generated = HelpGenerator::generateNumControl('03');

        // if( $generated = null )
        // return response()->json([
        //     'generado' => 'null'
        // ]);

        return response()->json([
            'generado' => $generated
        ]);
    }

    public function codeGeneration(){

        return HelpGenerator::generateCodeGeneration();
    }
}
