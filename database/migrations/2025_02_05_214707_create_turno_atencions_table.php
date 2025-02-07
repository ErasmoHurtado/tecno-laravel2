<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('turno_atencions', function (Blueprint $table) {
            $table->id();
            $table->string('horario');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->json('dias_servicio');
            $table->integer('cantidad_fichas');
            $table->decimal('precio', 8, 2);
            
            $table->foreignId('medico_especialidad_id')->constrained('medico_especialidads')->onDelete('cascade');
            $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turno_atencions');
    }
};
