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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('item_type_id');
            $table->enum('flow', ['in', 'out']);
            $table->enum('frequency', ['single', 'daily', 'weekly', 'monthly']);
            $table->timestamp('start_date');
            $table->unsignedSmallInteger('number_of_transactions');
            $table->mediumText('description');
            $table->tinyText('company_name');
            $table->float('amount', 2);
            $table->tinyText('reference')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_type_id')->references('id')->on('item_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
