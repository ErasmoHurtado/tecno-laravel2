<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->text('sintomas');
            $table->text('diagnostico');
            $table->string('estado')->default('En espera');

            $table->foreignId('ficha_id')->constrained('fichas')->onDelete('cascade');
            $table->foreignId('historial_clinico_id')->constrained('historial_clinicos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
};
