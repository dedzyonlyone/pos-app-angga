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
Schema::create('sale_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
    $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
    $table->string('product_name', 150);   // snapshot
    $table->decimal('price', 15, 2);        // snapshot harga jual
    $table->decimal('purchase_price', 15, 2); // snapshot modal
    $table->unsignedInteger('quantity');
    $table->decimal('subtotal', 15, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
