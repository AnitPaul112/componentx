<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewOrdersTable extends Migration
{
    public function up()
    {
        // Create the new_orders table
        if (!Schema::hasTable('new_orders')) {
            Schema::create('new_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('username');
                $table->text('address');
                $table->decimal('total_price', 10, 2);
                $table->string('payment_method');
                $table->json('products'); // Store all product data as JSON
                $table->timestamps();
            });
        }

        // Create the order_items table
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('new_orders')->onDelete('cascade');
                $table->unsignedBigInteger('product_id'); // Explicitly define unsignedBigInteger
                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('new_orders');
    }
}
