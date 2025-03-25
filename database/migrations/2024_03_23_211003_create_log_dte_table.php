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
        Schema::create('log_dte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_cliente');
            $table->string('numero_dte')->nullable();
            $table->string('codigo_generacion');
            
            $table->string('tipo_documento');
            $table->date('fecha');
            $table->timestamp('hora');
            $table->text('error');
            $table->boolean('estado');
            $table->timestamps();
            $table->foreign('id_empresa')->references('id')->on('empresa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id')->on('cliente')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_dte');
    }
};
