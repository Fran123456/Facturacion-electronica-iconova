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
            $table->unsignedBigInteger("id_tipo_cliente");
            $table->string('tipo_documento', 10)->nullable();
            $table->string('nit', 50)->unique()->nullable();
            $table->string('nrc', 50)->unique()->nullable();
            $table->string('dui', 50)->unique()->nullable();
            $table->string('nombre', 255)->nullable();
            $table->string('codigo_activad', 50)->nullable();
            $table->text('descripcion_activad')->nullable();
            $table->string('nombre_comercial', 255)->nullable();
            $table->string('departamento', 255)->nullable();
            $table->string('municipio', 255)->nullable();
            $table->string('complemento', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('correo', 255)->nullable();
            $table->boolean('estado')->default(true)->nullable();
            $table->timestamps();
            $table->foreign("id_tipo_cliente")->references("id")->on("tipo_cliente")->onDelete("cascade")->onUpdate("cascade");
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
