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
        Schema::create('mh_tributo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('valor');
            $table->double('porcentaje', 10, 2)->nullable()->default(0);
            $table->string('tipo');
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
        Schema::dropIfExists('mh_tributo');
    }
};
