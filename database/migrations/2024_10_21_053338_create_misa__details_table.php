<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('misa_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('misa_id')->unsigned();
            $table->foreign('misa_id')
                ->references('id')
                ->on('misas');
            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->string('roles');
            $table->boolean('participation')->nullable();
            $table->boolean('confirmation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misa__details');
    }
};
