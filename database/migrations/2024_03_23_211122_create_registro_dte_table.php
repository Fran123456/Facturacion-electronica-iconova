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
        Schema::create('registro_dte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('invalidacion_id')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->string('codigo_generacion');
            $table->string('numero_dte');
            $table->string('tipo_documento');
            $table->json('dte');
            $table->string('sello')->nullable();
            $table->string('fecha_recibido');
            $table->json('observaciones')->nullable();
            $table->boolean('estado');
            $table->foreign('id_cliente')->references('id')->on('cliente')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invalidacion_id')->references('id')->on('invalidacion_dte')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('registro_dte');
    }
};
