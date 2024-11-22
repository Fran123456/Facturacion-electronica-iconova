<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invalidacion_dte', function (Blueprint $table) {
            $table->id();
            $table->text('respuesta');
            $table->string('sello', 255)->nullable(); 
            $table->string('codigo_generacion', 255)->nullable(); 
            $table->json('dte');
            $table->text('dte_firmado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invalidacion_dtes');
    }
};
