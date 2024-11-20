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
        Schema::create('misa_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('misa_detail_id')->unsigned();
            $table->foreign('misa_detail_id')
                ->references('id')
                ->on('misa_details');
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misa_permissions');
    }
};
