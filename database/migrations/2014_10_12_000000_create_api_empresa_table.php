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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->text("nombre");
            $table->string("nombre_comercial", 300)->nullable();
    $table->string("nit", 200)->nullable();
            $table->text("credenciales_api");
            $table->text("password_mh");
            $table->text("public_key");
            $table->text("private_key");
            $table->text("correo_electronico");
            $table->text("telefono");
            $table->text("celular");

            // Campos agregados
            $table->string('departamento', 200)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->text('direccion')->nullable();
            $table->string('codigo_establecimiento', 20)->nullable();
            $table->text('token_mh')->nullable();
            $table->string('codigo_actividad', 200)->nullable();
            $table->string('ambiente', 10)->nullable();
            $table->string('correlativo_fex', 200)->nullable();
            $table->string('correlativo_ccf', 200)->nullable();
            $table->string("correlativo_fact", 200)->nullable();
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
        Schema::dropIfExists('empresa');
    }
};
