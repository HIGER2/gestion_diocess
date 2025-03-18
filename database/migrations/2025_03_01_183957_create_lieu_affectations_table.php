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
        Schema::create('lieu_affectations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->date('date_fin')->nullable();
            $table->string('fonction')->nullable();
            $table->string('adresse')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('pretre_id')->constrained('pretres')->onDelete('cascade');
            $table->foreignId('dioceses_id')->nullable()->constrained('dioceses')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lieu_affectations');
    }
};
