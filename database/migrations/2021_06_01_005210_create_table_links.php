<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('link_title',50);
            $table->string('link_url');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        $data = [
            [
                'slug' => 'github',
                'link_title' => 'GitHub',
                'link_url' => 'https://github.com',
                'order' => 0
            ],
            [
            'slug' => 'kofi',
            'link_title' => 'Ko-Fi',
            'link_url' => 'https://ko-fi.com',
            'order' => -1,
            ]
        ];

        DB::table('links')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
