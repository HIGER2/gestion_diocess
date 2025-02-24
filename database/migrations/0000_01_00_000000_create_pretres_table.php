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
        Schema::create('pretres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('matricule')->index();

            $table->bigInteger('dioceses_id')->unsigned()->index()->nullable();
            $table->foreign("dioceses_id")
                ->references('id')
                ->on('dioceses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('status')->default('active');
            $table->date('date_ordination_sacerdotale');
            $table->string('lieu_ordination_sacerdotale');
            $table->string('numero_telephone')->nullable();
            $table->string('adresse_electronique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
