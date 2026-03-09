<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Kounde Avocats');
            $table->text('site_description')->nullable();
            $table->string('site_email')->default('contact@kounde-avocats.com');
            $table->string('site_phone')->default('+33 6 66 69 00 80');
            $table->text('site_address')->default('123 Rue de la Loi, 31000 Toulouse');
            $table->string('working_hours')->default('Lun - Sam: 9h - 18h');
            $table->string('contact_email')->default('contact@kounde-avocats.com');
            $table->string('contact_phone')->default('+33 6 66 69 00 80');
            $table->text('contact_address')->default('123 Rue de la Loi, 31000 Toulouse');
            $table->string('contact_map_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_copyright')->default('© 2025 Kounde Avocats - Tous droits réservés');
            $table->boolean('newsletter_enabled')->default(true);
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};