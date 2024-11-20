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
        Schema::create('misas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->dateTime('activity_datetime');
            $table->dateTime('upload_datetime')->nullable();
            $table->dateTime('deadline_datetime')->nullable();
            $table->string('evaluation');
            $table->string('status');
            $table->bigInteger('active')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misas');
    }
};
