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
        Schema::create('meets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->nullable()->unsigned();
            $table->foreign('event_id')
                ->references('id')
                ->on('events');
            $table->string('title');
            $table->dateTime('date');
            $table->string('place');
            $table->boolean('status')->default(1);
            $table->boolean('permission')->default(0);
            $table->string('notulen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meets');
    }
};
