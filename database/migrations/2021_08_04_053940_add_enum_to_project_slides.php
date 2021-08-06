<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnumToProjectSlides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_slides', function (Blueprint $table) {
            $table->enum('visibility', ['horizontal', 'vertical', 'all'])->default('all');
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
            $table->dropColumn('visibility');
        });
    }
}
