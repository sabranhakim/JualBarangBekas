<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_hakim_order_items_table.php
    public function up()
    {
        Schema::create('hakim_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('hakim_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('hakim_products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2); // harga satuan saat pemesanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hakim_order_items');
    }
};
