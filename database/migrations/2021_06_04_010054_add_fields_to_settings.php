<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('side_nav')->default(1);
            $table->boolean('about')->default(1);
            $table->boolean('site_owner')->default(1);
            $table->boolean('projects')->default(1);
            $table->boolean('footer')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('side_nav');
            $table->dropColumn('about');
            $table->dropColumn('site_owner');
            $table->dropColumn('projects');
            $table->dropColumn('footer');
        });
    }
}
