<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('pmt_id')->nullable();
            $table->integer('product_id');
            $table->integer('user_id');
            $table->integer('quantity');
            $table->string('attributes');
            $table->integer('final_price');
            $table->string('delivery_address')->nullable();
            $table->boolean('is_in_cart')->default(true);
            $table->enum('status',['pending','hold','delivered'])->nullable();
            $table->string('order_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
