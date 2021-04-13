<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->string('site_owner_name');
            $table->string('site_owner_occupation');
            $table->text('site_owner_about');
            $table->string('site_owner_bottom');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'site_title' => 'Site Title',
            'site_owner_name' => 'Site Owner Name',
            'site_owner_occupation' => 'Site Owner Occupation',
            'site_owner_about' => 'About Site Owner',
            'site_owner_bottom' => 'Bottom Text',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
