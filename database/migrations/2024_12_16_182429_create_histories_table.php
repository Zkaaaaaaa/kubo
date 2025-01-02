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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name')->nullable();
            $table->foreignId('product_id');
            $table->string('note')->nullable();
            $table->integer('total')->default(0);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['cart', 'process', 'done']);
            $table->integer('table')->default(0);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
