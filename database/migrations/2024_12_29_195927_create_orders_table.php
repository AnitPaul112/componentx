<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments("id"); // Auto-increment primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for user
            $table->string('order_id')->unique(); // Unique order ID
            $table->unsignedBigInteger('product_id'); // Foreign key for product
            $table->string('name'); // Customer name
            $table->text('address'); // Delivery address
            $table->string('payment_method'); // Payment method
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
