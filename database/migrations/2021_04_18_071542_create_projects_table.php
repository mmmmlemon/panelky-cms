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
            $table->string('project_subtitle')->default('Project Subtitle')->nullable();
            $table->text('project_desc')->nullable();
            $table->string('project_bottomText')->default('Bottom Text')->nullable();
            $table->string('project_icon', 500)->nullable();
            $table->string('project_image', 500)->nullable();
            $table->string('project_url')->nullable();
            $table->integer('order')->default(0);
            $table->string('slug')->unique();
            $table->boolean('is_home')->default(false);
            $table->timestamps();
        });

       $data =  [
           [
                'project_title' => 'Проект №1',
                'project_subtitle' => 'Краткое описание',
                'project_desc' => 'Подробное описание',
                'project_bottomText' => 'Нижний текст',
                'project_url' => '/',
                'order' => 0,
                'slug' => 'proekt1',
                'is_home' => true,
            ], 
            [
                'project_title' => 'Проект №2',
                'project_subtitle' => 'Краткое описание',
                'project_desc' => 'Подробное описание',
                'project_bottomText' => 'Нижний текст',
                'project_url' => '/',
                'order' => -1,
                'slug' => 'proekt2',
                'is_home' => true,  
            ],
            [
                'project_title' => 'Проект №3',
                'project_subtitle' => 'Краткое описание',
                'project_desc' => 'Подробное описание',
                'project_bottomText' => 'Нижний текст',
                'project_url' => '/',
                'order' => -2,
                'slug' => 'proekt3',
                'is_home' => false,  
            ],
            [
                'project_title' => 'Проект №4',
                'project_subtitle' => 'Краткое описание',
                'project_desc' => 'Подробное описание',
                'project_bottomText' => 'Нижний текст',
                'project_url' => '/',
                'order' => -3,
                'slug' => 'proekt4',
                'is_home' => false,  
            ],
            [
                'project_title' => 'Проект №5',
                'project_subtitle' => 'Краткое описание',
                'project_desc' => 'Подробное описание',
                'project_bottomText' => 'Нижний текст',
                'project_url' => '/',
                'order' => -4,
                'slug' => 'proekt5',
                'is_home' => false,  
            ]
        ];

        DB::table('projects')->insert($data);
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
