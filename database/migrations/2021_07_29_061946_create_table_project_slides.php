<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjectSlides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_slides', function (Blueprint $table) {
            $table->id();
            $table->string('media_url', 500);
            $table->string('commentary', 500)->nullable();
            $table->integer('project_id');
            $table->enum('visibility', ['horizontal', 'vertical'])->default('horizontal');
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('project_slides');
    }
}
