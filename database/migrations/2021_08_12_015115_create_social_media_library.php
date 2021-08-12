<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaLibrary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_library', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('tooltip')->nullable();
            $table->string('url_template')->nullable();
            $table->string('insert_type');
        });

        DB::table('social_media_library')->insert(
            array(
                [
                    'type' => 'email',
                    'tooltip' => 'E-Mail',
                    'url_template' => '{insert}',
                    'insert_type' => 'email'
                ],
                [
                    'type' => 'whatsapp',
                    'tooltip' => 'WhatsApp',
                    'url_template' => 'https://wa.me/{insert}',
                    'insert_type' => 'phone_number'
                ],
                [
                    'type' => 'telegram',
                    'tooltip' => 'Telegram',
                    'url_template' => 'https://t.me/{insert}',
                    'insert_type' => 'username'
                ],
                [
                    'type' => 'viber',
                    'tooltip' => 'Viber',
                    'url_template' => 'viber://chat?number=%2B{insert}',
                    'insert_type' => 'phone_number'
                ],
                [
                    'type' => 'facebook',
                    'tooltip' => 'Facebook',
                    'url_template' => 'https://www.facebook.com/{insert}',
                    'insert_type' => 'username'
                ],
                [
                    'type' => 'vk',
                    'tooltip' => 'VK',
                    'url_template' => 'https://www.vk.com/{insert}',
                    'insert_type' => 'username'
                ],
                [
                    'type' => 'instagram',
                    'tooltip' => 'Instagram',
                    'url_template' => 'https://www.instagram.com/{insert}',
                    'insert_type' => 'username'
                ],
                [
                    'type' => 'twitter',
                    'tooltip' => 'Twitter',
                    'url_template' => 'https://twitter.com/{insert}',
                    'insert_type' => 'username'
                ],
                [
                    'type' => 'skype',
                    'tooltip' => 'Skype',
                    'url_template' => 'skype:{insert}?chat',
                    'insert_type' => 'username'
                ],
                         
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media_library');
    }
}
