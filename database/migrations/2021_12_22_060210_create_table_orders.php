<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrders extends Migration
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
            $table->timestamps();
            $table->string('order_type');
            $table->string('order_name');
            $table->string('order_bootstrap_icon')->nullable();
            $table->longText('order_desc');
            $table->string('price_range')->nullable();
            $table->string('time_range')->nullable();
            $table->boolean('visibility')->default(1);
            $table->string('color_style')->nullable();
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
