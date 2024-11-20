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
        Schema::create('template_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('template_id')->unsigned();
            $table->foreign('template_id')
                ->references('id')
                ->on('templates');
            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_permissions');
    }
};
