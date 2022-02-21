<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pickup','delivery','registered']);
            $table->integer('role_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('house')->nullable();
            $table->string('area')->nullable();
            $table->string('pincode')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->string('landmark')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
