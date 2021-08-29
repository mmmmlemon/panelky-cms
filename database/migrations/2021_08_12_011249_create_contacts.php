<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_type')->default('email');
            $table->string('contact_tooltip')->nullable();
            $table->string('contact_url', 300);
            $table->string('contact_insertion');
            $table->integer('order')->default(0);
            $table->timestamps();
        });


        $data = [
            [
                'contact_type' => 'email',
                'contact_tooltip' => 'E-Mail',
                'contact_url' => 'myemail@email.com',
                'contact_insertion' => 'myemail@email.com',
                'order' => 0,
            ],
            [
                'contact_type' => 'facebook',
                'contact_tooltip' => 'Facebook',
                'contact_url' => 'https://facebook.com/',
                'contact_insertion' => '',
                'order' => 0,
            ]
        ];

        DB::table('contacts')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
