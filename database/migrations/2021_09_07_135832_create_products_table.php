<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->integer('grand_category_id');
            $table->integer('parent_category_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('mrp');
            $table->string('offer_price');
            $table->string('image');
            $table->text('description')->nullable();
            $table->boolean('status')->dfault(true);
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
        Schema::dropIfExists('products');
    }
}
