<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->enum('type', ['credit', 'debit']); // credit for top-up, debit for spending
            $table->decimal('amount', 15, 2); // to store saldo changes
            $table->enum('status', ['pending', 'success', 'failed']);
            $table->string('order_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}