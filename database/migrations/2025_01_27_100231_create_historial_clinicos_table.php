<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('historial_clinicos', function (Blueprint $table) {
            $table->id();
            $table->text('diagnostico_principal');
            $table->text('alergias')->nullable();
            $table->text('antecedentes_familiares')->nullable();
            $table->text('antecedentes_personales')->nullable();
            $table->text('tratamientos_cronicos')->nullable();
            $table->string('estado')->default('Activo');

            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade'); // Relación con paciente

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_clinicos');
    }
};
