<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_title')->default('Project Title');
            $table->string('project_subtitle')->default('Project Subtitle');
            $table->text('project_desc')->nullable();
            $table->string('project_bottomText')->default('Bottom Text');
            $table->string('project_icon', 500)->nullable();
            $table->string('project_image', 500)->nullable();
            $table->string('project_url')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
