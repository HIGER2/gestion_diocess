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
        Schema::create('diplome_ecclesiastiques', function (Blueprint $table) {
            $table->id();
            $table->string('intitule_diplome');
            $table->date('date')->nullable();
            $table->bigInteger('pretes_id')->unsigned()->index();
            $table->foreign('pretes_id')->references('id')->on('pretres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diplome_ecclesiastiques');
    }
};
