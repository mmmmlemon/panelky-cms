<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullablesInProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_subtitle')->nullable()->change();
            $table->string('project_bottomText')->nullable()->change();
            $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_subtitle')->nullable(false)->change();
            $table->string('project_bottomText')->nullable(false)->change();
            $table->string('slug')->nullable()->change();
        });
    }
}
