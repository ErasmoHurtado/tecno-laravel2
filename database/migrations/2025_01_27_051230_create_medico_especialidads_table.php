<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medico_especialidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medico');
            $table->unsignedBigInteger('id_especialidad');
            $table->string('titulo_especialidad');
            $table->string('origen_especialidad');
            $table->year('ano_especialidad');
            $table->timestamps();

          // Foreign keys
            $table->foreign('id_medico')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('id_especialidad')->references('id')->on('especialidads')->onDelete('cascade');
            
            // Unique constraint to avoid duplicates
            $table->unique(['id_medico', 'id_especialidad']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('medico_especialidads');
    }
};
