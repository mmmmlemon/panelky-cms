<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediaTypeToProjectSldies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_slides', function (Blueprint $table) {
            $table->enum('media_type', ['image', 'video'])->default('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_slides', function (Blueprint $table) {
            $table->dropColumn('media_type');
        });
    }
}
