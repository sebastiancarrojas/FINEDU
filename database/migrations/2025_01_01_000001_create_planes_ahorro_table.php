<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes_ahorro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('meta_nombre');
            $table->decimal('valor_meta', 15, 2);
            $table->decimal('ahorro_actual', 15, 2)->default(0);
            $table->integer('plazo_meses');
            $table->decimal('ahorro_mensual', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_ahorro');
    }
};