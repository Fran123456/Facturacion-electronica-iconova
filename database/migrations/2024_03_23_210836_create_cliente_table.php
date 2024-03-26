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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->text('nit');
            $table->text('nrc');
            $table->text('nombre');
            $table->text('codigo_activad');
            $table->text('descripcion_activad');
            $table->text('nombre_comercial');
            $table->text('departamento');
            $table->text('municipio');
            $table->text('complemento');
            $table->text('telefono');
            $table->text('correo')->nullable();
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('cliente');
    }
};
