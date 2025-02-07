<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('metodo'); // Método de pago (ejemplo: Tarjeta, Efectivo, Transferencia)
            $table->decimal('monto', 10, 2); // Monto pagado
            $table->string('estado')->default('Pendiente de pago');
            $table->foreignId('ficha_id')->constrained('fichas')->onDelete('cascade'); // Relación con ficha
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};
