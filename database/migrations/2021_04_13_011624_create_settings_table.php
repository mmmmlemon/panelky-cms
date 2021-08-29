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
            $table->boolean('public_access')->default(1);
            $table->string('public_access_message', 500)->default(null)->nullable();
            $table->boolean('side_nav')->default(1);
            $table->boolean('about')->default(1);
            $table->boolean('site_owner')->default(1);
            $table->boolean('projects')->default(1);
            $table->boolean('footer')->default(1);
            $table->string('bg_first_color')->default('#3b3280');
            $table->string('bg_second_color')->default('#b92b35');
            $table->longtext('about_site_text')->nullable();
            $table->boolean('cookies')->default(0);
            $table->string('cookies_message', 800)->default('<p>Предупреждение о Cookies</p>');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'site_title' => 'Panelky: моя персональная страница',
            'site_owner_name' => 'Иван Иванов',
            'site_owner_occupation' => 'Программист',
            'site_owner_about' => 'Frontend, backend, fullstack',
            'site_owner_bottom' => 'Здесь представлены мои проекты',
            'public_access_message' => 'Ведутся технические работы. Зайдите попозже.',
            'about_site_text' => '<h2>О сайте</h2>'
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
