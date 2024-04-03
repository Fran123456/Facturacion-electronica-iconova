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
            $table->string('tipo_documento', 10);
            $table->string('nit', 50)->unique();
            $table->string('nrc', 50)->unique();
            $table->string('dui', 50)->unique();
            $table->string('nombre', 255);
            $table->string('codigo_activad', 50);
            $table->text('descripcion_activad');
            $table->string('nombre_comercial', 255);
            $table->string('departamento', 255);
            $table->string('municipio', 255);
            $table->string('complemento', 255)->nullable();
            $table->string('telefono', 50);
            $table->string('correo', 255)->nullable();
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
