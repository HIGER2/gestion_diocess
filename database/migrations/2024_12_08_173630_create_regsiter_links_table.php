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
        Schema::create('regsiter_links', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->bigInteger('dioceses_id')->unsigned()->index()->nullable();
            $table->string('link');
            $table->string('status')->default('active');
            $table->string('token', 64)->unique();
            $table->foreign('dioceses_id')->references('id')->on('dioceses')->onDelete('cascade');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regsiter_links');
    }
};
