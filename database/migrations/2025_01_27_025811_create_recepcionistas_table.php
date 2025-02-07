<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recepcionistas', function (Blueprint $table) {
            $table->id();
            $table->string('turno_trabajo');    
            $table->string('fecha_contratacion');                
            $table->foreignId('person_id')->constrained('personas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepcionistas');
    }
};
