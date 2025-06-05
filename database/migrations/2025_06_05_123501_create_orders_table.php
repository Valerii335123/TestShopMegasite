<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->enum('delivery_method', ['pickup', 'post']);
            $table->enum('payment_method', ['postpaid', 'online']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}; 