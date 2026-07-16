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
        Schema::ensureVectorExtensionExists();

        Schema::create('cashflow_embeddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_transaction_id');
            $table->text('content'); 
            $table->integer('chunk_index');
            $table->vector('embedding', 1536); 
            $table->timestamps();

            $table->foreign('item_transaction_id')->references('id')->on('item_transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflow_embeddings');
    }
};
